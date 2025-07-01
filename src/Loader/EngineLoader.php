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

namespace BrowserDetector\Loader;

use BrowserDetector\Version\VersionBuilderInterface;
use Override;
use Psr\Log\LoggerInterface;
use RuntimeException;
use UaLoader\EngineLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaResult\Company\Company;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

final class EngineLoader implements EngineLoaderInterface
{
    use VersionFactoryTrait;

    /**
     * @phpstan-param Data\DataInterface&Data\Engine $initData
     *
     * @throws void
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly Data\DataInterface $initData,
        private readonly CompanyLoaderInterface $companyLoader,
        VersionBuilderInterface $versionBuilder,
    ) {
        $this->versionBuilder = $versionBuilder;
    }

    /** @throws NotFoundException */
    #[Override]
    public function load(string $key, string $useragent = ''): EngineInterface
    {
        try {
            $this->initData->init();
        } catch (RuntimeException $e) {
            throw new NotFoundException('the engine with key "' . $key . '" was not found', 0, $e);
        }

        $engineData = $this->initData->getItem($key);

        if ($engineData === null) {
            throw new NotFoundException('the engine with key "' . $key . '" was not found');
        }

        $version      = $this->getVersion($engineData->getVersion(), $useragent);
        $manufacturer = new Company(type: 'unknown', name: null, brandname: null);

        if ($engineData->getManufacturer() !== null) {
            try {
                $manufacturer = $this->companyLoader->load($engineData->getManufacturer());
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        return new Engine(name: $engineData->getName(), manufacturer: $manufacturer, version: $version);
    }
}
