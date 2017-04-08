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
class ArchosFactory implements Factory\FactoryInterface
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
        if ($s->contains('A101IT', false)) {
            return $this->loader->load('a101it', $useragent);
        }

        if ($s->contains('A80KSC', false)) {
            return $this->loader->load('a80ksc', $useragent);
        }

        if ($s->contains('A70S', false)) {
            return $this->loader->load('a70s', $useragent);
        }

        if ($s->contains('A70HB', false)) {
            return $this->loader->load('a70hb', $useragent);
        }

        if ($s->contains('A70H2', false)) {
            return $this->loader->load('a70 h2', $useragent);
        }

        if ($s->contains('A70CHT', false)) {
            return $this->loader->load('a70cht', $useragent);
        }

        if ($s->contains('A70BHT', false)) {
            return $this->loader->load('a70bht', $useragent);
        }

        if ($s->contains('a35dm', false)) {
            return $this->loader->load('a35dm', $useragent);
        }

        if ($s->contains('a7eb', false)) {
            return $this->loader->load('70c', $useragent);
        }

        if ($s->contains('101 xs 2', false)) {
            return $this->loader->load('101 xs 2', $useragent);
        }

        if ($s->contains('121 neon', false)) {
            return $this->loader->load('121 neon', $useragent);
        }

        if ($s->contains('101d neon', false)) {
            return $this->loader->load('101d neon', $useragent);
        }

        if ($s->contains('101 neon', false)) {
            return $this->loader->load('101 neon', $useragent);
        }

        if ($s->contains('101 copper', false)) {
            return $this->loader->load('101 copper', $useragent);
        }

        if ($s->contains('101g10', false)) {
            return $this->loader->load('101g10', $useragent);
        }

        if ($s->contains('101g9', false)) {
            return $this->loader->load('101 g9', $useragent);
        }

        if ($s->contains('101b', false)) {
            return $this->loader->load('101b', $useragent);
        }

        if ($s->contains('97 xenon', false)) {
            return $this->loader->load('97 xenon', $useragent);
        }

        if ($s->contains('97 TITANIUMHD', false)) {
            return $this->loader->load('97 titanium hd', $useragent);
        }

        if ($s->contains('97 neon', false)) {
            return $this->loader->load('97 neon', $useragent);
        }

        if ($s->contains('97 carbon', false)) {
            return $this->loader->load('97 carbon', $useragent);
        }

        if ($s->contains('80xsk', false)) {
            return $this->loader->load('80xsk', $useragent);
        }

        if ($s->contains('80 xenon', false)) {
            return $this->loader->load('80 xenon', $useragent);
        }

        if ($s->contains('80g9', false)) {
            return $this->loader->load('80 g9', $useragent);
        }

        if ($s->contains('80 cobalt', false)) {
            return $this->loader->load('80 cobalt', $useragent);
        }

        if ($s->contains('79 xenon', false)) {
            return $this->loader->load('79 xenon', $useragent);
        }

        if ($s->contains('70 xenon', false)) {
            return $this->loader->load('70 xenon', $useragent);
        }

        if ($s->contains('70it2', false)) {
            return $this->loader->load('70it2', $useragent);
        }

        if ($s->contains('53 platinum', false)) {
            return $this->loader->load('53 platinum', $useragent);
        }

        if ($s->contains('50 titanium', false)) {
            return $this->loader->load('50 titanium', $useragent);
        }

        if ($s->contains('50b platinum', false)) {
            return $this->loader->load('50b platinum', $useragent);
        }

        if ($s->contains('50 platinum', false)) {
            return $this->loader->load('50 platinum', $useragent);
        }

        if ($s->contains('50 cesium', false)) {
            return $this->loader->load('50 cesium', $useragent);
        }

        if ($s->contains('50 oxygen plus', false)) {
            return $this->loader->load('50 oxygen plus', $useragent);
        }

        if ($s->contains('50c oxygen', false)) {
            return $this->loader->load('50c oxygen', $useragent);
        }

        if ($s->contains('40 cesium', false)) {
            return $this->loader->load('40 cesium', $useragent);
        }

        if ($s->contains('40b titanium surround', false)) {
            return $this->loader->load('40b titanium surround', $useragent);
        }

        if ($s->contains('archos5', false)) {
            return $this->loader->load('5', $useragent);
        }

        if ($s->contains('FAMILYPAD 2', false)) {
            return $this->loader->load('family pad 2', $useragent);
        }

        if ($s->contains('bush windows phone', false)) {
            return $this->loader->load('eluma', $useragent);
        }

        return $this->loader->load('general archos device', $useragent);
    }
}
