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
class TriQFactory implements Factory\FactoryInterface
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
        if ($s->contains('QS0716D', true)) {
            return $this->loader->load('qs0716d', $useragent);
        }

        if ($s->contains('MT0812E', true)) {
            return $this->loader->load('mt0812e', $useragent);
        }

        if ($s->contains('MT0739D', true)) {
            return $this->loader->load('mt0739d', $useragent);
        }

        if ($s->contains('AC0732C', true)) {
            return $this->loader->load('ac0732c', $useragent);
        }

        if ($s->contains('RC9724C', true)) {
            return $this->loader->load('rc9724c', $useragent);
        }

        if ($s->contains('LC0720C', true)) {
            return $this->loader->load('lc0720c', $useragent);
        }

        return $this->loader->load('general 3q device', $useragent);
    }
}
