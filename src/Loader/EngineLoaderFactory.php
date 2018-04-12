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
use BrowserDetector\Loader\Helper\InitData;
use BrowserDetector\Loader\Helper\InitRules;
use Psr\Log\LoggerInterface;
use Seld\JsonLint\JsonParser;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use UaResult\Company\CompanyLoader;

class EngineLoaderFactory
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
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     */
    public function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
    }

    /**
     * @return Loader
     */
    public function __invoke(): Loader
    {
        static $loader = null;

        if (null === $loader) {
            $dataPath  = __DIR__ . '/../../data/engines';
            $rulesPath = __DIR__ . '/../../data/factories/engines.json';

            $finder = new Finder();
            $finder->files();
            $finder->name('*.json');
            $finder->ignoreDotFiles(true);
            $finder->ignoreVCS(true);
            $finder->ignoreUnreadableDirs();
            $finder->in($dataPath);

            $jsonParser = new JsonParser();
            $cacheKey   = new CacheKey(self::CACHE_PREFIX, $dataPath, $rulesPath);
            $file       = new SplFileInfo($rulesPath, '', '');
            $initRules  = new InitRules($this->cache, $jsonParser, $cacheKey, $file);
            $initData   = new InitData(
                $this->cache,
                $finder,
                $jsonParser,
                $cacheKey
            );

            $loader = new EngineLoader(
                $this->cache,
                $this->logger,
                $cacheKey,
                CompanyLoader::getInstance()
            );

            $loader = new Loader(
                $this->cache,
                $this->logger,
                $cacheKey,
                $initRules,
                $initData,
                $loader
            );
        }

        return $loader;
    }
}
