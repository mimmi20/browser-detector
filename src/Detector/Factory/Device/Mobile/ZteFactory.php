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

use BrowserDetector\Detector\Device\Mobile\Zte;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ZteFactory implements FactoryInterface
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
        if (preg_match('/blade v6/i', $useragent)) {
            return new Zte\ZteBladev6($useragent);
        }

        if (preg_match('/blade l6/i', $useragent)) {
            return new Zte\ZteBladeL6($useragent);
        }

        if (preg_match('/blade l5 plus/i', $useragent)) {
            return new Zte\ZteBladeL5plus($useragent);
        }

        if (preg_match('/n919/i', $useragent)) {
            return new Zte\ZteN919($useragent);
        }

        if (preg_match('/x920/i', $useragent)) {
            return new Zte\ZteX920($useragent);
        }

        if (preg_match('/w713/i', $useragent)) {
            return new Zte\ZteW713($useragent);
        }

        if (preg_match('/z221/i', $useragent)) {
            return new Zte\ZteZ221($useragent);
        }

        if (preg_match('/v970/i', $useragent)) {
            return new Zte\ZteV970($useragent);
        }

        if (preg_match('/v967s/i', $useragent)) {
            return new Zte\ZteV967s($useragent);
        }

        if (preg_match('/v880/i', $useragent)) {
            return new Zte\ZteV880($useragent);
        }

        if (preg_match('/v808/i', $useragent)) {
            return new Zte\ZteV808($useragent);
        }

        if (preg_match('/v788d/i', $useragent)) {
            return new Zte\ZteV788D($useragent);
        }

        if (preg_match('/v9/i', $useragent)) {
            return new Zte\ZteV9($useragent);
        }

        if (preg_match('/u930hd/i', $useragent)) {
            return new Zte\ZteU930Hd($useragent);
        }

        if (preg_match('/smarttab10/i', $useragent)) {
            return new Zte\ZteSmartTab10($useragent);
        }

        if (preg_match('/smarttab7/i', $useragent)) {
            return new Zte\ZteSmartTab7($useragent);
        }

        if (preg_match('/vodafone smart 4g/i', $useragent)) {
            return new Zte\ZteSmart4G($useragent);
        }

        if (preg_match('/zte[ \-]skate/i', $useragent)) {
            return new Zte\ZteSkatE($useragent);
        }

        if (preg_match('/racerii/i', $useragent)) {
            return new Zte\ZteRacerIi($useragent);
        }

        if (preg_match('/racer/i', $useragent)) {
            return new Zte\ZteRacer($useragent);
        }

        if (preg_match('/zteopen/i', $useragent)) {
            return new Zte\ZteOpen($useragent);
        }

        if (preg_match('/nx501/i', $useragent)) {
            return new Zte\ZteNx501($useragent);
        }

        if (preg_match('/nx402/i', $useragent)) {
            return new Zte\ZteNx402($useragent);
        }

        if (preg_match('/n918st/i', $useragent)) {
            return new Zte\ZteN918St($useragent);
        }

        if (preg_match('/ n600 /i', $useragent)) {
            return new Zte\ZteN600($useragent);
        }

        if (preg_match('/kis plus/i', $useragent)) {
            return new Zte\ZteKisPlus($useragent);
        }

        if (preg_match('/blade q maxi/i', $useragent)) {
            return new Zte\ZteBladeQMaxi($useragent);
        }

        if (preg_match('/blade iii\_il/i', $useragent)) {
            return new Zte\ZteBlade3($useragent);
        }

        if (preg_match('/blade/i', $useragent)) {
            return new Zte\ZteBlade($useragent);
        }

        if (preg_match('/base tab/i', $useragent)) {
            return new Zte\ZteBaseTab($useragent);
        }

        if (preg_match('/base_lutea_3/i', $useragent)) {
            return new Zte\BaseLutea3($useragent);
        }

        if (preg_match('/base lutea 2/i', $useragent)) {
            return new Zte\ZteBaseLutea2($useragent);
        }

        if (preg_match('/base lutea/i', $useragent)) {
            return new Zte\ZteBaseLutea($useragent);
        }

        if (preg_match('/atlas\_w/i', $useragent)) {
            return new Zte\ZteAtlasW($useragent);
        }

        if (preg_match('/tania/i', $useragent)) {
            return new Zte\ZteTania($useragent);
        }

        if (preg_match('/g\-x991\-rio\-orange/i', $useragent)) {
            return new Zte\ZteGX991RioOrange($useragent);
        }

        if (preg_match('/beeline pro/i', $useragent)) {
            return new Zte\ZteBeelinePro($useragent);
        }

        return new Zte\Zte($useragent);
    }
}
