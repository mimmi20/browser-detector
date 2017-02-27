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
namespace BrowserDetector\Version;

use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class FirefoxOs implements VersionCacheFactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface $cache
     */
    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\Version
     */
    public function detectVersion($useragent)
    {
        $doMatch = preg_match('/rv:(\d+\.\d+)/', $useragent, $matches);

        if (!$doMatch) {
            return new Version(0);
        }

        $version = (float) $matches[1];

        if ($version >= 37.0) {
            return new Version(2, 2);
        }

        if ($version >= 34.0) {
            return new Version(2, 1);
        }

        if ($version >= 32.0) {
            return new Version(2, 0);
        }

        if ($version >= 30.0) {
            return new Version(1, 4);
        }

        if ($version >= 28.0) {
            return new Version(1, 3);
        }

        if ($version >= 26.0) {
            return new Version(1, 2);
        }

        if ($version >= 18.1) {
            return new Version(1, 1);
        }

        if ($version >= 18.0) {
            return new Version(1, 0);
        }

        return new Version(0);
    }
}
