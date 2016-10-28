<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Device\Mobile\Medion;
use BrowserDetector\Detector\Factory\DeviceFactory;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MedionFactory implements FactoryInterface
{
    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public static function detect($useragent)
    {
        if (preg_match('/medion e5001/i', $useragent)) {
            $deviceCode = 'life e5001';
        }

        if (preg_match('/medion e4502/i', $useragent)) {
            $deviceCode = 'life e4502';
        }

        if (preg_match('/medion e4504/i', $useragent)) {
            $deviceCode = 'life e4504';
        }

        if (preg_match('/medion e4503/i', $useragent)) {
            $deviceCode = 'life e4503';
        }

        if (preg_match('/medion e4506/i', $useragent)) {
            $deviceCode = 'life e4506';
        }

        if (preg_match('/medion e4005/i', $useragent)) {
            $deviceCode = 'life e4005';
        }

        if (preg_match('/x5020/i', $useragent)) {
            $deviceCode = 'life x5020';
        }

        if (preg_match('/x5004/i', $useragent)) {
            $deviceCode = 'x5004';
        }

        if (preg_match('/x4701/i', $useragent)) {
            $deviceCode = 'x4701';
        }

        if (preg_match('/p5001/i', $useragent)) {
            $deviceCode = 'life p5001';
        }

        if (preg_match('/p5004/i', $useragent)) {
            $deviceCode = 'life p5004';
        }

        if (preg_match('/p5005/i', $useragent)) {
            $deviceCode = 'life p5005';
        }

        if (preg_match('/s5004/i', $useragent)) {
            $deviceCode = 'life s5004';
        }

        if (preg_match('/LIFETAB_P1034X/i', $useragent)) {
            $deviceCode = 'lifetab p1034x';
        }

        if (preg_match('/LIFETAB_P733X/i', $useragent)) {
            $deviceCode = 'lifetab p733x';
        }

        if (preg_match('/LIFETAB_S9714/i', $useragent)) {
            $deviceCode = 'lifetab s9714';
        }

        if (preg_match('/LIFETAB_S9512/i', $useragent)) {
            $deviceCode = 'lifetab s9512';
        }

        if (preg_match('/LIFETAB_S1036X/i', $useragent)) {
            $deviceCode = 'lifetab s1036x';
        }

        if (preg_match('/LIFETAB_S1034X/i', $useragent)) {
            $deviceCode = 'lifetab s1034x';
        }

        if (preg_match('/LIFETAB_S1033X/i', $useragent)) {
            $deviceCode = 'lifetab s1033x';
        }

        if (preg_match('/LIFETAB_S831X/i', $useragent)) {
            $deviceCode = 'lifetab s831x';
        }

        if (preg_match('/LIFETAB_S785X/i', $useragent)) {
            $deviceCode = 'lifetab s785x';
        }

        if (preg_match('/LIFETAB_S732X/i', $useragent)) {
            $deviceCode = 'lifetab s732x';
        }

        if (preg_match('/LIFETAB_P9516/i', $useragent)) {
            $deviceCode = 'lifetab p9516';
        }

        if (preg_match('/LIFETAB_P9514/i', $useragent)) {
            $deviceCode = 'lifetab p9514';
        }

        if (preg_match('/LIFETAB_P891X/i', $useragent)) {
            $deviceCode = 'lifetab p891x';
        }

        if (preg_match('/LIFETAB_P831X\.2/i', $useragent)) {
            $deviceCode = 'lifetab p831x.2';
        }

        if (preg_match('/LIFETAB_P831X/i', $useragent)) {
            $deviceCode = 'lifetab p831x';
        }

        if (preg_match('/LIFETAB_E10320/i', $useragent)) {
            $deviceCode = 'lifetab e10320';
        }

        if (preg_match('/LIFETAB_E10316/i', $useragent)) {
            $deviceCode = 'lifetab e10316';
        }

        if (preg_match('/LIFETAB_E10312/i', $useragent)) {
            $deviceCode = 'lifetab e10312';
        }

        if (preg_match('/LIFETAB_E10310/i', $useragent)) {
            $deviceCode = 'lifetab e10310';
        }

        if (preg_match('/LIFETAB_E7316/i', $useragent)) {
            $deviceCode = 'lifetab e7316';
        }

        if (preg_match('/LIFETAB_E7313/i', $useragent)) {
            $deviceCode = 'lifetab e7313';
        }

        if (preg_match('/LIFETAB_E7312/i', $useragent)) {
            $deviceCode = 'lifetab e7312';
        }

        if (preg_match('/LIFETAB_E733X/i', $useragent)) {
            $deviceCode = 'lifetab e733x';
        }

        if (preg_match('/LIFETAB_E723X/i', $useragent)) {
            $deviceCode = 'lifetab e723x';
        }

        if (preg_match('/p4501/i', $useragent)) {
            $deviceCode = 'md 98428';
        }

        if (preg_match('/p4502/i', $useragent)) {
            $deviceCode = 'life p4502';
        }

        if (preg_match('/LIFE P4310/i', $useragent)) {
            $deviceCode = 'life p4310';
        }

        if (preg_match('/p4013/i', $useragent)) {
            $deviceCode = 'life p4013';
        }

        if (preg_match('/LIFE P4012/i', $useragent)) {
            $deviceCode = 'lifetab p4012';
        }

        if (preg_match('/LIFE E3501/i', $useragent)) {
            $deviceCode = 'life e3501';
        }

        $deviceCode = 'general medion device';

        return DeviceFactory::get($deviceCode, $useragent);
    }
}
