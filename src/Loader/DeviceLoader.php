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

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use UaDeviceType\TypeLoader;
use UaResult\Company\CompanyLoader;
use UaResult\Device\Device;

/**
 * Device detection class
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class DeviceLoader implements ExtendedLoaderInterface
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
        $cacheInitializedId = hash('sha512', 'device-cache is initialized');
        $cacheInitialized   = $this->cache->getItem($cacheInitializedId);

        if (!$cacheInitialized->isHit() || !$cacheInitialized->get()) {
            $this->initCache($cacheInitialized);
        }
    }

    /**
     * @param string $deviceKey
     *
     * @return bool
     */
    public function has(string $deviceKey): bool
    {
        $this->init();

        $cacheItem = $this->cache->getItem(hash('sha512', 'device-cache-' . $deviceKey));

        return $cacheItem->isHit();
    }

    /**
     * @param string $deviceKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return (\UaResult\Device\DeviceInterface|\UaResult\Os\OsInterface|null)[]
     */
    public function load(string $deviceKey, string $useragent = ''): array
    {
        $this->init();

        if (!$this->has($deviceKey)) {
            throw new NotFoundException('the device with key "' . $deviceKey . '" was not found');
        }

        $cacheItem = $this->cache->getItem(hash('sha512', 'device-cache-' . $deviceKey));

        $device      = $cacheItem->get();
        $platformKey = $device->platform;

        if (null === $platformKey) {
            $platform = null;
        } else {
            $platform = (new PlatformLoader($this->cache))->load($platformKey, $useragent);
        }

        $device = new Device(
            $device->codename,
            $device->marketingName,
            $device->manufacturer,
            $device->brand,
            $device->type,
            $device->pointingMethod,
            $device->resolutionWidth,
            $device->resolutionHeight,
            $device->dualOrientation
        );

        return [$device, $platform];
    }

    /**
     * @param \Psr\Cache\CacheItemInterface $cacheInitialized
     *
     * @throws \Seld\JsonLint\ParsingException
     * @throws \RuntimeException
     *
     * @return void
     */
    private function initCache(CacheItemInterface $cacheInitialized): void
    {
        $sourceDirectory = __DIR__ . '/../../data/devices/';
        $iterator        = new \RecursiveDirectoryIterator($sourceDirectory);

        $companyLoader = CompanyLoader::getInstance($this->cache);
        $typeLoader    = TypeLoader::getInstance();
        $jsonParser    = new JsonParser();

        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            /* @var $file \SplFileInfo */
            if (!$file->isFile() || 'json' !== $file->getExtension()) {
                continue;
            }

            try {
                $devices = $jsonParser->parse(
                    file_get_contents($file->getPathname()),
                    JsonParser::DETECT_KEY_CONFLICTS
                );
            } catch (ParsingException $e) {
                throw new \RuntimeException('file "' . $file->getPathname() . '" contains invalid json', 0, $e);
            }

            foreach ($devices as $deviceKey => $deviceData) {
                $cacheItem = $this->cache->getItem(hash('sha512', 'device-cache-' . $deviceKey));

                $deviceData->manufacturer = $companyLoader->load($deviceData->manufacturer);
                $deviceData->brand        = $companyLoader->load($deviceData->brand);
                $deviceData->type         = $typeLoader->load($deviceData->type);

                $cacheItem->set($deviceData);

                $this->cache->save($cacheItem);
            }
        }

        $cacheInitialized->set(true);
        $this->cache->save($cacheInitialized);
    }
}
