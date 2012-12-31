<?php
namespace Browscap\Detector;

/**
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
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */

use \Browscap\Helper\Utils;
use \Browscap\Detector\MatcherInterface;

/**
 * WURFL_Handlers_Handler is the base class that combines the classification of
 * the user agents and the matching process.
 *
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
abstract class DeviceHandler implements MatcherInterface
{
    /**
     * @var string the user agent to handle
     */
    protected $_useragent = '';
    
    /**
     * @var \Browscap\Helper\Utils the helper class
     */
    protected $_utils = null;
    
    /**
     * a \Zend\Cache object
     *
     * @var \Zend\Cache
     */
    protected $_cache = null;
    
    /**
     * the detected browser properties
     *
     * @var StdClass
     */
    protected $_properties = array(
        'wurflKey' => null, // not in wurfl
        
        // kind of device
        'is_wireless_device' => false,
        'is_tablet'          => false,
        'is_bot'             => false,
        'is_smarttv'         => false,
        'is_console'         => false,
        'ux_full_desktop'    => false,
        'is_transcoder'      => false,
        
        // device
        'model_name'                => 'unknown',
        'manufacturer_name'         => 'unknown',
        'brand_name'                => 'unknown',
        'model_extra_info'          => null,
        'marketing_name'            => null,
        'has_qwerty_keyboard'       => null,
        'pointing_method'           => null,
        'device_claims_web_support' => null,
        'device_bits'               => null, // not in wurfl
        'device_cpu'                => null, // not in wurfl
        
        // browser
        // 'mobile_browser'         => null,
        // 'mobile_browser_version' => null,
        // 'mobile_browser_bits'    => null, // not in wurfl
        
        // os
        // 'device_os'              => null,
        // 'device_os_version'      => null,
        // 'device_os_bits'         => null, // not in wurfl
        // 'device_os_manufacturer' => null, // not in wurfl
        
        // engine
        // 'renderingengine_name'         => null, // not in wurfl
        // 'renderingengine_version'      => null, // not in wurfl
        // 'renderingengine_manufacturer' => null, // not in wurfl
    );
    
    /**
     * @param WURFL_Context $wurflContext
     * @param WURFL_Request_UserAgentNormalizer_Interface $userAgentNormalizer
     */
    public function __construct()
    {
        $this->_utils = new Utils();
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
        if (!($cache instanceof \Zend\Cache\Frontend\Core)) {
            throw new \InvalidArgumentException(
                'the cache must be an instance of \\Zend\\Cache\\Frontend\\Core'
            );
        }
        
        $this->_cache = $cache;
        
        return $this;
    }
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        $this->_utils->setUserAgent($userAgent);
        
        return $this;
    }
    
    /**
     * Returns true if this handler can handle the given $userAgent
     *
     * @param string $userAgent
     *
     * @return bool
     */
    public function canHandle()
    {
        return false;
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
     */
    public function detect()
    {
        $this->setCapability('device_cpu', $this->_detectCpu());
        $this->setCapability('device_bits', $this->_detectBits());
        
        $device = $this->detectDevice();
        
        return $device;
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
     */
    public function detectDevice()
    {
        return $this;
    }
    
    /**
     * detect the cpu which is build into the device
     *
     * @return Handler
     */
    protected function _detectCpu()
    {
        $detector = new \Browscap\Detector\Cpu();
        $detector->setUserAgent($this->_useragent);
        
        return $detector->getCpu();
    }
    
    /**
     * detect the bits of the cpu which is build into the device
     *
     * @return Handler
     */
    protected function _detectBits()
    {
        $detector = new \Browscap\Detector\Bits\Device();
        $detector->setUserAgent($this->_useragent);
        
        return $detector->getBits();
    }
    
    /**
     * detect the bits of the cpu which is build into the device
     *
     * @return Handler
     */
    protected function _detectProperties()
    {
        return $this;
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 1;
    }
    
    /**
     * Returns the value of a given capability name
     * for the current device
     * 
     * @param string $capabilityName must be a valid capability name
     * @return string Capability value
     * @throws InvalidArgumentException
     */
    public function getCapability($capabilityName) 
    {
        $this->_checkCapability($capabilityName);
        
        return $this->_properties[$capabilityName];
    }
    
    /**
     * Returns the value of a given capability name
     * for the current device
     * 
     * @param string $capabilityName must be a valid capability name
     * @return string Capability value
     * @throws InvalidArgumentException
     */
    public function setCapability($capabilityName, $capabilityValue = null) 
    {
        $this->_checkCapability($capabilityName);
        
        $this->_properties[$capabilityName] = $capabilityValue;
        
        return $this;
    }
    
    /**
     * Returns the value of a given capability name
     * for the current device
     * 
     * @param string $capabilityName must be a valid capability name
     * @return string Capability value
     * @throws InvalidArgumentException
     */
    protected function _checkCapability($capabilityName) 
    {
        if (empty($capabilityName)) {
            throw new \InvalidArgumentException(
                'capability name must not be empty'
            );
        }
        
        if (!array_key_exists($capabilityName, $this->_properties)) {
            throw new \InvalidArgumentException(
                'no capability named [' . $capabilityName . '] is present.'
            );    
        }
    }
    
    /**
     * returns TRUE if the device has a specific Operating System
     *
     * @return boolean
     */
    public function hasBrowser()
    {
        return true;
    }
    
    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectBrowser()
    {
        $browser = new \Browscap\Detector\Browser\Unknown();
        $browser->setUserAgent($this->_useragent);
        
        return $browser->detect();
    }
    
    /**
     * returns TRUE if the device has a specific Operating System
     *
     * @return boolean
     */
    public function hasOs()
    {
        return true;
    }
    
    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectOs()
    {
        $chain = new \Browscap\Detector\Chain();
        $chain->setDefaultHandler(new \Browscap\Detector\Os\Unknown());
        $chain->setUseragent($this->_useragent);
        $chain->setNamespace('\\Browscap\\Detector\\Os');
        $chain->setDirectory(
            __DIR__ . DIRECTORY_SEPARATOR . 'Os' . DIRECTORY_SEPARATOR
        );
        
        return $chain->detect();
    }
    
    /**
     * Returns the values of all capabilities for the current device
     * 
     * @return array All Capability values
     */
    public function getCapabilities() 
    {
        return $this->_properties;
    }
}