<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
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
use Symfony\Component\Finder\Finder;
use UaDeviceType\TypeLoader;
use UaResult\Company\CompanyLoader;
use UaResult\Device\Device;

class DeviceLoader
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
     * @var string|null
     */
    private $devicesPath;

    /**
     * @var string|null
     */
    private $rulesPath;

    /**
     * @var JsonParser
     */
    private $jsonParser;

    /**
     * @var array
     */
    private $devices = [];

    /**
     * @var string|null
     */
    private $genericDevice = null;

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     * @param string                                $path
     * @param string                                $mode
     */
    public function __construct(CacheInterface $cache, LoggerInterface $logger, string $path, string $mode)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
        $this->jsonParser = new JsonParser();

        $this->initPath($path, $mode);
    }

    /**
     * @param string $useragent
     *
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __invoke(string $useragent): array
    {
        $this->init();
        return $this->detectInArray($this->devices, $useragent);
    }

    /**
     * @param array            $devices
     * @param string           $useragent
     *
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function detectInArray(array $devices, string $useragent): array
    {
        foreach ($devices as $search => $key) {
            if (!preg_match($search, $useragent)) {
                continue;
            }

            if (is_array($key)) {
                return $this->detectInArray($key, $useragent);
            }

            return $this->load($key, $useragent);
        }

        return $this->load($this->genericDevice, $useragent);
    }

    /**
     * initializes cache
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function init(): void
    {
        $initKey = $this->getCacheKey('initialized');

        if ($this->cache->hasItem($initKey) && $this->cache->getItem($initKey)) {
            return;
        }

        $finder = new Finder();
        $finder->files();
        $finder->name('*.json');
        $finder->ignoreDotFiles(true);
        $finder->ignoreVCS(true);
        $finder->ignoreUnreadableDirs();
        $finder->in($this->devicesPath);

        foreach ($finder as $file) {
            /* @var \Symfony\Component\Finder\SplFileInfo $file */
            try {
                $fileData = $this->jsonParser->parse(
                    $file->getContents(),
                    JsonParser::DETECT_KEY_CONFLICTS
                );
            } catch (ParsingException $e) {
                throw new \RuntimeException('file "' . $file->getPathname() . '" contains invalid json', 0, $e);
            }

            foreach ($fileData as $key => $data) {
                $cacheKey = $this->getCacheKey((string) $key);

                if ($this->cache->hasItem($cacheKey)) {
                    $this->logger->warning(sprintf('deviceKey "%s" was defined more than once', $key));
                    continue;
                }

                $this->cache->setItem($cacheKey, $data);
            }
        }

        try {
            $fileData = $this->jsonParser->parse(
                $this->rulesPath,
                JsonParser::DETECT_KEY_CONFLICTS | JsonParser::PARSE_TO_ASSOC
            );
        } catch (ParsingException $e) {
            throw new \RuntimeException('file "' . $this->rulesPath . '" contains invalid json', 0, $e);
        }

        $this->devices       = $fileData['rules'];
        $this->genericDevice = $fileData['generic'];

        $this->cache->setItem($initKey, true);
    }

    /**
     * @param string $deviceKey
     *
     * @return bool
     */
    private function has(string $deviceKey): bool
    {
        try {
            return $this->cache->hasItem($this->getCacheKey($deviceKey));
        } catch (InvalidArgumentException $e) {
            $this->logger->info($e);
        }

        return false;
    }

    /**
     * @param string $deviceKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return array
     */
    private function load(string $deviceKey, string $useragent = ''): array
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
        $platform    = null;

        if (null !== $platformKey) {
            try {
                $platform = PlatformLoader::getInstance($this->cache, $this->logger)->load($platformKey, $useragent);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $companyLoader = CompanyLoader::getInstance();

        $device = new Device(
            $deviceData->codename,
            $deviceData->marketingName,
            $companyLoader->load($deviceData->manufacturer),
            $companyLoader->load($deviceData->brand),
            (new TypeLoader())->load($deviceData->type),
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
        return sprintf(
            '%s_%s_%s',
            self::CACHE_PREFIX,
            $this->clearCacheKey($this->devicesPath),
            $this->clearCacheKey($deviceKey)
        );
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function clearCacheKey(string $key)
    {
        return str_replace(['{', '}', '(', ')', '/', '\\', '@', ':'], '_', $key);
    }

    /**
     * @param string $company
     * @param string $mode
     */
    private function initPath(string $company, string $mode): void
    {
        $this->devicesPath = __DIR__ . '/../../data/devices/' . $company;
        $this->rulesPath   = __DIR__ . '/../../data/factories/devices/' . $mode . '/'. $company . '.json';
    }
}
