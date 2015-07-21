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

namespace BrowserDetector\Detector;

use BrowserDetector\Detector\Browser\AbstractBrowser;
use BrowserDetector\Detector\Device\AbstractDevice;
use BrowserDetector\Detector\Engine\AbstractEngine;
use BrowserDetector\Detector\MatcherInterface\Browser\BrowserHasWurflKeyInterface;
use BrowserDetector\Detector\MatcherInterface\Device\DeviceHasWurflKeyInterface;
use BrowserDetector\Detector\Os\AbstractOs;
use BrowserDetector\Helper\Utils;
use Psr\Log\LoggerInterface;
use Wurfl\WurflConstants;
use WurflData\Loader;

/**
 * Factory to build the detection result
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ResultFactory
{
    /**
     * builds the result object and set the values
     *
     * @param \BrowserDetector\Detector\Device\AbstractDevice   $device
     * @param \BrowserDetector\Detector\Os\AbstractOs           $os
     * @param \BrowserDetector\Detector\Browser\AbstractBrowser $browser
     * @param \BrowserDetector\Detector\Engine\AbstractEngine   $engine
     * @param \Psr\Log\LoggerInterface                          $logger
     *
     * @return \BrowserDetector\Detector\Result
     */
    public static function build(
        AbstractDevice $device,
        AbstractOs $os,
        AbstractBrowser $browser,
        AbstractEngine $engine,
        LoggerInterface $logger
    ) {
        if ($device->getDeviceType()->isMobile() && $device instanceof DeviceHasWurflKeyInterface) {
            $wurflKey = $device->getWurflKey($browser, $engine, $os);
        } elseif (!$device->getDeviceType()->isMobile() && $browser instanceof BrowserHasWurflKeyInterface) {
            $wurflKey = $browser->getWurflKey($os);
        } else {
            $wurflKey = WurflConstants::NO_MATCH;
        }

        $result = new Result($device, $os, $browser, $engine, $wurflKey);
        $result->setLogger($logger);

        $additionalData = Loader::load(strtolower($wurflKey), $logger);

        $properties = array_keys($result->getAllCapabilities());

        foreach ($properties as $property) {
            $value = null;

            try {
                switch ($property) {
                    case 'deviceClass':
                        $value = get_class($device);
                        break;
                    case 'browserClass':
                        $value = get_class($browser);
                        break;
                    case 'engineClass':
                        $value = get_class($engine);
                        break;
                    case 'osClass':
                        $value = get_class($os);
                        break;
                    case 'manufacturer_name':
                        $value = $this->getDeviceManufacturer()->getName();
                        break;
                    case 'brand_name':
                        $value = $this->getDeviceBrand()->getBrandName();
                        break;
                    case 'model_name':
                        $value = $this->getDeviceName();
                        break;
                    case 'marketing_name':
                        $value = $this->getDeviceMarketingName();
                        break;
                    case 'pointing_method':
                        $value = $this->getDevicePointingMethod();
                        break;
                    case 'resolution_width':
                        $value = $this->getDeviceResolutionWidth();
                        break;
                    case 'resolution_height':
                        $value = $this->getDeviceResolutionHeight();
                        break;
                    case 'dual_orientation':
                        $value = $this->hasDeviceDualOrientation();
                        break;
                    case 'colors':
                        $value = $this->getDeviceColors();
                        break;
                    case 'sms_enabled':
                        $value = $this->hasDeviceSmsEnabled();
                        break;
                    case 'nfc_support':
                        $value = $this->hasDeviceNfcSupport();
                        break;
                    case 'has_qwerty_keyboard':
                        $value = $this->hasDeviceQwertyKeyboard();
                        break;
                    case 'model_extra_info':
                        $value = $device->getCapability('model_extra_info', false);
                        break;
                    case 'pdf_support':
                        $value = $this->isPdfSupported();
                        break;
                    case 'rss_support':
                        $value = $this->isRssSupported();
                        break;
                    case 'basic_authentication_support':
                        $value = $browser->getCapability('basic_authentication_support', false);
                        break;
                    case 'post_method_support':
                        $value = $browser->getCapability('post_method_support', false);
                        break;
                    case 'device_type':
                    case 'controlcap_form_factor':
                        $value = $this->getDeviceType()->getName();
                        break;
                    case 'is_wireless_device':
                    case 'controlcap_is_mobile':
                        $value = $this->isMobileDevice();
                        break;
                    case 'is_tablet':
                        $value = $this->isTablet();
                        break;
                    case 'is_smarttv':
                        $value = $this->isTvDevice();
                        break;
                    case 'is_console':
                        $value = $this->isConsole();
                        break;
                    case 'ux_full_desktop':
                    case 'controlcap_is_full_desktop':
                        $value = $this->isDesktop();
                        break;
                    case 'can_assign_phone_number':
                    case 'controlcap_is_mobilephone':
                        $value = $this->isPhone();
                        break;
                    case 'controlcap_is_touchscreen':
                        $value = $this->hasDeviceTouchScreen();
                        break;
                    case 'controlcap_is_largescreen':
                        $value = ($this->getDeviceResolutionWidth() >= 480 && $this->getDeviceResolutionHeight() >= 480);
                        break;
                    case 'model_version':
                        $value = $device->detectVersion();
                        break;
                    case 'device_bits':
                        $detector = new Bits\Device();
                        $detector->setUserAgent($this->userAgent);

                        $value = $detector->getBits();
                        break;
                    case 'device_cpu':
                        $detector = new Cpu();
                        $detector->setUserAgent($this->userAgent);

                        $value = $detector->getCpu();
                        break;
                    case 'mobile_browser_manufacturer':
                        $value = $browser->getManufacturer();

                        if (!($value instanceof Company\CompanyInterface)) {
                            $value = new Company\Unknown();
                        }

                        $value = $value->getName();
                        break;
                    case 'mobile_browser_brand_name':
                        $value = $browser->getManufacturer();

                        if (!($value instanceof Company\CompanyInterface)) {
                            $value = new Company\Unknown();
                        }

                        $value = $value->getBrandName();
                        break;
                    case 'is_bot':
                    case 'controlcap_is_robot':
                        $value = $this->isCrawler();
                        break;
                    case 'is_transcoder':
                        $value = $this->isTranscoder();
                        break;
                    case 'is_syndication_reader':
                        $value = $this->isSyndicationReader();
                        break;
                    case 'is_banned':
                        $value = $this->isBanned();
                        break;
                    case 'browser_type':
                        $value = $this->getBrowserType()->getName();
                        break;
                    case 'mobile_browser':
                    case 'controlcap_advertised_browser':
                        $value = $browser->getName();
                        break;
                    case 'mobile_browser_modus':
                        $value = $browser->getCapability('mobile_browser_modus');
                        break;
                    case 'mobile_browser_version':
                    case 'controlcap_advertised_browser_version':
                        $value = $browser->detectVersion();
                        break;
                    case 'mobile_browser_bits':
                        $detector = new Bits\Browser();
                        $detector->setUserAgent($this->userAgent);

                        $value = $detector->getBits();
                        break;
                    case 'device_os_bits':
                        $detector = new Bits\Os();
                        $detector->setUserAgent($this->userAgent);

                        $value = $detector->getBits();
                        break;
                    case 'device_os':
                    case 'controlcap_advertised_device_os':
                        $value = $os->getName();
                        break;
                    case 'controlcap_is_windows_phone':
                        $value = ('Windows Phone OS' === $os->getName());
                        break;
                    case 'controlcap_is_android':
                        $value = ('Android' === $os->getName());
                        break;
                    case 'controlcap_is_ios':
                        $value = ('iOS' === $os->getName());
                        break;
                    case 'device_os_version':
                    case 'controlcap_advertised_device_os_version':
                        $value = $os->detectVersion();
                        break;
                    case 'device_os_manufacturer':
                        $value = $os->getManufacturer();

                        if (!($value instanceof Company\CompanyInterface)) {
                            $value = new Company\Unknown();
                        }

                        $value = $value->getName();
                        break;
                    case 'device_os_brand_name':
                        $value = $os->getManufacturer();

                        if (!($value instanceof Company\CompanyInterface)) {
                            $value = new Company\Unknown();
                        }

                        $value = $value->getBrandName();
                        break;
                    case 'renderingengine_manufacturer':
                        $value = $engine->getManufacturer();

                        if (!($value instanceof Company\CompanyInterface)) {
                            $value = new Company\Unknown();
                        }

                        $value = $value->getName();
                        break;
                    case 'renderingengine_brand_name':
                        $value = $engine->getManufacturer();

                        if (!($value instanceof Company\CompanyInterface)) {
                            $value = new Company\Unknown();
                        }

                        $value = $value->getBrandName();
                        break;
                    case 'renderingengine_version':
                        $value = $engine->detectVersion();
                        break;
                    case 'renderingengine_name':
                        $value = $engine->getName();
                        break;
                    case 'controlcap_is_xhtmlmp_preferred':
                        $value = ($engine->getCapability('xhtml_support_level') > 0
                            && strpos($engine->getCapability('preferred_markup'), 'html_web') !== 0);
                        break;
                    case 'controlcap_is_wml_preferred':
                        $value = ($engine->getCapability('xhtml_support_level') <= 0);
                        break;
                    case 'controlcap_is_html_preferred':
                        $value = (strpos($engine->getCapability('preferred_markup'), 'html_web') === 0);
                        break;
                    case 'controlcap_is_app':
                        $value = $this->isApp();
                        break;
                    case 'controlcap_is_smartphone':
                        $value = $this->isSmartphone();
                        break;
                    case 'cookie_support':
                        $value = $this->supportsCookies();
                        break;
                    case 'xhtml_table_support':
                        $value = $this->supportsTables();
                        break;
                    default:
                        if (is_array($additionalData) && array_key_exists($property, $additionalData)) {
                            $value = $additionalData[$property];
                        } else {
                            $value = null;
                        }
                        break;
                }
            } catch (\Exception $e) {
                // the property is not defined yet
                continue;
            }

            $this->setCapability($property, $value);
        }

        $renderedAs = $device->getRenderAs();

        if ($renderedAs instanceof Result) {
            $this->setRenderAs($renderedAs);
        }

        return $this;
    }
}
