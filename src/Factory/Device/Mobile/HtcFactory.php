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
     * @var array
     */
    private $devices = [
        ' x9 '                    => 'x9',
        'one me dual sim'                 => 'htc one me dual sim',
        '0pcv1'                 => 'htc 0pcv1',
        'nexus one'               => 'nexus one',
        'nexus-one'               => 'nexus one',
        'nexusone'                => 'nexus one',
        'nexus 9'                 => 'nexus 9',
        'nexushd2'                => 'nexus hd2',
        'nexus evohd2'            => 'nexus hd2',
        '8x by htc'               => 'windows phone 8x',
        'pm23300'                 => 'windows phone 8x',
        '8s by htc'               => '8s',
        'radar c110e'             => 'radar c110e',
        'radar; orange'           => 'radar c110e',
        'radar 4g'                => 'radar 4g',
        'radar'                   => 'radar',
        'hd7'                     => 't9292',
        'mondrian'                => 't9292',
        '7 mozart'                => 't8698',
        't8282'                   => 'touch hd t8282',
        '7 pro t7576'             => 't7576',
        'hd2_t8585'               => 't8585',
        'htc hd2'                 => 'htc hd2',
        'htc_hd2'                 => 'hd2',
        'hd mini'                 => 'mini t5555',
        'hd_mini'                 => 'mini t5555',
        'titan'                   => 'x310e',
        '7 trophy'                => 'spark',
        'mwp6985'                 => 'spark',
        '0p6b180'                 => '0p6b180',
        'one_m9plus'              => 'm9 plus',
        'one m9plus'              => 'm9 plus',
        'one_m9'                  => 'm9',
        'one m9'                  => 'm9',
        'one_m8s'                 => 'm8s',
        'one m8s'                 => 'm8s',
        'one_m8'                  => 'htc m8',
        'one m8'                  => 'htc m8',
        'pn07120'                 => 'pn07120',
        'pn071'                   => 'htc pn071',
        'one x+'                  => 'pm63100',
        'one_x+'                  => 'pm63100',
        'onexplus'                => 'pm63100',
        'one xl'                  => 'htc pj83100',
        'one_xl'                  => 'htc pj83100',
        'one x'                   => 'pj83100',
        'one_x'                   => 'pj83100',
        'onex'                    => 'pj83100',
        'pj83100'                 => 'pj83100',
        'one v'                   => 'one v',
        'one_v'                   => 'one v',
        'one sv'                  => 'one sv',
        'one_sv'                  => 'one sv',
        'onesv'                   => 'one sv',
        'one s'                   => 'pj401',
        'one_s'                   => 'pj401',
        'ones'                    => 'pj401',
        'one mini 2'              => 'one mini 2',
        'one_mini_2'              => 'one mini 2',
        'one mini'                => 'one mini',
        'one_mini'                => 'one mini',
        'one max'                 => 'one max',
        'one_max'                 => 'one max',
        'himauhl_htc_asia_tw'     => 'one max',
        'x315e'                   => 'htc x315e',
        'runnymede'               => 'htc x315e',
        'sensation 4g'            => 'sensation 4g',
        'sensation_4g'            => 'sensation 4g',
        'sensation xl'            => 'htc x315e',
        'sensationxl'             => 'htc x315e',
        'sensation xe'            => 'sensation xe beats z715e',
        'sensationxe'             => 'sensation xe beats z715e',
        'htc_sensation-orange-ls' => 'htc z710 ls',
        'htc_sensation-ls'        => 'htc z710 ls',
        'sensation z710e'         => 'z710e',
        'sensation_z710e'         => 'z710e',
        'sensation'               => 'htc z710',
        'pyramid'                 => 'htc z710',
        'evo 3d gsm'              => 'evo 3d gsm',
        'x515a'                   => 'x515a',
        'x515c'                   => 'x515c',
        'x515e'                   => 'x515e',
        'evo 3d'                  => 'x515m',
        'evo_3d'                  => 'x515m',
        'evo3d'                   => 'x515m',
        'x515m'                   => 'x515m',
        'x515'                    => 'x515',
        'desirez_a7272'           => 'a7272',
        'desire z'                => 'desire z',
        'desire_z'                => 'desire z',
        'desirez'                 => 'desire z',
        'desire x'                => 't328e',
        'desire_x'                => 't328e',
        'desirex'                 => 't328e',
        'desire v'                => 'desire v',
        'desire_v'                => 'desire v',
        'desirev'                 => 'desire v',
        's510e'                   => 's510e',
        'desire sv'               => 'desire sv',
        'desire_sv'               => 'desire sv',
        'desiresv'                => 'desire sv',
        'desire s'                => 'desire s',
        'desire_s'                => 'desire s',
        'desires'                 => 'desire s',
        'desirehd-orange-ls'      => 'desire hd ls',
        'a9191'                   => 'a9191',
        'a9192'                   => 'inspire 4g',
        'desire hd'               => 'desire hd',
        'desirehd'                => 'desire hd',
        'desire c'                => '1000c',
        'desire_c'                => '1000c',
        'desirec'                 => '1000c',
        'desire 820s'             => 'desire 820s',
        'desire_820s'             => 'desire 820s',
        'desire_820'              => 'desire 820',
        'desire 820'              => 'desire 820',
        'desire 816g'             => 'desire 816g',
        'desire_816g'             => 'desire 816g',
        'desire 816'              => 'desire 816',
        'desire_816'              => 'desire 816',
        '0p4e2'                   => '0p4e2',
        'desire 601'              => '0p4e2',
        'desire_601'              => '0p4e2',
        'desire 728g'             => 'desire 728g',
        'desire_728g'             => 'desire 728g',
        'desire 728'             => 'htc desire 728',
        'desire 700'              => 'desire 700',
        'desire_700'              => 'desire 700',
        'desire 626g'             => 'desire 626g',
        'desire_626g'             => 'desire 626g',
        'desire 626'              => 'desire 626',
        'desire_626'              => 'desire 626',
        'desire 620g'             => 'desire 620g',
        'desire_620g'             => 'desire 620g',
        'desire 610'              => 'desire 610',
        'desire_610'              => 'desire 610',
        'desire 600c'             => 'desire 600c',
        'desire_600c'             => 'desire 600c',
        'desire 600'              => 'desire 600',
        'desire_600'              => 'desire 600',
        'desire 530'              => 'desire 530',
        'desire_530'              => 'desire 530',
        'desire 526g'             => 'desire 526g',
        'desire_526g'             => 'desire 526g',
        'desire 516'              => 'desire 516',
        'desire_516'              => 'desire 516',
        'desire 510'              => 'desire 510',
        'desire_510'              => 'desire 510',
        'desire 500'              => 'desire 500',
        'desire_500'              => 'desire 500',
        'desire 400'              => 'desire 400',
        'desire_400'              => 'desire 400',
        'desire 320'              => 'desire 320',
        'desire_320'              => 'desire 320',
        'desire 310'              => 'desire 310',
        'desire_310'              => 'desire 310',
        'desire 300'              => 'desire 300',
        'desire_300'              => 'desire 300',
        'desire eye'              => 'desire eye',
        'desire_eye'              => 'desire eye',
        'desire_a8181'            => 'a8181',
        'desire'                  => 'desire',
        'wildfires-orange-ls'     => 'wildfire s ls',
        'wildfires-ls'            => 'wildfire s ls',
        ' a315c '                 => 'a315c',
        'a510a'                   => 'a510a',
        'wildfire_a3333'          => 'a3333',
        'wildfire s a510e'        => 'a510e',
        'wildfires_a510e'         => 'a510e',
        'adr6230'                 => 'adr6230',
        'wildfire s'              => 'htc a510',
        'wildfires'               => 'htc a510',
        'wildfire'                => 'wildfire',
        'vision'                  => 'vision',
        'velocity 4g x710s'       => 'x710s',
        'velocity_4g_x710s'       => 'x710s',
        'velocity 4g'             => 'velocity 4g',
        'velocity_4g'             => 'velocity 4g',
        'velocity'                => 'velocity',
        'touch_diamond2'          => 'touch diamond 2',
        'tattoo'                  => 'tattoo',
        'touch_pro2_t7373'        => 't7373',
        'touch2'                  => 't3335',
        't329d'                   => 't329d',
        't328w'                   => 't328w',
        't328d'                   => 't328d',
        'smart_f3188'             => 'smart f3188',
        'shooteru'                => 'shooter u',
        'salsa'                   => 'salsa',
        'butterfly_s_901s'        => 's901s',
        'incredible s'            => 's710e',
        'incredibles'             => 's710e',
        's710e'                   => 's710e',
        'rhyme'                   => 's510b',
        's510b'                   => 's510b',
        'ruby'                    => 'ruby',
        'p3700'                   => 'p3700',
        'magic'                   => 'magic',
        'legend'                  => 'legend',
        'hero'                    => 'hero',
        'a6288'                   => 'hero',
        'glacier'                 => 'glacier',
        'g21'                     => 'g21',
        'flyer p512'              => 'p512',
        'flyer_p512'              => 'p512',
        'flyer p510e'             => 'p510e',
        'flyer_p510e'             => 'p510e',
        'flyer'                   => 'flyer',
        'pc36100'                 => 'pc36100',
        'evo 4g'                  => 'pc36100',
        'kingdom'                 => 'pc36100',
        'dream'                   => 'dream',
        'd820mu'                  => 'd820mu',
        'd820us'                  => 'd820us',
        'click'                   => 'click',
        'eris'                    => 'eris',
        ' c2'                     => 'c2',
        'bravo'                   => 'bravo',
        'butterfly'               => 'butterfly',
        'adr6350'                 => 'adr6350',
        'gratia'                  => 'a6380',
        'a6380'                   => 'a6380',
        'a6366'                   => 'a6366',
        'a3335'                   => 'a3335',
        'chacha'                  => 'a810e',
        'explorer'                => 'a310e',
        'a310e'                   => 'a310e',
        'amaze'                   => 'amaze 4g',
        'htc7088'                 => '7088',
        'htc6990lvw'              => 'htc6990lvw',
        'htc6500lvw'              => 'm7 (htc6500lvw)',
        'htc6435lvw'              => 'htc6435lvw',
        'htc 919d'                => '919d',
        '831c'                    => '831c',
        'htc 809d'                => '809d',
        'htc 802t'                => '802t',
        'htc802t'                 => '802t',
        'htc 802d'                => '802d',
        'htc 606w'                => 'desire 606w',
        'htc d516d'               => 'desire 516',
        'vpa_touch'               => 'vpa touch',
        'htc_vpacompactiv'        => 'vpa compact iv',
    ];

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
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->containsAny(['One', 'ONE'], true)) {
            return $this->loader->load('m7', $useragent);
        }

        return $this->loader->load('general htc device', $useragent);
    }
}
