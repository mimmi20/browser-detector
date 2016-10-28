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
use BrowserDetector\Detector\Factory\DeviceFactory;
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
        if (preg_match('/genm14/i', $useragent)) {
            $deviceCode = 'xl2';
        }

        if (preg_match('/nokia_xl/i', $useragent)) {
            $deviceCode = 'xl';
        }

        if (preg_match('/(lumia 650|id336)/i', $useragent)) {
            $deviceCode = 'lumia 650';
        }

        if (preg_match('/lumia 510/i', $useragent)) {
            $deviceCode = 'lumia 510';
        }

        if (preg_match('/(rm\-1113|lumia 640 lte)/i', $useragent)) {
            $deviceCode = 'rm-1113';
        }

        if (preg_match('/rm\-1090/i', $useragent)) {
            $deviceCode = 'rm-1090';
        }

        if (preg_match('/rm\-1089/i', $useragent)) {
            $deviceCode = 'rm-1089';
        }

        if (preg_match('/rm\-1072/i', $useragent)) {
            $deviceCode = 'rm-1072';
        }

        if (preg_match('/rm\-1073/i', $useragent)) {
            $deviceCode = 'rm-1073';
        }

        if (preg_match('/rm\-1074/i', $useragent)) {
            $deviceCode = 'rm-1074';
        }

        if (preg_match('/rm\-1076/i', $useragent)) {
            $deviceCode = 'rm-1076';
        }

        if (preg_match('/rm\-1077/i', $useragent)) {
            $deviceCode = 'rm-1077';
        }

        if (preg_match('/(rm\-1075|lumia 640 dual sim)/i', $useragent)) {
            $deviceCode = 'rm-1075';
        }

        if (preg_match('/rm\-1062/i', $useragent)) {
            $deviceCode = 'rm-1062';
        }

        if (preg_match('/rm\-1063/i', $useragent)) {
            $deviceCode = 'rm-1063';
        }

        if (preg_match('/rm\-1064/i', $useragent)) {
            $deviceCode = 'rm-1064';
        }

        if (preg_match('/rm\-1065/i', $useragent)) {
            $deviceCode = 'rm-1065';
        }

        if (preg_match('/rm\-1066/i', $useragent)) {
            $deviceCode = 'rm-1066';
        }

        if (preg_match('/rm\-1067/i', $useragent)) {
            $deviceCode = 'rm-1067';
        }

        if (preg_match('/rm\-1045/i', $useragent)) {
            $deviceCode = 'rm-1045';
        }

        if (preg_match('/rm\-1038/i', $useragent)) {
            $deviceCode = 'rm-1038';
        }

        if (preg_match('/(rm\-1031|lumia 532)/i', $useragent)) {
            $deviceCode = 'rm-1031';
        }

        if (preg_match('/rm\-1010/i', $useragent)) {
            $deviceCode = 'rm-1010';
        }

        if (preg_match('/rm\-994/i', $useragent)) {
            $deviceCode = 'rm-994';
        }

        if (preg_match('/rm\-978/i', $useragent)) {
            $deviceCode = 'rm-978';
        }

        if (preg_match('/rm\-976/i', $useragent)) {
            $deviceCode = 'rm-976';
        }

        if (preg_match('/rm\-974/i', $useragent)) {
            $deviceCode = 'rm-974';
        }

        if (preg_match('/rm\-914/i', $useragent)) {
            $deviceCode = 'lumia 520 rm-914';
        }

        if (preg_match('/rm\-846/i', $useragent)) {
            $deviceCode = 'rm-846';
        }

        if (preg_match('/rm\-997/i', $useragent)) {
            $deviceCode = 'rm-997';
        }

        if (preg_match('/lumia 521/i', $useragent)) {
            $deviceCode = 'lumia 521';
        }

        if (preg_match('/lumia 520/i', $useragent)) {
            $deviceCode = 'lumia 520';
        }

        if (preg_match('/lumia 530/i', $useragent)) {
            $deviceCode = 'lumia 530';
        }

        if (preg_match('/lumia 535/i', $useragent)) {
            $deviceCode = 'lumia 535';
        }

        if (preg_match('/lumia 540/i', $useragent)) {
            $deviceCode = 'lumia 540';
        }

        if (preg_match('/lumia 550/i', $useragent)) {
            $deviceCode = 'lumia 550';
        }

        if (preg_match('/lumia 610/i', $useragent)) {
            $deviceCode = 'lumia 610';
        }

        if (preg_match('/lumia 620/i', $useragent)) {
            $deviceCode = 'lumia 620';
        }

        if (preg_match('/lumia 625/i', $useragent)) {
            $deviceCode = 'lumia 625';
        }

        if (preg_match('/lumia 630/i', $useragent)) {
            $deviceCode = 'lumia 630';
        }

        if (preg_match('/lumia 635/i', $useragent)) {
            $deviceCode = 'lumia 635';
        }

        if (preg_match('/lumia 640 xl/i', $useragent)) {
            $deviceCode = 'lumia 640 xl';
        }

        if (preg_match('/lumia 640/i', $useragent)) {
            $deviceCode = 'lumia 640';
        }

        if (preg_match('/lumia 710/i', $useragent)) {
            $deviceCode = 'lumia 710';
        }

        if (preg_match('/lumia 720/i', $useragent)) {
            $deviceCode = 'lumia 720';
        }

        if (preg_match('/lumia 730/i', $useragent)) {
            $deviceCode = 'lumia 730';
        }

        if (preg_match('/lumia 735/i', $useragent)) {
            $deviceCode = 'lumia 735';
        }

        if (preg_match('/lumia 800/i', $useragent)) {
            $deviceCode = 'lumia 800';
        }

        if (preg_match('/lumia 820/i', $useragent)) {
            $deviceCode = 'lumia 820';
        }

        if (preg_match('/lumia 830/i', $useragent)) {
            $deviceCode = 'lumia 830';
        }

        if (preg_match('/lumia 900/i', $useragent)) {
            $deviceCode = 'lumia 900';
        }

        if (preg_match('/lumia 920/i', $useragent)) {
            $deviceCode = 'lumia 920';
        }

        if (preg_match('/(lumia|nokia) 925/i', $useragent)) {
            $deviceCode = 'lumia 925';
        }

        if (preg_match('/lumia 928/i', $useragent)) {
            $deviceCode = 'lumia 928';
        }

        if (preg_match('/lumia 930/i', $useragent)) {
            $deviceCode = 'lumia 930';
        }

        if (preg_match('/lumia 950 xl/i', $useragent)) {
            $deviceCode = 'lumia 950 xl';
        }

        if (preg_match('/lumia 950/i', $useragent)) {
            $deviceCode = 'lumia 950';
        }

        if (preg_match('/(lumia 1020|nokia; 909|arm; 909)/i', $useragent)) {
            $deviceCode = 'lumia 1020';
        }

        if (preg_match('/lumia 1320/i', $useragent)) {
            $deviceCode = 'lumia 1320';
        }

        if (preg_match('/lumia 1520/i', $useragent)) {
            $deviceCode = 'lumia 1520';
        }

        if (preg_match('/lumia 435/i', $useragent)) {
            $deviceCode = 'lumia 435';
        }

        if (preg_match('/lumia/i', $useragent)) {
            $deviceCode = 'lumia';
        }

        if (preg_match('/ N1 /', $useragent)) {
            $deviceCode = 'n1';
        }

        if (preg_match('/nokian81/i', $useragent)) {
            $deviceCode = 'n81';
        }

        if (preg_match('/nokian82/i', $useragent)) {
            $deviceCode = 'n82';
        }

        if (preg_match('/nokian85/i', $useragent)) {
            $deviceCode = 'n85';
        }

        if (preg_match('/nokian86/i', $useragent)) {
            $deviceCode = 'n86';
        }

        if (preg_match('/nokian8\-00/i', $useragent)) {
            $deviceCode = 'n8-00';
        }

        if (preg_match('/nokian8/i', $useragent)) {
            $deviceCode = 'n8';
        }

        if (preg_match('/nokian90/i', $useragent)) {
            $deviceCode = 'n90';
        }

        if (preg_match('/nokian91/i', $useragent)) {
            $deviceCode = 'n91';
        }

        if (preg_match('/nokian95/i', $useragent)) {
            $deviceCode = 'n95';
        }

        if (preg_match('/nokian96/i', $useragent)) {
            $deviceCode = 'n96';
        }

        if (preg_match('/nokian97/i', $useragent)) {
            $deviceCode = 'n97';
        }

        if (preg_match('/nokian900/i', $useragent)) {
            $deviceCode = 'n900';
        }

        if (preg_match('/nokian9/i', $useragent)) {
            $deviceCode = 'n9';
        }

        if (preg_match('/nokia ?n70/i', $useragent)) {
            $deviceCode = 'n70';
        }

        if (preg_match('/nokia n78/i', $useragent)) {
            $deviceCode = 'n78';
        }

        if (preg_match('/nokia ?n79/i', $useragent)) {
            $deviceCode = 'n79';
        }

        if (preg_match('/NokiaX2DS/i', $useragent)) {
            $deviceCode = 'x2ds';
        }

        if (preg_match('/NokiaX2\-00/i', $useragent)) {
            $deviceCode = 'x2-00';
        }

        if (preg_match('/NokiaX2\-01/i', $useragent)) {
            $deviceCode = 'x2-01';
        }

        if (preg_match('/NokiaX2\-02/i', $useragent)) {
            $deviceCode = 'x2-02';
        }

        if (preg_match('/NokiaX2\-05/i', $useragent)) {
            $deviceCode = 'x2-05';
        }

        if (preg_match('/NokiaX2/i', $useragent)) {
            $deviceCode = 'x2';
        }

        if (preg_match('/NokiaX3\-02/i', $useragent)) {
            $deviceCode = 'x3-02';
        }

        if (preg_match('/NokiaX3\-00/i', $useragent)) {
            $deviceCode = 'x3-00';
        }

        if (preg_match('/NokiaX3/i', $useragent)) {
            $deviceCode = 'x3';
        }

        if (preg_match('/NokiaX6\-00/i', $useragent)) {
            $deviceCode = 'x6-00';
        }

        if (preg_match('/NokiaX6/i', $useragent)) {
            $deviceCode = 'x6';
        }

        if (preg_match('/NokiaX7\-00/i', $useragent)) {
            $deviceCode = 'x7-00';
        }

        if (preg_match('/NokiaX7/i', $useragent)) {
            $deviceCode = 'x7';
        }

        if (preg_match('/NokiaE7\-00/i', $useragent)) {
            $deviceCode = 'e7-00';
        }

        if (preg_match('/NokiaE71\-1/i', $useragent)) {
            $deviceCode = 'e71-1';
        }

        if (preg_match('/NokiaE71/i', $useragent)) {
            $deviceCode = 'e71';
        }

        if (preg_match('/NokiaE72/i', $useragent)) {
            $deviceCode = 'e72';
        }

        if (preg_match('/NokiaE75/i', $useragent)) {
            $deviceCode = 'e75';
        }

        if (preg_match('/NokiaE7/i', $useragent)) {
            $deviceCode = 'e7';
        }

        if (preg_match('/NokiaE6\-00/i', $useragent)) {
            $deviceCode = 'e6-00';
        }

        if (preg_match('/NokiaE62/i', $useragent)) {
            $deviceCode = 'e62';
        }

        if (preg_match('/NokiaE63/i', $useragent)) {
            $deviceCode = 'e63';
        }

        if (preg_match('/NokiaE66/i', $useragent)) {
            $deviceCode = 'e66';
        }

        if (preg_match('/NokiaE6/i', $useragent)) {
            $deviceCode = 'e6';
        }

        if (preg_match('/NokiaE5\-00/i', $useragent)) {
            $deviceCode = 'e5-00';
        }

        if (preg_match('/NokiaE50/i', $useragent)) {
            $deviceCode = 'e50';
        }

        if (preg_match('/NokiaE51/i', $useragent)) {
            $deviceCode = 'e51';
        }

        if (preg_match('/NokiaE52/i', $useragent)) {
            $deviceCode = 'e52';
        }

        if (preg_match('/NokiaE55/i', $useragent)) {
            $deviceCode = 'e55';
        }

        if (preg_match('/NokiaE56/i', $useragent)) {
            $deviceCode = 'e56';
        }

        if (preg_match('/NokiaE5/i', $useragent)) {
            $deviceCode = 'e5';
        }

        if (preg_match('/NokiaE90/i', $useragent)) {
            $deviceCode = 'e90';
        }

        if (preg_match('/NokiaC7\-00/i', $useragent)) {
            $deviceCode = 'c7-00';
        }

        if (preg_match('/NokiaC7/i', $useragent)) {
            $deviceCode = 'nokia c7';
        }

        if (preg_match('/NokiaC6\-00/i', $useragent)) {
            $deviceCode = 'c6-00';
        }

        if (preg_match('/NokiaC6\-01/i', $useragent)) {
            $deviceCode = 'c6-01';
        }

        if (preg_match('/NokiaC6/i', $useragent)) {
            $deviceCode = 'c6';
        }

        if (preg_match('/NokiaC5\-00/i', $useragent)) {
            $deviceCode = 'c5-00';
        }

        if (preg_match('/NokiaC5\-03/i', $useragent)) {
            $deviceCode = 'c5-03';
        }

        if (preg_match('/NokiaC5\-05/i', $useragent)) {
            $deviceCode = 'c5-05';
        }

        if (preg_match('/NokiaC5/i', $useragent)) {
            $deviceCode = 'c5';
        }

        if (preg_match('/NokiaC3\-00/i', $useragent)) {
            $deviceCode = 'c3-00';
        }

        if (preg_match('/NokiaC3\-01/i', $useragent)) {
            $deviceCode = 'c3-01';
        }

        if (preg_match('/NokiaC3/i', $useragent)) {
            $deviceCode = 'c3';
        }

        if (preg_match('/NokiaC2\-01/i', $useragent)) {
            $deviceCode = 'c2-01';
        }

        if (preg_match('/NokiaC2\-02/i', $useragent)) {
            $deviceCode = 'c2-02';
        }

        if (preg_match('/NokiaC2\-03/i', $useragent)) {
            $deviceCode = 'c2-03';
        }

        if (preg_match('/NokiaC2\-05/i', $useragent)) {
            $deviceCode = 'c2-05';
        }

        if (preg_match('/NokiaC2\-06/i', $useragent)) {
            $deviceCode = 'c2-06';
        }

        if (preg_match('/NokiaC2/i', $useragent)) {
            $deviceCode = 'nokia c2';
        }

        if (preg_match('/NokiaC1\-01/i', $useragent)) {
            $deviceCode = 'c1-01';
        }

        if (preg_match('/NokiaC1/i', $useragent)) {
            $deviceCode = 'c1';
        }

        if (preg_match('/Nokia9500/i', $useragent)) {
            $deviceCode = '9500';
        }

        if (preg_match('/Nokia7510/i', $useragent)) {
            $deviceCode = '7510';
        }

        if (preg_match('/Nokia7230/i', $useragent)) {
            $deviceCode = '7230';
        }

        if (preg_match('/Nokia6730c/i', $useragent)) {
            $deviceCode = '6730 classic';
        }

        if (preg_match('/Nokia6720c/i', $useragent)) {
            $deviceCode = '6720 classic';
        }

        if (preg_match('/Nokia6710s/i', $useragent)) {
            $deviceCode = '6710 slide';
        }

        if (preg_match('/Nokia6700s/i', $useragent)) {
            $deviceCode = '6700s';
        }

        if (preg_match('/Nokia6700c/i', $useragent)) {
            $deviceCode = '6700 classic';
        }

        if (preg_match('/Nokia6630/i', $useragent)) {
            $deviceCode = '6630';
        }

        if (preg_match('/Nokia6610I/i', $useragent)) {
            $deviceCode = '6610i';
        }

        if (preg_match('/Nokia6555/i', $useragent)) {
            $deviceCode = '6555';
        }

        if (preg_match('/Nokia6500s/i', $useragent)) {
            $deviceCode = '6500 slide';
        }

        if (preg_match('/Nokia6500c/i', $useragent)) {
            $deviceCode = '6500 classic';
        }

        if (preg_match('/Nokia6303iclassic/i', $useragent)) {
            $deviceCode = '6303i classic';
        }

        if (preg_match('/Nokia6303classic/i', $useragent)) {
            $deviceCode = '6303 classic';
        }

        if (preg_match('/Nokia6300/i', $useragent)) {
            $deviceCode = '6300';
        }

        if (preg_match('/Nokia6220c/i', $useragent)) {
            $deviceCode = '6220 classic';
        }

        if (preg_match('/Nokia6210/i', $useragent)) {
            $deviceCode = '6210';
        }

        if (preg_match('/Nokia6131/i', $useragent)) {
            $deviceCode = '6131';
        }

        if (preg_match('/Nokia6120c/i', $useragent)) {
            $deviceCode = '6120c';
        }

        if (preg_match('/Nokia5800d/i', $useragent)) {
            $deviceCode = '5800 xpressmusic';
        }

        if (preg_match('/Nokia5800/i', $useragent)) {
            $deviceCode = '5800';
        }

        if (preg_match('/Nokia5530c/i', $useragent)) {
            $deviceCode = 'nokia 5530 classic';
        }

        if (preg_match('/Nokia5530/i', $useragent)) {
            $deviceCode = 'nokia 5530 classic';
        }

        if (preg_match('/Nokia5330c/i', $useragent)) {
            $deviceCode = '5330 classic';
        }

        if (preg_match('/Nokia5310/i', $useragent)) {
            $deviceCode = '5310 xpressmusic';
        }

        if (preg_match('/Nokia5250/i', $useragent)) {
            $deviceCode = '5250';
        }

        if (preg_match('/Nokia5233/i', $useragent)) {
            $deviceCode = '5233';
        }

        if (preg_match('/Nokia5230/i', $useragent)) {
            $deviceCode = '5230';
        }

        if (preg_match('/Nokia5228/i', $useragent)) {
            $deviceCode = '5228';
        }

        if (preg_match('/Nokia5220XpressMusic/i', $useragent)) {
            $deviceCode = '5220 xpressmusic';
        }

        if (preg_match('/5130c\-2/i', $useragent)) {
            $deviceCode = '5130c-2';
        }

        if (preg_match('/Nokia5130c/i', $useragent)) {
            $deviceCode = '5130 classic';
        }

        if (preg_match('/Nokia3710/i', $useragent)) {
            $deviceCode = '3710';
        }

        if (preg_match('/Nokia301\.1/i', $useragent)) {
            $deviceCode = '301.1';
        }

        if (preg_match('/Nokia301/i', $useragent)) {
            $deviceCode = '301';
        }

        if (preg_match('/Nokia2760/i', $useragent)) {
            $deviceCode = '2760';
        }

        if (preg_match('/Nokia2730c/i', $useragent)) {
            $deviceCode = '2730 classic';
        }

        if (preg_match('/Nokia2720a/i', $useragent)) {
            $deviceCode = '2720a';
        }

        if (preg_match('/Nokia2700c/i', $useragent)) {
            $deviceCode = '2700 classic';
        }

        if (preg_match('/nokia2630/i', $useragent)) {
            $deviceCode = '2630';
        }

        if (preg_match('/nokia2330c/i', $useragent)) {
            $deviceCode = '2330 classic';
        }

        if (preg_match('/nokia2323c/i', $useragent)) {
            $deviceCode = '2323c';
        }

        if (preg_match('/nokia2320c/i', $useragent)) {
            $deviceCode = '2320c';
        }

        if (preg_match('/nokia808pureview/i', $useragent)) {
            $deviceCode = '808 pureview';
        }

        if (preg_match('/nokia701/i', $useragent)) {
            $deviceCode = '701';
        }

        if (preg_match('/nokia700/i', $useragent)) {
            $deviceCode = '700';
        }

        if (preg_match('/nokia603/i', $useragent)) {
            $deviceCode = '603';
        }

        if (preg_match('/nokia515/i', $useragent)) {
            $deviceCode = '515';
        }

        if (preg_match('/nokia501/i', $useragent)) {
            $deviceCode = '501';
        }

        if (preg_match('/(nokia500|nokiaasha500)/i', $useragent)) {
            $deviceCode = '500';
        }

        if (preg_match('/nokia311/i', $useragent)) {
            $deviceCode = '311';
        }

        if (preg_match('/nokia309/i', $useragent)) {
            $deviceCode = '309';
        }

        if (preg_match('/nokia308/i', $useragent)) {
            $deviceCode = '308';
        }

        if (preg_match('/nokia306/i', $useragent)) {
            $deviceCode = '306';
        }

        if (preg_match('/nokia305/i', $useragent)) {
            $deviceCode = '305';
        }

        if (preg_match('/nokia303/i', $useragent)) {
            $deviceCode = '303';
        }

        if (preg_match('/nokia302/i', $useragent)) {
            $deviceCode = '302';
        }

        if (preg_match('/nokia300/i', $useragent)) {
            $deviceCode = '300';
        }

        if (preg_match('/nokia220/i', $useragent)) {
            $deviceCode = '220';
        }

        if (preg_match('/nokia210/i', $useragent)) {
            $deviceCode = '210';
        }

        if (preg_match('/nokia206/i', $useragent)) {
            $deviceCode = '206';
        }

        if (preg_match('/nokia205/i', $useragent)) {
            $deviceCode = '205';
        }

        if (preg_match('/nokia203/i', $useragent)) {
            $deviceCode = '203';
        }

        if (preg_match('/nokia201/i', $useragent)) {
            $deviceCode = '201';
        }

        if (preg_match('/nokia200/i', $useragent)) {
            $deviceCode = '200';
        }

        if (preg_match('/nokia113/i', $useragent)) {
            $deviceCode = '113';
        }

        if (preg_match('/nokia112/i', $useragent)) {
            $deviceCode = '112';
        }

        if (preg_match('/nokia110/i', $useragent)) {
            $deviceCode = '110';
        }

        if (preg_match('/nokia109/i', $useragent)) {
            $deviceCode = '109';
        }

        $deviceCode = 'general nokia device';

        return DeviceFactory::get($deviceCode, $useragent);
    }
}
