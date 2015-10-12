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

namespace BrowserDetector\Detector\Device\Desktop;

use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Os\Windows;
use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Helper\Windows as WindowsHelper;
use UaMatcher\Device\DeviceInterface;
use UaMatcher\Device\DeviceInterface;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class WindowsDesktop extends AbstractDevice implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        // device
        'model_name'             => 'Windows Desktop',
        'model_extra_info'       => null,
        'marketing_name'         => 'Windows Desktop',
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'mouse',
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => null,
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => 400,
        'physical_screen_height' => 400,
        'columns'                => 120,
        'rows'                   => 200,
        'max_image_width'        => 600,
        'max_image_height'       => 600,
        'resolution_width'       => 800,
        'resolution_height'      => 600,
        'dual_orientation'       => false,
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
        $windowsHelper = new WindowsHelper();
        $windowsHelper->setUserAgent($this->useragent);

        if (!$windowsHelper->isWindows()) {
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
        return 394622049;
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Type\Device\TypeInterface
     */
    public function getDeviceType()
    {
        return new DeviceType\Desktop();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Unknown();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\Unknown();
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\Os\Windows
     */
    public function detectOs()
    {
        $handler = new Windows();
        $handler->setUseragent($this->useragent);

        return $handler;
    }

    /**
     * returns the Browser which used on the device
     *
     * @return \UaMatcher\Browser\BrowserInterface
     */
    public function detectBrowser()
    {
        $browserPath = realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Browser' . DIRECTORY_SEPARATOR . 'Desktop' . DIRECTORY_SEPARATOR
        );

        $chain = new Chain();
        $chain->setUserAgent($this->useragent);
        $chain->setNamespace('\BrowserDetector\Detector\Browser\Desktop');
        $chain->setDirectory($browserPath);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }
}
