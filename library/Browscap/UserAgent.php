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
     * @var \Browscap\Support
     */
    private $_support = null;

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
        
        if (!is_array($config)) {
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
        
        $this->getBrowser($agent, false, false);
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
    public function getBrowser($userAgent = null, $bReturnAsArray = false, $forceDetected = false, $useDb = false)
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
        
        $userAgent = str_replace(array('User-Agent:', 'User-agent:'), '', $userAgent);
        $userAgent = str_replace(array(' :: '), ';', $userAgent);
        $userAgent = trim($userAgent);
        
        $cacheId = 'agent_' . preg_replace(
            '/[^a-zA-Z0-9]/', '_', urlencode($userAgent)
        );
        
        if ($forceDetected 
            || !($this->_cache instanceof \Zend\Cache\Cache)
            || !($browserArray = $this->_cache->load($cacheId))
        ) {
            
            $browserArray = $this->_detect($userAgent, $bReturnAsArray, $forceDetected, $useDb);
            
            if ($this->_cache instanceof \Zend\Cache\Cache) {
                $this->_cache->save($browserArray, $cacheId);
            }
            
        }
        
        if ($forceDetected && $useDb) {
            
            $agent = $this->_serviceAgents->searchByAgent($userAgent);
            $this->_serviceAgents->count($agent->idAgents);
            
            unset($agent);
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
    private function _detect($userAgent = null, $bReturnAsArray = false, $forceDetected = false, $useDb = false)
    {
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
        
        if (null === $this->_serviceEngines && $useDb) {
            $this->_serviceEngines = new Service\Engines();
        }
        
        $engine = null;
        
        if ($useDb) {
            $idEngines = null;
            
            if ($idEngines = $agent->idEngines) {
                $engine = $this->_serviceEngines->find($idEngines)->current();
            }
            
            unset($idEngines);
        }
        
        if ($forceDetected || null === $engine) {
            // detect the Rendering Engine
            if (null === $this->_engineChain) {
                $this->_engineChain = new Engine\Chain();
            }
            
            $engine = $this->_engineChain->detect($userAgent);
            
            if ($forceDetected && $useDb) {
                $searchedEngine = $this->_serviceEngines->searchByName($engine->engine, $engine->version);
                
                if ($searchedEngine) {
                    $agent->idEngines = $searchedEngine->idEngines;
                }
                
                unset($searchedEngine);
            }
        } else {
            $engine = (object) $engine->toArray();
            $engine->engineFull = $engine->engine . ($engine->engine != $engine->version && '' != $engine->version ? ' ' . $engine->version : '');
        }
        
        if ($forceDetected && $useDb) {
            $this->_serviceEngines->count($agent->idEngines);
        }
        
        if (null === $this->_serviceBrowsers && $useDb) {
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
                $this->_browserChain = new Browser\Chain();
            }
            
            $browser = $this->_browserChain->detect($userAgent);
            
            if ($forceDetected && $useDb) {
                $agent->idBrowsers = $this->_serviceBrowsers->searchByBrowser($browser->browser, $browser->version, $browser->bits)->idBrowsers;
            }
        } else {
            $browser = (object) $browser->toArray();
            $browser->browserFull = $browser->browser . ($browser->browser != $browser->version && '' != $browser->version ? ' ' . $browser->version : '');
        }
        
        if ($forceDetected && $useDb) {
            $this->_serviceBrowsers->count($agent->idBrowsers);
        }
        
        if (null === $this->_serviceOs && $useDb) {
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
                $this->_osChain = new Os\Chain();
            }
            
            $os = $this->_osChain->detect($userAgent);
            
            if ($forceDetected && $useDb) {
                $osResult = $this->_serviceOs->searchByName($os->name, $os->version, $os->bits);
                
                if ($osResult) {
                    $agent->idOs = $osResult->idOs;
                }
                
                unset($osResult);
            }
        } else {
            $os = (object) $os->toArray();
            $os->osFull  = $os->os . ($os->os != $os->version && '' != $os->version ? ' ' . $os->version : '');
        }
        
        if ($forceDetected && $useDb) {
            $this->_serviceOs->count($agent->idOs);
        }
        
        $device = null;
        
        // detect the device
        if ($forceDetected 
            //|| !$agent->idDevice
            //|| null === ($device = $this->_serviceOs->find($agent->idDevice)->current())
        ) {
            // detect the device
            $chainDevice = new Device\Chain();
            
            $device = $chainDevice->detect($userAgent);//var_dump($os);exit;
            
            if ($useDb) {
                //$osResult = $this->_serviceOs->searchByName($os->name, $os->version, $os->bits);
                
                //if ($osResult) {
                //    $agent->idDevice = $osResult->idOs;
                //}
            }
            
            unset($chainDevice);
        } else {
            $device = null; //(object) $device->toArray();
        }
        
        if ($useDb) {
            $this->_serviceAgents->update($agent->toArray(), 'idAgents = ' . (int) $agent->idAgents);
            
            $this->_serviceAgents->getModel()->getAdapter()->commit();
        }
        
        $object = new \StdClass();
        $object->engine   = $engine;
        $object->browser  = $browser;
        $object->os       = $os;
        $object->device   = $device;
        
        unset($engine);
        unset($browser);
        unset($os);
        unset($agent);
        
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