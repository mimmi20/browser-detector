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

namespace BrowserDetector\Detector\Device\Mobile\Acer;


use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\AbstractDevice;
use BrowserDetector\Detector\AbstractEngine;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Os\AndroidAbstractOs;

use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AcerIconiaA511
    extends AbstractDevice
    implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'               => 'acer_iconia_tab_a511_ver1', // not in wurfl

        // device
        'model_name'             => 'A511',
        'model_extra_info'       => null,
        'marketing_name'         => 'A511',
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'touchscreen',
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => 'http://support.acer.com/UAprofile/Acer_A511_IML74K_Profile.xml',
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => 34,
        'physical_screen_height' => 50,
        'columns'                => 60,
        'rows'                   => 40,
        'max_image_width'        => 320,
        'max_image_height'       => 400,
        'resolution_width'       => 1280,
        'resolution_height'      => 800,
        'dual_orientation'       => true,
        'colors'                 => 4294967296,
        // sms
        'sms_enabled'            => true, // wurflkey: acer_iconia_tab_a511_ver1

        // chips
        'nfc_support'            => true, // wurflkey: acer_iconia_tab_a511_ver1
    );

    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains(array('Iconia A511', 'A511'))) {
            return false;
        }

        if ($this->utils->checkIfContains(array('HTC'))) {
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
        return new DeviceType\FonePad();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Acer();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\Acer();
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\Os\AndroidAbstractOs
     */
    public function detectOs()
    {
        $handler = new AndroidAbstractOs();
        $handler->setUseragent($this->useragent);

        return $handler;
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\AbstractBrowser $browser
     * @param \BrowserDetector\Detector\AbstractEngine  $engine
     * @param \BrowserDetector\Detector\AbstractOs      $os
     *
     * @return AbstractDevice
     */
    public function detectDependProperties(
        AbstractBrowser $browser,
        AbstractEngine $engine,
        AbstractOs $os
    ) {
        parent::detectDependProperties($browser, $engine, $os);

        // wurflkey: acer_iconia_tab_a511_ver1
        $engine->setCapability('xhtml_send_mms_string', 'mms:');
        $engine->setCapability('xhtml_send_sms_string', 'sms:');
        $engine->setCapability('bmp', true);

        $osVersion = $os->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        switch ($browser->getName()) {
            case 'Android Webkit':
                switch ((float)$osVersion) {
                    case 4.1:
                        $this->setCapability('wurflKey', 'acer_iconia_tab_a511_ver1_suban41');
                        break;
                    case 2.1:
                    case 2.2:
                    case 2.3:
                    case 3.1:
                    case 3.2:
                    case 4.0:
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
