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
class CobyFactory implements Factory\FactoryInterface
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
        if ($s->contains('MID9742', false)) {
            return $this->loader->load('mid9742', $useragent);
        }

        if ($s->contains('MID8128', false)) {
            return $this->loader->load('mid8128', $useragent);
        }

        if ($s->contains('MID8127', false)) {
            return $this->loader->load('mid8127', $useragent);
        }

        if ($s->contains('MID8024', false)) {
            return $this->loader->load('mid8024', $useragent);
        }

        if ($s->contains('MID7022', false)) {
            return $this->loader->load('mid7022', $useragent);
        }

        if ($s->contains('MID7015', false)) {
            return $this->loader->load('mid7015', $useragent);
        }

        if ($s->contains('MID1126', false)) {
            return $this->loader->load('mid1126', $useragent);
        }

        if ($s->contains('MID1125', false)) {
            return $this->loader->load('mid1125', $useragent);
        }

        if ($s->contains('NBPC724', false)) {
            return $this->loader->load('nbpc724', $useragent);
        }

        return $this->loader->load('general coby device', $useragent);
    }
}
