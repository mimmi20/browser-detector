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

namespace BrowserDetector\Detector\Device\Mobile\Apple;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\AbstractDevice;
use UaDeviceType\MobilePhone;
use UaMatcher\Browser\BrowserInterface;
use UaMatcher\Device\DeviceHasWurflKeyInterface;
use UaMatcher\Engine\EngineInterface;
use UaMatcher\Os\OsInterface;
use UaResult\Version;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Iphone extends AbstractDevice implements DeviceHasWurflKeyInterface
{
    /**
     * the class constructor
     *
     * @param string                   $useragent
     * @param array                    $data
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        $useragent,
        array $data,
        LoggerInterface $logger = null
    ) {
        $this->useragent = $useragent;

        $this->setData(
            [
                'deviceName'        => 'general HiPhone Device',
                'marketingName'     => 'general HiPhone Device',
                'version'           => null,
                'manufacturer'      => (new Company\HiPhone())->name,
                'brand'             => (new Company\HiPhone())->brandname,
                'formFactor'        => null,
                'pointingMethod'    => 'touchscreen',
                'resolutionWidth'   => null,
                'resolutionHeight'  => null,
                'dualOrientation'   => true,
                'colors'            => null,
                'smsSupport'        => true,
                'nfcSupport'        => true,
                'hasQwertyKeyboard' => true,
                'type'              => new Tablet(),
            ]
        );

        $this->logger = $logger;
    }

    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = [
        // device
        'code_name'              => 'iPhone',
        'model_extra_info'       => null,
        'marketing_name'         => 'iPhone',
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'touchscreen',
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => null,
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => 50,
        'physical_screen_height' => 74,
        'columns'                => 20,
        'rows'                   => 20,
        'max_image_width'        => 320,
        'max_image_height'       => 480,
        'resolution_width'       => 320,
        'resolution_height'      => 480,
        'dual_orientation'       => true,
        'colors'                 => 65536,
        // sms
        'sms_enabled'            => true,
        // chips
        'nfc_support'            => false,
    ];

    /**
     * checks if this device is able to handle the useragent
     *
     * @return bool returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains('iPh')) {
            return false;
        }

        if ($this->utils->checkIfContains(['ipod', 'ipod touch', 'ipad', 'ipad'], true)) {
            return false;
        }

        return true;
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return int
     */
    public function getWeight()
    {
        return 13794422;
    }

    /**
     * returns the type of the current device
     *
     * @return \UaDeviceType\TypeInterface
     */
    public function getDeviceType()
    {
        return new MobilePhone();
    }

    /**
     * returns the type of the current device
     *
     * @return \UaMatcher\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company(new Company\Apple());
    }

    /**
     * returns the type of the current device
     *
     * @return \UaMatcher\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company(new Company\Apple());
    }

    /**
     * returns the WurflKey for the device
     *
     * @param \UaMatcher\Browser\BrowserInterface $browser
     * @param \UaMatcher\Engine\EngineInterface   $engine
     * @param \UaMatcher\Os\OsInterface           $os
     *
     * @return string|null
     */
    public function getWurflKey(BrowserInterface $browser, EngineInterface $engine, OsInterface $os)
    {
        $wurflKey = 'apple_iphone_ver1';

        $osVersion = $os->detectVersion()->getVersion();

        $this->setCapability('model_extra_info', $osVersion);

        if ('Safari' === $browser->getName() && !$browser->detectVersion()->getVersion()
        ) {
            $browser->detectVersion()->setVersion($osVersion);
        }

        $osVersion = $os->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        if (4.1 === (float) $osVersion) {
            $wurflKey = 'apple_iphone_ver4_1';

            if ($this->utils->checkIfContains('Mobile/8B117')) {
                $wurflKey = 'apple_iphone_ver4_1_sub8b117';
            }
        }

        if (5.0 === (float) $osVersion) {
            $wurflKey = 'apple_iphone_ver5_subua';
        }

        if (5.1 === (float) $osVersion) {
            $wurflKey = 'apple_iphone_ver5_1';
        }

        if (6.0 <= (float) $osVersion) {
            $wurflKey = 'apple_iphone_ver6';
        }

        if (6.1 <= (float) $osVersion) {
            $wurflKey = 'apple_iphone_ver6_1';
        }

        if (7.0 === (float) $osVersion) {
            $wurflKey = 'apple_iphone_ver7';
        }

        if (7.1 === (float) $osVersion) {
            $wurflKey = 'apple_iphone_ver7_1';
        }

        if (8.0 === (float) $osVersion) {
            $wurflKey = 'apple_iphone_ver8';
        }

        if (8.1 === (float) $osVersion) {
            $wurflKey = 'apple_iphone_ver8_1';
        }

        $browserVersion = $browser->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        if (6.0 <= (float) $browserVersion) {
            $this->setCapability('resolution_width', 640);
            $this->setCapability('resolution_height', 960);
        }

        $osVersion = $os->detectVersion()->getVersion();

        switch ($osVersion) {
            case '3.1.3':
                $wurflKey = 'apple_iphone_ver3_1_3_subenus';
                break;
            case '4.2.1':
                $wurflKey = 'apple_iphone_ver4_2_1';
                break;
            case '4.3.0':
                $wurflKey = 'apple_iphone_ver4_3';
                break;
            case '4.3.1':
                $wurflKey = 'apple_iphone_ver4_3_1';
                break;
            case '4.3.2':
                $wurflKey = 'apple_iphone_ver4_3_2';
                break;
            case '4.3.3':
                $wurflKey = 'apple_iphone_ver4_3_3';
                break;
            case '4.3.4':
            case '4.3.5':
                $wurflKey = 'apple_iphone_ver4_3_5';
                break;
            case '8.0.2':
                $wurflKey = 'apple_iphone_ver8_subua802';
                break;
            default:
                // nothing to do here
                break;
        }

        return $wurflKey;
    }
}
