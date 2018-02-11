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

class KazamFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'thunder2 50'  => 'kazam thunder2 50',
        'thunder q45'  => 'kazam thunder q45',
        'trooper2 50'  => 'kazam trooper 2 5.0',
        'trooper 455'  => 'kazam trooper 455',
        'trooper 451'  => 'kazam trooper 451',
        'trooper 450l' => 'kazam trooper 450l',
        'trooper_450l' => 'kazam trooper 450l',
        'trooper_x55'  => 'kazam trooper x55',
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

        return $this->loader->load('general kazam device', $useragent);
    }
}
