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

namespace BrowserDetector\Detector\Device\Mobile\Amazon;

use BrowserDetector\Detector\BrowserHandler;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Os\AndroidOs;
use BrowserDetector\Detector\Os\Maemo;
use BrowserDetector\Detector\Os\UnknownOs;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Type\Device as DeviceType;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AmazonKftt extends DeviceHandler implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'               => 'amazon_kindle_fire_hd7_ver1_subuadesktop', // not in wurfl

        // device
        'model_name'             => 'KFTT',
        'model_extra_info'       => null,
        'marketing_name'         => 'Kindle Fire HD 7', // wurflkey: amazon_kindle_fire_hd7_ver1_subuanosilk
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'touchscreen', // wurflkey: amazon_kindle_fire_hd7_ver1_subuanosilk

        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => null,
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => 95,
        'physical_screen_height' => 151,
        'columns'                => 80,
        'rows'                   => 100,
        'max_image_width'        => 580,
        'max_image_height'       => 1000,
        'resolution_width'       => 1280,
        'resolution_height'      => 800,
        'dual_orientation'       => true,
        'colors'                 => 256,
        // sms
        'sms_enabled'            => true, // wurflkey: amazon_kindle_fire_hd7_ver1_subuadesktop

        // chips
        'nfc_support'            => true, // wurflkey: amazon_kindle_fire_hd7_ver1_subuadesktop
    );

    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains(array('KFTT'))) {
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
        return new Company\Amazon();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\Amazon();
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\OsHandler
     */
    public function detectOs()
    {
        $os = array(
            new AndroidOs(),
            new Maemo()
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
     * @return DeviceHandler
     */
    public function detectDependProperties(
        BrowserHandler $browser,
        EngineHandler $engine,
        OsHandler $os
    ) {
        parent::detectDependProperties($browser, $engine, $os);

        if ('Android Webkit' == $browser->getName() || 'Chrome' == $browser->getName()) {
            $this->setCapability('wurflKey', 'amazon_kindle_fire_hd7_ver1_subuanosilk');
        }

        $engine->setCapability('png', false);
        $engine->setCapability('jpg', false);
        $engine->setCapability('xhtml_preferred_charset', 'utf8');
        $engine->setCapability('transparent_png_index', false);
        $engine->setCapability('transparent_png_alpha', false);
        $engine->setCapability('max_url_length_in_requests', 128);
        $engine->setCapability('ajax_preferred_geoloc_api', 'none');
        $engine->setCapability('html_wi_oma_xhtmlmp_1_0', false);
        $engine->setCapability('wml_1_1', true);
        $engine->setCapability('wml_1_2', true);
        $engine->setCapability('wml_1_3', true);
        $engine->setCapability('xhtml_support_level', 1);
        $engine->setCapability('xhtmlmp_preferred_mime_type', 'application/vnd.wap.xhtml+xml');
        $engine->setCapability('xhtml_file_upload', 'not_supported');
        $engine->setCapability('xhtml_make_phone_call_string', 'none');
        $engine->setCapability('xhtml_allows_disabled_form_elements', false);
        $engine->setCapability('xhtml_can_embed_video', 'play_and_stop');
        $engine->setCapability('xhtml_format_as_css_property', true);
        $engine->setCapability('xhtml_marquee_as_css_property', true);
        $browser->setCapability('pdf_support', false);
        $engine->setCapability('is_sencha_touch_ok', true);

        return $this;
    }
}
