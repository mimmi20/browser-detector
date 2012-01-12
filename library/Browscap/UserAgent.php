<?php
declare(ENCODING = 'utf-8');
namespace Browscap;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * PHP version 5
 *
 * LICENSE: This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301 USA
 *
 * @category  CreditCalc
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright 2006-2008 Jonathan Stoppani
 * @version   SVN: $Id$
 */

/**
 * the agent database model
 */
use \Browscap\Model;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  CreditCalc
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright 2007-2010 Unister GmbH
 */
class UserAgent
{
    /**
     * the user agent sent from the browser
     *
     * @var string
     */
    private $_agent = '';
    
    /**
     * the detected browser
     *
     * @var StdClass
     */
    private $_browser = null;

    /**
     * a \Zend\Cache object
     *
     * @var \Zend\Cache
     */
    private $_cache = null;
    
    /*
     * @var \Zend\Log\Logger
     */
    private $_logger = null;
    
    /**
     * @var \Zend\Config\Config
     */
    private $_config = null;
    
    /**
     * @var \Browscap\Broscap
     */
    private $_browscap = null;
    
    /**
     * @var \Browscap\Service\Agents
     */
    private $_serviceAgents = null;
    
    /**
     * @var \Browscap\Service\Engines
     */
    private $_serviceEngines = null;
    
    /**
     * @var \Browscap\Service\Browsers
     */
    private $_serviceBrowsers = null;
    
    /**
     * @var \Browscap\Service\BrowserData
     */
    private $_serviceBrowserData = null;
    
    /**
     * @var \Browscap\Service\Os
     */
    private $_serviceOs = null;
    
    /**
     * @var \Browscap\Service\BrowscapData
     */
    private $_serviceBrowscapData = null;

