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

use BrowserDetector\Detector\Device\Mobile\Xiaomi;
use BrowserDetector\Detector\Factory\DeviceFactory;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class XiaomiFactory implements FactoryInterface
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
        if (preg_match('/MI MAX/', $useragent)) {
            $deviceCode = 'mi max';
        }

        if (preg_match('/MI 4LTE/', $useragent)) {
            $deviceCode = 'mi 4 lte';
        }

        if (preg_match('/MI 3W/', $useragent)) {
            $deviceCode = 'mi 3w';
        }

        if (preg_match('/(MI PAD|MiPad)/', $useragent)) {
            $deviceCode = 'mi pad';
        }

        if (preg_match('/MI 2A/', $useragent)) {
            $deviceCode = 'mi 2a';
        }

        if (preg_match('/MI 2/', $useragent)) {
            $deviceCode = 'mi 2';
        }

        if (preg_match('/Redmi 3S/', $useragent)) {
            $deviceCode = 'redmi 3s';
        }

        if (preg_match('/Redmi 3/', $useragent)) {
            $deviceCode = 'redmi 3';
        }

        if (preg_match('/Redmi_Note_3/', $useragent)) {
            $deviceCode = 'redmi note 3';
        }

        if (preg_match('/Redmi Note 2/', $useragent)) {
            $deviceCode = 'redmi note 2';
        }

        if (preg_match('/HM NOTE 1W/', $useragent)) {
            $deviceCode = 'hm note 1w';
        }

        if (preg_match('/HM NOTE 1S/', $useragent)) {
            $deviceCode = 'hm note 1s';
        }

        if (preg_match('/HM NOTE 1LTETD/', $useragent)) {
            $deviceCode = 'hm note 1lte td';
        }

        if (preg_match('/HM NOTE 1LTE/', $useragent)) {
            $deviceCode = 'hm note 1lte';
        }

        if (preg_match('/HM\_1SW/', $useragent)) {
            $deviceCode = 'hm 1sw';
        }

        if (preg_match('/HM 1SC/', $useragent)) {
            $deviceCode = 'hm 1sc';
        }

        $deviceCode = 'general xiaomi device';

        return DeviceFactory::get($deviceCode, $useragent);
    }
}
