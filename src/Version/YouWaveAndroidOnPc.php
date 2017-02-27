<?php


namespace BrowserDetector\Version;

use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class YouWaveAndroidOnPc implements VersionCacheFactoryInterface
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
        $s = new Stringy($useragent);

        if ($s->contains('i9988_custom')) {
            return VersionFactory::set('Basic');
        }

        if ($s->contains('i9999_custom')) {
            return VersionFactory::set('Home');
        }

        return new Version(0);
    }
}
