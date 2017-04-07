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
class BlackBerryFactory implements Factory\FactoryInterface
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
        if ($s->contains('BB10; Kbd', false)) {
            return $this->loader->load('kbd', $useragent);
        }

        if ($s->contains('BB10; Touch', false)) {
            return $this->loader->load('z10', $useragent);
        }

        if ($s->contains('PlayBook', false)) {
            return $this->loader->load('playbook', $useragent);
        }

        if ($s->contains('RIM Tablet', false)) {
            return $this->loader->load('tablet', $useragent);
        }

        if ($s->contains('9981', false)) {
            return $this->loader->load('blackberry 9981', $useragent);
        }

        if ($s->contains('9900', false)) {
            return $this->loader->load('blackberry bold touch 9900', $useragent);
        }

        if ($s->contains('9860', false)) {
            return $this->loader->load('blackberry torch 9860', $useragent);
        }

        if ($s->contains('9810', false)) {
            return $this->loader->load('blackberry 9810', $useragent);
        }

        if ($s->contains('9800', false)) {
            return $this->loader->load('blackberry 9800', $useragent);
        }

        if ($s->contains('9790', false)) {
            return $this->loader->load('blackberry 9790', $useragent);
        }

        if ($s->contains('9780', false)) {
            return $this->loader->load('blackberry 9780', $useragent);
        }

        if ($s->contains('9720', false)) {
            return $this->loader->load('blackberry 9720', $useragent);
        }

        if ($s->contains('9700', false)) {
            return $this->loader->load('blackberry 9700', $useragent);
        }

        if ($s->contains('9670', false)) {
            return $this->loader->load('blackberry 9670', $useragent);
        }

        if ($s->contains('9630', false)) {
            return $this->loader->load('blackberry 9630', $useragent);
        }

        if ($s->contains('9550', false)) {
            return $this->loader->load('blackberry 9550', $useragent);
        }

        if ($s->contains('9520', false)) {
            return $this->loader->load('blackberry 9520', $useragent);
        }

        if ($s->contains('9500', false)) {
            return $this->loader->load('blackberry 9500', $useragent);
        }

        if ($s->contains('9380', false)) {
            return $this->loader->load('blackberry 9380', $useragent);
        }

        if ($s->contains('9360', false)) {
            return $this->loader->load('blackberry 9360', $useragent);
        }

        if ($s->contains('9320', false)) {
            return $this->loader->load('blackberry 9320', $useragent);
        }

        if ($s->contains('9300', false)) {
            return $this->loader->load('blackberry 9300', $useragent);
        }

        if ($s->contains('9220', false)) {
            return $this->loader->load('blackberry 9220', $useragent);
        }

        if ($s->contains('9105', false)) {
            return $this->loader->load('blackberry 9105', $useragent);
        }

        if ($s->contains('9000', false)) {
            return $this->loader->load('blackberry 9000', $useragent);
        }

        if ($s->contains('8900', false)) {
            return $this->loader->load('blackberry 8900', $useragent);
        }

        if ($s->contains('8830', false)) {
            return $this->loader->load('blackberry 8830', $useragent);
        }

        if ($s->contains('8800', false)) {
            return $this->loader->load('blackberry 8800', $useragent);
        }

        if ($s->contains('8700', false)) {
            return $this->loader->load('blackberry 8700', $useragent);
        }

        if ($s->contains('8530', false)) {
            return $this->loader->load('blackberry 8530', $useragent);
        }

        if ($s->contains('8520', false)) {
            return $this->loader->load('blackberry 8520', $useragent);
        }

        if ($s->contains('8350i', false)) {
            return $this->loader->load('blackberry 8350i', $useragent);
        }

        if ($s->contains('8310', false)) {
            return $this->loader->load('blackberry 8310', $useragent);
        }

        if ($s->contains('8230', false)) {
            return $this->loader->load('blackberry 8230', $useragent);
        }

        if ($s->contains('8110', false)) {
            return $this->loader->load('blackberry 8110', $useragent);
        }

        if ($s->contains('8100', false)) {
            return $this->loader->load('blackberry 8100', $useragent);
        }

        if ($s->contains('7520', false)) {
            return $this->loader->load('blackberry 7520', $useragent);
        }

        if ($s->contains('7130', false)) {
            return $this->loader->load('blackberry 7130', $useragent);
        }

        return $this->loader->load('general blackberry device', $useragent);
    }
}
