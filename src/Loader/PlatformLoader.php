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

use BrowserDetector\Bits\Os as OsBits;
use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use UaResult\Company\CompanyLoader;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

class PlatformLoader
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
     * @var string
     */
    private $platformsPath = '';

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
     * @return OsInterface
     */
    public function __invoke(string $useragent): OsInterface
    {
        $this->init();

        $platforms = $this->cache->getItem($this->getCacheKey('rules'));
        $generic   = $this->cache->getItem($this->getCacheKey('generic'));

        return $this->detectInArray($platforms, $generic, $useragent);
    }

    /**
     * @param array  $rules
     * @param string $generic
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return OsInterface
     */
    private function detectInArray(array $rules, string $generic, string $useragent): OsInterface
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
        $finder->in($this->platformsPath);

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
     * @param string $platformCode
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Os\OsInterface
     */
    public function load(string $platformCode, string $useragent = ''): OsInterface
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

        if (!is_string($platformVersionClass) && isset($platform->version->value) && is_numeric($platform->version->value)) {
            $version = (new VersionFactory())->set((string) $platform->version->value);
        } elseif (!is_string($platformVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $platformVersionClass) {
            $version = (new VersionFactory())->detectVersion($useragent, $platform->version->search);
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
     * @param string $key
     *
     * @return string
     */
    private function getCacheKey(string $key): string
    {
        return sprintf(
            '%s_%s_%s_%s',
            self::CACHE_PREFIX,
            $this->clearCacheKey($this->platformsPath),
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
        $this->platformsPath = __DIR__ . '/../../data/platforms';
        $this->rulesPath     = __DIR__ . '/../../data/factories/platforms/' . $mode . '.json';
    }
}
