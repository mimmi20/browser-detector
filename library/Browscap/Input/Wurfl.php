<?php
namespace Browscap\Input;

/**
 * Browscap.ini parsing final class with caching and update capabilities
 *
 * PHP version 5.3
 *
 * LICENSE:
 *
 * Copyright (c) 2013, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, 
 *   this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice, 
 *   this list of conditions and the following disclaimer in the documentation 
 *   and/or other materials provided with the distribution.
 * * Neither the name of the authors nor the names of its contributors may be 
 *   used to endorse or promote products derived from this software without 
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright 2006-2008 Jonathan Stoppani
 * @version   SVN: $Id$
 */
use \Browscap\Detector\MatcherInterface;
use \Browscap\Detector\MatcherInterface\DeviceInterface;
use \Browscap\Detector\MatcherInterface\OsInterface;
use \Browscap\Detector\MatcherInterface\BrowserInterface;
use \Browscap\Detector\EngineHandler;
use \Browscap\Detector\Result;

/**
 * Browscap.ini parsing final class with caching and update capabilities
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
final class Wurfl extends Core
{
    /**
     * the detected browser
     *
     * @var Stdfinal class
     */
    private $_browser = null;
    
    /**
     * the detected browser engine
     *
     * @var Stdfinal class
     */
    private $_engine = null;
    
    /**
     * the detected platform
     *
     * @var Stdfinal class
     */
    private $_os = null;
    
    /**
     * the detected device
     *
     * @var Stdfinal class
     */
    private $_device = null;
    
    /**
     * the detection result
     *
     * @var \Browscap\Detector\Result
     */
    private $_result = null;
    
    /**
     * the wurfl detector class
     *
     * @var
     */
    private $_wurflManager = null;
    
    /**
     * the cache class
     *
     * @var
     */
    private $_cache = null;
    
    /** @var string */
    private $_cachePrefix = null;
    
    /**
     * the config object
     *
     * @var \Wurfl\Configuration\Config
     *
     * @throws \UnexpectedValueException
     */
    private $_config = null;
    
    /**
     * sets ab wurfl detection manager
     *
     * @var \Wurfl\ManagerFactory|\Wurfl\Manager
     *
     * @return \Browscap\Input\Wurfl
     */
    public function setWurflManager($wurfl)
    {
        if ($wurfl instanceof \Wurfl\ManagerFactory) {
            $wurfl = $wurfl->create();
        }
        
        if (!($wurfl instanceof \Wurfl\Manager)) {
            throw new \UnexpectedValueException(
                'the $wurfl object has to be an instance of \\Wurfl\\ManagerFactory or an instance of \\Wurfl\\ManagerFactory'
            );
        }
        
        $this->_wurflManager = $wurfl;
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return \\Browscap\\Browscap
     */
    public function setCache(\Zend\Cache\Frontend\Core $cache)
    {
        $this->_cache = $cache;
        
        return $this;
    }

    /**
     * sets the the cache prfix
     *
     * @param string $prefix the new prefix
     *
     * @return \\Browscap\\Browscap
     */
    public function setCachePrefix($prefix)
    {
        if (!is_string($prefix)) {
            throw new \UnexpectedValueException(
                'the cache prefix has to be a string'
            );
        }
        
        $this->_cachePrefix = $prefix;
        
        return $this;
    }

    /**
     * sets the the cache prfix
     *
     * @param \Wurfl\Configuration\Config $config the new config
     *
     * @return \\Browscap\\Browscap
     */
    public function setConfig(\Wurfl\Configuration\Config $config)
    {
        $this->_config = $config;
        
        return $this;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \Browscap\Detector\Result
     */
    public function getBrowser()
    {
        if (!($this->_wurflManager instanceof \Wurfl\Manager)) {
            throw new \UnexpectedValueException(
                'the $wurfl object has to be an instance of \\Wurfl\\ManagerFactory or an instance of \\Wurfl\\ManagerFactory'
            );
        }
        
        $device        = $this->_wurflManager->getDeviceForUserAgent($this->_agent);
        $allProperties = $device->getAllCapabilities();
        
        $this->_result = new Result();
        
        foreach ($allProperties as $capabilityName => $capabilityValue) {
            switch ($capabilityValue) {
                case 'true':
                case true:
                    $capabilityValue = true;
                    break;
                case 'false':
                case false:
                    $capabilityValue = false;
                    break;
                case null:
                case 'unknown':
                    $capabilityValue = null;
            }
            
            switch ($capabilityName) {
                case 
            }
            
            $this->_result->setCapability($capabilityName, $capabilityValue)
        }
        
        return $this->_result;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @return 
     */
    private function _detectEngine()
    {
        $handlersToUse = array();
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Engine');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Engine\Unknown());
        
        return $chain->detect();
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return 
     */
    private function _detectBrowser()
    {
        $handlersToUse = array(
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Browser');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Browser\Unknown());
        
        return $chain->detect();
    }

    /**
     * Gets the information about the os by User Agent
     *
     * @return 
     */
    private function _detectOs()
    {
        $handlersToUse = array(
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Os');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Os\Unknown());
        
        return $chain->detect();
    }

    /**
     * Gets the information about the device by User Agent
     *
     * @return UserAgent
     */
    private function _detectDevice()
    {
        $handlersToUse = array(
            new \Browscap\Detector\Device\GeneralBot(),
            new \Browscap\Detector\Device\GeneralMobile(),
            new \Browscap\Detector\Device\GeneralTv(),
            new \Browscap\Detector\Device\GeneralDesktop()
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Device');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Device\Unknown());
        
        return $chain->detect();
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
}