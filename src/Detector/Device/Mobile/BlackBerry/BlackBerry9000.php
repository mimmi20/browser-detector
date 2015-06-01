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

namespace BrowserDetector\Detector\Device\Mobile\BlackBerry;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;

use BrowserDetector\Detector\Type\Device as DeviceType;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BlackBerry9000
    extends DeviceHandler
    implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'               => 'blackberry9000_ver1', // not in wurfl

        // device
        'model_name'             => 'BlackBerry 9000',
        'model_extra_info'       => null,
        'marketing_name'         => 'Bold', // wurflkey: blackberry9000_ver1_sub460162_123
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'clickwheel', // wurflkey: blackberry9000_ver1_sub460162_123

        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => 'http://www.blackberry.net/go/mobile/profiles/uaprof/9000_edge/5.0.0.rdf',
        'uaprof2'                => 'http://www.blackberry.net/go/mobile/profiles/uaprof/9000_umts/5.0.0.rdf',
        'uaprof3'                => 'http://www.blackberry.net/go/mobile/profiles/uaprof/9000_edge/5.0.0.rdf',
        'unique'                 => true,
        // display
        'physical_screen_width'  => 27, // wurflkey: blackberry9000_ver1_sub460162
        'physical_screen_height' => 27, // wurflkey: blackberry9000_ver1_sub460162
        'columns'                => 48, // wurflkey: blackberry9000_ver1_sub460162
        'rows'                   => 21, // wurflkey: blackberry9000_ver1_sub460162
        'max_image_width'        => 460, // wurflkey: blackberry9000_ver1_sub460162
        'max_image_height'       => 280, // wurflkey: blackberry9000_ver1_sub460162
        'resolution_width'       => 480, // wurflkey: blackberry9000_ver1_sub460162
        'resolution_height'      => 320, // wurflkey: blackberry9000_ver1_sub460162
        'dual_orientation'       => false, // wurflkey: blackberry9000_ver1_sub460162
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
        if (!$this->utils->checkIfContains(array('BlackBerry 9000', 'BlackBerry9000'))) {
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
        return new Company\Rim();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\Rim();
    }
}
