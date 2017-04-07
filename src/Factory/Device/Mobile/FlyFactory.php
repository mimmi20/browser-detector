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
class FlyFactory implements Factory\FactoryInterface
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
        if ($s->contains('IQ4504', true)) {
            return $this->loader->load('iq4504', $useragent);
        }

        if ($s->contains('IQ4502', true)) {
            return $this->loader->load('iq4502', $useragent);
        }

        if ($s->contains('IQ4415', true)) {
            return $this->loader->load('iq4415', $useragent);
        }

        if ($s->contains('IQ4411', true)) {
            return $this->loader->load('iq4411 quad energie2', $useragent);
        }

        if ($s->contains('phoenix 2', false)) {
            return $this->loader->load('iq4410i', $useragent);
        }

        if ($s->contains('IQ4490', true)) {
            return $this->loader->load('iq4490', $useragent);
        }

        if ($s->contains('IQ4410', true)) {
            return $this->loader->load('iq4410 quad phoenix', $useragent);
        }

        if ($s->contains('IQ4409', true)) {
            return $this->loader->load('iq4409 quad', $useragent);
        }

        if ($s->contains('IQ4404', true)) {
            return $this->loader->load('iq4404', $useragent);
        }

        if ($s->contains('IQ4403', true)) {
            return $this->loader->load('iq4403', $useragent);
        }

        if ($s->contains('IQ456', true)) {
            return $this->loader->load('iq456', $useragent);
        }

        if ($s->contains('IQ452', true)) {
            return $this->loader->load('iq452', $useragent);
        }

        if ($s->contains('IQ450', true)) {
            return $this->loader->load('iq450', $useragent);
        }

        if ($s->contains('IQ449', true)) {
            return $this->loader->load('iq449', $useragent);
        }

        if ($s->contains('IQ448', true)) {
            return $this->loader->load('iq448', $useragent);
        }

        if ($s->contains('IQ444', true)) {
            return $this->loader->load('iq444', $useragent);
        }

        if ($s->contains('IQ442', true)) {
            return $this->loader->load('iq442', $useragent);
        }

        if ($s->contains('IQ436i', true)) {
            return $this->loader->load('iq436i', $useragent);
        }

        if ($s->contains('IQ434', true)) {
            return $this->loader->load('iq434', $useragent);
        }

        return $this->loader->load('general fly device', $useragent);
    }
}
