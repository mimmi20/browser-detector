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

use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use UaResult\Company\CompanyLoader;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

/**
 * Browser detection class
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class EngineLoader implements ExtendedLoaderInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    private $cache;

    /**
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface $cache
     * @param \Psr\Log\LoggerInterface          $logger
     *
     * @return self
     */
    public function __construct(CacheItemPoolInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
    }

    /**
     * initializes cache
     *
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return void
     */
    private function init(): void
    {
        $cacheInitializedId = hash('sha512', 'engine-cache is initialized');
        $cacheInitialized   = $this->cache->getItem($cacheInitializedId);

        if (!$cacheInitialized->isHit() || !$cacheInitialized->get()) {
            $this->initCache($cacheInitialized);
        }
    }

    /**
     * @param string $engineKey
     *
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return bool
     */
    public function has(string $engineKey): bool
    {
        $this->init();

        $cacheItem = $this->cache->getItem(hash('sha512', 'engine-cache-' . $engineKey));

        return $cacheItem->isHit();
    }

    /**
     * @param string $engineKey
     * @param string $useragent
     *
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function load(string $engineKey, string $useragent = ''): EngineInterface
    {
        $this->init();

        if (!$this->has($engineKey)) {
            throw new NotFoundException('the engine with key "' . $engineKey . '" was not found');
        }

        $cacheItem = $this->cache->getItem(hash('sha512', 'engine-cache-' . $engineKey));

        $engine = $cacheItem->get();

        $engineVersionClass = $engine->version->class;

        if (!is_string($engineVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $engineVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $engine->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $engineVersionClass($this->logger);
            $version      = $versionClass->detectVersion($useragent);
        }

        return new Engine(
            $engine->name,
            $engine->manufacturer,
            $version
        );
    }

    /**
     * @param \Psr\Cache\CacheItemInterface $cacheInitialized
     *
     * @throws \RuntimeException
     * @throws \Psr\Cache\InvalidArgumentException
     *
     * @return void
     */
    private function initCache(CacheItemInterface $cacheInitialized): void
    {
        $jsonParser = new JsonParser();
        $file       = new \SplFileInfo(__DIR__ . '/../../data/engines.json');

        try {
            $engines = $jsonParser->parse(
                file_get_contents($file->getPathname()),
                JsonParser::DETECT_KEY_CONFLICTS
            );
        } catch (ParsingException $e) {
            throw new \RuntimeException('file "' . $file->getPathname() . '" contains invalid json', 0, $e);
        }

        $companyLoader = CompanyLoader::getInstance();

        foreach ($engines as $engineKey => $engineData) {
            $cacheItem = $this->cache->getItem(hash('sha512', 'engine-cache-' . $engineKey));

            $engineData->manufacturer = $companyLoader->load($engineData->manufacturer);

            $cacheItem->set($engineData);

            $this->cache->save($cacheItem);
        }

        $cacheInitialized->set(true);
        $this->cache->save($cacheInitialized);
    }
}
