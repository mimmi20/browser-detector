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

use BrowserDetector\Bits\Browser as BrowserBits;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use UaBrowserType\TypeLoader;
use UaResult\Browser\Browser;
use UaResult\Company\CompanyLoader;

/**
 * Browser detection class
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class BrowserLoader implements ExtendedLoaderInterface
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
     * @return void
     */
    private function init(): void
    {
        $cacheInitializedId = hash('sha512', 'browser-cache is initialized');
        $cacheInitialized   = $this->cache->getItem($cacheInitializedId);

        if (!$cacheInitialized->isHit() || !$cacheInitialized->get()) {
            $this->initCache($cacheInitialized);
        }
    }

    /**
     * @param string $browserKey
     *
     * @return bool
     */
    public function has(string $browserKey): bool
    {
        $this->init();

        $cacheItem = $this->cache->getItem(hash('sha512', 'browser-cache-' . $browserKey));

        return $cacheItem->isHit();
    }

    /**
     * @param string $browserKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return (\UaResult\Browser\Browser|\UaResult\Engine\EngineInterface|null)[]
     */
    public function load(string $browserKey, string $useragent = ''): array
    {
        $this->init();

        if (!$this->has($browserKey)) {
            throw new NotFoundException('the browser with key "' . $browserKey . '" was not found');
        }

        $cacheItem = $this->cache->getItem(hash('sha512', 'browser-cache-' . $browserKey));
        $browser   = $cacheItem->get();

        $browserVersionClass = $browser->version->class;

        if (!is_string($browserVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $browserVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $browser->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $browserVersionClass($this->logger);
            $version      = $versionClass->detectVersion($useragent);
        }

        $bits      = (new BrowserBits($useragent))->getBits();
        $engineKey = $browser->engine;

        if (null !== $engineKey) {
            $engine = (new EngineLoader($this->cache, $this->logger))->load($engineKey, $useragent);
        } else {
            $engine = null;
        }

        $browser = new Browser($browser->name, $browser->manufacturer, $version, $browser->type, $bits);

        return [$browser, $engine];
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
        $jsonParser = new JsonParser();
        $file       = new \SplFileInfo(__DIR__ . '/../../data/browsers.json');

        try {
            $browsers = $jsonParser->parse(
                file_get_contents($file->getPathname()),
                JsonParser::DETECT_KEY_CONFLICTS
            );
        } catch (ParsingException $e) {
            throw new \RuntimeException('file "' . $file->getPathname() . '" contains invalid json', 0, $e);
        }

        $companyLoader = CompanyLoader::getInstance($this->cache, $this->logger);
        $typeLoader    = TypeLoader::getInstance();

        foreach ($browsers as $browserKey => $browserData) {
            $cacheItem = $this->cache->getItem(hash('sha512', 'browser-cache-' . $browserKey));

            $browserData->type         = $typeLoader->load($browserData->type);
            $browserData->manufacturer = $companyLoader->load($browserData->manufacturer);

            $cacheItem->set($browserData);

            $this->cache->save($cacheItem);
        }

        $cacheInitialized->set(true);
        $this->cache->save($cacheInitialized);
    }
}
