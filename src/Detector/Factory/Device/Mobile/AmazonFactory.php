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

use BrowserDetector\Detector\Device\Mobile\Amazon;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AmazonFactory implements FactoryInterface
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
        if (preg_match('/kftt/i', $useragent)) {
            return new Amazon\AmazonKftt($useragent, []);
        }

        if (preg_match('/kfthwi/i', $useragent)) {
            return new Amazon\AmazonKfthwi($useragent, []);
        }

        if (preg_match('/kfsowi/i', $useragent)) {
            return new Amazon\AmazonKfsowi($useragent, []);
        }

        if (preg_match('/kfot/i', $useragent)) {
            return new Amazon\AmazonKfot($useragent, []);
        }

        if (preg_match('/kfjwi/i', $useragent)) {
            return new Amazon\AmazonKfjwi($useragent, []);
        }

        if (preg_match('/kfjwa/i', $useragent)) {
            return new Amazon\AmazonKfjwa($useragent, []);
        }

        if (preg_match('/kfaswi/i', $useragent)) {
            return new Amazon\AmazonKfaswi($useragent, []);
        }

        if (preg_match('/kfapwi/i', $useragent)) {
            return new Amazon\AmazonKfapwi($useragent, []);
        }

        if (preg_match('/kfapwa/i', $useragent)) {
            return new Amazon\AmazonKfapwa($useragent, []);
        }

        if (preg_match('/sd4930ur/i', $useragent)) {
            return new Amazon\AmazonSd4930urFirePhone($useragent, []);
        }

        if (preg_match('/kindle fire/i', $useragent)) {
            return new Amazon\AmazonKindleFire($useragent, []);
        }

        if (preg_match('/(kindle|silk)/i', $useragent)) {
            return new Amazon\AmazonKindle($useragent, []);
        }

        return new Amazon($useragent, []);
    }
}
