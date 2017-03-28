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
class ThlFactory implements Factory\FactoryInterface
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
        if ($s->contains('W200', true)) {
            return $this->loader->load('w200', $useragent);
        }

        if ($s->contains('W100', true)) {
            return $this->loader->load('w100', $useragent);
        }

        if ($s->containsAny(['W8_beyond', 'ThL W8'], true)) {
            return $this->loader->load('thl w8', $useragent);
        }

        if ($s->contains('ThL W7', true)) {
            return $this->loader->load('w7', $useragent);
        }

        if ($s->contains('T6S', true)) {
            return $this->loader->load('t6s', $useragent);
        }

        if ($s->contains('4400', true)) {
            return $this->loader->load('4400', $useragent);
        }

        if ($s->contains('thl 2015', false)) {
            return $this->loader->load('2015', $useragent);
        }

        return $this->loader->load('general thl device', $useragent);
    }
}
