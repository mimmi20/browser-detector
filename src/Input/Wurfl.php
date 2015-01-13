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

use BrowserDetector\Detector\Result;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\InputMapper;
use Exception;
use UnexpectedValueException;
use Wurfl\Manager;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Wurfl extends Core
{
    /**
     * the wurfl detector class
     *
     * @var \Wurfl\Manager
     */
    private $wurflManager = null;

    /**
     * a flag to tell, if the wurfl data should be mapped
     *
     * @var boolean
     */
    private $mapWurflData = true;

    /**
     * sets the wurfl detection manager
     *
     * @var \Wurfl\Manager $wurfl
     *
     * @throws \UnexpectedValueException
     * @return Wurfl
     */
    public function setWurflManager(Manager $wurfl)
    {
        if (!($wurfl instanceof Manager)) {
            throw new UnexpectedValueException(
                'the $wurfl object has to be an instance of \\Wurfl\\Manager'
            );
        }

        $this->wurflManager = $wurfl;

        return $this;
    }

    /**
     * sets the flag to tell, if the wurfl data should be mapped
     *
     * @var boolean $map
     *
     * @return Wurfl
     */
    public function setMapWurflData($map)
    {
        $this->mapWurflData = ($map ? true : false);

        return $this;
    }

    /**
     * sets the main parameters to the parser
     *
     * @throws UnexpectedValueException
     * @return \Wurfl\Manager
     */
    private function initParser()
    {
        if (!($this->wurflManager instanceof Manager)) {
            throw new UnexpectedValueException(
                'the $wurfl object has to be an instance of \\Wurfl\\ManagerFactory'
            );
        }

        return $this->wurflManager;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @throws UnexpectedValueException
     * @return Result
     */
    public function getBrowser()
    {
        $marketingName = null;
        $xhtmlLevel    = 0;

        try {
            $agent         = str_replace('Toolbar', '', $this->_agent);
            $device        = $this->initParser()->getDeviceForUserAgent($agent);
            $allProperties = $device->getAllCapabilities();

            $apiKey = $device->id;
            $apiMob = ('true' === $device->getCapability('is_wireless_device'));

            if ($apiMob) {
                $apiOs    = ('iPhone OS' == $device->getCapability('device_os')
                    ? 'iOS'
                    : $device->getCapability(
                        'device_os'
                    ));
                $apiBro   = $device->getCapability('mobile_browser');
                $apiVer   = $device->getCapability('mobile_browser_version');
                $apiDev   = $device->getCapability('model_name');
                $apiTab   = ('true' === $device->getCapability('is_tablet'));
                $apiMan   = $device->getCapability('manufacturer_name');
                $apiPhone = ('true' === $device->getCapability('can_assign_phone_number'));

                $brandName = $device->getCapability('brand_name');

                if ('Opera' == $brandName && $this->mapWurflData) {
                    $brandName = null;
                }
            } else {
                $apiOs    = null;
                $apiBro   = $device->getCapability('brand_name');
                $apiVer   = $device->getCapability('model_name');
                $apiDev   = null;
                $apiTab   = false;
                $apiMan   = null;
                $apiPhone = false;

                $brandName = null;
            }

            $apiBot        = ('true' === $device->getCapability('is_bot'));
            $apiTv         = ('true' === $device->getCapability('is_smarttv'));
            $apiDesktop    = ('true' === $device->getCapability('ux_full_desktop'));
            $apiTranscoder = ('true' === $device->getCapability('is_transcoder'));
            $browserMaker  = '';

            if ($this->mapWurflData) {
                $apiOs = trim($apiOs);
                if (!$apiOs) {
                    $apiOs = null;
                } else {
                    $apiOs = trim($apiOs);
                }

                switch (strtolower($apiOs)) {
                case 'symbian os':
                    switch (strtolower($apiVer)) {
                    case 's3':
                    case 'belle':
                    case 'anna':
                        $apiVer = 'S3';
                        break;
                    default:
                        // nothing to do here
                        break;
                    }
                    break;
                default:
                    // nothing to do here
                    break;
                }

                $marketingName = $device->getCapability('marketing_name');

                $mapper = new InputMapper();

                $apiDev        = $mapper->mapDeviceName($apiDev);
                $apiMan        = $mapper->mapDeviceMaker($apiMan, $apiDev);
                $marketingName = $mapper->mapDeviceMarketingName($marketingName, $apiDev);
                $brandName     = $mapper->mapDeviceBrandName($brandName, $apiDev);

                if ('Generic' == $apiMan || 'Opera' == $apiMan) {
                    $apiMan        = null;
                    $apiDev        = null;
                    $marketingName = null;
                }

                $apiDev = trim($apiDev);
                if (!$apiDev) {
                    $apiDev = null;
                }

                switch (strtolower($apiBro)) {
                    case 'microsoft':
                        $browserMaker = 'Microsoft';

                        switch (strtolower($apiVer)) {
                            case 'internet explorer':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '';
                                break;
                            case 'internet explorer 10':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '10.0';
                                break;
                            case 'internet explorer 9':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '9.0';
                                break;
                            case 'internet explorer 8':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '8.0';
                                break;
                            case 'internet explorer 7':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '7.0';
                                break;
                            case 'internet explorer 6':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '6.0';
                                break;
                            case 'internet explorer 5.5':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '5.5';
                                break;
                            case 'internet explorer 5':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '5.0';
                                break;
                            case 'internet explorer 4.0':
                            case 'internet explorer 4':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '4.0';
                                break;
                            case 'mobile explorer':
                                $apiBro = 'IEMobile';
                                $apiVer = '';
                                break;
                            case 'mobile explorer 4.0':
                                $apiBro = 'IEMobile';
                                $apiVer = '4.0';
                                break;
                            case 'mobile explorer 6':
                                $apiBro = 'IEMobile';
                                $apiVer = '6.0';
                                break;
                            case 'mobile explorer 7.6':
                                $apiBro = 'IEMobile';
                                $apiVer = '7.6';
                                break;
                            case 'mobile explorer 7.11':
                                $apiBro = 'IEMobile';
                                $apiVer = '7.11';
                                break;
                            case 'mobile explorer 6.12':
                                $apiBro = 'IEMobile';
                                $apiVer = '6.12';
                                break;
                            case 'xbox 360':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '9.0';
                                $apiDev = 'Xbox 360';
                                $apiMan = 'Microsoft';
                                break;
                            case 'outlook express':
                                $apiBro = 'Windows Live Mail';
                                $apiVer = '';
                                break;
                            case 'office 2007':
                                $apiBro = 'Office';
                                $apiVer = '2007';
                                break;
                            case 'microsoft office 2007':
                                $apiBro = 'Office';
                                $apiVer = '2007';
                                break;
                            case 'microsoft office':
                                $apiBro = 'Office';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'microsoft internet explorer':
                    case 'msie':
                        $apiBro       = 'Internet Explorer';
                        $browserMaker = 'Microsoft';
                        break;
                    case 'microsoft mobile explorer':
                        $apiBro       = 'IEMobile';
                        $browserMaker = 'Microsoft';
                        break;
                    case 'microsoft office 2007':
                        $browserMaker = 'Microsoft';
                        $apiBro = 'Office';
                        $apiVer = '2007';
                        break;
                    case 'microsoft office':
                        $browserMaker = 'Microsoft';
                        $apiBro = 'Office';
                        break;
                    case 'microsoft outlook':
                        $browserMaker = 'Microsoft';
                        $apiBro = 'Outlook';
                        break;
                    case 'opera mobi':
                        $browserMaker = 'Opera Software ASA';
                        $apiBro       = 'Opera Mobile';
                        $apiVer       = '';
                        break;
                    case 'opera tablet':
                        $browserMaker = 'Opera Software ASA';
                        $apiBro       = 'Opera Tablet';
                        $apiVer       = '';
                        break;
                    case 'google chrome':
                    case 'chrome mobile':
                    case 'chrome':
                        $apiBro       = 'Chrome';
                        $apiVer       = '';
                        $browserMaker = 'Google';
                        break;
                    case 'google':
                        $browserMaker = 'Google';

                        switch (strtolower($apiVer)) {
                            case 'chrome':
                                $apiBro = 'Chrome';
                                $apiVer = $device->getCapability('mobile_browser_version');
                                break;
                            case 'bot':
                                $apiBro     = 'Google Bot';
                                $apiVer     = '';
                                $apiDesktop = false;
                                $apiBot     = true;
                                break;
                            case 'wireless transcoder':
                                $apiBro        = 'Google Wireless Transcoder';
                                $apiVer        = '';
                                $apiDesktop    = false;
                                $apiBot        = true;
                                $apiTranscoder = true;
                                break;
                            case 'adsense bot':
                                $apiBro        = 'AdSense Bot';
                                $apiVer        = '';
                                $apiDesktop    = false;
                                $apiBot        = true;
                                $apiTranscoder = true;
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'mozilla firefox':
                    case 'firefox':
                        $apiBro       = 'Firefox';
                        $browserMaker = 'Mozilla';
                        if ('3.0' == $apiVer) {
                            $apiVer = null;
                        }
                        break;
                    case 'mozilla':
                        $browserMaker = 'Mozilla';

                        switch (strtolower($apiVer)) {
                            case 'firefox':
                                $apiBro = 'Firefox';
                                $apiVer = $device->getCapability('mobile_browser_version');
                                break;
                            case 'thunderbird':
                                $apiBro = 'Thunderbird';
                                $apiVer = $device->getCapability('mobile_browser_version');
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'fennec':
                        $apiBro       = 'Fennec';
                        $browserMaker = 'Mozilla';
                        $apiVer       = null;
                        break;
                    case 'apple safari':
                    case 'safari':
                        $apiBro       = 'Safari';
                        $browserMaker = 'Apple';
                        $apiVer       = '';
                        break;
                    case 'apple':
                        $browserMaker = 'Apple';

                        switch (strtolower($apiVer)) {
                            case 'safari':
                                $apiBro = 'Safari';
                                $apiVer = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'opera software opera':
                    case 'opera':
                        $apiBro       = 'Opera';
                        $browserMaker = 'Opera Software ASA';
                        $apiVer       = '';
                        break;
                    case 'opera software':
                        $browserMaker = 'Opera Software ASA';

                        switch (strtolower($apiVer)) {
                            case 'opera':
                                $apiBro = 'Opera';
                                $apiVer = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'konqueror':
                        $apiBro = 'Konqueror';
                        break;
                    case 'access netfront':
                        $apiBro       = 'NetFront';
                        $browserMaker = 'Access';
                        break;
                    case 'nokia':
                    case 'nokia browserng':
                        $apiBro = 'Nokia Browser';
                        break;
                    case 'facebook':
                        switch (strtolower($apiVer)) {
                            case 'bot':
                                $apiBro     = 'FaceBook Bot';
                                $apiVer     = '';
                                $apiDesktop = false;
                                $apiBot     = true;
                                break;
                            default:
                                // nothing to do here
                                break;
                        }
                        break;
                    case 'bing bot':
                        $apiBro       = 'BingBot';
                        $browserMaker = 'Microsoft';
                        $apiDesktop   = false;
                        $apiBot       = true;
                        $apiTv        = false;
                        break;
                    case 'bing':
                        $browserMaker = 'Microsoft';

                        switch (strtolower($apiVer)) {
                            case 'bot':
                                $apiBro = 'BingBot';
                                $apiVer = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'google bot':
                    case 'facebook bot':
                        $apiDesktop = false;
                        $apiBot     = true;
                        $apiTv      = false;
                        break;
                    case 'generic web browser':
                        $apiBro     = null;
                        $apiOs      = null;
                        $apiMob     = null;
                        $apiTab     = null;
                        $apiDev     = null;
                        $apiMan     = null;
                        $apiBot     = null;
                        $apiTv      = null;
                        $apiDesktop = null;
                        break;
                    case 'robot bot or crawler':
                    case 'robot':
                        $apiDesktop = false;
                        $apiBot     = true;
                        $apiTv      = false;
                        $apiDev     = 'general Bot';
                        $apiBro     = 'unknown';
                        break;
                    case 'generic smarttv':
                        $apiDesktop = false;
                        $apiBot     = false;
                        $apiTv      = true;
                        $apiDev     = 'general TV Device';
                        $apiBro     = 'unknown';
                        break;
                    case 'unknown':
                        $browserMaker = 'unknown';
                        $apiBro       = 'unknown';

                        switch (strtolower($apiVer)) {
                            case 'bot or crawler':
                                $apiDesktop = false;
                                $apiBot     = true;
                                $apiTv      = false;
                                $apiDev     = 'general Bot';
                                $apiBro     = 'unknown';
                                $apiVer     = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'wii':
                        $apiDesktop = false;
                        $apiBot     = false;
                        $apiTv      = true;
                        $apiDev     = 'Wii';
                        $apiBro     = 'Wii Browser';
                        $apiMan     = 'Nintendo';
                        break;
                    case 'android webkit':
                    case 'android':
                        $apiBro = 'Android Webkit';
                        if ('4.01' == $apiVer) {
                            $apiVer = '4.0.1';
                        }
                        $browserMaker = 'Google';
                        break;
                    case 'UCWeb':
                        $apiBro = 'UC Browser';
                        break;
                    case 'seomoz':
                        $browserMaker = 'SEOmoz';

                        switch (strtolower($apiVer)) {
                            case 'rogerbot':
                                $apiBro = 'Rogerbot';
                                $apiVer = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'java':
                        $browserMaker = 'unknown';

                        switch (strtolower($apiVer)) {
                            case 'updater':
                                $apiBro       = 'Java Standard Library';
                                $apiVer       = '';
                                $browserMaker = 'Oracle';
                                $apiDesktop   = false;
                                $apiBot       = true;
                                $apiTv        = false;
                                $apiPhone     = false;
                                $device       = null;
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    default:
                        // nothing to do here
                        break;
                }

                $apiBro = trim($apiBro);
                if (!$apiBro) {
                    $apiBro = null;
                    $apiOs  = null;
                    $apiMob = null;
                    $apiTab = null;
                    $apiDev = null;
                    $apiMan = null;
                    $apiBot = null;
                    $apiTv  = null;

                    $apiPhone      = null;
                    $apiDesktop    = null;
                    $allProperties = array();
                    $marketingName = null;
                    $apiTranscoder = null;
                }

                $xhtmlLevel = null;

                if ((null !== $device) && ($apiDev || $apiBro)) {
                    $xhtmlLevel = $device->getCapability('xhtml_support_level');
                }
            }
        } catch (Exception $e) {
            $apiKey = 'error';
            $apiMob = false;
            $apiOs  = 'error';
            $apiBro = $e->getMessage();
            $apiVer = '';
            $apiDev = 'error';
            $apiTab = false;
            $apiMan = null;
            $apiBot = true;
            $apiTv  = false;

            $apiPhone      = false;
            $apiDesktop    = false;
            $allProperties = array();
            $marketingName = null;
            $apiTranscoder = null;

            $brandName    = null;
            $xhtmlLevel   = null;
            $browserMaker = '';

            $device = null;
        }

        $result = new Result();
        $result->setCapability('useragent', $this->_agent);

        if (null === $device || 'robot' === strtolower($device->getVirtualCapability('form_factor'))) {
            return $result;
        }

        if ($apiDev || $apiBro) {
            $versionFields = array(
                'mobile_browser_version', 'renderingengine_version',
                'device_os_version', 'controlcap_advertised_browser_version',
                'controlcap_advertised_device_os_version'
            );

            $integerFields = array(
                'max_deck_size', 'max_length_of_username', 'max_no_of_bookmarks',
                'max_length_of_password', 'max_no_of_connection_settings',
                'max_object_size', 'max_url_length_bookmark',
                'max_url_length_cached_page', 'max_url_length_in_requests',
                'max_url_length_homepage', 'colors', 'physical_screen_width',
                'physical_screen_height', 'columns', 'rows', 'max_image_width',
                'max_image_height', 'resolution_width', 'resolution_height'
            );

            $allProperties = array_intersect_key(
                $allProperties, $result->getCapabilities()
            );

            foreach ($allProperties as $capabilityName => $capabilityValue) {
                if (in_array($capabilityName, $versionFields)) {
                    $version         = new Version();
                    $capabilityValue = $version->setVersion($capabilityValue);
                } elseif ('colors' === $capabilityName && $capabilityValue == '65536') {
                    $capabilityValue = null;
                } elseif (in_array($capabilityName, $integerFields)) {
                    $capabilityValue = (int)$capabilityValue;
                } elseif ('unknown' === $capabilityValue
                    || 'null' === $capabilityValue
                    || null === $capabilityValue
                ) {
                    $capabilityValue = null;
                } elseif ('false' === $capabilityValue
                    || false === $capabilityValue
                ) {
                    $capabilityValue = false;
                } elseif ('true' === $capabilityValue
                    || true === $capabilityValue
                ) {
                    $capabilityValue = true;
                }

                $result->setCapability($capabilityName, $capabilityValue);
            }
        }

        $mapper  = new InputMapper();
        $version = new Version();

        $browserName = $mapper->mapBrowserName($apiBro);
        $deviceName  = $mapper->mapDeviceName($apiDev);

        $result->setCapability('mobile_browser', $browserName);
        $result->setCapability('mobile_browser_manufacturer', $mapper->mapBrowserMaker($browserMaker, $browserName));
        $result->setCapability(
            'mobile_browser_version',
            $version->setVersion($mapper->mapBrowserVersion($apiVer, $browserName))
        );
        $result->setCapability('device_os', $mapper->mapOsName($apiOs));
        $result->setCapability('model_name', $deviceName);
        $result->setCapability('manufacturer_name', $mapper->mapDeviceMaker($apiMan, $deviceName));
        $result->setCapability('marketing_name', $mapper->mapDeviceMarketingName($marketingName, $deviceName));
        $result->setCapability('brand_name', $mapper->mapDeviceBrandName($brandName, $deviceName));

        if ($apiBot) {
            $apiDesktop = false;
            $apiTv      = false;
            $apiMob     = false;
            $apiPhone   = false;

            $result->setCapability('pointing_method', null);
        }

        if (!$apiBro || !$device) {
            $apiDesktop = null;
            $apiTv      = null;
            $apiMob     = null;
            $apiBot     = null;
            $apiPhone   = null;
            $deviceType = null;
            $xhtmlLevel = null;
            $apiKey     = null;
        } else {
            $deviceType = $device->getVirtualCapability('form_factor');
        }

        if (!$apiPhone && $deviceType === 'Feature Phone') {
            $deviceType = 'Mobile Device';
        }

        if ($apiPhone && $deviceType === 'Tablet') {
            $deviceType = 'FonePad';
        }

        $result->setCapability('is_bot', $apiBot);
        $result->setCapability('is_smarttv', $apiTv);
        $result->setCapability('ux_full_desktop', $apiDesktop);
        $result->setCapability('is_wireless_device', $apiMob);
        $result->setCapability('is_tablet', $apiTab);
        $result->setCapability('is_transcoder', $apiTranscoder);
        $result->setCapability('can_assign_phone_number', $apiPhone);

        if ($apiDev || $apiBro) {
            $result->setCapability('xhtml_support_level', (int)$xhtmlLevel);
        }

        $result->setCapability('wurflKey', $apiKey);
        $result->setCapability('device_type', $mapper->mapDeviceType($deviceType));

        if (in_array($deviceType, array('Mobile Phone', 'Tablet', 'FonePad', 'Feature Phone', 'Mobile Device'))
            && 'true' === $device->getCapability('dual_orientation')
        ) {
            $width  = (int)$device->getCapability('resolution_width');
            $height = (int)$device->getCapability('resolution_height');

            if (in_array($deviceType, array('Mobile Phone', 'Feature Phone', 'Mobile Device'))) {
                $result->setCapability('resolution_width', min($height, $width));
                $result->setCapability('resolution_height', max($height, $width));
            } elseif (in_array($deviceType, array('Tablet', 'FonePad'))) {
                $result->setCapability('resolution_width', max($height, $width));
                $result->setCapability('resolution_height', min($height, $width));
            } else {
                $result->setCapability('resolution_width', $width);
                $result->setCapability('resolution_height', $height);
            }
        }

        return $result;
    }

    /**
     * returns the stored user agent
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getAgent();
    }
}

