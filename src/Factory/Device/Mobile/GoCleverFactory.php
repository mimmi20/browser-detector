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
class GoCleverFactory implements Factory\FactoryInterface
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
        if ($s->contains('TQ700', true)) {
            return $this->loader->load('tq700', $useragent);
        }

        if ($s->contains('TERRA_101', true)) {
            return $this->loader->load('a1021', $useragent);
        }

        if ($s->contains('INSIGNIA_785_PRO', true)) {
            return $this->loader->load('insignia 785 pro', $useragent);
        }

        if ($s->contains('ARIES_785', true)) {
            return $this->loader->load('aries 785', $useragent);
        }

        if ($s->contains('ARIES_101', true)) {
            return $this->loader->load('aries 101', $useragent);
        }

        if ($s->contains('ORION7o', true)) {
            return $this->loader->load('orion 7o', $useragent);
        }

        if ($s->contains('QUANTUM 4', true)) {
            return $this->loader->load('quantum 4', $useragent);
        }

        if ($s->contains('QUANTUM_700m', true)) {
            return $this->loader->load('quantum 700m', $useragent);
        }

        if ($s->contains('TAB A93.2', true)) {
            return $this->loader->load('a93.2', $useragent);
        }

        return $this->loader->load('general goclever device', $useragent);
    }
}
