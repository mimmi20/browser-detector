<?php
namespace BrowserDetector\Detector\Device\Mobile\Amazon;

/**
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
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

use BrowserDetector\Detector\BrowserHandler;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Os\AndroidOs;
use BrowserDetector\Detector\Os\Maemo;
use BrowserDetector\Detector\Os\UnknownOs;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Type\Device as DeviceType;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class AmazonKftt
    extends DeviceHandler
    implements MatcherInterface, DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array();

    /**
     * Class Constructor
     *
     * @return \BrowserDetector\Detector\Device\Mobile\Amazon\AmazonKftt
     */
    public function __construct()
    {
        parent::__construct();

        $this->properties = array(
            'wurflKey'                => 'amazon_kindle_fire_hd7_ver1_subuadesktop', // not in wurfl

            // kind of device
            'device_type'             => new DeviceType\Tablet(), // not in wurfl

            // device
            'model_name'              => 'KFTT',
            'model_version'           => null, // not in wurfl
            'manufacturer_name'       => new Company\Amazon(),
            'brand_name'              => new Company\Amazon(),
            'model_extra_info'        => null,
            'marketing_name'          => 'Kindle Fire HD 7', // wurflkey: amazon_kindle_fire_hd7_ver1_subuanosilk
            'has_qwerty_keyboard'     => true,
            'pointing_method'         => 'touchscreen', // wurflkey: amazon_kindle_fire_hd7_ver1_subuanosilk
            'device_bits'             => null, // not in wurfl
            'device_cpu'              => 'TI OMAP4460', // not in wurfl

            // product info
            'can_assign_phone_number' => false,
            'ununiqueness_handler'    => null,
            'uaprof'                  => null,
            'uaprof2'                 => null,
            'uaprof3'                 => null,
            'unique'                  => true,

            // display
            'physical_screen_width'   => 95,
            'physical_screen_height'  => 151,
            'columns'                 => 80,
            'rows'                    => 100,
            'max_image_width'         => 580,
            'max_image_height'        => 1000,
            'resolution_width'        => 1280,
            'resolution_height'       => 800,
            'dual_orientation'        => true,
            'colors'                  => 256,

            // sms
            'sms_enabled'             => true, // wurflkey: amazon_kindle_fire_hd7_ver1_subuadesktop

            // chips
            'nfc_support'             => true, // wurflkey: amazon_kindle_fire_hd7_ver1_subuadesktop
        );
    }

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
     * detects the device name from the given user agent
     *
     * @return \BrowserDetector\Detector\Device\Mobile\Amazon\AmazonKftt
     */
    public function detectDevice()
    {
        return $this;
    }

    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\OsHandler
     */
    public function detectOs()
    {
        $os = array(
            new AndroidOs(),
            new Maemo()
        );

        $chain = new Chain();
        $chain->setDefaultHandler(new UnknownOs());
        $chain->setUseragent($this->_useragent);
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
        BrowserHandler $browser, EngineHandler $engine, OsHandler $os
    ) {
        parent::detectDependProperties($browser, $engine, $os);

        if ('Android Webkit' == $browser->getCapability('mobile_browser')) {
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