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

use BrowserDetector\Detector\Device\Mobile\Sony;
use BrowserDetector\Detector\Factory\DeviceFactory;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class SonyFactory implements FactoryInterface
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
        if (preg_match('/f3111/i', $useragent)) {
            $deviceCode = 'f3111';
        }

        if (preg_match('/e6853/i', $useragent)) {
            $deviceCode = 'e6853';
        }

        if (preg_match('/e6653/i', $useragent)) {
            $deviceCode = 'e6653';
        }

        if (preg_match('/e6553/i', $useragent)) {
            $deviceCode = 'e6553';
        }

        if (preg_match('/e5823/i', $useragent)) {
            $deviceCode = 'e5823';
        }

        if (preg_match('/e5603/i', $useragent)) {
            $deviceCode = 'e5603';
        }

        if (preg_match('/e2303/i', $useragent)) {
            $deviceCode = 'e2303';
        }

        if (preg_match('/e2105/i', $useragent)) {
            $deviceCode = 'e2105';
        }

        if (preg_match('/e2003/i', $useragent)) {
            $deviceCode = 'e2003';
        }

        if (preg_match('/c5502/i', $useragent)) {
            $deviceCode = 'c5502';
        }

        if (preg_match('/c5303/i', $useragent)) {
            $deviceCode = 'c5303';
        }

        if (preg_match('/c5302/i', $useragent)) {
            $deviceCode = 'c5302';
        }

        if (preg_match('/xperia s/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/c6902/i', $useragent)) {
            $deviceCode = 'c6902';
        }

        if (preg_match('/l36h/i', $useragent)) {
            $deviceCode = 'l36h';
        }

        if (preg_match('/(xperia z1|c6903)/i', $useragent)) {
            $deviceCode = 'c6903';
        }

        if (preg_match('/c6833/i', $useragent)) {
            $deviceCode = 'c6833';
        }

        if (preg_match('/c6606/i', $useragent)) {
            $deviceCode = 'c6606';
        }

        if (preg_match('/c6602/i', $useragent)) {
            $deviceCode = 'c6602';
        }

        if (preg_match('/(xperia z|c6603)/i', $useragent)) {
            $deviceCode = 'c6603';
        }

        if (preg_match('/c6503/i', $useragent)) {
            $deviceCode = 'c6503';
        }

        if (preg_match('/c2305/i', $useragent)) {
            $deviceCode = 'c2305';
        }

        if (preg_match('/c2105/i', $useragent)) {
            $deviceCode = 'c2105';
        }

        if (preg_match('/c2005/i', $useragent)) {
            $deviceCode = 'c2005';
        }

        if (preg_match('/c1905/i', $useragent)) {
            $deviceCode = 'c1905';
        }

        if (preg_match('/c1904/i', $useragent)) {
            $deviceCode = 'c1904';
        }

        if (preg_match('/c1605/i', $useragent)) {
            $deviceCode = 'c1605';
        }

        if (preg_match('/c1505/i', $useragent)) {
            $deviceCode = 'c1505';
        }

        if (preg_match('/d5803/i', $useragent)) {
            $deviceCode = 'd5803';
        }

        if (preg_match('/d6633/i', $useragent)) {
            $deviceCode = 'd6633';
        }

        if (preg_match('/d6603/i', $useragent)) {
            $deviceCode = 'd6603';
        }

        if (preg_match('/l50u/i', $useragent)) {
            $deviceCode = 'l50u';
        }

        if (preg_match('/d6503/i', $useragent)) {
            $deviceCode = 'd6503';
        }

        if (preg_match('/d5833/i', $useragent)) {
            $deviceCode = 'd5833';
        }

        if (preg_match('/d5503/i', $useragent)) {
            $deviceCode = 'd5503';
        }

        if (preg_match('/d5303/i', $useragent)) {
            $deviceCode = 'd5303';
        }

        if (preg_match('/d5103/i', $useragent)) {
            $deviceCode = 'd5103';
        }

        if (preg_match('/d2403/i', $useragent)) {
            $deviceCode = 'd2403';
        }

        if (preg_match('/d2306/i', $useragent)) {
            $deviceCode = 'd2306';
        }

        if (preg_match('/d2303/i', $useragent)) {
            $deviceCode = 'd2303';
        }

        if (preg_match('/d2302/i', $useragent)) {
            $deviceCode = 'd2302';
        }

        if (preg_match('/d2203/i', $useragent)) {
            $deviceCode = 'd2203';
        }

        if (preg_match('/d2105/i', $useragent)) {
            $deviceCode = 'd2105';
        }

        if (preg_match('/d2005/i', $useragent)) {
            $deviceCode = 'd2005';
        }

        if (preg_match('/SGPT13/i', $useragent)) {
            $deviceCode = 'sgpt13';
        }

        if (preg_match('/sgpt12/i', $useragent)) {
            $deviceCode = 'sgpt12';
        }

        if (preg_match('/SGP771/i', $useragent)) {
            $deviceCode = 'sgp771';
        }

        if (preg_match('/SGP712/i', $useragent)) {
            $deviceCode = 'sgp712';
        }

        if (preg_match('/SGP621/i', $useragent)) {
            $deviceCode = 'sgp621';
        }

        if (preg_match('/SGP611/i', $useragent)) {
            $deviceCode = 'sgp611';
        }

        if (preg_match('/SGP521/i', $useragent)) {
            $deviceCode = 'sgp521';
        }

        if (preg_match('/SGP512/i', $useragent)) {
            $deviceCode = 'sgp512';
        }

        if (preg_match('/SGP511/i', $useragent)) {
            $deviceCode = 'sgp511';
        }

        if (preg_match('/SGP412/i', $useragent)) {
            $deviceCode = 'sgp412';
        }

        if (preg_match('/SGP321/i', $useragent)) {
            $deviceCode = 'sgp321';
        }

        if (preg_match('/SGP312/i', $useragent)) {
            $deviceCode = 'sgp312';
        }

        if (preg_match('/SGP311/i', $useragent)) {
            $deviceCode = 'sgp311';
        }

        if (preg_match('/ST26i/i', $useragent)) {
            $deviceCode = 'st26i';
        }

        if (preg_match('/ST26a/i', $useragent)) {
            $deviceCode = 'st26a';
        }

        if (preg_match('/ST23i/i', $useragent)) {
            $deviceCode = 'st23i';
        }

        if (preg_match('/ST21iv/i', $useragent)) {
            $deviceCode = 'st21iv';
        }

        if (preg_match('/ST21i2/i', $useragent)) {
            $deviceCode = 'st21i2';
        }

        if (preg_match('/ST21i/i', $useragent)) {
            $deviceCode = 'st21i';
        }

        if (preg_match('/(lt30p|xperia t)/i', $useragent)) {
            $deviceCode = 'lt30p';
        }

        if (preg_match('/LT29i/i', $useragent)) {
            $deviceCode = 'lt29i';
        }

        if (preg_match('/LT26w/i', $useragent)) {
            $deviceCode = 'lt26w';
        }

        if (preg_match('/LT25i/i', $useragent)) {
            $deviceCode = 'lt25i';
        }

        if (preg_match('/X10iv/i', $useragent)) {
            $deviceCode = 'x10iv';
        }

        if (preg_match('/X10i/i', $useragent)) {
            $deviceCode = 'x10i';
        }

        if (preg_match('/X10a/i', $useragent)) {
            $deviceCode = 'x10a';
        }

        if (preg_match('/X10/i', $useragent)) {
            $deviceCode = 'sonyericsson x10';
        }

        if (preg_match('/U20iv/i', $useragent)) {
            $deviceCode = 'u20iv';
        }

        if (preg_match('/U20i/i', $useragent)) {
            $deviceCode = 'u20i';
        }

        if (preg_match('/U20a/i', $useragent)) {
            $deviceCode = 'u20a';
        }

        if (preg_match('/ST27i/i', $useragent)) {
            $deviceCode = 'st27i';
        }

        if (preg_match('/ST25iv/i', $useragent)) {
            $deviceCode = 'st25iv';
        }

        if (preg_match('/ST25i/i', $useragent)) {
            $deviceCode = 'st25i';
        }

        if (preg_match('/ST25a/i', $useragent)) {
            $deviceCode = 'st25a';
        }

        if (preg_match('/ST18iv/i', $useragent)) {
            $deviceCode = 'st18iv';
        }

        if (preg_match('/ST18i/i', $useragent)) {
            $deviceCode = 'st18i';
        }

        if (preg_match('/ST17i/i', $useragent)) {
            $deviceCode = 'st17i';
        }

        if (preg_match('/ST15i/i', $useragent)) {
            $deviceCode = 'st15i';
        }

        if (preg_match('/so\-05d/i', $useragent)) {
            $deviceCode = 'so-05d';
        }

        if (preg_match('/so\-03e/i', $useragent)) {
            $deviceCode = 'so-03e';
        }

        if (preg_match('/so\-03c/i', $useragent)) {
            $deviceCode = 'so-03c';
        }

        if (preg_match('/so\-02e/i', $useragent)) {
            $deviceCode = 'so-02e';
        }

        if (preg_match('/so\-02d/i', $useragent)) {
            $deviceCode = 'so-02d';
        }

        if (preg_match('/so\-02c/i', $useragent)) {
            $deviceCode = 'so-02c';
        }

        if (preg_match('/SK17iv/i', $useragent)) {
            $deviceCode = 'sk17iv';
        }

        if (preg_match('/SK17i/i', $useragent)) {
            $deviceCode = 'sk17i';
        }

        if (preg_match('/R800iv/i', $useragent)) {
            $deviceCode = 'r800iv';
        }

        if (preg_match('/R800i/i', $useragent)) {
            $deviceCode = 'r800i';
        }

        if (preg_match('/R800a/i', $useragent)) {
            $deviceCode = 'r800a';
        }

        if (preg_match('/MT27i/i', $useragent)) {
            $deviceCode = 'mt27i';
        }

        if (preg_match('/MT15iv/i', $useragent)) {
            $deviceCode = 'mt15iv';
        }

        if (preg_match('/MT15i/i', $useragent)) {
            $deviceCode = 'mt15i';
        }

        if (preg_match('/MT15a/i', $useragent)) {
            $deviceCode = 'mt15a';
        }

        if (preg_match('/MT11i/i', $useragent)) {
            $deviceCode = 'mt11i';
        }

        if (preg_match('/MK16i/i', $useragent)) {
            $deviceCode = 'mk16i';
        }

        if (preg_match('/MK16a/i', $useragent)) {
            $deviceCode = 'mk16a';
        }

        if (preg_match('/LT28h/i', $useragent)) {
            $deviceCode = 'lt28h';
        }

        if (preg_match('/LT28at/i', $useragent)) {
            $deviceCode = 'lt28at';
        }

        if (preg_match('/LT26ii/i', $useragent)) {
            $deviceCode = 'lt26ii';
        }

        if (preg_match('/LT26i/i', $useragent)) {
            $deviceCode = 'lt26i';
        }

        if (preg_match('/LT22i/i', $useragent)) {
            $deviceCode = 'lt22i';
        }

        if (preg_match('/LT18iv/i', $useragent)) {
            $deviceCode = 'lt18iv';
        }

        if (preg_match('/LT18i/i', $useragent)) {
            $deviceCode = 'lt18i';
        }

        if (preg_match('/LT18a/i', $useragent)) {
            $deviceCode = 'lt18a';
        }

        if (preg_match('/LT18/i', $useragent)) {
            $deviceCode = 'lt18';
        }

        if (preg_match('/LT15iv/i', $useragent)) {
            $deviceCode = 'lt15iv';
        }

        if (preg_match('/LT15i/i', $useragent)) {
            $deviceCode = 'lt15i';
        }

        if (preg_match('/E15iv/i', $useragent)) {
            $deviceCode = 'e15iv';
        }

        if (preg_match('/E15i/i', $useragent)) {
            $deviceCode = 'e15i';
        }

        if (preg_match('/E15av/i', $useragent)) {
            $deviceCode = 'e15av';
        }

        if (preg_match('/E15a/i', $useragent)) {
            $deviceCode = 'e15a';
        }

        if (preg_match('/E10iv/i', $useragent)) {
            $deviceCode = 'e10iv';
        }

        if (preg_match('/E10i/i', $useragent)) {
            $deviceCode = 'e10i';
        }

        if (preg_match('/Tablet S/i', $useragent)) {
            $deviceCode = 'tablet s';
        }

        if (preg_match('/Tablet P/i', $useragent)) {
            $deviceCode = 'sgpt211';
        }

        if (preg_match('/Netbox/i', $useragent)) {
            $deviceCode = 'netbox';
        }

        if (preg_match('/XST2/i', $useragent)) {
            $deviceCode = 'xst2';
        }

        if (preg_match('/X2/i', $useragent)) {
            $deviceCode = 'sonyericsson x2';
        }

        if (preg_match('/X1i/i', $useragent)) {
            $deviceCode = 'x1i';
        }

        if (preg_match('/WT19iv/i', $useragent)) {
            $deviceCode = 'wt19iv';
        }

        if (preg_match('/WT19i/i', $useragent)) {
            $deviceCode = 'wt19i';
        }

        if (preg_match('/WT19a/i', $useragent)) {
            $deviceCode = 'wt19a';
        }

        if (preg_match('/WT13i/i', $useragent)) {
            $deviceCode = 'wt13i';
        }

        if (preg_match('/W995/i', $useragent)) {
            $deviceCode = 'w995';
        }

        if (preg_match('/W910i/i', $useragent)) {
            $deviceCode = 'w910i';
        }

        if (preg_match('/W890i/i', $useragent)) {
            $deviceCode = 'w890i';
        }

        if (preg_match('/W760i/i', $useragent)) {
            $deviceCode = 'w760i';
        }

        if (preg_match('/W715v/i', $useragent)) {
            $deviceCode = 'w715v';
        }

        if (preg_match('/W595/i', $useragent)) {
            $deviceCode = 'w595';
        }

        if (preg_match('/W580i/i', $useragent)) {
            $deviceCode = 'w580i';
        }

        if (preg_match('/W508a/i', $useragent)) {
            $deviceCode = 'w508a';
        }

        if (preg_match('/W200i/i', $useragent)) {
            $deviceCode = 'w200i';
        }

        if (preg_match('/W150i/i', $useragent)) {
            $deviceCode = 'w150i';
        }

        if (preg_match('/W20i/i', $useragent)) {
            $deviceCode = 'w20i';
        }

        if (preg_match('/U10i/i', $useragent)) {
            $deviceCode = 'u10i';
        }

        if (preg_match('/U8i/i', $useragent)) {
            $deviceCode = 'u8i';
        }

        if (preg_match('/U5i/i', $useragent)) {
            $deviceCode = 'u5i';
        }

        if (preg_match('/U1iv/i', $useragent)) {
            $deviceCode = 'u1iv';
        }

        if (preg_match('/U1i/i', $useragent)) {
            $deviceCode = 'u1i';
        }

        if (preg_match('/U1/i', $useragent)) {
            $deviceCode = 'sonyericsson u1';
        }

        if (preg_match('/SO\-01E/i', $useragent)) {
            $deviceCode = 'so-01e';
        }

        if (preg_match('/SO\-01D/i', $useragent)) {
            $deviceCode = 'so-01d';
        }

        if (preg_match('/SO\-01C/i', $useragent)) {
            $deviceCode = 'so-01c';
        }

        if (preg_match('/SO\-01B/i', $useragent)) {
            $deviceCode = 'so-01b';
        }

        if (preg_match('/SonyEricssonSO/i', $useragent)) {
            $deviceCode = 'so';
        }

        if (preg_match('/S500i/i', $useragent)) {
            $deviceCode = 's500i';
        }

        if (preg_match('/S312/i', $useragent)) {
            $deviceCode = 's312';
        }

        if (preg_match('/R800x/i', $useragent)) {
            $deviceCode = 'r800x';
        }

        if (preg_match('/K810i/i', $useragent)) {
            $deviceCode = 'k810i';
        }

        if (preg_match('/k800i/i', $useragent)) {
            $deviceCode = 'k800i';
        }

        if (preg_match('/k790i/i', $useragent)) {
            $deviceCode = 'k790i';
        }

        if (preg_match('/k770i/i', $useragent)) {
            $deviceCode = 'k770i';
        }

        if (preg_match('/J300/i', $useragent)) {
            $deviceCode = 'j300';
        }

        if (preg_match('/J108i/i', $useragent)) {
            $deviceCode = 'j108i';
        }

        if (preg_match('/J20i/i', $useragent)) {
            $deviceCode = 'j20i';
        }

        if (preg_match('/J10i2/i', $useragent)) {
            $deviceCode = 'j10i2';
        }

        if (preg_match('/G700/i', $useragent)) {
            $deviceCode = 'g700';
        }

        if (preg_match('/CK15i/i', $useragent)) {
            $deviceCode = 'ck15i';
        }

        if (preg_match('/C905/i', $useragent)) {
            $deviceCode = 'c905';
        }

        if (preg_match('/C902/i', $useragent)) {
            $deviceCode = 'c902';
        }

        if (preg_match('/A5000/i', $useragent)) {
            $deviceCode = 'a5000';
        }

        if (preg_match('/EBRD1201/i', $useragent)) {
            $deviceCode = 'sony prst1';
        }

        if (preg_match('/EBRD1101/i', $useragent)) {
            $deviceCode = 'sony prst1';
        }

        if (preg_match('/PlayStation Vita/i', $useragent)) {
            $deviceCode = 'playstation vita';
        }

        if (preg_match('/(PlayStation Portable|PSP)/i', $useragent)) {
            $deviceCode = 'playstation portable';
        }

        if (preg_match('/PlayStation 4/i', $useragent)) {
            $deviceCode = 'playstation 4';
        }

        if (preg_match('/PLAYSTATION 3/i', $useragent)) {
            $deviceCode = 'playstation 3';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            $deviceCode = 'xperia s';
        }

        $deviceCode = 'general sonyericsson device';

        return DeviceFactory::get($deviceCode, $useragent);
    }
}
