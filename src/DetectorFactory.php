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
use BrowserDetector\Parser\BrowserParser;
use BrowserDetector\Parser\DeviceParser;
use BrowserDetector\Parser\EngineParser;
use BrowserDetector\Parser\PlatformParser;
use JsonClass\Json;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface as PsrCacheInterface;

final class DetectorFactory
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
            $jsonParser = new Json();

            $platformParser = new PlatformParser($this->logger, $jsonParser);
            $deviceParser   = new DeviceParser($this->logger, $jsonParser, $platformParser);
            $engineParser   = new EngineParser($this->logger, $jsonParser);
            $browserParser  = new BrowserParser($this->logger, $jsonParser, $engineParser);

            $detector = new Detector($this->logger, $this->cache, $deviceParser, $platformParser, $browserParser, $engineParser);
        }

        return $detector;
    }
}
