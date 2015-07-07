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

namespace BrowserDetector\Detector\Device\Mobile\SonyEricsson;


use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\AbstractDevice;
use BrowserDetector\Detector\Engine\AbstractEngine;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Os\AndroidOs;
use BrowserDetector\Detector\Os\Symbianos;
use BrowserDetector\Detector\Os\UnknownOs;

use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class SonyEricssonU20i
    extends AbstractDevice
    implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'               => 'sonyericsson_u20i_ver1_suban21', // not in wurfl

        // device
        'model_name'             => 'U20i',
        'model_extra_info'       => null,
        'marketing_name'         => 'Xperia X10 Mini pro',
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'touchscreen',
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => 'http://wap.sonyericsson.com/UAprof/U20iR201.xml',
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => 40,
        'physical_screen_height' => 60,
        'columns'                => 25,
        'rows'                   => 21,
        'max_image_width'        => 238,
        'max_image_height'       => 318,
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
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains(array('SonyEricssonU20i', 'U20i', ' u20i '))) {
            return false;
        }

        if ($this->utils->checkIfContains(array('SonyEricssonU20iv', 'U20iv'))) {
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
        return new DeviceType\MobilePhone();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\SonyEricsson();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\SonyEricsson();
    }

    /**
     * detects properties who are depending on the device version or the user
     * agent
     *
     * @return AbstractDevice
     */
    public function detectSpecialProperties()
    {
        if ($this->utils->checkIfContains(array('Build/1.1'))) {
            $this->setCapability(
                'uaprof',
                'http://wap.sonyericsson.com/UAprof/U20iR102.xml'
            );
        }

        return $this;
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\Os\AbstractOs
     */
    public function detectOs()
    {
        $os = array(
            new Symbianos(),
            new AndroidOs(),
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
     * @return \BrowserDetector\Detector\Device\Mobile\SonyEricsson\SonyEricssonU20i
     */
    public function detectDependProperties(
        AbstractBrowser $browser,
        AbstractEngine $engine,
        AbstractOs $os
    ) {
        parent::detectDependProperties($browser, $engine, $os);

        $engine->setCapability('xhtml_can_embed_video', 'play_and_stop');

        $osVersion = $os->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        switch ($browser->getName()) {
            case 'Android Webkit':
                switch ((float)$osVersion) {
                    case 2.1:
                        $this->setCapability('wurflKey', 'sonyericsson_u20i_ver1_suban21');
                        $engine->setCapability('xhtml_file_upload', 'not_supported');
                        $engine->setCapability('jqm_grade', 'C');
                        break;
                    case 2.2:
                    case 2.3:
                    case 3.1:
                    case 3.2:
                    case 4.0:
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
                    case 2.1:
                    case 2.2:
                    case 2.3:
                    case 3.1:
                    case 3.2:
                    case 4.0:
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
