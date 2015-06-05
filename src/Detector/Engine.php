<?php
/**
 * Copyright (c) 2012-2014, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
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
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector;

use BrowserDetector\Detector\Company;

/**
 * Engine
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Engine
{
    /**
     * @var string
     */
    private $name = null;

    /**
     * @var \BrowserDetector\Detector\Company\CompanyInterface
     */
    private $manufacturer = null;

    /**
     * @var \BrowserDetector\Detector\Version
     */
    private $version = null;

    /**
     * @var boolean
     */
    private $transcoder = null;

    /**
     * the detected browser properties
     *
     * @var array
     */
    private $properties = array();

    /**
     * @param string                                             $name
     * @param \BrowserDetector\Detector\Company\CompanyInterface $manufacturer
     * @param \BrowserDetector\Detector\Version                  $version
     * @param boolean                                            $transcoder
     * @param array                                              $properties
     */
    public function __construct($name, Company\CompanyInterface $manufacturer, Version $version, $transcoder, array $properties)
    {
        $this->name = $name;
        $this->manufacturer = $manufacturer;
        $this->version = $version;
        $this->transcoder = $transcoder;
        $this->properties = $properties;
    }

    /**
     * gets the name of the platform
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * gets the maker of the platform
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @return \BrowserDetector\Detector\Version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return bool
     */
    public function isTranscoder()
    {
        return $this->transcoder;
    }

    /**
     * Returns the value of a given capability name
     * for the current device
     *
     * @param string $capabilityName must be a valid capability name
     *
     * @return string|int|bool|null Capability value
     * @throws \InvalidArgumentException
     */
    public function getCapability($capabilityName)
    {
        if (!array_key_exists($capabilityName, $this->properties)) {
             return null;
        }

        return $this->properties[$capabilityName];
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
}
