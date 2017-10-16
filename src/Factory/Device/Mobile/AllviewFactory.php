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
class AllviewFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'x2_soul'    => 'allview x2 soul',
        'x1_soul'    => 'allview x1 soul',
        'p5-mini'    => 'allview p5 mini',
        'p5_quad'    => 'allview p5 quad',
        'v1_viper_i' => 'allview v1 viper i',
        'v1_viper'   => 'allview v1 viper',
        'a4you'      => 'allview a4you',
        'ax4nano'    => 'allview ax4nano',
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

        return $this->loader->load('general allview device', $useragent);
    }
}
