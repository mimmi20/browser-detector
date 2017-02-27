<?php


namespace BrowserDetector\Version;

use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Maxthon implements VersionCacheFactoryInterface
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
        if (false !== strpos($useragent, 'MyIE2')) {
            return VersionFactory::set('2.0');
        }

        if (false !== strpos($useragent, 'MyIE')) {
            return VersionFactory::set('1.0');
        }

        return VersionFactory::detectVersion($useragent, ['Maxthon', 'MxBrowser', 'Version'], '2.0');
    }
}
