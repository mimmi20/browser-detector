<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Device\Mobile\Acer;


use BrowserDetector\Detector\Browser\AbstractBrowser;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\AbstractDevice;
use BrowserDetector\Detector\Engine\AbstractEngine;
use BrowserDetector\Detector\MatcherInterface\Device\DeviceInterface;
use BrowserDetector\Detector\Os\AbstractOs;
use BrowserDetector\Detector\Os\AndroidOs;

use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AcerIconiaA210
    extends AbstractDevice
    implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'               => 'acer_iconia_tab_a210_ver1', // not in wurfl

        // device
        'model_name'             => 'A210',
        'model_extra_info'       => null,
        'marketing_name'         => 'A210',
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'touchscreen',
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => 'https://support.acer.com/UAprofile/Acer_A210_JRO03H_Profile.xml',
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => 34,
        'physical_screen_height' => 50,
        'columns'                => 28,
        'rows'                   => 30,
        'max_image_width'        => 320,
        'max_image_height'       => 400,
        'resolution_width'       => 1280,
        'resolution_height'      => 800,
        'dual_orientation'       => true,
        'colors'                 => 4294967296,
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
        if (!$this->utils->checkIfContains(array('Iconia A210', 'A210'))) {
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
     * detects properties who are depending on the device version or the user
     * agent
     *
     * @return \BrowserDetector\Detector\Device\Mobile\Acer\AcerIconiaA210
     */
    public function detectSpecialProperties()
    {
        if ($this->utils->checkIfContains(array('Build/IMM76D'))) {
            $this->setCapability(
                'uaprof',
                'http://support.acer.com/UAprofile/Acer_A210_IMM76D_Profile.xml'
            );
        }

        return $this;
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\Os\AndroidOs
     */
    public function detectOs()
    {
        $handler = new AndroidOs();
        $handler->setUseragent($this->useragent);

        return $handler;
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\Browser\AbstractBrowser $browser
     * @param \BrowserDetector\Detector\Engine\AbstractEngine  $engine
     * @param \BrowserDetector\Detector\Os\AbstractOs      $os
     *
     * @return \BrowserDetector\Detector\Device\Mobile\Acer\AcerIconiaA210
     */
    public function detectDependProperties(
        AbstractBrowser $browser,
        AbstractEngine $engine,
        AbstractOs $os
    ) {
        $engine->setCapability('xhtml_send_mms_string', 'mms:');
        $engine->setCapability('xhtml_send_sms_string', 'sms:');
        $engine->setCapability('bmp', true);

        $osVersion = $os->detectVersion()->getVersion(
            Version::MAJORONLY
        );

        if (3 == $osVersion) {
            // $this->setCapability('resolution_width', 640);
            $this->setCapability('resolution_height', 768);
            $this->setCapability('uaprof', 'http://support.acer.com/UAprofile/Acer_A500_Profile.xml');
        }

        $osVersion = $os->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        switch ($browser->getName()) {
            case 'Android Webkit':
                switch ((float)$osVersion) {
                    case 4.1:
                        $this->setCapability('wurflKey', 'acer_iconia_tab_a210_ver1_suban41');
                        $this->setCapability('physical_screen_width', 218);
                        $this->setCapability('physical_screen_height', 136);
                        $this->setCapability('max_image_width', 400);
                        $this->setCapability('max_image_height', 320);
                        break;
                    case 2.1:
                    case 2.2:
                    case 2.3:
                    case 3.1:
                    case 3.2:
                    case 4.0:
                    case 4.2:
                    default:
                        // nothing to do here
                        break;
                }
                break;
            case 'Chrome':
            case 'Android WebView':
                switch ((float)$osVersion) {
                    case 4.1:
                    case 2.1:
                    case 2.2:
                    case 2.3:
                    case 3.1:
                    case 3.2:
                    case 4.0:
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
