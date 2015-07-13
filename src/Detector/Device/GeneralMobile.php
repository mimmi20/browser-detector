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

namespace BrowserDetector\Detector\Device;

use BrowserDetector\Detector\Browser\AbstractBrowser;
use BrowserDetector\Detector\Browser\UnknownBrowser;

use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Engine\AbstractEngine;
use BrowserDetector\Detector\MatcherInterface\Device\DeviceHasChildrenInterface;
use BrowserDetector\Detector\MatcherInterface\Device\DeviceInterface;

use BrowserDetector\Detector\Os\AbstractOs;
use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\MobileDevice;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class GeneralMobile
    extends AbstractDevice
    implements DeviceInterface, DeviceHasChildrenInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'               => 'generic_mobile', // not in wurfl

        // device
        'model_name'             => 'general Mobile Device',
        'model_extra_info'       => null,
        'marketing_name'         => 'general Mobile Device',
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'touchscreen',
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => null,
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => 40,
        'physical_screen_height' => 60,
        'columns'                => 15,
        'rows'                   => 12,
        'max_image_width'        => 240,
        'max_image_height'       => 320,
        'resolution_width'       => 240,
        'resolution_height'      => 320,
        'dual_orientation'       => true,
        'colors'                 => 65536,
        // sms
        'sms_enabled'            => true,
        // chips
        'nfc_support'            => true,
    );
    /**
     * @var DeviceType\MobilePhone
     */
    private $deviceType = null;

    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        $mobileDeviceHelper = new MobileDevice();
        $mobileDeviceHelper->setUserAgent($this->useragent);

        if ($mobileDeviceHelper->isMobile()) {
            return true;
        }

        return false;
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 3;
    }

    /**
     * detects the device name from the given user agent
     *
     * @return \BrowserDetector\Detector\Device\AbstractDevice
     */
    public function detectDevice()
    {
        $chain = new Chain();
        $chain->setUserAgent($this->useragent);
        $chain->setNamespace('\BrowserDetector\Detector\Device\Mobile');
        $chain->setDirectory(
            __DIR__ . DIRECTORY_SEPARATOR . 'Mobile' . DIRECTORY_SEPARATOR
        );
        $chain->setDefaultHandler($this);

        $device = $chain->detect();

        if (($device !== $this) && ($device instanceof DeviceHasChildrenInterface)) {
            $device = $device->detectDevice();
        }

        return $device;
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Type\Device\TypeInterface
     */
    public function getDeviceType()
    {
        if (null === $this->deviceType) {
            $this->deviceType = new DeviceType\MobilePhone();
        }

        return $this->deviceType;
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Unknown();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\Unknown();
    }

    /**
     * returns the Browser which used on the device
     *
     * @return \BrowserDetector\Detector\Browser\AbstractBrowser
     */
    public function detectBrowser()
    {
        $browserPath = realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Browser' . DIRECTORY_SEPARATOR . 'Mobile' . DIRECTORY_SEPARATOR
        );

        $chain = new Chain();
        $chain->setUserAgent($this->useragent);
        $chain->setNamespace('\BrowserDetector\Detector\Browser\Mobile');
        $chain->setDirectory($browserPath);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }

    /**
     * detects properties who are depending on the device version or the user
     * agent
     *
     * @return \BrowserDetector\Detector\Device\GeneralMobile
     */
    public function detectSpecialProperties()
    {
        if ($this->utils->checkIfContains(array('Android; Tablet'))) {
            $this->deviceType = new DeviceType\Tablet();

            $this->setCapability('physical_screen_width', 112);
            $this->setCapability('physical_screen_height', 187);
            $this->setCapability('columns', 40);
            $this->setCapability('rows', 40);
            $this->setCapability('max_image_width', 320);
            $this->setCapability('max_image_height', 400);
            $this->setCapability('resolution_width', 800);
            $this->setCapability('resolution_height', 480);
            $this->setCapability('dual_orientation', true);
            $this->setCapability('sms_enabled', true);
            $this->setCapability('nfc_support', true);

            return $this;
        }

        if ($this->utils->checkIfContains(array('Android; Mobile', 'Android; Linux'))) {
            $this->deviceType = new DeviceType\MobilePhone();

            return $this;
        }

        if ($this->utils->checkIfContains(array('Opera Tablet'))) {
            $this->deviceType = new DeviceType\Tablet();

            $this->setCapability('physical_screen_width', 100);
            $this->setCapability('physical_screen_height', 200);
            $this->setCapability('columns', 60);
            $this->setCapability('rows', 40);
            $this->setCapability('max_image_width', 480);
            $this->setCapability('max_image_height', 640);
            $this->setCapability('resolution_width', 640); // 1280 bei Ver 11, Android 3.2
            $this->setCapability('resolution_height', 480); // 768 bei Ver 11, Android 3.2
            $this->setCapability('dual_orientation', true);

            return $this;
        }

        if ($this->utils->checkIfContains(array('XBLWP7', 'ZuneWP7'))) {
            $this->deviceType = new DeviceType\MobilePhone();

            $this->setCapability('physical_screen_width', 50);
            $this->setCapability('physical_screen_height', 84);
            $this->setCapability('columns', 12);
            $this->setCapability('rows', 20);
            $this->setCapability('max_image_width', 320);
            $this->setCapability('max_image_height', 480);
            $this->setCapability('resolution_width', 480);
            $this->setCapability('resolution_height', 800);
            $this->setCapability('dual_orientation', true);
            $this->setCapability('has_qwerty_keyboard', true);
            $this->setCapability('pointing_method', 'touchscreen');
            $this->setCapability('sms_enabled', true);
            $this->setCapability('nfc_support', true);

            $this->setCapability('wurflKey', 'generic_ms_phone_os7_5_desktopmode');

            return $this;
        }

        if ($this->utils->checkIfContains(array('Opera Mobi'))) {
            $this->deviceType = new DeviceType\MobilePhone();

            $this->setCapability('physical_screen_width', 34);
            $this->setCapability('physical_screen_height', 50);
            $this->setCapability('columns', 60);
            $this->setCapability('rows', 40);
            $this->setCapability('max_image_width', 320);
            $this->setCapability('max_image_height', 400);
            $this->setCapability('resolution_width', 320);
            $this->setCapability('resolution_height', 480);
            $this->setCapability('dual_orientation', true);
            $this->setCapability('has_qwerty_keyboard', true);
            $this->setCapability('pointing_method', 'touchscreen');

            $this->setCapability('wurflKey', 'generic_android_ver4_0_opera_mobi');

            return $this;
        }

        if ($this->utils->checkIfContains(array('Opera Mini'))) {
            $this->deviceType = new DeviceType\MobilePhone();

            $this->setCapability('physical_screen_width', 34);
            $this->setCapability('physical_screen_height', 50);
            $this->setCapability('columns', 60);
            $this->setCapability('rows', 40);
            $this->setCapability('max_image_width', 320);
            $this->setCapability('max_image_height', 400);
            $this->setCapability('resolution_width', 320);
            $this->setCapability('resolution_height', 480);
            $this->setCapability('dual_orientation', true);
            $this->setCapability('has_qwerty_keyboard', true);
            $this->setCapability('pointing_method', 'touchscreen');

            $this->setCapability('wurflKey', 'generic_opera_mini_android');

            return $this;
        }

        if ($this->utils->checkIfContains(array('Windows Phone 6.5'))) {
            $this->deviceType = new DeviceType\MobilePhone();

            $this->setCapability('physical_screen_width', 34);
            $this->setCapability('physical_screen_height', 50);
            $this->setCapability('columns', 60);
            $this->setCapability('rows', 40);
            $this->setCapability('max_image_width', 320);
            $this->setCapability('max_image_height', 400);
            $this->setCapability('resolution_width', 320);
            $this->setCapability('resolution_height', 480);
            $this->setCapability('dual_orientation', false);
            $this->setCapability('has_qwerty_keyboard', false);
            $this->setCapability('pointing_method', 'stylus');
            $this->setCapability('colors', 4096);

            $this->setCapability('wurflKey', 'generic_opera_mini_android');

            return $this;
        }

        if ($this->utils->checkIfContainsAll(array('Windows NT', 'Touch'))) {
            $this->deviceType = new DeviceType\Tablet();

            $this->setCapability('physical_screen_width', 100);
            $this->setCapability('physical_screen_height', 200);
            $this->setCapability('columns', 60);
            $this->setCapability('rows', 40);
            $this->setCapability('max_image_width', 480);
            $this->setCapability('max_image_height', 640);
            $this->setCapability('resolution_width', 640);
            $this->setCapability('resolution_height', 480);
            $this->setCapability('dual_orientation', true);

            return $this;
        }

        if ($this->utils->checkIfContains(array('Mobile'))) {
            $this->deviceType = new DeviceType\MobilePhone();

            $this->setCapability('physical_screen_width', 34);
            $this->setCapability('physical_screen_height', 50);
            $this->setCapability('columns', 60);
            $this->setCapability('rows', 40);
            $this->setCapability('max_image_width', 320);
            $this->setCapability('max_image_height', 400);
            $this->setCapability('resolution_width', 320);
            $this->setCapability('resolution_height', 480);
            $this->setCapability('dual_orientation', false);
            $this->setCapability('has_qwerty_keyboard', false);
            $this->setCapability('pointing_method', 'stylus');
            $this->setCapability('colors', 4096);

            return $this;
        }

        return $this;
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\Browser\AbstractBrowser $browser
     * @param \BrowserDetector\Detector\Engine\AbstractEngine  $engine
     * @param \BrowserDetector\Detector\Os\AbstractOs      $os
     *
     * @return \BrowserDetector\Detector\Device\GeneralMobile
     */
    public function detectDependProperties(
        AbstractBrowser $browser,
        AbstractEngine $engine,
        AbstractOs $os
    ) {
        $engine->setCapability('bmp', false);
        $engine->setCapability('wbmp', false);
        $engine->setCapability('tiff', false);

        $brwoserName = $browser->getName();

        switch ($brwoserName) {
            case 'Firefox':
                if ('Android' == $os->getName()) {
                    $os->detectVersion()->setVersion('2.0');

                    if ($this->getDeviceType()->isTablet()) {
                        $this->setCapability('wurflKey', 'generic_android_ver2_0_fennec_tablet');
                    } else {
                        $this->setCapability('wurflKey', 'generic_android_ver2_0_fennec');

                        $engine->setCapability('wbmp', true);
                    }
                }
                break;
            case 'Opera Mobile':
                if ('Android' == $os->getName()) {
                    $osVersion = $os->detectVersion()->getVersion(Version::MAJORMINOR);

                    switch ((float)$osVersion) {
                        case 4.0:
                            $this->setCapability('wurflKey', 'generic_android_ver4_0_opera_mobi');
                            $engine->setCapability('html_wi_oma_xhtmlmp_1_0', true);
                            $engine->setCapability('wml_1_1', true);
                            $engine->setCapability('chtml_table_support', false);
                            $engine->setCapability('xhtml_select_as_radiobutton', false);
                            $engine->setCapability('xhtml_select_as_dropdown', false);
                            $engine->setCapability('xhtml_select_as_popup', false);
                            $engine->setCapability('xhtml_supports_css_cell_table_coloring', true);
                            $engine->setCapability('xhtml_allows_disabled_form_elements', true);
                            $engine->setCapability('xhtml_table_support', true);
                            $engine->setCapability('xhtml_supports_table_for_layout', true);
                            $engine->setCapability('wbmp', true);
                            $engine->setCapability('canvas_support', 'full');
                            $engine->setCapability('viewport_width', 'device_width_token');
                            $engine->setCapability('viewport_supported', true);
                            $engine->setCapability('viewport_userscalable', 'no');
                            $engine->setCapability('css_border_image', 'opera');
                            $engine->setCapability('css_rounded_corners', 'opera');
                            break;
                        case 4.1:
                            $this->setCapability('wurflKey', 'uabait_opera_mobi_android_4_1_ver12');
                            break;
                        default:
                            // nothing to do here
                            break;
                    }
                } elseif ('Windows Mobile OS' == $os->getName()) {
                    $this->setCapability('has_qwerty_keyboard', false);
                    $this->setCapability('pointing_method', 'stylus');
                    $this->setCapability('resolution_width', 240);
                    $this->setCapability('resolution_height', 320);
                    $this->setCapability('dual_orientation', false);
                    $this->setCapability('colors', 4096);
                } elseif ('Symbian OS' == $os->getName()) {
                    $this->setCapability('has_qwerty_keyboard', false);
                    $this->setCapability('pointing_method', null);
                    $this->setCapability('resolution_width', 240);
                    $this->setCapability('resolution_height', 320);
                    $this->setCapability('dual_orientation', false);
                    $this->setCapability('colors', 4096);
                }
                break;
            case 'Opera Tablet':
                if ('Android' == $os->getName()) {
                    $osVersion = $os->detectVersion()->getVersion(Version::MAJORMINOR);

                    if (3.2 == (float)$osVersion) {
                        $this->setCapability('wurflKey', 'generic_android_ver3_2_opera_tablet');
                        $engine->setCapability('html_wi_oma_xhtmlmp_1_0', true);
                        $engine->setCapability('wml_1_1', true);
                        $engine->setCapability('chtml_table_support', false);
                        $engine->setCapability('xhtml_select_as_radiobutton', false);
                        $engine->setCapability('xhtml_select_as_dropdown', false);
                        $engine->setCapability('xhtml_select_as_popup', false);
                        $engine->setCapability('xhtml_supports_css_cell_table_coloring', true);
                        $engine->setCapability('xhtml_allows_disabled_form_elements', true);
                        $engine->setCapability('xhtml_table_support', true);
                        $engine->setCapability('xhtml_supports_table_for_layout', true);
                        $engine->setCapability('wbmp', true);
                        $engine->setCapability('canvas_support', 'full');
                        $engine->setCapability('viewport_width', 'device_width_token');
                        $engine->setCapability('viewport_supported', true);
                        $engine->setCapability('viewport_userscalable', 'no');
                        $engine->setCapability('css_border_image', 'opera');
                        $engine->setCapability('css_rounded_corners', 'opera');

                        $this->setCapability('resolution_width', 1280);
                        $this->setCapability('resolution_height', 768);
                    }
                }
                break;
            case 'Opera Mini':
                if ('Android' == $os->getName()) {
                    $osVersion = $os->detectVersion()->getVersion(Version::MAJORMINOR);

                    if (5.0 == (float)$osVersion) {
                        $this->setCapability('wurflKey', 'generic_opera_mini_android_version5');
                    }

                    $this->setCapability('resolution_width', 240);
                    $this->setCapability('resolution_height', 320);
                    $this->setCapability('dual_orientation', false);
                } elseif ('Java' == $os->getName()) {
                    $this->setCapability('wurflKey', 'uabait_opera_mini_v10_op98');
                    $this->setCapability('colors', 256);
                }
                break;
            case 'Android Webkit':
                if ('Android' == $os->getName()) {
                    $this->setCapability('has_qwerty_keyboard', true);
                    $this->setCapability('pointing_method', 'touchscreen');
                }
                break;
            case 'Internet Explorer':
            case 'IEMobile':
                if ('Windows Mobile OS' == $os->getName()) {
                    $osVersion = $os->detectVersion()->getVersion(Version::MAJORMINOR);

                    if (6.5 == (float)$osVersion) {
                        $engine->setCapability('html_wi_oma_xhtmlmp_1_0', true);
                        $engine->setCapability('wml_1_1', true);
                        $engine->setCapability('chtml_table_support', false);
                        $engine->setCapability('xhtml_select_as_radiobutton', false);
                        $engine->setCapability('xhtml_select_as_dropdown', false);
                        $engine->setCapability('xhtml_select_as_popup', false);
                        $engine->setCapability('xhtml_supports_css_cell_table_coloring', true);
                        $engine->setCapability('xhtml_allows_disabled_form_elements', true);
                        $engine->setCapability('xhtml_table_support', true);
                        $engine->setCapability('xhtml_supports_table_for_layout', true);
                        $engine->setCapability('wbmp', true);
                        $engine->setCapability('canvas_support', 'full');
                        $engine->setCapability('viewport_width', 'device_width_token');
                        $engine->setCapability('viewport_supported', true);
                        $engine->setCapability('viewport_userscalable', 'no');
                        $engine->setCapability('css_border_image', 'opera');
                        $engine->setCapability('css_rounded_corners', 'opera');

                        $browser->setCapability('rss_support', true);
                    }
                }
                break;
            default:
                // nothing to do
                break;
        }

        if ($this->utils->checkIfContains(array('XBLWP7', 'ZuneWP7', 'WPDesktop'))) {
            $browser->setCapability('mobile_browser_modus', 'Desktop Mode');
        }

        if ($this->getDeviceType()->isTablet()) {
            $this->setCapability('sms_enabled', false);
            $this->setCapability('nfc_support', false);
        } else {
            $this->setCapability('sms_enabled', true);
            $this->setCapability('nfc_support', true);
        }

        return $this;
    }
}
