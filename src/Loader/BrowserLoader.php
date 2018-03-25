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
     * @throws \Psr\SimpleCache\InvalidArgumentException
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

        foreach ($this->getBrowsers() as $browserKey => $data) {
            $cacheKey = $this->getCacheKey((string) $browserKey);

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
    private function getBrowsers(): \Generator
    {
        static $browsers = null;

        if (null === $browsers) {
            $jsonParser = new JsonParser();
            $browsers   = [];

            $finder = new Finder();
            $finder->files();
            $finder->name('*.json');
            $finder->ignoreDotFiles(true);
            $finder->ignoreVCS(true);
            $finder->ignoreUnreadableDirs();
            $finder->in(__DIR__ . '/../../data/browsers/');

            foreach ($finder as $file) {
                /** @var \Symfony\Component\Finder\SplFileInfo $file */

                try {
                    $browsersFile = $jsonParser->parse(
                        $file->getContents(),
                        JsonParser::DETECT_KEY_CONFLICTS
                    );
                } catch (ParsingException $e) {
                    throw new \RuntimeException('file "' . $file->getPathname() . '" contains invalid json', 0, $e);
                }

                foreach ($browsersFile as $browserKey => $browserData) {
                    if (array_key_exists($browserKey, $browsers)) {
                        throw new \RuntimeException('browser key "' . $browserKey . '" was defined more then once');
                    }

                    $browsers[$browserKey] = $browserData;
                }
            }
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
     * @param string $browserKey
     *
     * @return string
     */
    private function getCacheKey(string $browserKey): string
    {
        return self::CACHE_PREFIX . '_' . str_replace(['{', '}', '(', ')', '/', '\\', '@', ':'], '_', $browserKey);
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
