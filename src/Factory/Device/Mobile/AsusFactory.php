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
class AsusFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'p024'              => 'asus p024',
        'p00c'              => 'asus p00c',
        'k01h'              => 'asus k01h',
        'x013d'             => 'asus x013d',
        'tf101g'            => 'eee pad transformer tf101g',
        'z00ad'             => 'z00ad',
        'z007'              => 'asus z007',
        't00i'              => 'asus t00i',
        'k00c'              => 'k00c',
        'k00f'              => 'k00f',
        'k00z'              => 'k00z',
        'k01e'              => 'k01e',
        'k01a'              => 'k01a',
        'k019'              => 'asus k019',
        'k017'              => 'k017',
        'k013'              => 'k013',
        'k012'              => 'k012',
        'k011'              => 'asus k011',
        'k00e'              => 'k00e',
        'me372cg'           => 'k00e',
        'me172v'            => 'me172v',
        'me173x'            => 'me173x',
        'me301t'            => 'me301t',
        'me302c'            => 'me302c',
        'me302kl'           => 'me302kl',
        'me371mg'           => 'me371mg',
        'p1801-t'           => 'p1801-t',
        't00j'              => 't00j',
        't00n'              => 't00n',
        't00q'              => 'asus t00q',
        'p01y'              => 'p01y',
        'tf101'             => 'tf101',
        'tf300tl'           => 'tf300tl',
        'tf300tg'           => 'tf300tg',
        'tf300t'            => 'tf300t',
        'tf700t'            => 'tf700t',
        'slider sl101'      => 'sl101',
        'garmin-asus a50'   => 'a50',
        'garmin-asus a10'   => 'asus a10',
        'transformer tf201' => 'asus eee pad tf201',
        'transformer prime' => 'asus eee pad tf201',
        'padfone t004'      => 'padfone t004',
        'padfone 2'         => 'a68',
        'padfone'           => 'padfone',
        'nexus 7'           => 'nexus 7',
        'nexus_7'           => 'nexus 7',
        'nexus7'            => 'nexus 7',
        'asus;galaxy6'      => 'galaxy6',
        'eee_701'           => 'eee 701',
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

        return $this->loader->load('general asus device', $useragent);
    }
}
