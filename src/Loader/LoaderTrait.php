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
use BrowserDetector\Loader\Helper\CacheKey;
use BrowserDetector\Loader\Helper\InitRules;
use Psr\Log\LoggerInterface;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Finder\Finder;

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
     * @var \Seld\JsonLint\JsonParser
     */
    private $jsonParser;

    /**
     * @var \Symfony\Component\Finder\Finder
     */
    private $finder;

    /**
     * @var \BrowserDetector\Loader\Helper\CacheKey
     */
    private $cacheKey;

    /**
     * @var \BrowserDetector\Loader\Helper\InitRules
     */
    private $initRules;

    /**
     * @param \BrowserDetector\Cache\CacheInterface    $cache
     * @param \Psr\Log\LoggerInterface                 $logger
     * @param \Symfony\Component\Finder\Finder         $finder
     * @param \Seld\JsonLint\JsonParser                $jsonParser
     * @param \BrowserDetector\Loader\Helper\CacheKey  $cacheKey
     * @param \BrowserDetector\Loader\Helper\InitRules $initRules
     */
    public function __construct(
        CacheInterface $cache,
        LoggerInterface $logger,
        Finder $finder,
        JsonParser $jsonParser,
        CacheKey $cacheKey,
        InitRules $initRules
    ) {
        $this->cache      = $cache;
        $this->logger     = $logger;
        $this->finder     = $finder;
        $this->jsonParser = $jsonParser;
        $this->cacheKey   = $cacheKey;
        $this->initRules  = $initRules;
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

        $cacheKey = $this->cacheKey;
        $devices  = $this->cache->getItem($cacheKey('rules'));
        $generic  = $this->cache->getItem($cacheKey('generic'));

        return $this->detectInArray($devices, $generic, $useragent);
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
        $cacheKey = $this->cacheKey;
        $initKey  = $cacheKey('initialized');

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
                $itemKey = $cacheKey((string) $key);

                if ($this->cache->hasItem($itemKey)) {
                    $this->logger->warning(sprintf('key "%s" was defined more than once', $key));
                    continue;
                }

                $this->cache->setItem($itemKey, $data);
            }
        }

        $initRules = $this->initRules;
        $initRules();
        $this->cache->setItem($initKey, true);
    }

    /**
     * @param array  $rules
     * @param string $generic
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \BrowserDetector\Loader\NotFoundException
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

            return $this->load($key, $useragent);
        }

        return $this->load($generic, $useragent);
    }
}
