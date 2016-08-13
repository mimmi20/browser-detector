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

use BrowserDetector\Detector\Device\Mobile\Odys;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class OdysFactory implements FactoryInterface
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
        if (preg_match('/xtreme/i', $useragent)) {
            return new Odys\OdysXtreme($useragent);
        }

        if (preg_match('/XPRESS PRO/', $useragent)) {
            return new Odys\OdysXpressPro($useragent);
        }

        if (preg_match('/xpress/i', $useragent)) {
            return new Odys\OdysXpress($useragent);
        }

        if (preg_match('/(XENO10|XENO 10)/', $useragent)) {
            return new Odys\OdysXeno10($useragent);
        }

        if (preg_match('/XelioPT2Pro/', $useragent)) {
            return new Odys\OdysXelioPT2Pro($useragent);
        }

        if (preg_match('/(Xelio10Pro|Xelio 10 Pro)/i', $useragent)) {
            return new Odys\OdysXelio10Pro($useragent);
        }

        if (preg_match('/(XELIO10EXTREME|Xelio 10 Extreme)/', $useragent)) {
            return new Odys\OdysXelio10Extreme($useragent);
        }

        if (preg_match('/(XELIO7PRO|Xelio 7 pro)/', $useragent)) {
            return new Odys\OdysXelio7Pro($useragent);
        }

        if (preg_match('/xelio/i', $useragent)) {
            return new Odys\OdysXelio($useragent);
        }

        if (preg_match('/UNO\_X10/', $useragent)) {
            return new Odys\OdysUnoX10($useragent);
        }

        if (preg_match('/Space/', $useragent)) {
            return new Odys\OdysSpace($useragent);
        }

        if (preg_match('/sky plus/i', $useragent)) {
            return new Odys\OdysSkyPlus3g($useragent);
        }

        if (preg_match('/ODYS\-Q/', $useragent)) {
            return new Odys\OdysQ($useragent);
        }

        if (preg_match('/noon/i', $useragent)) {
            return new Odys\OdysNoon($useragent);
        }

        if (preg_match('/ADM816HC/', $useragent)) {
            return new Odys\OdysNeoX($useragent);
        }

        if (preg_match('/ADM816KC/', $useragent)) {
            return new Odys\OdysNeoS8Plus($useragent);
        }

        if (preg_match('/NEO\_QUAD10/', $useragent)) {
            return new Odys\OdysNeoQuad10($useragent);
        }

        if (preg_match('/loox plus/i', $useragent)) {
            return new Odys\OdysLooxPlus($useragent);
        }

        if (preg_match('/loox/i', $useragent)) {
            return new Odys\OdysLoox($useragent);
        }

        if (preg_match('/IEOS_QUAD/', $useragent)) {
            return new Odys\OdysIeosQuad($useragent);
        }

        if (preg_match('/genesis/i', $useragent)) {
            return new Odys\OdysGenesis($useragent);
        }

        if (preg_match('/evo/i', $useragent)) {
            return new Odys\OdysEvo($useragent);
        }

        return new Odys\Odys($useragent);
    }
}
