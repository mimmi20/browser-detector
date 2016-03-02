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

namespace BrowserDetector\Detector\Result;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Company\Unknown as UnknownCompany;
use BrowserDetector\Detector\Cpu;
use Psr\Log\LoggerInterface;
use UaMatcher\Browser\BrowserHasWurflKeyInterface;
use UaResult\Browser\BrowserInterface;
use UaResult\Company\CompanyInterface;
use UaMatcher\Device\DeviceHasVersionInterface;
use UaMatcher\Device\DeviceHasWurflKeyInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Engine\EngineInterface;
use UaResult\Os\OsInterface;
use UaResult\Result\ResultFactoryInterface;
use Wurfl\WurflConstants;
use WurflData\Loader;

/**
 * Factory to build the detection result
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ResultFactory implements ResultFactoryInterface
{
    /**
     * builds the result object and set the values
     *
     * @param string                             $useragent
     * @param \Psr\Log\LoggerInterface           $logger
     * @param \UaResult\Device\DeviceInterface   $device
     * @param \UaResult\Os\OsInterface           $os
     * @param \UaResult\Browser\BrowserInterface $browser
     * @param \UaResult\Engine\EngineInterface   $engine
     *
     * @return \UaResult\Result\ResultInterface
     */
    public static function build(
        $useragent,
        LoggerInterface $logger = null,
        DeviceInterface $device = null,
        OsInterface $os = null,
        BrowserInterface $browser = null,
        EngineInterface $engine = null
    ) {
        if ($device->getDeviceType()->isMobile() && $device instanceof DeviceHasWurflKeyInterface) {
            $wurflKey = $device->getWurflKey($browser, $engine, $os);
        } elseif (!$device->getDeviceType()->isMobile() && $browser instanceof BrowserHasWurflKeyInterface) {
            $wurflKey = $browser->getWurflKey($os);
        } else {
            $wurflKey = WurflConstants::NO_MATCH;
        }

        $result = new Result($useragent, $logger, $wurflKey, $device, $os, $browser, $engine);

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
                        $value = $result->getDeviceManufacturer()->getName();
                        break;
                    case 'brand_name':
                        $value = $result->getDeviceBrand()->getBrandName();
                        break;
                    case 'code_name':
                        $value = $result->getDeviceName();
                        break;
                    case 'marketing_name':
                        $value = $result->getDeviceMarketingName();
                        break;
                    case 'pointing_method':
                        $value = $result->getDevicePointingMethod();
                        break;
                    case 'resolution_width':
                        $value = $result->getDeviceResolutionWidth();
                        break;
                    case 'resolution_height':
                        $value = $result->getDeviceResolutionHeight();
                        break;
                    case 'dual_orientation':
                        $value = $result->hasDeviceDualOrientation();
                        break;
                    case 'colors':
                        $value = $result->getDeviceColors();
                        break;
                    case 'sms_enabled':
                        $value = $result->hasDeviceSmsEnabled();
                        break;
                    case 'nfc_support':
                        $value = $result->hasDeviceNfcSupport();
                        break;
                    case 'has_qwerty_keyboard':
                        $value = $result->hasDeviceQwertyKeyboard();
                        break;
                    case 'model_extra_info':
                        $value = $device->getCapability('model_extra_info');
                        break;
                    case 'pdf_support':
                        $value = $result->isPdfSupported();
                        break;
                    case 'rss_support':
                        $value = $result->isRssSupported();
                        break;
                    case 'basic_authentication_support':
                        $value = $browser->getCapability('basic_authentication_support');
                        break;
                    case 'post_method_support':
                        $value = $browser->getCapability('post_method_support');
                        break;
                    case 'device_type':
                    case 'controlcap_form_factor':
                        $value = $result->getDeviceType()->getName();
                        break;
                    case 'is_wireless_device':
                    case 'controlcap_is_mobile':
                        $value = $result->isMobileDevice();
                        break;
                    case 'is_tablet':
                        $value = $result->isTablet();
                        break;
                    case 'is_smarttv':
                        $value = $result->isTvDevice();
                        break;
                    case 'is_console':
                        $value = $result->isConsole();
                        break;
                    case 'ux_full_desktop':
                    case 'controlcap_is_full_desktop':
                        $value = $result->isDesktop();
                        break;
                    case 'can_assign_phone_number':
                    case 'controlcap_is_mobilephone':
                        $value = $result->isPhone();
                        break;
                    case 'controlcap_is_touchscreen':
                        $value = $result->hasDeviceTouchScreen();
                        break;
                    case 'controlcap_is_largescreen':
                        $value = ($result->getDeviceResolutionWidth() >= 480 && $result->getDeviceResolutionHeight() >= 480);
                        break;
                    case 'model_version':
                        if ($device instanceof DeviceHasVersionInterface) {
                            $value = $device->detectDeviceVersion();
                        } else {
                            $value = null;
                        }
                        break;
                    case 'device_bits':
                        $value = $device->detectBits();
                        break;
                    case 'device_cpu':
                        $detector = new Cpu();
                        $detector->setUserAgent($useragent);

                        $value = $detector->getCpu();
                        break;
                    case 'mobile_browser_manufacturer':
                        /** @var \UaMatcher\Company\CompanyInterface $company */
                        $company = $browser->getManufacturer();

                        if (!($company instanceof CompanyInterface)) {
                            $company = new Company(new UnknownCompany());
                        }

                        $value = $company->getName();
                        break;
                    case 'mobile_browser_brand_name':
                        /** @var \UaMatcher\Company\CompanyInterface $company */
                        $company = $browser->getManufacturer();

                        if (!($company instanceof CompanyInterface)) {
                            $company = new Company(new UnknownCompany());
                        }

                        $value = $company->getBrandName();
                        break;
                    case 'is_bot':
                    case 'controlcap_is_robot':
                        $value = $result->isCrawler();
                        break;
                    case 'is_transcoder':
                        $value = $result->isTranscoder();
                        break;
                    case 'is_syndication_reader':
                        $value = $result->isSyndicationReader();
                        break;
                    case 'is_banned':
                        $value = $result->isBanned();
                        break;
                    case 'browser_type':
                        $value = $result->getBrowserType()->getName();
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
                        $value = $browser->detectBits();
                        break;
                    case 'device_os_bits':
                        $value = $os->detectBits();
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
                        /** @var \UaMatcher\Company\CompanyInterface $company */
                        $company = $os->getManufacturer();

                        if (!($company instanceof CompanyInterface)) {
                            $company = new Company(new UnknownCompany());
                        }

                        $value = $company->getName();
                        break;
                    case 'device_os_brand_name':
                        /** @var \UaMatcher\Company\CompanyInterface $company */
                        $company = $os->getManufacturer();

                        if (!($company instanceof CompanyInterface)) {
                            $company = new Company(new UnknownCompany());
                        }

                        $value = $company->getBrandName();
                        break;
                    case 'renderingengine_manufacturer':
                        /** @var \UaMatcher\Company\CompanyInterface $company */
                        $company = $engine->getManufacturer();

                        if (!($company instanceof CompanyInterface)) {
                            $company = new Company(new UnknownCompany());
                        }

                        $value = $company->getName();
                        break;
                    case 'renderingengine_brand_name':
                        /** @var \UaMatcher\Company\CompanyInterface $company */
                        $company = $engine->getManufacturer();

                        if (!($company instanceof CompanyInterface)) {
                            $company = new Company(new UnknownCompany());
                        }

                        $value = $company->getBrandName();
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
                        $value = $result->isApp();
                        break;
                    case 'controlcap_is_smartphone':
                        $value = $result->isSmartphone();
                        break;
                    case 'cookie_support':
                        $value = $result->supportsCookies();
                        break;
                    case 'xhtml_table_support':
                        $value = $result->supportsTables();
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

            $result->setCapability($property, $value);
        }

        $renderedAs = $device->getRenderAs();

        if ($renderedAs instanceof Result) {
            $result->setRenderAs($renderedAs);
        }

        return $result;
    }
}
