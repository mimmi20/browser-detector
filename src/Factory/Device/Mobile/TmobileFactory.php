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
class TmobileFactory implements Factory\FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
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
        if ($s->contains('Pulse', true)) {
            return $this->loader->load('pulse', $useragent);
        }

        if ($s->contains('mytouch4g', false)) {
            return $this->loader->load('mytouch4g', $useragent);
        }

        if ($s->contains('mytouch 3g slide', false)) {
            return $this->loader->load('mytouch3g', $useragent);
        }

        if ($s->containsAny(['t-mobile_g2_touch', 't-mobile g2'], false)) {
            return $this->loader->load('g2 touch', $useragent);
        }

        if ($s->contains('t-mobile g1', false)) {
            return $this->loader->load('g1', $useragent);
        }

        if ($s->contains('mda compact/3', false)) {
            return $this->loader->load('mda compact iii', $useragent);
        }

        if ($s->contains('mda compact', false)) {
            return $this->loader->load('mda compact', $useragent);
        }

        if ($s->contains('Ameo', true)) {
            return $this->loader->load('ameo', $useragent);
        }

        return $this->loader->load('general t-mobile device', $useragent);
    }
}
