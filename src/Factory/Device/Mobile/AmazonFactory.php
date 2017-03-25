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
class AmazonFactory implements Factory\FactoryInterface
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
        if ($s->contains('kftt', false)) {
            return $this->loader->load('kftt', $useragent);
        }

        if ($s->contains('kfthwi', false)) {
            return $this->loader->load('kfthwi', $useragent);
        }

        if ($s->contains('kfsowi', false)) {
            return $this->loader->load('kfsowi', $useragent);
        }

        if ($s->contains('kfot', false)) {
            return $this->loader->load('kfot', $useragent);
        }

        if ($s->contains('kfjwi', false)) {
            return $this->loader->load('kfjwi', $useragent);
        }

        if ($s->contains('kfjwa', false)) {
            return $this->loader->load('kfjwa', $useragent);
        }

        if ($s->contains('kfaswi', false)) {
            return $this->loader->load('kfaswi', $useragent);
        }

        if ($s->contains('kfapwi', false)) {
            return $this->loader->load('kfapwi', $useragent);
        }

        if ($s->contains('kfapwa', false)) {
            return $this->loader->load('kfapwa', $useragent);
        }

        if ($s->contains('sd4930ur', false)) {
            return $this->loader->load('sd4930ur', $useragent);
        }

        if ($s->contains('kindle fire', false)) {
            return $this->loader->load('d01400', $useragent);
        }

        if ($s->containsAny(['kindle', 'silk'], false)) {
            return $this->loader->load('kindle', $useragent);
        }

        return $this->loader->load('general amazon device', $useragent);
    }
}
