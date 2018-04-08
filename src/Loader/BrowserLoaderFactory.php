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
use Seld\JsonLint\JsonParser;
use Symfony\Component\Finder\Finder;

class BrowserLoaderFactory
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
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     */
    public function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
    }

    /**
     * @param string $mode
     *
     * @return BrowserLoader
     */
    public function __invoke(string $mode): BrowserLoader
    {
        static $loaders = [];

        if (!array_key_exists($mode, $loaders)) {
            $dataPath  = __DIR__ . '/../../data/browsers';
            $rulesPath = __DIR__ . '/../../data/factories/browsers/' . $mode . '.json';

            $finder = new Finder();
            $finder->files();
            $finder->name('*.json');
            $finder->ignoreDotFiles(true);
            $finder->ignoreVCS(true);
            $finder->ignoreUnreadableDirs();
            $finder->in($dataPath);

            $loader = new BrowserLoader(
                $this->cache,
                $this->logger,
                $finder,
                new JsonParser(),
                $dataPath,
                $rulesPath
            );

            $loaders[$mode] = $loader;
        }

        return $loaders[$mode];
    }
}
