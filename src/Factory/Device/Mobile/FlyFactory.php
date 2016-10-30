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
class FlyFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general fly device';

        if (preg_match('/IQ4504/', $useragent)) {
            $deviceCode = 'iq4504';
        }

        if (preg_match('/IQ4502/', $useragent)) {
            $deviceCode = 'iq4502';
        }

        if (preg_match('/IQ4415/', $useragent)) {
            $deviceCode = 'iq4415';
        }

        if (preg_match('/IQ4411/', $useragent)) {
            $deviceCode = 'iq4411 quad energie2';
        }

        if (preg_match('/phoenix 2/i', $useragent)) {
            $deviceCode = 'iq4410i';
        }

        if (preg_match('/IQ4490/', $useragent)) {
            $deviceCode = 'iq4490';
        }

        if (preg_match('/IQ4410/', $useragent)) {
            $deviceCode = 'iq4410 quad phoenix';
        }

        if (preg_match('/IQ4409/', $useragent)) {
            $deviceCode = 'iq4409 quad';
        }

        if (preg_match('/IQ4404/', $useragent)) {
            $deviceCode = 'iq4404';
        }

        if (preg_match('/IQ4403/', $useragent)) {
            $deviceCode = 'iq4403';
        }

        if (preg_match('/IQ456/', $useragent)) {
            $deviceCode = 'iq456';
        }

        if (preg_match('/IQ452/', $useragent)) {
            $deviceCode = 'iq452';
        }

        if (preg_match('/IQ450/', $useragent)) {
            $deviceCode = 'iq450';
        }

        if (preg_match('/IQ449/', $useragent)) {
            $deviceCode = 'iq449';
        }

        if (preg_match('/IQ448/', $useragent)) {
            $deviceCode = 'iq448';
        }

        if (preg_match('/IQ444/', $useragent)) {
            $deviceCode = 'iq444';
        }

        if (preg_match('/IQ442/', $useragent)) {
            $deviceCode = 'iq442';
        }

        if (preg_match('/IQ436i/', $useragent)) {
            $deviceCode = 'iq436i';
        }

        if (preg_match('/IQ434/', $useragent)) {
            $deviceCode = 'iq434';
        }

        return (new Factory\DeviceFactory())->get($deviceCode, $useragent);
    }
}
