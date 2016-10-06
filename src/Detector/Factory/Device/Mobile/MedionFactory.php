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
            return new Medion\MdLifeE5001($useragent);
        }

        if (preg_match('/x5004/i', $useragent)) {
            return new Medion\MdX5004($useragent);
        }

        if (preg_match('/x4701/i', $useragent)) {
            return new Medion\MdX4701($useragent);
        }

        if (preg_match('/LIFETAB_P1034X/i', $useragent)) {
            return new Medion\MdLifetabP1034x($useragent);
        }

        if (preg_match('/LIFETAB_P733X/i', $useragent)) {
            return new Medion\MdLifetabP733x($useragent);
        }

        if (preg_match('/LIFETAB_S9714/i', $useragent)) {
            return new Medion\MdLifetabS9714($useragent);
        }

        if (preg_match('/LIFETAB_S9512/i', $useragent)) {
            return new Medion\MdLifetabS9512($useragent);
        }

        if (preg_match('/LIFETAB_S1036X/i', $useragent)) {
            return new Medion\MdLifetabS1036x($useragent);
        }

        if (preg_match('/LIFETAB_S1034X/i', $useragent)) {
            return new Medion\MdLifetabS1034x($useragent);
        }

        if (preg_match('/LIFETAB_S1033X/i', $useragent)) {
            return new Medion\MdLifetabS1033x($useragent);
        }

        if (preg_match('/LIFETAB_S831X/i', $useragent)) {
            return new Medion\MdLifetabS831x($useragent);
        }

        if (preg_match('/LIFETAB_S785X/i', $useragent)) {
            return new Medion\MdLifetabS785x($useragent);
        }

        if (preg_match('/LIFETAB_P9516/i', $useragent)) {
            return new Medion\MdLifetabP9516($useragent);
        }

        if (preg_match('/LIFETAB_P9514/i', $useragent)) {
            return new Medion\MdLifetabP9514($useragent);
        }

        if (preg_match('/LIFETAB_P891X/i', $useragent)) {
            return new Medion\MdLifetabP891x($useragent);
        }

        if (preg_match('/LIFETAB_P831X\.2/i', $useragent)) {
            return new Medion\MdLifetabP831x2($useragent);
        }

        if (preg_match('/LIFETAB_E10320/i', $useragent)) {
            return new Medion\MdLifetabE10320($useragent);
        }

        if (preg_match('/LIFETAB_E10316/i', $useragent)) {
            return new Medion\MdLifetabE10316($useragent);
        }

        if (preg_match('/LIFETAB_E10312/i', $useragent)) {
            return new Medion\MdLifetabE10312($useragent);
        }

        if (preg_match('/LIFETAB_E10310/i', $useragent)) {
            return new Medion\MdLifetabE10310($useragent);
        }

        if (preg_match('/LIFETAB_E7316/i', $useragent)) {
            return new Medion\MdLifetabE7316($useragent);
        }

        if (preg_match('/LIFETAB_E7312/i', $useragent)) {
            return new Medion\MdLifetabE7312($useragent);
        }

        if (preg_match('/p4501/i', $useragent)) {
            return new Medion\MdLifeP4501($useragent);
        }

        if (preg_match('/LIFE P4310/i', $useragent)) {
            return new Medion\MdLifeP4310($useragent);
        }

        if (preg_match('/LIFE P4013/i', $useragent)) {
            return new Medion\MdLifeP4013($useragent);
        }

        if (preg_match('/LIFE P4012/i', $useragent)) {
            return new Medion\MdLifeP4012($useragent);
        }

        if (preg_match('/LIFE E3501/i', $useragent)) {
            return new Medion\MdLifeE3501($useragent);
        }

        return new Medion\Medion($useragent);
    }
}
