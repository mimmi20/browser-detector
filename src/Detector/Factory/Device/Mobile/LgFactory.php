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

use BrowserDetector\Detector\Device\Mobile\Lg;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class LgFactory implements FactoryInterface
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
        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS880/i', $useragent)) {
            return new Lg\LgVs880($useragent, []);
        }

        if (preg_match('/VS840/i', $useragent)) {
            return new Lg\LgVs840($useragent, []);
        }

        if (preg_match('/VS700/i', $useragent)) {
            return new Lg\LgVs700($useragent, []);
        }

        if (preg_match('/VM701/i', $useragent)) {
            return new Lg\LgVm701($useragent, []);
        }

        if (preg_match('/VM670/i', $useragent)) {
            return new Lg\LgVm670($useragent, []);
        }

        if (preg_match('/V900/i', $useragent)) {
            return new Lg\Lgv900($useragent, []);
        }

        if (preg_match('/V700/i', $useragent)) {
            return new Lg\Lgv700($useragent, []);
        }

        if (preg_match('/V500/i', $useragent)) {
            return new Lg\Lgv500($useragent, []);
        }

        if (preg_match('/V490/i', $useragent)) {
            return new Lg\Lgv490($useragent, []);
        }

        if (preg_match('/T500/i', $useragent)) {
            return new Lg\Lgt500($useragent, []);
        }

        if (preg_match('/T385/i', $useragent)) {
            return new Lg\Lgt385($useragent, []);
        }

        if (preg_match('/T300/i', $useragent)) {
            return new Lg\Lgt300($useragent, []);
        }

        if (preg_match('/SU760/i', $useragent)) {
            return new Lg\LgSu760($useragent, []);
        }

        if (preg_match('/SU660/i', $useragent)) {
            return new Lg\LgSu660($useragent, []);
        }

        if (preg_match('/P999/i', $useragent)) {
            return new Lg\Lgp999($useragent, []);
        }

        if (preg_match('/(P990|Optimus 2X)/i', $useragent)) {
            return new Lg\Lgp990($useragent, []);
        }

        if (preg_match('/(P970|Optimus\-Black)/i', $useragent)) {
            return new Lg\Lgp970($useragent, []);
        }

        if (preg_match('/P940/i', $useragent)) {
            return new Lg\Lgp940($useragent, []);
        }

        if (preg_match('/P936/i', $useragent)) {
            return new Lg\Lgp936($useragent, []);
        }

        if (preg_match('/P925/i', $useragent)) {
            return new Lg\Lgp925($useragent, []);
        }

        if (preg_match('/P920/i', $useragent)) {
            return new Lg\Lgp920($useragent, []);
        }

        if (preg_match('/P895/i', $useragent)) {
            return new Lg\LgP895($useragent, []);
        }

        if (preg_match('/P880/i', $useragent)) {
            return new Lg\LgP880($useragent, []);
        }

        if (preg_match('/P875/i', $useragent)) {
            return new Lg\Lgp875($useragent, []);
        }

        if (preg_match('/P760/i', $useragent)) {
            return new Lg\Lgp760($useragent, []);
        }

        if (preg_match('/P720/i', $useragent)) {
            return new Lg\Lgp720($useragent, []);
        }

        if (preg_match('/P713/i', $useragent)) {
            return new Lg\Lgp713($useragent, []);
        }

        if (preg_match('/P710/i', $useragent)) {
            return new Lg\Lgp710($useragent, []);
        }

        if (preg_match('/P705/i', $useragent)) {
            return new Lg\Lgp705($useragent, []);
        }

        if (preg_match('/P700/i', $useragent)) {
            return new Lg\Lgp700($useragent, []);
        }

        if (preg_match('/P698/i', $useragent)) {
            return new Lg\Lgp698($useragent, []);
        }

        if (preg_match('/P690/i', $useragent)) {
            return new Lg\Lgp690($useragent, []);
        }

        if (preg_match('/(P509|Optimus\-T)/i', $useragent)) {
            return new Lg\Lgp509($useragent, []);
        }

        if (preg_match('/P505R/i', $useragent)) {
            return new Lg\Lgp505r($useragent, []);
        }

        if (preg_match('/P505/i', $useragent)) {
            return new Lg\Lgp505($useragent, []);
        }

        if (preg_match('/P500h/i', $useragent)) {
            return new Lg\Lgp500h($useragent, []);
        }

        if (preg_match('/P500/i', $useragent)) {
            return new Lg\Lgp500($useragent, []);
        }

        if (preg_match('/P350/i', $useragent)) {
            return new Lg\Lgp350($useragent, []);
        }

        if (preg_match('/Nexus 5/i', $useragent)) {
            return new Lg\LgNexus5($useragent, []);
        }

        if (preg_match('/Nexus 4/i', $useragent)) {
            return new Lg\LgNexus4($useragent, []);
        }

        if (preg_match('/MS690/i', $useragent)) {
            return new Lg\Lgms690($useragent, []);
        }

        if (preg_match('/LS860/i', $useragent)) {
            return new Lg\LgLs860($useragent, []);
        }

        if (preg_match('/LS740/i', $useragent)) {
            return new Lg\LgLs740($useragent, []);
        }

        if (preg_match('/LS670/i', $useragent)) {
            return new Lg\LgLs670($useragent, []);
        }

        if (preg_match('/LN510/i', $useragent)) {
            return new Lg\LgLn510($useragent, []);
        }

        if (preg_match('/L160L/i', $useragent)) {
            return new Lg\LgL160l($useragent, []);
        }

        if (preg_match('/KU800/i', $useragent)) {
            return new Lg\LgKu800($useragent, []);
        }

        if (preg_match('/KS365/i', $useragent)) {
            return new Lg\LgKs365($useragent, []);
        }

        if (preg_match('/KS20/i', $useragent)) {
            return new Lg\LgKs20($useragent, []);
        }

        if (preg_match('/KP500/i', $useragent)) {
            return new Lg\LgKp500($useragent, []);
        }

        if (preg_match('/KM900/i', $useragent)) {
            return new Lg\LgKm900($useragent, []);
        }

        if (preg_match('/KC910/i', $useragent)) {
            return new Lg\LgKc910($useragent, []);
        }

        if (preg_match('/HB620T/i', $useragent)) {
            return new Lg\LgHb620t($useragent, []);
        }

        if (preg_match('/GW300/i', $useragent)) {
            return new Lg\LgGw300($useragent, []);
        }

        if (preg_match('/GT550/i', $useragent)) {
            return new Lg\LgGt550($useragent, []);
        }

        if (preg_match('/GT540/i', $useragent)) {
            return new Lg\LgGt540($useragent, []);
        }

        if (preg_match('/GS290/i', $useragent)) {
            return new Lg\LgGs290($useragent, []);
        }

        if (preg_match('/GM360/i', $useragent)) {
            return new Lg\LgGm360($useragent, []);
        }

        if (preg_match('/GD880/i', $useragent)) {
            return new Lg\LgGd880($useragent, []);
        }

        if (preg_match('/GD350/i', $useragent)) {
            return new Lg\LgGd350($useragent, []);
        }

        if (preg_match('/ G3 /i', $useragent)) {
            return new Lg\LgG3($useragent, []);
        }

        if (preg_match('/F240S/i', $useragent)) {
            return new Lg\LgF240s($useragent, []);
        }

        if (preg_match('/F200K/i', $useragent)) {
            return new Lg\LgF200K($useragent, []);
        }

        if (preg_match('/F160K/i', $useragent)) {
            return new Lg\LgF160K($useragent, []);
        }

        if (preg_match('/F100S/i', $useragent)) {
            return new Lg\Lgf100s($useragent, []);
        }

        if (preg_match('/F100L/i', $useragent)) {
            return new Lg\LgF100L($useragent, []);
        }

        if (preg_match('/Eve/i', $useragent)) {
            return new Lg\LgEve($useragent, []);
        }

        if (preg_match('/E988/i', $useragent)) {
            return new Lg\Lge988($useragent, []);
        }

        if (preg_match('/E980h/i', $useragent)) {
            return new Lg\Lge980h($useragent, []);
        }

        if (preg_match('/E975/i', $useragent)) {
            return new Lg\Lge975($useragent, []);
        }

        if (preg_match('/E970/i', $useragent)) {
            return new Lg\Lge970($useragent, []);
        }

        if (preg_match('/E906/i', $useragent)) {
            return new Lg\LgE906($useragent, []);
        }

        if (preg_match('/E900/i', $useragent)) {
            return new Lg\Lge900($useragent, []);
        }

        if (preg_match('/E739/i', $useragent)) {
            return new Lg\Lge739($useragent, []);
        }

        if (preg_match('/E730/i', $useragent)) {
            return new Lg\Lge730($useragent, []);
        }

        if (preg_match('/E720/i', $useragent)) {
            return new Lg\Lge720($useragent, []);
        }

        if (preg_match('/E610/i', $useragent)) {
            return new Lg\Lge610($useragent, []);
        }

        if (preg_match('/E510/i', $useragent)) {
            return new Lg\Lge510($useragent, []);
        }

        if (preg_match('/E460/i', $useragent)) {
            return new Lg\Lge460($useragent, []);
        }

        if (preg_match('/E440/i', $useragent)) {
            return new Lg\Lge440($useragent, []);
        }

        if (preg_match('/E430/i', $useragent)) {
            return new Lg\Lge430($useragent, []);
        }

        if (preg_match('/E400/i', $useragent)) {
            return new Lg\Lge400($useragent, []);
        }

        if (preg_match('/D955/i', $useragent)) {
            return new Lg\Lgd955($useragent, []);
        }

        if (preg_match('/D855/i', $useragent)) {
            return new Lg\Lgd855($useragent, []);
        }

        if (preg_match('/D805/i', $useragent)) {
            return new Lg\Lgd805($useragent, []);
        }

        if (preg_match('/D802/i', $useragent)) {
            return new Lg\Lgd802($useragent, []);
        }

        if (preg_match('/D724/i', $useragent)) {
            return new Lg\Lgd724($useragent, []);
        }

        if (preg_match('/D722/i', $useragent)) {
            return new Lg\Lgd722($useragent, []);
        }

        if (preg_match('/D618/i', $useragent)) {
            return new Lg\LgD618($useragent, []);
        }

        if (preg_match('/D605/i', $useragent)) {
            return new Lg\Lgd605($useragent, []);
        }

        if (preg_match('/D320/i', $useragent)) {
            return new Lg\Lgd320($useragent, []);
        }

        if (preg_match('/D300/i', $useragent)) {
            return new Lg\Lgd300($useragent, []);
        }

        if (preg_match('/D295/i', $useragent)) {
            return new Lg\Lgd295($useragent, []);
        }

        if (preg_match('/D285/i', $useragent)) {
            return new Lg\Lgd285($useragent, []);
        }

        if (preg_match('/D280/i', $useragent)) {
            return new Lg\Lgd280($useragent, []);
        }

        if (preg_match('/D213/i', $useragent)) {
            return new Lg\Lgd213($useragent, []);
        }

        if (preg_match('/D160/i', $useragent)) {
            return new Lg\Lgd160($useragent, []);
        }

        if (preg_match('/C660/i', $useragent)) {
            return new Lg\Lgc660($useragent, []);
        }

        if (preg_match('/C550/i', $useragent)) {
            return new Lg\Lgc550($useragent, []);
        }

        if (preg_match('/C330/i', $useragent)) {
            return new Lg\Lgc330($useragent, []);
        }

        if (preg_match('/C199/i', $useragent)) {
            return new Lg\Lgc199($useragent, []);
        }

        if (preg_match('/BL40/i', $useragent)) {
            return new Lg\LgBl40($useragent, []);
        }

        if (preg_match('/LG900G/i', $useragent)) {
            return new Lg\Lg900g($useragent, []);
        }

        if (preg_match('/LG220C/i', $useragent)) {
            return new Lg\Lg220c($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        if (preg_match('/VS980/i', $useragent)) {
            return new Lg\LgVs980($useragent, []);
        }

        return new Lg\Lg($useragent, []);
    }
}
