<?php
/**
 * Copyright (c) 2012-2014, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Input;

use BrowserDetector\Detector\Bits as BitsDetector;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Result;
use BrowserDetector\Helper\InputMapper;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
abstract class AbstractBrowscapInput extends Core
{
    /**
     * the location of the local ini file
     *
     * @var string
     */
    protected $localFile = null;

    /**
     * sets the name of the local file
     *
     * @param string $filename the file name
     *
     * @throws Exception
     * @return void
     */
    public function setLocaleFile($filename)
    {
        if (empty($filename)) {
            throw new Exception(
                'the filename can not be empty', Exception::LOCAL_FILE_MISSING
            );
        }

        $localFile = realpath($filename);

        if (false === $localFile) {
            throw new Exception(
                'the filename is invalid: ' . $filename, Exception::LOCAL_FILE_MISSING
            );
        }

        $this->localFile = $localFile;
    }

    /**
     * sets the main parameters to the parser
     *
     * @throws \UnexpectedValueException
     * @return \phpbrowscap\Browscap
     */
    abstract protected function initParser();

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \BrowserDetector\Detector\Result the object containing the browsers details.
     * @throws \UnexpectedValueException
     */
    public function getBrowser()
    {
        throw new \UnexpectedValueException('need to be overwritten by the child classes');
    }

    /**
     * checks the parser result for special keys
     *
     * @param \stdClass $allProperties  The parser result array
     * @param string    $propertyName   The name of the property to detect
     * @param boolean   $depended       If TRUE the parameter $dependingValue has to be set
     * @param string    $dependingValue An master value
     *
     * @return string|integer|boolean The value of the detected property
     */
    protected function detectProperty(
        \stdClass $allProperties, $propertyName, $depended = false,
        $dependingValue = null
    ) {
        $propertyName  = strtolower($propertyName);
        $propertyValue = (empty($allProperties->$propertyName) ? null : trim($allProperties->$propertyName));

        if (empty($propertyValue)
            || '' == $propertyValue
        ) {
            $propertyValue = null;
        }

        if ($depended && null !== $propertyValue && !$dependingValue) {
            $propertyValue = null;
        }

        return $propertyValue;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param \stdClass $parserResult
     *
     * @return \BrowserDetector\Detector\Result the object containing the browsers details.
     */
    protected function setResultData(\stdClass $parserResult)
    {
        $result = new Result();
        $result->setCapability('useragent', $this->_agent);

        $mapper = new InputMapper();

        $browserName    = $this->detectProperty($parserResult, 'browser');
        $browserVersion = $this->detectProperty(
            $parserResult, 'version', true, $browserName
        );

        $browserName    = $mapper->mapBrowserName(trim($browserName));
        $browserVersion = $mapper->mapBrowserVersion(
            trim($browserVersion), $browserName
        );

        $browserBits = $this->detectProperty(
            $parserResult, 'browser_bits', true, $browserName
        );

        $browserMaker = $this->detectProperty(
            $parserResult, 'browser_maker', true, $browserName
        );

        $result->setCapability('mobile_browser', $browserName);
        $result->setCapability('mobile_browser_version', $browserVersion);
        $result->setCapability('mobile_browser_bits', $browserBits);
        $result->setCapability(
            'mobile_browser_manufacturer',
            $mapper->mapBrowserMaker($browserMaker, $browserName)
        );

        if (!empty($parserResult->browser_type)) {
            $browserType = $parserResult->browser_type;
        } else {
            $browserType = null;
        }

        $result->setCapability('browser_type', $mapper->mapBrowserType($browserType, $browserName));

        if (!empty($parserResult->browser_modus) && 'unknown' !== $parserResult->browser_modus) {
            $browserModus = $parserResult->browser_modus;
        } else {
            $browserModus = null;
        }

        $result->setCapability('mobile_browser_modus', $browserModus);

        $platform = $this->detectProperty($parserResult, 'platform');

        $platformVersion = $this->detectProperty(
            $parserResult, 'platform_version', true, $platform
        );

        $platformVersion = $mapper->mapOsVersion(trim($platformVersion), trim($platform));
        $platform        = $mapper->mapOsName(trim($platform));

        $platformbits  = $this->detectProperty(
            $parserResult, 'platform_bits', true, $platform
        );
        $platformMaker = $this->detectProperty(
            $parserResult, 'platform_maker', true, $platform
        );

        $result->setCapability('device_os', $platform);
        $result->setCapability('device_os_version', $platformVersion);
        $result->setCapability('device_os_bits', $platformbits);
        $result->setCapability('device_os_manufacturer', $platformMaker);

        $deviceName = $this->detectProperty($parserResult, 'device_code_name');
        $deviceType = $this->detectProperty($parserResult, 'device_type');

        $result->setCapability('device_type', $mapper->mapDeviceType($deviceType));

        $deviceName = $mapper->mapDeviceName($deviceName);

        $deviceMaker = $this->detectProperty(
            $parserResult, 'device_maker', true, $deviceName
        );

        $deviceMarketingName = $this->detectProperty(
            $parserResult, 'device_name', true, $deviceName
        );

        $deviceBrandName = $this->detectProperty(
            $parserResult, 'device_brand_name', true, $deviceName
        );

        $devicePointingMethod = $this->detectProperty(
            $parserResult, 'device_pointing_method', true, $deviceName
        );

        $result->setCapability('model_name', $deviceName);
        $result->setCapability('marketing_name', $mapper->mapDeviceMarketingName($deviceMarketingName, $deviceName));
        $result->setCapability('brand_name', $mapper->mapDeviceBrandName($deviceBrandName, $deviceName));
        $result->setCapability('manufacturer_name', $mapper->mapDeviceMaker($deviceMaker, $deviceName));
        $result->setCapability('pointing_method', $devicePointingMethod);

        $engineName = $this->detectProperty($parserResult, 'renderingengine_name');

        if ('unknown' === $engineName || '' === $engineName) {
            $engineName = null;
        }

        $engineMaker = $this->detectProperty(
            $parserResult, 'renderingengine_maker', true, $engineName
        );

        $result->setCapability(
            'renderingengine_name', $engineName
        );

        $result->setCapability('renderingengine_manufacturer', $engineMaker);

        $result->setCapability('ux_full_desktop', $deviceType === 'Desktop');
        $result->setCapability('is_smarttv', $deviceType === 'TV Device');
        $result->setCapability('is_tablet', $deviceType === 'Tablet');

        if (!empty($parserResult->ismobiledevice)) {
            $result->setCapability(
                'is_wireless_device', $parserResult->ismobiledevice
            );
        }

        if (!empty($parserResult->istablet)) {
            $result->setCapability('is_tablet', $parserResult->istablet);
        } else {
            $result->setCapability('is_tablet', null);
        }
        $result->setCapability('is_bot', $parserResult->crawler);

        $result->setCapability(
            'is_syndication_reader', $parserResult->issyndicationreader
        );

        if (!empty($parserResult->frames)) {
            $framesSupport = $parserResult->frames;
        } else {
            $framesSupport = null;
        }

        $result->setCapability('xhtml_supports_frame', $mapper->mapFrameSupport($framesSupport));

        if (!empty($parserResult->iframes)) {
            $framesSupport = $parserResult->iframes;
        } else {
            $framesSupport = null;
        }

        $result->setCapability('xhtml_supports_iframe', $mapper->mapFrameSupport($framesSupport));

        if (!empty($parserResult->tables)) {
            $tablesSupport = $parserResult->tables;
        } else {
            $tablesSupport = null;
        }

        $result->setCapability('xhtml_table_support', $tablesSupport);

        if (!empty($parserResult->cookies)) {
            $cookieSupport = $parserResult->cookies;
        } else {
            $cookieSupport = null;
        }

        $result->setCapability('cookie_support', $cookieSupport);

        if (!empty($parserResult->backgroundsounds)) {
            $bgsoundSupport = $parserResult->backgroundsounds;
        } else {
            $bgsoundSupport = null;
        }

        $result->setCapability('supports_background_sounds', $bgsoundSupport);

        if (!empty($parserResult->vbscript)) {
            $vbSupport = $parserResult->vbscript;
        } else {
            $vbSupport = null;
        }

        $result->setCapability('supports_vb_script', $vbSupport);

        if (!empty($parserResult->javascript)) {
            $jsSupport = $parserResult->javascript;
        } else {
            $jsSupport = null;
        }

        $result->setCapability('ajax_support_javascript', $jsSupport);

        if (!empty($parserResult->javaapplets)) {
            $appletsSupport = $parserResult->javaapplets;
        } else {
            $appletsSupport = null;
        }

        $result->setCapability('supports_java_applets', $appletsSupport);

        if (!empty($parserResult->activexcontrols)) {
            $activexSupport = $parserResult->activexcontrols;
        } else {
            $activexSupport = null;
        }

        $result->setCapability('supports_activex_controls', $activexSupport);

        return $result;
    }
}