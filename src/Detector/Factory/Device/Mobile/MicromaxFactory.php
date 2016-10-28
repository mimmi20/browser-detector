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

use BrowserDetector\Detector\Device\Mobile\Micromax;
use BrowserDetector\Detector\Factory\DeviceFactory;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MicromaxFactory implements FactoryInterface
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
        if (preg_match('/X650/i', $useragent)) {
            $deviceCode = 'x650';
        }

        if (preg_match('/A120/i', $useragent)) {
            $deviceCode = 'a120';
        }

        if (preg_match('/A116/i', $useragent)) {
            $deviceCode = 'a116';
        }

        if (preg_match('/A114/i', $useragent)) {
            $deviceCode = 'a114';
        }

        if (preg_match('/A101/i', $useragent)) {
            $deviceCode = 'micromax a101';
        }

        if (preg_match('/A093/i', $useragent)) {
            $deviceCode = 'a093';
        }

        if (preg_match('/A065/i', $useragent)) {
            $deviceCode = 'a065';
        }

        if (preg_match('/A59/i', $useragent)) {
            $deviceCode = 'a59';
        }

        if (preg_match('/A40/i', $useragent)) {
            $deviceCode = 'a40';
        }

        if (preg_match('/A35/i', $useragent)) {
            $deviceCode = 'a35';
        }

        if (preg_match('/A27/i', $useragent)) {
            $deviceCode = 'a27';
        }

        $deviceCode = 'general micromax device';

        return DeviceFactory::get($deviceCode, $useragent);
    }
}
