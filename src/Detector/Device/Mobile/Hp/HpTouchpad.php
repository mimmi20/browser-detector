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

namespace BrowserDetector\Detector\Device\Mobile\Hp;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\AbstractDevice;
use UaDeviceType\Tablet;
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
class HpTouchpad extends AbstractDevice implements DeviceHasWurflKeyInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = [
        // device
        'code_name'              => 'Touchpad',
        'model_extra_info'       => null,
        'marketing_name'         => 'Touchpad',
        'has_qwerty_keyboard'    => true,
        'pointing_method'        => 'touchscreen',
        // product info
        'ununiqueness_handler'   => null,
        'uaprof'                 => 'http://downloads.palm.com/profiles/HSTNH-I29C_R1.xml',
        'uaprof2'                => null,
        'uaprof3'                => null,
        'unique'                 => true,
        // display
        'physical_screen_width'  => 100,
        'physical_screen_height' => 200,
        'columns'                => 100,
        'rows'                   => 50,
        'max_image_width'        => 768,
        'max_image_height'       => 1000,
        'resolution_width'       => 1024,
        'resolution_height'      => 768,
        'dual_orientation'       => true,
        'colors'                 => 262144,
        // sms
        'sms_enabled'            => true, // wurflkey: hp_touchpad_ver1

        // chips
        'nfc_support'            => true, // wurflkey: hp_touchpad_ver1
    ];

    /**
     * checks if this device is able to handle the useragent
     *
     * @return bool returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains(['TouchPad', 'Touchpad', 'cm_tenderloin'])) {
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
        return 3;
    }

    /**
     * returns the type of the current device
     *
     * @return \UaDeviceType\TypeInterface
     */
    public function getDeviceType()
    {
        return new Tablet();
    }

    /**
     * returns the type of the current device
     *
     * @return \UaMatcher\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company(new Company\Hp());
    }

    /**
     * returns the type of the current device
     *
     * @return \UaMatcher\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company(new Company\Hp());
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
        $wurflKey = 'hp_touchpad_ver1';

        if (('Android Webkit' === $browser->getName() || 'Chrome' === $browser->getName())
            && 'Android' === $os->getName()
        ) {
            $osVersion = $os->detectVersion()->getVersion(
                Version::MAJORMINOR
            );

            switch ($browser->getName()) {
                case 'Android Webkit':
                    switch ((float) $osVersion) {
                        case 4.0:
                            $wurflKey = 'hp_touchpad_android_ver1_suban40rom';
                            break;
                        default:
                            // nothing to do here
                            break;
                    }
                    break;
                case 'Chrome':
                    switch ((float) $osVersion) {
                        case 4.0:
                            $wurflKey = 'hp_touchpad_android_ver1_suban40rom';
                            break;
                        default:
                            // nothing to do here
                            break;
                    }
                    break;
                default:
                    // nothing to do here
                    break;
            }
        }

        return $wurflKey;
    }
}
