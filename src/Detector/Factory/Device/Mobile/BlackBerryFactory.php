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

use BrowserDetector\Detector\Device\Mobile\BlackBerry;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BlackBerryFactory implements FactoryInterface
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
        if (preg_match('/BB10; Kbd/i', $useragent)) {
            return new BlackBerry\BlackBerryKbd($useragent, []);
        }

        if (preg_match('/BB10; Touch/i', $useragent)) {
            return new BlackBerry\BlackBerryZ10($useragent, []);
        }

        if (preg_match('/PlayBook/i', $useragent)) {
            return new BlackBerry\RimPlayBook($useragent, []);
        }

        if (preg_match('/RIM Tablet/i', $useragent)) {
            return new BlackBerry\RimTablet($useragent, []);
        }

        if (preg_match('/9981/i', $useragent)) {
            return new BlackBerry\BlackBerry9981($useragent, []);
        }

        if (preg_match('/9900/i', $useragent)) {
            return new BlackBerry\BlackBerry9900($useragent, []);
        }

        if (preg_match('/9860/i', $useragent)) {
            return new BlackBerry\BlackBerry9860($useragent, []);
        }

        if (preg_match('/9810/i', $useragent)) {
            return new BlackBerry\BlackBerry9810($useragent, []);
        }

        if (preg_match('/9800/i', $useragent)) {
            return new BlackBerry\BlackBerry9800($useragent, []);
        }

        if (preg_match('/9790/i', $useragent)) {
            return new BlackBerry\BlackBerry9790($useragent, []);
        }

        if (preg_match('/9780/i', $useragent)) {
            return new BlackBerry\BlackBerry9780($useragent, []);
        }

        if (preg_match('/9700/i', $useragent)) {
            return new BlackBerry\BlackBerry9700($useragent, []);
        }

        if (preg_match('/9670/i', $useragent)) {
            return new BlackBerry\BlackBerry9670($useragent, []);
        }

        if (preg_match('/9630/i', $useragent)) {
            return new BlackBerry\BlackBerry9630($useragent, []);
        }

        if (preg_match('/9550/i', $useragent)) {
            return new BlackBerry\BlackBerry9550($useragent, []);
        }

        if (preg_match('/9520/i', $useragent)) {
            return new BlackBerry\BlackBerry9520($useragent, []);
        }

        if (preg_match('/9500/i', $useragent)) {
            return new BlackBerry\BlackBerry9500($useragent, []);
        }

        if (preg_match('/9380/i', $useragent)) {
            return new BlackBerry\BlackBerry9380($useragent, []);
        }

        if (preg_match('/9360/i', $useragent)) {
            return new BlackBerry\BlackBerry9360($useragent, []);
        }

        if (preg_match('/9320/i', $useragent)) {
            return new BlackBerry\BlackBerry9320($useragent, []);
        }

        if (preg_match('/9300/i', $useragent)) {
            return new BlackBerry\BlackBerry9300($useragent, []);
        }

        if (preg_match('/9220/i', $useragent)) {
            return new BlackBerry\BlackBerry9220($useragent, []);
        }

        if (preg_match('/9105/i', $useragent)) {
            return new BlackBerry\BlackBerry9105($useragent, []);
        }

        if (preg_match('/9000/i', $useragent)) {
            return new BlackBerry\BlackBerry9000($useragent, []);
        }

        if (preg_match('/8900/i', $useragent)) {
            return new BlackBerry\BlackBerry8900($useragent, []);
        }

        if (preg_match('/8830/i', $useragent)) {
            return new BlackBerry\BlackBerry8830($useragent, []);
        }

        if (preg_match('/8800/i', $useragent)) {
            return new BlackBerry\BlackBerry8800($useragent, []);
        }

        if (preg_match('/8700/i', $useragent)) {
            return new BlackBerry\BlackBerry8700($useragent, []);
        }

        if (preg_match('/8530/i', $useragent)) {
            return new BlackBerry\BlackBerry8530($useragent, []);
        }

        if (preg_match('/8520/i', $useragent)) {
            return new BlackBerry\BlackBerry8520($useragent, []);
        }

        if (preg_match('/8350i/i', $useragent)) {
            return new BlackBerry\BlackBerry8350i($useragent, []);
        }

        if (preg_match('/8310/i', $useragent)) {
            return new BlackBerry\BlackBerry8310($useragent, []);
        }

        if (preg_match('/8230/i', $useragent)) {
            return new BlackBerry\BlackBerry8230($useragent, []);
        }

        if (preg_match('/8110/i', $useragent)) {
            return new BlackBerry\BlackBerry8110($useragent, []);
        }

        if (preg_match('/8100/i', $useragent)) {
            return new BlackBerry\BlackBerry8100($useragent, []);
        }

        if (preg_match('/7520/i', $useragent)) {
            return new BlackBerry\BlackBerry7520($useragent, []);
        }

        if (preg_match('/7130/i', $useragent)) {
            return new BlackBerry\BlackBerry7130($useragent, []);
        }

        return new BlackBerry\BlackBerry($useragent, []);
    }
}
