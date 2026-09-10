<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
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
use BrowserDetector\Loader\MappingfileLoader;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetector\Parser\BrowserParserFactory;
use BrowserDetector\Parser\DeviceParserFactory;
use BrowserDetector\Parser\EngineParserFactory;
use BrowserDetector\Parser\Header\HeaderLoader;
use BrowserDetector\Parser\Helper\RulefileParser;
use BrowserDetector\Parser\PlatformParserFactory;
use BrowserDetector\Version\VersionBuilder;
use Laminas\Hydrator\Exception\InvalidArgumentException;
use Laminas\Hydrator\Strategy\SerializableStrategy;
use Laminas\Serializer\Adapter\Json;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface as PsrCacheInterface;
use UaNormalizer\NormalizerFactory;
use UaRequest\RequestBuilder;

final class DetectorFactory
{
    private Detector | null $detector = null;

    /** @throws void */
    public function __construct(
        private readonly PsrCacheInterface $psrCache,
        private readonly LoggerInterface $logger,
        private readonly bool $autoUpdate = false,
    ) {
        // nothing to do
    }

    /** @throws InvalidArgumentException */
    public function __invoke(): Detector
    {
        if (!$this->detector instanceof Detector) {
            $companyLoaderFactory = new CompanyLoaderFactory();

            $serializableStrategy = new SerializableStrategy(
                new Json(),
            );

            $companyLoader = $companyLoaderFactory($serializableStrategy);

            $platformLoader = new PlatformLoader(
                logger: $this->logger,
                companyLoader: $companyLoader,
                versionBuilder: new VersionBuilder(),
            );

            $platformParserFactory = new PlatformParserFactory();
            $platformParser        = $platformParserFactory();

            $deviceLoaderFactory = new DeviceLoaderFactory(
                logger: $this->logger,
                companyLoader: $companyLoader,
            );

            $ruleFileParser = new RulefileParser(logger: $this->logger);

            $deviceParserFactory = new DeviceParserFactory(rulefileParser: $ruleFileParser);
            $deviceParser        = $deviceParserFactory();

            $engineLoader = new EngineLoader(
                logger: $this->logger,
                companyLoader: $companyLoader,
                versionBuilder: new VersionBuilder(),
            );

            $engineParserFactory = new EngineParserFactory(rulefileParser: $ruleFileParser);
            $engineParser        = $engineParserFactory();

            $browserLoader = new BrowserLoader(
                logger: $this->logger,
                initData: new Data\Client(),
                companyLoader: $companyLoader,
                versionBuilder: new VersionBuilder(),
            );

            $browserParserFactory = new BrowserParserFactory(rulefileParser: $ruleFileParser);
            $browserParser        = $browserParserFactory();

            $normalizerFactory = new NormalizerFactory();
            $mappingfileLoader = new MappingfileLoader();

            $headerLoader = new HeaderLoader(
                deviceParser: $deviceParser,
                platformParser: $platformParser,
                browserParser: $browserParser,
                engineParser: $engineParser,
                normalizerFactory: $normalizerFactory,
                browserLoader: $browserLoader,
                platformLoader: $platformLoader,
                engineLoader: $engineLoader,
                mappingFileParser: $mappingfileLoader,
                logger: $this->logger,
                autoUpdate: $this->autoUpdate,
            );

            $requestBuilder = new RequestBuilder(headerLoader: $headerLoader);

            $this->detector = new Detector(
                logger: $this->logger,
                cache: new Cache(cache: $this->psrCache),
                requestBuilder: $requestBuilder,
                deviceLoaderFactory: $deviceLoaderFactory,
                platformLoader: $platformLoader,
                browserLoader: $browserLoader,
                engineLoader: $engineLoader,
            );
        }

        return $this->detector;
    }
}
