<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\CompanyLoaderFactory;
use BrowserDetector\Parser\BrowserParserFactory;
use BrowserDetector\Parser\DeviceParserFactory;
use BrowserDetector\Parser\EngineParserFactory;
use BrowserDetector\Parser\PlatformParserFactory;
use JsonClass\Json;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface as PsrCacheInterface;
use Symfony\Component\Finder\Finder;

final class DetectorFactory
{
    /**
     * @var \Psr\SimpleCache\CacheInterface
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
        $this->cache  = $cache;
        $this->logger = $logger;
    }

    /**
     * @return Detector
     */
    public function __invoke(): Detector
    {
        static $detector = null;

        if (null === $detector) {
            $jsonParser           = new Json();
            $companyLoaderFactory = new CompanyLoaderFactory($jsonParser, new Finder());

            /** @var CompanyLoader $companyLoader */
            $companyLoader = $companyLoaderFactory();

            $platformParserFactory = new PlatformParserFactory($this->logger, $jsonParser, $companyLoader);
            $platformParser        = $platformParserFactory();
            $deviceParserFactory   = new DeviceParserFactory($this->logger, $jsonParser, $companyLoader, $platformParser);
            $deviceParser          = $deviceParserFactory();
            $engineParserFactory   = new EngineParserFactory($this->logger, $jsonParser, $companyLoader);
            $engineParser          = $engineParserFactory();
            $browserParserFactory  = new BrowserParserFactory($this->logger, $jsonParser, $companyLoader, $engineParser);
            $browserParser         = $browserParserFactory();

            $detector = new Detector($this->logger, new Cache($this->cache), $deviceParser, $platformParser, $browserParser, $engineParser);
        }

        return $detector;
    }
}
