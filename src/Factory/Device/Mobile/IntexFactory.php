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

class IntexFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'aqua n11'     => 'intex aqua n11',
        'aqua trend'   => 'intex aqua trend',
        'aqua power+'  => 'intex aqua power+',
        'aqua_lifeiii' => 'intex aqua life iii',
        'aqua life ii' => 'intex aqua life ii',
        'aqua star ii' => 'intex aqua star ii',
        'aqua star 4g' => 'intex aqua star 4g',
        'aqua star'    => 'intex aqua star',
        'aqua_star'    => 'intex aqua star',
        'aqua_y2+'     => 'intex aqua y2+',
        'cloud_m5_ii'  => 'intex cloud m5 ii',
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

        return $this->loader->load('general intex device', $useragent);
    }
}
