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
class SharpFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general sharp device';

        if (preg_match('/SHARP\-TQ\-GX30i/', $useragent)) {
            $deviceCode = 'tq-gx30i';
        }

        if (preg_match('/SH\-10D/', $useragent)) {
            $deviceCode = 'sh-10d';
        }

        if (preg_match('/SH\-01F/', $useragent)) {
            $deviceCode = 'sh-01f';
        }

        if (preg_match('/SH8128U/', $useragent)) {
            $deviceCode = 'sh8128u';
        }

        if (preg_match('/SH7228U/', $useragent)) {
            $deviceCode = 'sh7228u';
        }

        if (preg_match('/306SH/', $useragent)) {
            $deviceCode = '306sh';
        }

        if (preg_match('/304SH/', $useragent)) {
            $deviceCode = '304sh';
        }

        if (preg_match('/SH80F/', $useragent)) {
            $deviceCode = 'sh80f';
        }

        if (preg_match('/SH05C/', $useragent)) {
            $deviceCode = 'sh-05c';
        }

        if (preg_match('/IS05/', $useragent)) {
            $deviceCode = 'is05';
        }

        return (new Factory\DeviceFactory())->get($deviceCode, $useragent);
    }
}
