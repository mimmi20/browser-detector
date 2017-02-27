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
class WindowsPhoneOs implements VersionCacheFactoryInterface
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

        if ($s->containsAny(['XBLWP7', 'ZuneWP7'])) {
            return VersionFactory::set('7.5.0');
        }

        if ($s->contains('wds 8.10')) {
            return VersionFactory::set('8.1.0');
        }

        if ($s->contains('WPDesktop')) {
            if ($s->contains('Windows NT 6.3')) {
                return VersionFactory::set('8.1.0');
            }

            if ($s->contains('Windows NT 6.2')) {
                return VersionFactory::set('8.0.0');
            }

            return VersionFactory::set('0.0.0');
        }

        $searches = ['Windows Phone OS', 'Windows Phone', 'wds', 'Windows Mobile', 'Windows NT'];

        return VersionFactory::detectVersion($useragent, $searches);
    }
}
