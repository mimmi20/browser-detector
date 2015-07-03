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

namespace BrowserDetector\Detector\Device\Mobile;

use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\MatcherInterface\Device\DeviceHasChildrenInterface;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Type\Device as DeviceType;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Acer
    extends DeviceHandler
    implements DeviceInterface, DeviceHasChildrenInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'               => null, // not in wurfl

        // device
        'model_name'             => 'general Acer Device',
        'model_extra_info'       => null,
        'marketing_name'         => 'general Acer Device',
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'touchscreen',
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => null,
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => null,
        'physical_screen_height' => null,
        'columns'                => null,
        'rows'                   => null,
        'max_image_width'        => null,
        'max_image_height'       => null,
        'resolution_width'       => null,
        'resolution_height'      => null,
        'dual_orientation'       => null,
        'colors'                 => null,
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
        $otherPhones = array('HTC', 'IdeaTab', 'Wildfire S A510e', 'HTC_WildfireS_A510e', 'A101IT', 'SmartTabII7');

        if ($this->utils->checkIfContains($otherPhones)) {
            return false;
        }

        $acerPhones = array(
            'Acer',
            'Iconia',
            ' A100 ',
            ' A101 ',
            ' A200 ',
            ' A210 ',
            ' A211 ',
            ' A500 ',
            ' A501 ',
            ' A510 ',
            ' A511 ',
            ' A700 ',
            ' A701 ',
            ' A1-',
            ' A3-',
            ' B1-',
            ' b1-721',
            ' E140 ',
            ' E310 ',
            ' E320 ',
            ' G100W ',
            'Stream-S110',
            ' Liquid ',
            ' S500 ',
            ' Z150 ',
            ' V370 ',
        );

        if (!$this->utils->checkIfContains($acerPhones)) {
            return false;
        }

        return true;
    }

    /**
     * detects the device name from the given user agent
     *
     * @return \BrowserDetector\Detector\DeviceHandler
     */
    public function detectDevice()
    {
        $chain = new Chain();
        $chain->setUserAgent($this->useragent);
        $chain->setNamespace('\BrowserDetector\Detector\Device\Mobile\Acer');
        $chain->setDirectory(
            __DIR__ . DIRECTORY_SEPARATOR . 'Acer' . DIRECTORY_SEPARATOR
        );
        $chain->setDefaultHandler($this);

        return $chain->detect();
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 321280;
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
}
