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

use BrowserDetector\Helper\Safari as SafariHelper;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AndroidWebkit implements VersionCacheFactoryInterface
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
        $safariHelper = new SafariHelper($useragent);

        $doMatch = preg_match(
            '/Version\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($safariHelper->mapSafariVersions($matches[1]));
        }

        if (preg_match('/android eclair/i', $useragent)) {
            return VersionFactory::set('2.1');
        }

        if (preg_match('/gingerbread/i', $useragent)) {
            return VersionFactory::set('2.3');
        }

        $doMatch = preg_match(
            '/Safari\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match(
            '/AppleWebKit\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match(
            '/MobileSafari\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match(
            '/Android\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($matches[1]);
        }

        $searches = ['Version', 'Safari', 'JUC \(Linux\; U\;'];

        return VersionFactory::detectVersion($useragent, $searches);
    }
}
