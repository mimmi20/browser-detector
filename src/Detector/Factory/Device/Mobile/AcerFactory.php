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

use BrowserDetector\Detector\Device;
use BrowserDetector\Detector\Factory\DeviceFactory;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AcerFactory implements FactoryInterface
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
        $deviceCode = 'general acer device';

        if (preg_match('/V989/i', $useragent)) {
            $deviceCode = 'v989';
        }

        if (preg_match('/V370/i', $useragent)) {
            $deviceCode = 'v370';
        }

        if (preg_match('/Stream\-S110/i', $useragent)) {
            $deviceCode = 'stream s110';
        }

        if (preg_match('/S500/i', $useragent)) {
            $deviceCode = 's500';
        }

        if (preg_match('/Liquid (MT|Metal)/i', $useragent)) {
            $deviceCode = 's120';
        }

        if (preg_match('/Z150/i', $useragent)) {
            $deviceCode = 'z150';
        }

        if (preg_match('/Liquid/i', $useragent)) {
            $deviceCode = 's100';
        }

        if (preg_match('/b1\-770/i', $useragent)) {
            $deviceCode = 'b1-770';
        }

        if (preg_match('/b1\-730hd/i', $useragent)) {
            $deviceCode = 'b1-730hd';
        }

        if (preg_match('/b1\-721/i', $useragent)) {
            $deviceCode = 'b1-721';
        }

        if (preg_match('/b1\-711/i', $useragent)) {
            $deviceCode = 'b1-711';
        }

        if (preg_match('/b1\-710/i', $useragent)) {
            $deviceCode = 'b1-710';
        }

        if (preg_match('/b1\-a71/i', $useragent)) {
            $deviceCode = 'b1-a71';
        }

        if (preg_match('/a1\-830/i', $useragent)) {
            $deviceCode = 'a1-830';
        }

        if (preg_match('/a1\-811/i', $useragent)) {
            $deviceCode = 'a1-811';
        }

        if (preg_match('/a1\-810/i', $useragent)) {
            $deviceCode = 'a1-810';
        }

        if (preg_match('/A742/i', $useragent)) {
            $deviceCode = 'tab a742';
        }

        if (preg_match('/A701/i', $useragent)) {
            $deviceCode = 'a701';
        }

        if (preg_match('/A700/i', $useragent)) {
            $deviceCode = 'a700';
        }

        if (preg_match('/A511/i', $useragent)) {
            $deviceCode = 'a511';
        }

        if (preg_match('/A510/i', $useragent)) {
            $deviceCode = 'a510';
        }

        if (preg_match('/A501/i', $useragent)) {
            $deviceCode = 'a501';
        }

        if (preg_match('/A500/i', $useragent)) {
            $deviceCode = 'a500';
        }

        if (preg_match('/A211/i', $useragent)) {
            $deviceCode = 'a211';
        }

        if (preg_match('/A210/i', $useragent)) {
            $deviceCode = 'a210';
        }

        if (preg_match('/A200/i', $useragent)) {
            $deviceCode = 'a200';
        }

        if (preg_match('/A101C/i', $useragent)) {
            $deviceCode = 'a101c';
        }

        if (preg_match('/A101/i', $useragent)) {
            $deviceCode = 'a101';
        }

        if (preg_match('/A100/i', $useragent)) {
            $deviceCode = 'a100';
        }

        if (preg_match('/a3\-a20/i', $useragent)) {
            $deviceCode = 'a3-a20';
        }

        if (preg_match('/a3\-a11/i', $useragent)) {
            $deviceCode = 'a3-a11';
        }

        if (preg_match('/a3\-a10/i', $useragent)) {
            $deviceCode = 'a3-a10';
        }

        if (preg_match('/Iconia/i', $useragent)) {
            $deviceCode = 'iconia';
        }

        if (preg_match('/G100W/i', $useragent)) {
            $deviceCode = 'g100w';
        }

        if (preg_match('/E320/i', $useragent)) {
            $deviceCode = 'e320';
        }

        if (preg_match('/E310/i', $useragent)) {
            $deviceCode = 'e310';
        }

        if (preg_match('/E140/i', $useragent)) {
            $deviceCode = 'e140';
        }

        if (preg_match('/DA241HL/i', $useragent)) {
            $deviceCode = 'da241hl';
        }

        if (preg_match('/allegro/i', $useragent)) {
            $deviceCode = 'allegro';
        }

        if (preg_match('/TM01/', $useragent)) {
            $deviceCode = 'tm01';
        }

        if (preg_match('/M220/', $useragent)) {
            $deviceCode = 'm220';
        }

        return DeviceFactory::get($deviceCode, $useragent);
    }
}
