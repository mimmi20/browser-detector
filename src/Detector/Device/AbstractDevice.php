<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Device;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface\Device\DeviceInterface;
use BrowserDetector\Detector\MatcherInterface\MatcherCanHandleInterface;
use BrowserDetector\Detector\MatcherInterface\MatcherHasCapabilitiesInterface;
use BrowserDetector\Detector\MatcherInterface\MatcherHasWeightInterface;
use BrowserDetector\Detector\MatcherInterface\MatcherInterface;
use BrowserDetector\Detector\Result\Result;
use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\Utils;
use Psr\Log\LoggerInterface;

/**
 * base class for all Devices to detect
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @property-read string  $deviceClass
 * @property-read string  $userAgent
 * @property-read string  $fallBack
 * @property-read boolean $actualDeviceRoot
 */
abstract class AbstractDevice implements MatcherInterface, MatcherCanHandleInterface, MatcherHasCapabilitiesInterface, MatcherHasWeightInterface, DeviceInterface, \Serializable
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
     * should the device render the content like another?
     *
     * @var Result
     */
    protected $renderAs = null;

    /**
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger = null;

    /**
     * device version
     *
     * @var \BrowserDetector\Detector\Version
     */
    protected $version = null;

    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        // device
        'model_name'             => 'unknown',
        'model_extra_info'       => null,
        'marketing_name'         => null,
        'has_qwerty_keyboard'    => null,
        'pointing_method'        => null,
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => null,
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
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
        'colors'                 => 65536,
        // chips
        'nfc_support'            => null,
    );

    /**
     * Class Constructor
     *
     * @return AbstractDevice
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * initializes the object
     */
    protected function init()
    {
        $this->utils = new Utils();
    }

    /**
     * sets the user agent to be handled
     *
     * @param string $userAgent
     *
     * @return AbstractDevice
     */
    public function setUserAgent($userAgent)
    {
        $this->useragent = $userAgent;
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
    public function detectVersion()
    {
        if (null === $this->version) {
            $detector = new Version();
            $detector->setUserAgent($this->useragent);
            $detector->setMode(Version::COMPLETE | Version::IGNORE_MICRO_IF_EMPTY);

            $this->version = $detector->setVersion('');
        }

        return $this->version;
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
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Type\Device\TypeInterface
     */
    public function getDeviceType()
    {
        return new DeviceType\Unknown();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Unknown();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\Unknown();
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
     * @return AbstractDevice
     */
    public function setCapability(
        $capabilityName,
        $capabilityValue = null
    ) {
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
     * @var \BrowserDetector\Detector\Result\Result $result
     *
     * @return AbstractDevice
     */
    public function setRenderAs(Result $result)
    {
        $this->renderAs = $result;

        return $this;
    }

    /**
     * sets a second device for rendering properties
     *
     * @return \BrowserDetector\Detector\Result\Result
     */
    public function getRenderAs()
    {
        return $this->renderAs;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return AbstractDevice
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(
            array(
                'properties' => $this->properties,
                'userAgent'  => $this->useragent,
                'renderAs'   => $this->renderAs,
                'version'    => $this->version,
            )
        );
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        $unseriliazedData = unserialize($serialized);

        foreach ($unseriliazedData['properties'] as $property => $value) {
            $this->properties[$property] = $value;
        }

        $this->init();
        $this->setUserAgent($unseriliazedData['userAgent']);

        $this->renderAs = $unseriliazedData['renderAs'];
        $this->version  = $unseriliazedData['version'];
    }
}
