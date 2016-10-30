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

namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class LenovoFactory implements Factory\FactoryInterface
{
    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function detect($useragent)
    {
        $deviceCode = 'general lenovo device';

        if (preg_match('/YT3\-X50L/i', $useragent)) {
            $deviceCode = 'yt3-x50l';
        }

        if (preg_match('/TB2\-X30F/i', $useragent)) {
            $deviceCode = 'tb2-x30f';
        }

        if (preg_match('/YOGA Tablet 2 Pro\-1380L/i', $useragent)) {
            $deviceCode = '1380l';
        }

        if (preg_match('/YOGA Tablet 2 Pro\-1380F/i', $useragent)) {
            $deviceCode = '1380f';
        }

        if (preg_match('/YOGA Tablet 2\-1050L/i', $useragent)) {
            $deviceCode = '1050l';
        }

        if (preg_match('/YOGA Tablet 2\-1050F/i', $useragent)) {
            $deviceCode = '1050f';
        }

        if (preg_match('/YOGA Tablet 2\-830L/i', $useragent)) {
            $deviceCode = '830l';
        }

        if (preg_match('/YOGA Tablet 2\-830F/i', $useragent)) {
            $deviceCode = '830f';
        }

        if (preg_match('/a10\-70f/i', $useragent)) {
            $deviceCode = 'a10-70f';
        }

        if (preg_match('/s6000l\-f/i', $useragent)) {
            $deviceCode = 's6000l-f';
        }

        if (preg_match('/s6000\-h/i', $useragent)) {
            $deviceCode = 's6000-h';
        }

        if (preg_match('/s6000\-f/i', $useragent)) {
            $deviceCode = 'ideatab';
        }

        if (preg_match('/s5000\-h/i', $useragent)) {
            $deviceCode = 's5000-h';
        }

        if (preg_match('/s5000\-f/i', $useragent)) {
            $deviceCode = 's5000-f';
        }

        if (preg_match('/ideatabs2110ah/i', $useragent)) {
            $deviceCode = 's2110a-h';
        }

        if (preg_match('/ideatabs2110af/i', $useragent)) {
            $deviceCode = 's2110a-f';
        }

        if (preg_match('/IdeaTabS2109A\-F/', $useragent)) {
            $deviceCode = 's2109a-f';
        }

        if (preg_match('/s920/i', $useragent)) {
            $deviceCode = 's920';
        }

        if (preg_match('/s880i/i', $useragent)) {
            $deviceCode = 's880i';
        }

        if (preg_match('/s856/i', $useragent)) {
            $deviceCode = 's856';
        }

        if (preg_match('/s820\_row/i', $useragent)) {
            $deviceCode = 's820_row';
        }

        if (preg_match('/s720/i', $useragent)) {
            $deviceCode = 's720';
        }

        if (preg_match('/s660/i', $useragent)) {
            $deviceCode = 's660';
        }

        if (preg_match('/p1050x/i', $useragent)) {
            $deviceCode = 'lifetab p1050x';
        }

        if (preg_match('/p1032x/i', $useragent)) {
            $deviceCode = 'lifetab p1032x';
        }

        if (preg_match('/p780/i', $useragent)) {
            $deviceCode = 'p780';
        }

        if (preg_match('/k910l/i', $useragent)) {
            $deviceCode = 'k910l';
        }

        if (preg_match('/k900/i', $useragent)) {
            $deviceCode = 'k900';
        }

        if (preg_match('/ k1/i', $useragent)) {
            $deviceCode = 'k1';
        }

        if (preg_match('/ideapada10/i', $useragent)) {
            $deviceCode = 'ideapad a10';
        }

        if (preg_match('/a1\_07/i', $useragent)) {
            $deviceCode = 'ideapad a1';
        }

        if (preg_match('/b8080\-h/i', $useragent)) {
            $deviceCode = 'b8080-h';
        }

        if (preg_match('/b8080\-f/i', $useragent)) {
            $deviceCode = 'b8080-f';
        }

        if (preg_match('/b8000\-h/i', $useragent)) {
            $deviceCode = 'b8000-h';
        }

        if (preg_match('/b8000\-f/i', $useragent)) {
            $deviceCode = 'b8000-f';
        }

        if (preg_match('/b6000\-hv/i', $useragent)) {
            $deviceCode = 'b6000-hv';
        }

        if (preg_match('/b6000\-h/i', $useragent)) {
            $deviceCode = 'b6000-h';
        }

        if (preg_match('/b6000\-f/i', $useragent)) {
            $deviceCode = 'b6000-f';
        }

        if (preg_match('/a7600\-h/i', $useragent)) {
            $deviceCode = 'a7600-h';
        }

        if (preg_match('/a7600\-f/i', $useragent)) {
            $deviceCode = 'a7600-f';
        }

        if (preg_match('/a7000\-a/i', $useragent)) {
            $deviceCode = 'a7000-a';
        }

        if (preg_match('/A5500\-H/i', $useragent)) {
            $deviceCode = 'a5500-h';
        }

        if (preg_match('/A5500\-F/i', $useragent)) {
            $deviceCode = 'a5500-f';
        }

        if (preg_match('/A3500\-H/i', $useragent)) {
            $deviceCode = 'a3500-h';
        }

        if (preg_match('/A3500\-FL/i', $useragent)) {
            $deviceCode = 'a3500-fl';
        }

        if (preg_match('/a3300\-hv/i', $useragent)) {
            $deviceCode = 'a3300-hv';
        }

        if (preg_match('/a3300\-h/i', $useragent)) {
            $deviceCode = 'a3300-h';
        }

        if (preg_match('/a3300\-gv/i', $useragent)) {
            $deviceCode = 'a3300-gv';
        }

        if (preg_match('/A3000\-H/i', $useragent)) {
            $deviceCode = 'a3000-h';
        }

        if (preg_match('/A2107A\-H/i', $useragent)) {
            $deviceCode = 'a2107a-h';
        }

        if (preg_match('/A1107/i', $useragent)) {
            $deviceCode = 'a1107';
        }

        if (preg_match('/A1000\-F/i', $useragent)) {
            $deviceCode = 'a1000-f';
        }

        if (preg_match('/A1000L\-F/i', $useragent)) {
            $deviceCode = 'a1000l-f';
        }

        if (preg_match('/A1000/i', $useragent)) {
            $deviceCode = 'a1000';
        }

        if (preg_match('/(a2109a|ideatab)/i', $useragent)) {
            $deviceCode = 'a2109a';
        }

        if (preg_match('/a889/i', $useragent)) {
            $deviceCode = 'a889';
        }

        if (preg_match('/a880/i', $useragent)) {
            $deviceCode = 'a880';
        }

        if (preg_match('/a850\+/i', $useragent)) {
            $deviceCode = 'a850+';
        }

        if (preg_match('/a850/i', $useragent)) {
            $deviceCode = 'a850';
        }

        if (preg_match('/a820/i', $useragent)) {
            $deviceCode = 'a820';
        }

        if (preg_match('/a816/i', $useragent)) {
            $deviceCode = 'a816';
        }

        if (preg_match('/a789/i', $useragent)) {
            $deviceCode = 'a789';
        }

        if (preg_match('/a766/i', $useragent)) {
            $deviceCode = 'a766';
        }

        if (preg_match('/a660/i', $useragent)) {
            $deviceCode = 'a660';
        }

        if (preg_match('/a656/i', $useragent)) {
            $deviceCode = 'a656';
        }

        if (preg_match('/a606/i', $useragent)) {
            $deviceCode = 'a606';
        }

        if (preg_match('/a590/i', $useragent)) {
            $deviceCode = 'a590';
        }

        if (preg_match('/a536/i', $useragent)) {
            $deviceCode = 'a536';
        }

        if (preg_match('/a390/i', $useragent)) {
            $deviceCode = 'a390';
        }

        if (preg_match('/a388t/i', $useragent)) {
            $deviceCode = 'a388t';
        }

        if (preg_match('/a328/i', $useragent)) {
            $deviceCode = 'a328';
        }

        if (preg_match('/a319/i', $useragent)) {
            $deviceCode = 'a319';
        }

        if (preg_match('/a288t/i', $useragent)) {
            $deviceCode = 'a288t';
        }

        if (preg_match('/a65/i', $useragent)) {
            $deviceCode = 'a65';
        }

        if (preg_match('/a60/i', $useragent)) {
            $deviceCode = 'a60';
        }

        if (preg_match('/(SmartTabIII10|Smart Tab III 10)/i', $useragent)) {
            $deviceCode = 'smart tab iii 10';
        }

        if (preg_match('/(SmartTabII10|SmartTab II 10)/i', $useragent)) {
            $deviceCode = 'smarttab ii 10';
        }

        if (preg_match('/SmartTabII7/i', $useragent)) {
            $deviceCode = 'smarttab ii 7';
        }

        if (preg_match('/smart tab 4g/i', $useragent)) {
            $deviceCode = 'smart tab 4g';
        }

        if (preg_match('/smart tab 4/i', $useragent)) {
            $deviceCode = 'smart tab 4';
        }

        if (preg_match('/smart tab 3g/i', $useragent)) {
            $deviceCode = 'smart tab 3g';
        }

        if (preg_match('/ThinkPad/i', $useragent)) {
            $deviceCode = '1838';
        }

        if (preg_match('/AT1010\-T/', $useragent)) {
            $deviceCode = 'at1010-t';
        }

        return (new Factory\DeviceFactory())->get($deviceCode, $useragent);
    }
}
