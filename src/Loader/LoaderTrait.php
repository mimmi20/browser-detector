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
use Psr\Log\LoggerInterface;

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
     * @var \BrowserDetector\Loader\Helper\CacheKey
     */
    private $cacheKey;

    /**
     * @param \BrowserDetector\Cache\CacheInterface   $cache
     * @param \Psr\Log\LoggerInterface                $logger
     * @param \BrowserDetector\Loader\Helper\CacheKey $cacheKey
     */
    public function __construct(
        CacheInterface $cache,
        LoggerInterface $logger,
        CacheKey $cacheKey
    ) {
        $this->cache    = $cache;
        $this->logger   = $logger;
        $this->cacheKey = $cacheKey;
    }
}
