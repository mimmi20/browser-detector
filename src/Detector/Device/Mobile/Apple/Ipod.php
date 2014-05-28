<?php
namespace BrowserDetector\Detector\Device\Mobile\Apple;

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
use BrowserDetector\Detector\Os\Darwin;
use BrowserDetector\Detector\Os\Ios;
use BrowserDetector\Detector\Os\UnknownOs;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class Ipod
    extends DeviceHandler
    implements DeviceInterface
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
     * @return \BrowserDetector\Detector\Device\Mobile\Apple\Ipod
     */
    public function __construct()
    {
        parent::__construct();

        $this->properties = array(
            'wurflKey'                => 'apple_ipod_touch_ver5', // not in wurfl

            // kind of device
            'device_type'             => new DeviceType\MobileDevice(), // not in wurfl

            // device
            'model_name'              => 'iPod Touch',
            'manufacturer_name'       => new Company\Apple(),
            'brand_name'              => new Company\Apple(),
            'model_extra_info'        => null,
            'marketing_name'          => 'iPod Touch',
            'has_qwerty_keyboard'     => true,
            'pointing_method'         => 'touchscreen',

            // product info
            'can_assign_phone_number' => false,
            'ununiqueness_handler'    => null,
            'uaprof'                  => null,
            'uaprof2'                 => null,
            'uaprof3'                 => null,
            'unique'                  => true,

            // display
            'physical_screen_width'   => 50,
            'physical_screen_height'  => 74,
            'columns'                 => 20,
            'rows'                    => 20,
            'max_image_width'         => 320,
            'max_image_height'        => 360,
            'resolution_width'        => 320, // wurflkey: apple_ipod_touch_ver5
            'resolution_height'       => 480, // wurflkey: apple_ipod_touch_ver5
            'dual_orientation'        => true,
            'colors'                  => 65536,

            // sms
            'sms_enabled'             => false,

            // chips
            'nfc_support'             => false,
        );
    }

    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains('iPod')) {
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
        return 381078;
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
            new Ios(),
            new Darwin()
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
     * @return \BrowserDetector\Detector\Device\Mobile\Apple\Ipod
     */
    public function detectDependProperties(
        BrowserHandler $browser, EngineHandler $engine, OsHandler $os
    ) {
        $osVersion = $os->getVersion()->getVersion(
            Version::MAJORONLY
        );

        if (6 <= $osVersion) {
            $this->setCapability('resolution_width', 640);
            $this->setCapability('resolution_height', 960);
        }

        $osVersion = $os->getVersion()->getVersion(
            Version::MAJORMINOR
        );

        $this->setCapability('model_extra_info', $osVersion);

        parent::detectDependProperties($browser, $engine, $os);

        $engine->setCapability('accept_third_party_cookie', false);
        $engine->setCapability('xhtml_make_phone_call_string', 'none');
        $engine->setCapability('xhtml_send_sms_string', 'none');
        $browser->setCapability('pdf_support', false);
        $engine->setCapability('css_gradient', 'none');
        $engine->setCapability('supports_java_applets', true);

        if (6.0 <= (float)$osVersion) {
            $this->setCapability('wurflKey', 'apple_ipod_touch_ver6');
        }

        $osVersion = $os->getVersion()->getVersion();

        switch ($osVersion) {
        case '4.2.1':
            $this->setCapability('wurflKey', 'apple_ipod_touch_ver4_2_1_subua');
            break;
        case '4.3.5':
            $this->setCapability('wurflKey', 'apple_ipod_touch_ver4_3_5');
            break;
        default:
            // nothing to do here
            break;
        }
        if ('4.2.1' == $osVersion) {
        }

        return $this;
    }
}