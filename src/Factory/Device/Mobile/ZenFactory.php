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

class ZenFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'cinemax click' => 'zen cinemax click',
        'cinemax_click' => 'zen cinemax click',
        'cinemax 3'     => 'zen cinemax 3',
        'cinemax 2+'    => 'zen cinemax 2+',
        'cinemax2'      => 'zen cinemax 2',
        'cinemax1'      => 'zen cinemax 1',
        'cinemax 4g'    => 'zen cinemax 4g',
        'cinemax_4g'    => 'zen cinemax 4g',
        'cinemax force' => 'zen cinemax force',
        'cinemax-force' => 'zen cinemax force',
        'admire sxy'    => 'zen admire sxy',
        '303'           => 'zen ultrafone 303',
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

        return $this->loader->load('general zen device', $useragent);
    }
}
