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

use BrowserDetector\Cache\CacheInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use UaDeviceType\TypeLoader;
use UaResult\Company\CompanyLoader;
use UaResult\Device\Device;

class DeviceLoader implements ExtendedLoaderInterface
{
    private const CACHE_PREFIX = 'device';

    /**
     * @var \BrowserDetector\Cache\CacheInterface
     */
    private $cache;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var self|null
     */
    private static $instance;

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
    }

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     *
     * @return self
     */
    public static function getInstance(CacheInterface $cache, LoggerInterface $logger)
    {
        if (null === self::$instance) {
            self::$instance = new self($cache, $logger);
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    public static function resetInstance(): void
    {
        self::$instance = null;
    }

    /**
     * initializes cache
     *
     * @throws \RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    private function init(): void
    {
        $initKey = $this->getCacheKey('initialized');

        if ($this->cache->hasItem($initKey) && $this->cache->getItem($initKey)) {
            return;
        }

        foreach ($this->getDevices() as $deviceKey => $data) {
            $cacheKey = $this->getCacheKey((string) $deviceKey);

            if ($this->cache->hasItem($cacheKey)) {
                continue;
            }

            $this->cache->setItem($cacheKey, $data);
        }

        $this->cache->setItem($initKey, true);
    }

    /**
     * @throws \RuntimeException
     *
     * @return \Generator|\stdClass[]
     */
    private function getDevices(): \Generator
    {
        static $devices = null;

        if (null === $devices) {
            $sourceDirectory = __DIR__ . '/../../data/devices/';
            $iterator        = new \RecursiveDirectoryIterator($sourceDirectory);
            $jsonParser      = new JsonParser();
            $devices         = [];

            foreach (new \RecursiveIteratorIterator($iterator) as $file) {
                /* @var $file \SplFileInfo */
                if (!$file->isFile() || 'json' !== $file->getExtension()) {
                    continue;
                }

                try {
                    $devicesFile = $jsonParser->parse(
                        file_get_contents($file->getPathname()),
                        JsonParser::DETECT_KEY_CONFLICTS
                    );
                } catch (ParsingException $e) {
                    throw new \RuntimeException('file "' . $file->getPathname() . '" contains invalid json', 0, $e);
                }

                foreach ($devicesFile as $deviceKey => $deviceData) {
                    if (array_key_exists($deviceKey, $devices)) {
                        throw new \RuntimeException('device key "' . $deviceKey . '" was defined more then once');
                    }

                    $devices[$deviceKey] = $deviceData;
                }
            }
        }

        foreach ($devices as $deviceKey => $data) {
            yield $deviceKey => $data;
        }
    }

    /**
     * @param string $deviceKey
     *
     * @return bool
     */
    public function has(string $deviceKey): bool
    {
        try {
            return $this->cache->hasItem($this->getCacheKey($deviceKey));
        } catch (InvalidArgumentException $e) {
            $this->logger->info($e);

            return false;
        }
    }

    /**
     * @param string $deviceKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    public function load(string $deviceKey, string $useragent = ''): array
    {
        if (!$this->has($deviceKey)) {
            throw new NotFoundException('the device with key "' . $deviceKey . '" was not found');
        }

        try {
            $deviceData = $this->cache->getItem($this->getCacheKey($deviceKey));
        } catch (InvalidArgumentException $e) {
            throw new NotFoundException('the device with key "' . $deviceKey . '" was not found', 0, $e);
        }

        $platformKey = $deviceData->platform;

        if (null === $platformKey) {
            $platform = null;
        } else {
            try {
                $platform = PlatformLoader::getInstance($this->cache, $this->logger)->load($platformKey, $useragent);
            } catch (NotFoundException $e) {
                $this->logger->info($e);

                $platform = null;
            }
        }

        $companyLoader = CompanyLoader::getInstance();
        $typeLoader    = TypeLoader::getInstance();

        $device = new Device(
            $deviceData->codename,
            $deviceData->marketingName,
            $companyLoader->load($deviceData->manufacturer),
            $companyLoader->load($deviceData->brand),
            $typeLoader->load($deviceData->type),
            $deviceData->pointingMethod,
            $deviceData->resolutionWidth,
            $deviceData->resolutionHeight,
            $deviceData->dualOrientation
        );

        return [$device, $platform];
    }

    /**
     * @param string $deviceKey
     *
     * @return string
     */
    private function getCacheKey(string $deviceKey): string
    {
        return self::CACHE_PREFIX . '_' . str_replace(['{', '}', '(', ')', '/', '\\', '@', ':'], '_', $deviceKey);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function warmupCache(): void
    {
        $this->init();
    }
}
