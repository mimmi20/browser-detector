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

use BrowserDetector\Detector\Device\Mobile\Fly;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class FlyFactory implements FactoryInterface
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
        if (preg_match('/IQ4504/', $useragent)) {
            return new Fly\FlyIq4504($useragent);
        }

        if (preg_match('/IQ4502/', $useragent)) {
            return new Fly\FlyIq4502($useragent);
        }

        if (preg_match('/IQ4415/', $useragent)) {
            return new Fly\FlyIq4415($useragent);
        }

        if (preg_match('/IQ4411/', $useragent)) {
            return new Fly\FlyIq4411($useragent);
        }

        if (preg_match('/phoenix 2/i', $useragent)) {
            return new Fly\FlyIq4410i($useragent);
        }

        if (preg_match('/IQ4490/', $useragent)) {
            return new Fly\FlyIq4490($useragent);
        }

        if (preg_match('/IQ4410/', $useragent)) {
            return new Fly\FlyIq4410($useragent);
        }

        if (preg_match('/IQ4409/', $useragent)) {
            return new Fly\FlyIq4409($useragent);
        }

        if (preg_match('/IQ4404/', $useragent)) {
            return new Fly\FlyIq4404($useragent);
        }

        if (preg_match('/IQ4403/', $useragent)) {
            return new Fly\FlyIq4403($useragent);
        }

        if (preg_match('/IQ456/', $useragent)) {
            return new Fly\FlyIq456($useragent);
        }

        if (preg_match('/IQ452/', $useragent)) {
            return new Fly\FlyIq452($useragent);
        }

        if (preg_match('/IQ450/', $useragent)) {
            return new Fly\FlyIq450($useragent);
        }

        if (preg_match('/IQ449/', $useragent)) {
            return new Fly\FlyIq449($useragent);
        }

        if (preg_match('/IQ448/', $useragent)) {
            return new Fly\FlyIq448($useragent);
        }

        if (preg_match('/IQ444/', $useragent)) {
            return new Fly\FlyIq444($useragent);
        }

        if (preg_match('/IQ442/', $useragent)) {
            return new Fly\FlyIq442($useragent);
        }

        if (preg_match('/IQ436i/', $useragent)) {
            return new Fly\FlyIq436i($useragent);
        }

        if (preg_match('/IQ434/', $useragent)) {
            return new Fly\FlyIq434($useragent);
        }

        return new Fly\Fly($useragent);
    }
}
