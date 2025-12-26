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
use UaLoader\EngineLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaResult\Company\Company;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;
use UnexpectedValueException;

final class EngineLoader implements EngineLoaderInterface
{
    use VersionFactoryTrait;

    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CompanyLoaderInterface $companyLoader,
        VersionBuilderInterface $versionBuilder,
    ) {
        $this->versionBuilder = $versionBuilder;
    }

    /** @throws void */
    #[Override]
    public function load(string $key, string $useragent = ''): EngineInterface
    {
        try {
            $engine = \BrowserDetector\Data\Engine::fromName($key);
        } catch (UnexpectedValueException) {
            $engine = \BrowserDetector\Data\Engine::unknown;
        }

        return $this->loadFromEngine($engine, $useragent);
    }

    /** @throws void */
    #[Override]
    public function loadFromEngine(\UaData\EngineInterface $engine, string $useragent = ''): EngineInterface
    {
        $version      = $this->getVersion((object) $engine->getVersion(), $useragent);
        $manufacturer = new Company(type: 'unknown', name: null, brandname: null);

        if ($engine->getManufacturer()->getBrandname() !== null) {
            try {
                $manufacturer = $this->companyLoader->load($engine->getManufacturer()->getBrandname());
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        return new Engine(name: $engine->getName(), manufacturer: $manufacturer, version: $version);
    }
}
