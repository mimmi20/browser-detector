<?php


namespace BrowserDetector\Version;

use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Goanna implements VersionCacheFactoryInterface
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
        // lastest version: version on "Goanna" token
        $doMatch = preg_match('/Goanna\/([\d\.]+)/', $useragent, $matches);

        if ($doMatch && 2015 > substr($matches[1], 0, 4)) {
            return VersionFactory::set($matches[1]);
        }

        // second version: version on "rv:" token
        $doMatch = preg_match('/rv\:([\d\.]+)/', $useragent, $matches);

        if ($doMatch && 2 >= substr($matches[1], 0, 4)) {
            return VersionFactory::set($matches[1]);
        }

        // first version: uses gecko version
        return VersionFactory::set('1.0');
    }
}
