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
class OneplusFactory implements Factory\FactoryInterface
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
        if ($s->contains('A3000', true)) {
            return $this->loader->load('a3000', $useragent);
        }

        if ($s->contains('A2001', true)) {
            return $this->loader->load('a2001', $useragent);
        }

        if ($s->contains('A2003', true)) {
            return $this->loader->load('a2003', $useragent);
        }

        if ($s->contains('A2005', true)) {
            return $this->loader->load('a2005', $useragent);
        }

        if ($s->contains('E1003', true)) {
            return $this->loader->load('e1003', $useragent);
        }

        return $this->loader->load('general oneplus device', $useragent);
    }
}
