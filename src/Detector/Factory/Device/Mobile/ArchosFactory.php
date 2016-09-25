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

use BrowserDetector\Detector\Device\Mobile\Archos;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ArchosFactory implements FactoryInterface
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
        if (preg_match('/A101IT/i', $useragent)) {
            return new Archos\ArchosA101it($useragent);
        }

        if (preg_match('/A80KSC/i', $useragent)) {
            return new Archos\ArchosA80KSC($useragent);
        }

        if (preg_match('/A70S/i', $useragent)) {
            return new Archos\ArchosA70S($useragent);
        }

        if (preg_match('/A70HB/i', $useragent)) {
            return new Archos\ArchosA70HB($useragent);
        }

        if (preg_match('/A70H2/i', $useragent)) {
            return new Archos\ArchosA70H2($useragent);
        }

        if (preg_match('/A70CHT/i', $useragent)) {
            return new Archos\ArchosA70CHT($useragent);
        }

        if (preg_match('/A70BHT/i', $useragent)) {
            return new Archos\ArchosA70BHT($useragent);
        }

        if (preg_match('/a35dm/i', $useragent)) {
            return new Archos\ArchosA35DM($useragent);
        }

        if (preg_match('/a7eb/i', $useragent)) {
            return new Archos\ArchosA7eb($useragent);
        }

        if (preg_match('/101 xs 2/i', $useragent)) {
            return new Archos\Archos101xs2($useragent);
        }

        if (preg_match('/121 neon/i', $useragent)) {
            return new Archos\Archos121Neon($useragent);
        }

        if (preg_match('/101d neon/i', $useragent)) {
            return new Archos\Archos101dNeon($useragent);
        }

        if (preg_match('/101 neon/i', $useragent)) {
            return new Archos\Archos101Neon($useragent);
        }

        if (preg_match('/101 copper/i', $useragent)) {
            return new Archos\Archos101Copper($useragent);
        }

        if (preg_match('/101g10/i', $useragent)) {
            return new Archos\Archos101G10($useragent);
        }

        if (preg_match('/101g9/i', $useragent)) {
            return new Archos\Archos101G9($useragent);
        }

        if (preg_match('/101b/i', $useragent)) {
            return new Archos\Archos101B($useragent);
        }

        if (preg_match('/97 xenon/i', $useragent)) {
            return new Archos\Archos97Xenon($useragent);
        }

        if (preg_match('/97 TITANIUMHD/i', $useragent)) {
            return new Archos\Archos97TitaniumHd($useragent);
        }

        if (preg_match('/97 neon/i', $useragent)) {
            return new Archos\Archos97Neon($useragent);
        }

        if (preg_match('/97 carbon/i', $useragent)) {
            return new Archos\Archos97Carbon($useragent);
        }

        if (preg_match('/80xsk/i', $useragent)) {
            return new Archos\Archos80XSK($useragent);
        }

        if (preg_match('/80 xenon/i', $useragent)) {
            return new Archos\Archos80Xenon($useragent);
        }

        if (preg_match('/80g9/i', $useragent)) {
            return new Archos\Archos80G9($useragent);
        }

        if (preg_match('/80 cobalt/i', $useragent)) {
            return new Archos\Archos80Cobalt($useragent);
        }

        if (preg_match('/79 xenon/i', $useragent)) {
            return new Archos\Archos79Xenon($useragent);
        }

        if (preg_match('/70 xenon/i', $useragent)) {
            return new Archos\Archos70Xenon($useragent);
        }

        if (preg_match('/70it2/i', $useragent)) {
            return new Archos\Archos70it2($useragent);
        }

        if (preg_match('/53 platinum/i', $useragent)) {
            return new Archos\Archos53Platinum($useragent);
        }

        if (preg_match('/50 titanium/i', $useragent)) {
            return new Archos\Archos50Titanium($useragent);
        }

        if (preg_match('/50b platinum/i', $useragent)) {
            return new Archos\Archos50bPlatinum($useragent);
        }

        if (preg_match('/50 platinum/i', $useragent)) {
            return new Archos\Archos50Platinum($useragent);
        }

        if (preg_match('/50 cesium/i', $useragent)) {
            return new Archos\Archos50Cesium($useragent);
        }

        if (preg_match('/50 oxygen plus/i', $useragent)) {
            return new Archos\Archos50OxygenPlus($useragent);
        }

        if (preg_match('/50c oxygen/i', $useragent)) {
            return new Archos\Archos50cOxygen($useragent);
        }

        if (preg_match('/40 cesium/i', $useragent)) {
            return new Archos\Archos40Cesium($useragent);
        }

        if (preg_match('/40b titanium surround/i', $useragent)) {
            return new Archos\Archos40bTitaniumSurround($useragent);
        }

        if (preg_match('/archos5/i', $useragent)) {
            return new Archos\Archos5($useragent);
        }

        if (preg_match('/FAMILYPAD 2/i', $useragent)) {
            return new Archos\ArchosFamilyPad2($useragent);
        }

        if (preg_match('/bush windows phone/i', $useragent)) {
            return new Archos\BushEluma($useragent);
        }

        return new Archos\Archos($useragent);
    }
}
