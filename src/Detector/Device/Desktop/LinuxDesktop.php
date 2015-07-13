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
use BrowserDetector\Detector\Device\AbstractDevice;
use BrowserDetector\Detector\MatcherInterface\Device\DeviceInterface;
use BrowserDetector\Detector\Os\AndroidOs;
use BrowserDetector\Detector\Os\CentOs;
use BrowserDetector\Detector\Os\CrOs;
use BrowserDetector\Detector\Os\Debian;
use BrowserDetector\Detector\Os\Fedora;
use BrowserDetector\Detector\Os\Gentoo;
use BrowserDetector\Detector\Os\JoliOs;
use BrowserDetector\Detector\Os\Kubuntu;
use BrowserDetector\Detector\Os\Linux;
use BrowserDetector\Detector\Os\LinuxTv;
use BrowserDetector\Detector\Os\Mandriva;
use BrowserDetector\Detector\Os\Mint;
use BrowserDetector\Detector\Os\Moblin;
use BrowserDetector\Detector\Os\Redhat;
use BrowserDetector\Detector\Os\Slackware;
use BrowserDetector\Detector\Os\Suse;
use BrowserDetector\Detector\Os\Ubuntu;
use BrowserDetector\Detector\Os\UnknownOs;
use BrowserDetector\Detector\Os\Ventana;
use BrowserDetector\Detector\Os\ZenwalkGnu;
use BrowserDetector\Detector\Type\Device as DeviceType;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class LinuxDesktop
    extends AbstractDevice
    implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        // device
        'model_name'             => 'Linux Desktop',
        'model_extra_info'       => null,
        'marketing_name'         => 'Linux Desktop',
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
        $linux = array(
            'Linux',
            'Debian',
            'Ubuntu',
            'SUSE',
            'Fedora',
            'Mint',
            'redhat',
            'Slackware',
            'Zenwalk GNU',
            'CentOS',
            'Kubuntu',
            'CrOs',
            'Moblin'
        );

        if (!$this->utils->checkIfContains($linux, true)) {
            return false;
        }

        if ($this->utils->checkIfContains(array('Loewe; SL121', 'eeepc'))) {
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
        return 4916399;
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
     * @return \BrowserDetector\Detector\Os\AbstractOs
     */
    public function detectOs()
    {
        $os = array(
            new Linux(),
            new Debian(),
            new Fedora(),
            new JoliOs(),
            new Kubuntu(),
            new Mint(),
            new Redhat(),
            new Slackware(),
            new Suse(),
            new Ubuntu(),
            new ZenwalkGnu(),
            new CentOs(),
            new LinuxTv(),
            new CrOs(),
            new Ventana(),
            new Mandriva(),
            new Moblin(),
            new Gentoo(),
            new AndroidOs(),
        );

        $chain = new Chain();
        $chain->setDefaultHandler(new UnknownOs());
        $chain->setUseragent($this->useragent);
        $chain->setHandlers($os);

        return $chain->detect();
    }

    /**
     * returns the Browser which used on the device
     *
     * @return \BrowserDetector\Detector\Browser\AbstractBrowser
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
