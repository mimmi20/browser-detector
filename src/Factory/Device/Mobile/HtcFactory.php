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
use Psr\Cache\CacheItemPoolInterface;
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
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
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
        if (preg_match('/ X9 /', $useragent)) {
            return $this->loader->load('x9', $useragent);
        }

        if (preg_match('/(Nexus[ \-]One|NexusOne)/i', $useragent)) {
            return $this->loader->load('nexus one', $useragent);
        }

        if (preg_match('/Nexus 9/i', $useragent)) {
            return $this->loader->load('nexus 9', $useragent);
        }

        if (preg_match('/nexus(hd2| evohd2)/i', $useragent)) {
            return $this->loader->load('nexus hd2', $useragent);
        }

        if (preg_match('/8X by HTC/i', $useragent)) {
            return $this->loader->load('windows phone 8x', $useragent);
        }

        if (preg_match('/PM23300/', $useragent)) {
            return $this->loader->load('windows phone 8x', $useragent);
        }

        if (preg_match('/8S by HTC/i', $useragent)) {
            return $this->loader->load('8s', $useragent);
        }

        if (preg_match('/radar( c110e|; orange)/i', $useragent)) {
            return $this->loader->load('radar c110e', $useragent);
        }

        if (preg_match('/radar 4g/i', $useragent)) {
            return $this->loader->load('radar 4g', $useragent);
        }

        if (preg_match('/radar/i', $useragent)) {
            return $this->loader->load('radar', $useragent);
        }

        if (preg_match('/(hd7|mondrian)/i', $useragent)) {
            return $this->loader->load('t9292', $useragent);
        }

        if (preg_match('/7 Mozart/i', $useragent)) {
            return $this->loader->load('t8698', $useragent);
        }

        if (preg_match('/t8282/i', $useragent)) {
            return $this->loader->load('touch hd t8282', $useragent);
        }

        if (preg_match('/7 Pro T7576/i', $useragent)) {
            return $this->loader->load('t7576', $useragent);
        }

        if (preg_match('/HD2\_T8585/i', $useragent)) {
            return $this->loader->load('t8585', $useragent);
        }

        if (preg_match('/HD2/', $useragent) && preg_match('/android/i', $useragent)) {
            return $this->loader->load('htc hd2', $useragent);
        }

        if (preg_match('/HD2/', $useragent)) {
            return $this->loader->load('hd2', $useragent);
        }

        if (preg_match('/(HD[ |\_]mini)/i', $useragent)) {
            return $this->loader->load('mini t5555', $useragent);
        }

        if (preg_match('/titan/i', $useragent)) {
            return $this->loader->load('x310e', $useragent);
        }

        if (preg_match('/(7 Trophy|mwp6985)/i', $useragent)) {
            return $this->loader->load('spark', $useragent);
        }

        if (preg_match('/0P6B180/i', $useragent)) {
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

        if (preg_match('/pn07120/i', $useragent)) {
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

        if (preg_match('/one/i', $useragent)) {
            return $this->loader->load('m7', $useragent);
        }

        if (preg_match('/(Smart Tab III 7|SmartTabIII7)/i', $useragent)) {
            return $this->loader->load('smart tab iii 7', $useragent);
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

        if (preg_match('/Xda\_Diamond\_2/i', $useragent)) {
            return $this->loader->load('xda_diamond_2', $useragent);
        }

        if (preg_match('/Evo 3D GSM/i', $useragent)) {
            return $this->loader->load('evo 3d gsm', $useragent);
        }

        if (preg_match('/(EVO[ _]3D|EVO3D|x515m)/i', $useragent)) {
            return $this->loader->load('x515m', $useragent);
        }

        if (preg_match('/x515e/i', $useragent)) {
            return $this->loader->load('x515e', $useragent);
        }

        if (preg_match('/x515/i', $useragent)) {
            return $this->loader->load('x515', $useragent);
        }

        if (preg_match('/desirez\_a7272/i', $useragent)) {
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

        if (preg_match('/s510e/i', $useragent)) {
            return $this->loader->load('s510e', $useragent);
        }

        if (preg_match('/(desire[ _]sv|desiresv)/i', $useragent)) {
            return $this->loader->load('desire sv', $useragent);
        }

        if (preg_match('/(desire[ _]s|desires)/i', $useragent)) {
            return $this->loader->load('desire s', $useragent);
        }

        if (preg_match('/desirehd\-orange\-ls/i', $useragent)) {
            return $this->loader->load('desire hd ls', $useragent);
        }

        if (preg_match('/a9191/i', $useragent)) {
            return $this->loader->load('a9191', $useragent);
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

        if (preg_match('/desire\_a8181/i', $useragent)) {
            return $this->loader->load('a8181', $useragent);
        }

        if (preg_match('/desire/i', $useragent)) {
            return $this->loader->load('desire', $useragent);
        }

        if (preg_match('/WildfireS\-orange\-LS|WildfireS\-LS/i', $useragent)) {
            return $this->loader->load('wildfire s ls', $useragent);
        }

        if (preg_match('/ a315c /i', $useragent)) {
            return $this->loader->load('a315c', $useragent);
        }

        if (preg_match('/Wildfire\_A3333/i', $useragent)) {
            return $this->loader->load('a3333', $useragent);
        }

        if (preg_match('/(Wildfire S A510e|WildfireS_A510e)/i', $useragent)) {
            return $this->loader->load('a510e', $useragent);
        }

        if (preg_match('/ADR6230/i', $useragent)) {
            return $this->loader->load('adr6230', $useragent);
        }

        if (preg_match('/Wildfire[ |]S/i', $useragent)) {
            return $this->loader->load('htc a510', $useragent);
        }

        if (preg_match('/Wildfire/i', $useragent)) {
            return $this->loader->load('wildfire', $useragent);
        }

        if (preg_match('/Vision/i', $useragent)) {
            return $this->loader->load('vision', $useragent);
        }

        if (preg_match('/velocity[ _]4g[ _]x710s/i', $useragent)) {
            return $this->loader->load('x710s', $useragent);
        }

        if (preg_match('/velocity[ _]4g/i', $useragent)) {
            return $this->loader->load('velocity 4g', $useragent);
        }

        if (preg_match('/Velocity/i', $useragent)) {
            return $this->loader->load('velocity', $useragent);
        }

        if (preg_match('/Touch\_Diamond2/i', $useragent)) {
            return $this->loader->load('touch diamond 2', $useragent);
        }

        if (preg_match('/tattoo/i', $useragent)) {
            return $this->loader->load('tattoo', $useragent);
        }

        if (preg_match('/Touch\_Pro2\_T7373/i', $useragent)) {
            return $this->loader->load('t7373', $useragent);
        }

        if (preg_match('/Touch2/i', $useragent)) {
            return $this->loader->load('t3335', $useragent);
        }

        if (preg_match('/t329d/i', $useragent)) {
            return $this->loader->load('t329d', $useragent);
        }

        if (preg_match('/t328w/i', $useragent)) {
            return $this->loader->load('t328w', $useragent);
        }

        if (preg_match('/t328d/i', $useragent)) {
            return $this->loader->load('t328d', $useragent);
        }

        if (preg_match('/Smart\_F3188/i', $useragent)) {
            return $this->loader->load('smart f3188', $useragent);
        }

        if (preg_match('/ShooterU/i', $useragent)) {
            return $this->loader->load('shooter u', $useragent);
        }

        if (preg_match('/Salsa/i', $useragent)) {
            return $this->loader->load('salsa', $useragent);
        }

        if (preg_match('/butterfly_s_901s/i', $useragent)) {
            return $this->loader->load('s901s', $useragent);
        }

        if (preg_match('/(Incredible S|IncredibleS|S710e)/i', $useragent)) {
            return $this->loader->load('s710e', $useragent);
        }

        if (preg_match('/(Rhyme|S510b)/i', $useragent)) {
            return $this->loader->load('s510b', $useragent);
        }

        if (preg_match('/ruby/i', $useragent)) {
            return $this->loader->load('ruby', $useragent);
        }

        if (preg_match('/P3700/i', $useragent)) {
            return $this->loader->load('p3700', $useragent);
        }

        if (preg_match('/MDA\_Vario\_V/i', $useragent)) {
            return $this->loader->load('mda vario v', $useragent);
        }

        if (preg_match('/MDA Vario\/3/i', $useragent)) {
            return $this->loader->load('mda vario iii', $useragent);
        }

        if (preg_match('/MDA Vario\/2/i', $useragent)) {
            return $this->loader->load('mda vario ii', $useragent);
        }

        if (preg_match('/MDA\_Compact\_V/i', $useragent)) {
            return $this->loader->load('mda compact v', $useragent);
        }

        if (preg_match('/Magic/i', $useragent)) {
            return $this->loader->load('magic', $useragent);
        }

        if (preg_match('/Legend/i', $useragent)) {
            return $this->loader->load('legend', $useragent);
        }

        if (preg_match('/(Hero|a6288)/i', $useragent)) {
            return $this->loader->load('hero', $useragent);
        }

        if (preg_match('/Glacier/i', $useragent)) {
            return $this->loader->load('glacier', $useragent);
        }

        if (preg_match('/G21/i', $useragent)) {
            return $this->loader->load('g21', $useragent);
        }

        if (preg_match('/(Flyer[ |\_]P512)/i', $useragent)) {
            return $this->loader->load('p512', $useragent);
        }

        if (preg_match('/(Flyer[ |\_]P510e)/i', $useragent)) {
            return $this->loader->load('p510e', $useragent);
        }

        if (preg_match('/Flyer/i', $useragent)) {
            return $this->loader->load('flyer', $useragent);
        }

        if (preg_match('/(pc36100|evo 4g|kingdom)/i', $useragent)) {
            return $this->loader->load('pc36100', $useragent);
        }

        if (preg_match('/Dream/i', $useragent)) {
            return $this->loader->load('dream', $useragent);
        }

        if (preg_match('/D820mu/i', $useragent)) {
            return $this->loader->load('d820mu', $useragent);
        }

        if (preg_match('/D820us/i', $useragent)) {
            return $this->loader->load('d820us', $useragent);
        }

        if (preg_match('/click/i', $useragent)) {
            return $this->loader->load('click', $useragent);
        }

        if (preg_match('/eris/i', $useragent)) {
            return $this->loader->load('eris', $useragent);
        }

        if (preg_match('/ C2/i', $useragent)) {
            return $this->loader->load('c2', $useragent);
        }

        if (preg_match('/bravo/i', $useragent)) {
            return $this->loader->load('bravo', $useragent);
        }

        if (preg_match('/butterfly/i', $useragent)) {
            return $this->loader->load('butterfly', $useragent);
        }

        if (preg_match('/adr6350/i', $useragent)) {
            return $this->loader->load('adr6350', $useragent);
        }

        if (preg_match('/apa9292kt/i', $useragent)) {
            return $this->loader->load('9292', $useragent);
        }

        if (preg_match('/a9192/i', $useragent)) {
            return $this->loader->load('inspire 4g', $useragent);
        }

        if (preg_match('/APA7373KT/i', $useragent)) {
            return $this->loader->load('a7373', $useragent);
        }

        if (preg_match('/Gratia/i', $useragent)) {
            return $this->loader->load('a6380', $useragent);
        }

        if (preg_match('/A6366/i', $useragent)) {
            return $this->loader->load('a6366', $useragent);
        }

        if (preg_match('/A3335/i', $useragent)) {
            return $this->loader->load('a3335', $useragent);
        }

        if (preg_match('/chacha/i', $useragent)) {
            return $this->loader->load('a810e', $useragent);
        }

        if (preg_match('/a510a/i', $useragent)) {
            return $this->loader->load('a510a', $useragent);
        }

        if (preg_match('/(explorer|a310e)/i', $useragent)) {
            return $this->loader->load('a310e', $useragent);
        }

        if (preg_match('/amaze/i', $useragent)) {
            return $this->loader->load('amaze 4g', $useragent);
        }

        if (preg_match('/htc7088/i', $useragent)) {
            return $this->loader->load('7088', $useragent);
        }

        if (preg_match('/HTC6990LVW/', $useragent)) {
            return $this->loader->load('htc6990lvw', $useragent);
        }

        if (preg_match('/htc6500lvw/i', $useragent)) {
            return $this->loader->load('m7 (htc6500lvw)', $useragent);
        }

        if (preg_match('/htc6435lvw/i', $useragent)) {
            return $this->loader->load('htc6435lvw', $useragent);
        }

        if (preg_match('/htc 919d/i', $useragent)) {
            return $this->loader->load('919d', $useragent);
        }

        if (preg_match('/831c/i', $useragent)) {
            return $this->loader->load('831c', $useragent);
        }

        if (preg_match('/htc 809d/i', $useragent)) {
            return $this->loader->load('809d', $useragent);
        }

        if (preg_match('/htc[ ]?802t/i', $useragent)) {
            return $this->loader->load('802t', $useragent);
        }

        if (preg_match('/htc 802d/i', $useragent)) {
            return $this->loader->load('802d', $useragent);
        }

        if (preg_match('/htc 606w/i', $useragent)) {
            return $this->loader->load('desire 606w', $useragent);
        }

        if (preg_match('/htc d516d/i', $useragent)) {
            return $this->loader->load('desire 516', $useragent);
        }

        if (preg_match('/VPA\_Touch/i', $useragent)) {
            return $this->loader->load('vpa touch', $useragent);
        }

        if (preg_match('/HTC\_VPACompactIV/i', $useragent)) {
            return $this->loader->load('vpa compact iv', $useragent);
        }

        return $this->loader->load('general htc device', $useragent);
    }
}
