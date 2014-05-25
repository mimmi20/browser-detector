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

use BrowserDetector\Detector\Bits\Browser;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Engine\BlackBerry;
use BrowserDetector\Detector\Engine\Gecko;
use BrowserDetector\Detector\Engine\Khtml;
use BrowserDetector\Detector\Engine\NetFront;
use BrowserDetector\Detector\Engine\Presto;
use BrowserDetector\Detector\Engine\Tasman;
use BrowserDetector\Detector\Engine\Trident;
use BrowserDetector\Detector\Engine\UnknownEngine;
use BrowserDetector\Detector\Engine\Webkit;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\BrowserInterface;
use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Helper\Utils;

/**
 * base class for all browsers to detect
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
abstract class BrowserHandler
    implements MatcherInterface, BrowserInterface
{
    /**
     * @var string the user agent to handle
     */
    protected $useragent = '';

    /**
     * @var \BrowserDetector\Helper\Utils the helper class
     */
    protected $utils = null;

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
     * @return BrowserHandler
     */
    public function __construct()
    {
        $this->utils = new Utils();

        $this->properties = array(
            // kind of browser
            'browser_type'                 => new BrowserType\Unknown(), // not in wurfl

            'device_claims_web_support'    => false,

            // browser
            'mobile_browser'               => 'unknown',
            'mobile_browser_version'       => null,
            'mobile_browser_bits'          => null, // not in wurfl
            'mobile_browser_manufacturer'  => new Company\Unknown(), // not in wurfl
            'mobile_browser_modus'         => null, // not in wurfl

            // product info
            'can_skip_aligned_link_row'    => false,
            'can_assign_phone_number'      => false,

            // pdf
            'pdf_support'                  => true,

            // cache
            'time_to_live_support'         => null,
            'total_cache_disable_support'  => null,

            // bugs
            'emptyok'                      => false,
            'empty_option_value_support'   => null,
            'basic_authentication_support' => true,
            'post_method_support'          => true,

            // rss
            'rss_support'                  => false,
        );

        $detector = new Version();
        $detector->setVersion('');

        $this->setCapability('mobile_browser_version', $detector);
    }

    /**
     * sets the user agent to be handled
     *
     * @param string $userAgent
     *
     * @return BrowserHandler
     */
    public function setUserAgent($userAgent)
    {
        $this->useragent = $userAgent;
        $this->utils->setUserAgent($userAgent);

        return $this;
    }

    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        return false;
    }

    /**
     * detects the browser name from the given user agent
     *
     * @return BrowserHandler
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
     * @return BrowserHandler
     */
    protected function _detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->useragent);

        $this->setCapability('mobile_browser_version', $detector->setVersion(''));

        return $this;
    }

    /**
     * detects the bit count by this browser from the given user agent
     *
     * @return BrowserHandler
     */
    protected function _detectBits()
    {
        $detector = new Browser();
        $detector->setUserAgent($this->useragent);

        $this->setCapability('mobile_browser_bits', $detector->getBits());

        return $this;
    }

    /**
     * detect the bits of the cpu which is build into the device
     *
     * @return BrowserHandler
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
     *
     * @return string Capability value
     * @throws \InvalidArgumentException
     */
    public function getCapability($capabilityName)
    {
        $this->checkCapability($capabilityName);

        switch ($capabilityName) {
        case 'mobile_browser_version':
            if (!($this->properties['mobile_browser_version'] instanceof Version)) {
                $detector = new Version();
                $detector->setVersion('');

                $this->setCapability('mobile_browser_version', $detector);
            }
            break;
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
     * @param mixed  $capabilityValue
     *
     * @return BrowserHandler
     *
     * @throws \InvalidArgumentException
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
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\EngineHandler
     */
    public function detectEngine()
    {
        $engines = array(
            new Webkit(),
            new Gecko(),
            new Trident(),
            new Presto(),
            new Tasman(),
            new BlackBerry(),
            new Khtml(),
            new NetFront()
        );

        $chain = new Chain();
        $chain->setUseragent($this->useragent);
        $chain->setHandlers($engines);
        $chain->setDefaultHandler(new UnknownEngine());

        $device = $chain->detect();
        return $device->detect();
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
     * @param EngineHandler $engine
     * @param OsHandler     $os
     * @param DeviceHandler $device
     *
     * @return BrowserHandler
     */
    public function detectDependProperties(
        EngineHandler $engine, OsHandler $os, DeviceHandler $device
    ) {
        $engine->detectDependProperties($os, $device, $this);

        return $this;
    }
}