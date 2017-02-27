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
class AndroidOs implements VersionCacheFactoryInterface
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
        if (false !== mb_stripos($useragent, 'android 2.1-update1')) {
            return VersionFactory::set('2.1.1');
        }

        $searches = [
            'android android',
            'android androidhouse team',
            'android wildpuzzlerom v8 froyo',
            'juc ?\(linux;',
            'linux; googletv',
            'android os',
            'android;',
            'android_',
            'android ',
            'android\/',
            'android',
            'adr ',
        ];

        $detector = VersionFactory::detectVersion($useragent, $searches);

        if ('0.0.0' !== $detector->getVersion()) {
            return $detector;
        }

        if (false !== mb_stripos($useragent, 'android eclair')) {
            return VersionFactory::set('2.1.0');
        }

        if (false !== mb_stripos($useragent, 'gingerbread')) {
            return VersionFactory::set('2.3.0');
        }

        return new Version(0);
    }
}
