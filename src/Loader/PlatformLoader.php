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
use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Seld\JsonLint\JsonParser;
use UaResult\Company\CompanyLoader;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

class PlatformLoader implements ExtendedLoaderInterface
{
    private const CACHE_PREFIX = 'platform';

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
     * @throws \Seld\JsonLint\ParsingException
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
     * @throws \Seld\JsonLint\ParsingException
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

        foreach ($this->getPlatforms() as $platformCode => $data) {
            $cacheKey = $this->getCacheKey((string) $platformCode);

            if ($this->cache->hasItem($cacheKey)) {
                continue;
            }

            $this->cache->setItem($cacheKey, $data);
        }

        $this->cache->setItem($initKey, true);
    }

    /**
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return \Generator|\stdClass[]
     */
    private function getPlatforms(): \Generator
    {
        static $platforms = null;

        if (null === $platforms) {
            $jsonParser = new JsonParser();
            $platforms  = $jsonParser->parse(
                file_get_contents(__DIR__ . '/../../data/platforms.json'),
                JsonParser::DETECT_KEY_CONFLICTS
            );
        }

        foreach ($platforms as $platformCode => $data) {
            yield $platformCode => $data;
        }
    }

    /**
     * @param string $platformCode
     *
     * @return bool
     */
    public function has(string $platformCode): bool
    {
        try {
            return $this->cache->hasItem($this->getCacheKey($platformCode));
        } catch (InvalidArgumentException $e) {
            $this->logger->info($e);

            return false;
        }
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
        if (!$this->has($platformCode)) {
            throw new NotFoundException('the platform with key "' . $platformCode . '" was not found');
        }

        try {
            $platform = $this->cache->getItem($this->getCacheKey($platformCode));
        } catch (InvalidArgumentException $e) {
            throw new NotFoundException('the platform with key "' . $platformCode . '" was not found', 0, $e);
        }

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
        $manufacturer  = CompanyLoader::getInstance()->load($platform->manufacturer);

        if ('Mac OS X' === $name
            && version_compare($version->getVersion(VersionInterface::IGNORE_MICRO), '10.12', '>=')
        ) {
            $name          = 'macOS';
            $marketingName = 'macOS';
        }

        $bits = (new OsBits($useragent))->getBits();

        return new Os($name, $marketingName, $manufacturer, $version, $bits);
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
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return void
     */
    public function warmupCache(): void
    {
        $this->init();
    }
}
