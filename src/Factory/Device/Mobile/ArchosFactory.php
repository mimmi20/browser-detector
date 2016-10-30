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
class ArchosFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general archos device';

        if (preg_match('/A101IT/i', $useragent)) {
            $deviceCode = 'a101it';
        }

        if (preg_match('/A80KSC/i', $useragent)) {
            $deviceCode = 'a80ksc';
        }

        if (preg_match('/A70S/i', $useragent)) {
            $deviceCode = 'a70s';
        }

        if (preg_match('/A70HB/i', $useragent)) {
            $deviceCode = 'a70hb';
        }

        if (preg_match('/A70H2/i', $useragent)) {
            $deviceCode = 'a70 h2';
        }

        if (preg_match('/A70CHT/i', $useragent)) {
            $deviceCode = 'a70cht';
        }

        if (preg_match('/A70BHT/i', $useragent)) {
            $deviceCode = 'a70bht';
        }

        if (preg_match('/a35dm/i', $useragent)) {
            $deviceCode = 'a35dm';
        }

        if (preg_match('/a7eb/i', $useragent)) {
            $deviceCode = '70c';
        }

        if (preg_match('/101 xs 2/i', $useragent)) {
            $deviceCode = '101 xs 2';
        }

        if (preg_match('/121 neon/i', $useragent)) {
            $deviceCode = '121 neon';
        }

        if (preg_match('/101d neon/i', $useragent)) {
            $deviceCode = '101d neon';
        }

        if (preg_match('/101 neon/i', $useragent)) {
            $deviceCode = '101 neon';
        }

        if (preg_match('/101 copper/i', $useragent)) {
            $deviceCode = '101 copper';
        }

        if (preg_match('/101g10/i', $useragent)) {
            $deviceCode = '101g10';
        }

        if (preg_match('/101g9/i', $useragent)) {
            $deviceCode = '101 g9';
        }

        if (preg_match('/101b/i', $useragent)) {
            $deviceCode = '101b';
        }

        if (preg_match('/97 xenon/i', $useragent)) {
            $deviceCode = '97 xenon';
        }

        if (preg_match('/97 TITANIUMHD/i', $useragent)) {
            $deviceCode = '97 titanium hd';
        }

        if (preg_match('/97 neon/i', $useragent)) {
            $deviceCode = '97 neon';
        }

        if (preg_match('/97 carbon/i', $useragent)) {
            $deviceCode = '97 carbon';
        }

        if (preg_match('/80xsk/i', $useragent)) {
            $deviceCode = '80xsk';
        }

        if (preg_match('/80 xenon/i', $useragent)) {
            $deviceCode = '80 xenon';
        }

        if (preg_match('/80g9/i', $useragent)) {
            $deviceCode = '80 g9';
        }

        if (preg_match('/80 cobalt/i', $useragent)) {
            $deviceCode = '80 cobalt';
        }

        if (preg_match('/79 xenon/i', $useragent)) {
            $deviceCode = '79 xenon';
        }

        if (preg_match('/70 xenon/i', $useragent)) {
            $deviceCode = '70 xenon';
        }

        if (preg_match('/70it2/i', $useragent)) {
            $deviceCode = '70it2';
        }

        if (preg_match('/53 platinum/i', $useragent)) {
            $deviceCode = '53 platinum';
        }

        if (preg_match('/50 titanium/i', $useragent)) {
            $deviceCode = '50 titanium';
        }

        if (preg_match('/50b platinum/i', $useragent)) {
            $deviceCode = '50b platinum';
        }

        if (preg_match('/50 platinum/i', $useragent)) {
            $deviceCode = '50 platinum';
        }

        if (preg_match('/50 cesium/i', $useragent)) {
            $deviceCode = '50 cesium';
        }

        if (preg_match('/50 oxygen plus/i', $useragent)) {
            $deviceCode = '50 oxygen plus';
        }

        if (preg_match('/50c oxygen/i', $useragent)) {
            $deviceCode = '50c oxygen';
        }

        if (preg_match('/40 cesium/i', $useragent)) {
            $deviceCode = '40 cesium';
        }

        if (preg_match('/40b titanium surround/i', $useragent)) {
            $deviceCode = '40b titanium surround';
        }

        if (preg_match('/archos5/i', $useragent)) {
            $deviceCode = '5';
        }

        if (preg_match('/FAMILYPAD 2/i', $useragent)) {
            $deviceCode = 'family pad 2';
        }

        if (preg_match('/bush windows phone/i', $useragent)) {
            $deviceCode = 'eluma';
        }

        return (new Factory\DeviceFactory())->get($deviceCode, $useragent);
    }
}
