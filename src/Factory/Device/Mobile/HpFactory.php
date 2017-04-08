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
class HpFactory implements Factory\FactoryInterface
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
        if ($s->contains('ipaqhw6900', false)) {
            return $this->loader->load('ipaq 6900', $useragent);
        }

        if ($s->contains('slate 17', false)) {
            return $this->loader->load('slate 17', $useragent);
        }

        if ($s->contains('slate 10 hd', false)) {
            return $this->loader->load('slate 10', $useragent);
        }

        if ($s->containsAny(['touchpad', 'cm_tenderloin'], false)) {
            return $this->loader->load('touchpad', $useragent);
        }

        if ($s->contains('palm-d050', false)) {
            return $this->loader->load('tx', $useragent);
        }

        if ($s->contains('pre/', false)) {
            return $this->loader->load('pre', $useragent);
        }

        if ($s->contains('pixi/', false)) {
            return $this->loader->load('pixi', $useragent);
        }

        if ($s->contains('blazer', false)) {
            return $this->loader->load('blazer', $useragent);
        }

        if ($s->contains('p160u', false)) {
            return $this->loader->load('p160u', $useragent);
        }

        return $this->loader->load('general hp device', $useragent);
    }
}
