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

use BrowserDetector\Bits\Browser as BrowserBits;
use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Finder\Finder;
use UaBrowserType\TypeLoader;
use UaResult\Browser\Browser;
use UaResult\Company\CompanyLoader;

class BrowserLoader implements ExtendedLoaderInterface
{
    private const CACHE_PREFIX = 'browser';

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
    private $path;

    /**
     * @var JsonParser
     */
    private $jsonParser;

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
        $this->jsonParser = new JsonParser();

        $this->initPath();
    }

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
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
     * @param bool   $load
     *
     * @throws \Seld\JsonLint\ParsingException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    private function init(bool $load = false): void
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
        $finder->in($this->path);

        $cacheFiles = [];

        foreach ($finder as $file) {
            /* @var \Symfony\Component\Finder\SplFileInfo $file */
            try {
                $devicesFile = $this->jsonParser->parse(
                    $file->getContents(),
                    JsonParser::DETECT_KEY_CONFLICTS
                );
            } catch (ParsingException $e) {
                throw new \RuntimeException('file "' . $file->getPathname() . '" contains invalid json', 0, $e);
            }

            foreach ($devicesFile as $deviceKey => $deviceData) {

                if (array_key_exists($deviceKey, $cacheFiles)) {
                    continue;
                }

                $cacheFiles[$deviceKey]   = $file->getPathname();
            }

            if ($load) {
                $this->loadFileToCache($file->getPathname());
            }
        }

        $this->cache->setItem($this->getCacheKey('cacheFiles'), $cacheFiles);
        $this->cache->setItem($initKey, true);
    }

    /**
     * @param string $browserKey
     *
     * @return bool
     */
    public function has(string $browserKey): bool
    {
        try {
            return $this->cache->hasItem($this->getCacheKey($browserKey));
        } catch (InvalidArgumentException $e) {
            $this->logger->info($e);

            return false;
        }
    }

    /**
     * @param string $browserKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    public function load(string $browserKey, string $useragent = ''): array
    {
        if (!$this->has($browserKey)) {
            throw new NotFoundException('the browser with key "' . $browserKey . '" was not found');
        }

        try {
            $browserData = $this->cache->getItem($this->getCacheKey($browserKey));
        } catch (InvalidArgumentException $e) {
            throw new NotFoundException('the browser with key "' . $browserKey . '" was not found', 0, $e);
        }

        $browserVersionClass = $browserData->version->class;
        $manufacturer        = CompanyLoader::getInstance()->load($browserData->manufacturer);
        $type                = (new TypeLoader())->load($browserData->type);

        if (!is_string($browserVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $browserVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $browserData->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $browserVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        $bits      = (new BrowserBits($useragent))->getBits();
        $engineKey = $browserData->engine;
        $engine    = null;

        if (null !== $engineKey) {
            try {
                $engine = EngineLoader::getInstance($this->cache, $this->logger)->load($engineKey, $useragent);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $browser = new Browser($browserData->name, $manufacturer, $version, $type, $bits);

        return [$browser, $engine];
    }

    /**
     * @param string $browserKey
     *
     * @return string
     */
    private function getCacheKey(string $browserKey): string
    {
        return sprintf(
            '%s_%s_%s',
            self::CACHE_PREFIX,
            $this->clearCacheKey($this->path),
            $this->clearCacheKey($browserKey)
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
     * @param string $filePath
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function loadFileToCache(string $filePath): void
    {
        try {
            $fileData = $this->jsonParser->parse(
                file_get_contents($filePath),
                JsonParser::DETECT_KEY_CONFLICTS
            );
        } catch (ParsingException $e) {
            throw new \RuntimeException('file "' . $filePath . '" contains invalid json', 0, $e);
        }

        foreach ($fileData as $key => $data) {
            $cacheKey = $this->getCacheKey((string) $key);

            if ($this->cache->hasItem($cacheKey)) {
                continue;
            }

            $this->cache->setItem($cacheKey, $data);
        }
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return void
     */
    public function warmupCache(): void
    {
        $this->init();
    }

    private function initPath(): void
    {
        $this->path = __DIR__ . '/../../data/browsers';
    }
}
