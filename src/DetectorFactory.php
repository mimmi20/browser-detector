<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Loader\CompanyLoaderFactory;
use BrowserDetector\Parser\BrowserParserFactory;
use BrowserDetector\Parser\DeviceParserFactory;
use BrowserDetector\Parser\EngineParserFactory;
use BrowserDetector\Parser\PlatformParserFactory;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface as PsrCacheInterface;
use UaNormalizer\NormalizerFactory;

final class DetectorFactory
{
    private PsrCacheInterface $cache;

    private LoggerInterface $logger;

    private ?Detector $detector = null;

    public function __construct(PsrCacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
    }

    public function __invoke(): Detector
    {
        if (null === $this->detector) {
            $companyLoaderFactory = new CompanyLoaderFactory();

            $companyLoader = $companyLoaderFactory();

            $platformParserFactory = new PlatformParserFactory($this->logger, $companyLoader);
            $platformParser        = $platformParserFactory();
            $deviceParserFactory   = new DeviceParserFactory($this->logger, $companyLoader, $platformParser);
            $deviceParser          = $deviceParserFactory();
            $engineParserFactory   = new EngineParserFactory($this->logger, $companyLoader);
            $engineParser          = $engineParserFactory();
            $browserParserFactory  = new BrowserParserFactory($this->logger, $companyLoader, $engineParser);
            $browserParser         = $browserParserFactory();
            $normalizer            = (new NormalizerFactory())->build();

            $this->detector = new Detector(
                $this->logger,
                new Cache($this->cache),
                $deviceParser,
                $platformParser,
                $browserParser,
                $engineParser,
                $normalizer
            );
        }

        return $this->detector;
    }
}
