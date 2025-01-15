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
use BrowserDetector\Version\VersionBuilderInterface;
use Override;
use Psr\Log\LoggerInterface;
use RuntimeException;
use stdClass;
use UaBrowserType\Type;
use UaLoader\BrowserLoaderInterface;
use UaLoader\Data\ClientDataInterface;
use UaLoader\Exception\NotFoundException;
use UaResult\Browser\Browser;
use UaResult\Company\Company;

use function array_key_exists;
use function assert;
use function is_string;
use function property_exists;

final class BrowserLoader implements BrowserLoaderInterface
{
    use VersionFactoryTrait;

    public const string DATA_PATH = __DIR__ . '/../../data/browsers';

    /** @throws RuntimeException */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly DataInterface $initData,
        private readonly CompanyLoaderInterface $companyLoader,
        VersionBuilderInterface $versionBuilder,
    ) {
        $this->versionBuilder = $versionBuilder;

        $initData();
    }

    /** @throws NotFoundException */
    #[Override]
    public function load(string $key, string $useragent = ''): ClientDataInterface
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        $browserData = $this->initData->getItem($key);

        if ($browserData === null) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        assert($browserData instanceof stdClass);

        assert(
            property_exists($browserData, 'engine') && (is_string(
                $browserData->engine,
            ) || $browserData->engine === null),
            '"engine" property is required',
        );

        return new ClientData(
            client: $this->fromArray((array) $browserData, $useragent),
            engine: $browserData->engine,
        );
    }

    /**
     * @param array{name: string|null, modus: string|null, version: stdClass|string|null, manufacturer: string, bits: int|null, type: string} $data
     *
     * @throws void
     */
    private function fromArray(array $data, string $useragent = ''): Browser
    {
        assert(
            array_key_exists('name', $data) && (is_string($data['name']) || $data['name'] === null),
            '"name" property is required',
        );
        assert(
            array_key_exists('manufacturer', $data)
            && (is_string($data['manufacturer']) || $data['manufacturer'] === null),
            '"manufacturer" property is required',
        );
        assert(
            array_key_exists('version', $data)
            && (
                is_string($data['version'])
                || $data['version'] === null
                || $data['version'] instanceof stdClass
            ),
            '"version" property is required',
        );
        assert(
            array_key_exists('type', $data) && (is_string($data['type']) || $data['type'] === null),
            '"type" property is required',
        );

        $name = $data['name'];
        $type = Type::fromName($data['type']);

        $version      = $this->getVersion($data['version'], $useragent);
        $manufacturer = new Company(type: 'unknown', name: null, brandname: null);

        if ($data['manufacturer'] !== null) {
            try {
                $manufacturer = $this->companyLoader->load($data['manufacturer']);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        return new Browser(
            name: $name,
            manufacturer: $manufacturer,
            version: $version,
            type: $type,
            bits: null,
            modus: null,
        );
    }
}
