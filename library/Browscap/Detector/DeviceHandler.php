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
use \Browscap\Detector\MatcherInterface\DeviceInterface;
use \Browscap\Detector\BrowserHandler;
use \Browscap\Detector\EngineHandler;
use \Browscap\Detector\OsHandler;

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
abstract class DeviceHandler implements MatcherInterface, DeviceInterface
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
     * @var array
     */
    protected $_properties = array(
        'wurflKey' => null, // not in wurfl
        
        // kind of device
        'is_wireless_device' => false,
        'is_tablet'          => false,
        // 'is_bot'             => false,
        'is_smarttv'         => false,
        'is_console'         => false,
        'ux_full_desktop'    => false,
        // 'is_transcoder'      => false,
        
        // device
        'model_name'                => 'unknown',
        'model_version'             => null, // not in wurfl
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
        
        // product info
        'can_skip_aligned_link_row' => null,
        'can_assign_phone_number'   => false,
        'nokia_feature_pack'        => 0,
        'nokia_series'              => 0,
        'nokia_edition'             => 0,
        'ununiqueness_handler'      => null,
        'uaprof'                    => null,
        'uaprof2'                   => null,
        'uaprof3'                   => null,
        'unique'                    => true,
        
        // display
        'physical_screen_width'  => 27,
        'physical_screen_height' => 27,
        'columns'                => 11,
        'rows'                   => 6,
        'max_image_width'        => 90,
        'max_image_height'       => 35,
        'resolution_width'       => 90,
        'resolution_height'      => 40,
        'dual_orientation'       => false,
    );
    
    /**
     * Class Constructor
     *
     * @return DeviceHandler
     */
    public function __construct()
    {
        $this->_utils = new Utils();
    }
    
    /**
     * sets the user agent to be handled
     *
     * @return DeviceHandler
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
     * @return DeviceHandler
     */
    public function detect()
    {
        $device = $this->detectDevice();
        
        return $device
            ->_detectCpu()
            ->_detectBits()
            ->_detectDeviceVersion()
            ->_parseProperties()
        ;
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @param string $userAgent
     *
     * @return DeviceHandler
     */
    public function detectDevice()
    {
        return $this;
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @return DeviceHandler
     */
    protected function _detectDeviceVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->_useragent);
        $detector->ignoreMinorVersion(true);
        
        $this->setCapability(
            'model_version', $detector->setVersion('')
        );
        return $this;
    }
    
    /**
     * detect the cpu which is build into the device
     *
     * @return DeviceHandler
     */
    protected function _detectCpu()
    {
        $detector = new \Browscap\Detector\Cpu();
        $detector->setUserAgent($this->_useragent);
        
        $this->setCapability('device_cpu', $detector->getCpu());
        
        return $this;
    }
    
    /**
     * detect the bits of the cpu which is build into the device
     *
     * @return DeviceHandler
     */
    protected function _detectBits()
    {
        $detector = new \Browscap\Detector\Bits\Device();
        $detector->setUserAgent($this->_useragent);
        
        $this->setCapability('device_bits', $detector->getBits());
        
        return $this;
    }
    
    /**
     * detects properties who are depending on the device version or the user 
     * agent
     *
     * @return DeviceHandler
     */
    protected function _parseProperties()
    {
        return $this;
    }
    
    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @return DeviceHandler
     */
    public function detectDependProperties(
        BrowserHandler $browser, EngineHandler $engine, OsHandler $os)
    {
        $browser->detectDependProperties($engine, $os);
        $os->detectDependProperties($browser, $engine);
        
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
     * @return DeviceHandler
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
     * @return void
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