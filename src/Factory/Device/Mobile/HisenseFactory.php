<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class HisenseFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'e621t'     => 'hisense e621t',
        'eg680'     => 'hisense eg680',
        'i639t'     => 'hisense i639t',
        'i639m'     => 'hisense i639m',
        'u972'      => 'hisense u972',
        'e2281uk'   => 'hisense e2281uk',
        'hs-x68t'   => 'hisense hs-x68t',
        'hs-x8t'    => 'hisense hs-x8t',
        'hs-x8c'    => 'hisense hs-x8c',
        'hs-x1'     => 'hisense hs-x1',
        'hs-u980'   => 'hisense hs-u980',
        'hs-u971'   => 'hisense hs-u971',
        'hs-u970'   => 'hisense hs-u970',
        'hs-u966'   => 'hisense hs-u966',
        'hs-u950'   => 'hisense hs-u950',
        'hs-u939'   => 'hisense hs-u939',
        'hs-u929'   => 'hisense hs-u929',
        'hs-u912c'  => 'hisense hs-u912c',
        'hs-u912'   => 'hisense hs-u912',
        'hs-u850'   => 'hisense hs-u850',
        'hs-u820'   => 'hisense hs-u820',
        'hs-u800'   => 'hisense hs-u800',
        'hs-u606'   => 'hisense hs-u606',
        'hs-u602'   => 'hisense hs-u602',
        'hs-u98'    => 'hisense hs-u98',
        'hs-u8'     => 'hisense hs-u8',
        'hs-t959s1' => 'hisense hs-t959s1',
        'hs-t958'   => 'hisense hs-t958',
        'hs-t912'   => 'hisense hs-t912',
        'hs-t96'    => 'hisense hs-t96',
        'hs-t39'    => 'hisense hs-t39',
        'hs-l691'   => 'hisense hs-l691',
        'hs-i630t'  => 'hisense hs-i630t',
        'hs-i630m'  => 'hisense hs-i630m',
        'hs-g610'   => 'hisense hs-g610',
        'hs-eg970'  => 'hisense hs-eg970',
        'hs-e968'   => 'hisense hs-e968',
        'hs-e920'   => 'hisense hs-e920',
        'hs-e912'   => 'hisense hs-e912',
        'f5281'     => 'hisense f5281',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general hisense device';

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

        return $this->loader->load($this->genericDevice, $useragent);
    }
}
