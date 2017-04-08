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
class LenovoFactory implements Factory\FactoryInterface
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
        if ($s->contains('YT3-X50L', false)) {
            return $this->loader->load('yt3-x50l', $useragent);
        }

        if ($s->contains('TB2-X30F', false)) {
            return $this->loader->load('tb2-x30f', $useragent);
        }

        if ($s->contains('YOGA Tablet 2 Pro-1380L', false)) {
            return $this->loader->load('1380l', $useragent);
        }

        if ($s->contains('YOGA Tablet 2 Pro-1380F', false)) {
            return $this->loader->load('1380f', $useragent);
        }

        if ($s->contains('YOGA Tablet 2-1050L', false)) {
            return $this->loader->load('1050l', $useragent);
        }

        if ($s->contains('YOGA Tablet 2-1050F', false)) {
            return $this->loader->load('1050f', $useragent);
        }

        if ($s->contains('YOGA Tablet 2-830L', false)) {
            return $this->loader->load('830l', $useragent);
        }

        if ($s->contains('YOGA Tablet 2-830F', false)) {
            return $this->loader->load('830f', $useragent);
        }

        if ($s->contains('a10-70f', false)) {
            return $this->loader->load('a10-70f', $useragent);
        }

        if ($s->contains('s6000l-f', false)) {
            return $this->loader->load('s6000l-f', $useragent);
        }

        if ($s->contains('s6000-h', false)) {
            return $this->loader->load('s6000-h', $useragent);
        }

        if ($s->contains('s6000-f', false)) {
            return $this->loader->load('s6000-f', $useragent);
        }

        if ($s->contains('s5000-h', false)) {
            return $this->loader->load('s5000-h', $useragent);
        }

        if ($s->contains('s5000-f', false)) {
            return $this->loader->load('s5000-f', $useragent);
        }

        if ($s->contains('ideatabs2110ah', false)) {
            return $this->loader->load('s2110a-h', $useragent);
        }

        if ($s->contains('ideatabs2110af', false)) {
            return $this->loader->load('s2110a-f', $useragent);
        }

        if ($s->contains('IdeaTabS2109A-F', true)) {
            return $this->loader->load('s2109a-f', $useragent);
        }

        if ($s->contains('s920', false)) {
            return $this->loader->load('s920', $useragent);
        }

        if ($s->contains('s880i', false)) {
            return $this->loader->load('s880i', $useragent);
        }

        if ($s->contains('s856', false)) {
            return $this->loader->load('s856', $useragent);
        }

        if ($s->contains('s820_row', false)) {
            return $this->loader->load('s820_row', $useragent);
        }

        if ($s->contains('s720', false)) {
            return $this->loader->load('s720', $useragent);
        }

        if ($s->contains('s660', false)) {
            return $this->loader->load('s660', $useragent);
        }

        if ($s->contains('p1050x', false)) {
            return $this->loader->load('lifetab p1050x', $useragent);
        }

        if ($s->contains('p1032x', false)) {
            return $this->loader->load('lifetab p1032x', $useragent);
        }

        if ($s->contains('p780', false)) {
            return $this->loader->load('p780', $useragent);
        }

        if ($s->contains('k910l', false)) {
            return $this->loader->load('k910l', $useragent);
        }

        if ($s->contains('k900', false)) {
            return $this->loader->load('k900', $useragent);
        }

        if ($s->contains(' k1', false)) {
            return $this->loader->load('k1', $useragent);
        }

        if ($s->contains('ideapada10', false)) {
            return $this->loader->load('ideapad a10', $useragent);
        }

        if ($s->contains('a1_07', false)) {
            return $this->loader->load('ideapad a1', $useragent);
        }

        if ($s->contains('b8080-h', false)) {
            return $this->loader->load('b8080-h', $useragent);
        }

        if ($s->contains('b8080-f', false)) {
            return $this->loader->load('b8080-f', $useragent);
        }

        if ($s->contains('b8000-h', false)) {
            return $this->loader->load('b8000-h', $useragent);
        }

        if ($s->contains('b8000-f', false)) {
            return $this->loader->load('b8000-f', $useragent);
        }

        if ($s->contains('b6000-hv', false)) {
            return $this->loader->load('b6000-hv', $useragent);
        }

        if ($s->contains('b6000-h', false)) {
            return $this->loader->load('b6000-h', $useragent);
        }

        if ($s->contains('b6000-f', false)) {
            return $this->loader->load('b6000-f', $useragent);
        }

        if ($s->contains('a7600-h', false)) {
            return $this->loader->load('a7600-h', $useragent);
        }

        if ($s->contains('a7600-f', false)) {
            return $this->loader->load('a7600-f', $useragent);
        }

        if ($s->contains('a7000-a', false)) {
            return $this->loader->load('a7000-a', $useragent);
        }

        if ($s->contains('A5500-H', false)) {
            return $this->loader->load('a5500-h', $useragent);
        }

        if ($s->contains('A5500-F', false)) {
            return $this->loader->load('a5500-f', $useragent);
        }

        if ($s->contains('a3500-hv', false)) {
            return $this->loader->load('a3500-hv', $useragent);
        }

        if ($s->contains('a3500-h', false)) {
            return $this->loader->load('a3500-h', $useragent);
        }

        if ($s->contains('A3500-FL', false)) {
            return $this->loader->load('a3500-fl', $useragent);
        }

        if ($s->contains('a3300-hv', false)) {
            return $this->loader->load('a3300-hv', $useragent);
        }

        if ($s->contains('a3300-h', false)) {
            return $this->loader->load('a3300-h', $useragent);
        }

        if ($s->contains('a3300-gv', false)) {
            return $this->loader->load('a3300-gv', $useragent);
        }

        if ($s->contains('A3000-H', false)) {
            return $this->loader->load('a3000-h', $useragent);
        }

        if ($s->contains('A2107A-H', false)) {
            return $this->loader->load('a2107a-h', $useragent);
        }

        if ($s->contains('A1107', false)) {
            return $this->loader->load('a1107', $useragent);
        }

        if ($s->contains('A1000-F', false)) {
            return $this->loader->load('a1000-f', $useragent);
        }

        if ($s->contains('A1000L-F', false)) {
            return $this->loader->load('a1000l-f', $useragent);
        }

        if ($s->contains('A1000', false)) {
            return $this->loader->load('a1000', $useragent);
        }

        if ($s->containsAny(['a2109a', 'ideatab'], false)) {
            return $this->loader->load('a2109a', $useragent);
        }

        if ($s->contains('a889', false)) {
            return $this->loader->load('a889', $useragent);
        }

        if ($s->contains('a880', false)) {
            return $this->loader->load('a880', $useragent);
        }

        if ($s->contains('a850+', false)) {
            return $this->loader->load('a850+', $useragent);
        }

        if ($s->contains('a850', false)) {
            return $this->loader->load('a850', $useragent);
        }

        if ($s->contains('a820', false)) {
            return $this->loader->load('a820', $useragent);
        }

        if ($s->contains('a816', false)) {
            return $this->loader->load('a816', $useragent);
        }

        if ($s->contains('a789', false)) {
            return $this->loader->load('a789', $useragent);
        }

        if ($s->contains('a766', false)) {
            return $this->loader->load('a766', $useragent);
        }

        if ($s->contains('a660', false)) {
            return $this->loader->load('a660', $useragent);
        }

        if ($s->contains('a656', false)) {
            return $this->loader->load('a656', $useragent);
        }

        if ($s->contains('a606', false)) {
            return $this->loader->load('a606', $useragent);
        }

        if ($s->contains('a590', false)) {
            return $this->loader->load('a590', $useragent);
        }

        if ($s->contains('a536', false)) {
            return $this->loader->load('a536', $useragent);
        }

        if ($s->contains('a390', false)) {
            return $this->loader->load('a390', $useragent);
        }

        if ($s->contains('a388t', false)) {
            return $this->loader->load('a388t', $useragent);
        }

        if ($s->contains('a328', false)) {
            return $this->loader->load('a328', $useragent);
        }

        if ($s->contains('a319', false)) {
            return $this->loader->load('a319', $useragent);
        }

        if ($s->contains('a288t', false)) {
            return $this->loader->load('a288t', $useragent);
        }

        if ($s->contains('a65', false)) {
            return $this->loader->load('a65', $useragent);
        }

        if ($s->contains('a60', false)) {
            return $this->loader->load('a60', $useragent);
        }

        if ($s->containsAny(['SmartTabIII10', 'Smart Tab III 10'], false)) {
            return $this->loader->load('smart tab iii 10', $useragent);
        }

        if ($s->containsAny(['SmartTabII10', 'SmartTab II 10'], false)) {
            return $this->loader->load('smarttab ii 10', $useragent);
        }

        if ($s->contains('SmartTabII7', false)) {
            return $this->loader->load('smarttab ii 7', $useragent);
        }

        if ($s->contains('smart tab 4g', false)) {
            return $this->loader->load('smart tab 4g', $useragent);
        }

        if ($s->contains('smart tab 4', false)) {
            return $this->loader->load('smart tab 4', $useragent);
        }

        if ($s->contains('smart tab 3g', false)) {
            return $this->loader->load('smart tab 3g', $useragent);
        }

        if ($s->contains('ThinkPad', false)) {
            return $this->loader->load('1838', $useragent);
        }

        if ($s->contains('AT1010-T', true)) {
            return $this->loader->load('at1010-t', $useragent);
        }

        return $this->loader->load('general lenovo device', $useragent);
    }
}
