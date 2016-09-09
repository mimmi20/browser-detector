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

use BrowserDetector\Detector\Device\Mobile\Lenovo;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class LenovoFactory implements FactoryInterface
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
        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent);
        }

        if (preg_match('/S6000\-H/i', $useragent)) {
            return new Lenovo\LenovoS6000hIdeaTab($useragent);
        }

        if (preg_match('/S6000\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000fIdeaTab($useragent);
        }

        if (preg_match('/S5000\-H/i', $useragent)) {
            return new Lenovo\LenovoS5000h($useragent);
        }

        if (preg_match('/S5000\-F/i', $useragent)) {
            return new Lenovo\LenovoS5000f($useragent);
        }

        if (preg_match('/(IdeaTabS2110AF|IdeaTabS2110AH)/i', $useragent)) {
            return new Lenovo\LenovoS2110afIdeaTab($useragent);
        }

        if (preg_match('/S920\_ROW/i', $useragent)) {
            return new Lenovo\LenovoS920($useragent);
        }

        if (preg_match('/s880i/i', $useragent)) {
            return new Lenovo\LenovoS880i($useragent);
        }

        if (preg_match('/s856/i', $useragent)) {
            return new Lenovo\LenovoS856($useragent);
        }

        if (preg_match('/S820\_ROW/i', $useragent)) {
            return new Lenovo\LenovoS820row($useragent);
        }

        if (preg_match('/S660/i', $useragent)) {
            return new Lenovo\LenovoS660($useragent);
        }

        if (preg_match('/P1032X/i', $useragent)) {
            return new Lenovo\LenovoP1032x($useragent);
        }

        if (preg_match('/P780/i', $useragent)) {
            return new Lenovo\LenovoP780($useragent);
        }

        if (preg_match('/K910L/i', $useragent)) {
            return new Lenovo\LenovoK910l($useragent);
        }

        if (preg_match('/ K1/i', $useragent)) {
            return new Lenovo\LenovoIdeaPadK1($useragent);
        }

        if (preg_match('/IdeaPadA10/i', $useragent)) {
            return new Lenovo\LenovoIdeaPadA10($useragent);
        }

        if (preg_match('/A1\_07/i', $useragent)) {
            return new Lenovo\LenovoIdeaPadA1($useragent);
        }

        if (preg_match('/B8080\-H/i', $useragent)) {
            return new Lenovo\LenovoB8080h($useragent);
        }

        if (preg_match('/B8080\-F/i', $useragent)) {
            return new Lenovo\LenovoB8080f($useragent);
        }

        if (preg_match('/B8000\-H/i', $useragent)) {
            return new Lenovo\LenovoB8000h($useragent);
        }

        if (preg_match('/B8000\-F/i', $useragent)) {
            return new Lenovo\LenovoB8000f($useragent);
        }

        if (preg_match('/B6000\-H/i', $useragent)) {
            return new Lenovo\LenovoB6000h($useragent);
        }

        if (preg_match('/B6000\-F/i', $useragent)) {
            return new Lenovo\LenovoB6000f($useragent);
        }

        if (preg_match('/A7600\-H/i', $useragent)) {
            return new Lenovo\LenovoA7600h($useragent);
        }

        if (preg_match('/A7600\-F/i', $useragent)) {
            return new Lenovo\LenovoA7600f($useragent);
        }

        if (preg_match('/A5500\-H/i', $useragent)) {
            return new Lenovo\LenovoA5500hIdeaTab($useragent);
        }

        if (preg_match('/A5500\-F/i', $useragent)) {
            return new Lenovo\LenovoA5500f($useragent);
        }

        if (preg_match('/A3500\-H/i', $useragent)) {
            return new Lenovo\LenovoA3500h($useragent);
        }

        if (preg_match('/A3500\-FL/i', $useragent)) {
            return new Lenovo\LenovoA3500flIdeaTab($useragent);
        }

        if (preg_match('/A3300\-HV/i', $useragent)) {
            return new Lenovo\LenovoA3300hv($useragent);
        }

        if (preg_match('/A3300\-H/i', $useragent)) {
            return new Lenovo\LenovoA3300h($useragent);
        }

        if (preg_match('/A3000\-H/i', $useragent)) {
            return new Lenovo\LenovoA3000hIdeaTab($useragent);
        }

        if (preg_match('/A2107A\-H/i', $useragent)) {
            return new Lenovo\LenovoA2107ahIdeaTab($useragent);
        }

        if (preg_match('/A1107/i', $useragent)) {
            return new Lenovo\LenovoA1107($useragent);
        }

        if (preg_match('/A1000\-F/i', $useragent)) {
            return new Lenovo\LenovoA1000f($useragent);
        }

        if (preg_match('/A1000L\-F/i', $useragent)) {
            return new Lenovo\LenovoA1000lf($useragent);
        }

        if (preg_match('/(A2109A|IdeaTab)/i', $useragent)) {
            return new Lenovo\LenovoA2109aIdeaTab($useragent);
        }

        if (preg_match('/A889/i', $useragent)) {
            return new Lenovo\LenovoA889($useragent);
        }

        if (preg_match('/A880/i', $useragent)) {
            return new Lenovo\LenovoA880($useragent);
        }

        if (preg_match('/A850\+/i', $useragent)) {
            return new Lenovo\LenovoA850Plus($useragent);
        }

        if (preg_match('/A850/i', $useragent)) {
            return new Lenovo\LenovoA850($useragent);
        }

        if (preg_match('/A820/i', $useragent)) {
            return new Lenovo\LenovoA820($useragent);
        }

        if (preg_match('/A816/i', $useragent)) {
            return new Lenovo\LenovoA816($useragent);
        }

        if (preg_match('/A789/i', $useragent)) {
            return new Lenovo\LenovoA789($useragent);
        }

        if (preg_match('/A660/i', $useragent)) {
            return new Lenovo\LenovoA660($useragent);
        }

        if (preg_match('/A656/i', $useragent)) {
            return new Lenovo\LenovoA656($useragent);
        }

        if (preg_match('/A590/i', $useragent)) {
            return new Lenovo\LenovoA590($useragent);
        }

        if (preg_match('/A536/i', $useragent)) {
            return new Lenovo\LenovoA536($useragent);
        }

        if (preg_match('/A390/i', $useragent)) {
            return new Lenovo\LenovoA390($useragent);
        }

        if (preg_match('/a388t/i', $useragent)) {
            return new Lenovo\LenovoA388T($useragent);
        }

        if (preg_match('/A328/i', $useragent)) {
            return new Lenovo\LenovoA328($useragent);
        }

        if (preg_match('/A319/i', $useragent)) {
            return new Lenovo\LenovoA319($useragent);
        }

        if (preg_match('/A288t/i', $useragent)) {
            return new Lenovo\LenovoA288t($useragent);
        }

        if (preg_match('/A65/i', $useragent)) {
            return new Lenovo\LenovoA65($useragent);
        }

        if (preg_match('/A60/i', $useragent)) {
            return new Lenovo\LenovoA60($useragent);
        }

        if (preg_match('/(SmartTabIII10|Smart Tab III 10)/i', $useragent)) {
            return new Lenovo\VodafoneSmartTabIii10($useragent);
        }

        if (preg_match('/(SmartTabII10|SmartTab II 10)/i', $useragent)) {
            return new Lenovo\VodafoneSmartTabIi10($useragent);
        }

        if (preg_match('/SmartTabII7/i', $useragent)) {
            return new Lenovo\VodafoneSmartTabIi7($useragent);
        }

        if (preg_match('/Smart Tab 4/i', $useragent)) {
            return new Lenovo\VodafoneSmartTab4($useragent);
        }

        if (preg_match('/Smart Tab 3G/i', $useragent)) {
            return new Lenovo\VodafoneSmartTab3g($useragent);
        }

        if (preg_match('/ThinkPad/i', $useragent)) {
            return new Lenovo\ThinkPadTablet($useragent);
        }

        return new Lenovo\Lenovo($useragent);
    }
}
