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
class SharpFactory implements Factory\FactoryInterface
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
        if ($s->contains('SHARP-TQ-GX30i', true)) {
            return $this->loader->load('tq-gx30i', $useragent);
        }

        if ($s->contains('SH-10D', true)) {
            return $this->loader->load('sh-10d', $useragent);
        }

        if ($s->contains('SH-01F', true)) {
            return $this->loader->load('sh-01f', $useragent);
        }

        if ($s->contains('SH8128U', true)) {
            return $this->loader->load('sh8128u', $useragent);
        }

        if ($s->contains('SH7228U', true)) {
            return $this->loader->load('sh7228u', $useragent);
        }

        if ($s->contains('306SH', true)) {
            return $this->loader->load('306sh', $useragent);
        }

        if ($s->contains('304SH', true)) {
            return $this->loader->load('304sh', $useragent);
        }

        if ($s->contains('SH80F', true)) {
            return $this->loader->load('sh80f', $useragent);
        }

        if ($s->contains('SH05C', true)) {
            return $this->loader->load('sh-05c', $useragent);
        }

        if ($s->contains('IS05', true)) {
            return $this->loader->load('is05', $useragent);
        }

        return $this->loader->load('general sharp device', $useragent);
    }
}
