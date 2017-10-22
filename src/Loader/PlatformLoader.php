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
namespace BrowserDetector\Loader;

use BrowserDetector\Bits\Os as OsBits;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionInterface;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use UaResult\Company\CompanyLoader;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

/**
 * Browser detection class
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class PlatformLoader implements ExtendedLoaderInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    private $cache;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface $cache
     *
     * @return self
     */
    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * initializes cache
     *
     * @return void
     */
    private function init(): void
    {
        $cacheInitializedId = hash('sha512', 'platform-cache is initialized');
        $cacheInitialized   = $this->cache->getItem($cacheInitializedId);

        if (!$cacheInitialized->isHit() || !$cacheInitialized->get()) {
            $this->initCache($cacheInitialized);
        }
    }

    /**
     * @param string $platformCode
     *
     * @return bool
     */
    public function has(string $platformCode): bool
    {
        $this->init();

        $cacheItem = $this->cache->getItem(hash('sha512', 'platform-cache-' . $platformCode));

        return $cacheItem->isHit();
    }

    /**
     * @param string      $platformCode
     * @param string      $useragent
     * @param string|null $inputVersion
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Os\OsInterface
     */
    public function load(string $platformCode, string $useragent = '', string $inputVersion = null): OsInterface
    {
        $this->init();

        if (!$this->has($platformCode)) {
            throw new NotFoundException('the platform with key "' . $platformCode . '" was not found');
        }

        $cacheItem = $this->cache->getItem(hash('sha512', 'platform-cache-' . $platformCode));

        $platform = $cacheItem->get();

        $platformVersionClass = $platform->version->class;

        if (null !== $inputVersion && is_string($inputVersion)) {
            $version = VersionFactory::set($inputVersion);
        } elseif (!is_string($platformVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $platformVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $platform->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $platformVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        $name          = $platform->name;
        $marketingName = $platform->marketingName;

        if ('Mac OS X' === $name
            && version_compare($version->getVersion(VersionInterface::IGNORE_MICRO), '10.12', '>=')
        ) {
            $name          = 'macOS';
            $marketingName = 'macOS';
        }

        $bits = (new OsBits($useragent))->getBits();

        return new Os($name, $marketingName, $platform->manufacturer, $version, $bits);
    }

    /**
     * @param \Psr\Cache\CacheItemInterface $cacheInitialized
     *
     * @return void
     */
    private function initCache(CacheItemInterface $cacheInitialized): void
    {
        static $platforms = null;

        if (null === $platforms) {
            $platforms = json_decode(file_get_contents(__DIR__ . '/../../data/platforms.json'));
        }

        $companyLoader = CompanyLoader::getInstance($this->cache);

        foreach ($platforms as $platformCode => $platformData) {
            $cacheItem = $this->cache->getItem(hash('sha512', 'platform-cache-' . $platformCode));

            $platformData->manufacturer = $companyLoader->load($platformData->manufacturer);

            $cacheItem->set($platformData);

            $this->cache->save($cacheItem);
        }

        $cacheInitialized->set(true);
        $this->cache->save($cacheInitialized);
    }
}
