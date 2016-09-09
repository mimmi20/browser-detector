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

use BrowserDetector\Detector\Device\Mobile\SonyEricsson;
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
        if (preg_match('/e5823/i', $useragent)) {
            return new SonyEricsson\SonyE5823($useragent);
        }

        if (preg_match('/c5303/i', $useragent)) {
            return new SonyEricsson\SonyC5303XperiaSp($useragent);
        }

        if (preg_match('/c5302/i', $useragent)) {
            return new SonyEricsson\SonyC5302($useragent);
        }

        if (preg_match('/xperia s/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/c6902/i', $useragent)) {
            return new SonyEricsson\SonyC6902($useragent);
        }

        if (preg_match('/(xperia z1|c6903)/i', $useragent)) {
            return new SonyEricsson\SonyC6903ExperiaZ1($useragent);
        }

        if (preg_match('/c6833/i', $useragent)) {
            return new SonyEricsson\SonyC6833ExperiaZultra($useragent);
        }

        if (preg_match('/c6602/i', $useragent)) {
            return new SonyEricsson\SonyC6602ExperiaZ($useragent);
        }

        if (preg_match('/(xperia z|c6603)/i', $useragent)) {
            return new SonyEricsson\SonyC6603ExperiaZ($useragent);
        }

        if (preg_match('/c6503/i', $useragent)) {
            return new SonyEricsson\SonyC6503XperiaZl($useragent);
        }

        if (preg_match('/c2305/i', $useragent)) {
            return new SonyEricsson\SonyC2305($useragent);
        }

        if (preg_match('/c2105/i', $useragent)) {
            return new SonyEricsson\SonyC2105XperiaL($useragent);
        }

        if (preg_match('/c1905/i', $useragent)) {
            return new SonyEricsson\SonyC1905($useragent);
        }

        if (preg_match('/c1904/i', $useragent)) {
            return new SonyEricsson\SonyC1904($useragent);
        }

        if (preg_match('/c1605/i', $useragent)) {
            return new SonyEricsson\SonyC1605($useragent);
        }

        if (preg_match('/c1505/i', $useragent)) {
            return new SonyEricsson\SonyC1505XperiaE($useragent);
        }

        if (preg_match('/d5803/i', $useragent)) {
            return new SonyEricsson\SonyD5803XperiaZ3Compact($useragent);
        }

        if (preg_match('/d6603/i', $useragent)) {
            return new SonyEricsson\SonyD6603ExperiaZ3($useragent);
        }

        if (preg_match('/l50u/i', $useragent)) {
            return new SonyEricsson\SonyL50uExperiaZ2lte($useragent);
        }

        if (preg_match('/d6503/i', $useragent)) {
            return new SonyEricsson\SonyD6503ExperiaZ2($useragent);
        }

        if (preg_match('/d5833/i', $useragent)) {
            return new SonyEricsson\SonyD5833($useragent);
        }

        if (preg_match('/d5503/i', $useragent)) {
            return new SonyEricsson\SonyD5503XperiaZ1Compact($useragent);
        }

        if (preg_match('/d5303/i', $useragent)) {
            return new SonyEricsson\SonyD5303($useragent);
        }

        if (preg_match('/d2403/i', $useragent)) {
            return new SonyEricsson\SonyD2403($useragent);
        }

        if (preg_match('/d2306/i', $useragent)) {
            return new SonyEricsson\SonyD2306($useragent);
        }

        if (preg_match('/d2303/i', $useragent)) {
            return new SonyEricsson\SonyD2303($useragent);
        }

        if (preg_match('/d2302/i', $useragent)) {
            return new SonyEricsson\SonyD2302($useragent);
        }

        if (preg_match('/d2203/i', $useragent)) {
            return new SonyEricsson\SonyD2203($useragent);
        }

        if (preg_match('/d2105/i', $useragent)) {
            return new SonyEricsson\SonyD2105($useragent);
        }

        if (preg_match('/d2005/i', $useragent)) {
            return new SonyEricsson\SonyD2005($useragent);
        }

        if (preg_match('/SGPT13/i', $useragent)) {
            return new SonyEricsson\SonyTabletSgpt13($useragent);
        }

        if (preg_match('/sgpt12/i', $useragent)) {
            return new SonyEricsson\SonyTabletSgpt12($useragent);
        }

        if (preg_match('/SGP521/i', $useragent)) {
            return new SonyEricsson\SonyTabletSgp521($useragent);
        }

        if (preg_match('/SGP512/i', $useragent)) {
            return new SonyEricsson\SonyTabletSgp512($useragent);
        }

        if (preg_match('/SGP511/i', $useragent)) {
            return new SonyEricsson\SonyTabletSgp511($useragent);
        }

        if (preg_match('/SGP321/i', $useragent)) {
            return new SonyEricsson\SonyTabletSgp321($useragent);
        }

        if (preg_match('/SGP312/i', $useragent)) {
            return new SonyEricsson\SonyTabletSgp312($useragent);
        }

        if (preg_match('/SGP311/i', $useragent)) {
            return new SonyEricsson\SonyTabletSgp311($useragent);
        }

        if (preg_match('/ST26i/i', $useragent)) {
            return new SonyEricsson\SonyST26i($useragent);
        }

        if (preg_match('/ST26a/i', $useragent)) {
            return new SonyEricsson\SonyST26a($useragent);
        }

        if (preg_match('/ST23i/i', $useragent)) {
            return new SonyEricsson\SonyST23i($useragent);
        }

        if (preg_match('/ST21iv/i', $useragent)) {
            return new SonyEricsson\SonyST21iv($useragent);
        }

        if (preg_match('/ST21i2/i', $useragent)) {
            return new SonyEricsson\SonyST21i2($useragent);
        }

        if (preg_match('/ST21i/i', $useragent)) {
            return new SonyEricsson\SonyST21i($useragent);
        }

        if (preg_match('/(lt30p|xperia t)/i', $useragent)) {
            return new SonyEricsson\SonyLT30p($useragent);
        }

        if (preg_match('/LT29i/i', $useragent)) {
            return new SonyEricsson\SonyLT29i($useragent);
        }

        if (preg_match('/LT26w/i', $useragent)) {
            return new SonyEricsson\SonyLT26w($useragent);
        }

        if (preg_match('/LT25i/i', $useragent)) {
            return new SonyEricsson\SonyLT25i($useragent);
        }

        if (preg_match('/X10iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonX10iv($useragent);
        }

        if (preg_match('/X10i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonX10i($useragent);
        }

        if (preg_match('/X10a/i', $useragent)) {
            return new SonyEricsson\SonyEricssonX10a($useragent);
        }

        if (preg_match('/X10/i', $useragent)) {
            return new SonyEricsson\SonyEricssonX10($useragent);
        }

        if (preg_match('/U20iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonU20iv($useragent);
        }

        if (preg_match('/U20i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonU20i($useragent);
        }

        if (preg_match('/U20a/i', $useragent)) {
            return new SonyEricsson\SonyEricssonU20a($useragent);
        }

        if (preg_match('/ST27i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonST27i($useragent);
        }

        if (preg_match('/ST25iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonST25iv($useragent);
        }

        if (preg_match('/ST25i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonST25i($useragent);
        }

        if (preg_match('/ST18iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonST18iv($useragent);
        }

        if (preg_match('/ST18i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonST18i($useragent);
        }

        if (preg_match('/ST17i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonST17i($useragent);
        }

        if (preg_match('/ST15i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonST15i($useragent);
        }

        if (preg_match('/SO\-03E/i', $useragent)) {
            return new SonyEricsson\SonyEricssonSo03e($useragent);
        }

        if (preg_match('/SO\-03C/i', $useragent)) {
            return new SonyEricsson\SonyEricssonSo03c($useragent);
        }

        if (preg_match('/SO\-02D/i', $useragent)) {
            return new SonyEricsson\SonyEricssonSo02d($useragent);
        }

        if (preg_match('/SO\-02C/i', $useragent)) {
            return new SonyEricsson\SonyEricssonSo02c($useragent);
        }

        if (preg_match('/SK17iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonSK17iv($useragent);
        }

        if (preg_match('/SK17i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonSK17i($useragent);
        }

        if (preg_match('/R800iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonR800iv($useragent);
        }

        if (preg_match('/R800i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonR800i($useragent);
        }

        if (preg_match('/R800a/i', $useragent)) {
            return new SonyEricsson\SonyEricssonR800a($useragent);
        }

        if (preg_match('/MT27i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonMT27i($useragent);
        }

        if (preg_match('/MT15iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonMT15iv($useragent);
        }

        if (preg_match('/MT15i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonMT15i($useragent);
        }

        if (preg_match('/MT15a/i', $useragent)) {
            return new SonyEricsson\SonyEricssonMT15a($useragent);
        }

        if (preg_match('/MT11i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonMT11i($useragent);
        }

        if (preg_match('/MK16i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonMK16i($useragent);
        }

        if (preg_match('/MK16a/i', $useragent)) {
            return new SonyEricsson\SonyEricssonMK16a($useragent);
        }

        if (preg_match('/LT28h/i', $useragent)) {
            return new SonyEricsson\SonyEricssonLT28h($useragent);
        }

        if (preg_match('/LT28at/i', $useragent)) {
            return new SonyEricsson\SonyEricssonLT28at($useragent);
        }

        if (preg_match('/LT26ii/i', $useragent)) {
            return new SonyEricsson\SonyEricssonLT26ii($useragent);
        }

        if (preg_match('/LT26i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonLT26i($useragent);
        }

        if (preg_match('/LT22i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonLT22i($useragent);
        }

        if (preg_match('/LT18iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonLT18iv($useragent);
        }

        if (preg_match('/LT18i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonLT18i($useragent);
        }

        if (preg_match('/LT18a/i', $useragent)) {
            return new SonyEricsson\SonyEricssonLT18a($useragent);
        }

        if (preg_match('/LT18/i', $useragent)) {
            return new SonyEricsson\SonyEricssonLT18($useragent);
        }

        if (preg_match('/LT15iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonLT15iv($useragent);
        }

        if (preg_match('/LT15i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonLT15i($useragent);
        }

        if (preg_match('/E15iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonE15iv($useragent);
        }

        if (preg_match('/E15i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonE15i($useragent);
        }

        if (preg_match('/E15av/i', $useragent)) {
            return new SonyEricsson\SonyEricssonE15av($useragent);
        }

        if (preg_match('/E15a/i', $useragent)) {
            return new SonyEricsson\SonyEricssonE15a($useragent);
        }

        if (preg_match('/E10iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonE10iv($useragent);
        }

        if (preg_match('/E10i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonE10i($useragent);
        }

        if (preg_match('/Tablet S/i', $useragent)) {
            return new SonyEricsson\SonyTabletS($useragent);
        }

        if (preg_match('/Tablet P/i', $useragent)) {
            return new SonyEricsson\SonyTabletP($useragent);
        }

        if (preg_match('/Netbox/i', $useragent)) {
            return new SonyEricsson\SonyNetbox($useragent);
        }

        if (preg_match('/XST2/i', $useragent)) {
            return new SonyEricsson\SonyEricssonXST2($useragent);
        }

        if (preg_match('/X2/i', $useragent)) {
            return new SonyEricsson\SonyEricssonX2($useragent);
        }

        if (preg_match('/X1i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonX1i($useragent);
        }

        if (preg_match('/WT19iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonWT19iv($useragent);
        }

        if (preg_match('/WT19i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonWT19i($useragent);
        }

        if (preg_match('/WT19a/i', $useragent)) {
            return new SonyEricsson\SonyEricssonWT19a($useragent);
        }

        if (preg_match('/WT13i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonWT13i($useragent);
        }

        if (preg_match('/W995/i', $useragent)) {
            return new SonyEricsson\SonyEricssonW995($useragent);
        }

        if (preg_match('/W910i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonW910i($useragent);
        }

        if (preg_match('/W890i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonW890i($useragent);
        }

        if (preg_match('/W760i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonW760i($useragent);
        }

        if (preg_match('/W715v/i', $useragent)) {
            return new SonyEricsson\SonyEricssonW715v($useragent);
        }

        if (preg_match('/W595/i', $useragent)) {
            return new SonyEricsson\SonyEricssonW595($useragent);
        }

        if (preg_match('/W580i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonW580i($useragent);
        }

        if (preg_match('/W508a/i', $useragent)) {
            return new SonyEricsson\SonyEricssonW508a($useragent);
        }

        if (preg_match('/W200i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonW200i($useragent);
        }

        if (preg_match('/W150i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonW150i($useragent);
        }

        if (preg_match('/W20i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonW20i($useragent);
        }

        if (preg_match('/U10i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonU10i($useragent);
        }

        if (preg_match('/U8i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonU8i($useragent);
        }

        if (preg_match('/U5i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonU5i($useragent);
        }

        if (preg_match('/U1iv/i', $useragent)) {
            return new SonyEricsson\SonyEricssonU1iv($useragent);
        }

        if (preg_match('/U1i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonU1i($useragent);
        }

        if (preg_match('/U1/i', $useragent)) {
            return new SonyEricsson\SonyEricssonU1($useragent);
        }

        if (preg_match('/SO\-01D/i', $useragent)) {
            return new SonyEricsson\SonyEricssonSo01d($useragent);
        }

        if (preg_match('/SO\-01C/i', $useragent)) {
            return new SonyEricsson\SonyEricssonSo01c($useragent);
        }

        if (preg_match('/SO\-01B/i', $useragent)) {
            return new SonyEricsson\SonyEricssonSo01b($useragent);
        }

        if (preg_match('/SonyEricssonSO/i', $useragent)) {
            return new SonyEricsson\SonyEricssonSo($useragent);
        }

        if (preg_match('/S500i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonS500i($useragent);
        }

        if (preg_match('/S312/i', $useragent)) {
            return new SonyEricsson\SonyEricssonS312($useragent);
        }

        if (preg_match('/R800x/i', $useragent)) {
            return new SonyEricsson\SonyEricssonR800x($useragent);
        }

        if (preg_match('/K810i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonK810i($useragent);
        }

        if (preg_match('/k800i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonK800i($useragent);
        }

        if (preg_match('/k790i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonK790i($useragent);
        }

        if (preg_match('/J300/i', $useragent)) {
            return new SonyEricsson\SonyEricssonJ300($useragent);
        }

        if (preg_match('/J108i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonJ108i($useragent);
        }

        if (preg_match('/J20i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonJ20i($useragent);
        }

        if (preg_match('/J10i2/i', $useragent)) {
            return new SonyEricsson\SonyEricssonJ10i2($useragent);
        }

        if (preg_match('/G700/i', $useragent)) {
            return new SonyEricsson\SonyEricssonG700($useragent);
        }

        if (preg_match('/CK15i/i', $useragent)) {
            return new SonyEricsson\SonyEricssonCK15i($useragent);
        }

        if (preg_match('/C905/i', $useragent)) {
            return new SonyEricsson\SonyEricssonC905($useragent);
        }

        if (preg_match('/C902/i', $useragent)) {
            return new SonyEricsson\SonyEricssonC902($useragent);
        }

        if (preg_match('/A5000/i', $useragent)) {
            return new SonyEricsson\SonyA5000($useragent);
        }

        if (preg_match('/EBRD1201/i', $useragent)) {
            return new SonyEricsson\Ebrd1201($useragent);
        }

        if (preg_match('/EBRD1101/i', $useragent)) {
            return new SonyEricsson\Ebrd1101($useragent);
        }

        if (preg_match('/PlayStation Vita/i', $useragent)) {
            return new SonyEricsson\PlayStationVita($useragent);
        }

        if (preg_match('/(PlayStation Portable|PSP)/i', $useragent)) {
            return new SonyEricsson\PlayStationPortable($useragent);
        }

        if (preg_match('/PlayStation 4/i', $useragent)) {
            return new SonyEricsson\PlayStation4($useragent);
        }

        if (preg_match('/PLAYSTATION 3/i', $useragent)) {
            return new SonyEricsson\PlayStation3($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        if (preg_match('/Xperia S/i', $useragent)) {
            return new SonyEricsson\SonyXperiaS($useragent);
        }

        return new SonyEricsson\SonyEricsson($useragent);
    }
}
