<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
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
    private Detector | null $detector = null;

    /** @throws void */
    public function __construct(private readonly PsrCacheInterface $cache, private readonly LoggerInterface $logger)
    {
        // nothing to do
    }

    /** @throws void */
    public function __invoke(): Detector
    {
        if ($this->detector === null) {
            $companyLoaderFactory = new CompanyLoaderFactory();

            $companyLoader = $companyLoaderFactory();

            $platformParserFactory = new PlatformParserFactory($this->logger, $companyLoader);
            $platformParser        = $platformParserFactory();
            $deviceParserFactory   = new DeviceParserFactory($this->logger, $companyLoader);
            $deviceParser          = $deviceParserFactory();
            $engineParserFactory   = new EngineParserFactory($this->logger, $companyLoader);
            $engineParser          = $engineParserFactory();
            $browserParserFactory  = new BrowserParserFactory($this->logger, $companyLoader);
            $browserParser         = $browserParserFactory();
            $normalizerFactory     = new NormalizerFactory();

            $requestBuilder = new RequestBuilder(
                $deviceParser,
                $platformParser,
                $browserParser,
                $engineParser,
                $normalizerFactory,
            );

            $this->detector = new Detector(
                $this->logger,
                new Cache($this->cache),
                $requestBuilder,
                $deviceParser,
                $platformParser,
                $browserParser,
                $engineParser,
            );
        }

        return $this->detector;
    }
}
