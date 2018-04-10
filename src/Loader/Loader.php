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

class Loader
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
     * @var \BrowserDetector\Loader\Helper\CacheKey
     */
    private $cacheKey;

    /**
     * @var \BrowserDetector\Loader\Helper\InitRules
     */
    private $initRules;

    /**
     * @var \BrowserDetector\Loader\Helper\InitData
     */
    private $initData;

    /**
     * @var \BrowserDetector\Loader\SpecificLoaderInterface
     */
    private $specificLoader;

    /**
     * @param \BrowserDetector\Cache\CacheInterface           $cache
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \BrowserDetector\Loader\Helper\CacheKey         $cacheKey
     * @param \BrowserDetector\Loader\Helper\InitRules        $initRules
     * @param \BrowserDetector\Loader\Helper\InitData         $initData
     * @param \BrowserDetector\Loader\SpecificLoaderInterface $load
     */
    public function __construct(
        CacheInterface $cache,
        LoggerInterface $logger,
        CacheKey $cacheKey,
        InitRules $initRules,
        InitData $initData,
        SpecificLoaderInterface $load
    ) {
        $this->cache          = $cache;
        $this->logger         = $logger;
        $this->cacheKey       = $cacheKey;
        $this->initRules      = $initRules;
        $this->initData       = $initData;
        $this->specificLoader = $load;
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

        return $this->detectInArray($devices, $generic, $useragent, $this->specificLoader);
    }

    /**
     * initializes cache
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function init(): void
    {
        $cacheKey = $this->cacheKey;
        $initKey  = $cacheKey('initialized');

        if ($this->cache->getItem($initKey)) {
            return;
        }

        $initData = $this->initData;
        $initData();

        $initRules = $this->initRules;
        $initRules();
        $this->cache->setItem($initKey, true);
    }

    /**
     * @param array                                           $rules
     * @param string                                          $generic
     * @param string                                          $useragent
     * @param \BrowserDetector\Loader\SpecificLoaderInterface $load
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return mixed
     */
    private function detectInArray(array $rules, string $generic, string $useragent, SpecificLoaderInterface $load)
    {
        foreach ($rules as $search => $key) {
            if (!preg_match($search, $useragent)) {
                continue;
            }

            if (is_array($key)) {
                return $this->detectInArray($key, $generic, $useragent, $load);
            }

            return $load($key, $useragent);
        }

        return $load($generic, $useragent);
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @return mixed
     */
    public function load(string $key, string $useragent = '')
    {
        $load = $this->specificLoader;

        return $load($key, $useragent);
    }
}
