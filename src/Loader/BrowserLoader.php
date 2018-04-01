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
use Symfony\Component\Finder\SplFileInfo;
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
     * @var string
     */
    private $browsersPath = '';

    /**
     * @var string
     */
    private $rulesPath = '';

    /**
     * @var JsonParser
     */
    private $jsonParser;

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     * @param string                                $mode
     */
    public function __construct(CacheInterface $cache, LoggerInterface $logger, string $mode)
    {
        $this->cache      = $cache;
        $this->logger     = $logger;
        $this->jsonParser = new JsonParser();

        $this->initPath($mode);
    }

    /**
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
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
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array
     */
    private function detectInArray(array $rules, string $generic, string $useragent): array
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
        $finder->in($this->browsersPath);

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
    public function has(string $key): bool
    {
        try {
            return $this->cache->hasItem($this->getCacheKey($key));
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
                $loaderFactory = new EngineLoaderFactory($this->cache, $this->logger);
                $loader        = $loaderFactory();
                $engine        = $loader->load($engineKey, $useragent);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $browser = new Browser($browserData->name, $manufacturer, $version, $type, $bits);

        return [$browser, $engine];
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
            $this->clearCacheKey($this->browsersPath),
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
     * @param string $mode
     *
     * @return void
     */
    private function initPath(string $mode): void
    {
        $this->browsersPath = __DIR__ . '/../../data/browsers';
        $this->rulesPath    = __DIR__ . '/../../data/factories/browsers/' . $mode . '.json';
    }
}
