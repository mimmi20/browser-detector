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
class AcerFactory implements Factory\FactoryInterface
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
        if ($s->contains('V989', false)) {
            return $this->loader->load('v989', $useragent);
        }

        if ($s->contains('V370', false)) {
            return $this->loader->load('v370', $useragent);
        }

        if ($s->contains('Stream-S110', false)) {
            return $this->loader->load('stream s110', $useragent);
        }

        if ($s->contains('S500', false)) {
            return $this->loader->load('s500', $useragent);
        }

        if ($s->containsAny(['Liquid MT', 'Liquid Metal'], false)) {
            return $this->loader->load('s120', $useragent);
        }

        if ($s->contains('Z150', false)) {
            return $this->loader->load('z150', $useragent);
        }

        if ($s->contains('Liquid', false)) {
            return $this->loader->load('s100', $useragent);
        }

        if ($s->contains('b1-770', false)) {
            return $this->loader->load('b1-770', $useragent);
        }

        if ($s->contains('b1-730hd', false)) {
            return $this->loader->load('b1-730hd', $useragent);
        }

        if ($s->contains('b1-721', false)) {
            return $this->loader->load('b1-721', $useragent);
        }

        if ($s->contains('b1-711', false)) {
            return $this->loader->load('b1-711', $useragent);
        }

        if ($s->contains('b1-710', false)) {
            return $this->loader->load('b1-710', $useragent);
        }

        if ($s->contains('b1-a71', false)) {
            return $this->loader->load('b1-a71', $useragent);
        }

        if ($s->contains('a1-830', false)) {
            return $this->loader->load('a1-830', $useragent);
        }

        if ($s->contains('a1-811', false)) {
            return $this->loader->load('a1-811', $useragent);
        }

        if ($s->contains('a1-810', false)) {
            return $this->loader->load('a1-810', $useragent);
        }

        if ($s->contains('A742', false)) {
            return $this->loader->load('tab a742', $useragent);
        }

        if ($s->contains('A701', false)) {
            return $this->loader->load('a701', $useragent);
        }

        if ($s->contains('A700', false)) {
            return $this->loader->load('a700', $useragent);
        }

        if ($s->contains('A511', false)) {
            return $this->loader->load('a511', $useragent);
        }

        if ($s->contains('A510', false)) {
            return $this->loader->load('a510', $useragent);
        }

        if ($s->contains('A501', false)) {
            return $this->loader->load('a501', $useragent);
        }

        if ($s->contains('A500', false)) {
            return $this->loader->load('a500', $useragent);
        }

        if ($s->contains('A211', false)) {
            return $this->loader->load('a211', $useragent);
        }

        if ($s->contains('A210', false)) {
            return $this->loader->load('a210', $useragent);
        }

        if ($s->contains('A200', false)) {
            return $this->loader->load('a200', $useragent);
        }

        if ($s->contains('A101C', false)) {
            return $this->loader->load('a101c', $useragent);
        }

        if ($s->contains('A101', false)) {
            return $this->loader->load('a101', $useragent);
        }

        if ($s->contains('A100', false)) {
            return $this->loader->load('a100', $useragent);
        }

        if ($s->contains('a3-a20', false)) {
            return $this->loader->load('a3-a20', $useragent);
        }

        if ($s->contains('a3-a11', false)) {
            return $this->loader->load('a3-a11', $useragent);
        }

        if ($s->contains('a3-a10', false)) {
            return $this->loader->load('a3-a10', $useragent);
        }

        if ($s->contains('Iconia', false)) {
            return $this->loader->load('iconia', $useragent);
        }

        if ($s->contains('G100W', false)) {
            return $this->loader->load('g100w', $useragent);
        }

        if ($s->contains('E320', false)) {
            return $this->loader->load('e320', $useragent);
        }

        if ($s->contains('E310', false)) {
            return $this->loader->load('e310', $useragent);
        }

        if ($s->contains('E140', false)) {
            return $this->loader->load('e140', $useragent);
        }

        if ($s->contains('DA241HL', false)) {
            return $this->loader->load('da241hl', $useragent);
        }

        if ($s->contains('allegro', false)) {
            return $this->loader->load('allegro', $useragent);
        }

        if ($s->contains('TM01', true)) {
            return $this->loader->load('tm01', $useragent);
        }

        if ($s->contains('M220', true)) {
            return $this->loader->load('m220', $useragent);
        }

        return $this->loader->load('general acer device', $useragent);
    }
}
