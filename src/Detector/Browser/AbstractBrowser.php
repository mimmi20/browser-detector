<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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

namespace BrowserDetector\Detector\Browser;

use BrowserDetector\Detector\Bits\Browser as BrowserBits;
use UaBrowserType\TypeInterface;
use UaResult\Browser\BrowserInterface;
use Version\Version;

/**
 * base class for all browsers to detect
 *
 * @category  BrowserDetector
 *
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
abstract class AbstractBrowser implements BrowserInterface
{
    /**
     * @var string the user agent to handle
     */
    protected $useragent = '';

    /**
     * @var string|null
     */
    protected $name = null;

    /**
     * @var string|null
     */
    protected $modus = null;

    /**
     * @var \Version\Version|null
     */
    protected $version = null;

    /**
     * @var \UaResult\Company\CompanyInterface|null
     */
    protected $manufacturer = null;

    /**
     * @var bool|null
     */
    protected $pdfSupport = null;

    /**
     * @var bool|null
     */
    protected $rssSupport = null;

    /**
     * @var bool|null
     */
    protected $canSkipAlignedLinkRow = null;

    /**
     * @var bool|null
     */
    protected $claimsWebSupport = null;

    /**
     * @var bool|null
     */
    protected $supportsEmptyOptionValues = null;

    /**
     * @var bool|null
     */
    protected $supportsBasicAuthentication = null;

    /**
     * @var bool|null
     */
    protected $supportsPostMethod = null;

    /**
     * @var int|null
     */
    protected $bits = null;

    /**
     * @var \UaBrowserType\TypeInterface|null
     */
    protected $type = null;

    /**
     * Class Constructor
     *
     * @param string $useragent the user agent to be handled
     * @param array  $data
     */
    public function __construct(
        $useragent,
        array $data
    ) {
        $this->useragent = $useragent;

        $this->setData($data);
    }

    /**
     * gets the name of the browser
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool|null
     */
    public function getCanSkipAlignedLinkRow()
    {
        return $this->canSkipAlignedLinkRow;
    }

    /**
     * @return bool|null
     */
    public function getClaimsWebSupport()
    {
        return $this->claimsWebSupport;
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
    public function getModus()
    {
        return $this->modus;
    }

    /**
     * @return bool|null
     */
    public function getPdfSupport()
    {
        return $this->pdfSupport;
    }

    /**
     * @return bool|null
     */
    public function getRssSupport()
    {
        return $this->rssSupport;
    }

    /**
     * @return bool|null
     */
    public function getSupportsBasicAuthentication()
    {
        return $this->supportsBasicAuthentication;
    }

    /**
     * @return bool|null
     */
    public function getSupportsEmptyOptionValues()
    {
        return $this->supportsEmptyOptionValues;
    }

    /**
     * @return bool|null
     */
    public function getSupportsPostMethod()
    {
        return $this->supportsPostMethod;
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
     * @return int|null
     */
    public function getBits()
    {
        return $this->bits;
    }

    /**
     * @return null|\UaBrowserType\TypeInterface
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
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     */
    public function unserialize($serialized)
    {
        $unseriliazedData = unserialize($serialized);

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
                'name'                        => $this->name,
                'modus'                       => $this->modus,
                'version'                     => $this->version,
                'manufacturer'                => $this->manufacturer,
                'pdfSupport'                  => $this->pdfSupport,
                'rssSupport'                  => $this->rssSupport,
                'canSkipAlignedLinkRow'       => $this->canSkipAlignedLinkRow,
                'claimsWebSupport'            => $this->claimsWebSupport,
                'supportsEmptyOptionValues'   => $this->supportsEmptyOptionValues,
                'supportsBasicAuthentication' => $this->supportsBasicAuthentication,
                'supportsPostMethod'          => $this->supportsPostMethod,
                'bits'                        => $this->bits,
                'type'                        => $this->type,
            ],
        ];
    }

    /**
     * @param array $data
     */
    protected function setData(array $data)
    {
        $this->name = $data['name'];

        if (!empty($data['modus'])) {
            $this->modus = $data['modus'];
        }

        if (!empty($data['version']) && $data['version'] instanceof Version) {
            $this->version = $data['version'];
        }

        if (!empty($data['manufacturer'])) {
            $this->manufacturer = $data['manufacturer'];
        }

        if (!empty($data['pdfSupport'])) {
            $this->pdfSupport = $data['pdfSupport'];
        }

        if (!empty($data['rssSupport'])) {
            $this->rssSupport = $data['rssSupport'];
        }

        if (!empty($data['canSkipAlignedLinkRow'])) {
            $this->canSkipAlignedLinkRow = $data['canSkipAlignedLinkRow'];
        }

        if (!empty($data['claimsWebSupport'])) {
            $this->claimsWebSupport = $data['claimsWebSupport'];
        }

        if (!empty($data['supportsEmptyOptionValues'])) {
            $this->supportsEmptyOptionValues = $data['supportsEmptyOptionValues'];
        }

        if (!empty($data['supportsBasicAuthentication'])) {
            $this->supportsBasicAuthentication = $data['supportsBasicAuthentication'];
        }

        if (!empty($data['supportsPostMethod'])) {
            $this->supportsPostMethod = $data['supportsPostMethod'];
        }

        $detector   = new BrowserBits($this->useragent);
        $this->bits = $detector->getBits();

        if (!empty($data['type']) && $data['type'] instanceof TypeInterface) {
            $this->type = $data['type'];
        }
    }
}
