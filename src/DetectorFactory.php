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
use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\CompanyLoaderFactory;
use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetector\Parser\BrowserParserFactory;
use BrowserDetector\Parser\DeviceParserFactory;
use BrowserDetector\Parser\EngineParserFactory;
use BrowserDetector\Parser\PlatformParserFactory;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderFactory;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface as PsrCacheInterface;
use RuntimeException;
use UaBrowserType\TypeLoader;
use UaNormalizer\NormalizerFactory;

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
                $this->logger,
                new Data(PlatformLoader::DATA_PATH, 'json'),
                $companyLoader,
                new VersionBuilder($this->logger),
            );

            $platformParserFactory = new PlatformParserFactory($this->logger);
            $platformParser        = $platformParserFactory();

            $deviceLoaderFactory = new DeviceLoaderFactory($this->logger, $companyLoader);

            $deviceParserFactory = new DeviceParserFactory($this->logger);
            $deviceParser        = $deviceParserFactory();

            $engineLoader = new EngineLoader(
                $this->logger,
                new Data(EngineLoader::DATA_PATH, 'json'),
                $companyLoader,
                new VersionBuilder($this->logger),
            );

            $engineParserFactory = new EngineParserFactory($this->logger);
            $engineParser        = $engineParserFactory();

            $browserLoader = new BrowserLoader(
                $this->logger,
                new Data(BrowserLoader::DATA_PATH, 'json'),
                $companyLoader,
                new TypeLoader(),
                new VersionBuilder($this->logger),
            );

            $browserParserFactory = new BrowserParserFactory($this->logger);
            $browserParser        = $browserParserFactory();

            $normalizerFactory = new NormalizerFactory();

            $requestBuilder = new RequestBuilder(
                $deviceParser,
                $platformParser,
                $browserParser,
                $engineParser,
                $normalizerFactory,
                $browserLoader,
                $platformLoader,
                $engineLoader,
            );

            $this->detector = new Detector(
                $this->logger,
                new Cache($this->cache),
                $requestBuilder,
                $deviceLoaderFactory,
                $platformLoader,
                $browserLoader,
                $engineLoader,
                new VersionBuilderFactory(),
            );
        }

        return $this->detector;
    }
}
