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
use Symfony\Component\Finder\SplFileInfo;
use UaResult\Browser\Browser;

trait LoaderTrait
{
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
    private $dataPath = '';

    /**
     * @var string
     */
    private $rulesPath = '';

    /**
     * @var JsonParser
     */
    private $jsonParser;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     * @param \Symfony\Component\Finder\Finder      $finder
     * @param \Seld\JsonLint\JsonParser             $jsonParser
     * @param string                                $dataPath
     * @param string                                $rulesPath
     */
    public function __construct(
        CacheInterface $cache,
        LoggerInterface $logger,
        Finder $finder,
        JsonParser $jsonParser,
        string $dataPath,
        string $rulesPath
    ) {
        $this->cache      = $cache;
        $this->logger     = $logger;
        $this->finder     = $finder;
        $this->jsonParser = $jsonParser;
        $this->dataPath   = $dataPath;
        $this->rulesPath  = $rulesPath;
    }

    /**
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return mixed
     */
    public function __invoke(string $useragent)
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
     * @return mixed
     */
    private function detectInArray(array $rules, string $generic, string $useragent)
    {
        foreach ($rules as $search => $key) {
            if (!preg_match($search, $useragent)) {
                continue;
            }

            if (is_array($key)) {
                return $this->detectInArray($key, $generic, $useragent);
            }

            if (!$this->has($key)) {
                throw new NotFoundException('the data with key "' . $key . '" were not found');
            }

            return $this->load($key, $useragent);
        }

        if (!$this->has($generic)) {
            throw new NotFoundException('the data with key "' . $generic . '" were not found');
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

        foreach ($this->finder as $file) {
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
        }

        return false;
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
            $this->clearCacheKey($this->dataPath),
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
}
