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
class CatSoundFactory implements Factory\FactoryInterface
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
        if ($s->contains('CatNova8', false)) {
            return $this->loader->load('cat nova 8', $useragent);
        }

        if ($s->contains('nova', false)) {
            return $this->loader->load('nova', $useragent);
        }

        if ($s->contains('Cat Tablet Galactica X', false)) {
            return $this->loader->load('galactica x', $useragent);
        }

        if ($s->contains('StarGate', false)) {
            return $this->loader->load('stargate', $useragent);
        }

        if ($s->contains('Cat Tablet PHOENIX', false)) {
            return $this->loader->load('phoenix', $useragent);
        }

        if ($s->contains('Cat Tablet', false)) {
            return $this->loader->load('catsound tablet', $useragent);
        }

        return $this->loader->load('general catsound device', $useragent);
    }
}
