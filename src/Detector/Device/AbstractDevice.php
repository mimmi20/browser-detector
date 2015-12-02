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
use BrowserDetector\Detector\Result\Result;
use UaMatcher\MatcherCanHandleInterface;
use UaMatcher\MatcherHasWeightInterface;
use UaResult\Version;
use Psr\Log\LoggerInterface;
use UaHelper\Utils;
use UaMatcher\Device\DeviceInterface;
use UaMatcher\Result\ResultInterface;
use BrowserDetector\Detector\Bits\Device as DeviceBits;

/**
 * base class for all Devices to detect
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @property-read string  $deviceClass
 * @property-read string  $useragent
 * @property-read string  $fallBack
 * @property-read boolean $actualDeviceRoot
 */
abstract class AbstractDevice
    implements DeviceInterface, \Serializable, MatcherHasWeightInterface, MatcherCanHandleInterface
{
    /**
     * @var string the user agent to handle
     */
    protected $useragent = '';

    /**
     * @var \UaHelper\Utils the helper class
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
     * @var \UaResult\Version
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
     * @param string                   $useragent the user agent to be handled
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct($useragent = null, LoggerInterface $logger = null)
    {
        $this->init($useragent);

        $this->logger = $logger;
    }

    /**
     * initializes the object
     * @param string $useragent
     */
    protected function init($useragent)
    {
        $this->utils = new Utils();

        $this->useragent = $useragent;
        $this->utils->setUserAgent($useragent);
    }

    /**
     * sets the actual user agent
     *
     * @param string $agent
     *
     * @return \UaMatcher\MatcherInterface
     */
    public function setUseragent($agent)
    {
        $this->useragent = $agent;
        $this->utils->setUserAgent($agent);

        return $this;
    }

    /**
     * sets the logger
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \UaMatcher\MatcherInterface
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

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
     * @return \UaResult\Version
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
     * @return \UaDeviceType\TypeInterface
     */
    public function getDeviceType()
    {
        return new \UaDeviceType\Unknown();
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
     * @return DeviceInterface
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
                case 'useragent':
                    return $this->useragent;
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
     * @var \UaMatcher\Result\ResultInterface $result
     *
     * @return DeviceInterface
     */
    public function setRenderAs(ResultInterface $result)
    {
        $this->renderAs = $result;

        return $this;
    }

    /**
     * sets a second device for rendering properties
     *
     * @return \UaMatcher\Result\ResultInterface
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
                'useragent'  => $this->useragent,
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

        $this->init($unseriliazedData['useragent']);

        $this->renderAs = $unseriliazedData['renderAs'];
        $this->version  = $unseriliazedData['version'];
    }

    /**
     * @return string
     */
    public function detectBits()
    {
        $detector = new DeviceBits($this->useragent);

        return $detector->getBits();
    }
}
