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
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\InputMapper;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
abstract class AbstractBrowscapInput extends Core
{
    /**
     * the Browscap parser class
     *
     * @var \phpbrowscap\Browscap|\phpbrowscap\Detector
     */
    protected $parser = null;

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
    protected function initParser()
    {
        return $this->parser;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \BrowserDetector\Detector\Result the object containing the browsers details.
     * @throws \UnexpectedValueException
     */
    public function getBrowser()
    {
        $parserResult = $this->initParser()->getBrowser($this->_agent, true);

        $result = new Result();
        $result->setCapability('useragent', $this->_agent);

        $mapper = new InputMapper();

        $browserName = $this->detectProperty($parserResult, 'Browser');
        $browserVersion = $this->detectProperty(
            $parserResult, 'Version', true, $browserName
        );

        $browserName    = $mapper->mapBrowserName(trim($browserName));
        $browserVersion = $mapper->mapBrowserVersion(
            trim($browserVersion), $browserName
        );

        $browserBits = $this->detectProperty(
            $parserResult, 'Browser_Bits', true, $browserName
        );

        $browserMaker = $this->detectProperty(
            $parserResult, 'Browser_Maker', true, $browserName
        );

        $result->setCapability('mobile_browser', $browserName);
        $result->setCapability('mobile_browser_version', $browserVersion);
        $result->setCapability('mobile_browser_bits', $browserBits);
        $result->setCapability(
            'mobile_browser_manufacturer',
            $mapper->mapBrowserMaker($browserMaker, $browserName)
        );

        if (!empty($parserResult['Browser_Type'])) {
            $browserType = $parserResult['Browser_Type'];
        } else {
            $browserType = null;
        }

        $result->setCapability('browser_type', $browserType);

        if (!empty($parserResult['Browser_Modus']) && 'unknown' !== $parserResult['Browser_Modus']) {
            $browserModus = $parserResult['Browser_Modus'];
        } else {
            $browserModus = '';
        }

        $result->setCapability('mobile_browser_modus', $browserModus);

        $platform = $this->detectProperty($parserResult, 'Platform');

        $platformVersion = $this->detectProperty(
            $parserResult, 'Platform_Version', true, $platform
        );

        $platformVersion = $mapper->mapOsVersion(trim($platformVersion), trim($platform));
        $platform        = $mapper->mapOsName(trim($platform));

        $platformbits  = $this->detectProperty(
            $parserResult, 'Platform_Bits', true, $platform
        );
        $platformMaker = $this->detectProperty(
            $parserResult, 'Platform_Maker', true, $platform
        );

        $result->setCapability('device_os', $platform);
        $result->setCapability('device_os_version', $platformVersion);
        $result->setCapability('device_os_bits', $platformbits);
        $result->setCapability('device_os_manufacturer', $platformMaker);

        $deviceName = $this->detectProperty($parserResult, 'Device_Code_Name');
        $deviceType = $this->detectProperty($parserResult, 'Device_Type');

        $result->setCapability('device_type', $mapper->mapDeviceType($deviceType));

        $deviceName = $mapper->mapDeviceName($deviceName);

        $deviceMaker = $this->detectProperty(
            $parserResult, 'Device_Maker', true, $deviceName
        );

        $deviceMarketingName = $this->detectProperty(
            $parserResult, 'Device_Name', true, $deviceName
        );

        $deviceBrandName = $this->detectProperty(
            $parserResult, 'Device_Brand_Name', true, $deviceName
        );

        $devicePointingMethod = $this->detectProperty(
            $parserResult, 'Device_Pointing_Method', true, $deviceName
        );

        $result->setCapability('model_name', $deviceName);
        $result->setCapability('marketing_name', $mapper->mapDeviceMarketingName($deviceMarketingName, $deviceName));
        $result->setCapability('brand_name', $mapper->mapDeviceBrandName($deviceBrandName, $deviceName));
        $result->setCapability('manufacturer_name', $mapper->mapDeviceMaker($deviceMaker, $deviceName));
        $result->setCapability('pointing_method', $devicePointingMethod);

        $engineName = $this->detectProperty($parserResult, 'RenderingEngine_Name');

        if ('unknown' === $engineName || '' === $engineName) {
            $engineName = null;
        }

        $engineMaker = $this->detectProperty(
            $parserResult, 'RenderingEngine_Maker', true, $engineName
        );

        $result->setCapability(
            'renderingengine_name', $engineName
        );

        $result->setCapability('renderingengine_manufacturer', $engineMaker);

        $result->setCapability('ux_full_desktop', $deviceType === 'Desktop');
        $result->setCapability('is_smarttv', $deviceType === 'TV Device');
        $result->setCapability('is_tablet', $deviceType === 'Tablet');

        if (array_key_exists('isMobileDevice', $parserResult)) {
            $result->setCapability(
                'is_wireless_device', $parserResult['isMobileDevice']
            );
        }

        if (isset($parserResult['isTablet'])) {
            $result->setCapability('is_tablet', $parserResult['isTablet']);
        } else {
            $result->setCapability('is_tablet', false);
        }
        $result->setCapability('is_bot', $parserResult['Crawler']);

        $result->setCapability(
            'is_syndication_reader', $parserResult['isSyndicationReader']
        );

        if (!empty($parserResult['Frames'])) {
            $framesSupport = $parserResult['Frames'];
        } else {
            $framesSupport = null;
        }

        $result->setCapability('xhtml_supports_frame', $mapper->mapFrameSupport($framesSupport));

        if (!empty($parserResult['IFrames'])) {
            $framesSupport = $parserResult['IFrames'];
        } else {
            $framesSupport = null;
        }

        $result->setCapability('xhtml_supports_iframe', $mapper->mapFrameSupport($framesSupport));

        if (!empty($parserResult['Tables'])) {
            $tablesSupport = $parserResult['Tables'];
        } else {
            $tablesSupport = null;
        }

        $result->setCapability('xhtml_table_support', $tablesSupport);

        if (!empty($parserResult['Cookies'])) {
            $cookieSupport = $parserResult['Cookies'];
        } else {
            $cookieSupport = null;
        }

        $result->setCapability('cookie_support', $cookieSupport);

        if (!empty($parserResult['BackgroundSounds'])) {
            $bgsoundSupport = $parserResult['BackgroundSounds'];
        } else {
            $bgsoundSupport = null;
        }

        $result->setCapability('supports_background_sounds', $bgsoundSupport);

        if (!empty($parserResult['VBScript'])) {
            $vbSupport = $parserResult['VBScript'];
        } else {
            $vbSupport = null;
        }

        $result->setCapability('supports_vb_script', $vbSupport);

        if (!empty($parserResult['JavaScript'])) {
            $jsSupport = $parserResult['JavaScript'];
        } else {
            $jsSupport = null;
        }

        $result->setCapability('ajax_support_javascript', $jsSupport);

        if (!empty($parserResult['JavaApplets'])) {
            $appletsSupport = $parserResult['JavaApplets'];
        } else {
            $appletsSupport = null;
        }

        $result->setCapability('supports_java_applets', $appletsSupport);

        if (!empty($parserResult['ActiveXControls'])) {
            $activexSupport = $parserResult['ActiveXControls'];
        } else {
            $activexSupport = null;
        }

        $result->setCapability('supports_activex_controls', $activexSupport);

        return $result;
    }

    /**
     * checks the parser result for special keys
     *
     * @param array   $allProperties  The parser result array
     * @param string  $propertyName   The name of the property to detect
     * @param boolean $depended       If TRUE the parameter $dependingValue has to be set
     * @param string  $dependingValue An master value
     *
     * @return string|integer|boolean The value of the detected property
     */
    protected function detectProperty(
        array $allProperties, $propertyName, $depended = false,
        $dependingValue = null
    ) {
        $propertyValue = (empty($allProperties[$propertyName]) ? null : trim($allProperties[$propertyName]));

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
}