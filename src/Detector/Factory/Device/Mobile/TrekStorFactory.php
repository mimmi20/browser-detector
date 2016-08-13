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

use BrowserDetector\Detector\Device\Mobile\TrekStor;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class TrekStorFactory implements FactoryInterface
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
        if (preg_match('/VT10416\-2/', $useragent)) {
            return new TrekStor\TrekStorVt104162($useragent);
        }

        if (preg_match('/VT10416\-1/', $useragent)) {
            return new TrekStor\TrekStorVt10416($useragent);
        }

        if (preg_match('/(ST701041|SurfTab\_7\.0)/', $useragent)) {
            return new TrekStor\TrekStorSt701041($useragent);
        }

        if (preg_match('/ST10216\-2/', $useragent)) {
            return new TrekStor\TrekStorSt102162($useragent);
        }

        if (preg_match('/ST80216/', $useragent)) {
            return new TrekStor\TrekStorSt80216($useragent);
        }

        if (preg_match('/ST80208/', $useragent)) {
            return new TrekStor\TrekStorSt80208($useragent);
        }

        if (preg_match('/ST70104/', $useragent)) {
            return new TrekStor\TrekStorSt70104($useragent);
        }

        if (preg_match('/ST10416\-1/', $useragent)) {
            return new TrekStor\TrekStorSt10416($useragent);
        }

        if (preg_match('/ST10216\-1/', $useragent)) {
            return new TrekStor\TrekStorSt10216($useragent);
        }

        if (preg_match('/trekstor_liro_color/', $useragent)) {
            return new TrekStor\TrekStorLiroColor($useragent);
        }

        if (preg_match('/breeze 10\.1 quad/', $useragent)) {
            return new TrekStor\TrekStorBreeze10Quad($useragent);
        }

        return new TrekStor\TrekStor($useragent);
    }
}
