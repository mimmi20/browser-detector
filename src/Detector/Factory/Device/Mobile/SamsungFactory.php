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

use BrowserDetector\Detector\Device\Mobile\Samsung;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class SamsungFactory implements FactoryInterface
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
        if (preg_match('/SM\-T2105/i', $useragent)) {
            return new Samsung\SamsungSmT2105($useragent, []);
        }

        if (preg_match('/SM\-T900/i', $useragent)) {
            return new Samsung\SamsungSmT900($useragent, []);
        }

        if (preg_match('/SM\-T805/i', $useragent)) {
            return new Samsung\SamsungSmT805($useragent, []);
        }

        if (preg_match('/SM\-T800/i', $useragent)) {
            return new Samsung\SamsungSmT800($useragent, []);
        }

        if (preg_match('/SM\-T705M/i', $useragent)) {
            return new Samsung\SamsungSmT705m($useragent, []);
        }

        if (preg_match('/SM\-T705/i', $useragent)) {
            return new Samsung\SamsungSmT705($useragent, []);
        }

        if (preg_match('/SM\-T700/i', $useragent)) {
            return new Samsung\SamsungSmT700($useragent, []);
        }

        if (preg_match('/SM\-T535/i', $useragent)) {
            return new Samsung\SamsungSmT535($useragent, []);
        }

        if (preg_match('/(SM\-T531|SM \- T531)/i', $useragent)) {
            return new Samsung\SamsungSmT531($useragent, []);
        }

        if (preg_match('/SM\-T530NU/i', $useragent)) {
            return new Samsung\SamsungSmT530nu($useragent, []);
        }

        if (preg_match('/SM\-T530/i', $useragent)) {
            return new Samsung\SamsungSmT530($useragent, []);
        }

        if (preg_match('/SM\-T525/i', $useragent)) {
            return new Samsung\SamsungSmT525($useragent, []);
        }

        if (preg_match('/SM\-T520/i', $useragent)) {
            return new Samsung\SamsungSmT520($useragent, []);
        }

        if (preg_match('/SM\-T365/i', $useragent)) {
            return new Samsung\SamsungSmT365($useragent, []);
        }

        if (preg_match('/SM\-T335/i', $useragent)) {
            return new Samsung\SamsungSmT335($useragent, []);
        }

        if (preg_match('/SM\-T331/i', $useragent)) {
            return new Samsung\SamsungSmT331($useragent, []);
        }

        if (preg_match('/SM\-T325/i', $useragent)) {
            return new Samsung\SamsungSmT325($useragent, []);
        }

        if (preg_match('/SM\-T320/i', $useragent)) {
            return new Samsung\SamsungSmT320($useragent, []);
        }

        if (preg_match('/SM\-T315/i', $useragent)) {
            return new Samsung\SamsungSmT315($useragent, []);
        }

        if (preg_match('/SM\-T311/i', $useragent)) {
            return new Samsung\SamsungSmT311($useragent, []);
        }

        if (preg_match('/SM\-T310/i', $useragent)) {
            return new Samsung\SamsungSmT310($useragent, []);
        }

        if (preg_match('/SM\-T235/i', $useragent)) {
            return new Samsung\SamsungSmT235($useragent, []);
        }

        if (preg_match('/SM\-T230NU/i', $useragent)) {
            return new Samsung\SamsungSmT230nu($useragent, []);
        }

        if (preg_match('/SM\-T230/i', $useragent)) {
            return new Samsung\SamsungSmT230($useragent, []);
        }

        if (preg_match('/SM\-T211/i', $useragent)) {
            return new Samsung\SamsungSmT211($useragent, []);
        }

        if (preg_match('/SM\-T210/i', $useragent)) {
            return new Samsung\SamsungSmT210($useragent, []);
        }

        if (preg_match('/SM\-T111/i', $useragent)) {
            return new Samsung\SamsungSmT111($useragent, []);
        }

        if (preg_match('/SM\-T110/i', $useragent)) {
            return new Samsung\SamsungSmT110($useragent, []);
        }

        if (preg_match('/SM\-P905/i', $useragent)) {
            return new Samsung\SamsungSmP905($useragent, []);
        }

        if (preg_match('/SM\-P900/i', $useragent)) {
            return new Samsung\SamsungSmP900($useragent, []);
        }

        if (preg_match('/SM\-P605/i', $useragent)) {
            return new Samsung\SamsungSmP605($useragent, []);
        }

        if (preg_match('/SM\-P601/i', $useragent)) {
            return new Samsung\SamsungSmP601($useragent, []);
        }

        if (preg_match('/SM\-P600/i', $useragent)) {
            return new Samsung\SamsungSmP600($useragent, []);
        }

        if (preg_match('/SM\-N9008V/i', $useragent)) {
            return new Samsung\SamsungSmN9008V($useragent, []);
        }

        if (preg_match('/(SM\-N9005|N9005)/i', $useragent)) {
            return new Samsung\SamsungSmN9005($useragent, []);
        }

        if (preg_match('/SM\-N8000/i', $useragent)) {
            return new Samsung\SamsungSmN8000($useragent, []);
        }

        if (preg_match('/SM\-N7505/i', $useragent)) {
            return new Samsung\SamsungSmN7505($useragent, []);
        }

        if (preg_match('/SM\-N915FY/i', $useragent)) {
            return new Samsung\SamsungSmN915fy($useragent, []);
        }

        if (preg_match('/SM\-N910V/i', $useragent)) {
            return new Samsung\SamsungSmN910V($useragent, []);
        }

        if (preg_match('/SM\-N910F/i', $useragent)) {
            return new Samsung\SamsungSmN910F($useragent, []);
        }

        if (preg_match('/SM\-N910C/i', $useragent)) {
            return new Samsung\SamsungSmN910C($useragent, []);
        }

        if (preg_match('/SM\-N900V/i', $useragent)) {
            return new Samsung\SamsungSmN900V($useragent, []);
        }

        if (preg_match('/SM\-N900A/i', $useragent)) {
            return new Samsung\SamsungSmN900A($useragent, []);
        }

        if (preg_match('/SM\-N900/i', $useragent)) {
            return new Samsung\SamsungSmN900($useragent, []);
        }

        if (preg_match('/SM\-G3502L/i', $useragent)) {
            return new Samsung\SamsungSmG3502l($useragent, []);
        }

        if (preg_match('/SM\-G901F/i', $useragent)) {
            return new Samsung\SamsungSmG901F($useragent, []);
        }

        if (preg_match('/SM\-G900W8/i', $useragent)) {
            return new Samsung\SamsungSmG900w8($useragent, []);
        }

        if (preg_match('/SM\-G900V/i', $useragent)) {
            return new Samsung\SamsungSmG900V($useragent, []);
        }

        if (preg_match('/SM\-G900T/i', $useragent)) {
            return new Samsung\SamsungSmG900T($useragent, []);
        }

        if (preg_match('/SM\-G900I/i', $useragent)) {
            return new Samsung\SamsungSmG900i($useragent, []);
        }

        if (preg_match('/SM\-G900F/i', $useragent)) {
            return new Samsung\SamsungSmG900F($useragent, []);
        }

        if (preg_match('/SM\-G900A/i', $useragent)) {
            return new Samsung\SamsungSmG900a($useragent, []);
        }

        if (preg_match('/SM\-G870F/i', $useragent)) {
            return new Samsung\SamsungSmG870F($useragent, []);
        }

        if (preg_match('/SM\-G850F/i', $useragent)) {
            return new Samsung\SamsungSmG850F($useragent, []);
        }

        if (preg_match('/SM\-G800H/i', $useragent)) {
            return new Samsung\SamsungSmG800h($useragent, []);
        }

        if (preg_match('/SM\-G800F/i', $useragent)) {
            return new Samsung\SamsungSmG800F($useragent, []);
        }

        if (preg_match('/SM\-G350/i', $useragent)) {
            return new Samsung\SamsungSmG350($useragent, []);
        }

        if (preg_match('/SM\-G310HN/i', $useragent)) {
            return new Samsung\SamsungSmG310hn($useragent, []);
        }

        if (preg_match('/SM\-C105/i', $useragent)) {
            return new Samsung\SamsungSmC105($useragent, []);
        }

        if (preg_match('/SM\-C101/i', $useragent)) {
            return new Samsung\SamsungSmC101($useragent, []);
        }

        if (preg_match('/SGH\-T989/i', $useragent)) {
            return new Samsung\SamsungSghT989($useragent, []);
        }

        if (preg_match('/SGH\-T959/i', $useragent)) {
            return new Samsung\SamsungSghT959($useragent, []);
        }

        if (preg_match('/SGH\-T889/i', $useragent)) {
            return new Samsung\SamsungSghT889($useragent, []);
        }

        if (preg_match('/SGH\-T839/i', $useragent)) {
            return new Samsung\SamsungSghT839($useragent, []);
        }

        if (preg_match('/(SGH\-T769|blaze)/i', $useragent)) {
            return new Samsung\SamsungSghT769($useragent, []);
        }

        if (preg_match('/SGH\-T759/i', $useragent)) {
            return new Samsung\SamsungSghT759($useragent, []);
        }

        if (preg_match('/SGH\-T669/i', $useragent)) {
            return new Samsung\SamsungSghT669($useragent, []);
        }

        if (preg_match('/SGH\-T528g/i', $useragent)) {
            return new Samsung\SamsungSghT528g($useragent, []);
        }

        if (preg_match('/SGH\-T499/i', $useragent)) {
            return new Samsung\SamsungSghT499($useragent, []);
        }

        if (preg_match('/SGH\-M919/i', $useragent)) {
            return new Samsung\SamsungSghm919($useragent, []);
        }

        if (preg_match('/SGH\-i997R/i', $useragent)) {
            return new Samsung\SamsungSghi997r($useragent, []);
        }

        if (preg_match('/SGH\-i997/i', $useragent)) {
            return new Samsung\SamsungSghi997($useragent, []);
        }

        if (preg_match('/SGH\-I957R/i', $useragent)) {
            return new Samsung\SamsungSghi957r($useragent, []);
        }

        if (preg_match('/SGH\-i957/i', $useragent)) {
            return new Samsung\SamsungSghi957($useragent, []);
        }

        if (preg_match('/SGH\-i917/i', $useragent)) {
            return new Samsung\SamsungSghi917($useragent, []);
        }

        if (preg_match('/SGH-i900V/i', $useragent)) {
            return new Samsung\SamsungSghi900V($useragent, []);
        }

        if (preg_match('/SGH\-i900/i', $useragent)) {
            return new Samsung\SamsungSghi900($useragent, []);
        }

        if (preg_match('/SGH\-I897/i', $useragent)) {
            return new Samsung\SamsungSghi897($useragent, []);
        }

        if (preg_match('/SGH\-I857/i', $useragent)) {
            return new Samsung\SamsungSghi857($useragent, []);
        }

        if (preg_match('/SGH\-i780/i', $useragent)) {
            return new Samsung\SamsungSghi780($useragent, []);
        }

        if (preg_match('/SGH\-I777/i', $useragent)) {
            return new Samsung\SamsungSghi777($useragent, []);
        }

        if (preg_match('/SGH\-I747M/i', $useragent)) {
            return new Samsung\SamsungSghi747m($useragent, []);
        }

        if (preg_match('/SGH\-I747/i', $useragent)) {
            return new Samsung\SamsungSghi747($useragent, []);
        }

        if (preg_match('/SGH\-I727/i', $useragent)) {
            return new Samsung\SamsungSghi727($useragent, []);
        }

        if (preg_match('/SGH\-I577/i', $useragent)) {
            return new Samsung\SamsungSghi577($useragent, []);
        }

        if (preg_match('/SGH\-I547/i', $useragent)) {
            return new Samsung\SamsungSghi547($useragent, []);
        }

        if (preg_match('/SGH\-I497/i', $useragent)) {
            return new Samsung\SamsungSghi497($useragent, []);
        }

        if (preg_match('/SGH\-I337M/i', $useragent)) {
            return new Samsung\SamsungSghi337m($useragent, []);
        }

        if (preg_match('/SGH\-I337/i', $useragent)) {
            return new Samsung\SamsungSghi337($useragent, []);
        }

        if (preg_match('/SGH\-F480i/i', $useragent)) {
            return new Samsung\SamsungSghF480i($useragent, []);
        }

        if (preg_match('/SGH\-F480/i', $useragent)) {
            return new Samsung\SamsungSghF480($useragent, []);
        }

        if (preg_match('/SGH\-E250i/i', $useragent)) {
            return new Samsung\SamsungSghE250i($useragent, []);
        }

        if (preg_match('/SGH\-E250/i', $useragent)) {
            return new Samsung\SamsungSghE250($useragent, []);
        }

        if (preg_match('/(SGH\-B100|SEC\-SGHB100)/i', $useragent)) {
            return new Samsung\SamsungSghB100($useragent, []);
        }

        if (preg_match('/SEC\-SGHU600B/i', $useragent)) {
            return new Samsung\SamsungSghu600b($useragent, []);
        }

        if (preg_match('/SGH\-U800/i', $useragent)) {
            return new Samsung\SamsungSghU800($useragent, []);
        }

        if (preg_match('/SHV\-E210L/i', $useragent)) {
            return new Samsung\SamsungShvE210l($useragent, []);
        }

        if (preg_match('/SHW\-M110S/i', $useragent)) {
            return new Samsung\SamsungShwM110s($useragent, []);
        }

        if (preg_match('/SHW\-M180S/i', $useragent)) {
            return new Samsung\SamsungShwM180s($useragent, []);
        }

        if (preg_match('/SHW\-M380S/i', $useragent)) {
            return new Samsung\SamsungShwM380s($useragent, []);
        }

        if (preg_match('/SHW\-M380W/i', $useragent)) {
            return new Samsung\SamsungShwM380w($useragent, []);
        }

        if (preg_match('/SHW\-M930BST/i', $useragent)) {
            return new Samsung\SamsungShwM930bst($useragent, []);
        }

        if (preg_match('/SCL24/i', $useragent)) {
            return new Samsung\SamsungScl24($useragent, []);
        }

        if (preg_match('/SCH\-U820/i', $useragent)) {
            return new Samsung\SamsungSchU820($useragent, []);
        }

        if (preg_match('/SCH\-U750/i', $useragent)) {
            return new Samsung\SamsungSchU750($useragent, []);
        }

        if (preg_match('/SCH\-U660/i', $useragent)) {
            return new Samsung\SamsungSchU660($useragent, []);
        }

        if (preg_match('/SCH\-U485/i', $useragent)) {
            return new Samsung\SamsungSchU485($useragent, []);
        }

        if (preg_match('/SCH\-R530U/i', $useragent)) {
            return new Samsung\SamsungSchR530u($useragent, []);
        }

        if (preg_match('/SCH\-M828C/i', $useragent)) {
            return new Samsung\SamsungSchM828c($useragent, []);
        }

        if (preg_match('/SCH\-I535/i', $useragent)) {
            return new Samsung\SamsungSchI5354G($useragent, []);
        }

        if (preg_match('/SCH\-i919/i', $useragent)) {
            return new Samsung\SamsungSchI919($useragent, []);
        }

        if (preg_match('/SCH\-I800/i', $useragent)) {
            return new Samsung\SamsungSchI800($useragent, []);
        }

        if (preg_match('/SCH\-I699/i', $useragent)) {
            return new Samsung\SamsungSchI699($useragent, []);
        }

        if (preg_match('/SCH\-I605/i', $useragent)) {
            return new Samsung\SamsungSchI605($useragent, []);
        }

        if (preg_match('/SCH\-I545/i', $useragent)) {
            return new Samsung\SamsungSchI545($useragent, []);
        }

        if (preg_match('/SCH\-I510/i', $useragent)) {
            return new Samsung\SamsungSchI510($useragent, []);
        }

        if (preg_match('/SCH\-I500/i', $useragent)) {
            return new Samsung\SamsungSchI500($useragent, []);
        }

        if (preg_match('/SCH\-I400/i', $useragent)) {
            return new Samsung\SamsungSchI400($useragent, []);
        }

        if (preg_match('/SCH\-I200/i', $useragent)) {
            return new Samsung\SamsungSchI200($useragent, []);
        }

        if (preg_match('/SCH\-R720/i', $useragent)) {
            return new Samsung\SamsungSchr720($useragent, []);
        }

        if (preg_match('/GT\-S8600/i', $useragent)) {
            return new Samsung\SamsungGts8600($useragent, []);
        }

        if (preg_match('/GT\-S8530/i', $useragent)) {
            return new Samsung\SamsungGts8530($useragent, []);
        }

        if (preg_match('/GT\-S8500/i', $useragent)) {
            return new Samsung\SamsungGts8500($useragent, []);
        }

        if (preg_match('/(SAMSUNG|GT)\-S8300/i', $useragent)) {
            return new Samsung\SamsungGts8300($useragent, []);
        }

        if (preg_match('/(SAMSUNG|GT)\-S8003/i', $useragent)) {
            return new Samsung\SamsungGts8003($useragent, []);
        }

        if (preg_match('/(SAMSUNG|GT)\-S8000/i', $useragent)) {
            return new Samsung\SamsungGts8000($useragent, []);
        }

        if (preg_match('/(SAMSUNG|GT)\-S7710/i', $useragent)) {
            return new Samsung\SamsungGts7710($useragent, []);
        }

        if (preg_match('/GT\-S7580/i', $useragent)) {
            return new Samsung\SamsungGts7580($useragent, []);
        }

        if (preg_match('/GT\-S7562/i', $useragent)) {
            return new Samsung\SamsungGts7562($useragent, []);
        }

        if (preg_match('/GT\-S7560/i', $useragent)) {
            return new Samsung\SamsungGts7560($useragent, []);
        }

        if (preg_match('/GT\-S7530/i', $useragent)) {
            return new Samsung\SamsungGts7530($useragent, []);
        }

        if (preg_match('/GT\-S7500/i', $useragent)) {
            return new Samsung\SamsungGts7500($useragent, []);
        }

        if (preg_match('/GT\-S7390/i', $useragent)) {
            return new Samsung\SamsungGts7390($useragent, []);
        }

        if (preg_match('/GT\-S7330/i', $useragent)) {
            return new Samsung\SamsungGts7330($useragent, []);
        }

        if (preg_match('/GT\-S7275R/i', $useragent)) {
            return new Samsung\SamsungGts7275r($useragent, []);
        }

        if (preg_match('/GT\-S7262/i', $useragent)) {
            return new Samsung\SamsungGts7262($useragent, []);
        }

        if (preg_match('/GT\-S7250/i', $useragent)) {
            return new Samsung\SamsungGts7250($useragent, []);
        }

        if (preg_match('/GT\-S7233E/i', $useragent)) {
            return new Samsung\SamsungGts7233e($useragent, []);
        }

        if (preg_match('/GT\-S7230E/i', $useragent)) {
            return new Samsung\SamsungGts7230e($useragent, []);
        }

        if (preg_match('/(SAMSUNG|GT)\-S7220/i', $useragent)) {
            return new Samsung\SamsungGts7220($useragent, []);
        }

        if (preg_match('/GT\-S6810P/i', $useragent)) {
            return new Samsung\SamsungGts6810p($useragent, []);
        }

        if (preg_match('/GT\-S6810/i', $useragent)) {
            return new Samsung\SamsungGts6810($useragent, []);
        }

        if (preg_match('/GT\-S6802/i', $useragent)) {
            return new Samsung\SamsungGts6802($useragent, []);
        }

        if (preg_match('/GT\-S6500D/i', $useragent)) {
            return new Samsung\SamsungGts6500d($useragent, []);
        }

        if (preg_match('/GT\-S6500/i', $useragent)) {
            return new Samsung\SamsungGts6500($useragent, []);
        }

        if (preg_match('/GT\-S6312/i', $useragent)) {
            return new Samsung\SamsungGts6312($useragent, []);
        }

        if (preg_match('/GT\-S6310N/i', $useragent)) {
            return new Samsung\SamsungGts6310N($useragent, []);
        }

        if (preg_match('/GT\-S6310/i', $useragent)) {
            return new Samsung\SamsungGts6310($useragent, []);
        }

        if (preg_match('/GT\-S6102B/i', $useragent)) {
            return new Samsung\SamsungGts6102B($useragent, []);
        }

        if (preg_match('/GT\-S6102/i', $useragent)) {
            return new Samsung\SamsungGts6102($useragent, []);
        }

        if (preg_match('/GT\-S5839i/i', $useragent)) {
            return new Samsung\SamsungGts5839i($useragent, []);
        }

        if (preg_match('/GT\-S5830L/i', $useragent)) {
            return new Samsung\SamsungGts5830l($useragent, []);
        }

        if (preg_match('/GT\-S5830i/i', $useragent)) {
            return new Samsung\SamsungGts5830i($useragent, []);
        }

        if (preg_match('/GT\-S5830C/i', $useragent)) {
            return new Samsung\SamsungGts5830c($useragent, []);
        }

        if (preg_match('/GT\-S5830/i', $useragent)) {
            return new Samsung\SamsungGts5830($useragent, []);
        }

        if (preg_match('/GT\-S5780/i', $useragent)) {
            return new Samsung\SamsungGts5780($useragent, []);
        }

        if (preg_match('/GT\-S5750E/i', $useragent)) {
            return new Samsung\SamsungGts5750e($useragent, []);
        }

        if (preg_match('/GT\-S5690/i', $useragent)) {
            return new Samsung\SamsungGts5690($useragent, []);
        }

        if (preg_match('/GT\-S5670/i', $useragent)) {
            return new Samsung\SamsungGts5670($useragent, []);
        }

        if (preg_match('/GT\-S5660/i', $useragent)) {
            return new Samsung\SamsungGts5660($useragent, []);
        }

        if (preg_match('/gt\-s5620/i', $useragent)) {
            return new Samsung\SamsungGts5620($useragent, []);
        }

        if (preg_match('/GT\-S5570I/i', $useragent)) {
            return new Samsung\SamsungGts5570i($useragent, []);
        }

        if (preg_match('/GT\-S5570/i', $useragent)) {
            return new Samsung\SamsungGts5570($useragent, []);
        }

        if (preg_match('/GT\-S5560i/i', $useragent)) {
            return new Samsung\SamsungGts5560i($useragent, []);
        }

        if (preg_match('/GT\-S5560/i', $useragent)) {
            return new Samsung\SamsungGts5560($useragent, []);
        }

        if (preg_match('/GT\-S5380/i', $useragent)) {
            return new Samsung\SamsungGts5380($useragent, []);
        }

        if (preg_match('/GT\-S5369/i', $useragent)) {
            return new Samsung\SamsungGts5369($useragent, []);
        }

        if (preg_match('/GT\-S5363/i', $useragent)) {
            return new Samsung\SamsungGts5363($useragent, []);
        }

        if (preg_match('/GT\-S5360/i', $useragent)) {
            return new Samsung\SamsungGts5360($useragent, []);
        }

        if (preg_match('/GT\-S5330/i', $useragent)) {
            return new Samsung\SamsungGts5330($useragent, []);
        }

        if (preg_match('/GT\-S5310/i', $useragent)) {
            return new Samsung\SamsungGts5310($useragent, []);
        }

        if (preg_match('/GT\-S5302/i', $useragent)) {
            return new Samsung\SamsungGts5302($useragent, []);
        }

        if (preg_match('/GT\-S5301/i', $useragent)) {
            return new Samsung\SamsungGts5301($useragent, []);
        }

        if (preg_match('/GT\-S5300B/i', $useragent)) {
            return new Samsung\SamsungGts5300B($useragent, []);
        }

        if (preg_match('/GT\-S5300/i', $useragent)) {
            return new Samsung\SamsungGts5300($useragent, []);
        }

        if (preg_match('/GT\-S5280/i', $useragent)) {
            return new Samsung\SamsungGts5280($useragent, []);
        }

        if (preg_match('/GT\-S5260/i', $useragent)) {
            return new Samsung\SamsungGts5260($useragent, []);
        }

        if (preg_match('/GT\-S5250/i', $useragent)) {
            return new Samsung\SamsungGts5250($useragent, []);
        }

        if (preg_match('/GT\-S5233S/i', $useragent)) {
            return new Samsung\SamsungGts5233S($useragent, []);
        }

        if (preg_match('/GT\-S5230W/i', $useragent)) {
            return new Samsung\SamsungGts5230w($useragent, []);
        }

        if (preg_match('/GT\-S5230/i', $useragent)) {
            return new Samsung\SamsungGts5230($useragent, []);
        }

        if (preg_match('/GT\-S5222/i', $useragent)) {
            return new Samsung\SamsungGts5222($useragent, []);
        }

        if (preg_match('/GT\-S5220/i', $useragent)) {
            return new Samsung\SamsungGts5220($useragent, []);
        }

        if (preg_match('/GT\-S3850/i', $useragent)) {
            return new Samsung\SamsungGts3850($useragent, []);
        }

        if (preg_match('/GT\-S3802/i', $useragent)) {
            return new Samsung\SamsungGts3802($useragent, []);
        }

        if (preg_match('/GT\-S3653/i', $useragent)) {
            return new Samsung\SamsungGts3653($useragent, []);
        }

        if (preg_match('/GT\-S3650/i', $useragent)) {
            return new Samsung\SamsungGts3650($useragent, []);
        }

        if (preg_match('/gt-s3370/i', $useragent)) {
            return new Samsung\SamsungGts3370($useragent, []);
        }

        if (preg_match('/GT\-P7511/i', $useragent)) {
            return new Samsung\SamsungGtp7511($useragent, []);
        }

        if (preg_match('/GT\-P7510/i', $useragent)) {
            return new Samsung\SamsungGtp7510($useragent, []);
        }

        if (preg_match('/GT\-P7501/i', $useragent)) {
            return new Samsung\SamsungGtp7501($useragent, []);
        }

        if (preg_match('/GT\-P7500M/i', $useragent)) {
            return new Samsung\SamsungGtp7500M($useragent, []);
        }

        if (preg_match('/GT\-P7500/i', $useragent)) {
            return new Samsung\SamsungGtp7500($useragent, []);
        }

        if (preg_match('/GT\-P7320/i', $useragent)) {
            return new Samsung\SamsungGtp7320($useragent, []);
        }

        if (preg_match('/GT\-P7310/i', $useragent)) {
            return new Samsung\SamsungGtp7310($useragent, []);
        }

        if (preg_match('/GT\-P7300B/i', $useragent)) {
            return new Samsung\SamsungGtp7300B($useragent, []);
        }

        if (preg_match('/GT\-P7300/i', $useragent)) {
            return new Samsung\SamsungGtp7300($useragent, []);
        }

        if (preg_match('/GT\-P7100/i', $useragent)) {
            return new Samsung\SamsungGtp7100($useragent, []);
        }

        if (preg_match('/GT\-P6810/i', $useragent)) {
            return new Samsung\SamsungGtp6810($useragent, []);
        }

        if (preg_match('/GT\-P6800/i', $useragent)) {
            return new Samsung\SamsungGtp6800($useragent, []);
        }

        if (preg_match('/GT\-P6211/i', $useragent)) {
            return new Samsung\SamsungGtp6211($useragent, []);
        }

        if (preg_match('/GT\-P6210/i', $useragent)) {
            return new Samsung\SamsungGtp6210($useragent, []);
        }

        if (preg_match('/GT\-P6201/i', $useragent)) {
            return new Samsung\SamsungGtp6201($useragent, []);
        }

        if (preg_match('/GT\-P6200/i', $useragent)) {
            return new Samsung\SamsungGtp6200($useragent, []);
        }

        if (preg_match('/GT\-P5220/i', $useragent)) {
            return new Samsung\SamsungGtp5220($useragent, []);
        }

        if (preg_match('/GT\-P5210/i', $useragent)) {
            return new Samsung\SamsungGtp5210($useragent, []);
        }

        if (preg_match('/GT\-P5200/i', $useragent)) {
            return new Samsung\SamsungGtp5200($useragent, []);
        }

        if (preg_match('/GT\-P5113/i', $useragent)) {
            return new Samsung\SamsungGtp5113($useragent, []);
        }

        if (preg_match('/GT\-P5110/i', $useragent)) {
            return new Samsung\SamsungGtp5110($useragent, []);
        }

        if (preg_match('/GT\-P5100/i', $useragent)) {
            return new Samsung\SamsungGtp5100($useragent, []);
        }

        if (preg_match('/GT\-P3113/i', $useragent)) {
            return new Samsung\SamsungGtp3113($useragent, []);
        }

        if (preg_match('/GT\-P3110/i', $useragent)) {
            return new Samsung\SamsungGtp3110($useragent, []);
        }

        if (preg_match('/GT\-P3100/i', $useragent)) {
            return new Samsung\SamsungGtp3100($useragent, []);
        }

        if (preg_match('/GT\-P1010/i', $useragent)) {
            return new Samsung\SamsungGtp1010($useragent, []);
        }

        if (preg_match('/GT\-P1000N/i', $useragent)) {
            return new Samsung\SamsungGtp1000N($useragent, []);
        }

        if (preg_match('/GT\-P1000M/i', $useragent)) {
            return new Samsung\SamsungGtp1000M($useragent, []);
        }

        if (preg_match('/GT\-P1000/i', $useragent)) {
            return new Samsung\SamsungGtp1000($useragent, []);
        }

        if (preg_match('/GT\-N8020/i', $useragent)) {
            return new Samsung\SamsungGtn8020($useragent, []);
        }

        if (preg_match('/GT\-N8013/i', $useragent)) {
            return new Samsung\SamsungGtn8013($useragent, []);
        }

        if (preg_match('/GT\-N8010/i', $useragent)) {
            return new Samsung\SamsungGtn8010($useragent, []);
        }

        if (preg_match('/GT\-N8000/i', $useragent)) {
            return new Samsung\SamsungGtn8000($useragent, []);
        }

        if (preg_match('/GT\-N7108/i', $useragent)) {
            return new Samsung\SamsungGtn7108($useragent, []);
        }

        if (preg_match('/GT\-N7105/i', $useragent)) {
            return new Samsung\SamsungGtn7105($useragent, []);
        }

        if (preg_match('/GT\-N7100/i', $useragent)) {
            return new Samsung\SamsungGtn7100($useragent, []);
        }

        if (preg_match('/GT\-N7000/i', $useragent)) {
            return new Samsung\SamsungGtn7000($useragent, []);
        }

        if (preg_match('/GT\-N5120/i', $useragent)) {
            return new Samsung\SamsungGtn5120($useragent, []);
        }

        if (preg_match('/GT\-N5110/i', $useragent)) {
            return new Samsung\SamsungGtn5110($useragent, []);
        }

        if (preg_match('/GT\-N5100/i', $useragent)) {
            return new Samsung\SamsungGtn5100($useragent, []);
        }

        if (preg_match('/GT\-M7600/i', $useragent)) {
            return new Samsung\SamsungGtm7600($useragent, []);
        }

        if (preg_match('/GT\-I9515/i', $useragent)) {
            return new Samsung\SamsungGti9515($useragent, []);
        }

        if (preg_match('/GT\-I9506/i', $useragent)) {
            return new Samsung\SamsungGti9506($useragent, []);
        }

        if (preg_match('/GT\-I9505X/i', $useragent)) {
            return new Samsung\SamsungGti9505x($useragent, []);
        }

        if (preg_match('/GT\-I9505G/i', $useragent)) {
            return new Samsung\SamsungGti9505g($useragent, []);
        }

        if (preg_match('/GT\-I9505/i', $useragent)) {
            return new Samsung\SamsungGti9505($useragent, []);
        }

        if (preg_match('/GT\-I9500/i', $useragent)) {
            return new Samsung\SamsungGti9500($useragent, []);
        }

        if (preg_match('/GT\-I9308/i', $useragent)) {
            return new Samsung\SamsungGti9308($useragent, []);
        }

        if (preg_match('/GT\-I9305/i', $useragent)) {
            return new Samsung\SamsungGti9305($useragent, []);
        }

        if (preg_match('/(GT\-l9301I|GT\-i9301I|I9301I)/i', $useragent)) {
            return new Samsung\SamsungGti9301i($useragent, []);
        }

        if (preg_match('/GT\-I9300I/i', $useragent)) {
            return new Samsung\SamsungGti9300i($useragent, []);
        }

        if (preg_match('/(GT\-l9300|GT\-i9300|I9300)/i', $useragent)) {
            return new Samsung\SamsungGti9300($useragent, []);
        }

        if (preg_match('/(GT\-I9295|I9295)/i', $useragent)) {
            return new Samsung\SamsungGti9295($useragent, []);
        }

        if (preg_match('/GT\-I9210/i', $useragent)) {
            return new Samsung\SamsungGti9210($useragent, []);
        }

        if (preg_match('/GT\-I9205/i', $useragent)) {
            return new Samsung\SamsungGti9205($useragent, []);
        }

        if (preg_match('/GT\-I9200/i', $useragent)) {
            return new Samsung\SamsungGti9200($useragent, []);
        }

        if (preg_match('/(GT\-I9195|I9195)/i', $useragent)) {
            return new Samsung\SamsungGti9195($useragent, []);
        }

        if (preg_match('/(GT\-I9192|I9192)/i', $useragent)) {
            return new Samsung\SamsungGti9192($useragent, []);
        }

        if (preg_match('/(GT\-I9190|I9190)/i', $useragent)) {
            return new Samsung\SamsungGti9190($useragent, []);
        }

        if (preg_match('/GT\-I9128V/i', $useragent)) {
            return new Samsung\SamsungGti9128v($useragent, []);
        }

        if (preg_match('/GT\-I9105P/i', $useragent)) {
            return new Samsung\SamsungGti9105p($useragent, []);
        }

        if (preg_match('/GT\-I9103/i', $useragent)) {
            return new Samsung\SamsungGti9103($useragent, []);
        }

        if (preg_match('/GT\-I9100T/i', $useragent)) {
            return new Samsung\SamsungGti9100t($useragent, []);
        }

        if (preg_match('/GT\-I9100P/i', $useragent)) {
            return new Samsung\SamsungGti9100p($useragent, []);
        }

        if (preg_match('/GT\-I9100G/i', $useragent)) {
            return new Samsung\SamsungGti9100g($useragent, []);
        }

        if (preg_match('/(GT\-I9100|I9100)/i', $useragent)) {
            return new Samsung\SamsungGti9100($useragent, []);
        }

        if (preg_match('/GT\-I9088/i', $useragent)) {
            return new Samsung\SamsungGti9088($useragent, []);
        }

        if (preg_match('/GT\-I9082L/i', $useragent)) {
            return new Samsung\SamsungGti9082L($useragent, []);
        }

        if (preg_match('/GT\-I9082/i', $useragent)) {
            return new Samsung\SamsungGti9082($useragent, []);
        }

        if (preg_match('/GT\-I9070P/i', $useragent)) {
            return new Samsung\SamsungGti9070P($useragent, []);
        }

        if (preg_match('/GT\-I9070/i', $useragent)) {
            return new Samsung\SamsungGti9070($useragent, []);
        }

        if (preg_match('/GT\-I9060/i', $useragent)) {
            return new Samsung\SamsungGti9060($useragent, []);
        }

        if (preg_match('/GT\-I9023/i', $useragent)) {
            return new Samsung\SamsungGti9023($useragent, []);
        }

        if (preg_match('/GT\-I9010P/i', $useragent)) {
            return new Samsung\SamsungGti9010P($useragent, []);
        }

        if (preg_match('/Galaxy( |\-)S/i', $useragent)) {
            return new Samsung\SamsungGti9010GalaxyS($useragent, []);
        }

        if (preg_match('/GT\-I9010/i', $useragent)) {
            return new Samsung\SamsungGti9010($useragent, []);
        }

        if (preg_match('/GT\-I9008L/i', $useragent)) {
            return new Samsung\SamsungGti9008l($useragent, []);
        }

        if (preg_match('/GT\-I9008/i', $useragent)) {
            return new Samsung\SamsungGti9008($useragent, []);
        }

        if (preg_match('/GT\-I9003L/i', $useragent)) {
            return new Samsung\SamsungGti9003l($useragent, []);
        }

        if (preg_match('/GT\-I9003/i', $useragent)) {
            return new Samsung\SamsungGti9003($useragent, []);
        }

        if (preg_match('/GT\-I9001/i', $useragent)) {
            return new Samsung\SamsungGti9001($useragent, []);
        }

        if (preg_match('/(GT\-I9000|SGH\-T959V)/i', $useragent)) {
            return new Samsung\SamsungGti9000($useragent, []);
        }

        if (preg_match('/(GT\-I8910|I8910)/i', $useragent)) {
            return new Samsung\SamsungGti8910($useragent, []);
        }

        if (preg_match('/GT\-I8750/i', $useragent)) {
            return new Samsung\SamsungGti8750($useragent, []);
        }

        if (preg_match('/GT\-I8730/i', $useragent)) {
            return new Samsung\SamsungGti8730($useragent, []);
        }

        if (preg_match('/OMNIA7/i', $useragent)) {
            return new Samsung\SamsungGti8700Omnia7($useragent, []);
        }

        if (preg_match('/GT\-I8530/i', $useragent)) {
            return new Samsung\SamsungGti8530($useragent, []);
        }

        if (preg_match('/GT\-I8350/i', $useragent)) {
            return new Samsung\SamsungGti8350OmniaW($useragent, []);
        }

        if (preg_match('/GT\-I8320/i', $useragent)) {
            return new Samsung\SamsungGti8320($useragent, []);
        }

        if (preg_match('/GT\-I8262/i', $useragent)) {
            return new Samsung\SamsungGti8262($useragent, []);
        }

        if (preg_match('/GT\-I8200N/i', $useragent)) {
            return new Samsung\SamsungGti8200n($useragent, []);
        }

        if (preg_match('/GT\-I8200/i', $useragent)) {
            return new Samsung\SamsungGti8200($useragent, []);
        }

        if (preg_match('/GT\-I8190N/i', $useragent)) {
            return new Samsung\SamsungGti8190n($useragent, []);
        }

        if (preg_match('/GT\-I8190/i', $useragent)) {
            return new Samsung\SamsungGti8190($useragent, []);
        }

        if (preg_match('/GT\-I8160P/i', $useragent)) {
            return new Samsung\SamsungGti8160p($useragent, []);
        }

        if (preg_match('/GT\-I8160/i', $useragent)) {
            return new Samsung\SamsungGti8160($useragent, []);
        }

        if (preg_match('/GT\-I8150/i', $useragent)) {
            return new Samsung\SamsungGti8150($useragent, []);
        }

        if (preg_match('/GT\-i8000V/i', $useragent)) {
            return new Samsung\SamsungGti8000v($useragent, []);
        }

        if (preg_match('/GT\-i8000/i', $useragent)) {
            return new Samsung\SamsungGti8000($useragent, []);
        }

        if (preg_match('/GT\-I6410/i', $useragent)) {
            return new Samsung\SamsungGti6410($useragent, []);
        }

        if (preg_match('/GT\-I5801/i', $useragent)) {
            return new Samsung\SamsungGti5801($useragent, []);
        }

        if (preg_match('/GT\-I5800/i', $useragent)) {
            return new Samsung\SamsungGti5800($useragent, []);
        }

        if (preg_match('/GT\-I5700/i', $useragent)) {
            return new Samsung\SamsungGti5700($useragent, []);
        }

        if (preg_match('/GT\-I5510/i', $useragent)) {
            return new Samsung\SamsungGti5510($useragent, []);
        }

        if (preg_match('/GT\-I5508/i', $useragent)) {
            return new Samsung\SamsungGti5508($useragent, []);
        }

        if (preg_match('/GT\-I5503/i', $useragent)) {
            return new Samsung\SamsungGti5503($useragent, []);
        }

        if (preg_match('/GT\-I5500/i', $useragent)) {
            return new Samsung\SamsungGti5500($useragent, []);
        }

        if (preg_match('/Nexus S 4G/i', $useragent)) {
            return new Samsung\SamsungGalaxyNexusS4G($useragent, []);
        }

        if (preg_match('/Nexus S/i', $useragent)) {
            return new Samsung\SamsungGalaxyNexusS($useragent, []);
        }

        if (preg_match('/Nexus 10/i', $useragent)) {
            return new Samsung\SamsungGalaxyNexus10($useragent, []);
        }

        if (preg_match('/Nexus/i', $useragent)) {
            return new Samsung\SamsungGalaxyNexus($useragent, []);
        }

        if (preg_match('/Galaxy/i', $useragent)) {
            return new Samsung\SamsungGti7500Galaxy($useragent, []);
        }

        if (preg_match('/GT\-E3309T/i', $useragent)) {
            return new Samsung\SamsungGte3309t($useragent, []);
        }

        if (preg_match('/GT\-E2550/i', $useragent)) {
            return new Samsung\SamsungGte2550($useragent, []);
        }

        if (preg_match('/GT\-E2252/i', $useragent)) {
            return new Samsung\SamsungGte2252($useragent, []);
        }

        if (preg_match('/GT\-E2222/i', $useragent)) {
            return new Samsung\SamsungGte2222($useragent, []);
        }

        if (preg_match('/GT\-E2202/i', $useragent)) {
            return new Samsung\SamsungGte2202($useragent, []);
        }

        if (preg_match('/GT\-E1282T/i', $useragent)) {
            return new Samsung\SamsungGte1282T($useragent, []);
        }

        if (preg_match('/GT\-C6712/i', $useragent)) {
            return new Samsung\SamsungGtc6712($useragent, []);
        }

        if (preg_match('/GT\-C3510/i', $useragent)) {
            return new Samsung\SamsungGtc3510($useragent, []);
        }

        if (preg_match('/GT\-C3500/i', $useragent)) {
            return new Samsung\SamsungGtc3500($useragent, []);
        }

        if (preg_match('/GT\-C3350/i', $useragent)) {
            return new Samsung\SamsungGtc3350($useragent, []);
        }

        if (preg_match('/GT\-C3322/i', $useragent)) {
            return new Samsung\SamsungGtc3322($useragent, []);
        }

        if (preg_match('/GT\-C3310/i', $useragent)) {
            return new Samsung\SamsungGtc3310($useragent, []);
        }

        if (preg_match('/GT\-C3262/i', $useragent)) {
            return new Samsung\SamsungGtc3262($useragent, []);
        }

        if (preg_match('/GT\-B7722/i', $useragent)) {
            return new Samsung\SamsungGtb7722($useragent, []);
        }

        if (preg_match('/GT\-B7610/i', $useragent)) {
            return new Samsung\SamsungGtb7610($useragent, []);
        }

        if (preg_match('/GT\-B7510/i', $useragent)) {
            return new Samsung\SamsungGtb7510($useragent, []);
        }

        if (preg_match('/GT\-B7350/i', $useragent)) {
            return new Samsung\SamsungGtb7350($useragent, []);
        }

        if (preg_match('/GT\-B5510/i', $useragent)) {
            return new Samsung\SamsungGtb5510($useragent, []);
        }

        if (preg_match('/GT\-B3410/i', $useragent)) {
            return new Samsung\SamsungGtb3410($useragent, []);
        }

        if (preg_match('/GT\-B2710/i', $useragent)) {
            return new Samsung\SamsungGtb2710($useragent, []);
        }

        if (preg_match('/(GT\-B2100|B2100)/i', $useragent)) {
            return new Samsung\SamsungGtb2100($useragent, []);
        }

        if (preg_match('/F031/i', $useragent)) {
            return new Samsung\SamsungF031($useragent, []);
        }

        if (preg_match('/Continuum\-I400/i', $useragent)) {
            return new Samsung\SamsungContinuumI400($useragent, []);
        }

        if (preg_match('/CETUS/i', $useragent)) {
            return new Samsung\Cetus($useragent, []);
        }

        if (preg_match('/SC\-02C/i', $useragent)) {
            return new Samsung\SamsungSc02c($useragent, []);
        }

        if (preg_match('/SC\-02B/i', $useragent)) {
            return new Samsung\SamsungSc02b($useragent, []);
        }

        if (preg_match('/S3500/i', $useragent)) {
            return new Samsung\SamsungS3500($useragent, []);
        }

        if (preg_match('/R631/i', $useragent)) {
            return new Samsung\SamsungR631($useragent, []);
        }

        if (preg_match('/I7110/i', $useragent)) {
            return new Samsung\SamsungI7110($useragent, []);
        }

        if (preg_match('/YP\-GS1/i', $useragent)) {
            return new Samsung\YPGs1($useragent, []);
        }

        if (preg_match('/YP\-GI1/i', $useragent)) {
            return new Samsung\YPGi1($useragent, []);
        }

        if (preg_match('/YP\-GB70/i', $useragent)) {
            return new Samsung\YPGB70($useragent, []);
        }

        if (preg_match('/YP\-G70/i', $useragent)) {
            return new Samsung\YPG70($useragent, []);
        }

        if (preg_match('/YP\-G1/i', $useragent)) {
            return new Samsung\YPG1($useragent, []);
        }

        if (preg_match('/SPH\-M580/i', $useragent)) {
            return new Samsung\SphM580($useragent, []);
        }

        if (preg_match('/SHW\-M380K/i', $useragent)) {
            return new Samsung\ShwM380K($useragent, []);
        }

        if (preg_match('/SCH\-R730/i', $useragent)) {
            return new Samsung\SamsungSshR730($useragent, []);
        }

        if (preg_match('/SPH\-P100/i', $useragent)) {
            return new Samsung\SamsungSphp100($useragent, []);
        }

        if (preg_match('/SPH\-M930/i', $useragent)) {
            return new Samsung\SamsungSphm930($useragent, []);
        }

        if (preg_match('/SPH\-L720/i', $useragent)) {
            return new Samsung\SamsungSphl720($useragent, []);
        }

        if (preg_match('/SPH\-L710/i', $useragent)) {
            return new Samsung\SamsungSphl710($useragent, []);
        }

        if (preg_match('/SPH\-ip830w/i', $useragent)) {
            return new Samsung\SamsungSphIp830w($useragent, []);
        }

        if (preg_match('/SPH\-D710BST/i', $useragent)) {
            return new Samsung\SamsungSphd710bst($useragent, []);
        }

        if (preg_match('/SPH\-D710/i', $useragent)) {
            return new Samsung\SamsungSphd710($useragent, []);
        }

        if (preg_match('/smart\-tv/i', $useragent)) {
            return new Samsung\SamsungSmartTv($useragent, []);
        }

        return new Samsung($useragent, []);
    }
}
