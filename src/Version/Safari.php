<?php


namespace BrowserDetector\Version;

use BrowserDetector\Helper\Safari as SafariHelper;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Safari implements VersionCacheFactoryInterface
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

        $doMatch = preg_match('/Version\/([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            return VersionFactory::set($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match(
            '/Safari\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match('/Safari([\d\.]+)/', $useragent, $matches);

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

        return new Version(0);
    }
}
