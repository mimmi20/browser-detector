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
 * @version   SVN: $Id$
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
 * @version   SVN: $Id$
 */
class Iphone
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
     * @return \BrowserDetector\Detector\Device\Mobile\Apple\Iphone
     */
    public function __construct()
    {
        parent::__construct();

        $this->properties = array(
            'wurflKey'                => 'apple_iphone_ver1', // not in wurfl

            // kind of device
            'device_type'             => new DeviceType\MobilePhone(), // not in wurfl

            // device
            'model_name'              => 'iPhone',
            'model_version'           => null, // not in wurfl
            'manufacturer_name'       => new Company\Apple(),
            'brand_name'              => new Company\Apple(),
            'model_extra_info'        => null,
            'marketing_name'          => 'iPhone',
            'has_qwerty_keyboard'     => true,
            'pointing_method'         => 'touchscreen',
            'device_bits'             => null, // not in wurfl
            'device_cpu'              => null, // not in wurfl

            // product info
            'can_assign_phone_number' => true, // wurflkey: apple_iphone_ver6
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
            'max_image_height'        => 480,
            'resolution_width'        => 320,
            'resolution_height'       => 480,
            'dual_orientation'        => true,
            'colors'                  => 65536,

            // sms
            'sms_enabled'             => true,

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
        if (!$this->utils->checkIfContains('iPhone')) {
            return false;
        }

        if ($this->utils->checkIfContains(array('ipod', 'ipod touch', 'ipad', 'ipad'), true)) {
            return false;
        }

        return true;
    }

    /**
     * detects the device name from the given user agent
     *
     * @return \BrowserDetector\Detector\Device\Mobile\Apple\Iphone
     */
    public function detectDevice()
    {
        return $this;
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 13794422;
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
     * @return \BrowserDetector\Detector\Device\Mobile\Apple\Iphone
     */
    public function detectDependProperties(
        BrowserHandler $browser, EngineHandler $engine, OsHandler $os
    ) {
        $osVersion = $os->getCapability('device_os_version')->getVersion();

        if (6 <= $osVersion) {
            $this->setCapability('resolution_width', 640);
            $this->setCapability('resolution_height', 960);
        }

        $this->setCapability('model_extra_info', $osVersion);

        if ('Safari' == $browser->getCapability('mobile_browser')
            && !$browser->getCapability('mobile_browser_version')->getVersion()
        ) {
            $browser->getCapability('mobile_browser_version')->setVersion($osVersion);
        }

        parent::detectDependProperties($browser, $engine, $os);

        $engine->setCapability('accept_third_party_cookie', false);
        $engine->setCapability('xhtml_file_upload', 'not_supported');
        $engine->setCapability('xhtml_send_sms_string', 'sms:');
        $engine->setCapability('css_gradient', 'webkit');
        $engine->setCapability('accept_third_party_cookie', false);
        $engine->setCapability('accept_third_party_cookie', false);

        $osVersion = $os->getCapability('device_os_version')->getVersion(
            Version::MAJORMINOR
        );

        if (4.1 == (float)$osVersion) {
            $this->setCapability('wurflKey', 'apple_iphone_ver4_1');

            if ($this->utils->checkIfContains('Mobile/8B117')) {
                $this->setCapability('wurflKey', 'apple_iphone_ver4_1_sub8b117');
            }
        }

        if (5.0 == (float)$osVersion) {
            $this->setCapability('wurflKey', 'apple_iphone_ver5_subua');
        }

        if (5.1 == (float)$osVersion) {
            $this->setCapability('wurflKey', 'apple_iphone_ver5_1');
        }

        if (6.0 <= (float)$osVersion) {
            $this->setCapability('wurflKey', 'apple_iphone_ver6');
        }

        $browserVersion = $browser->getCapability('mobile_browser_version')->getVersion(
            Version::MAJORMINOR
        );

        if (6.0 <= (float)$browserVersion) {
            $engine->setCapability('xhtml_file_upload', 'supported');
        }

        $osVersion = $os->getCapability('device_os_version')->getVersion();

        switch ($osVersion) {
        case '3.1.3':
            $this->setCapability('wurflKey', 'apple_iphone_ver3_1_3_subenus');
            break;
        case '4.2.1':
            $this->setCapability('wurflKey', 'apple_iphone_ver4_2_1');
            break;
        case '4.3.0':
            $this->setCapability('wurflKey', 'apple_iphone_ver4_3');
            break;
        case '4.3.1':
            $this->setCapability('wurflKey', 'apple_iphone_ver4_3_1');
            break;
        case '4.3.2':
            $this->setCapability('wurflKey', 'apple_iphone_ver4_3_2');
            break;
        case '4.3.3':
            $this->setCapability('wurflKey', 'apple_iphone_ver4_3_3');
            break;
        case '4.3.4':
        case '4.3.5':
            $this->setCapability('wurflKey', 'apple_iphone_ver4_3_5');
            break;
        default:
            // nothing to do here
            break;
        }

        return $this;
    }
}