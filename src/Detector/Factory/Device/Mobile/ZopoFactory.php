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

use BrowserDetector\Detector\Device\Mobile\Zopo;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ZopoFactory implements FactoryInterface
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
        if (preg_match('/ZP980/', $useragent)) {
            return new Zopo\ZopoZp980($useragent);
        }

        if (preg_match('/ZP950\+/', $useragent)) {
            return new Zopo\ZopoZp950Plus($useragent);
        }

        if (preg_match('/ZP950/', $useragent)) {
            return new Zopo\ZopoZp950($useragent);
        }

        if (preg_match('/ZP9(10|00H)/', $useragent)) {
            return new Zopo\ZopoZp910($useragent);
        }

        if (preg_match('/ZP900/', $useragent)) {
            return new Zopo\ZopoZp900($useragent);
        }

        if (preg_match('/ZP8(10|00H)/', $useragent)) {
            return new Zopo\ZopoZp810($useragent);
        }

        if (preg_match('/ZP500/', $useragent)) {
            return new Zopo\ZopoZp500($useragent);
        }

        if (preg_match('/ZP300/', $useragent)) {
            return new Zopo\ZopoZp300($useragent);
        }

        if (preg_match('/ZP200/', $useragent)) {
            return new Zopo\ZopoZp200($useragent);
        }

        if (preg_match('/ZP100/', $useragent)) {
            return new Zopo\ZopoZp100($useragent);
        }

        return new Zopo\Zopo($useragent);
    }
}
