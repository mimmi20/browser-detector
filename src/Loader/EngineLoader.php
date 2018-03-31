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
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use UaResult\Company\CompanyLoader;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

class EngineLoader
{
    private const CACHE_PREFIX = 'engine';

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
    private $enginesPath;

    /**
     * @var string|null
     */
    private $rulesPath;

    /**
     * @var JsonParser
     */
    private $jsonParser;

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     */
    public function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
        $this->jsonParser = new JsonParser();

        $this->initPath();
    }

    /**
     * @param string $useragent
     *
     * @return EngineInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Seld\JsonLint\ParsingException
     */
    public function __invoke(string $useragent): EngineInterface
    {
        $this->init();

        $devices = $this->cache->getItem($this->getCacheKey('rules'));
        $generic = $this->cache->getItem($this->getCacheKey('generic'));

        return $this->detectInArray($devices, $generic, $useragent);
    }

    /**
     * @param array  $rules
     * @param string $generic
     * @param string $useragent
     *
     * @return EngineInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function detectInArray(array $rules, string $generic, string $useragent): EngineInterface
    {
        foreach ($rules as $search => $key) {
            if (!preg_match($search, $useragent)) {
                continue;
            }

            if (is_array($key)) {
                return $this->detectInArray($key, $generic, $useragent);
            }

            return $this->load($key, $useragent);
        }

        return $this->load($generic, $useragent);
    }

    /**
     * initializes cache
     *
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

        $finder = new Finder();
        $finder->files();
        $finder->name('*.json');
        $finder->ignoreDotFiles(true);
        $finder->ignoreVCS(true);
        $finder->ignoreUnreadableDirs();
        $finder->in($this->enginesPath);

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
                    $this->logger->warning(sprintf('key "%s" was defined more than once', $key));
                    continue;
                }

                $this->cache->setItem($cacheKey, $data);
            }
        }

        $file = new SplFileInfo($this->rulesPath, '', '');

        try {
            $fileData = $this->jsonParser->parse(
                $file->getContents(),
                JsonParser::DETECT_KEY_CONFLICTS | JsonParser::PARSE_TO_ASSOC
            );
        } catch (ParsingException $e) {
            throw new \RuntimeException('file "' . $file->getPathname() . '" contains invalid json', 0, $e);
        }

        $this->cache->setItem($this->getCacheKey('rules'), $fileData['rules']);
        $this->cache->setItem($this->getCacheKey('generic'), $fileData['generic']);

        $this->cache->setItem($initKey, true);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    private function has(string $key): bool
    {
        try {
            return $this->cache->hasItem($this->getCacheKey($key));
        } catch (InvalidArgumentException $e) {
            $this->logger->info($e);

            return false;
        }
    }

    /**
     * @param string $engineKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function load(string $engineKey, string $useragent = ''): EngineInterface
    {
        if (!$this->has($engineKey)) {
            throw new NotFoundException('the engine with key "' . $engineKey . '" was not found');
        }

        try {
            $engine = $this->cache->getItem($this->getCacheKey($engineKey));
        } catch (InvalidArgumentException $e) {
            throw new NotFoundException('the engine with key "' . $engineKey . '" was not found', 0, $e);
        }

        $engineVersionClass = $engine->version->class;
        $manufacturer       = CompanyLoader::getInstance()->load($engine->manufacturer);

        if (!is_string($engineVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $engineVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $engine->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $engineVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        return new Engine(
            $engine->name,
            $manufacturer,
            $version
        );
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function getCacheKey(string $key): string
    {
        return sprintf(
            '%s_%s_%s_%s',
            self::CACHE_PREFIX,
            $this->clearCacheKey($this->enginesPath),
            $this->clearCacheKey($this->rulesPath),
            $this->clearCacheKey($key)
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
     * @return void
     */
    private function initPath(): void
    {
        $this->enginesPath = __DIR__ . '/../../data/engines';
        $this->rulesPath   = __DIR__ . '/../../data/factories/engines.json';
    }
}
