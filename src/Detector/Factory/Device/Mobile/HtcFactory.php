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

use BrowserDetector\Detector\Device\Mobile\Htc;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class HtcFactory implements FactoryInterface
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
        if (preg_match('/ X9 /', $useragent)) {
            return new Htc\HtcX9($useragent);
        }

        if (preg_match('/(Nexus[ \-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent);
        }

        if (preg_match('/Nexus 9/i', $useragent)) {
            return new Htc\HtcNexus9($useragent);
        }

        if (preg_match('/nexus(hd2| evohd2)/i', $useragent)) {
            return new Htc\HtcNexusHd2($useragent);
        }

        if (preg_match('/8X by HTC/i', $useragent)) {
            return new Htc\Htc8x($useragent);
        }

        if (preg_match('/PM23300/', $useragent)) {
            return new Htc\Htc8x($useragent);
        }

        if (preg_match('/8S by HTC/i', $useragent)) {
            return new Htc\Htc8s($useragent);
        }

        if (preg_match('/radar( c110e|; orange)/i', $useragent)) {
            return new Htc\HtcC110eRadar($useragent);
        }

        if (preg_match('/radar 4g/i', $useragent)) {
            return new Htc\HtcRadar4G($useragent);
        }

        if (preg_match('/radar/i', $useragent)) {
            return new Htc\HtcRadar($useragent);
        }

        if (preg_match('/(HD7|Mondrian)/i', $useragent)) {
            return new Htc\HtcT9292($useragent);
        }

        if (preg_match('/7 Mozart/i', $useragent)) {
            return new Htc\HtcT8698($useragent);
        }

        if (preg_match('/t8282/i', $useragent)) {
            return new Htc\HtcTouchHdT8282($useragent);
        }

        if (preg_match('/7 Pro T7576/i', $useragent)) {
            return new Htc\HtcT7576($useragent);
        }

        if (preg_match('/HD2\_T8585/i', $useragent)) {
            return new Htc\HtcHd2T8585($useragent);
        }

        if (preg_match('/HD2/', $useragent) && preg_match('/android/i', $useragent)) {
            return new Htc\HtcHd2Android($useragent);
        }

        if (preg_match('/HD2/', $useragent)) {
            return new Htc\HtcHd2($useragent);
        }

        if (preg_match('/(HD[ |\_]mini)/i', $useragent)) {
            return new Htc\HtcHdMini($useragent);
        }

        if (preg_match('/titan/i', $useragent)) {
            return new Htc\HtcTitan($useragent);
        }

        if (preg_match('/(7 Trophy|mwp6985)/i', $useragent)) {
            return new Htc\HtcSpark($useragent);
        }

        if (preg_match('/0P6B180/i', $useragent)) {
            return new Htc\HtcOneM8Windows($useragent);
        }

        if (preg_match('/one[_ ]m9plus/i', $useragent)) {
            return new Htc\HtcOneM9plus($useragent);
        }

        if (preg_match('/one[_ ]m9/i', $useragent)) {
            return new Htc\HtcOneM9($useragent);
        }

        if (preg_match('/one\_m8/i', $useragent)) {
            return new Htc\HtcOneM8($useragent);
        }

        if (preg_match('/(one[ _]x\+|onexplus)/i', $useragent)) {
            return new Htc\HtcOneXplus($useragent);
        }

        if (preg_match('/one[ _]xl/i', $useragent)) {
            return new Htc\HtcOneXl($useragent);
        }

        if (preg_match('/(one[ _]x|onex|PJ83100)/i', $useragent)) {
            return new Htc\HtcOneX($useragent);
        }

        if (preg_match('/one[ _]v/i', $useragent)) {
            return new Htc\HtcOneV($useragent);
        }

        if (preg_match('/(one[ _]sv|onesv)/i', $useragent)) {
            return new Htc\HtcOneSv($useragent);
        }

        if (preg_match('/(one[ _]s|ones)/i', $useragent)) {
            return new Htc\HtcOneS($useragent);
        }

        if (preg_match('/one[ _]mini[ _]2/i', $useragent)) {
            return new Htc\HtcOneMini2($useragent);
        }

        if (preg_match('/one[ _]mini/i', $useragent)) {
            return new Htc\HtcOneMini($useragent);
        }

        if (preg_match('/(one[ _]max|himauhl_htc_asia_tw)/i', $useragent)) {
            return new Htc\HtcOneMax($useragent);
        }

        if (preg_match('/one/i', $useragent)) {
            return new Htc\HtcOne($useragent);
        }

        if (preg_match('/(Smart Tab III 7|SmartTabIII7)/i', $useragent)) {
            return new Htc\VodafoneSmartTabIii7($useragent);
        }

        if (preg_match('/(x315e|runnymede)/i', $useragent)) {
            return new Htc\HtcX315eSensationXlBeats($useragent);
        }

        if (preg_match('/sensation[ _]4g/i', $useragent)) {
            return new Htc\HtcSensation4g($useragent);
        }

        if (preg_match('/(sensationxl|sensation xl)/i', $useragent)) {
            return new Htc\HtcSensationXlBeats($useragent);
        }

        if (preg_match('/(sensation xe|sensationxe)/i', $useragent)) {
            return new Htc\HtcZ715eSensationXeBeats($useragent);
        }

        if (preg_match('/(HTC\_Sensation\-orange\-LS|HTC\_Sensation\-LS)/i', $useragent)) {
            return new Htc\HtcZ710SensationLs($useragent);
        }

        if (preg_match('/sensation[ _]z710e/i', $useragent)) {
            return new Htc\HtcZ710e($useragent);
        }

        if (preg_match('/(sensation|pyramid)/i', $useragent)) {
            return new Htc\HtcZ710($useragent);
        }

        if (preg_match('/Xda\_Diamond\_2/i', $useragent)) {
            return new Htc\HtcXdaDiamond2($useragent);
        }

        if (preg_match('/Evo 3D GSM/i', $useragent)) {
            return new Htc\HtcEvo3dGsm($useragent);
        }

        if (preg_match('/(EVO[ _]3D|EVO3D|x515m)/i', $useragent)) {
            return new Htc\HtcX515m($useragent);
        }

        if (preg_match('/x515e/i', $useragent)) {
            return new Htc\HtcX515e($useragent);
        }

        if (preg_match('/x515/i', $useragent)) {
            return new Htc\HtcX515($useragent);
        }

        if (preg_match('/desirez\_a7272/i', $useragent)) {
            return new Htc\HtcDesireZA7272($useragent);
        }

        if (preg_match('/(desire[ _]z|desirez)/i', $useragent)) {
            return new Htc\HtcDesireZ($useragent);
        }

        if (preg_match('/(desire[ _]x|desirex)/i', $useragent)) {
            return new Htc\HtcDesireX($useragent);
        }

        if (preg_match('/(desire[ _]v|desirev)/i', $useragent)) {
            return new Htc\HtcDesireV($useragent);
        }

        if (preg_match('/s510e/i', $useragent)) {
            return new Htc\HtcS510eDesireS($useragent);
        }

        if (preg_match('/(desire[ _]sv|desiresv)/i', $useragent)) {
            return new Htc\HtcDesireSv($useragent);
        }

        if (preg_match('/(desire[ _]s|desires)/i', $useragent)) {
            return new Htc\HtcDesireS($useragent);
        }

        if (preg_match('/desirehd\-orange\-ls/i', $useragent)) {
            return new Htc\HtcDesireHhLs($useragent);
        }

        if (preg_match('/a9191/i', $useragent)) {
            return new Htc\HtcA9191DesireHd($useragent);
        }

        if (preg_match('/(desire hd|desirehd)/i', $useragent)) {
            return new Htc\HtcDesireHd($useragent);
        }

        if (preg_match('/(desire[ _]c|desirec)/i', $useragent)) {
            return new Htc\HtcDesireC($useragent);
        }

        if (preg_match('/desire[ _]820/i', $useragent)) {
            return new Htc\HtcDesire820($useragent);
        }

        if (preg_match('/desire[ _]816g/i', $useragent)) {
            return new Htc\HtcDesire816g($useragent);
        }

        if (preg_match('/desire[ _]816/i', $useragent)) {
            return new Htc\HtcDesire816($useragent);
        }

        if (preg_match('/(0p4e2|desire[ _]601)/i', $useragent)) {
            return new Htc\Htc0p4e2($useragent);
        }

        if (preg_match('/desire[ _]700/i', $useragent)) {
            return new Htc\HtcDesire700($useragent);
        }

        if (preg_match('/desire[ _]610/i', $useragent)) {
            return new Htc\HtcDesire610($useragent);
        }

        if (preg_match('/desire[ _]600c/i', $useragent)) {
            return new Htc\HtcDesire600c($useragent);
        }

        if (preg_match('/desire[ _]600/i', $useragent)) {
            return new Htc\HtcDesire600($useragent);
        }

        if (preg_match('/desire[ _]516/i', $useragent)) {
            return new Htc\HtcDesire516($useragent);
        }

        if (preg_match('/desire[ _]500/i', $useragent)) {
            return new Htc\HtcDesire500($useragent);
        }

        if (preg_match('/desire[ _]400/i', $useragent)) {
            return new Htc\HtcDesire400($useragent);
        }

        if (preg_match('/desire[ _]310/i', $useragent)) {
            return new Htc\HtcDesire310($useragent);
        }

        if (preg_match('/desire[ _]300/i', $useragent)) {
            return new Htc\HtcDesire300($useragent);
        }

        if (preg_match('/desire[_ ]eye/i', $useragent)) {
            return new Htc\HtcDesireEye($useragent);
        }

        if (preg_match('/desire\_a8181/i', $useragent)) {
            return new Htc\HtcA8181Desire($useragent);
        }

        if (preg_match('/desire/i', $useragent)) {
            return new Htc\HtcDesire($useragent);
        }

        if (preg_match('/WildfireS\-orange\-LS|WildfireS\-LS/i', $useragent)) {
            return new Htc\HtcWildfireSLs($useragent);
        }

        if (preg_match('/ a315c /i', $useragent)) {
            return new Htc\HtcA315c($useragent);
        }

        if (preg_match('/Wildfire\_A3333/i', $useragent)) {
            return new Htc\HtcA3333($useragent);
        }

        if (preg_match('/(Wildfire S A510e|WildfireS_A510e)/i', $useragent)) {
            return new Htc\HtcA510e($useragent);
        }

        if (preg_match('/ADR6230/i', $useragent)) {
            return new Htc\HtcAdr6230($useragent);
        }

        if (preg_match('/Wildfire[ |]S/i', $useragent)) {
            return new Htc\HtcA510($useragent);
        }

        if (preg_match('/Wildfire/i', $useragent)) {
            return new Htc\HtcWildfire($useragent);
        }

        if (preg_match('/Vision/i', $useragent)) {
            return new Htc\HtcVision($useragent);
        }

        if (preg_match('/velocity[ _]4g[ _]x710s/i', $useragent)) {
            return new Htc\HtcVelocity4GX710s($useragent);
        }

        if (preg_match('/velocity[ _]4g/i', $useragent)) {
            return new Htc\HtcVelocity4G($useragent);
        }

        if (preg_match('/Velocity/i', $useragent)) {
            return new Htc\HtcVelocity($useragent);
        }

        if (preg_match('/Touch\_Diamond2/i', $useragent)) {
            return new Htc\HtcTouchDiamond2($useragent);
        }

        if (preg_match('/tattoo/i', $useragent)) {
            return new Htc\HtcTattoo($useragent);
        }

        if (preg_match('/Touch\_Pro2\_T7373/i', $useragent)) {
            return new Htc\HtcT7373($useragent);
        }

        if (preg_match('/Touch2/i', $useragent)) {
            return new Htc\HtcT3335($useragent);
        }

        if (preg_match('/t329d/i', $useragent)) {
            return new Htc\HtcT329d($useragent);
        }

        if (preg_match('/t328w/i', $useragent)) {
            return new Htc\HtcT328w($useragent);
        }

        if (preg_match('/t328d/i', $useragent)) {
            return new Htc\HtcT328d($useragent);
        }

        if (preg_match('/Smart\_F3188/i', $useragent)) {
            return new Htc\HtcSmartF3188($useragent);
        }

        if (preg_match('/ShooterU/i', $useragent)) {
            return new Htc\HtcShooterU($useragent);
        }

        if (preg_match('/Salsa/i', $useragent)) {
            return new Htc\HtcSalsa($useragent);
        }

        if (preg_match('/butterfly_s_901s/i', $useragent)) {
            return new Htc\HtcS901s($useragent);
        }

        if (preg_match('/(Incredible S|IncredibleS|S710e)/i', $useragent)) {
            return new Htc\HtcS710e($useragent);
        }

        if (preg_match('/(Rhyme|S510b)/i', $useragent)) {
            return new Htc\HtcS510b($useragent);
        }

        if (preg_match('/ruby/i', $useragent)) {
            return new Htc\HtcRuby($useragent);
        }

        if (preg_match('/P3700/i', $useragent)) {
            return new Htc\HtcP3700($useragent);
        }

        if (preg_match('/MDA\_Vario\_V/i', $useragent)) {
            return new Htc\HtcMdaVarioV($useragent);
        }

        if (preg_match('/MDA Vario\/3/i', $useragent)) {
            return new Htc\HtcMdaVarioIii($useragent);
        }

        if (preg_match('/MDA Vario\/2/i', $useragent)) {
            return new Htc\HtcMdaVarioIi($useragent);
        }

        if (preg_match('/MDA\_Compact\_V/i', $useragent)) {
            return new Htc\HtcMdaCompactV($useragent);
        }

        if (preg_match('/Magic/i', $useragent)) {
            return new Htc\HtcMagic($useragent);
        }

        if (preg_match('/Legend/i', $useragent)) {
            return new Htc\HtcLegend($useragent);
        }

        if (preg_match('/(Hero|a6288)/i', $useragent)) {
            return new Htc\HtcHero($useragent);
        }

        if (preg_match('/Glacier/i', $useragent)) {
            return new Htc\HtcGlacier($useragent);
        }

        if (preg_match('/G21/i', $useragent)) {
            return new Htc\HtcG21($useragent);
        }

        if (preg_match('/(Flyer[ |\_]P512)/i', $useragent)) {
            return new Htc\HtcFlyerP512($useragent);
        }

        if (preg_match('/(Flyer[ |\_]P510e)/i', $useragent)) {
            return new Htc\HtcFlyerP510e($useragent);
        }

        if (preg_match('/Flyer/i', $useragent)) {
            return new Htc\HtcFlyer($useragent);
        }

        if (preg_match('/(pc36100|evo 4g|kingdom)/i', $useragent)) {
            return new Htc\HtcEvo4g($useragent);
        }

        if (preg_match('/Dream/i', $useragent)) {
            return new Htc\HtcDream($useragent);
        }

        if (preg_match('/D820mu/i', $useragent)) {
            return new Htc\HtcD820mu($useragent);
        }

        if (preg_match('/D820us/i', $useragent)) {
            return new Htc\HtcD820us($useragent);
        }

        if (preg_match('/click/i', $useragent)) {
            return new Htc\HtcClick($useragent);
        }

        if (preg_match('/eris/i', $useragent)) {
            return new Htc\HtcEris($useragent);
        }

        if (preg_match('/ C2/i', $useragent)) {
            return new Htc\HtcC2($useragent);
        }

        if (preg_match('/bravo/i', $useragent)) {
            return new Htc\HtcBravo($useragent);
        }

        if (preg_match('/butterfly/i', $useragent)) {
            return new Htc\HtcButterfly($useragent);
        }

        if (preg_match('/adr6350/i', $useragent)) {
            return new Htc\HtcAdr6350($useragent);
        }

        if (preg_match('/APA9292KT/i', $useragent)) {
            return new Htc\HtcA9292Apa9292kt($useragent);
        }

        if (preg_match('/A9192/i', $useragent)) {
            return new Htc\HtcA9192Inspire4g($useragent);
        }

        if (preg_match('/APA7373KT/i', $useragent)) {
            return new Htc\HtcA7373Apa7373kt($useragent);
        }

        if (preg_match('/Gratia/i', $useragent)) {
            return new Htc\HtcA6380Gratia($useragent);
        }

        if (preg_match('/A6366/i', $useragent)) {
            return new Htc\HtcA6366($useragent);
        }

        if (preg_match('/A3335/i', $useragent)) {
            return new Htc\HtcA3335($useragent);
        }

        if (preg_match('/chacha/i', $useragent)) {
            return new Htc\HtcA810eChaCha($useragent);
        }

        if (preg_match('/a510a/i', $useragent)) {
            return new Htc\HtcA510a($useragent);
        }

        if (preg_match('/(explorer|a310e)/i', $useragent)) {
            return new Htc\HtcA310e($useragent);
        }

        if (preg_match('/amaze/i', $useragent)) {
            return new Htc\HtcAmaze($useragent);
        }

        if (preg_match('/htc7088/i', $useragent)) {
            return new Htc\Htc7088($useragent);
        }

        if (preg_match('/HTC6990LVW/', $useragent)) {
            return new Htc\Htc6990Lvw($useragent);
        }

        if (preg_match('/htc6500lvw/i', $useragent)) {
            return new Htc\Htc6500Lvw($useragent);
        }

        if (preg_match('/htc6435lvw/i', $useragent)) {
            return new Htc\HTC6435lvw($useragent);
        }

        if (preg_match('/htc 919d/i', $useragent)) {
            return new Htc\Htc919d($useragent);
        }

        if (preg_match('/831c/i', $useragent)) {
            return new Htc\Htc831C($useragent);
        }

        if (preg_match('/htc 809d/i', $useragent)) {
            return new Htc\Htc809d($useragent);
        }

        if (preg_match('/htc[ ]?802t/i', $useragent)) {
            return new Htc\Htc802T($useragent);
        }

        if (preg_match('/htc 802d/i', $useragent)) {
            return new Htc\Htc802d($useragent);
        }

        if (preg_match('/htc 606w/i', $useragent)) {
            return new Htc\Htc606w($useragent);
        }

        if (preg_match('/htc d516d/i', $useragent)) {
            return new Htc\HtcDesire516($useragent);
        }

        if (preg_match('/VPA\_Touch/i', $useragent)) {
            return new Htc\HtcVpaTouch($useragent);
        }

        if (preg_match('/HTC\_VPACompactIV/i', $useragent)) {
            return new Htc\HtcVpaCompactIv($useragent);
        }

        return new Htc\Htc($useragent);
    }
}
