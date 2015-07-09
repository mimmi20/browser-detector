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

namespace BrowserDetector\Detector\Device\Mobile\Apple;


use BrowserDetector\Detector\Browser\AbstractBrowser;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\AbstractDevice;
use BrowserDetector\Detector\Engine\AbstractEngine;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Os\AbstractOs;
use BrowserDetector\Detector\Os\Darwin;
use BrowserDetector\Detector\Os\Ios;
use BrowserDetector\Detector\Os\UnknownOs;

use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Ipod
    extends AbstractDevice
    implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'               => 'apple_ipod_touch_ver5', // not in wurfl

        // device
        'model_name'             => 'iPod Touch',
        'model_extra_info'       => null,
        'marketing_name'         => 'iPod Touch',
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'touchscreen',
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => null,
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => 50,
        'physical_screen_height' => 74,
        'columns'                => 20,
        'rows'                   => 20,
        'max_image_width'        => 320,
        'max_image_height'       => 360,
        'resolution_width'       => 320, // wurflkey: apple_ipod_touch_ver5
        'resolution_height'      => 480, // wurflkey: apple_ipod_touch_ver5
        'dual_orientation'       => true,
        'colors'                 => 65536,
        // sms
        'sms_enabled'            => false,
        // chips
        'nfc_support'            => false,
    );

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
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Type\Device\TypeInterface
     */
    public function getDeviceType()
    {
        return new DeviceType\MobileDevice();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Apple();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\Apple();
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\Os\AbstractOs
     */
    public function detectOs()
    {
        $os = array(
            new Ios(),
            new Darwin()
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
     * @param \BrowserDetector\Detector\Browser\AbstractBrowser $browser
     * @param \BrowserDetector\Detector\Engine\AbstractEngine  $engine
     * @param \BrowserDetector\Detector\Os\AbstractOs      $os
     *
     * @return \BrowserDetector\Detector\Device\Mobile\Apple\Ipod
     */
    public function detectDependProperties(
        AbstractBrowser $browser,
        AbstractEngine $engine,
        AbstractOs $os
    ) {
        $osVersion = $os->detectVersion()->getVersion(
            Version::MAJORONLY
        );

        if (6 <= $osVersion) {
            $this->setCapability('resolution_width', 640);
            $this->setCapability('resolution_height', 960);
        }

        $osVersion = $os->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        $this->setCapability('model_extra_info', $osVersion);

        $engine->setCapability('accept_third_party_cookie', false);
        $engine->setCapability('xhtml_make_phone_call_string', 'none');
        $engine->setCapability('xhtml_send_sms_string', 'none');
        $browser->setCapability('pdf_support', false);
        $engine->setCapability('css_gradient', 'none');
        $engine->setCapability('supports_java_applets', true);

        if (6.0 <= (float)$osVersion) {
            $this->setCapability('wurflKey', 'apple_ipod_touch_ver6');
        }

        $osVersion = $os->detectVersion()->getVersion();

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
