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
        if (preg_match('/x150/i', $useragent)) {
            return new Lg\Lgx150($useragent);
        }

        if (preg_match('/h850/i', $useragent)) {
            return new Lg\LgH850($useragent);
        }

        if (preg_match('/h345/i', $useragent)) {
            return new Lg\LgH345($useragent);
        }

        if (preg_match('/h320/i', $useragent)) {
            return new Lg\LgH320($useragent);
        }

        if (preg_match('/vs980/i', $useragent)) {
            return new Lg\LgVs980($useragent);
        }

        if (preg_match('/vs880/i', $useragent)) {
            return new Lg\LgVs880($useragent);
        }

        if (preg_match('/vs840/i', $useragent)) {
            return new Lg\LgVs840($useragent);
        }

        if (preg_match('/vs700/i', $useragent)) {
            return new Lg\LgVs700($useragent);
        }

        if (preg_match('/vm701/i', $useragent)) {
            return new Lg\LgVm701($useragent);
        }

        if (preg_match('/vm670/i', $useragent)) {
            return new Lg\LgVm670($useragent);
        }

        if (preg_match('/v935/i', $useragent)) {
            return new Lg\Lgv935($useragent);
        }

        if (preg_match('/v900/i', $useragent)) {
            return new Lg\Lgv900($useragent);
        }

        if (preg_match('/v700/i', $useragent)) {
            return new Lg\Lgv700($useragent);
        }

        if (preg_match('/v500/i', $useragent)) {
            return new Lg\Lgv500($useragent);
        }

        if (preg_match('/v490/i', $useragent)) {
            return new Lg\Lgv490($useragent);
        }

        if (preg_match('/t500/i', $useragent)) {
            return new Lg\Lgt500($useragent);
        }

        if (preg_match('/t385/i', $useragent)) {
            return new Lg\Lgt385($useragent);
        }

        if (preg_match('/t300/i', $useragent)) {
            return new Lg\Lgt300($useragent);
        }

        if (preg_match('/su760/i', $useragent)) {
            return new Lg\LgSu760($useragent);
        }

        if (preg_match('/su660/i', $useragent)) {
            return new Lg\LgSu660($useragent);
        }

        if (preg_match('/p999/i', $useragent)) {
            return new Lg\Lgp999($useragent);
        }

        if (preg_match('/(p990|optimus 2x)/i', $useragent)) {
            return new Lg\Lgp990($useragent);
        }

        if (preg_match('/(p970|optimus\-black)/i', $useragent)) {
            return new Lg\Lgp970($useragent);
        }

        if (preg_match('/p940/i', $useragent)) {
            return new Lg\Lgp940($useragent);
        }

        if (preg_match('/p936/i', $useragent)) {
            return new Lg\Lgp936($useragent);
        }

        if (preg_match('/p925/i', $useragent)) {
            return new Lg\Lgp925($useragent);
        }

        if (preg_match('/p920/i', $useragent)) {
            return new Lg\Lgp920($useragent);
        }

        if (preg_match('/p895/i', $useragent)) {
            return new Lg\LgP895($useragent);
        }

        if (preg_match('/p880/i', $useragent)) {
            return new Lg\LgP880($useragent);
        }

        if (preg_match('/p875/i', $useragent)) {
            return new Lg\Lgp875($useragent);
        }

        if (preg_match('/p760/i', $useragent)) {
            return new Lg\Lgp760($useragent);
        }

        if (preg_match('/p720/i', $useragent)) {
            return new Lg\Lgp720($useragent);
        }

        if (preg_match('/p713/i', $useragent)) {
            return new Lg\Lgp713($useragent);
        }

        if (preg_match('/p710/i', $useragent)) {
            return new Lg\Lgp710($useragent);
        }

        if (preg_match('/p705/i', $useragent)) {
            return new Lg\Lgp705($useragent);
        }

        if (preg_match('/p700/i', $useragent)) {
            return new Lg\Lgp700($useragent);
        }

        if (preg_match('/p698/i', $useragent)) {
            return new Lg\Lgp698($useragent);
        }

        if (preg_match('/p690/i', $useragent)) {
            return new Lg\Lgp690($useragent);
        }

        if (preg_match('/(p509|optimus\-t)/i', $useragent)) {
            return new Lg\Lgp509($useragent);
        }

        if (preg_match('/p505r/i', $useragent)) {
            return new Lg\Lgp505r($useragent);
        }

        if (preg_match('/p505/i', $useragent)) {
            return new Lg\Lgp505($useragent);
        }

        if (preg_match('/p500h/i', $useragent)) {
            return new Lg\Lgp500h($useragent);
        }

        if (preg_match('/p500/i', $useragent)) {
            return new Lg\Lgp500($useragent);
        }

        if (preg_match('/p350/i', $useragent)) {
            return new Lg\Lgp350($useragent);
        }

        if (preg_match('/nexus 5x/i', $useragent)) {
            return new Lg\LgNexus5x($useragent);
        }

        if (preg_match('/nexus 5/i', $useragent)) {
            return new Lg\LgNexus5($useragent);
        }

        if (preg_match('/nexus 4/i', $useragent)) {
            return new Lg\LgNexus4($useragent);
        }

        if (preg_match('/ms690/i', $useragent)) {
            return new Lg\Lgms690($useragent);
        }

        if (preg_match('/ls860/i', $useragent)) {
            return new Lg\LgLs860($useragent);
        }

        if (preg_match('/ls740/i', $useragent)) {
            return new Lg\LgLs740($useragent);
        }

        if (preg_match('/ls670/i', $useragent)) {
            return new Lg\LgLs670($useragent);
        }

        if (preg_match('/ln510/i', $useragent)) {
            return new Lg\LgLn510($useragent);
        }

        if (preg_match('/l160l/i', $useragent)) {
            return new Lg\LgL160l($useragent);
        }

        if (preg_match('/ku800/i', $useragent)) {
            return new Lg\LgKu800($useragent);
        }

        if (preg_match('/ks365/i', $useragent)) {
            return new Lg\LgKs365($useragent);
        }

        if (preg_match('/ks20/i', $useragent)) {
            return new Lg\LgKs20($useragent);
        }

        if (preg_match('/kp500/i', $useragent)) {
            return new Lg\LgKp500($useragent);
        }

        if (preg_match('/km900/i', $useragent)) {
            return new Lg\LgKm900($useragent);
        }

        if (preg_match('/kc910/i', $useragent)) {
            return new Lg\LgKc910($useragent);
        }

        if (preg_match('/hb620t/i', $useragent)) {
            return new Lg\LgHb620t($useragent);
        }

        if (preg_match('/gw300/i', $useragent)) {
            return new Lg\LgGw300($useragent);
        }

        if (preg_match('/gt550/i', $useragent)) {
            return new Lg\LgGt550($useragent);
        }

        if (preg_match('/gt540/i', $useragent)) {
            return new Lg\LgGt540($useragent);
        }

        if (preg_match('/gs290/i', $useragent)) {
            return new Lg\LgGs290($useragent);
        }

        if (preg_match('/gm360/i', $useragent)) {
            return new Lg\LgGm360($useragent);
        }

        if (preg_match('/gd880/i', $useragent)) {
            return new Lg\LgGd880($useragent);
        }

        if (preg_match('/gd350/i', $useragent)) {
            return new Lg\LgGd350($useragent);
        }

        if (preg_match('/ g3 /i', $useragent)) {
            return new Lg\LgG3($useragent);
        }

        if (preg_match('/f240s/i', $useragent)) {
            return new Lg\LgF240s($useragent);
        }

        if (preg_match('/f240k/i', $useragent)) {
            return new Lg\LgF240k($useragent);
        }

        if (preg_match('/f200k/i', $useragent)) {
            return new Lg\LgF200K($useragent);
        }

        if (preg_match('/f160k/i', $useragent)) {
            return new Lg\LgF160K($useragent);
        }

        if (preg_match('/f100s/i', $useragent)) {
            return new Lg\Lgf100s($useragent);
        }

        if (preg_match('/f100l/i', $useragent)) {
            return new Lg\LgF100L($useragent);
        }

        if (preg_match('/eve/i', $useragent)) {
            return new Lg\LgEve($useragent);
        }

        if (preg_match('/e988/i', $useragent)) {
            return new Lg\Lge988($useragent);
        }

        if (preg_match('/e980h/i', $useragent)) {
            return new Lg\Lge980h($useragent);
        }

        if (preg_match('/e975/i', $useragent)) {
            return new Lg\Lge975($useragent);
        }

        if (preg_match('/e970/i', $useragent)) {
            return new Lg\Lge970($useragent);
        }

        if (preg_match('/e906/i', $useragent)) {
            return new Lg\LgE906($useragent);
        }

        if (preg_match('/e900/i', $useragent)) {
            return new Lg\Lge900($useragent);
        }

        if (preg_match('/e739/i', $useragent)) {
            return new Lg\Lge739($useragent);
        }

        if (preg_match('/e730/i', $useragent)) {
            return new Lg\Lge730($useragent);
        }

        if (preg_match('/e720/i', $useragent)) {
            return new Lg\Lge720($useragent);
        }

        if (preg_match('/e610/i', $useragent)) {
            return new Lg\Lge610($useragent);
        }

        if (preg_match('/e510/i', $useragent)) {
            return new Lg\Lge510($useragent);
        }

        if (preg_match('/e460/i', $useragent)) {
            return new Lg\Lge460($useragent);
        }

        if (preg_match('/e440/i', $useragent)) {
            return new Lg\Lge440($useragent);
        }

        if (preg_match('/e430/i', $useragent)) {
            return new Lg\Lge430($useragent);
        }

        if (preg_match('/e400/i', $useragent)) {
            return new Lg\Lge400($useragent);
        }

        if (preg_match('/d955/i', $useragent)) {
            return new Lg\Lgd955($useragent);
        }

        if (preg_match('/d855/i', $useragent)) {
            return new Lg\Lgd855($useragent);
        }

        if (preg_match('/d805/i', $useragent)) {
            return new Lg\Lgd805($useragent);
        }

        if (preg_match('/d802tr/i', $useragent)) {
            return new Lg\Lgd802tr($useragent);
        }

        if (preg_match('/d802/i', $useragent)) {
            return new Lg\Lgd802($useragent);
        }

        if (preg_match('/d724/i', $useragent)) {
            return new Lg\Lgd724($useragent);
        }

        if (preg_match('/d722/i', $useragent)) {
            return new Lg\Lgd722($useragent);
        }

        if (preg_match('/d686/i', $useragent)) {
            return new Lg\LgD686($useragent);
        }

        if (preg_match('/d618/i', $useragent)) {
            return new Lg\LgD618($useragent);
        }

        if (preg_match('/d605/i', $useragent)) {
            return new Lg\Lgd605($useragent);
        }

        if (preg_match('/d373/i', $useragent)) {
            return new Lg\Lgd373($useragent);
        }

        if (preg_match('/d320/i', $useragent)) {
            return new Lg\Lgd320($useragent);
        }

        if (preg_match('/d300/i', $useragent)) {
            return new Lg\Lgd300($useragent);
        }

        if (preg_match('/d295/i', $useragent)) {
            return new Lg\Lgd295($useragent);
        }

        if (preg_match('/d290/i', $useragent)) {
            return new Lg\Lgd290($useragent);
        }

        if (preg_match('/d285/i', $useragent)) {
            return new Lg\Lgd285($useragent);
        }

        if (preg_match('/d280/i', $useragent)) {
            return new Lg\Lgd280($useragent);
        }

        if (preg_match('/d213/i', $useragent)) {
            return new Lg\Lgd213($useragent);
        }

        if (preg_match('/d160/i', $useragent)) {
            return new Lg\Lgd160($useragent);
        }

        if (preg_match('/c660/i', $useragent)) {
            return new Lg\Lgc660($useragent);
        }

        if (preg_match('/c550/i', $useragent)) {
            return new Lg\Lgc550($useragent);
        }

        if (preg_match('/c330/i', $useragent)) {
            return new Lg\Lgc330($useragent);
        }

        if (preg_match('/c199/i', $useragent)) {
            return new Lg\Lgc199($useragent);
        }

        if (preg_match('/bl40/i', $useragent)) {
            return new Lg\LgBl40($useragent);
        }

        if (preg_match('/lg900g/i', $useragent)) {
            return new Lg\Lg900g($useragent);
        }

        if (preg_match('/lg220c/i', $useragent)) {
            return new Lg\Lg220c($useragent);
        }

        return new Lg\Lg($useragent);
    }
}
