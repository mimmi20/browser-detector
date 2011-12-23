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
        if (null === $agent) {
            $support = new Support();
            $agent   = $support->getUserAgent();
        }
        if (!is_string($agent)) {
            throw new Exceptions\AgentNotStringException(
                'the user agent must be a string'
            );
        }
        
        $this->_agent = $agent;
        
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
        } elseif (!empty($config['cache']) && is_array($config['cache'])) {
            $cacheConfig = $config['cache'];
            
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
        
        $this->getBrowser();
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
        $start = microtime(true);
        
        // Automatically detect the useragent
        if (empty($userAgent) || !is_string($userAgent)) {
            echo 'detecting User Agent (using Support - Start): ' . (microtime(true) - $start) . ' Sek.' . "\n";
            
            $support    = new Support();
            $userAgent = $support->getUserAgent();
            
            echo 'detecting User Agent (using Support - End)  : ' . (microtime(true) - $start) . ' Sek.' . "\n";
        }
        
        echo 'detecting User Agent: ' . (microtime(true) - $start) . ' Sek.' . "\n";

        $cacheId = 'agent_' . preg_replace(
            '/[^a-zA-Z0-9]/', '_', urlencode($userAgent)
        );
        
        //if (!($array = $this->_cache->load($cacheId))) {
            echo 'detecting Browser (using _detect - Start): ' . (microtime(true) - $start) . ' Sek.' . "\n";
            $array = $this->_detect($userAgent, $bReturnAsArray, $forceDetected);
            
            echo 'detecting Browser (using _detect - End)  : ' . (microtime(true) - $start) . ' Sek.' . "\n";
            

        //    $this->_cache->save($array, $cacheId);
        //}
        
        echo 'detecting User Agent (Finish): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        
        return $this->_browser = $array;
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
        $start = microtime(true);
        
        $agentModel = new Model\Agents();
        $agent      = $agentModel->searchByAgent($userAgent);
        
        if (!is_object($agent)) {
            $agent        = $agentModel->createRow();
            $agent->agent = $userAgent;
            $agent->save();
        }
        
        echo "\t" . 'searching User Agent: ' . (microtime(true) - $start) . ' Sek.' . "\n";
        
        $agentModel->count($agent->idAgents);
        
        echo "\t" . 'counting User Agent: ' . (microtime(true) - $start) . ' Sek.' . "\n";
        echo "\t" . 'detecting rendering Engine (Start): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        
        $engineModel = new Model\Engines();
        if ($forceDetected 
            || null === $agent->idEngines 
            || null === ($engine = $engineModel->find($agent->idEngines)->current())
        ) {
            // detect the Rendering Engine
            $engineChain      = new Engine\Chain();
            $engine           = $engineChain->detect($userAgent);
            $agent->idEngines = $engineModel->countByName($engine->engine, $engine->version);
        } else {
            $engineModel->count($agent->idEngines);
            $engine = (object) $engine->toArray();
        }
        
        echo "\t" . 'detecting rendering Engine (End): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        echo "\t" . 'detecting Browser (Start): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        
        $browserModel = new Model\Browsers();
        if ($forceDetected 
            || null === $agent->idBrowsers 
            || null === ($browser = $browserModel->find($agent->idBrowsers)->current())
        ) {
            // detect the browser
            $browserChain = new Browser\Chain();
            $browser      = $browserChain->detect($userAgent);
            
            $agent->idBrowsers = $browser->idBrowsers;
        } else {
            $browserModel->count($agent->idBrowsers);
            $browser = (object) $browser->toArray();
        }
        
        echo "\t" . 'detecting Browser (End): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        echo "\t" . 'detecting Browser-Data (Start): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        
        $browserDataModel = new Model\BrowserData();
        if ($forceDetected 
            || null === $agent->idBrowserData
        ) {
            $agent->idBrowserData = $browserDataModel->countByName($browser->browser, $browser->version, $browser->bits, (array) $browser);
        } else {
            $browserDataModel->count($agent->idBrowserData);
        }
        
        echo "\t" . 'detecting Browser-Data (End): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        echo "\t" . 'detecting OS (Start): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        
        $osModel = new Model\Os();
        if ($forceDetected 
            || null === $agent->idOs 
            || null === ($os = $osModel->find($agent->idOs)->current())
        ) {
            // detect the Operating System
            $osChain     = new Os\Chain();
            $os          = $osChain->detect($userAgent);//var_dump($os);exit;
            $agent->idOs = $osModel->countByName($os->name, $os->version, $os->bits);
        } else {
            $osModel->count($agent->idOs);
            $os = (object) $os->toArray();
        }
        
        echo "\t" . 'detecting OS (End): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        /*
        echo "\t" . 'detecting Device (Start): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        
        // detect the device
        $deviceChain = new Device\Chain();
        $device      = $deviceChain->detect($userAgent);
        
        echo "\t" . 'detecting Device (End): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        /**/
        echo "\t" . 'detecting Browscap-Data (Start): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        
        /*
        $modelWurflData = new Model\WurflData();
        //if (null === $agent->idWurflData) {
            $wurfl = $modelWurflData->count(null, $userAgent);exit;
        //    $agent->idWurflData = $wurfl->idWurflData;
        //} else {
        //    $modelWurflData->count($agent->idWurflData, $userAgent);
        //    
        //    $wurfl = $modelWurflData->find($agent->idWurflData)->current();
        //}
        /**/
        $modelBrowscapData = new Model\BrowscapData();
        if ($forceDetected 
            || null === $agent->idBrowscapData 
            || null === ($object = $modelBrowscapData->find($agent->idBrowscapData)->current())
        ) {
            // define the User Agent object and set the default values
            $browscap = new Browscap($this->_config, $this->_logger, $this->_cache);
            $detected = $browscap->getBrowser($userAgent);
            
            $object = new \StdClass();
            
            // take over the detected values to User Agent object
            $object->Browser = $browser->browser;
            $version         = $browser->version;
            
            if (false === strpos($version, '.')) {
                $version = number_format($version, 2);
            }
            $object->Version  = $version;
            $object->MajorVer = (int) $version;
            
            $versions         = explode('.', $version, 2);
            $object->MinorVer = $versions[1];
            
            if (64 == $browser->bits) {
                $object->Win64 = 1;
            } elseif (32 == $browser->bits) {
                $object->Win32 = 1;
            } elseif (16 == $browser->bits) {
                $object->Win16 = 1;
            }
            //var_dump($os);exit;
            $object->Platform            = $os->osFull;
            $object->Alpha               = false;
            $object->Beta                = false;
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
            
            $data = $modelBrowscapData->searchByBrowser($object->Browser, $object->Platform, $object->Version, $browser->bits, $object->wurflKey);
            if (!is_object($data)) {
                var_dump($data, $object->Browser, $object->Platform, $object->Version, $browser->bits, $object->wurflKey);exit;
            }
            $modelBrowscapData->update($dataToStore, 'idBrowscapData = ' . $data->idBrowscapData);
            $agent->idBrowscapData = $data->idBrowscapData;
            
            //var_dump(1, $object);exit;
        } else {
            $objectCopy = clone $object;
            //var_dump(2, $object);exit;
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
            
            //var_dump(2, $object);exit;
        }
        
        echo "\t" . 'detecting Browscap-Data (End): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        
        $agent->save();
        $object->idAgents = $agent->idAgents;
        
        echo "\t" . 'detecting Browscap (Finish): ' . (microtime(true) - $start) . ' Sek.' . "\n";
        
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