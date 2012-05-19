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
 * @version    SVN: $Id$
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
     * the user agent sent from the browser
     *
     * @var string
     */
    private $_cleanedAgent = '';
    
    /**
     * the ID of the user agent sent from the browser
     *
     * @var string
     */
    private $_idAgent = null;
    
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
     * @var \Browscap\Os\Chain
     */
    private $_osChain = null;
    
    /**
     * @var \Browscap\Engine\Chain
     */
    private $_engineChain = null;
    
    /**
     * @var \Browscap\Browser\Chain
     */
    private $_browserChain = null;
    
    /**
     * @var \Browscap\Device\Chain
     */
    private $_deviceChain = null;
    
    /**
     * @var \Browscap\Support
     */
    private $_support = null;
    
    private $_engine = null;
    
    private $_os = null;
    
    private $_device = null;

    /**
     * Constructor class, checks for the existence of (and loads) the cache and
     * if needed updated the definitions
     */
    public function __construct()
    {
        //
    }
    
    /**
     * sets the logger used when errors occur
     *
     * @param \Zend\Log\Logger $logger
     *
     * @return 
     */
    public function setLogger(\Zend\Log\Logger $logger)
    {
        $this->_logger = $logger;
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return 
     */
    public function setCache(\Zend\Cache\Frontend\Core $cache)
    {
        $this->_cache = $cache;
        
        return $this;
    }
    
    public function cleanAgent($userAgent)
    {
        $userAgent = str_replace(array('User-Agent:', 'User-agent:'), '', $userAgent);
        $userAgent = str_replace(array(' :: '), ';', $userAgent);
        $userAgent = str_replace(array('%2C'), '.', $userAgent);
        $userAgent = preg_replace('/\s+\s/', ' ', $userAgent);
        $userAgent = trim($userAgent);
        
        return $userAgent;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $userAgent the user agent string
     *
     * @return 
     */
    public function getBrowser($userAgent = null, $forceDetected = false, $useDb = false)
    {
        // Automatically detect the useragent
        if (empty($userAgent) || !is_string($userAgent)) {
            if (null === $this->_support) {
                $this->_support = new Support();
            }
            
            $userAgent = $this->_support->getUserAgent();
        }
        
        if (null === $this->_serviceAgents && $useDb) {
            $this->_serviceAgents = new Service\Agents();
        }
        
        $this->_agent = $userAgent;
        
        $userAgent = $this->cleanAgent($userAgent);
        
        $this->_cleanedAgent = $userAgent;
        
        $cacheId = substr(
            'agent_' . preg_replace(
                '/[^a-zA-Z0-9]/', '_', $userAgent
            ), 
            0, 
            179
        );
        
        if ($forceDetected 
            || $useDb
            || !($this->_cache instanceof \Zend\Cache\Frontend\Core)
            || !($browserArray = $this->_cache->load($cacheId))
        ) {
            $browserArray = $this->_detect($this->_cleanedAgent, $forceDetected, $useDb);
            
            if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                $this->_cache->save($browserArray, $cacheId);
            }
            
        }
        
        if ($forceDetected && $useDb) {
            
            $agent = $this->_serviceAgents->searchByAgent($userAgent);
            $this->_serviceAgents->count($agent->idAgents);
            
            $this->_idAgent = $agent->idAgents;
            
            unset($agent);
        }
        
        unset($cacheId);
        
        return $browserArray;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $userAgent     the user agent string
     *
     * @return 
     */
    private function _detect($userAgent = null, $forceDetected = false, $useDb = false)
    {
        $agent = null;
        
        if ($useDb) {
            $agent = $this->_serviceAgents->searchByAgent($userAgent);
            
            if (!is_object($agent)) {
                $agent        = $this->_serviceAgents->createRow();
                $agent->agent = $userAgent;
                $agent->save();
            }
            
            $this->_serviceAgents->getModel()->getAdapter()->beginTransaction();
            
            if ($forceDetected) {
                $this->_serviceAgents->count($agent->idAgents);
            }
        }
        
        $this->_engine  = $this->_detectEngine($agent, $userAgent, $forceDetected, $useDb);
        $this->_browser = $this->_detectBrowser($agent, $userAgent, $forceDetected, $useDb);
        $this->_os      = $this->_detectOs($agent, $userAgent, $forceDetected, $useDb);
        $this->_device  = $this->_detectDevice($agent, $userAgent, $forceDetected, $useDb);
        
        if ($useDb) {
            $this->_serviceAgents->update($agent->toArray(), 'idAgents = ' . (int) $agent->idAgents);
            
            $this->_serviceAgents->getModel()->getAdapter()->commit();
        }
        
        return $this;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $userAgent     the user agent string
     *
     * @return 
     */
    private function _detectEngine($agent, $userAgent = null, $forceDetected = false, $useDb = false)
    {
        if (null === $this->_serviceEngines 
            && $useDb 
            && $agent instanceof \Zend\Db\Table\Row
        ) {
            $this->_serviceEngines = new Service\Engines();
        }
        
        $engine = null;
        
        if ($useDb && $agent instanceof \Zend\Db\Table\Row) {
            $idEngines = null;
            
            if ($idEngines = $agent->idEngines) {
                $engine = $this->_serviceEngines->find($idEngines)->current();
            }
            
            unset($idEngines);
        }
        
        if ($forceDetected || null === $engine) {
            // detect the Rendering Engine
            if (null === $this->_engineChain) {
                if (!($this->_cache instanceof \Zend\Cache\Frontend\Core)
                    || !($this->_engineChain = $this->_cache->load('EngineChain'))
                ) {
                    $this->_engineChain = new Engine\Chain();
                    $this->_engineChain->setLogger($this->_logger);
                    
                    if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                        $this->_engineChain->setCache($this->_cache);
                        
                        $this->_cache->save($this->_engineChain, 'EngineChain');
                    }
                }
            }
            
            $engine = $this->_engineChain->detect($userAgent);
            
            if ($useDb && $agent instanceof \Zend\Db\Table\Row) {
                $searchedEngine = $this->_serviceEngines->searchByName($engine->getEngine(), $engine->getVersion());
                
                if ($searchedEngine) {
                    $agent->idEngines = $searchedEngine->idEngines;
                    $searchedEngine->data = \Zend\Json\Json::encode($engine);
                    $searchedEngine->save();
                }
                
                unset($searchedEngine);
            }
        } else {
            $engine = (object) $engine->toArray();var_dump($engine);exit;
            
            if ($useDb && $agent instanceof \Zend\Db\Table\Row) {
                $this->_serviceEngines->count($engine->idEngines);
            }
            
            //$engine->engineFull = $engine->getFullEngine();
        }
        
        return $engine;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $userAgent     the user agent string
     *
     * @return 
     */
    private function _detectBrowser($agent, $userAgent = null, $forceDetected = false, $useDb = false)
    {
        if (null === $this->_serviceBrowsers && $useDb && $agent instanceof \Zend\Db\Table\Row) {
            $this->_serviceBrowsers = new Service\Browsers();
        }
        
        $browser = null;
        
        if ($useDb) {
            $idBrowsers = null;
            
            if ($idBrowsers = $agent->idBrowsers) {
                $browser = $browser = $this->_serviceBrowsers->find($idBrowsers)->current();
            }
            
            unset($idBrowsers);
        }
        
        if ($forceDetected || null === $browser) {
            // detect the browser
            if (null === $this->_browserChain) {
                if (!($this->_cache instanceof \Zend\Cache\Frontend\Core)
                    || !($this->_browserChain = $this->_cache->load('BrowserChain'))
                ) {
                    $this->_browserChain = new Browser\Chain();
                    $this->_browserChain->setLogger($this->_logger);
                    
                    if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                        $this->_browserChain->setCache($this->_cache);
                        
                        $this->_cache->save($this->_browserChain, 'BrowserChain');
                    }
                }
            }
            
            $browser = $this->_browserChain->detect($userAgent);
            
            if ($forceDetected && $useDb && $agent instanceof \Zend\Db\Table\Row) {
                $agent->idBrowsers = $this->_serviceBrowsers->searchByBrowser($browser->getBrowser(), $browser->getVersion(), $browser->getBits())->idBrowsers;
            }
        } else {
            $browser = (object) $browser->toArray();
            $browser->browserFull = $browser->getFullBrowser();
        }
        
        if ($forceDetected && $useDb && $agent instanceof \Zend\Db\Table\Row) {
            $this->_serviceBrowsers->count($agent->idBrowsers);
        }
        
        return $browser;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $userAgent     the user agent string
     *
     * @return 
     */
    private function _detectOs($agent, $userAgent = null, $forceDetected = false, $useDb = false)
    {   
        if (null === $this->_serviceOs && $useDb && $agent instanceof \Zend\Db\Table\Row) {
            $this->_serviceOs = new Service\Os();
        }
        
        $os = null;
        
        if ($useDb) {
            $idOs = null;
            
            if ($idOs = $agent->idOs) {
                $os = $this->_serviceOs->find($idOs)->current();
            }
            
            unset($idOs);
        }
        
        if ($forceDetected || null === $os) {
            // detect the Operating System
            if (null === $this->_osChain) {
                if (!($this->_cache instanceof \Zend\Cache\Frontend\Core)
                    || !($this->_osChain = $this->_cache->load('PlatformChain'))
                ) {
                    $this->_osChain = new Os\Chain();
                    $this->_osChain->setLogger($this->_logger);
                    
                    if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                        $this->_osChain->setCache($this->_cache);
                        
                        $this->_cache->save($this->_osChain, 'PlatformChain');
                    }
                }
            }
            
            $os = $this->_osChain->detect($userAgent);
            
            if ($forceDetected && $useDb && $agent instanceof \Zend\Db\Table\Row) {
                $osResult = $this->_serviceOs->searchByName($os->getName(), $os->getVersion(), $os->getBits());
                
                if ($osResult) {
                    $agent->idOs = $osResult->idOs;
                }
                
                unset($osResult);
            }
        } else {
            $os = (object) $os->toArray();
            $os->osFull  = $os->getFullName();
        }
        
        if ($forceDetected && $useDb && $agent instanceof \Zend\Db\Table\Row) {
            $this->_serviceOs->count($agent->idOs);
        }
        
        return $os;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $userAgent     the user agent string
     *
     * @return 
     */
    private function _detectDevice($agent, $userAgent = null, $forceDetected = false, $useDb = false)
    {
        /*
        if (null === $this->_serviceOs && $useDb && $agent instanceof \Zend\Db\Table\Row) {
            $this->_serviceOs = new Service\Os();
        }
        /**/
        
        $device = null;
        
        /*
        if ($useDb) {
            $idOs = null;
            
            if ($idOs = $agent->idOs) {
                $os = $this->_serviceOs->find($idOs)->current();
            }
            
            unset($idOs);
        }
        /**/
        
        // detect the device
        if ($forceDetected  || null === $device) {
            // detect the device
            // detect the Operating System
            if (null === $this->_deviceChain) {
                if (!($this->_cache instanceof \Zend\Cache\Frontend\Core)
                    || !($this->_deviceChain = $this->_cache->load('DeviceChain'))
                ) {
                    $this->_deviceChain = new Device\Chain();
                    $this->_deviceChain->setLogger($this->_logger);
                    
                    if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                        $this->_deviceChain->setCache($this->_cache);
                        
                        $this->_cache->save($this->_deviceChain, 'DeviceChain');
                    }
                }
            }
            
            $device = $this->_deviceChain->detect($userAgent);
            
            if ($useDb) {
                //$osResult = $this->_serviceOs->searchByName($os->name, $os->version, $os->bits);
                
                //if ($osResult) {
                //    $agent->idDevice = $osResult->idOs;
                //}
            }
        } else {
            $device = null; //(object) $device->toArray();
        }
        /*
        if ($forceDetected && $useDb && $agent instanceof \Zend\Db\Table\Row) {
            $this->_serviceOs->count($agent->idOs);
        }
        /**/
        return $device;
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
    public function getcleanedAgent()
    {
        return $this->_cleanedAgent;
    }
    
    /**
     * returns the stored user agent
     *
     * @return integer|null
     */
    public function getAgentId()
    {
        return $this->_idAgent;
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
    
    final public function getDevice()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->getDevice();
    }
    
    final public function getFullDevice()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->getFullDevice();
    }
    
    /**
     * returns TRUE if the device supports RSS Feeds
     *
     * @return boolean
     */
    public function isRssSupported()
    {
        if (null === $this->_browser 
            && null === $this->_engine 
            && null === $this->_device
        ) {
            return null;
        }
        
        $support = true;
        
        if (null !== $this->_engine) {
            $support = $support && $this->_engine->isRssSupported();
        }
        
        if ($support && null !== $this->_browser) {
            $support = $support && $this->_browser->isRssSupported();
        }
        
        if ($support && null !== $this->_device) {
            $support = $support && $this->_device->isRssSupported();
        }
        
        return $support;
    }
    
    /**
     * returns TRUE if the device supports PDF documents
     *
     * @return boolean
     */
    public function isPdfSupported()
    {
        if (null === $this->_browser 
            && null === $this->_engine 
            && null === $this->_device
        ) {
            return null;
        }
        
        $support = true;
        
        if (null !== $this->_engine) {
            $support = $support && $this->_engine->isPdfSupported();
        }
        
        if ($support && null !== $this->_browser) {
            $support = $support && $this->_browser->isPdfSupported();
        }
        
        if ($support && null !== $this->_device) {
            $support = $support && $this->_device->isPdfSupported();
        }
        
        return $support;
    }
    
    final public function getBrowserName()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getBrowser();
    }
    
    final public function getVersion()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getVersion();
    }
    
    final public function getBits()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getBits();
    }
    
    final public function getFullBrowser($withBits = true)
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getFullBrowser($withBits);
    }
    
    /**
     * returns TRUE if the device is a Transcoder
     *
     * @return boolean
     */
    public function isTranscoder()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->isTranscoder();
    }
    
    final public function getEngine()
    {
        if (null === $this->_engine) {
            return null;
        }
        
        return $this->_engine->getEngine();
    }
    
    final public function getEngineVersion()
    {
        if (null === $this->_engine) {
            return null;
        }
        
        return $this->_engine->getVersion();
    }
    
    final public function getFullEngine($withBits = true)
    {
        if (null === $this->_engine) {
            return null;
        }
        
        return $this->_engine->getFullEngine($withBits);
    }
    
    final public function getPlatform()
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getName();
    }
    
    final public function getPlatformVersion()
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getVersion();
    }
    
    final public function getPlatformBits()
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getBits();
    }
    
    final public function getFullPlatform($withBits = true)
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getFullName($withBits);
    }
    
    /**
     * returns TRUE if the browser should be banned
     *
     * @return boolean
     */
    public function isBanned()
    {
        if (null === $this->_browser && null === $this->_device) {
            return null;
        }
        
        $notBanned = true;
        
        if (null !== $this->_browser) {
            $notBanned = $notBanned && !$this->_browser->isBanned();
        }
        
        if ($notBanned && null !== $this->_device) {
            $notBanned = $notBanned && !$this->_device->isBanned();
        }
        
        return (!$notBanned);
    }
    
    /**
     * returns TRUE if the device is a mobile
     *
     * @return boolean
     */
    public function isMobileDevice()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->isMobileDevice();
    }
    
    /**
     * returns TRUE if the device is a tablet
     *
     * @return boolean
     */
    public function isTablet()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->isTablet();
    }
    
    /**
     * returns TRUE if the browser supports VBScript
     *
     * @return boolean
     */
    public function isCrawler()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->isCrawler();
    }
    
    /**
     * returns TRUE if the browser supports Frames
     *
     * @return boolean
     */
    public function supportsFrames()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsFrames();
    }
    
    /**
     * returns TRUE if the browser supports IFrames
     *
     * @return boolean
     */
    public function supportsIframes()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsIframes();
    }
    
    /**
     * returns TRUE if the browser supports Tables
     *
     * @return boolean
     */
    public function supportsTables()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsTables();
    }
    
    /**
     * returns TRUE if the browser supports Cookies
     *
     * @return boolean
     */
    public function supportsCookies()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsCookies();
    }
    
    /**
     * returns TRUE if the browser supports BackgroundSounds
     *
     * @return boolean
     */
    public function supportsBackgroundSounds()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsBackgroundSounds();
    }
    
    /**
     * returns TRUE if the browser supports JavaScript
     *
     * @return boolean
     */
    public function supportsJavaScript()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsJavaScript();
    }
    
    /**
     * returns TRUE if the browser supports VBScript
     *
     * @return boolean
     */
    public function supportsVbScript()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsVbScript();
    }
    
    /**
     * returns TRUE if the browser supports Java Applets
     *
     * @return boolean
     */
    public function supportsJavaApplets()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsJavaApplets();
    }
    
    /**
     * returns TRUE if the browser supports ActiveX Controls
     *
     * @return boolean
     */
    public function supportsActivexControls()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsActivexControls();
    }
    
    /**
     * returns TRUE if the device is a Syndication Reader
     *
     * @return boolean
     */
    public function isSyndicationReader()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->isSyndicationReader();
    }
}