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
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Device\Mobile\SonyEricsson;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\AbstractDevice;
use BrowserDetector\Detector\Os\CellOs;
use UaDeviceType\Tv;
use UaMatcher\Device\DeviceHasSpecificPlatformInterface;
use UaMatcher\Device\DeviceHasVersionInterface;
use UaResult\Version;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class PlayStation4
    extends AbstractDevice
    implements DeviceHasSpecificPlatformInterface, DeviceHasVersionInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = [
        // device
        'code_name'              => 'Playstation 4',
        'model_extra_info'       => null,
        'marketing_name'         => 'Playstation 4',
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'mouse',
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
        'resolution_width'       => 685,
        'resolution_height'      => 600,
        'dual_orientation'       => false,
        'colors'                 => 65536,
        // sms
        'sms_enabled'            => true,
        // chips
        'nfc_support'            => true,
    ];

    /**
     * @var \UaResult\Version
     */
    protected $version = null;

    /**
     * checks if this device is able to handle the useragent
     *
     * @return bool returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if ($this->utils->checkIfContains(['PlayStation 4'])) {
            return true;
        }

        return false;
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return int
     */
    public function getWeight()
    {
        return 3;
    }

    /**
     * returns the type of the current device
     *
     * @return \UaDeviceType\TypeInterface
     */
    public function getDeviceType()
    {
        return new Tv();
    }

    /**
     * returns the type of the current device
     *
     * @return \UaMatcher\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company(new Company\Sony());
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\AbstractCompany
     */
    public function getBrand()
    {
        return new Company(new Company\Sony());
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\Os\CellOs
     */
    public function detectOs()
    {
        return new CellOs($this->useragent, $this->logger);
    }

    /**
     * detects the device name from the given user agent
     *
     * @return \UaResult\Version
     */
    public function detectDeviceVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->useragent);
        $detector->setMode(Version::COMPLETE | Version::IGNORE_MICRO_IF_EMPTY);

        $searches = ['PlayStation 4'];

        $this->version = $detector->detectVersion($searches);

        return $this->version;
    }
}
