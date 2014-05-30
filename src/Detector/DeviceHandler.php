<?php
namespace BrowserDetector\Detector;

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
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Helper\Utils;

/**
 * base class for all Devices to detect
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
abstract class DeviceHandler
    implements DeviceInterface
{
    /**
     * @var string the user agent to handle
     */
    protected $_useragent = '';

    /**
     * @var \BrowserDetector\Helper\Utils the helper class
     */
    protected $utils = null;

    /**
     * should the device render the content like another?
     *
     * @var \BrowserDetector\Detector\Result
     */
    protected $renderAs = null;

    /**
     * a Cache object
     *
     * @var \WurflCache\Adapter\AdapterInterface
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
     * @return DeviceHandler
     */
    public function __construct()
    {
        $this->utils = new Utils();

        $this->properties = array(
            'wurflKey'                  => null, // not in wurfl

            // kind of device
            'device_type'               => new DeviceType\Unknown(), // not in wurfl

            // device
            'model_name'                => 'unknown',
            'manufacturer_name'         => new Company\Unknown(),
            'brand_name'                => new Company\Unknown(),
            'model_extra_info'          => null,
            'marketing_name'            => null,
            'has_qwerty_keyboard'       => null,
            'pointing_method'           => null,
            'device_claims_web_support' => null,

            // product info
            'can_skip_aligned_link_row' => null,
            'can_assign_phone_number'   => false,
            'ununiqueness_handler'      => null,
            'uaprof'                    => null,
            'uaprof2'                   => null,
            'uaprof3'                   => null,
            'unique'                    => true,

            // display
            'physical_screen_width'     => 27,
            'physical_screen_height'    => 27,
            'columns'                   => 11,
            'rows'                      => 6,
            'max_image_width'           => 90,
            'max_image_height'          => 35,
            'resolution_width'          => 90,
            'resolution_height'         => 40,
            'dual_orientation'          => false,
            'colors'                    => 65536,

            // chips
            'nfc_support'               => null,
        );
    }

    /**
     * sets the user agent to be handled
     *
     * @param string $userAgent
     *
     * @return DeviceHandler
     */
    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        $this->utils->setUserAgent($userAgent);

        return $this;
    }

    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        return false;
    }

    /**
     * detects the device name from the given user agent
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function getDeviceVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->_useragent);
        $detector->setMode(Version::COMPLETE | Version::IGNORE_MICRO_IF_EMPTY);

        return $detector->setVersion('');
    }

    /**
     * detects properties who are depending on the device version or the user
     * agent
     *
     * @return DeviceHandler
     */
    public function detectSpecialProperties()
    {
        return $this;
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param BrowserHandler $browser
     * @param EngineHandler  $engine
     * @param OsHandler      $os
     *
     * @return DeviceHandler
     */
    public function detectDependProperties(
        BrowserHandler $browser, EngineHandler $engine, OsHandler $os
    ) {
        $browser->detectDependProperties($engine, $os, $this);
        $os->detectDependProperties($browser, $engine, $this);

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
     *
     * @return string Capability value
     * @throws \InvalidArgumentException
     */
    public function getCapability($capabilityName)
    {
        $this->checkCapability($capabilityName);

        return $this->properties[$capabilityName];
    }

    /**
     * Returns the value of a given capability name
     * for the current device
     *
     * @param string $capabilityName must be a valid capability name
     *
     * @param null   $capabilityValue
     *
     * @return DeviceHandler
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
     *
     * @throws \InvalidArgumentException
     * @return void
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
     * Magic Method
     *
     * @param string $name
     *
     * @throws \InvalidArgumentException
     * @return string
     */
    public function __get($name)
    {
        if (isset($name)) {
            switch ($name) {
            case 'id':
                return $this->getCapability('wurflKey');
                break;
            case 'userAgent':
                return $this->getCapability('useragent');
                break;
            case 'deviceClass':
                return $this->getCapability('deviceClass');
                break;
            case 'fallBack':
            case 'actualDeviceRoot':
                return null;
                break;
            default:
                // nothing to do here
                break;
            }
        }

        throw new \InvalidArgumentException(
            'the property "' . $name . '" is not defined'
        );
    }

    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\OsHandler
     */
    public function detectBrowser()
    {
        $browser = new Browser\UnknownBrowser();
        $browser->setUserAgent($this->_useragent);

        return $browser->detect();
    }

    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\OsHandler
     */
    public function detectOs()
    {
        $chain = new Chain();
        $chain->setDefaultHandler(new Os\UnknownOs());
        $chain->setUseragent($this->_useragent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Os');
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
        return $this->properties;
    }

    /**
     * sets a second device for rendering properties
     *
     * @var \BrowserDetector\Detector\Result $result
     *
     * @return DeviceHandler
     */
    public function setRenderAs(Result $result)
    {
        $this->renderAs = $result;

        return $this;
    }

    /**
     * sets a second device for rendering properties
     *
     * @return \BrowserDetector\Detector\Result
     */
    public function getRenderAs()
    {
        return $this->renderAs;
    }
}