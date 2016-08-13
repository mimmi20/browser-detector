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

use BrowserDetector\Detector\Device\Mobile\Nokia;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class NokiaFactory implements FactoryInterface
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
        if (preg_match('/Lumia 510/i', $useragent)) {
            return new Nokia\NokiaLumia510($useragent);
        }

        if (preg_match('/Lumia 520/i', $useragent)) {
            return new Nokia\NokiaLumia520($useragent);
        }

        if (preg_match('/rm\-914/i', $useragent)) {
            return new Nokia\NokiaLumia520Rm914($useragent);
        }

        if (preg_match('/Lumia 530/i', $useragent)) {
            return new Nokia\NokiaLumia530($useragent);
        }

        if (preg_match('/Lumia 550/i', $useragent)) {
            return new Nokia\NokiaLumia550($useragent);
        }

        if (preg_match('/Lumia 610/i', $useragent)) {
            return new Nokia\NokiaLumia610($useragent);
        }

        if (preg_match('/Lumia 620/i', $useragent)) {
            return new Nokia\NokiaLumia620($useragent);
        }

        if (preg_match('/Lumia 625/i', $useragent)) {
            return new Nokia\NokiaLumia625($useragent);
        }

        if (preg_match('/Lumia 630/i', $useragent)) {
            return new Nokia\NokiaLumia630($useragent);
        }

        if (preg_match('/Lumia 635/i', $useragent)) {
            return new Nokia\NokiaLumia635($useragent);
        }

        if (preg_match('/Lumia 640 xl/i', $useragent)) {
            return new Nokia\NokiaLumia640xl($useragent);
        }

        if (preg_match('/Lumia 640/i', $useragent)) {
            return new Nokia\NokiaLumia640($useragent);
        }

        if (preg_match('/Lumia 710/i', $useragent)) {
            return new Nokia\NokiaLumia710($useragent);
        }

        if (preg_match('/Lumia 720/i', $useragent)) {
            return new Nokia\NokiaLumia720($useragent);
        }

        if (preg_match('/Lumia 730/i', $useragent)) {
            return new Nokia\NokiaLumia730($useragent);
        }

        if (preg_match('/Lumia 800/i', $useragent)) {
            return new Nokia\NokiaLumia800($useragent);
        }

        if (preg_match('/Lumia 820/i', $useragent)) {
            return new Nokia\NokiaLumia820($useragent);
        }

        if (preg_match('/Lumia 830/i', $useragent)) {
            return new Nokia\NokiaLumia830($useragent);
        }

        if (preg_match('/Lumia 900/i', $useragent)) {
            return new Nokia\NokiaLumia900($useragent);
        }

        if (preg_match('/Lumia 920/i', $useragent)) {
            return new Nokia\NokiaLumia920($useragent);
        }

        if (preg_match('/Lumia 925/i', $useragent)) {
            return new Nokia\NokiaLumia925($useragent);
        }

        if (preg_match('/Lumia 928/i', $useragent)) {
            return new Nokia\NokiaLumia928($useragent);
        }

        if (preg_match('/Lumia 930/i', $useragent)) {
            return new Nokia\NokiaLumia930($useragent);
        }

        if (preg_match('/Lumia 950 xl/i', $useragent)) {
            return new Nokia\NokiaLumia950xl($useragent);
        }

        if (preg_match('/Lumia 950/i', $useragent)) {
            return new Nokia\NokiaLumia950($useragent);
        }

        if (preg_match('/(Lumia 1020|nokia; 909)/i', $useragent)) {
            return new Nokia\NokiaLumia1020($useragent);
        }

        if (preg_match('/Lumia 1320/i', $useragent)) {
            return new Nokia\NokiaLumia1320($useragent);
        }

        if (preg_match('/Lumia 1520/i', $useragent)) {
            return new Nokia\NokiaLumia1520($useragent);
        }

        if (preg_match('/Lumia/i', $useragent)) {
            return new Nokia\NokiaLumia($useragent);
        }

        if (preg_match('/NokiaN81/i', $useragent)) {
            return new Nokia\NokiaN81($useragent);
        }

        if (preg_match('/NokiaN82/i', $useragent)) {
            return new Nokia\NokiaN82($useragent);
        }

        if (preg_match('/NokiaN85/i', $useragent)) {
            return new Nokia\NokiaN85($useragent);
        }

        if (preg_match('/NokiaN86/i', $useragent)) {
            return new Nokia\NokiaN86($useragent);
        }

        if (preg_match('/NokiaN8\-00/i', $useragent)) {
            return new Nokia\NokiaN800($useragent);
        }

        if (preg_match('/NokiaN8/i', $useragent)) {
            return new Nokia\NokiaN8($useragent);
        }

        if (preg_match('/NokiaN90/i', $useragent)) {
            return new Nokia\NokiaN90($useragent);
        }

        if (preg_match('/NokiaN91/i', $useragent)) {
            return new Nokia\NokiaN91($useragent);
        }

        if (preg_match('/NokiaN95/i', $useragent)) {
            return new Nokia\NokiaN95($useragent);
        }

        if (preg_match('/NokiaN96/i', $useragent)) {
            return new Nokia\NokiaN96($useragent);
        }

        if (preg_match('/NokiaN97/i', $useragent)) {
            return new Nokia\NokiaN97($useragent);
        }

        if (preg_match('/NokiaN900/i', $useragent)) {
            return new Nokia\NokiaN900($useragent);
        }

        if (preg_match('/NokiaN9/i', $useragent)) {
            return new Nokia\NokiaN9($useragent);
        }

        if (preg_match('/Nokia N70/i', $useragent)) {
            return new Nokia\NokiaN70($useragent);
        }

        if (preg_match('/Nokia N78/i', $useragent)) {
            return new Nokia\NokiaN78($useragent);
        }

        if (preg_match('/(Nokia N79|NokiaN79)/i', $useragent)) {
            return new Nokia\NokiaN79($useragent);
        }

        if (preg_match('/NokiaX2DS/i', $useragent)) {
            return new Nokia\NokiaX2ds($useragent);
        }

        if (preg_match('/NokiaX2\-00/i', $useragent)) {
            return new Nokia\NokiaX200($useragent);
        }

        if (preg_match('/NokiaX2\-01/i', $useragent)) {
            return new Nokia\NokiaX201($useragent);
        }

        if (preg_match('/NokiaX2\-02/i', $useragent)) {
            return new Nokia\NokiaX202($useragent);
        }

        if (preg_match('/NokiaX2\-05/i', $useragent)) {
            return new Nokia\NokiaX205($useragent);
        }

        if (preg_match('/NokiaX2/i', $useragent)) {
            return new Nokia\NokiaX2($useragent);
        }

        if (preg_match('/NokiaX3\-02/i', $useragent)) {
            return new Nokia\NokiaX302($useragent);
        }

        if (preg_match('/NokiaX3/i', $useragent)) {
            return new Nokia\NokiaX3($useragent);
        }

        if (preg_match('/NokiaX6\-00/i', $useragent)) {
            return new Nokia\NokiaX600($useragent);
        }

        if (preg_match('/NokiaX6/i', $useragent)) {
            return new Nokia\NokiaX6($useragent);
        }

        if (preg_match('/NokiaX7\-00/i', $useragent)) {
            return new Nokia\NokiaX700($useragent);
        }

        if (preg_match('/NokiaX7/i', $useragent)) {
            return new Nokia\NokiaX7($useragent);
        }

        if (preg_match('/NokiaE7\-00/i', $useragent)) {
            return new Nokia\NokiaE700($useragent);
        }

        if (preg_match('/NokiaE71/i', $useragent)) {
            return new Nokia\NokiaE71($useragent);
        }

        if (preg_match('/NokiaE72/i', $useragent)) {
            return new Nokia\NokiaE72($useragent);
        }

        if (preg_match('/NokiaE75/i', $useragent)) {
            return new Nokia\NokiaE75($useragent);
        }

        if (preg_match('/NokiaE7/i', $useragent)) {
            return new Nokia\NokiaE7($useragent);
        }

        if (preg_match('/NokiaE6\-00/i', $useragent)) {
            return new Nokia\NokiaE600($useragent);
        }

        if (preg_match('/NokiaE62/i', $useragent)) {
            return new Nokia\NokiaE62($useragent);
        }

        if (preg_match('/NokiaE63/i', $useragent)) {
            return new Nokia\NokiaE63($useragent);
        }

        if (preg_match('/NokiaE66/i', $useragent)) {
            return new Nokia\NokiaE66($useragent);
        }

        if (preg_match('/NokiaE6/i', $useragent)) {
            return new Nokia\NokiaE6($useragent);
        }

        if (preg_match('/NokiaE5\-00/i', $useragent)) {
            return new Nokia\NokiaE500($useragent);
        }

        if (preg_match('/NokiaE50/i', $useragent)) {
            return new Nokia\NokiaE50($useragent);
        }

        if (preg_match('/NokiaE51/i', $useragent)) {
            return new Nokia\NokiaE51($useragent);
        }

        if (preg_match('/NokiaE52/i', $useragent)) {
            return new Nokia\NokiaE52($useragent);
        }

        if (preg_match('/NokiaE55/i', $useragent)) {
            return new Nokia\NokiaE55($useragent);
        }

        if (preg_match('/NokiaE56/i', $useragent)) {
            return new Nokia\NokiaE56($useragent);
        }

        if (preg_match('/NokiaE5/i', $useragent)) {
            return new Nokia\NokiaE5($useragent);
        }

        if (preg_match('/NokiaE90/i', $useragent)) {
            return new Nokia\NokiaE90($useragent);
        }

        if (preg_match('/NokiaC7\-00/i', $useragent)) {
            return new Nokia\NokiaC700($useragent);
        }

        if (preg_match('/NokiaC7/i', $useragent)) {
            return new Nokia\NokiaC7($useragent);
        }

        if (preg_match('/NokiaC6\-00/i', $useragent)) {
            return new Nokia\NokiaC600($useragent);
        }

        if (preg_match('/NokiaC6\-01/i', $useragent)) {
            return new Nokia\NokiaC601($useragent);
        }

        if (preg_match('/NokiaC6/i', $useragent)) {
            return new Nokia\NokiaC6($useragent);
        }

        if (preg_match('/NokiaC5\-00/i', $useragent)) {
            return new Nokia\NokiaC500($useragent);
        }

        if (preg_match('/NokiaC5\-03/i', $useragent)) {
            return new Nokia\NokiaC503($useragent);
        }

        if (preg_match('/NokiaC5\-05/i', $useragent)) {
            return new Nokia\NokiaC505($useragent);
        }

        if (preg_match('/NokiaC5/i', $useragent)) {
            return new Nokia\NokiaC5($useragent);
        }

        if (preg_match('/NokiaC3\-00/i', $useragent)) {
            return new Nokia\NokiaC300($useragent);
        }

        if (preg_match('/NokiaC3\-01/i', $useragent)) {
            return new Nokia\NokiaC301($useragent);
        }

        if (preg_match('/NokiaC3/i', $useragent)) {
            return new Nokia\NokiaC3($useragent);
        }

        if (preg_match('/NokiaC2\-01/i', $useragent)) {
            return new Nokia\NokiaC201($useragent);
        }

        if (preg_match('/NokiaC2\-02/i', $useragent)) {
            return new Nokia\NokiaC202($useragent);
        }

        if (preg_match('/NokiaC2\-03/i', $useragent)) {
            return new Nokia\NokiaC203($useragent);
        }

        if (preg_match('/NokiaC2\-05/i', $useragent)) {
            return new Nokia\NokiaC205($useragent);
        }

        if (preg_match('/NokiaC2\-06/i', $useragent)) {
            return new Nokia\NokiaC206($useragent);
        }

        if (preg_match('/NokiaC2/i', $useragent)) {
            return new Nokia\NokiaC2($useragent);
        }

        if (preg_match('/NokiaC1\-01/i', $useragent)) {
            return new Nokia\NokiaC101($useragent);
        }

        if (preg_match('/NokiaC1/i', $useragent)) {
            return new Nokia\NokiaC1($useragent);
        }

        if (preg_match('/Nokia9500/i', $useragent)) {
            return new Nokia\Nokia9500($useragent);
        }

        if (preg_match('/Nokia7510/i', $useragent)) {
            return new Nokia\Nokia7510($useragent);
        }

        if (preg_match('/Nokia7230/i', $useragent)) {
            return new Nokia\Nokia7230($useragent);
        }

        if (preg_match('/Nokia6730c/i', $useragent)) {
            return new Nokia\Nokia6730c($useragent);
        }

        if (preg_match('/Nokia6720c/i', $useragent)) {
            return new Nokia\Nokia6720c($useragent);
        }

        if (preg_match('/Nokia6710s/i', $useragent)) {
            return new Nokia\Nokia6710s($useragent);
        }

        if (preg_match('/Nokia6700s/i', $useragent)) {
            return new Nokia\Nokia6700s($useragent);
        }

        if (preg_match('/Nokia6700c/i', $useragent)) {
            return new Nokia\Nokia6700c($useragent);
        }

        if (preg_match('/Nokia6630/i', $useragent)) {
            return new Nokia\Nokia6630($useragent);
        }

        if (preg_match('/Nokia6610I/i', $useragent)) {
            return new Nokia\Nokia6610i($useragent);
        }

        if (preg_match('/Nokia6555/i', $useragent)) {
            return new Nokia\Nokia6555($useragent);
        }

        if (preg_match('/Nokia6500s/i', $useragent)) {
            return new Nokia\Nokia6500s($useragent);
        }

        if (preg_match('/Nokia6500c/i', $useragent)) {
            return new Nokia\Nokia6500c($useragent);
        }

        if (preg_match('/Nokia6303iclassic/i', $useragent)) {
            return new Nokia\Nokia6303iClassic($useragent);
        }

        if (preg_match('/Nokia6303classic/i', $useragent)) {
            return new Nokia\Nokia6303Classic($useragent);
        }

        if (preg_match('/Nokia6300/i', $useragent)) {
            return new Nokia\Nokia6300($useragent);
        }

        if (preg_match('/Nokia6220c/i', $useragent)) {
            return new Nokia\Nokia6220c($useragent);
        }

        if (preg_match('/Nokia6210/i', $useragent)) {
            return new Nokia\Nokia6210($useragent);
        }

        if (preg_match('/Nokia6131/i', $useragent)) {
            return new Nokia\Nokia6131($useragent);
        }

        if (preg_match('/Nokia6120c/i', $useragent)) {
            return new Nokia\Nokia6120c($useragent);
        }

        if (preg_match('/Nokia5800d/i', $useragent)) {
            return new Nokia\Nokia5800XpressMusic($useragent);
        }

        if (preg_match('/Nokia5800/i', $useragent)) {
            return new Nokia\Nokia5800($useragent);
        }

        if (preg_match('/Nokia5530c/i', $useragent)) {
            return new Nokia\Nokia5530c($useragent);
        }

        if (preg_match('/Nokia5530/i', $useragent)) {
            return new Nokia\Nokia5530($useragent);
        }

        if (preg_match('/Nokia5330c/i', $useragent)) {
            return new Nokia\Nokia5330c($useragent);
        }

        if (preg_match('/Nokia5310/i', $useragent)) {
            return new Nokia\Nokia5310($useragent);
        }

        if (preg_match('/Nokia5250/i', $useragent)) {
            return new Nokia\Nokia5250($useragent);
        }

        if (preg_match('/Nokia5233/i', $useragent)) {
            return new Nokia\Nokia5233($useragent);
        }

        if (preg_match('/Nokia5230/i', $useragent)) {
            return new Nokia\Nokia5230($useragent);
        }

        if (preg_match('/Nokia5228/i', $useragent)) {
            return new Nokia\Nokia5228($useragent);
        }

        if (preg_match('/Nokia5220XpressMusic/i', $useragent)) {
            return new Nokia\Nokia5220XpressMusic($useragent);
        }

        if (preg_match('/5130c\-2/i', $useragent)) {
            return new Nokia\Nokia5130c2($useragent);
        }

        if (preg_match('/Nokia5130c/i', $useragent)) {
            return new Nokia\Nokia5130c($useragent);
        }

        if (preg_match('/Nokia3710/i', $useragent)) {
            return new Nokia\Nokia3710($useragent);
        }

        if (preg_match('/Nokia301\.1/i', $useragent)) {
            return new Nokia\Nokia3011($useragent);
        }

        if (preg_match('/Nokia301/i', $useragent)) {
            return new Nokia\Nokia301($useragent);
        }

        if (preg_match('/Nokia2760/i', $useragent)) {
            return new Nokia\Nokia2760($useragent);
        }

        if (preg_match('/Nokia2730c/i', $useragent)) {
            return new Nokia\Nokia2730c($useragent);
        }

        if (preg_match('/Nokia2720a/i', $useragent)) {
            return new Nokia\Nokia2720a($useragent);
        }

        if (preg_match('/Nokia2700c/i', $useragent)) {
            return new Nokia\Nokia2700c($useragent);
        }

        if (preg_match('/Nokia2630/i', $useragent)) {
            return new Nokia\Nokia2630($useragent);
        }

        if (preg_match('/Nokia2330c/i', $useragent)) {
            return new Nokia\Nokia2330c($useragent);
        }

        if (preg_match('/Nokia2323c/i', $useragent)) {
            return new Nokia\Nokia2323c($useragent);
        }

        if (preg_match('/Nokia2320c/i', $useragent)) {
            return new Nokia\Nokia2320c($useragent);
        }

        if (preg_match('/Nokia808PureView/i', $useragent)) {
            return new Nokia\Nokia808PureView($useragent);
        }

        if (preg_match('/Nokia701/i', $useragent)) {
            return new Nokia\Nokia701($useragent);
        }

        if (preg_match('/Nokia700/i', $useragent)) {
            return new Nokia\Nokia700($useragent);
        }

        if (preg_match('/Nokia603/i', $useragent)) {
            return new Nokia\Nokia603($useragent);
        }

        if (preg_match('/Nokia501/i', $useragent)) {
            return new Nokia\Nokia501($useragent);
        }

        if (preg_match('/Nokia500/i', $useragent)) {
            return new Nokia\Nokia500($useragent);
        }

        if (preg_match('/Nokia311/i', $useragent)) {
            return new Nokia\Nokia311($useragent);
        }

        if (preg_match('/Nokia309/i', $useragent)) {
            return new Nokia\Nokia309($useragent);
        }

        if (preg_match('/Nokia306/i', $useragent)) {
            return new Nokia\Nokia306($useragent);
        }

        if (preg_match('/Nokia305/i', $useragent)) {
            return new Nokia\Nokia305($useragent);
        }

        if (preg_match('/Nokia303/i', $useragent)) {
            return new Nokia\Nokia303($useragent);
        }

        if (preg_match('/Nokia302/i', $useragent)) {
            return new Nokia\Nokia302($useragent);
        }

        if (preg_match('/Nokia300/i', $useragent)) {
            return new Nokia\Nokia300($useragent);
        }

        if (preg_match('/Nokia220/i', $useragent)) {
            return new Nokia\Nokia220($useragent);
        }

        if (preg_match('/Nokia203/i', $useragent)) {
            return new Nokia\Nokia203($useragent);
        }

        if (preg_match('/Nokia201/i', $useragent)) {
            return new Nokia\Nokia201($useragent);
        }

        if (preg_match('/Nokia200/i', $useragent)) {
            return new Nokia\Nokia200($useragent);
        }

        if (preg_match('/Nokia113/i', $useragent)) {
            return new Nokia\Nokia113($useragent);
        }

        if (preg_match('/Nokia112/i', $useragent)) {
            return new Nokia\Nokia112($useragent);
        }

        if (preg_match('/Nokia110/i', $useragent)) {
            return new Nokia\Nokia110($useragent);
        }

        if (preg_match('/Nokia109/i', $useragent)) {
            return new Nokia\Nokia109($useragent);
        }

        return new Nokia\Nokia($useragent);
    }
}
