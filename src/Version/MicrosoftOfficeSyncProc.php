<?php


namespace BrowserDetector\Version;

use BrowserDetector\Helper\MicrosoftOffice as MicrosoftOfficeHelper;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MicrosoftOfficeSyncProc implements VersionCacheFactoryInterface
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
        $doMatch = preg_match(
            '/Office SyncProc(\/| )([\d\.]+)/',
            $useragent,
            $matches
        );

        $helper = new MicrosoftOfficeHelper();

        if ($doMatch) {
            return VersionFactory::set($helper->mapVersion($matches[1]));
        }

        return VersionFactory::set($helper->mapVersion($helper->detectInternalVersion($useragent)));
    }
}
