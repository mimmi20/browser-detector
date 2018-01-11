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

class HisenseFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'hs-g610' => 'hisense hs-g610',
        'u972'    => 'hisense u972',
        'hs-u971' => 'hisense hs-u971',
        'hs-u970' => 'hisense hs-u970',
        'hs-u800' => 'hisense hs-u800',
        'hs-u606' => 'hisense hs-u606',
        'hs-u602' => 'hisense hs-u602',
        'hs-l691' => 'hisense hs-l691',
        'hs-e912' => 'hisense hs-e912',
        'f5281'   => 'hisense f5281',
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

        return $this->loader->load('general hisense device', $useragent);
    }
}
