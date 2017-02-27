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
class Trident implements VersionCacheFactoryInterface
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
        $doMatch = preg_match('/Trident\/([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            return VersionFactory::set($matches[1]);
        }

        $doMatch = preg_match('/MSIE ([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            $version = '';

            switch ((float) $matches[1]) {
                case 11.0:
                    $version = '7.0';
                    break;
                case 10.0:
                    $version = '6.0';
                    break;
                case 9.0:
                    $version = '5.0';
                    break;
                case 8.0:
                    $version = '4.0';
                    break;
                default:
                    // do nothing here
            }

            return VersionFactory::set($version);
        }

        return new Version(0);
    }
}
