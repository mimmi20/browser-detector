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
        //echo "\n";
        
        // Automatically detect the useragent
        if (empty($userAgent) || !is_string($userAgent)) {
            //echo 'detecting User Agent (using Support - Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            
            $support   = new Support();
            $userAgent = $support->getUserAgent();
            
            //echo 'detecting User Agent (using Support - End)  : ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            
            unset($support);
        }
        
        $userAgent = trim(str_replace(array('User-Agent:'), '', $userAgent));
        
        $this->_agent = $userAgent;
        
        //echo 'detecting User Agent: ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";

        $cacheId = 'agent_' . preg_replace(
            '/[^a-zA-Z0-9]/', '_', urlencode($userAgent)
        );
        
        if ($forceDetected 
            || !($this->_cache instanceof \Zend\Cache\Cache)
            || !($browserArray = $this->_cache->load($cacheId))
        ) {
            //echo 'detecting Browser (using _detect - Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $browserArray = $this->_detect($userAgent, $bReturnAsArray, $forceDetected);
            
            //echo 'detecting Browser (using _detect - End)  : ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            
            if (!$forceDetected 
                && $this->_cache instanceof \Zend\Cache\Cache
            ) {
                //echo 'detecting Browser (writing cache - Start)  : ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
                $this->_cache->save($browserArray, $cacheId);
                //echo 'detecting Browser (writing cache - End)  : ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            }
        } else {
            if (null === $this->_serviceAgents) {
                $this->_serviceAgents = new Service\Agents();
            }
            
            $agent = $this->_serviceAgents->searchByAgent($userAgent);
            $this->_serviceAgents->count($agent->idAgents);
        }
        
        unset($cacheId);
        
        //echo 'detecting User Agent (Finish): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        
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
            ////echo "\t" . 'searching User Agent - creating new object: ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $agent        = $this->_serviceAgents->createRow();
            $agent->agent = $userAgent;
            $agent->save();
        }
        
        ////echo "\t" . 'searching User Agent: ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        
        $this->_serviceAgents->count($agent->idAgents);
        
        ////echo "\t" . 'counting User Agent: ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        ////echo "\t" . 'detecting rendering Engine (Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        ////echo "\t\t" . 'detecting rendering Engine (init): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        
        if (null === $this->_serviceEngines) {
            $this->_serviceEngines = new Service\Engines();
        }
        ////echo "\t\t" . 'detecting rendering Engine (creating Model): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        if ($forceDetected 
            || !$agent->idEngines 
            || null === ($engine = $this->_serviceEngines->find($agent->idEngines)->current())
        ) {
            ////echo "\t\t" . 'detecting rendering Engine (searching Engine failed): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            // detect the Rendering Engine
            $chainEngines = new Engine\Chain();
            
            $engine           = $chainEngines->detect($userAgent);
            ////echo "\t\t" . 'detecting rendering Engine (detecting Engine): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $agent->idEngines = $this->_serviceEngines->countByName($engine->engine, $engine->version);
            
            unset($chainEngines);
        } else {
            ////echo "\t\t" . 'detecting rendering Engine (searching Engine secceeded): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $this->_serviceEngines->count($agent->idEngines);
            ////echo "\t\t" . 'detecting rendering Engine (counting Engine): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $engine = (object) $engine->toArray();
        }
        ////echo "\t\t" . 'detecting rendering Engine (Finish): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        ////echo "\t" . 'detecting rendering Engine (End): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        ////echo "\t" . 'detecting Browser (Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        ////echo "\t\t" . 'detecting Browser (init): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        
        if (null === $this->_serviceBrowsers) {
            $this->_serviceBrowsers = new Service\Browsers();
        }
        
        ////echo "\t\t" . 'detecting Browser (creating Model): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        
        if ($forceDetected 
            || !$agent->idBrowsers 
            || null === ($browser = $this->_serviceBrowsers->find($agent->idBrowsers)->current())
        ) {
            ////echo "\t\t" . 'detecting Browser (searching Browser failed): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            // detect the browser
            $chainBrowsers = new Browser\Chain();
            
            ////echo "\t\t" . 'detecting Browser (creating Chain): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $browser           = $chainBrowsers->detect($userAgent);
            ////echo "\t\t" . 'detecting Browser (detecting Browser): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $agent->idBrowsers = $browser->idBrowsers;
            
            unset($chainBrowsers);
        } else {
            ////echo "\t\t" . 'detecting Browser (searching Browser succeded): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $browser = (object) $browser->toArray();
        }
        
        $this->_serviceBrowsers->count($agent->idBrowsers);
        ////echo "\t\t" . 'detecting Browser (counting Browser): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        ////echo "\t\t" . 'detecting Browser (Finish): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        ////echo "\t" . 'detecting Browser (End): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        ////echo "\t" . 'detecting Browser-Data (Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        
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
        
        ////echo "\t" . 'detecting Browser-Data (End): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        ////echo "\t" . 'detecting OS (Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        
        if (null === $this->_serviceOs) {
            $this->_serviceOs = new Service\Os();
        }
        
        ////echo "\t\t" . 'detecting OS (Model-Init): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        if ($forceDetected 
            || !$agent->idOs 
            || null === ($os = $this->_serviceOs->find($agent->idOs)->current())
        ) {
            ////echo "\t\t" . 'detecting OS (searching OS failed): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            // detect the Operating System
            $chainOs = new Os\Chain();
            
            ////echo "\t\t" . 'detecting OS (creating Chain): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $os          = $chainOs->detect($userAgent);//var_dump($os);exit;
            ////echo "\t\t" . 'detecting OS (detecting OS): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $agent->idOs = $this->_serviceOs->countByName($os->name, $os->version, $os->bits);
            ////echo "\t\t" . 'detecting OS (counting OS): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            
            unset($chainOs);
        } else {
            ////echo "\t\t" . 'detecting OS (searching OS succseeded): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $this->_serviceOs->count($agent->idOs);
            ////echo "\t\t" . 'detecting OS (counting OS): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $os = (object) $os->toArray();
        }
        
        ////echo "\t\t" . 'detecting OS (Finish): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        ////echo "\t" . 'detecting OS (End): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        /*
        ////echo "\t" . 'detecting Device (Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        
        // detect the device
        $deviceChain = new Device\Chain();
        $device      = $deviceChain->detect($userAgent);
        
        ////echo "\t" . 'detecting Device (End): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        /**/
        /*
        ////echo "\t" . 'detecting Wurfl-Data (Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        
        $modelWurflData = new Model\WurflData();
        //if (null === $agent->idWurflData) {
            $wurfl = $modelWurflData->count(null, $userAgent);exit;
        //    $agent->idWurflData = $wurfl->idWurflData;
        //} else {
        //    $modelWurflData->count($agent->idWurflData, $userAgent);
        //    
        //    $wurfl = $modelWurflData->find($agent->idWurflData)->current();
        //}
        
        ////echo "\t" . 'detecting Wurfl-Data (End): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        /**/
        ////echo "\t" . 'detecting Browscap-Data (Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        
        if (null === $this->_serviceBrowscapData) {
            $this->_serviceBrowscapData = new Service\BrowscapData();
        }
        /*
        ////echo "\t\t" . 'detecting Browscap-Data (Model-Init): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        if ($forceDetected 
            || !$agent->idBrowscapData 
            || null === ($object = $this->_serviceBrowscapData->find($agent->idBrowscapData)->current())
        ) {
            ////echo "\t\t" . 'detecting Browscap-Data (init): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            
            if (null === $this->_browscap) {
                // define the User Agent object and set the default values
                $this->_browscap = new Browscap($this->_config, $this->_logger, $this->_cache);
            }
            
            ////echo "\t\t" . 'detecting Browscap-Data (construct): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $detected = $this->_browscap->getBrowser($userAgent);
            ////echo "\t\t" . 'detecting Browscap-Data (getBrowser): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            
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
            
            ////echo "\t\t" . 'detecting Browscap-Data (set object): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        }
        
        ////echo "\t" . 'detecting Browscap-Data (End): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        /**/
        $this->_serviceAgents->update($agent->toArray(), 'idAgents = ' . (int) $agent->idAgents);
        
        //$object->idAgents = $agent->idAgents;
        
        ////echo "\t" . 'detecting Browscap (Finish): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        
        //return ($bReturnAsArray ? (array) $object : $object);
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