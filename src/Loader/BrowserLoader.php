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

use BrowserDetector\Loader\Data\ClientData;
use BrowserDetector\Loader\InitData\Client as DataClient;
use BrowserDetector\Version\VersionBuilderInterface;
use Override;
use Psr\Log\LoggerInterface;
use RuntimeException;
use UaBrowserType\Type;
use UaLoader\BrowserLoaderInterface;
use UaLoader\Data\ClientDataInterface;
use UaLoader\Exception\NotFoundException;
use UaResult\Browser\Browser;
use UaResult\Company\Company;

final class BrowserLoader implements BrowserLoaderInterface
{
    use VersionFactoryTrait;

    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly Data\Client $initData,
        private readonly CompanyLoaderInterface $companyLoader,
        VersionBuilderInterface $versionBuilder,
    ) {
        $this->versionBuilder = $versionBuilder;
    }

    /** @throws NotFoundException */
    #[Override]
    public function load(string $key, string $useragent = ''): ClientDataInterface
    {
        try {
            $this->initData->init();
        } catch (RuntimeException $e) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found', 0, $e);
        }

        $browserData = $this->initData->getItem($key);

        if ($browserData === null) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        return new ClientData(
            client: $this->fromArray($browserData, $useragent),
            engine: $browserData->getEngine(),
        );
    }

    /** @throws void */
    private function fromArray(DataClient $data, string $useragent = ''): Browser
    {
        $manufacturer = new Company(type: 'unknown', name: null, brandname: null);

        if ($data->getManufacturer() !== null) {
            try {
                $manufacturer = $this->companyLoader->load($data->getManufacturer());
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        return new Browser(
            name: $data->getName(),
            manufacturer: $manufacturer,
            version: $this->getVersion($data->getVersion(), $useragent),
            type: Type::fromName($data->getType()),
            bits: null,
            modus: null,
        );
    }
}
