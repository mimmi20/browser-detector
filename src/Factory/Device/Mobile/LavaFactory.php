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

class LavaFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        ' x17 '       => 'lava x17',
        'iris fuel60' => 'lava iris fuel60',
        'iris fuel50' => 'lava iris fuel50',
        'iris x8 l'   => 'lava iris x8 l',
        'iris x1'     => 'lava iris x1',
        'iris700'     => 'lava iris 700',
        'pixel v2+'   => 'lava pixel v2+',
        'iris x8s'    => 'lava iris x8s',
        'iris402+'    => 'lava iris 402+',
        'x1 atom'     => 'lava iris x1 atom',
        'x1 selfie'   => 'lava iris x1 selfie',
        'x5 4g'       => 'lava iris x5 4g',
        'spark284'    => 'lava spark 284',
        'kkt20'       => 'lava kkt20',
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

        return $this->loader->load('general lava device', $useragent);
    }
}
