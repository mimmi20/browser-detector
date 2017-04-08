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
class DellFactory implements Factory\FactoryInterface
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
        if ($s->contains('venue pro', false)) {
            return $this->loader->load('venue pro', $useragent);
        }

        if ($s->contains('venue 8 hspa+', false)) {
            return $this->loader->load('venue 8 hspa+', $useragent);
        }

        if ($s->contains('venue 8 3830', false)) {
            return $this->loader->load('venue 8 3830', $useragent);
        }

        if ($s->contains('venue 7 hspa+', false)) {
            return $this->loader->load('venue 7 hspa+', $useragent);
        }

        if ($s->contains('venue 7 3730', false)) {
            return $this->loader->load('venue 7 3730', $useragent);
        }

        if ($s->contains('venue', false)) {
            return $this->loader->load('venue', $useragent);
        }

        if ($s->contains('streak 10 pro', false)) {
            return $this->loader->load('streak 10 pro', $useragent);
        }

        if ($s->contains('streak 7', false)) {
            return $this->loader->load('streak 7', $useragent);
        }

        if ($s->contains('streak', false)) {
            return $this->loader->load('streak', $useragent);
        }

        return $this->loader->load('general dell device', $useragent);
    }
}
