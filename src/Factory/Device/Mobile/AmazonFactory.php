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
class AmazonFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general amazon device';

        if (preg_match('/kftt/i', $useragent)) {
            $deviceCode = 'kftt';
        }

        if (preg_match('/kfthwi/i', $useragent)) {
            $deviceCode = 'kfthwi';
        }

        if (preg_match('/kfsowi/i', $useragent)) {
            $deviceCode = 'kfsowi';
        }

        if (preg_match('/kfot/i', $useragent)) {
            $deviceCode = 'kfot';
        }

        if (preg_match('/kfjwi/i', $useragent)) {
            $deviceCode = 'kfjwi';
        }

        if (preg_match('/kfjwa/i', $useragent)) {
            $deviceCode = 'kfjwa';
        }

        if (preg_match('/kfaswi/i', $useragent)) {
            $deviceCode = 'kfaswi';
        }

        if (preg_match('/kfapwi/i', $useragent)) {
            $deviceCode = 'kfapwi';
        }

        if (preg_match('/kfapwa/i', $useragent)) {
            $deviceCode = 'kfapwa';
        }

        if (preg_match('/sd4930ur/i', $useragent)) {
            $deviceCode = 'sd4930ur';
        }

        if (preg_match('/kindle fire/i', $useragent)) {
            $deviceCode = 'd01400';
        }

        if (preg_match('/(kindle|silk)/i', $useragent)) {
            $deviceCode = 'kindle';
        }

        return (new Factory\DeviceFactory())->get($deviceCode, $useragent);
    }
}
