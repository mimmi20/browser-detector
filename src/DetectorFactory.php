<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\CompanyLoaderFactory;
use BrowserDetector\Loader\Data;
use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetector\Parser\BrowserParserFactory;
use BrowserDetector\Parser\DeviceParserFactory;
use BrowserDetector\Parser\EngineParserFactory;
use BrowserDetector\Parser\Header\HeaderLoader;
use BrowserDetector\Parser\PlatformParserFactory;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderFactory;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface as PsrCacheInterface;
use RuntimeException;
use UaNormalizer\NormalizerFactory;
use UaRequest\RequestBuilder;

final class DetectorFactory
{
    private Detector | null $detector = null;

    /** @throws void */
    public function __construct(private readonly PsrCacheInterface $cache, private readonly LoggerInterface $logger)
    {
        // nothing to do
    }

    /** @throws RuntimeException */
    public function __invoke(): Detector
    {
        if ($this->detector === null) {
            $companyLoaderFactory = new CompanyLoaderFactory();

            $companyLoader = $companyLoaderFactory();

            $platformLoader = new PlatformLoader(
                logger: $this->logger,
                initData: new Data(PlatformLoader::DATA_PATH, 'json'),
                companyLoader: $companyLoader,
                versionBuilder: new VersionBuilder(),
            );

            $platformParserFactory = new PlatformParserFactory(logger: $this->logger);
            $platformParser        = $platformParserFactory();

            $deviceLoaderFactory = new DeviceLoaderFactory(
                logger: $this->logger,
                companyLoader: $companyLoader,
            );

            $deviceParserFactory = new DeviceParserFactory(logger: $this->logger);
            $deviceParser        = $deviceParserFactory();

            $engineLoader = new EngineLoader(
                logger: $this->logger,
                initData: new Data(EngineLoader::DATA_PATH, 'json'),
                companyLoader: $companyLoader,
                versionBuilder: new VersionBuilder(),
            );

            $engineParserFactory = new EngineParserFactory(logger: $this->logger);
            $engineParser        = $engineParserFactory();

            $browserLoader = new BrowserLoader(
                logger: $this->logger,
                initData: new Data(BrowserLoader::DATA_PATH, 'json'),
                companyLoader: $companyLoader,
                versionBuilder: new VersionBuilder(),
            );

            $browserParserFactory = new BrowserParserFactory(logger: $this->logger);
            $browserParser        = $browserParserFactory();

            $normalizerFactory = new NormalizerFactory();

            $headerLoader = new HeaderLoader(
                deviceParser: $deviceParser,
                platformParser: $platformParser,
                browserParser: $browserParser,
                engineParser: $engineParser,
                normalizerFactory: $normalizerFactory,
                browserLoader: $browserLoader,
                platformLoader: $platformLoader,
                engineLoader: $engineLoader,
            );

            $requestBuilder = new RequestBuilder(headerLoader: $headerLoader);

            $this->detector = new Detector(
                logger: $this->logger,
                cache: new Cache(cache: $this->cache),
                requestBuilder: $requestBuilder,
                deviceLoaderFactory: $deviceLoaderFactory,
                platformLoader: $platformLoader,
                browserLoader: $browserLoader,
                engineLoader: $engineLoader,
                versionBuilderFactory: new VersionBuilderFactory(),
            );
        }

        return $this->detector;
    }
}
