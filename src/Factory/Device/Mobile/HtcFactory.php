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

namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class HtcFactory implements Factory\FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface $cache
     */
    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function detect($useragent)
    {
        $deviceCode = 'general htc device';

        if (preg_match('/ X9 /', $useragent)) {
            $deviceCode = 'x9';
        } elseif (preg_match('/(Nexus[ \-]One|NexusOne)/i', $useragent)) {
            $deviceCode = 'nexus one';
        } elseif (preg_match('/Nexus 9/i', $useragent)) {
            $deviceCode = 'nexus 9';
        } elseif (preg_match('/nexus(hd2| evohd2)/i', $useragent)) {
            $deviceCode = 'nexus hd2';
        } elseif (preg_match('/8X by HTC/i', $useragent)) {
            $deviceCode = 'windows phone 8x';
        } elseif (preg_match('/PM23300/', $useragent)) {
            $deviceCode = 'windows phone 8x';
        } elseif (preg_match('/8S by HTC/i', $useragent)) {
            $deviceCode = '8s';
        } elseif (preg_match('/radar( c110e|; orange)/i', $useragent)) {
            $deviceCode = 'radar c110e';
        } elseif (preg_match('/radar 4g/i', $useragent)) {
            $deviceCode = 'radar 4g';
        } elseif (preg_match('/radar/i', $useragent)) {
            $deviceCode = 'radar';
        } elseif (preg_match('/(hd7|mondrian)/i', $useragent)) {
            $deviceCode = 't9292';
        } elseif (preg_match('/7 Mozart/i', $useragent)) {
            $deviceCode = 't8698';
        } elseif (preg_match('/t8282/i', $useragent)) {
            $deviceCode = 'touch hd t8282';
        } elseif (preg_match('/7 Pro T7576/i', $useragent)) {
            $deviceCode = 't7576';
        } elseif (preg_match('/HD2\_T8585/i', $useragent)) {
            $deviceCode = 't8585';
        } elseif (preg_match('/HD2/', $useragent) && preg_match('/android/i', $useragent)) {
            $deviceCode = 'htc hd2';
        } elseif (preg_match('/HD2/', $useragent)) {
            $deviceCode = 'hd2';
        } elseif (preg_match('/(HD[ |\_]mini)/i', $useragent)) {
            $deviceCode = 'mini t5555';
        } elseif (preg_match('/titan/i', $useragent)) {
            $deviceCode = 'x310e';
        } elseif (preg_match('/(7 Trophy|mwp6985)/i', $useragent)) {
            $deviceCode = 'spark';
        } elseif (preg_match('/0P6B180/i', $useragent)) {
            $deviceCode = '0p6b180';
        } elseif (preg_match('/one[_ ]m9plus/i', $useragent)) {
            $deviceCode = 'm9 plus';
        } elseif (preg_match('/one[_ ]m9/i', $useragent)) {
            $deviceCode = 'm9';
        } elseif (preg_match('/one[_ ]m8s/i', $useragent)) {
            $deviceCode = 'm8s';
        } elseif (preg_match('/one[_ ]m8/i', $useragent)) {
            $deviceCode = 'htc m8';
        } elseif (preg_match('/pn07120/i', $useragent)) {
            $deviceCode = 'pn07120';
        } elseif (preg_match('/(one[ _]x\+|onexplus)/i', $useragent)) {
            $deviceCode = 'pm63100';
        } elseif (preg_match('/one[ _]xl/i', $useragent)) {
            $deviceCode = 'htc pj83100';
        } elseif (preg_match('/(one[ _]x|onex|PJ83100)/i', $useragent)) {
            $deviceCode = 'pj83100';
        } elseif (preg_match('/one[ _]v/i', $useragent)) {
            $deviceCode = 'one v';
        } elseif (preg_match('/(one[ _]sv|onesv)/i', $useragent)) {
            $deviceCode = 'one sv';
        } elseif (preg_match('/(one[ _]s|ones)/i', $useragent)) {
            $deviceCode = 'pj401';
        } elseif (preg_match('/one[ _]mini[ _]2/i', $useragent)) {
            $deviceCode = 'one mini 2';
        } elseif (preg_match('/one[ _]mini/i', $useragent)) {
            $deviceCode = 'one mini';
        } elseif (preg_match('/(one[ _]max|himauhl_htc_asia_tw)/i', $useragent)) {
            $deviceCode = 'one max';
        } elseif (preg_match('/one/i', $useragent)) {
            $deviceCode = 'm7';
        } elseif (preg_match('/(Smart Tab III 7|SmartTabIII7)/i', $useragent)) {
            $deviceCode = 'smart tab iii 7';
        } elseif (preg_match('/(x315e|runnymede)/i', $useragent)) {
            $deviceCode = 'htc x315e';
        } elseif (preg_match('/sensation[ _]4g/i', $useragent)) {
            $deviceCode = 'sensation 4g';
        } elseif (preg_match('/(sensationxl|sensation xl)/i', $useragent)) {
            $deviceCode = 'htc x315e';
        } elseif (preg_match('/(sensation xe|sensationxe)/i', $useragent)) {
            $deviceCode = 'sensation xe beats z715e';
        } elseif (preg_match('/(htc\_sensation\-orange\-ls|htc\_sensation\-ls)/i', $useragent)) {
            $deviceCode = 'htc z710 ls';
        } elseif (preg_match('/sensation[ _]z710e/i', $useragent)) {
            $deviceCode = 'z710e';
        } elseif (preg_match('/(sensation|pyramid)/i', $useragent)) {
            $deviceCode = 'htc z710';
        } elseif (preg_match('/Xda\_Diamond\_2/i', $useragent)) {
            $deviceCode = 'xda_diamond_2';
        } elseif (preg_match('/Evo 3D GSM/i', $useragent)) {
            $deviceCode = 'evo 3d gsm';
        } elseif (preg_match('/(EVO[ _]3D|EVO3D|x515m)/i', $useragent)) {
            $deviceCode = 'x515m';
        } elseif (preg_match('/x515e/i', $useragent)) {
            $deviceCode = 'x515e';
        } elseif (preg_match('/x515/i', $useragent)) {
            $deviceCode = 'x515';
        } elseif (preg_match('/desirez\_a7272/i', $useragent)) {
            $deviceCode = 'a7272';
        } elseif (preg_match('/(desire[ _]z|desirez)/i', $useragent)) {
            $deviceCode = 'desire z';
        } elseif (preg_match('/(desire[ _]x|desirex)/i', $useragent)) {
            $deviceCode = 't328e';
        } elseif (preg_match('/(desire[ _]v|desirev)/i', $useragent)) {
            $deviceCode = 'desire v';
        } elseif (preg_match('/s510e/i', $useragent)) {
            $deviceCode = 's510e';
        } elseif (preg_match('/(desire[ _]sv|desiresv)/i', $useragent)) {
            $deviceCode = 'desire sv';
        } elseif (preg_match('/(desire[ _]s|desires)/i', $useragent)) {
            $deviceCode = 'desire s';
        } elseif (preg_match('/desirehd\-orange\-ls/i', $useragent)) {
            $deviceCode = 'desire hd ls';
        } elseif (preg_match('/a9191/i', $useragent)) {
            $deviceCode = 'a9191';
        } elseif (preg_match('/(desire hd|desirehd)/i', $useragent)) {
            $deviceCode = 'desire hd';
        } elseif (preg_match('/(desire[ _]c|desirec)/i', $useragent)) {
            $deviceCode = '1000c';
        } elseif (preg_match('/desire[ _]820s/i', $useragent)) {
            $deviceCode = 'desire 820s';
        } elseif (preg_match('/desire[ _]820/i', $useragent)) {
            $deviceCode = 'desire 820';
        } elseif (preg_match('/desire[ _]816g/i', $useragent)) {
            $deviceCode = 'desire 816g';
        } elseif (preg_match('/desire[ _]816/i', $useragent)) {
            $deviceCode = 'desire 816';
        } elseif (preg_match('/(0p4e2|desire[ _]601)/i', $useragent)) {
            $deviceCode = '0p4e2';
        } elseif (preg_match('/desire[ _]728g/i', $useragent)) {
            $deviceCode = 'desire 728g';
        } elseif (preg_match('/desire[ _]700/i', $useragent)) {
            $deviceCode = 'desire 700';
        } elseif (preg_match('/desire[ _]626g/i', $useragent)) {
            $deviceCode = 'desire 626g';
        } elseif (preg_match('/desire[ _]626/i', $useragent)) {
            $deviceCode = 'desire 626';
        } elseif (preg_match('/desire[ _]620g/i', $useragent)) {
            $deviceCode = 'desire 620g';
        } elseif (preg_match('/desire[ _]610/i', $useragent)) {
            $deviceCode = 'desire 610';
        } elseif (preg_match('/desire[ _]600c/i', $useragent)) {
            $deviceCode = 'desire 600c';
        } elseif (preg_match('/desire[ _]600/i', $useragent)) {
            $deviceCode = 'desire 600';
        } elseif (preg_match('/desire[ _]530/i', $useragent)) {
            $deviceCode = 'desire 530';
        } elseif (preg_match('/desire[ _]526g/i', $useragent)) {
            $deviceCode = 'desire 526g';
        } elseif (preg_match('/desire[ _]516/i', $useragent)) {
            $deviceCode = 'desire 516';
        } elseif (preg_match('/desire[ _]510/i', $useragent)) {
            $deviceCode = 'desire 510';
        } elseif (preg_match('/desire[ _]500/i', $useragent)) {
            $deviceCode = 'desire 500';
        } elseif (preg_match('/desire[ _]400/i', $useragent)) {
            $deviceCode = 'desire 400';
        } elseif (preg_match('/desire[ _]320/i', $useragent)) {
            $deviceCode = 'desire 320';
        } elseif (preg_match('/desire[ _]310/i', $useragent)) {
            $deviceCode = 'desire 310';
        } elseif (preg_match('/desire[ _]300/i', $useragent)) {
            $deviceCode = 'desire 300';
        } elseif (preg_match('/desire[_ ]eye/i', $useragent)) {
            $deviceCode = 'desire eye';
        } elseif (preg_match('/desire\_a8181/i', $useragent)) {
            $deviceCode = 'a8181';
        } elseif (preg_match('/desire/i', $useragent)) {
            $deviceCode = 'desire';
        } elseif (preg_match('/WildfireS\-orange\-LS|WildfireS\-LS/i', $useragent)) {
            $deviceCode = 'wildfire s ls';
        } elseif (preg_match('/ a315c /i', $useragent)) {
            $deviceCode = 'a315c';
        } elseif (preg_match('/Wildfire\_A3333/i', $useragent)) {
            $deviceCode = 'a3333';
        } elseif (preg_match('/(Wildfire S A510e|WildfireS_A510e)/i', $useragent)) {
            $deviceCode = 'a510e';
        } elseif (preg_match('/ADR6230/i', $useragent)) {
            $deviceCode = 'adr6230';
        } elseif (preg_match('/Wildfire[ |]S/i', $useragent)) {
            $deviceCode = 'htc a510';
        } elseif (preg_match('/Wildfire/i', $useragent)) {
            $deviceCode = 'wildfire';
        } elseif (preg_match('/Vision/i', $useragent)) {
            $deviceCode = 'vision';
        } elseif (preg_match('/velocity[ _]4g[ _]x710s/i', $useragent)) {
            $deviceCode = 'x710s';
        } elseif (preg_match('/velocity[ _]4g/i', $useragent)) {
            $deviceCode = 'velocity 4g';
        } elseif (preg_match('/Velocity/i', $useragent)) {
            $deviceCode = 'velocity';
        } elseif (preg_match('/Touch\_Diamond2/i', $useragent)) {
            $deviceCode = 'touch diamond 2';
        } elseif (preg_match('/tattoo/i', $useragent)) {
            $deviceCode = 'tattoo';
        } elseif (preg_match('/Touch\_Pro2\_T7373/i', $useragent)) {
            $deviceCode = 't7373';
        } elseif (preg_match('/Touch2/i', $useragent)) {
            $deviceCode = 't3335';
        } elseif (preg_match('/t329d/i', $useragent)) {
            $deviceCode = 't329d';
        } elseif (preg_match('/t328w/i', $useragent)) {
            $deviceCode = 't328w';
        } elseif (preg_match('/t328d/i', $useragent)) {
            $deviceCode = 't328d';
        } elseif (preg_match('/Smart\_F3188/i', $useragent)) {
            $deviceCode = 'smart f3188';
        } elseif (preg_match('/ShooterU/i', $useragent)) {
            $deviceCode = 'shooter u';
        } elseif (preg_match('/Salsa/i', $useragent)) {
            $deviceCode = 'salsa';
        } elseif (preg_match('/butterfly_s_901s/i', $useragent)) {
            $deviceCode = 's901s';
        } elseif (preg_match('/(Incredible S|IncredibleS|S710e)/i', $useragent)) {
            $deviceCode = 's710e';
        } elseif (preg_match('/(Rhyme|S510b)/i', $useragent)) {
            $deviceCode = 's510b';
        } elseif (preg_match('/ruby/i', $useragent)) {
            $deviceCode = 'ruby';
        } elseif (preg_match('/P3700/i', $useragent)) {
            $deviceCode = 'p3700';
        } elseif (preg_match('/MDA\_Vario\_V/i', $useragent)) {
            $deviceCode = 'mda vario v';
        } elseif (preg_match('/MDA Vario\/3/i', $useragent)) {
            $deviceCode = 'mda vario iii';
        } elseif (preg_match('/MDA Vario\/2/i', $useragent)) {
            $deviceCode = 'mda vario ii';
        } elseif (preg_match('/MDA\_Compact\_V/i', $useragent)) {
            $deviceCode = 'mda compact v';
        } elseif (preg_match('/Magic/i', $useragent)) {
            $deviceCode = 'magic';
        } elseif (preg_match('/Legend/i', $useragent)) {
            $deviceCode = 'legend';
        } elseif (preg_match('/(Hero|a6288)/i', $useragent)) {
            $deviceCode = 'hero';
        } elseif (preg_match('/Glacier/i', $useragent)) {
            $deviceCode = 'glacier';
        } elseif (preg_match('/G21/i', $useragent)) {
            $deviceCode = 'g21';
        } elseif (preg_match('/(Flyer[ |\_]P512)/i', $useragent)) {
            $deviceCode = 'p512';
        } elseif (preg_match('/(Flyer[ |\_]P510e)/i', $useragent)) {
            $deviceCode = 'p510e';
        } elseif (preg_match('/Flyer/i', $useragent)) {
            $deviceCode = 'flyer';
        } elseif (preg_match('/(pc36100|evo 4g|kingdom)/i', $useragent)) {
            $deviceCode = 'pc36100';
        } elseif (preg_match('/Dream/i', $useragent)) {
            $deviceCode = 'dream';
        } elseif (preg_match('/D820mu/i', $useragent)) {
            $deviceCode = 'd820mu';
        } elseif (preg_match('/D820us/i', $useragent)) {
            $deviceCode = 'd820us';
        } elseif (preg_match('/click/i', $useragent)) {
            $deviceCode = 'click';
        } elseif (preg_match('/eris/i', $useragent)) {
            $deviceCode = 'eris';
        } elseif (preg_match('/ C2/i', $useragent)) {
            $deviceCode = 'c2';
        } elseif (preg_match('/bravo/i', $useragent)) {
            $deviceCode = 'bravo';
        } elseif (preg_match('/butterfly/i', $useragent)) {
            $deviceCode = 'butterfly';
        } elseif (preg_match('/adr6350/i', $useragent)) {
            $deviceCode = 'adr6350';
        } elseif (preg_match('/apa9292kt/i', $useragent)) {
            $deviceCode = '9292';
        } elseif (preg_match('/a9192/i', $useragent)) {
            $deviceCode = 'inspire 4g';
        } elseif (preg_match('/APA7373KT/i', $useragent)) {
            $deviceCode = 'a7373';
        } elseif (preg_match('/Gratia/i', $useragent)) {
            $deviceCode = 'a6380';
        } elseif (preg_match('/A6366/i', $useragent)) {
            $deviceCode = 'a6366';
        } elseif (preg_match('/A3335/i', $useragent)) {
            $deviceCode = 'a3335';
        } elseif (preg_match('/chacha/i', $useragent)) {
            $deviceCode = 'a810e';
        } elseif (preg_match('/a510a/i', $useragent)) {
            $deviceCode = 'a510a';
        } elseif (preg_match('/(explorer|a310e)/i', $useragent)) {
            $deviceCode = 'a310e';
        } elseif (preg_match('/amaze/i', $useragent)) {
            $deviceCode = 'amaze 4g';
        } elseif (preg_match('/htc7088/i', $useragent)) {
            $deviceCode = '7088';
        } elseif (preg_match('/HTC6990LVW/', $useragent)) {
            $deviceCode = 'htc6990lvw';
        } elseif (preg_match('/htc6500lvw/i', $useragent)) {
            $deviceCode = 'm7 (htc6500lvw)';
        } elseif (preg_match('/htc6435lvw/i', $useragent)) {
            $deviceCode = 'htc6435lvw';
        } elseif (preg_match('/htc 919d/i', $useragent)) {
            $deviceCode = '919d';
        } elseif (preg_match('/831c/i', $useragent)) {
            $deviceCode = '831c';
        } elseif (preg_match('/htc 809d/i', $useragent)) {
            $deviceCode = '809d';
        } elseif (preg_match('/htc[ ]?802t/i', $useragent)) {
            $deviceCode = '802t';
        } elseif (preg_match('/htc 802d/i', $useragent)) {
            $deviceCode = '802d';
        } elseif (preg_match('/htc 606w/i', $useragent)) {
            $deviceCode = 'desire 606w';
        } elseif (preg_match('/htc d516d/i', $useragent)) {
            $deviceCode = 'desire 516';
        } elseif (preg_match('/VPA\_Touch/i', $useragent)) {
            $deviceCode = 'vpa touch';
        } elseif (preg_match('/HTC\_VPACompactIV/i', $useragent)) {
            $deviceCode = 'vpa compact iv';
        }

        return (new Factory\DeviceFactory($this->cache))->get($deviceCode, $useragent);
    }
}
