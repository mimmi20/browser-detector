<?php
namespace BrowserDetector\Detector\Device\Mobile\Samsung;

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
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
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
class SamsungGti9000
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
     * @return DeviceHandler
     */
    public function __construct()
    {
        parent::__construct();

        $this->properties = array(
            'wurflKey'                => 'samsung_gt_i9000_ver1', // not in wurfl

            // kind of device
            'device_type'             => new DeviceType\MobilePhone(), // not in wurfl

            // device
            'model_name'              => 'GT-I9000',
            'model_version'           => null, // not in wurfl
            'manufacturer_name'       => new Company\Samsung(),
            'brand_name'              => new Company\Samsung(),
            'model_extra_info'        => null,
            'marketing_name'          => 'Galaxy S',
            'has_qwerty_keyboard'     => false,
            'pointing_method'         => 'touchscreen',
            'device_bits'             => null, // not in wurfl
            'device_cpu'              => 'ARM11', // not in wurfl

            // product info
            'can_assign_phone_number' => true, // wurflkey: samsung_gt_i9000_ver1_suban233bis
            'ununiqueness_handler'    => null,
            'uaprof'                  => 'http://wap.samsungmobile.com/uaprof/GT-i9000.xml',
            'uaprof2'                 => 'http://wap.samsungmobile.com/uaprof/GT-I9000.xml',
            'uaprof3'                 => null,
            'unique'                  => true,

            // display
            'physical_screen_width'   => 53,
            'physical_screen_height'  => 88,
            'columns'                 => 15,
            'rows'                    => 12,
            'max_image_width'         => 320,
            'max_image_height'        => 452,
            'resolution_width'        => 480,
            'resolution_height'       => 800,
            'dual_orientation'        => true,
            'colors'                  => 16777216,

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
        if (!$this->utils->checkIfContains(array('GT-I9000', 'GT-i9000', 'SGH-T959V'))) {
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
        return 558995;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
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
        $handler = new \BrowserDetector\Detector\Os\Android();
        $handler->setUseragent($this->_useragent);

        return $handler->detect();
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @return DeviceHandler
     */
    public function detectDependProperties(
        BrowserHandler $browser, EngineHandler $engine, OsHandler $os
    ) {
        parent::detectDependProperties($browser, $engine, $os);

        $engine->setCapability('xhtml_can_embed_video', 'play_and_stop');
        $engine->setCapability('supports_java_applets', false);

        $osVersion = $os->getCapability('device_os_version')->getVersion(
            Version::MAJORMINOR
        );

        switch ($browser->getCapability('mobile_browser')) {
        case 'Android Webkit':
            switch ((float)$osVersion) {
            case 2.1:
                $engineVersion = $engine->getCapability('renderingengine_version')->getVersion(Version::MAJORMINOR);

                if ('530.17' == $engineVersion) {
                    $this->setCapability('wurflKey', 'samsung_gt_i9000_ver1_sub53017');
                }
                break;
            case 2.2:
                $this->setCapability('wurflKey', 'samsung_gt_i9000_ver1_suban221');
                break;
            case 2.3:
                $this->setCapability('wurflKey', 'samsung_gt_i9000_ver1_suban233bis');
                break;
            case 4.0:
                $this->setCapability('wurflKey', 'samsung_gt_i9100_ver1_suban40');
                break;
            case 3.1:
            case 3.2:
            case 4.1:
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
                $this->setCapability('wurflKey', 'samsung_gt_i9100_ver1_suban40chrome');
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

        return $this;
    }
}