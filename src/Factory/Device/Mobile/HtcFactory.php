<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class HtcFactory implements Factory\FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect($useragent, Stringy $s = null)
    {
        if ($s->contains(' X9 ', true)) {
            return $this->loader->load('x9', $useragent);
        }

        if (preg_match('/(Nexus[ \-]One|NexusOne)/i', $useragent)) {
            return $this->loader->load('nexus one', $useragent);
        }

        if ($s->contains('nexus 9', false)) {
            return $this->loader->load('nexus 9', $useragent);
        }

        if (preg_match('/nexus(hd2| evohd2)/i', $useragent)) {
            return $this->loader->load('nexus hd2', $useragent);
        }

        if ($s->contains('8X by HTC', false)) {
            return $this->loader->load('windows phone 8x', $useragent);
        }

        if ($s->contains('PM23300', true)) {
            return $this->loader->load('windows phone 8x', $useragent);
        }

        if ($s->contains('8S by HTC', false)) {
            return $this->loader->load('8s', $useragent);
        }

        if (preg_match('/radar( c110e|; orange)/i', $useragent)) {
            return $this->loader->load('radar c110e', $useragent);
        }

        if ($s->contains('radar 4g', false)) {
            return $this->loader->load('radar 4g', $useragent);
        }

        if ($s->contains('radar', false)) {
            return $this->loader->load('radar', $useragent);
        }

        if (preg_match('/(hd7|mondrian)/i', $useragent)) {
            return $this->loader->load('t9292', $useragent);
        }

        if ($s->contains('7 Mozart', false)) {
            return $this->loader->load('t8698', $useragent);
        }

        if ($s->contains('t8282', false)) {
            return $this->loader->load('touch hd t8282', $useragent);
        }

        if ($s->contains('7 Pro T7576', false)) {
            return $this->loader->load('t7576', $useragent);
        }

        if ($s->contains('HD2_T8585', false)) {
            return $this->loader->load('t8585', $useragent);
        }

        if (preg_match('/HD2/', $useragent) && preg_match('/android/i', $useragent)) {
            return $this->loader->load('htc hd2', $useragent);
        }

        if ($s->contains('HD2', true)) {
            return $this->loader->load('hd2', $useragent);
        }

        if (preg_match('/(HD[ |\_]mini)/i', $useragent)) {
            return $this->loader->load('mini t5555', $useragent);
        }

        if ($s->contains('titan', false)) {
            return $this->loader->load('x310e', $useragent);
        }

        if (preg_match('/(7 Trophy|mwp6985)/i', $useragent)) {
            return $this->loader->load('spark', $useragent);
        }

        if ($s->contains('0P6B180', false)) {
            return $this->loader->load('0p6b180', $useragent);
        }

        if (preg_match('/one[_ ]m9plus/i', $useragent)) {
            return $this->loader->load('m9 plus', $useragent);
        }

        if (preg_match('/one[_ ]m9/i', $useragent)) {
            return $this->loader->load('m9', $useragent);
        }

        if (preg_match('/one[_ ]m8s/i', $useragent)) {
            return $this->loader->load('m8s', $useragent);
        }

        if (preg_match('/one[_ ]m8/i', $useragent)) {
            return $this->loader->load('htc m8', $useragent);
        }

        if ($s->contains('pn07120', false)) {
            return $this->loader->load('pn07120', $useragent);
        }

        if (preg_match('/(one[ _]x\+|onexplus)/i', $useragent)) {
            return $this->loader->load('pm63100', $useragent);
        }

        if (preg_match('/one[ _]xl/i', $useragent)) {
            return $this->loader->load('htc pj83100', $useragent);
        }

        if (preg_match('/(one[ _]x|onex|PJ83100)/i', $useragent)) {
            return $this->loader->load('pj83100', $useragent);
        }

        if (preg_match('/one[ _]v/i', $useragent)) {
            return $this->loader->load('one v', $useragent);
        }

        if (preg_match('/(one[ _]sv|onesv)/i', $useragent)) {
            return $this->loader->load('one sv', $useragent);
        }

        if (preg_match('/(one[ _]s|ones)/i', $useragent)) {
            return $this->loader->load('pj401', $useragent);
        }

        if (preg_match('/one[ _]mini[ _]2/i', $useragent)) {
            return $this->loader->load('one mini 2', $useragent);
        }

        if (preg_match('/one[ _]mini/i', $useragent)) {
            return $this->loader->load('one mini', $useragent);
        }

        if (preg_match('/(one[ _]max|himauhl_htc_asia_tw)/i', $useragent)) {
            return $this->loader->load('one max', $useragent);
        }

        if ($s->containsAny(['One', 'ONE'], true)) {
            return $this->loader->load('m7', $useragent);
        }

        if (preg_match('/(x315e|runnymede)/i', $useragent)) {
            return $this->loader->load('htc x315e', $useragent);
        }

        if (preg_match('/sensation[ _]4g/i', $useragent)) {
            return $this->loader->load('sensation 4g', $useragent);
        }

        if (preg_match('/(sensationxl|sensation xl)/i', $useragent)) {
            return $this->loader->load('htc x315e', $useragent);
        }

        if (preg_match('/(sensation xe|sensationxe)/i', $useragent)) {
            return $this->loader->load('sensation xe beats z715e', $useragent);
        }

        if (preg_match('/(htc\_sensation\-orange\-ls|htc\_sensation\-ls)/i', $useragent)) {
            return $this->loader->load('htc z710 ls', $useragent);
        }

        if (preg_match('/sensation[ _]z710e/i', $useragent)) {
            return $this->loader->load('z710e', $useragent);
        }

        if (preg_match('/(sensation|pyramid)/i', $useragent)) {
            return $this->loader->load('htc z710', $useragent);
        }

        if ($s->contains('evo 3d gsm', false)) {
            return $this->loader->load('evo 3d gsm', $useragent);
        }

        if ($s->contains('x515a', false)) {
            return $this->loader->load('x515a', $useragent);
        }

        if ($s->contains('x515c', false)) {
            return $this->loader->load('x515c', $useragent);
        }

        if ($s->contains('x515e', false)) {
            return $this->loader->load('x515e', $useragent);
        }

        if (preg_match('/(EVO[ _]3D|EVO3D|x515m)/i', $useragent)) {
            return $this->loader->load('x515m', $useragent);
        }

        if ($s->contains('x515', false)) {
            return $this->loader->load('x515', $useragent);
        }

        if ($s->contains('desirez_a7272', false)) {
            return $this->loader->load('a7272', $useragent);
        }

        if (preg_match('/(desire[ _]z|desirez)/i', $useragent)) {
            return $this->loader->load('desire z', $useragent);
        }

        if (preg_match('/(desire[ _]x|desirex)/i', $useragent)) {
            return $this->loader->load('t328e', $useragent);
        }

        if (preg_match('/(desire[ _]v|desirev)/i', $useragent)) {
            return $this->loader->load('desire v', $useragent);
        }

        if ($s->contains('s510e', false)) {
            return $this->loader->load('s510e', $useragent);
        }

        if (preg_match('/(desire[ _]sv|desiresv)/i', $useragent)) {
            return $this->loader->load('desire sv', $useragent);
        }

        if (preg_match('/(desire[ _]s|desires)/i', $useragent)) {
            return $this->loader->load('desire s', $useragent);
        }

        if ($s->contains('desirehd-orange-ls', false)) {
            return $this->loader->load('desire hd ls', $useragent);
        }

        if ($s->contains('a9191', false)) {
            return $this->loader->load('a9191', $useragent);
        }

        if ($s->contains('a9192', false)) {
            return $this->loader->load('inspire 4g', $useragent);
        }

        if (preg_match('/(desire hd|desirehd)/i', $useragent)) {
            return $this->loader->load('desire hd', $useragent);
        }

        if (preg_match('/(desire[ _]c|desirec)/i', $useragent)) {
            return $this->loader->load('1000c', $useragent);
        }

        if (preg_match('/desire[ _]820s/i', $useragent)) {
            return $this->loader->load('desire 820s', $useragent);
        }

        if (preg_match('/desire[ _]820/i', $useragent)) {
            return $this->loader->load('desire 820', $useragent);
        }

        if (preg_match('/desire[ _]816g/i', $useragent)) {
            return $this->loader->load('desire 816g', $useragent);
        }

        if (preg_match('/desire[ _]816/i', $useragent)) {
            return $this->loader->load('desire 816', $useragent);
        }

        if (preg_match('/(0p4e2|desire[ _]601)/i', $useragent)) {
            return $this->loader->load('0p4e2', $useragent);
        }

        if (preg_match('/desire[ _]728g/i', $useragent)) {
            return $this->loader->load('desire 728g', $useragent);
        }

        if (preg_match('/desire[ _]700/i', $useragent)) {
            return $this->loader->load('desire 700', $useragent);
        }

        if (preg_match('/desire[ _]626g/i', $useragent)) {
            return $this->loader->load('desire 626g', $useragent);
        }

        if (preg_match('/desire[ _]626/i', $useragent)) {
            return $this->loader->load('desire 626', $useragent);
        }

        if (preg_match('/desire[ _]620g/i', $useragent)) {
            return $this->loader->load('desire 620g', $useragent);
        }

        if (preg_match('/desire[ _]610/i', $useragent)) {
            return $this->loader->load('desire 610', $useragent);
        }

        if (preg_match('/desire[ _]600c/i', $useragent)) {
            return $this->loader->load('desire 600c', $useragent);
        }

        if (preg_match('/desire[ _]600/i', $useragent)) {
            return $this->loader->load('desire 600', $useragent);
        }

        if (preg_match('/desire[ _]530/i', $useragent)) {
            return $this->loader->load('desire 530', $useragent);
        }

        if (preg_match('/desire[ _]526g/i', $useragent)) {
            return $this->loader->load('desire 526g', $useragent);
        }

        if (preg_match('/desire[ _]516/i', $useragent)) {
            return $this->loader->load('desire 516', $useragent);
        }

        if (preg_match('/desire[ _]510/i', $useragent)) {
            return $this->loader->load('desire 510', $useragent);
        }

        if (preg_match('/desire[ _]500/i', $useragent)) {
            return $this->loader->load('desire 500', $useragent);
        }

        if (preg_match('/desire[ _]400/i', $useragent)) {
            return $this->loader->load('desire 400', $useragent);
        }

        if (preg_match('/desire[ _]320/i', $useragent)) {
            return $this->loader->load('desire 320', $useragent);
        }

        if (preg_match('/desire[ _]310/i', $useragent)) {
            return $this->loader->load('desire 310', $useragent);
        }

        if (preg_match('/desire[ _]300/i', $useragent)) {
            return $this->loader->load('desire 300', $useragent);
        }

        if (preg_match('/desire[_ ]eye/i', $useragent)) {
            return $this->loader->load('desire eye', $useragent);
        }

        if ($s->contains('desire_a8181', false)) {
            return $this->loader->load('a8181', $useragent);
        }

        if ($s->contains('desire', false)) {
            return $this->loader->load('desire', $useragent);
        }

        if (preg_match('/WildfireS\-orange\-LS|WildfireS\-LS/i', $useragent)) {
            return $this->loader->load('wildfire s ls', $useragent);
        }

        if ($s->contains(' a315c ', false)) {
            return $this->loader->load('a315c', $useragent);
        }

        if ($s->contains('Wildfire_A3333', false)) {
            return $this->loader->load('a3333', $useragent);
        }

        if (preg_match('/(Wildfire S A510e|WildfireS_A510e)/i', $useragent)) {
            return $this->loader->load('a510e', $useragent);
        }

        if ($s->contains('adr6230', false)) {
            return $this->loader->load('adr6230', $useragent);
        }

        if (preg_match('/Wildfire[ |]S/i', $useragent)) {
            return $this->loader->load('htc a510', $useragent);
        }

        if ($s->contains('wildfire', false)) {
            return $this->loader->load('wildfire', $useragent);
        }

        if ($s->contains('vision', false)) {
            return $this->loader->load('vision', $useragent);
        }

        if (preg_match('/velocity[ _]4g[ _]x710s/i', $useragent)) {
            return $this->loader->load('x710s', $useragent);
        }

        if (preg_match('/velocity[ _]4g/i', $useragent)) {
            return $this->loader->load('velocity 4g', $useragent);
        }

        if ($s->contains('velocity', false)) {
            return $this->loader->load('velocity', $useragent);
        }

        if ($s->contains('touch_diamond2', false)) {
            return $this->loader->load('touch diamond 2', $useragent);
        }

        if ($s->contains('tattoo', false)) {
            return $this->loader->load('tattoo', $useragent);
        }

        if ($s->contains('touch_pro2_t7373', false)) {
            return $this->loader->load('t7373', $useragent);
        }

        if ($s->contains('touch2', false)) {
            return $this->loader->load('t3335', $useragent);
        }

        if ($s->contains('t329d', false)) {
            return $this->loader->load('t329d', $useragent);
        }

        if ($s->contains('t328w', false)) {
            return $this->loader->load('t328w', $useragent);
        }

        if ($s->contains('t328d', false)) {
            return $this->loader->load('t328d', $useragent);
        }

        if ($s->contains('smart_f3188', false)) {
            return $this->loader->load('smart f3188', $useragent);
        }

        if ($s->contains('shooteru', false)) {
            return $this->loader->load('shooter u', $useragent);
        }

        if ($s->contains('salsa', false)) {
            return $this->loader->load('salsa', $useragent);
        }

        if ($s->contains('butterfly_s_901s', false)) {
            return $this->loader->load('s901s', $useragent);
        }

        if (preg_match('/(Incredible S|IncredibleS|S710e)/i', $useragent)) {
            return $this->loader->load('s710e', $useragent);
        }

        if (preg_match('/(Rhyme|S510b)/i', $useragent)) {
            return $this->loader->load('s510b', $useragent);
        }

        if ($s->contains('ruby', false)) {
            return $this->loader->load('ruby', $useragent);
        }

        if ($s->contains('p3700', false)) {
            return $this->loader->load('p3700', $useragent);
        }

        if ($s->contains('magic', false)) {
            return $this->loader->load('magic', $useragent);
        }

        if ($s->contains('legend', false)) {
            return $this->loader->load('legend', $useragent);
        }

        if (preg_match('/(Hero|a6288)/i', $useragent)) {
            return $this->loader->load('hero', $useragent);
        }

        if ($s->contains('glacier', false)) {
            return $this->loader->load('glacier', $useragent);
        }

        if ($s->contains('g21', false)) {
            return $this->loader->load('g21', $useragent);
        }

        if (preg_match('/(Flyer[ |\_]P512)/i', $useragent)) {
            return $this->loader->load('p512', $useragent);
        }

        if (preg_match('/(Flyer[ |\_]P510e)/i', $useragent)) {
            return $this->loader->load('p510e', $useragent);
        }

        if ($s->contains('flyer', false)) {
            return $this->loader->load('flyer', $useragent);
        }

        if (preg_match('/(pc36100|evo 4g|kingdom)/i', $useragent)) {
            return $this->loader->load('pc36100', $useragent);
        }

        if ($s->contains('dream', false)) {
            return $this->loader->load('dream', $useragent);
        }

        if ($s->contains('d820mu', false)) {
            return $this->loader->load('d820mu', $useragent);
        }

        if ($s->contains('d820us', false)) {
            return $this->loader->load('d820us', $useragent);
        }

        if ($s->contains('click', false)) {
            return $this->loader->load('click', $useragent);
        }

        if ($s->contains('eris', false)) {
            return $this->loader->load('eris', $useragent);
        }

        if ($s->contains(' c2', false)) {
            return $this->loader->load('c2', $useragent);
        }

        if ($s->contains('bravo', false)) {
            return $this->loader->load('bravo', $useragent);
        }

        if ($s->contains('butterfly', false)) {
            return $this->loader->load('butterfly', $useragent);
        }

        if ($s->contains('adr6350', false)) {
            return $this->loader->load('adr6350', $useragent);
        }

        if ($s->containsAny(['gratia', 'a6380'], false)) {
            return $this->loader->load('a6380', $useragent);
        }

        if ($s->contains('a6366', false)) {
            return $this->loader->load('a6366', $useragent);
        }

        if ($s->contains('a3335', false)) {
            return $this->loader->load('a3335', $useragent);
        }

        if ($s->contains('chacha', false)) {
            return $this->loader->load('a810e', $useragent);
        }

        if ($s->contains('a510a', false)) {
            return $this->loader->load('a510a', $useragent);
        }

        if (preg_match('/(explorer|a310e)/i', $useragent)) {
            return $this->loader->load('a310e', $useragent);
        }

        if ($s->contains('amaze', false)) {
            return $this->loader->load('amaze 4g', $useragent);
        }

        if ($s->contains('htc7088', false)) {
            return $this->loader->load('7088', $useragent);
        }

        if ($s->contains('HTC6990LVW', true)) {
            return $this->loader->load('htc6990lvw', $useragent);
        }

        if ($s->contains('htc6500lvw', false)) {
            return $this->loader->load('m7 (htc6500lvw)', $useragent);
        }

        if ($s->contains('htc6435lvw', false)) {
            return $this->loader->load('htc6435lvw', $useragent);
        }

        if ($s->contains('htc 919d', false)) {
            return $this->loader->load('919d', $useragent);
        }

        if ($s->contains('831c', false)) {
            return $this->loader->load('831c', $useragent);
        }

        if ($s->contains('htc 809d', false)) {
            return $this->loader->load('809d', $useragent);
        }

        if (preg_match('/htc[ ]?802t/i', $useragent)) {
            return $this->loader->load('802t', $useragent);
        }

        if ($s->contains('htc 802d', false)) {
            return $this->loader->load('802d', $useragent);
        }

        if ($s->contains('htc 606w', false)) {
            return $this->loader->load('desire 606w', $useragent);
        }

        if ($s->contains('htc d516d', false)) {
            return $this->loader->load('desire 516', $useragent);
        }

        if ($s->contains('vpa_touch', false)) {
            return $this->loader->load('vpa touch', $useragent);
        }

        if ($s->contains('htc_vpacompactiv', false)) {
            return $this->loader->load('vpa compact iv', $useragent);
        }

        return $this->loader->load('general htc device', $useragent);
    }
}
