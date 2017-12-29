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
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Seld\JsonLint\JsonParser;
use UaBrowserType\TypeLoader;
use UaResult\Browser\Browser;
use UaResult\Company\CompanyLoader;

class BrowserLoader implements ExtendedLoaderInterface
{
    private const CACHE_PREFIX = 'browser';

    /**
     * @var \Psr\SimpleCache\CacheInterface
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
     * @param \Psr\SimpleCache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface        $logger
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Seld\JsonLint\ParsingException
     */
    private function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;

        $this->init();
    }

    /**
     * @param \Psr\SimpleCache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface        $logger
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
     * @throws \Seld\JsonLint\ParsingException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    private function init(): void
    {
        foreach ($this->getBrowsers() as $browserKey => $data) {
            $cacheKey = $this->getCacheKey((string) $browserKey);

            if ($this->cache->has($cacheKey)) {
                continue;
            }

            $this->cache->set($cacheKey, $data);
        }
    }

    /**
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return \Generator|\stdClass[]
     */
    private function getBrowsers(): \Generator
    {
        static $browsers = null;

        if (null === $browsers) {
            $jsonParser = new JsonParser();
            $browsers   = $jsonParser->parse(
                file_get_contents(__DIR__ . '/../../data/browsers.json'),
                JsonParser::DETECT_KEY_CONFLICTS
            );
        }

        foreach ($browsers as $browserKey => $data) {
            yield $browserKey => $data;
        }
    }

    /**
     * @param string $browserKey
     *
     * @return bool
     */
    public function has(string $browserKey): bool
    {
        try {
            return $this->cache->has($this->getCacheKey($browserKey));
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
            $browserData = $this->cache->get($this->getCacheKey($browserKey));
        } catch (InvalidArgumentException $e) {
            throw new NotFoundException('the browser with key "' . $browserKey . '" was not found', 0, $e);
        }

        $browserVersionClass = $browserData->version->class;
        $manufacturer        = CompanyLoader::getInstance()->load($browserData->manufacturer);
        $type                = TypeLoader::getInstance()->load($browserData->type);

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

        if (null !== $engineKey) {
            try {
                $engine = EngineLoader::getInstance($this->cache, $this->logger)->load($engineKey, $useragent);
            } catch (NotFoundException $e) {
                $this->logger->info($e);

                $engine = null;
            }
        } else {
            $engine = null;
        }

        $browser = new Browser($browserData->name, $manufacturer, $version, $type, $bits);

        return [$browser, $engine];
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
}
