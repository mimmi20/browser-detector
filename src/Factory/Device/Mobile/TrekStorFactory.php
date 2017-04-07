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
use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class TrekStorFactory implements Factory\FactoryInterface
{
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
        if ($s->contains('SurfTab duo W1 10.1', true)) {
            return $this->loader->load('surftab duo w1 10.1', $useragent);
        }

        if ($s->contains('WP 4.7', true)) {
            return $this->loader->load('winphone 4.7 hd', $useragent);
        }

        if ($s->contains('VT10416-2', true)) {
            return $this->loader->load('vt10416-2', $useragent);
        }

        if ($s->contains('VT10416-1', true)) {
            return $this->loader->load('vt10416-1', $useragent);
        }

        if ($s->containsAny(['ST701041', 'SurfTab_7.0'], true)) {
            return $this->loader->load('st701041', $useragent);
        }

        if ($s->contains('ST10216-2', true)) {
            return $this->loader->load('st10216-2', $useragent);
        }

        if ($s->contains('ST80216', true)) {
            return $this->loader->load('st80216', $useragent);
        }

        if ($s->contains('ST80208', true)) {
            return $this->loader->load('st80208', $useragent);
        }

        if ($s->contains('ST70104', true)) {
            return $this->loader->load('st70104', $useragent);
        }

        if ($s->contains('ST10416-1', true)) {
            return $this->loader->load('st10416-1', $useragent);
        }

        if ($s->contains('ST10216-1', true)) {
            return $this->loader->load('st10216-1', $useragent);
        }

        if ($s->contains('trekstor_liro_color', true)) {
            return $this->loader->load('liro color', $useragent);
        }

        if ($s->contains('breeze 10.1 quad', true)) {
            return $this->loader->load('surftab breeze 10.1 quad', $useragent);
        }

        return $this->loader->load('general trekstor device', $useragent);
    }
}
