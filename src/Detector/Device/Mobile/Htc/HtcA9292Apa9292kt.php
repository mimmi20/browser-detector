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

namespace BrowserDetector\Detector\Device\Mobile\Htc;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Os\AndroidOs;
use BrowserDetector\Detector\Type\Device as DeviceType;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class HtcA9292Apa9292kt
    extends DeviceHandler
    implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'                => 'sprint_apa9292_ver1', // not in wurfl

        // device
        'model_name'              => '9292',
        'model_extra_info'        => null,
        'marketing_name'          => 'EVO 4G',
        'has_qwerty_keyboard'     => false,
        'pointing_method'         => 'touchscreen',

        // product info
        'ununiqueness_handler'    => null,
        'uaprof'                  => 'http://device.sprintpcs.com/HTC/APA9292KT/1226511.rdf',
        'uaprof2'                 => null,
        'uaprof3'                 => null,
        'unique'                  => true,

        // display
        'physical_screen_width'   => 56,
        'physical_screen_height'  => 93,
        'columns'                 => 25,
        'rows'                    => 21,
        'max_image_width'         => 460,
        'max_image_height'        => 760,
        'resolution_width'        => 480,
        'resolution_height'       => 800,
        'dual_orientation'        => true,
        'colors'                  => 65536,

        // sms
        'sms_enabled'             => true,

        // chips
        'nfc_support'             => true,
    );

    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains(array('APA9292KT'))) {
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
        return new DeviceType\Smartphone();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Htc();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\Htc();
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\Os\AndroidOs
     */
    public function detectOs()
    {
        $handler = new AndroidOs();
        $handler->setUseragent($this->_useragent);

        return $handler;
    }
}
