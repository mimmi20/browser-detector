<?php
namespace BrowserDetector\Input;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
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
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @version   SVN: $Id$
 */

use BrowserDetector\Detector\Bits as BitsDetector;use BrowserDetector\Detector\Company;use BrowserDetector\Detector\Result;
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
class Browscap extends Core
{
    /**
     * the UAParser class
     *
     * @var \phpbrowscap\Browscap
     */
    private $parser = null;

    /**
     * the location of the local ini file
     *
     * @var string
     */
    private $localFile = null;

    /**
     * sets the UA Parser detector
     *
     * @var \phpbrowscap\Browscap $parser
     *
     * @return \phpbrowscap\Browscap
     */
    public function setParser(\phpbrowscap\Browscap $parser)
    {
        $this->parser = $parser;

        return $this;
    }

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

        $this->localFile = realpath($filename);
    }

    /**
     * sets the main parameters to the parser
     *
     * @throws \UnexpectedValueException
     * @return \phpbrowscap\Browscap
     */
    private function initParser()
    {
        if (!($this->parser instanceof \phpbrowscap\Browscap)) {
            throw new \UnexpectedValueException(
                'the parser object has to be an instance of \\phpbrowscap\\Browscap'
            );
        }

        if (null !== $this->localFile) {
            $this->parser->localfile = $this->localFile;
        }

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

        if (empty($parserResult['Browser_Name'])) {
            $browserName = $this->detectProperty($parserResult, 'Browser');
        } else {
            $browserName = $this->detectProperty($parserResult, 'Browser_Name');
        }
        if (!empty($parserResult['Browser_Version'])) {
            $browserVersion = $this->detectProperty(
                $parserResult, 'Browser_Version', true, $browserName
            );
        } else {
            $browserVersion = $this->detectProperty(
                $parserResult, 'Version', true, $browserName
            );
        }

        $browserName    = $mapper->mapBrowserName($browserName);
        $browserVersion = $mapper->mapBrowserVersion(
            $browserVersion, $browserName
        );

        $browserBits  = $this->detectProperty(
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
        } elseif (!empty($parserResult['Category'])) {
            $browserType = $parserResult['Category'];
        } else {
            $browserType = null;
        }

        $result->setCapability('browser_type', $browserType);

        if (!empty($parserResult['Browser_Modus'])) {
            $browserModus = $parserResult['Browser_Modus'];
        } else {
            $browserModus = '';
        }

        $result->setCapability('mobile_browser_modus', $browserModus);

        if (!empty($parserResult['Browser_Icon'])) {
            $browserIcon = $parserResult['Browser_Icon'];
        } else {
            $browserIcon = '';
        }

        $result->setCapability('mobile_browser_icon', $browserIcon);

        if (!empty($parserResult['Platform_Name'])) {
            $platform = $this->detectProperty($parserResult, 'Platform_Name');
        } else {
            $platform = $this->detectProperty($parserResult, 'Platform');
        }

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
        $platformIcon  = $this->detectProperty(
            $parserResult, 'Platform_Icon', true, $platform
        );

        $result->setCapability('device_os', $platform);
        $result->setCapability('device_os_version', $platformVersion);
        $result->setCapability('device_os_bits', $platformbits);
        $result->setCapability('device_os_manufacturer', $platformMaker);
        $result->setCapability('device_os_icon', $platformIcon);

        $deviceName = $this->detectProperty($parserResult, 'Device_Code_Name');
        $deviceType = $this->detectProperty($parserResult, 'Device_Type');

        $result->setCapability('device_type', $deviceType);

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

        $engineIcon = $this->detectProperty(
            $parserResult, 'RenderingEngine_Icon', true, $engineName
        );

        $result->setCapability(
            'renderingengine_name', $engineName
        );

        $result->setCapability('renderingengine_manufacturer', $engineMaker);
        $result->setCapability('renderingengine_icon', $engineIcon);

        if (!empty($parserResult['Device_isDesktop'])) {
            $result->setCapability(
                'ux_full_desktop',
                $parserResult['Device_isDesktop']
            );
        }

        if (!empty($parserResult['Device_isTv'])) {
            $result->setCapability('is_smarttv', $parserResult['Device_isTv']);
        }

        if (!empty($parserResult['Device_isMobileDevice'])) {
            $result->setCapability(
                'is_wireless_device', $parserResult['Device_isMobileDevice']
            );
        } elseif (!empty($parserResult['isMobileDevice'])) {
            $result->setCapability(
                'is_wireless_device', $parserResult['isMobileDevice']
            );
        }

        if (!empty($parserResult['Device_isTablet'])) {
            $result->setCapability('is_tablet', $parserResult['Device_isTablet']);
        } elseif (!empty($parserResult['isTablet'])) {
            $result->setCapability('is_tablet', $parserResult['isTablet']);
        }

        if (!empty($parserResult['Browser_isBot'])) {
            $result->setCapability('is_bot', $parserResult['Browser_isBot']);
        } elseif (!empty($parserResult['Crawler'])) {
            $result->setCapability('is_bot', $parserResult['Crawler']);
        }

        if (!empty($parserResult['Browser_isSyndicationReader'])) {
            $result->setCapability(
                'is_syndication_reader', $parserResult['Browser_isSyndicationReader']
            );
        } elseif (!empty($parserResult['isSyndicationReader'])) {
            $result->setCapability(
                'is_syndication_reader', $parserResult['isSyndicationReader']
            );
        }

        if (!empty($parserResult['Browser_isBanned'])) {
            $result->setCapability(
                'is_banned', $parserResult['Browser_isBanned']
            );
        } elseif (!empty($parserResult['isBanned'])) {
            $result->setCapability(
                'is_banned', $parserResult['isBanned']
            );
        }

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
    private function detectProperty(
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

    public function expandIni($doSort = true)
    {
        $this->log(\Monolog\Logger::DEBUG, 'loading ini');

        $browsers = $this->initParser()->getLoader()->load();

        $this->log(\Monolog\Logger::DEBUG, 'init');

        $browserBitHelper = new BitsDetector\Browser();
        $osBitHelper      = new BitsDetector\Os();
        $version          = new Version();
        $allProperties    = array_keys($browsers['DefaultProperties']);
        array_unshift(
            $allProperties,
            'Parent',
            'Parents'
        );

        unset($browsers[\phpbrowscap\Browscap::BROWSCAP_VERSION_KEY]);

        $this->log(\Monolog\Logger::DEBUG, 'expand');

        foreach ($browsers as $key => $properties) {
            if (!isset($properties['Parent'])) {
                continue;
            }

            $userAgent = $key;
            $parents   = array($userAgent);

            while (isset($browsers[$userAgent]['Parent'])) {
                if ($userAgent === $browsers[$userAgent]['Parent']) {
                    $this->log(
                        \Monolog\Logger::ALERT,
                        'Parent is identical to itself for key "' . $userAgent . '"'
                    );
                    break;
                }

                $parents[] = $browsers[$userAgent]['Parent'];
                $userAgent = $browsers[$userAgent]['Parent'];
            }
            unset($userAgent);

            $parents     = array_reverse($parents);
            $browserData = array();

            foreach ($parents as $parent) {
                if (!isset($browsers[$parent])) {
                    $this->log(
                        \Monolog\Logger::ALERT,
                        'Parent not found for key "' . $parent . '"'
                    );
                    continue;
                }

                if (!is_array($browsers[$parent])) {
                    $this->log(
                        \Monolog\Logger::ALERT,
                        'empty Parent found for key "' . $parent . '"'
                    );
                    continue;
                }

                $browserData = array_merge($browserData, $browsers[$parent]);
            }

            array_pop($parents);
            $browserData['Parents'] = implode(',', $parents);

            foreach ($browserData as $propertyName => $propertyValue) {
                switch ($propertyValue) {
                case 'true':
                    $properties[$propertyName] = true;
                    break;
                case 'false':
                    $properties[$propertyName] = false;
                    break;
                default:
                    $properties[$propertyName] = trim($propertyValue);
                    break;
                }
            }

            $browsers[$key] = $properties;

            if (!isset($properties['Version']) || !isset($properties['Browser'])) {
                continue;
            }

            $completeVersion = $properties['Version'];

            $version->setVersion($completeVersion);
            $version->setUserAgent($key);

            $properties['MajorVer'] = (int)$version->getVersion(Version::MAJORONLY);
            $v                      = $version->getVersion(Version::MINORMICRO | Version::IGNORE_MICRO_IF_EMPTY);
            if ($v) {
                $properties['MinorVer'] = $v;
            } else {
                $properties['MinorVer'] = 0;
            }

            $browserName = $properties['Browser'];

            $properties['Version'] = $completeVersion;
            $properties['Browser'] = $browserName;

            if (!empty($properties['Browser_Type'])) {
                $browserType = $properties['Browser_Type'];
            } else {
                $browserType = 'all';
            }

            $properties['Browser_Type'] = $browserType;

            $browserBitHelper->setUserAgent($key);
            $osBitHelper->setUserAgent($key);

            $properties['Browser_Bits']  = (int)$browserBitHelper->getBits();
            $properties['Platform_Bits'] = (int)$osBitHelper->getBits();

            $properties['Win64'] = false;
            $properties['Win32'] = false;
            $properties['Win16'] = false;

            $platform = $properties['Platform'];

            if (!empty($properties['Platform_Name'])) {
                $platform = $properties['Platform_Name'];
            }

            if ('Windows' == $platform) {
                if (64 == $properties['Browser_Bits']) {
                    $properties['Win64'] = true;
                } elseif (32 == $properties['Browser_Bits']) {
                    $properties['Win32'] = true;
                } elseif (16 == $properties['Browser_Bits']) {
                    $properties['Win16'] = true;
                }
            }

            $properties['Device_isMobileDevice'] = $properties['isMobileDevice'];
            $properties['Device_isTablet']       = $properties['isTablet'];

            if ($properties['Device_isTablet']) {
                $properties['Device_Type'] = 'Tablet';
            }

            if ('DefaultProperties' == $key
                || '*' == $key
            ) {
                $properties['Platform_Bits']        = 0;
                $properties['Browser_Bits']         = 0;
                $properties['isTablet']             = false;
                $properties['Device_Type']          = 'unknown';
                $properties['Platform_Description'] = '';
                $properties['Platform_Icon']        = '';
            } else {
                switch ($platform) {
                case 'RIM OS':
                    $properties['Device_Maker']          = 'Research In Motion Limited';
                    $properties['isMobileDevice']        = true;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = true;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = false;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'Research In Motion Limited';
                    $properties['Device_Type']           = 'Mobile Phone';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'Windows':
                case 'Win32':
                    $properties['Device_Code_Name']      = 'Windows Desktop';
                    $properties['Device_Maker']          = 'unknown';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform']              = 'Windows';
                    $properties['Platform_Name']         = 'Windows';
                    $properties['Platform_Maker']        = 'Microsoft Corporation';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'CygWin':
                    $properties['Device_Code_Name']      = 'Windows Desktop';
                    $properties['Device_Maker']          = 'unknown';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'Microsoft Corporation';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'WinMobile':
                case 'Windows Mobile OS':
                    $properties['isMobileDevice']        = true;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = true;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = false;
                    $properties['Device_isTv']           = false;
                    $properties['Platform']              = 'Windows Mobile OS';
                    $properties['Platform_Name']         = 'Windows Mobile OS';
                    $properties['Platform_Maker']        = 'Microsoft Corporation';
                    $properties['Device_Type']           = 'Mobile Phone';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'Windows Phone OS':
                    $properties['isMobileDevice']        = true;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = true;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = false;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'Microsoft Corporation';
                    $properties['Device_Type']           = 'Mobile Phone';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'Symbian OS':
                case 'SymbianOS':
                    $properties['isMobileDevice']        = true;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = true;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = false;
                    $properties['Device_isTv']           = false;
                    $properties['Platform']              = 'SymbianOS';
                    $properties['Platform_Name']         = 'Symbian OS';
                    $properties['Platform_Maker']        = 'Symbian Foundation';
                    $properties['Device_Type']           = 'Mobile Phone';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'Debian':
                case 'Linux':
                case 'Linux for TV':
                case 'Linux Smartphone OS':
                    $properties['Platform_Name']        = 'Linux';
                    $properties['Platform_Maker']       = 'Linux Foundation';
                    $properties['Platform_Description'] = '';
                    $properties['Platform_Icon']        = '';

                    if ($mobileDevice === false
                        && !empty($properties['Device_isTv'])
                        && $properties['Device_isTv'] === false
                    ) {
                        $properties['Device_Code_Name']      = 'Linux Desktop';
                        $properties['Device_Maker']          = 'unknown';
                        $properties['isMobileDevice']        = false;
                        $properties['isTablet']              = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet']       = false;
                        $properties['Device_isDesktop']      = true;
                        $properties['Device_isTv']           = false;
                        $properties['Device_Type']           = 'Desktop';
                    } elseif (!empty($properties['Device_isTv'])
                        && $properties['Device_isTv'] === true
                    ) {
                        $properties['Device_Code_Name']      = 'general TV Device';
                        $properties['Device_Maker']          = 'unknown';
                        $properties['isMobileDevice']        = false;
                        $properties['isTablet']              = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet']       = false;
                        $properties['Device_isDesktop']      = false;
                        $properties['Device_isTv']           = true;
                        $properties['Platform_Name']         = 'Linux for TV';
                        $properties['Device_Type']           = 'TV Device';
                    } elseif ($mobileDevice == true) {
                        $properties['isMobileDevice']        = true;
                        $properties['Device_isMobileDevice'] = true;
                        $properties['Device_isDesktop']      = false;
                        $properties['Device_isTv']           = false;
                        $properties['Platform']              = 'Linux Smartphone OS';
                        $properties['Platform_Name']         = 'Linux Smartphone OS';
                        $properties['Device_Type']           = 'Mobile Phone';
                    }
                    break;
                case 'CentOS':
                    $properties['Device_Code_Name']      = 'Linux Desktop';
                    $properties['Device_Maker']          = 'unknown';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'Macintosh':
                case 'MacOSX':
                case 'Mac OS X':
                case 'Mac68K':
                    $properties['Device_Code_Name']      = 'Macintosh';
                    $properties['Device_Maker']          = 'Apple Inc';
                    $properties['Device_Brand_Name']     = 'Apple';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'Apple Inc';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'Darwin':
                    $properties['Device_Maker']          = 'Apple Inc';
                    $properties['Device_Brand_Name']     = 'Apple';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = false;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'Apple Inc';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';

                    if (!empty($properties['Device_Code_Name'])) {
                        switch ($properties['Device_Code_Name']) {
                        case 'iPad':
                            $properties['isMobileDevice']        = true;
                            $properties['Device_isMobileDevice'] = true;
                            $properties['isTablet']              = true;
                            $properties['Device_isTablet']       = true;
                            $properties['Device_Type']           = 'Tablet';
                            break;
                        case 'iPod':
                            $properties['isMobileDevice']        = true;
                            $properties['Device_isMobileDevice'] = true;
                            $properties['isTablet']              = false;
                            $properties['Device_isTablet']       = false;
                            $properties['Device_Type']           = 'Mobile Device';
                            break;
                        case 'iPhone':
                            $properties['isMobileDevice']        = true;
                            $properties['Device_isMobileDevice'] = true;
                            $properties['isTablet']              = false;
                            $properties['Device_isTablet']       = false;
                            $properties['Device_Type']           = 'Mobile Phone';
                            break;
                        default:
                            $properties['Device_Code_Name'] = 'Macintosh';
                            $properties['Device_isDesktop'] = true;
                            $properties['Device_Type']      = 'Desktop';
                            break;
                        }
                    }
                    break;
                case 'iOS':
                    $properties['Device_Maker']          = 'Apple Inc';
                    $properties['Device_Brand_Name']     = 'Apple';
                    $properties['isMobileDevice']        = true;
                    $properties['Device_isMobileDevice'] = true;
                    $properties['Device_isDesktop']      = false;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'Apple Inc';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';

                    if (!empty($properties['Device_Code_Name'])) {
                        switch ($properties['Device_Code_Name']) {
                        case 'iPad':
                            $properties['isTablet']        = true;
                            $properties['Device_isTablet'] = true;
                            $properties['Device_Type']     = 'Tablet';
                            break;
                        case 'iPod':
                            $properties['isTablet']        = false;
                            $properties['Device_isTablet'] = false;
                            $properties['Device_Type']     = 'Mobile Device';
                            break;
                        case 'iPhone':
                            $properties['isTablet']        = false;
                            $properties['Device_isTablet'] = false;
                            $properties['Device_Type']     = 'Mobile Phone';
                            break;
                        default:
                            // nothing to do here
                            break;
                        }
                    }
                    break;
                case 'BeOS':
                    $properties['Device_Code_Name']      = 'general Desktop';
                    $properties['Device_Maker']          = 'unknown';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'Access';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'AIX':
                    $properties['Device_Code_Name']      = 'general Desktop';
                    $properties['Device_Maker']          = 'IBM';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'IBM';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'Digital Unix':
                case 'Tru64 UNIX':
                    $properties['Device_Code_Name']      = 'general Desktop';
                    $properties['Device_Maker']          = 'HP';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform']              = 'Tru64 UNIX';
                    $properties['Platform_Name']         = 'Tru64 UNIX';
                    $properties['Platform_Maker']        = 'HP';
                    $properties['Platform_Bits']         = '64';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'HPUX':
                case 'HP-UX':
                case 'OpenVMS':
                    $properties['Device_Code_Name']      = 'general Desktop';
                    $properties['Device_Maker']          = 'HP';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'HP';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'IRIX':
                case 'IRIX64':
                    $properties['Device_Code_Name']      = 'general Desktop';
                    $properties['Device_Maker']          = 'SGI';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'SGI';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'Solaris':
                case 'SunOS':
                    $properties['Device_Code_Name'] = 'general Desktop';
                    // $properties['Device_Maker'] = 'Oracle';
                    $properties['Device_Maker']          = 'unknown';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'Oracle';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'OS/2':
                    $properties['Device_Code_Name']      = 'general Desktop';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'IBM';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'Android':
                case 'Dalvik':
                    $properties['Platform_Description'] = '';
                    $properties['Platform_Icon']        = '';

                    if (!empty($properties['Device_Code_Name']) && $properties['Device_Code_Name'] !== 'NBPC724') {
                        $properties['isMobileDevice']        = true;
                        $properties['Device_isMobileDevice'] = true;
                        $properties['Device_isDesktop']      = false;
                        $properties['Device_isTv']           = false;
                        $properties['Platform_Maker']        = 'Google Inc';
                        if ($isTablet) {
                            $properties['Device_Type'] = 'Tablet';
                        } else {
                            $properties['Device_Type'] = 'Mobile Phone';
                        }
                    } elseif (!empty($properties['Device_Code_Name'])
                        && $properties['Device_Code_Name'] === 'NBPC724'
                    ) {
                        $properties['isMobileDevice']        = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isDesktop']      = true;
                        $properties['Device_isTv']           = false;
                        $properties['Platform_Maker']        = 'Google Inc';
                        $properties['Device_Type']           = 'Desktop';
                    }
                    break;
                case 'FreeBSD':
                    if (!empty($properties['Device_isTv'])
                        && $properties['Device_isTv'] === false
                    ) {
                        $properties['Device_Code_Name'] = 'Linux Desktop';
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv']      = false;
                        $properties['Device_Type']      = 'Desktop';
                    } elseif (!empty($properties['Device_isTv'])
                        && $properties['Device_isTv'] === true
                    ) {
                        $properties['Device_Code_Name'] = 'general TV Device';
                        $properties['Device_isDesktop'] = false;
                        $properties['Device_isTv']      = true;
                        $properties['Device_Type']      = 'TV Device';
                    }

                    $properties['Device_Maker']          = 'unknown';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Platform_Maker']        = 'FreeBSD Foundation';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'NetBSD':
                case 'OpenBSD':
                case 'RISC OS':
                case 'Unix':
                    $properties['Device_Code_Name']      = 'general Desktop';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'unknown';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'WebTV':
                    $properties['Device_Code_Name']      = 'General TV Device';
                    $properties['Device_Maker']          = 'unknown';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = false;
                    $properties['Device_isTv']           = true;
                    $properties['Platform_Maker']        = 'unknown';
                    $properties['Device_Type']           = 'TV Device';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'ChromeOS':
                    $properties['Device_Code_Name']      = 'general Desktop';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'Google Inc';
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                case 'Ubuntu':
                    $properties['Device_Code_Name']      = 'Linux Desktop';
                    $properties['isMobileDevice']        = false;
                    $properties['isTablet']              = false;
                    $properties['Device_isMobileDevice'] = false;
                    $properties['Device_isTablet']       = false;
                    $properties['Device_isDesktop']      = true;
                    $properties['Device_isTv']           = false;
                    $properties['Platform_Maker']        = 'Canonical Ltd';
                    $properties['Platform_Bits']         = 0;
                    $properties['Device_Type']           = 'Desktop';
                    $properties['Platform_Description']  = '';
                    $properties['Platform_Icon']         = '';
                    break;
                default:
                    $properties['Platform_Description'] = '';
                    $properties['Platform_Icon']        = '';
                    break;
                }
            }

            if (empty($properties['Device_Name'])
                || false !== strpos($properties['Device_Name'], 'unknown')
                || false !== strpos($properties['Device_Name'], 'general')
            ) {
                if (empty($properties['Device_Code_Name'])) {
                    $properties['Device_Name'] = 'unknown';
                } else {
                    $properties['Device_Name'] = $properties['Device_Code_Name'];
                }
            }

            if (empty($properties['Device_Maker'])) {
                $properties['Device_Brand_Name'] = '';
            } elseif (empty($properties['Device_Brand_Name'])
                || false !== strpos($properties['Device_Brand_Name'], 'unknown')
                || false !== strpos($properties['Device_Brand_Name'], 'general')
            ) {
                $properties['Device_Brand_Name'] = $properties['Device_Maker'];
            }

            $browsers[$key] = $properties;
        }

        $this->log(\Monolog\Logger::DEBUG, 'build groups');

        foreach ($browsers as $key => $properties) {
            if (!empty($properties['Parents'])) {
                $groups[$properties['Parents']][] = $key;
            }
        }

        //sort
        if ($doSort) {
            $this->log(\Monolog\Logger::DEBUG, 'sort');

            $sort1  = array();
            $sort2  = array();
            $sort3  = array();
            $sort4  = array();
            $sort5  = array();
            $sort6  = array();
            $sort7  = array();
            $sort8  = array();
            $sort9  = array();
            $sort10 = array();
            $sort11 = array();
            $sort12 = array();
            $sort13 = array();
            $sort14 = array();
            $sort15 = array();
            $sort16 = array();

            foreach ($browsers as $key => $properties) {
                $x = 0;

                if (!empty($properties['Category'])) {
                    switch ($properties['Category']) {
                    case 'Bot/Crawler':
                        $x = 1;
                        break;
                    case 'Application':
                        $x = 2;
                        break;
                    case 'Email Client':
                        $x = 3;
                        break;
                    case 'Library':
                        $x = 4;
                        break;
                    case 'Browser':
                        $x = 8;
                        break;
                    case 'Unister':
                        $x = 9;
                        break;
                    case 'all':
                        $x = 10;
                        break;
                    case 'unknown':
                    default:
                        // nothing to do here
                        break;
                    }
                }

                if ('DefaultProperties' === $key) {
                    $x = -1;
                }

                if ('*' === $key) {
                    $x = 11;
                }

                $sort1[$key] = $x;

                if (!empty($properties['Browser_Name'])) {
                    $sort2[$key] = strtolower($properties['Browser_Name']);
                } elseif (!empty($properties['Browser'])) {
                    $sort2[$key] = strtolower($properties['Browser']);
                } else {
                    $sort2[$key] = '';
                }

                if (!empty($properties['Browser_Version'])) {
                    $v = (float)$properties['Browser_Version'];
                } elseif (!empty($properties['Version'])) {
                    $v = (float)$properties['Version'];
                } else {
                    $v = 0.0;
                }

                $version->setVersion($v);
                $version->setUserAgent($key);
                $sort3[$key]  = $version->getVersion(Version::MAJORONLY);
                $sort13[$key] = $version->getVersion(Version::MINORONLY);
                $sort14[$key] = $version->getVersion(Version::MICROONLY);

                if (!empty($properties['Browser_Bits'])) {
                    $bits = $properties['Browser_Bits'];
                } else {
                    $bits = 0;
                }

                $sort5[$key] = $bits;

                if (!empty($properties['Platform_Name'])) {
                    $sort4[$key] = strtolower($properties['Platform_Name']);
                } elseif (!empty($properties['Platform'])) {
                    $sort4[$key] = strtolower($properties['Platform']);
                } else {
                    $sort4[$key] = '';
                }

                if (!empty($properties['Browser_Version'])) {
                    $v = $properties['Browser_Version'];
                } elseif (!empty($properties['Version'])) {
                    $v = $properties['Version'];
                } else {
                    $v = 0.0;
                }

                switch ($v) {
                case '3.1':
                    $v = 3.1;
                    break;
                case '95':
                    $v = 3.2;
                    break;
                case 'NT':
                    $v = 4.0;
                    break;
                case '98':
                    $v = 4.1;
                    break;
                case 'ME':
                    $v = 4.2;
                    break;
                case '2000':
                    $v = 4.3;
                    break;
                case 'XP':
                    $v = 4.4;
                    break;
                case '2003':
                    $v = 4.5;
                    break;
                case 'Vista':
                    $v = 6.0;
                    break;
                case '7':
                    $v = 7.0;
                    break;
                case '8':
                    $v = 8.0;
                    break;
                default:
                    $v = (float)$v;
                    break;
                }

                $version->setVersion($v);
                $version->setUserAgent($key);
                $sort6[$key]  = $version->getVersion(Version::MAJORONLY);
                $sort15[$key] = $version->getVersion(Version::MINORONLY);
                $sort16[$key] = $version->getVersion(Version::MICROONLY);

                if (!empty($properties['Platform_Bits'])) {
                    $bits = $properties['Platform_Bits'];
                } else {
                    $bits = 0;
                }

                $sort9[$key] = $bits;

                $parents = (empty($properties['Parents']) ? '' : $properties['Parents'] . ',') . $key;

                if (!empty($groups[$parents])) {
                    $group    = $parents;
                    $subgroup = 0;
                } elseif (!empty($properties['Parents'])) {
                    $group    = $properties['Parents'];
                    $subgroup = 1;
                } else {
                    $group    = '';
                    $subgroup = 2;
                }

                if (!empty($properties['Device_Maker'])
                    && false !== strpos($properties['Device_Maker'], 'unknown')
                    && false !== strpos($properties['Device_Maker'], 'general')
                ) {
                    $brandName = strtolower($properties['Device_Maker']);
                } else {
                    $brandName = '';
                }

                if (!empty($properties['Device_Code_Name'])
                    && false !== strpos($properties['Device_Code_Name'], 'unknown')
                    && false !== strpos($properties['Device_Code_Name'], 'general')
                ) {
                    $marketingName = strtolower($properties['Device_Code_Name']);
                } else {
                    $marketingName = '';
                }

                $sort7[$key]  = strtolower($group);
                $sort8[$key]  = strtolower($subgroup);
                $sort11[$key] = $brandName;
                $sort12[$key] = $marketingName;
                $sort10[$key] = $key;
            }

            array_multisort(
                $sort1, SORT_ASC,
                $sort7, SORT_ASC, // Parents
                $sort8, SORT_ASC, // Parent first
                $sort2, SORT_ASC, // Browser Name
                $sort3, SORT_ASC, SORT_NUMERIC, // Browser Version::Major
                $sort13, SORT_ASC, SORT_NUMERIC, // Browser Version::Minor
                $sort14, SORT_ASC, SORT_NUMERIC, // Browser Version::Micro
                $sort4, SORT_ASC, // Platform Name
                $sort6, SORT_ASC, SORT_NUMERIC, // Platform Version::Major
                $sort15, SORT_ASC, SORT_NUMERIC, // Platform Version::Minor
                $sort16, SORT_ASC, SORT_NUMERIC, // Platform Version::Micro
                $sort9, SORT_ASC, SORT_NUMERIC, // Platform Bits
                $sort5, SORT_ASC, SORT_NUMERIC, // Browser Bits
                $sort11, SORT_ASC, // Device Hersteller
                $sort12, SORT_ASC, // Device Name
                $sort10, SORT_ASC,
                $browsers
            );
        }

        $this->log(\Monolog\Logger::DEBUG, 'shrink and output');

        $fp = fopen($this->localFile . '.full.php.ini', 'w');
        fwrite(
            $fp,
            ';;; Provided courtesy of https://browsers.garykeith.com
;;; Created on Tuesday, March 12, 2013 at 3:03 AM UTC

;;; Keep up with the latest goings-on with the project:
;;; Follow us on Twitter <https://twitter.com/browscap>, or...
;;; Like us on Facebook <https://facebook.com/browscap>, or...
;;; Collaborate on GitHub <https://github.com/GaryKeith/browscap>, or...
;;; Discuss on Google Groups <https://groups.google.com/d/forum/browscap>.

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;; Browscap Version

[GJK_Browscap_Version]
Version=5020
Released=$Date: 2013-09-11 21:09:35 +0200 (Mi, 11 Sep 2013) $

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;; known Platforms
;
;unknown - not detected
;Dalvik  - VM on Andoid
;Darwin  - Free BSD based Hybridkernel OS for the MAC
;Bada    - a OS developt by Samsung
;Mac OS X
;MacPPC
;WAP
;Solaris
;Polaris - a free clone of Solaris
;' . "\n"
        );

        // shrink
        foreach ($browsers as $key => $properties) {
            if (!isset($properties['Version'])) {
                continue;
            }

            if (!isset($properties['Parent'])
                && 'DefaultProperties' !== $key
                && '*' !== $key
            ) {
                continue;
            }

            if ('DefaultProperties' !== $key
                && '*' !== $key
            ) {
                if (!isset($browsers[$properties['Parent']])) {
                    continue;
                }

                $parent = $browsers[$properties['Parent']];
            } else {
                $parent = array();
            }

            $propertiesToOutput = $properties;
/*
            foreach ($propertiesToOutput as $property => $value) {
                if (!isset($parent[$property])) {
                    continue;
                }

                if ($parent[$property] != $value) {
                    continue;
                }

                unset($propertiesToOutput[$property]);
            }
/**/
            // create output - php

            if ('DefaultProperties' == $key
                || empty($properties['Parent'])
                || 'DefaultProperties' == $properties['Parent']
            ) {
                fwrite(
                    $fp,
                    ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;; ' . $key. "\n\n"
                );
            }

            fwrite($fp, '[' . $key . ']' . "\n");

            foreach ($allProperties as $property) {
                if ('Parents' === $property) {
                    continue;
                }

                $value = $propertiesToOutput[$property];

                if (true === $value || $value === 'true') {
                    $valuePhp = 'true';
                } elseif (false === $value || $value === 'false') {
                    $valuePhp = 'false';
                } elseif ('0' === $value
                    || 'Version' === $property
                    || 'MajorVer' === $property
                    || 'MinorVer' === $property
                    || 'RenderingEngine_Version' === $property
                    || 'Platform_Version' === $property
                    || 'Browser_Version' === $property
                ) {
                    $valuePhp = $value;
                } else {
                    $valuePhp = '"' . $value . '"';
                }

                fwrite($fp, $property . '=' . $valuePhp . "\n");
            }

            fwrite($fp, "\n");
        }

        fclose($fp);
    }
}