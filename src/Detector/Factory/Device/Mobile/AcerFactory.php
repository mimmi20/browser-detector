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

use BrowserDetector\Detector\Device\Mobile\Acer;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AcerFactory implements FactoryInterface
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
        if (preg_match('/V989/i', $useragent)) {
            return new Acer\AcerV989($useragent, []);
        }

        if (preg_match('/V370/i', $useragent)) {
            return new Acer\AcerV370($useragent, []);
        }

        if (preg_match('/Stream\-S110/i', $useragent)) {
            return new Acer\AcerStreamS110($useragent, []);
        }

        if (preg_match('/S500/i', $useragent)) {
            return new Acer\AcerS500($useragent, []);
        }

        if (preg_match('/Liquid (MT|Metal)/i', $useragent)) {
            return new Acer\AcerS120LiquidMetal($useragent, []);
        }

        if (preg_match('/Z150/i', $useragent)) {
            return new Acer\AcerLiquidZ150($useragent, []);
        }

        if (preg_match('/Liquid/i', $useragent)) {
            return new Acer\AcerLiquidS100($useragent, []);
        }

        if (preg_match('/b1\-730hd/i', $useragent)) {
            return new Acer\AcerIconiaB1730hd($useragent, []);
        }

        if (preg_match('/b1\-721/i', $useragent)) {
            return new Acer\AcerIconiaB1721($useragent, []);
        }

        if (preg_match('/b1\-711/i', $useragent)) {
            return new Acer\AcerIconiaB1711($useragent, []);
        }

        if (preg_match('/b1\-710/i', $useragent)) {
            return new Acer\AcerIconiaB1710($useragent, []);
        }

        if (preg_match('/b1\-a71/i', $useragent)) {
            return new Acer\AcerIconiaB1a71($useragent, []);
        }

        if (preg_match('/a1\-830/i', $useragent)) {
            return new Acer\AcerIconiaA1830($useragent, []);
        }

        if (preg_match('/a1\-811/i', $useragent)) {
            return new Acer\AcerIconiaA1811($useragent, []);
        }

        if (preg_match('/a1\-810/i', $useragent)) {
            return new Acer\AcerIconiaA1810($useragent, []);
        }

        if (preg_match('/A742/i', $useragent)) {
            return new Acer\AcerIconiaA742($useragent, []);
        }

        if (preg_match('/A701/i', $useragent)) {
            return new Acer\AcerIconiaA701($useragent, []);
        }

        if (preg_match('/A700/i', $useragent)) {
            return new Acer\AcerIconiaA700($useragent, []);
        }

        if (preg_match('/A511/i', $useragent)) {
            return new Acer\AcerIconiaA511($useragent, []);
        }

        if (preg_match('/A510/i', $useragent)) {
            return new Acer\AcerIconiaA510($useragent, []);
        }

        if (preg_match('/A501/i', $useragent)) {
            return new Acer\AcerIconiaA501($useragent, []);
        }

        if (preg_match('/A500/i', $useragent)) {
            return new Acer\AcerIconiaA500($useragent, []);
        }

        if (preg_match('/A211/i', $useragent)) {
            return new Acer\AcerIconiaA211($useragent, []);
        }

        if (preg_match('/A210/i', $useragent)) {
            return new Acer\AcerIconiaA210($useragent, []);
        }

        if (preg_match('/A200/i', $useragent)) {
            return new Acer\AcerIconiaA200($useragent, []);
        }

        if (preg_match('/A101C/i', $useragent)) {
            return new Acer\AcerIconiaA101c($useragent, []);
        }

        if (preg_match('/A101/i', $useragent)) {
            return new Acer\AcerIconiaA101($useragent, []);
        }

        if (preg_match('/A100/i', $useragent)) {
            return new Acer\AcerIconiaA100($useragent, []);
        }

        if (preg_match('/a3\-a20/i', $useragent)) {
            return new Acer\AcerIconiaA3A20($useragent, []);
        }

        if (preg_match('/a3\-a10/i', $useragent)) {
            return new Acer\AcerIconiaA3A10($useragent, []);
        }

        if (preg_match('/Iconia/i', $useragent)) {
            return new Acer\AcerIconia($useragent, []);
        }

        if (preg_match('/G100W/i', $useragent)) {
            return new Acer\AcerG100W($useragent, []);
        }

        if (preg_match('/E320/i', $useragent)) {
            return new Acer\AcerE320($useragent, []);
        }

        if (preg_match('/E310/i', $useragent)) {
            return new Acer\AcerE310($useragent, []);
        }

        if (preg_match('/E140/i', $useragent)) {
            return new Acer\AcerE140($useragent, []);
        }

        if (preg_match('/DA241HL/i', $useragent)) {
            return new Acer\AcerDa241hl($useragent, []);
        }

        if (preg_match('/Allegro/i', $useragent)) {
            return new Acer\AcerAllegro($useragent, []);
        }

        return new Acer\Acer($useragent, []);
    }
}
