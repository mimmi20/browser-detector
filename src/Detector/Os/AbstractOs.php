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
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Os;

use BrowserDetector\Detector\Bits\Os as OsBits;
use UaResult\Os\OsInterface;
use BrowserDetector\Version\Version;

/**
 * base class for all rendering platforms/operating systems to detect
 *
 * @category  BrowserDetector
 *
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
abstract class AbstractOs implements OsInterface
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
     * @var \BrowserDetector\Version\Version|null
     */
    protected $version = null;

    /**
     * @var \UaResult\Company\CompanyInterface|null
     */
    protected $manufacturer = null;

    /**
     * @var int|null
     */
    protected $bits = null;

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
     * @return int|null
     */
    public function getBits()
    {
        return $this->bits;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null|\BrowserDetector\Version\Version
     */
    public function getVersion()
    {
        return $this->version;
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
        return serialize(
            [
                'useragent' => $this->useragent,
                'data'      => [
                    'name'         => $this->name,
                    'version'      => $this->version,
                    'manufacturer' => $this->manufacturer,
                    'bits'         => $this->bits,
                ],
            ]
        );
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
        return [
            'useragent' => $this->useragent,
            'data'      => [
                'name'         => $this->name,
                'version'      => $this->version,
                'manufacturer' => $this->manufacturer,
                'bits'         => $this->bits,
            ],
        ];
    }

    /**
     * @param array $data
     */
    protected function setData(array $data)
    {
        $this->name = $data['name'];

        if (!empty($data['version']) && $data['version'] instanceof Version) {
            $this->version = $data['version'];
        } else {
            $this->version = new Version();
        }

        if (!empty($data['manufacturer'])) {
            $this->manufacturer = $data['manufacturer'];
        }

        $detector   = new OsBits($this->useragent);
        $this->bits = $detector->getBits();
    }
}
