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
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Device;

use UaResult\Device\DeviceInterface;
use UaDeviceType\TypeInterface;
use Version\Version;

/**
 * base class for all Devices to detect
 *
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
abstract class AbstractDevice
    implements DeviceInterface
{
    /**
     * @var string the user agent to handle
     */
    protected $useragent = null;

    /**
     * @var \UaHelper\Utils the helper class
     */
    protected $utils = null;

    /**
     * @var string|null
     */
    protected $deviceName = null;

    /**
     * @var string|null
     */
    protected $marketingName = null;

    /**
     * @var \Version\Version|null
     */
    protected $version = null;

    /**
     * @var \UaResult\Company\CompanyInterface|null
     */
    protected $manufacturer = null;

    /**
     * @var string|null
     */
    protected $brand = null;

    /**
     * @var string|null
     */
    protected $formFactor = null;

    /**
     * @var string|null
     */
    protected $pointingMethod = null;

    /**
     * @var int|null
     */
    protected $resolutionWidth = null;

    /**
     * @var int|null
     */
    protected $resolutionHeight = null;

    /**
     * @var bool|null
     */
    protected $dualOrientation = null;

    /**
     * @var int|null
     */
    protected $colors = null;

    /**
     * @var bool|null
     */
    protected $smsSupport = null;

    /**
     * @var bool|null
     */
    protected $nfcSupport = null;

    /**
     * @var bool|null
     */
    protected $hasQwertyKeyboard = null;

    /**
     * @var \UaDeviceType\TypeInterface|null
     */
    protected $type = null;

    /**
     * the class constructor
     *
     * @param string                   $useragent
     * @param array                    $data
     */
    public function __construct(
        $useragent,
        array $data
    ) {
        $this->useragent = $useragent;

        $this->setData($data);
    }

    /**
     * @return null|string
     */
    public function getDeviceName()
    {
        return $this->deviceName;
    }

    /**
     * @return null|string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return int|null
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * @return bool|null
     */
    public function getDualOrientation()
    {
        return $this->dualOrientation;
    }

    /**
     * @return null|string
     */
    public function getFormFactor()
    {
        return $this->formFactor;
    }

    /**
     * @return bool|null
     */
    public function getHasQwertyKeyboard()
    {
        return $this->hasQwertyKeyboard;
    }

    /**
     * @return null|\UaResult\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @return null|string
     */
    public function getMarketingName()
    {
        return $this->marketingName;
    }

    /**
     * @return bool|null
     */
    public function getNfcSupport()
    {
        return $this->nfcSupport;
    }

    /**
     * @return null|string
     */
    public function getPointingMethod()
    {
        return $this->pointingMethod;
    }

    /**
     * @return int|null
     */
    public function getResolutionHeight()
    {
        return $this->resolutionHeight;
    }

    /**
     * @return int|null
     */
    public function getResolutionWidth()
    {
        return $this->resolutionWidth;
    }

    /**
     * @return bool|null
     */
    public function getSmsSupport()
    {
        return $this->smsSupport;
    }

    /**
     * @return string
     */
    public function getUseragent()
    {
        return $this->useragent;
    }

    /**
     * @return null|\Version\Version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return null|\UaDeviceType\TypeInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     *
     * @link http://php.net/manual/en/serializable.serialize.php
     *
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->getData());
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     *
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $data <p>
     *                     The string representation of the object.
     *                     </p>
     */
    public function unserialize($data)
    {
        $unseriliazedData = unserialize($data);

        $this->useragent = $unseriliazedData['useragent'];
        $this->setData($unseriliazedData['data']);
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return $this->getData();
    }

    /**
     * @return array
     */
    protected function getData()
    {
        return [
            'useragent' => $this->useragent,
            'data'      => [
                'deviceName'        => $this->deviceName,
                'marketingName'     => $this->marketingName,
                'version'           => $this->version,
                'manufacturer'      => $this->manufacturer,
                'brand'             => $this->brand,
                'formFactor'        => $this->formFactor,
                'pointingMethod'    => $this->pointingMethod,
                'resolutionWidth'   => $this->resolutionWidth,
                'resolutionHeight'  => $this->resolutionHeight,
                'dualOrientation'   => $this->dualOrientation,
                'colors'            => $this->colors,
                'smsSupport'        => $this->smsSupport,
                'nfcSupport'        => $this->nfcSupport,
                'hasQwertyKeyboard' => $this->hasQwertyKeyboard,
                'type'              => $this->type,
            ],
        ];
    }

    /**
     * @param array $data
     */
    protected function setData(array $data)
    {
        $this->deviceName = $data['deviceName'];

        if (!empty($data['marketingName'])) {
            $this->marketingName = $data['marketingName'];
        }

        if (!empty($data['version']) && $data['version'] instanceof Version) {
            $this->version = $data['version'];
        }

        if (!empty($data['manufacturer'])) {
            $this->manufacturer = $data['manufacturer'];
        }

        if (!empty($data['brand'])) {
            $this->brand = $data['brand'];
        }

        if (!empty($data['formFactor'])) {
            $this->formFactor = $data['formFactor'];
        }

        if (!empty($data['pointingMethod'])) {
            $this->pointingMethod = $data['pointingMethod'];
        }

        if (!empty($data['resolutionWidth'])) {
            $this->resolutionWidth = $data['resolutionWidth'];
        }

        if (!empty($data['resolutionHeight'])) {
            $this->resolutionHeight = $data['resolutionHeight'];
        }

        if (!empty($data['dualOrientation'])) {
            $this->dualOrientation = $data['dualOrientation'];
        }

        if (!empty($data['colors'])) {
            $this->colors = $data['colors'];
        }

        if (!empty($data['smsSupport'])) {
            $this->smsSupport = $data['smsSupport'];
        }

        if (!empty($data['nfcSupport'])) {
            $this->nfcSupport = $data['nfcSupport'];
        }

        if (!empty($data['hasQwertyKeyboard'])) {
            $this->hasQwertyKeyboard = $data['hasQwertyKeyboard'];
        }

        if (!empty($data['type']) && $data['type'] instanceof TypeInterface) {
            $this->type = $data['type'];
        }
    }
}
