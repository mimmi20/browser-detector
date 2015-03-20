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

namespace BrowserDetector\Detector\Device\Mobile\Hp;

use BrowserDetector\Detector\BrowserHandler;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Os\AndroidOs;
use BrowserDetector\Detector\Os\UnknownOs;
use BrowserDetector\Detector\Os\WebOs;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class HpTouchpad
    extends DeviceHandler
    implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'               => 'hp_touchpad_ver1', // not in wurfl

        // device
        'model_name'             => 'Touchpad',
        'model_extra_info'       => null,
        'marketing_name'         => 'Touchpad',
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'touchscreen',
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => 'http://downloads.palm.com/profiles/HSTNH-I29C_R1.xml',
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => 100,
        'physical_screen_height' => 200,
        'columns'                => 100,
        'rows'                   => 50,
        'max_image_width'        => 768,
        'max_image_height'       => 1000,
        'resolution_width'       => 1024,
        'resolution_height'      => 768,
        'dual_orientation'       => true,
        'colors'                 => 262144,
        // sms
        'sms_enabled'            => true, // wurflkey: hp_touchpad_ver1

        // chips
        'nfc_support'            => true, // wurflkey: hp_touchpad_ver1
    );

    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains(array('TouchPad', 'Touchpad', 'cm_tenderloin'))) {
            return false;
        }

        return true;
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
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Type\Device\TypeInterface
     */
    public function getDeviceType()
    {
        return new DeviceType\Tablet();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Hp();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\Hp();
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\OsHandler
     */
    public function detectOs()
    {
        $os = array(
            new WebOs(),
            new AndroidOs()
        );

        $chain = new Chain();
        $chain->setDefaultHandler(new UnknownOs());
        $chain->setUseragent($this->useragent);
        $chain->setHandlers($os);

        return $chain->detect();
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\BrowserHandler $browser
     * @param \BrowserDetector\Detector\EngineHandler  $engine
     * @param \BrowserDetector\Detector\OsHandler      $os
     *
     * @return \BrowserDetector\Detector\Device\Mobile\Hp\HpTouchpad
     */
    public function detectDependProperties(
        BrowserHandler $browser,
        EngineHandler $engine,
        OsHandler $os
    ) {
        parent::detectDependProperties($browser, $engine, $os);

        $engine->setCapability('xhtml_avoid_accesskeys', false);
        $engine->setCapability('xhtml_supports_forms_in_table', false);
        $engine->setCapability('xhtml_allows_disabled_form_elements', false);
        $engine->setCapability('xhtml_supports_invisible_text', false);
        $engine->setCapability('bmp', true); // wurflkey: hp_touchpad_ver1
        $engine->setCapability('ajax_support_javascript', true);

        if (('Android Webkit' == $browser->getName() || 'Chrome' == $browser->getName()) && 'Android' == $os->getName()
        ) {
            $this->setCapability('wurflKey', 'hp_touchpad_android_ver1');
            $this->setCapability('model_extra_info', 'Android port');
            $this->setCapability('colors', 65536);

            $osVersion = $os->detectVersion()->getVersion(
                Version::MAJORMINOR
            );

            switch ($browser->getName()) {
                case 'Android Webkit':
                    switch ((float)$osVersion) {
                        case 4.0:
                            $this->setCapability('wurflKey', 'hp_touchpad_android_ver1_suban40rom');
                            break;
                        case 2.1:
                        case 2.2:
                        case 2.3:
                        case 3.1:
                        case 3.2:
                        case 4.2:
                        default:
                            // nothing to do here
                            break;
                    }
                    break;
                case 'Chrome':
                    $engine->setCapability('is_sencha_touch_ok', false);

                    switch ((float)$osVersion) {
                        case 4.0:
                            $this->setCapability('wurflKey', 'hp_touchpad_android_ver1_suban40rom');
                            break;
                        case 2.1:
                        case 2.2:
                        case 2.3:
                        case 3.1:
                        case 3.2:
                        case 4.1:
                        case 4.2:
                        default:
                            // nothing to do here
                            break;
                    }
                    break;
                default:
                    // nothing to do here
                    break;
            }
        }

        return $this;
    }
}
