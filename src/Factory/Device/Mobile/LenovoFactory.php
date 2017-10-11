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
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

/**
 * @author Thomas Müller <mimmi20@live.de>
 */
class LenovoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'x1030x'                  => 'lenovo x1030x',
        'zuk z1'                  => 'lenovo zuk z1',
        'k80m'                    => 'lenovo k80m',
        'yb1-x90l'                => 'lenovo yb1-x90l',
        'yt3-x90f'                => 'lenovo yt3-x90f',
        'yt3-x50f'                => 'lenovo yt3-x50f',
        'yt3-850m'                => 'lenovo yt3-850m',
        'k50a40'                  => 'lenovo k50a40',
        'k33a48'                  => 'lenovo k33a48',
        'k10a40'                  => 'lenovo k10a40',
        'z2121'                   => 'lenovo z2121',
        's1032x'                  => 'lenovo s1032x',
        's1a40'                   => 'lenovo s1a40',
        'p770'                    => 'lenovo p770',
        'k50-t5'                  => 'lenovo k50-t5',
        'tb3-x70f'                => 'lenovo tb3-x70f',
        'tb3-x70l'                => 'lenovo tb3-x70l',
        'tb3-850m'                => 'lenovo tb3-850m',
        'tb3-710i'                => 'lenovo tb3-710i',
        'tb3-710f'                => 'lenovo tb3-710f',
        'tb2-x30l'                => 'lenovo tb2-x30l',
        'tb2-x30f'                => 'lenovo tb2-x30f',
        'tb-7703x'                => 'lenovo tb-7703x',
        'yt3-x90l'                => 'lenovo yt3-x90l',
        'p1a42'                   => 'lenovo p1a42',
        'p2a42'                   => 'lenovo p2a42',
        ' p2 '                    => 'lenovo p2a42',
        's8-50f'                  => 'lenovo s8-50f',
        's8-50l'                  => 'lenovo s8-50l',
        's6000d'                  => 'lenovo s6000d',
        's860'                    => 'lenovo s860',
        'yt3-x50l'                => 'lenovo yt3-x50l',
        'yoga tablet 2 pro-1380l' => 'lenovo 1380l',
        'yoga tablet 2 pro-1380f' => 'lenovo 1380f',
        'yoga tablet 2-1050l'     => 'lenovo 1050l',
        'yoga tablet 2-1050f'     => 'lenovo 1050f',
        'yoga tablet 2-830l'      => 'lenovo 830l',
        'yoga tablet 2-830f'      => 'lenovo 830f',
        's6000l-f'                => 'lenovo s6000l-f',
        's6000-h'                 => 'lenovo s6000-h',
        's6000-f'                 => 'lenovo s6000-f',
        's5000-h'                 => 'lenovo s5000-h',
        's5000-f'                 => 'lenovo s5000-f',
        'ideatabs2110ah'          => 'lenovo s2110a-h',
        'ideatabs2110af'          => 'lenovo s2110a-f',
        'ideatabs2109a-f'         => 'lenovo s2109a-f',
        's920'                    => 'lenovo s920',
        's880i'                   => 'lenovo s880i',
        's856'                    => 'lenovo s856',
        's820_row'                => 'lenovo s820_row',
        's720'                    => 'lenovo s720',
        's660'                    => 'lenovo s660',
        'p780'                    => 'lenovo p780',
        'p70-a'                   => 'lenovo p70-a',
        'p70'                     => 'lenovo p70',
        'k910l'                   => 'lenovo k910l',
        'k900'                    => 'lenovo k900',
        ' k1'                     => 'lenovo k1',
        'ideapada10'              => 'lenovo ideapad a10',
        'a1_07'                   => 'lenovo ideapad a1',
        'b8080-h'                 => 'lenovo b8080-h',
        'b8080-f'                 => 'lenovo b8080-f',
        'b8000-h'                 => 'lenovo b8000-h',
        'b8000-f'                 => 'lenovo b8000-f',
        'b6000-hv'                => 'lenovo b6000-hv',
        'b6000-h'                 => 'lenovo b6000-h',
        'b6000-f'                 => 'lenovo b6000-f',
        'b5060'                   => 'lenovo b5060',
        'a10-70l'                 => 'lenovo a10-70l',
        'a10-70f'                 => 'lenovo a10-70f',
        'a8-50l'                  => 'lenovo a8-50l',
        'a7-30hc'                 => 'lenovo a7-30hc',
        'a7-30h'                  => 'lenovo a7-30h',
        'a7-30dc'                 => 'lenovo a7-30dc',
        'a7-10f'                  => 'lenovo a7-10f',
        'a7-20f'                  => 'lenovo a7-20f',
        'a7-30f'                  => 'lenovo a7-30f',
        'a7600-h'                 => 'lenovo a7600-h',
        'a7600-f'                 => 'lenovo a7600-f',
        'a7000-a'                 => 'lenovo a7000-a',
        'a6020a40'                => 'lenovo a6020a40',
        'a6000'                   => 'lenovo a6000',
        'a5500-h'                 => 'lenovo a5500-h',
        'a5500-f'                 => 'lenovo a5500-f',
        'a5000'                   => 'lenovo a5000',
        'a3500-hv'                => 'lenovo a3500-hv',
        'a3500-h'                 => 'lenovo a3500-h',
        'a3500-fl'                => 'lenovo a3500-fl',
        'a3500-f'                 => 'lenovo a3500-f',
        'a3300-hv'                => 'lenovo a3300-hv',
        'a3300-h'                 => 'lenovo a3300-h',
        'a3300-gv'                => 'lenovo a3300-gv',
        'a3000-h'                 => 'lenovo a3000-h',
        'a2107a-h'                => 'lenovo a2107a-h',
        'a2016a40'                => 'lenovo a2016a40',
        'a2010-a'                 => 'lenovo a2010-a',
        'a1107'                   => 'lenovo a1107',
        'a1000-f'                 => 'lenovo a1000-f',
        'a1000l-f'                => 'lenovo a1000l-f',
        'a1000'                   => 'lenovo a1000',
        'a2109a'                  => 'lenovo a2109a',
        'ideatab'                 => 'lenovo a2109a',
        'a936'                    => 'lenovo a936',
        'a889'                    => 'lenovo a889',
        'a880'                    => 'lenovo a880',
        'a850+'                   => 'lenovo a850+',
        'a850'                    => 'lenovo a850',
        'a820'                    => 'lenovo a820',
        'a816'                    => 'lenovo a816',
        'a806t'                   => 'lenovo a806t',
        'a806'                    => 'lenovo a806',
        'a789'                    => 'lenovo a789',
        'a766'                    => 'lenovo a766',
        'a680'                    => 'lenovo a680',
        'a660'                    => 'lenovo a660',
        'a656'                    => 'lenovo a656',
        'a616'                    => 'lenovo a616',
        'a606'                    => 'lenovo a606',
        'a590'                    => 'lenovo a590',
        'a536'                    => 'lenovo a536',
        'a526'                    => 'lenovo a526',
        'a390'                    => 'lenovo a390',
        'a388t'                   => 'lenovo a388t',
        'a328'                    => 'lenovo a328',
        'a319'                    => 'lenovo a319',
        'a316'                    => 'lenovo a316',
        'a308t'                   => 'lenovo a308t',
        'a288t'                   => 'lenovo a288t',
        'a269i'                   => 'lenovo a269i',
        'a65'                     => 'lenovo a65',
        'a60'                     => 'lenovo a60',
        'smarttabiii10'           => 'lenovo smart tab iii 10',
        'smart tab iii 10'        => 'lenovo smart tab iii 10',
        'smarttabii10'            => 'lenovo smarttab ii 10',
        'smarttab ii 10'          => 'lenovo smarttab ii 10',
        'smarttabii7'             => 'lenovo smarttab ii 7',
        'smart tab 4g'            => 'lenovo smart tab 4g',
        'smart tab 3g'            => 'lenovo smart tab 3g',
        'thinkpad'                => 'lenovo 1838',
        'at1010-t'                => 'lenovo at1010-t',
        'smart tab iii 7'         => 'lenovo smart tab iii 7',
        'smarttabiii7'            => 'lenovo smart tab iii 7',
    ];

    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
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
    public function detect(string $useragent, Stringy $s): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general lenovo device', $useragent);
    }
}