    /**
     * Constructor class, checks for the existence of (and loads) the cache and
     * if needed updated the definitions
     *
     * @param string                          $agent
     * @param array|\Zend\Config\Config       $config
     * @param \Zend\Log\Logger                $logger
     * @param array|\Zend\Cache\Frontend\Core $cache
     *
     * @throws Exceptions\AgentNotStringException
     */
    public function __construct($agent = null, $config = null, $logger = null, $cache = null)
    {
        if ($config instanceof \Zend\Config\Config) {
            $config = $config->toArray();
        }
        
        if (null !== $config && !is_array($config)) {
            throw new Exceptions\WrongConfigObjectException(
                'the config must be an array or an instance of \\Zend\\Config\\Config'
            );
        }
        
        $this->_config = $config;
        
        $this->_cache = null;
        if ($cache instanceof \Zend\Cache\Frontend\Core) {
            $this->_cache = $cache;
        } elseif (!empty($this->_config['cache']) && is_array($config['cache'])) {
            $cacheConfig = $this->_config['cache'];
            
            $this->_cache = \Zend\Cache\Cache::factory(
                $cacheConfig['frontend'],
                $cacheConfig['backend'],
                $cacheConfig['front'],
                $cacheConfig['back']
            );
        }
        
        if (null === $this->_cache && null !== $cache) {
            throw new Exceptions\WrongCacheObjectException(
                'the cache must be an instance of \\Zend\\Cache\\Frontend\\Core'
            );
        }
        
        if ($logger instanceof \Zend\Log\Logger) {
            $this->_logger = $logger;
        } elseif (null !== $logger) {
            throw new Exceptions\WrongCacheObjectException(
                'the logger must be an instance of \\Zend\\Log\\Logger'
            );
        }
        
        $this->getBrowser($agent, false, true);
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $userAgent     the user agent string
     * @param boolean $bReturnAsArray whether return an array or an object
     *
     * @return stdClas|array the object containing the browsers details.
     *                       Array if $bReturnAsArray is set to true.
     */
    public function getBrowser($userAgent = null, $bReturnAsArray = false, $forceDetected = false)
    {
        // Automatically detect the useragent
        if (empty($userAgent) || !is_string($userAgent)) {
            $support   = new Support();
            $userAgent = $support->getUserAgent();
            
            unset($support);
        }
        
        $userAgent    = trim(str_replace(array('User-Agent:'), '', $userAgent));
        $this->_agent = $userAgent;
        
        $cacheId = 'agent_' . preg_replace(
            '/[^a-zA-Z0-9]/', '_', urlencode($userAgent)
        );
        
        if ($forceDetected 
            || !($this->_cache instanceof \Zend\Cache\Cache)
            || !($browserArray = $this->_cache->load($cacheId))
        ) {
            $browserArray = $this->_detect($userAgent, $bReturnAsArray, $forceDetected);
            
            if (!$forceDetected 
                && $this->_cache instanceof \Zend\Cache\Cache
            ) {
                $this->_cache->save($browserArray, $cacheId);
            }
        } else {
            if (null === $this->_serviceAgents) {
                $this->_serviceAgents = new Service\Agents();
            }
            
            $agent = $this->_serviceAgents->searchByAgent($userAgent);
            $this->_serviceAgents->count($agent->idAgents);
        }
        
        unset($cacheId);
        
        return $browserArray;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $userAgent     the user agent string
     * @param boolean $bReturnAsArray whether return an array or an object
     *
     * @return stdClas|array the object containing the browsers details.
     *                       Array if $bReturnAsArray is set to true.
     */
    private function _detect($userAgent = null, $bReturnAsArray = false, $forceDetected = false)
    {
        if (null === $this->_serviceAgents) {
            $this->_serviceAgents = new Service\Agents();
        }
        
        $agent = $this->_serviceAgents->searchByAgent($userAgent);
        
        if (!is_object($agent)) {
            $agent        = $this->_serviceAgents->createRow();
            $agent->agent = $userAgent;
            $agent->save();
        }
        
        $this->_serviceAgents->count($agent->idAgents);
        
        if (null === $this->_serviceEngines) {
            $this->_serviceEngines = new Service\Engines();
        }
        
        if ($forceDetected 
            || !$agent->idEngines 
            || null === ($engine = $this->_serviceEngines->find($agent->idEngines)->current())
        ) {
            // detect the Rendering Engine
            $chainEngines = new Engine\Chain();
            
            $engine         = $chainEngines->detect($userAgent);
            //var_dump($engine);//exit;
            $searchedEngine = $this->_serviceEngines->searchByName($engine->engine, $engine->version);
            
            if ($searchedEngine) {
                $agent->idEngines = $searchedEngine->idEngines;
            }
            
            unset($chainEngines);
        } else {
            $engine = (object) $engine->toArray();
        }
        
        $this->_serviceEngines->count($agent->idEngines);
        
        if (null === $this->_serviceBrowsers) {
            $this->_serviceBrowsers = new Service\Browsers();
        }
        
        if ($forceDetected 
            || !$agent->idBrowsers 
            || null === ($browser = $this->_serviceBrowsers->find($agent->idBrowsers)->current())
        ) {
            // detect the browser
            $chainBrowsers = new Browser\Chain();
            
            $browser           = $chainBrowsers->detect($userAgent);
            $agent->idBrowsers = $browser->idBrowsers;
            
            unset($chainBrowsers);
        } else {
            $browser = (object) $browser->toArray();
        }
        
        $this->_serviceBrowsers->count($agent->idBrowsers);
        
        if (null === $this->_serviceOs) {
            $this->_serviceOs = new Service\Os();
        }
        
        if ($forceDetected 
            || !$agent->idOs 
            || null === ($os = $this->_serviceOs->find($agent->idOs)->current())
        ) {
            // detect the Operating System
            $chainOs = new Os\Chain();
            
            $os       = $chainOs->detect($userAgent);//var_dump($os);exit;
            $osResult = $this->_serviceOs->searchByName($os->name, $os->version, $os->bits);
            
            if ($osResult) {
                $agent->idOs = $osResult->idOs;
            }
            
            unset($chainOs);
        } else {
            $os = (object) $os->toArray();
        }
        
        $this->_serviceOs->count($agent->idOs);
        /*
        if (null === $this->_serviceBrowserData) {
            $this->_serviceBrowserData = new Service\BrowserData();
        }
        
        if ($forceDetected 
            || !$agent->idBrowserData
        ) {
            $agent->idBrowserData = $this->_serviceBrowserData->countByName($browser->browser, $browser->version, $browser->bits, (array) $browser);
        } else {
            $this->_serviceBrowserData->count($agent->idBrowserData);
        }
        
        // detect the device
        $deviceChain = new Device\Chain();
        $device      = $deviceChain->detect($userAgent);
        
        $modelWurflData = new Model\WurflData();
        //if (null === $agent->idWurflData) {
            $wurfl = $modelWurflData->count(null, $userAgent);exit;
        //    $agent->idWurflData = $wurfl->idWurflData;
        //} else {
        //    $modelWurflData->count($agent->idWurflData, $userAgent);
        //    
        //    $wurfl = $modelWurflData->find($agent->idWurflData)->current();
        //}
        
        if (null === $this->_serviceBrowscapData) {
            $this->_serviceBrowscapData = new Service\BrowscapData();
        }
        
        if ($forceDetected 
            || !$agent->idBrowscapData 
            || null === ($object = $this->_serviceBrowscapData->find($agent->idBrowscapData)->current())
        ) {
            if (null === $this->_browscap) {
                // define the User Agent object and set the default values
                $this->_browscap = new Browscap($this->_config, $this->_logger, $this->_cache);
            }
            
            $detected = $this->_browscap->getBrowser($userAgent);
            
            $object = new \StdClass();
            
            // take over the detected values to User Agent object
            $object->Browser = $browser->browser;
            $version         = $browser->version;
            
            $object->Version  = $browser->version;
            $object->MajorVer = (int) $version;
            
            $versions         = explode('.', $version, 2);
            $object->MinorVer = (isset($versions[1]) ? $versions[1] : '0');
            
            if (64 == $browser->bits) {
                $object->Win64 = 1;
            } elseif (32 == $browser->bits) {
                $object->Win32 = 1;
            } elseif (16 == $browser->bits) {
                $object->Win16 = 1;
            }
            ////echo "\t\t" . 'detecting Browscap-Data (detecting bits): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $object->Platform            = $os->osFull;
            $object->Alpha               = false;
            $object->Beta                = false;
            if (!isset($detected->Frames)) {
                var_dump($userAgent, $detected);exit;
            }
            $object->Frames              = $detected->Frames;
            $object->IFrames             = $detected->IFrames;
            $object->Tables              = $detected->Tables;
            $object->Cookies             = $detected->Cookies;
            $object->BackgroundSounds    = $detected->BackgroundSounds;
            $object->JavaScript          = $detected->JavaScript;
            $object->VBScript            = $detected->VBScript;
            $object->JavaApplets         = $detected->JavaApplets;
            $object->ActiveXControls     = $detected->ActiveXControls;
            $object->isBanned            = $detected->isBanned;
            $object->isMobileDevice      = $detected->isMobileDevice;
            $object->isSyndicationReader = $detected->isSyndicationReader;
            $object->Crawler             = $detected->Crawler;
            $object->CssVersion          = $detected->CssVersion;
            $object->AolVersion          = 0;
            $object->wurflKey            = $detected->wurflKey;
            $object->renderEngine        = $engine->engine;
            
            $dataToStore = (array) $object;
            unset($dataToStore['AolVersion']);
            ////echo "\t\t" . 'detecting Browscap-Data (set object): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            
            $data = $this->_serviceBrowscapData->searchByBrowser($object->Browser, $object->Platform, $object->Version, $browser->bits, $object->wurflKey);
            if (!is_object($data)) {
                var_dump($data, $object->Browser, $object->Platform, $object->Version, $browser->bits, $object->wurflKey);exit;
            }
            
            ////echo "\t\t" . 'detecting Browscap-Data (search browser): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            
            $this->_serviceBrowscapData->update($dataToStore, 'idBrowscapData = ' . $data->idBrowscapData);
            $agent->idBrowscapData = $data->idBrowscapData;
            
            ////echo "\t\t" . 'detecting Browscap-Data (finish): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        } else {
            ////echo "\t\t" . 'detecting Browscap-Data (init): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $objectCopy = clone $object;
            
            ////echo "\t\t" . 'detecting Browscap-Data (clone): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $object = new \StdClass();
            
            // take over the detected values to User Agent object
            $object->Browser             = $objectCopy->browser;
            $object->Version             = $objectCopy->version;
            $object->MajorVer            = $objectCopy->majorver;
            $object->MinorVer            = $objectCopy->minorver;
            $object->Win64               = $objectCopy->win64;
            $object->Win32               = $objectCopy->win32;
            $object->Win16               = $objectCopy->win16;
            $object->Platform            = $objectCopy->platform;
            $object->Alpha               = false;
            $object->Beta                = false;
            $object->Frames              = $objectCopy->frames;
            $object->IFrames             = $objectCopy->iframes;
            $object->Tables              = $objectCopy->tables;
            $object->Cookies             = $objectCopy->cookies;
            $object->BackgroundSounds    = $objectCopy->backgroundsounds;
            $object->JavaScript          = $objectCopy->javascript;
            $object->VBScript            = $objectCopy->vbscript;
            $object->JavaApplets         = $objectCopy->javaapplets;
            $object->ActiveXControls     = $objectCopy->activexcontrols;
            $object->isBanned            = $objectCopy->isbanned;
            $object->isMobileDevice      = $objectCopy->ismobiledevice;
            $object->isSyndicationReader = $objectCopy->issyndicationreader;
            $object->Crawler             = $objectCopy->crawler;
            $object->CssVersion          = $objectCopy->cssversion;
            $object->AolVersion          = 0;
            $object->wurflKey            = $objectCopy->wurflkey;
            $object->renderEngine        = $objectCopy->renderengine;
        }
        /**/
        $this->_serviceAgents->update($agent->toArray(), 'idAgents = ' . (int) $agent->idAgents);
        
        $object = new \StdClass();
        $object->idAgents = $agent->idAgents;
        $object->engine   = $engine;
        $object->browser  = $browser;
        $object->os       = $os;
        //var_dump($object);
        return ($bReturnAsArray ? (array) $object : $object);
    }
    
    /**
     * returns the stored user agent
     *
     * @return string
     */
    public function getAgent()
    {
        return $this->_agent;
    }
    
    /**
     * returns the stored user agent
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getAgent();
    }
    
    public function toArray()
    {
        return $this->getBrowser(null, true, false);
    }
}