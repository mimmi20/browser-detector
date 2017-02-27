<?php


namespace BrowserDetector\Version;

use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class RimOs implements VersionCacheFactoryInterface
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
        if (false !== stripos($useragent, 'bb10') && false === stripos($useragent, 'version')) {
            return VersionFactory::set('10.0.0');
        }

        $searches = ['BlackBerry[0-9a-z]+', 'BlackBerrySimulator'];

        if (false !== stripos($useragent, 'bb10') || false === stripos($useragent, 'opera')) {
            $searches[] = 'Version';
        }

        return VersionFactory::detectVersion($useragent, $searches);
    }
}
