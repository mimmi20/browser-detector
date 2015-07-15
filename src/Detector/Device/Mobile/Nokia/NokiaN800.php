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

namespace BrowserDetector\Detector\Device\Mobile\Nokia;


use BrowserDetector\Detector\Browser\AbstractBrowser;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\AbstractDevice;
use BrowserDetector\Detector\Engine\AbstractEngine;
use BrowserDetector\Detector\MatcherInterface\Device\DeviceHasWurflKeyInterface;
use BrowserDetector\Detector\MatcherInterface\Device\DeviceInterface;
use BrowserDetector\Detector\Os\AbstractOs;
use BrowserDetector\Detector\Os\Symbianos;

use BrowserDetector\Detector\Type\Device as DeviceType;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class NokiaN800
    extends AbstractDevice
    implements DeviceInterface, DeviceHasWurflKeyInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'               => 'nokia_n8_00_ver1', // not in wurfl

        // device
        'model_name'             => 'N8-00',
        'model_extra_info'       => null,
        'marketing_name'         => 'N8', // wurflkey: nokia_n8_00_ver1
        'has_qwerty_keyboard'    => false, // wurflkey: nokia_n8_00_ver1
        'pointing_method'        => 'touchscreen',
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => 'http://nds1.nds.nokia.com/uaprof/NN8-00r100-3G.xml',
        'uaprof2'                => 'http://nds1.nds.nokia.com/uaprof/NN8-00r100-VF3G.xml',
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => 44,
        'physical_screen_height' => 78,
        'columns'                => 17,
        'rows'                   => 13,
        'max_image_width'        => 360,
        'max_image_height'       => 600,
        'resolution_width'       => 360,
        'resolution_height'      => 640,
        'dual_orientation'       => true,
        'colors'                 => 16777216, // wurflkey: nokia_n8_00_ver1_subs53

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
        if (!$this->utils->checkIfContains(array('NokiaN8-00'))) {
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
        return new Company\Nokia();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\Nokia();
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\Os\Symbianos
     */
    public function detectOs()
    {
        $handler = new Symbianos();
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
     * @return \BrowserDetector\Detector\Device\Mobile\Nokia\NokiaN800
     */
    public function detectDependProperties(
        AbstractBrowser $browser,
        AbstractEngine $engine,
        AbstractOs $os
    ) {
        if ($this->utils->checkIfContains(array('Series60/5.3'))) {
            $this->setCapability('wurflKey', 'nokia_n8_00_ver1_subs53');
            $this->setCapability('uaprof', 'http://nds1.nds.nokia.com/uaprof/NN8-00r310-3G.xml');
            $this->setCapability('colors', 16777216);
            $engine->setCapability('image_inlining', true);
        }

        return $this;
    }
}
