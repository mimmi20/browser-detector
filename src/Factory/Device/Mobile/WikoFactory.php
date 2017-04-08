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
class WikoFactory implements Factory\FactoryInterface
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
        if ($s->contains('SLIDE2', true)) {
            return $this->loader->load('slide 2', $useragent);
        }

        if ($s->contains('JERRY', true)) {
            return $this->loader->load('jerry', $useragent);
        }

        if ($s->contains('BLOOM', true)) {
            return $this->loader->load('bloom', $useragent);
        }

        if ($s->contains('RAINBOW', true)) {
            return $this->loader->load('rainbow', $useragent);
        }

        if ($s->contains('LENNY', true)) {
            return $this->loader->load('lenny', $useragent);
        }

        if ($s->contains('GETAWAY', true)) {
            return $this->loader->load('getaway', $useragent);
        }

        if ($s->contains('DARKMOON', true)) {
            return $this->loader->load('darkmoon', $useragent);
        }

        if ($s->contains('DARKSIDE', true)) {
            return $this->loader->load('darkside', $useragent);
        }

        if ($s->contains('CINK PEAX 2', true)) {
            return $this->loader->load('cink peax 2', $useragent);
        }

        return $this->loader->load('general wiko device', $useragent);
    }
}
