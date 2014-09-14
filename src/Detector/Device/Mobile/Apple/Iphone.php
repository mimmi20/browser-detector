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
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Iphone
    extends DeviceHandler
    implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'                => 'apple_iphone_ver1', // not in wurfl

        // device
        'model_name'              => 'iPhone',
        'model_extra_info'        => null,
        'marketing_name'          => 'iPhone',
        'has_qwerty_keyboard'     => true,
        'pointing_method'         => 'touchscreen',

        // product info
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
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 13794422;
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Type\Device\TypeInterface
     */
    public function getDeviceType()
    {
        return new DeviceType\MobilePhone();
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
     * @return \BrowserDetector\Detector\OsHandler
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
        $osVersion = $os->detectVersion()->getVersion();

        if (6 <= $osVersion) {
            $this->setCapability('resolution_width', 640);
            $this->setCapability('resolution_height', 960);
        }

        $this->setCapability('model_extra_info', $osVersion);

        if ('Safari' == $browser->getName()
            && !$browser->detectVersion()->getVersion()
        ) {
            $browser->detectVersion()->setVersion($osVersion);
        }

        parent::detectDependProperties($browser, $engine, $os);

        $engine->setCapability('accept_third_party_cookie', false);
        $engine->setCapability('xhtml_file_upload', 'not_supported');
        $engine->setCapability('xhtml_send_sms_string', 'sms:');
        $engine->setCapability('css_gradient', 'webkit');
        $engine->setCapability('accept_third_party_cookie', false);
        $engine->setCapability('accept_third_party_cookie', false);

        $osVersion = $os->detectVersion()->getVersion(
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

        $browserVersion = $browser->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        if (6.0 <= (float)$browserVersion) {
            $engine->setCapability('xhtml_file_upload', 'supported');
        }

        $osVersion = $os->detectVersion()->getVersion();

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