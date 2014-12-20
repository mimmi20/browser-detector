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

namespace BrowserDetector\Detector\Device;

use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\MatcherInterface\DeviceHasChildrenInterface;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Tv as TvHelper;
use BrowserDetector\Helper\Windows as WindowsHelper;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class GeneralDesktop
    extends DeviceHandler
    implements DeviceInterface, DeviceHasChildrenInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'                => null, // not in wurfl

        // device
        'model_name'              => 'general Desktop',
        'model_extra_info'        => null,
        'marketing_name'          => 'general Desktop',
        'has_qwerty_keyboard'     => null,
        'pointing_method'         => 'mouse',

        // product info
        'ununiqueness_handler'    => null,
        'uaprof'                  => null,
        'uaprof2'                 => null,
        'uaprof3'                 => null,
        'unique'                  => true,

        // display
        'physical_screen_width'   => null,
        'physical_screen_height'  => null,
        'columns'                 => null,
        'rows'                    => null,
        'max_image_width'         => null,
        'max_image_height'        => null,
        'resolution_width'        => null,
        'resolution_height'       => null,
        'dual_orientation'        => false,
        'colors'                  => 65536,

        // sms
        'sms_enabled'             => false,

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
        $mobileDeviceHelper = new MobileDevice();
        $mobileDeviceHelper->setUserAgent($this->_useragent);

        if ($mobileDeviceHelper->isMobileBrowser()) {
            return false;
        }

        $tvHelper = new TvHelper();
        $tvHelper->setUserAgent($this->_useragent);

        if ($tvHelper->isTvDevice()) {
            return false;
        }

        $windowsHelper = new WindowsHelper();
        $windowsHelper->setUserAgent($this->_useragent);

        if ($windowsHelper->isWindows()) {
            return true;
        }

        $others = array(
            // Linux
            'linux', 'debian', 'ubuntu', 'suse', 'fedora', 'mint', 'redhat',
            'slackware', 'zenwalk gnu', 'centos', 'kubuntu', 'cros',
            // Mac
            'macintosh', 'darwin', 'mac_powerpc', 'macbook', 'for mac',
            'ppc mac', 'mac os x', 'imac', 'macbookpro', 'macbookair',
            'macbook', 'macmini',
            // others
            'freebsd', 'openbsd', 'os/2', 'warp', 'sunos', 'netbsd', 'w3m',
            'google desktop', 'eeepc', 'dillo', 'konqueror', 'eudora',
            'masking-agent', 'safersurf'
        );

        if ($this->utils->checkIfContains($others, true)) {
            return true;
        }

        return false;
    }

    /**
     * detects the device name from the given user agent
     *
     * @return \BrowserDetector\Detector\DeviceHandler
     */
    public function detectDevice()
    {
        $chain = new Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setNamespace(__NAMESPACE__ . '\\Desktop');
        $chain->setDirectory(
            __DIR__ . DIRECTORY_SEPARATOR . 'Desktop' . DIRECTORY_SEPARATOR
        );
        $chain->setDefaultHandler($this);

        $device = $chain->detect();

        if ($device !== $this && $device instanceof DeviceHasChildrenInterface) {
            $device = $device->detectDevice();
        }

        return $device;
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 1;
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
     * @return \BrowserDetector\Detector\BrowserHandler
     */
    public function detectBrowser()
    {
        $browserPath = realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . 'Browser'
            . DIRECTORY_SEPARATOR . 'Desktop'
            . DIRECTORY_SEPARATOR
        );

        $chain = new Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Browser\\Desktop');
        $chain->setDirectory($browserPath);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }
}
