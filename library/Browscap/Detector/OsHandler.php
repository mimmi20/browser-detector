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
use \Browscap\Detector\MatcherInterface\OsInterface;
use \Browscap\Detector\BrowserHandler;
use \Browscap\Detector\EngineHandler;

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
abstract class OsHandler
    implements MatcherInterface, OsInterface
{
    /**
     * @var string the user agent to handle
     */
    protected $_useragent = '';
    
    /**
     * @var \Browscap\Helper\Utils the helper class
     */
    protected $utils = null;
    
    /**
     * a \Zend\Cache object
     *
     * @var \Zend\Cache
     */
    protected $cache = null;
    
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array();
    
    /**
     * Class Constructor
     *
     * @return OsHandler
     */
    public function __construct()
    {
        $this->utils = new Utils();
        
        $this->properties = array(
            // os
            'device_os'              => 'unknown',
            'device_os_version'      => '',
            'device_os_bits'         => '', // not in wurfl
            'device_os_manufacturer' => new Company\Unknown(), // not in wurfl
        );
        
        $detector = new Version();
        $detector->setVersion('');
        
        $this->setCapability('device_os_version', $detector);
    }
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        $this->utils->setUserAgent($userAgent);
        
        return $this;
    }
    
    /**
     * Returns true if this handler can handle the given useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        return false;
    }
    
    /**
     * detects the operating system name (platform) from the given user agent
     *
     * @return StdClass
     */
    public function detect()
    {
        $this->_detectVersion();
        $this->_detectBits();
        $this->_detectProperties();
        
        return $this;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $this->_useragent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $detector = new \Browscap\Detector\Version();
        $detector->setUserAgent($this->_useragent);
        
        $this->setCapability('device_os_version', $detector->setVersion(''));
    }
    
    /**
     * detects the bit count by this browser from the given user agent
     *
     * @param string $this->_useragent
     *
     * @return string
     */
    protected function _detectBits()
    {
        $detector = new \Browscap\Detector\Bits\Os();
        $detector->setUserAgent($this->_useragent);
        
        $this->setCapability('device_os_bits', $detector->getBits());
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
        $this->checkCapability($capabilityName);
        
        switch ($capabilityName) {
            case 'device_os_version':
                if (!($this->properties['device_os_version'] instanceof Version)) {
                    $detector = new Version();
                    $detector->setVersion('');
                    
                    $this->setCapability('device_os_version', $detector);
                }
            default:
                // nothing to do here
                break;
        }
        
        return $this->properties[$capabilityName];
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
        $this->checkCapability($capabilityName);
        
        $this->properties[$capabilityName] = $capabilityValue;
        
        return $this;
    }
    
    /**
     * Returns the value of a given capability name
     * for the current device
     * 
     * @param string $capabilityName must be a valid capability name
     * @return string Capability value
     * @throws InvalidArgumentException The $capabilityName is is not defined in the loaded WURFL.
     * @see WURFL_Xml_ModelDevice::getCapability()
     */
    protected function checkCapability($capabilityName) 
    {
        if (empty($capabilityName)) {
            throw new \InvalidArgumentException(
                'capability name must not be empty'
            );
        }
        
        if (!array_key_exists($capabilityName, $this->properties)) {
            throw new \InvalidArgumentException(
                'no capability named [' . $capabilityName . '] is present.'
            );    
        }
    }
    
    /**
     * Returns the values of all capabilities for the current device
     * 
     * @return array All Capability values
     */
    public function getCapabilities() 
    {
        return $this->properties;
    }
    
    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @return DeviceHandler
     */
    public function detectDependProperties(
        BrowserHandler $browser, EngineHandler $engine, DeviceHandler $device)
    {
        return $this;
    }
    
    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectBrowser()
    {
        return null;
    }
}