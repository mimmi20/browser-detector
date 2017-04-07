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
class DnsFactory implements Factory\FactoryInterface
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
        if ($s->contains('s5701', false)) {
            return $this->loader->load('s5701', $useragent);
        }

        if ($s->contains('s4505m', false)) {
            return $this->loader->load('s4505m', $useragent);
        }

        if ($s->contains('s4505', false)) {
            return $this->loader->load('s4505', $useragent);
        }

        if ($s->contains('s4503q', false)) {
            return $this->loader->load('s4503q', $useragent);
        }

        if ($s->contains('s4502m', false)) {
            return $this->loader->load('s4502m', $useragent);
        }

        if ($s->contains('s4502', false)) {
            return $this->loader->load('s4502', $useragent);
        }

        if ($s->contains('s4501m', false)) {
            return $this->loader->load('s4501m', $useragent);
        }

        if ($s->contains('S4008', true)) {
            return $this->loader->load('s4008', $useragent);
        }

        if ($s->contains('MB40II1', true)) {
            return $this->loader->load('mb40ii1', $useragent);
        }

        return $this->loader->load('general dns device', $useragent);
    }
}
