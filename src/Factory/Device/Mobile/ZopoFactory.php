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
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ZopoFactory implements Factory\FactoryInterface
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
        if ($s->contains('ZP980', true)) {
            return $this->loader->load('zp980', $useragent);
        }

        if ($s->contains('ZP950+', true)) {
            return $this->loader->load('zp950+', $useragent);
        }

        if ($s->contains('ZP950', true)) {
            return $this->loader->load('zp950', $useragent);
        }

        if ($s->containsAny(['ZP910', 'ZP900H'], true)) {
            return $this->loader->load('zp910', $useragent);
        }

        if ($s->contains('ZP900', true)) {
            return $this->loader->load('zp900', $useragent);
        }

        if ($s->containsAny(['ZP810', 'ZP800H'], true)) {
            return $this->loader->load('zp810', $useragent);
        }

        if ($s->contains('ZP500+', true)) {
            return $this->loader->load('zp500+', $useragent);
        }

        if ($s->contains('ZP500', true)) {
            return $this->loader->load('zp500', $useragent);
        }

        if ($s->contains('ZP300', true)) {
            return $this->loader->load('zp300', $useragent);
        }

        if ($s->contains('ZP200+', true)) {
            return $this->loader->load('zp200+', $useragent);
        }

        if ($s->contains('ZP200', true)) {
            return $this->loader->load('zp200', $useragent);
        }

        if ($s->contains('ZP100', true)) {
            return $this->loader->load('zp100', $useragent);
        }

        return $this->loader->load('general zopo device', $useragent);
    }
}
