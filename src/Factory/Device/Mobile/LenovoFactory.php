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
class LenovoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'yt3-x90l'                => 'lenovo yt3-x90l',
        'p1a42'                   => 'lenovo p1a42',
        'a7-20f'                  => 'lenovo a7-20f',
        'a7-30hc'                 => 'lenovo a7-30hc',
        'a7-30h'                  => 'lenovo a7-30h',
        'p2a42'                   => 'lenovo p2a42',
        'tb3-710f'                => 'lenovo tb3-710f',
        'a936'                    => 'lenovo a936',
        'a2010-a'                 => 'lenovo a2010-a',
        'tb2-x30l'                => 'lenovo tb2-x30l',
        's8-50l'                  => 'lenovo s8-50l',
        'a7-30f'                  => 'lenovo a7-30f',
        'tb3-850m'                => 'lenovo tb3-850m',
        'tb3-710i'                => 'lenovo tb3-710i',
        's860'                    => 'lenovo s860',
        'a806t'                   => 'lenovo a806t',
        'a806'                    => 'lenovo a806',
        'a269i'                   => 'lenovo a269i',
        'a2016a40'                => 'lenovo a2016a40',
        'a6020a40'                => 'lenovo a6020a40',
        'yt3-x50l'                => 'yt3-x50l',
        'tb2-x30f'                => 'tb2-x30f',
        'yoga tablet 2 pro-1380l' => '1380l',
        'yoga tablet 2 pro-1380f' => '1380f',
        'yoga tablet 2-1050l'     => '1050l',
        'yoga tablet 2-1050f'     => '1050f',
        'yoga tablet 2-830l'      => '830l',
        'yoga tablet 2-830f'      => '830f',
        'a10-70f'                 => 'a10-70f',
        's6000l-f'                => 's6000l-f',
        's6000-h'                 => 's6000-h',
        's6000-f'                 => 's6000-f',
        's5000-h'                 => 's5000-h',
        's5000-f'                 => 's5000-f',
        'ideatabs2110ah'          => 's2110a-h',
        'ideatabs2110af'          => 's2110a-f',
        'ideatabs2109a-f'         => 's2109a-f',
        's920'                    => 's920',
        's880i'                   => 's880i',
        's856'                    => 's856',
        's820_row'                => 's820_row',
        's720'                    => 's720',
        's660'                    => 's660',
        'p1050x'                  => 'lifetab p1050x',
        'p1032x'                  => 'lifetab p1032x',
        'p780'                    => 'p780',
        'p70-a'                   => 'lenovo p70-a',
        'p70'                     => 'lenovo p70',
        'k910l'                   => 'k910l',
        'k900'                    => 'k900',
        ' k1'                     => 'k1',
        'ideapada10'              => 'ideapad a10',
        'a1_07'                   => 'ideapad a1',
        'b8080-h'                 => 'b8080-h',
        'b8080-f'                 => 'b8080-f',
        'b8000-h'                 => 'b8000-h',
        'b8000-f'                 => 'b8000-f',
        'b6000-hv'                => 'b6000-hv',
        'b6000-h'                 => 'b6000-h',
        'b6000-f'                 => 'b6000-f',
        'a7600-h'                 => 'a7600-h',
        'a7600-f'                 => 'a7600-f',
        'a7000-a'                 => 'a7000-a',
        'a5500-h'                 => 'a5500-h',
        'a5500-f'                 => 'a5500-f',
        'a3500-hv'                => 'a3500-hv',
        'a3500-h'                 => 'a3500-h',
        'a3500-fl'                => 'a3500-fl',
        'a3300-hv'                => 'a3300-hv',
        'a3300-h'                 => 'a3300-h',
        'a3300-gv'                => 'a3300-gv',
        'a3000-h'                 => 'a3000-h',
        'a2107a-h'                => 'a2107a-h',
        'a1107'                   => 'a1107',
        'a1000-f'                 => 'a1000-f',
        'a1000l-f'                => 'a1000l-f',
        'a1000'                   => 'a1000',
        'a2109a'                  => 'a2109a',
        'ideatab'                 => 'a2109a',
        'a889'                    => 'a889',
        'a880'                    => 'a880',
        'a850+'                   => 'a850+',
        'a850'                    => 'a850',
        'a820'                    => 'a820',
        'a816'                    => 'a816',
        'a789'                    => 'a789',
        'a766'                    => 'a766',
        'a680'                    => 'lenovo a680',
        'a660'                    => 'a660',
        'a656'                    => 'a656',
        'a606'                    => 'a606',
        'a590'                    => 'a590',
        'a536'                    => 'a536',
        'a390'                    => 'a390',
        'a388t'                   => 'a388t',
        'a328'                    => 'a328',
        'a319'                    => 'a319',
        'a316'                    => 'lenovo a316',
        'a308t'                   => 'lenovo a308t',
        'a288t'                   => 'a288t',
        'a65'                     => 'a65',
        'a60'                     => 'a60',
        'smarttabiii10'           => 'smart tab iii 10',
        'smart tab iii 10'        => 'smart tab iii 10',
        'smarttabii10'            => 'smarttab ii 10',
        'smarttab ii 10'          => 'smarttab ii 10',
        'smarttabii7'             => 'smarttab ii 7',
        'smart tab 4g'            => 'smart tab 4g',
        'smart tab 3g'            => 'smart tab 3g',
        'thinkpad'                => '1838',
        'at1010-t'                => 'at1010-t',
        'smart tab iii 7'         => 'smart tab iii 7',
        'smarttabiii7'            => 'smart tab iii 7',
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

        return $this->loader->load('general lenovo device', $useragent);
    }
}
