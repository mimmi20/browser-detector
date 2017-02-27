<?php


namespace BrowserDetector\Version;

use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Ios implements VersionCacheFactoryInterface
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
        $doMatch = preg_match('/CPU like Mac OS X/', $useragent, $matches);

        if ($doMatch) {
            return VersionFactory::set('1.0');
        }

        $searches = [
            'IphoneOSX',
            'CPU OS\_',
            'CPU OS',
            'CPU iOS',
            'CPU iPad OS',
            'iPhone OS\;FBSV',
            'iPhone OS',
            'iPhone_OS',
            'IUC\(U\;iOS',
            'iPh OS',
            'iosv',
            'iOS',
        ];

        $detectedVersion = VersionFactory::detectVersion($useragent, $searches);

        if ($detectedVersion->getVersion(VersionInterface::IGNORE_MINOR) > 999) {
            $versions = [];
            $found    = preg_match('/(\d\d)(\d)(\d)/', $detectedVersion->getVersion(VersionInterface::IGNORE_MINOR), $versions);

            if ($found) {
                return VersionFactory::set($versions[1] . '.' . $versions[2] . '.' . $versions[3]);
            }
        }

        if ($detectedVersion->getVersion(VersionInterface::IGNORE_MINOR) > 99) {
            $versions = [];
            $found    = preg_match('/(\d)(\d)(\d)/', $detectedVersion->getVersion(VersionInterface::IGNORE_MINOR), $versions);

            if ($found) {
                return VersionFactory::set($versions[1] . '.' . $versions[2] . '.' . $versions[3]);
            }
        }

        if ('10.10' === $detectedVersion->getVersion(VersionInterface::IGNORE_MICRO)) {
            return VersionFactory::set('8.0.0');
        }

        return $detectedVersion;
    }
}
