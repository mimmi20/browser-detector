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
namespace BrowserDetector;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\EngineLoaderFactory;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface as PsrCacheInterface;

class DetectorFactory
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
     * @param \Psr\SimpleCache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface        $logger
     */
    public function __construct(PsrCacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = new Cache($cache);
        $this->logger = $logger;
    }

    /**
     * @return Detector
     */
    public function __invoke(): Detector
    {
        static $detector = null;

        if (null === $detector) {
            $deviceFactory   = new DeviceFactory($this->cache, $this->logger);
            $platformFactory = new PlatformFactory($this->cache, $this->logger);
            $browserFactory  = new BrowserFactory($this->cache, $this->logger);

            $factory       = new EngineLoaderFactory($this->cache, $this->logger);
            $engineLoader  = $factory();

            $detector = new Detector($this->logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);
        }

        return $detector;
    }
}
