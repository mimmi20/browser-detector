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
        'z00ud'             => 'asus z00ud',
        'z00ed'             => 'asus z00ed',
        'z012d'             => 'asus z012d',
        'z01bd'             => 'asus z01bd',
        'p022'              => 'asus p022',
        'k00r'              => 'asus k00r',
        'z00yd'             => 'asus z00yd',
        'z010dd'            => 'asus z010dd',
        'k018'              => 'asus k018',
        'x00dd'             => 'asus x00dd',
        'z016d'             => 'asus z016d',
        'p024'              => 'asus p024',
        'p00c'              => 'asus p00c',
        'k01h'              => 'asus k01h',
        'x013d'             => 'asus x013d',
        'tf101g'            => 'asus eee pad transformer tf101g',
        'z00ad'             => 'asus z00ad',
        'z007'              => 'asus z007',
        't00i'              => 'asus t00i',
        'k00c'              => 'asus k00c',
        'k00f'              => 'asus k00f',
        'k00z'              => 'asus k00z',
        'k01e'              => 'asus k01e',
        'k01a'              => 'asus k01a',
        'k019'              => 'asus k019',
        'k017'              => 'asus k017',
        'k013'              => 'asus k013',
        'k012'              => 'asus k012',
        'k011'              => 'asus k011',
        'k00e'              => 'asus k00e',
        'me372cg'           => 'asus k00e',
        'me172v'            => 'asus me172v',
        'me173x'            => 'asus me173x',
        'me301t'            => 'asus me301t',
        'me302c'            => 'asus me302c',
        'me302kl'           => 'asus me302kl',
        'me371mg'           => 'asus me371mg',
        'p1801-t'           => 'asus p1801-t',
        't00j'              => 'asus t00j',
        't00n'              => 'asus t00n',
        't00q'              => 'asus t00q',
        'p01y'              => 'asus p01y',
        'tf101'             => 'asus tf101',
        'tf300tl'           => 'asus tf300tl',
        'tf300tg'           => 'asus tf300tg',
        'tf300t'            => 'asus tf300t',
        'tf700t'            => 'asus tf700t',
        'slider sl101'      => 'asus sl101',
        'garmin-asus a50'   => 'asus a50',
        'garmin-asus a10'   => 'asus a10',
        'transformer tf201' => 'asus eee pad tf201',
        'transformer prime' => 'asus eee pad tf201',
        'padfone t004'      => 'asus padfone t004',
        'padfone 2'         => 'asus a68',
        'padfone'           => 'asus padfone',
        'nexus 7'           => 'asus nexus 7',
        'nexus_7'           => 'asus nexus 7',
        'nexus7'            => 'asus nexus 7',
        'asus;galaxy6'      => 'asus galaxy6',
        'eee_701'           => 'asus eee 701',
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
