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

class AsusFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'a001'              => 'asus a001',
        'p00c'              => 'asus p00c',
        'p01y'              => 'asus p01y',
        'p01t_1'            => 'asus p01t_1',
        'p021'              => 'asus p021',
        'p022'              => 'asus p022',
        'p023'              => 'asus p023',
        'p024'              => 'asus p024',
        'p027'              => 'asus p027',
        'x00dd'             => 'asus x00dd',
        'x013d'             => 'asus x013d',
        'z00ld'             => 'asus z00ld',
        'z007'              => 'asus z007',
        'z002'              => 'asus z002',
        'z00ad'             => 'asus z00ad',
        'z00ed'             => 'asus z00ed',
        'z00ud'             => 'asus z00ud',
        'z00yd'             => 'asus z00yd',
        'z010dd'            => 'asus z010dd',
        'z010d'             => 'asus z010d',
        'z012d'             => 'asus z012d',
        'z016d'             => 'asus z016d',
        'z017da'            => 'asus z017da',
        'z017db'            => 'asus z017db',
        'z017d'             => 'asus z017d',
        'z01bd'             => 'asus z01bd',
        't00i'              => 'asus t00i',
        'k00c'              => 'asus k00c',
        'k00e'              => 'asus k00e',
        'me372cg'           => 'asus k00e',
        'k00f'              => 'asus k00f',
        'k00g'              => 'asus k00g',
        'k00r'              => 'asus k00r',
        'k00z'              => 'asus k00z',
        'k007'              => 'asus k007',
        'k010'              => 'asus k010',
        'k011'              => 'asus k011',
        'k012'              => 'asus k012',
        'k013'              => 'asus k013',
        'k015'              => 'asus k015',
        'k016'              => 'asus k016',
        'k017'              => 'asus k017',
        'k018'              => 'asus k018',
        'tpad_10'           => 'asus k018',
        'k019'              => 'asus k019',
        'k01a'              => 'asus k01a',
        'k01b'              => 'asus k01b',
        'k01e'              => 'asus k01e',
        'k01h'              => 'asus k01h',
        'me172v'            => 'asus me172v',
        'me173x'            => 'asus me173x',
        'me301t'            => 'asus me301t',
        'me302c'            => 'asus me302c',
        'me302kl'           => 'asus me302kl',
        'me371mg'           => 'asus me371mg',
        'p1801-t'           => 'asus p1801-t',
        'tx201la'           => 'asus tx201la',
        't00j'              => 'asus t00j',
        't00n'              => 'asus t00n',
        't00q'              => 'asus t00q',
        'tf101g'            => 'asus eee pad transformer tf101g',
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
        'nuvifone-m10'      => 'asus nuvifone m10',
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

        return $this->loader->load('general asus device', $useragent);
    }
}
