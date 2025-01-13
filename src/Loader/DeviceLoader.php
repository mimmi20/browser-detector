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

use BrowserDetector\Loader\Data\DeviceData;
use Override;
use Psr\Log\LoggerInterface;
use RuntimeException;
use stdClass;
use UaDeviceType\Type;
use UaDeviceType\TypeLoaderInterface;
use UaDeviceType\Unknown;
use UaLoader\Data\DeviceDataInterface;
use UaLoader\DeviceLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\DeviceInterface;
use UaResult\Device\Display;

use function array_key_exists;
use function assert;
use function is_string;

final readonly class DeviceLoader implements DeviceLoaderInterface
{
    /** @throws RuntimeException */
    public function __construct(
        private LoggerInterface $logger,
        private DataInterface $initData,
        private CompanyLoaderInterface $companyLoader,
    ) {
        $initData();
    }

    /**
     * @throws NotFoundException
     */
    #[Override]
    public function load(string $key): DeviceDataInterface
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the device with key "' . $key . '" was not found');
        }

        $deviceData = $this->initData->getItem($key);

        if ($deviceData === null) {
            throw new NotFoundException('the device with key "' . $key . '" was not found');
        }

        assert($deviceData instanceof stdClass);

        $device = $this->fromArray((array) $deviceData);

        assert(
            is_string($deviceData->platform) || $deviceData->platform === null,
            '"platform" property is required',
        );

        return new DeviceData(
            device: $device,
            os: $deviceData->platform,
        );
    }

    /**
     * @param array<string, (int|stdClass|string|null)> $data
     * @phpstan-param array{deviceName?: (string|null), marketingName?: (string|null), manufacturer?: string, brand?: string, type?: (string|null), display?: (array{width?: (int|null), height?: (int|null), touch?: (bool|null), size?: (int|float|null)}|stdClass|null)} $data
     *
     * @throws void
     */
    private function fromArray(array $data): DeviceInterface
    {
        assert(array_key_exists('deviceName', $data), '"deviceName" property is required');
        assert(array_key_exists('marketingName', $data), '"marketingName" property is required');
        assert(array_key_exists('manufacturer', $data), '"manufacturer" property is required');
        assert(array_key_exists('brand', $data), '"brand" property is required');
        assert(array_key_exists('type', $data), '"type" property is required');
        assert(array_key_exists('display', $data), '"display" property is required');

        $deviceName    = $data['deviceName'] !== null && $data['deviceName'] !== ''
            ? $data['deviceName']
            : null;
        $marketingName = $data['marketingName'] !== null && $data['marketingName'] !== ''
            ? $data['marketingName']
            : null;

        $type = Type::fromName($data['type']);

        $manufacturer = new Company(type: 'unknown', name: null, brandname: null);

        try {
            $manufacturer = $this->companyLoader->load($data['manufacturer']);
        } catch (NotFoundException $e) {
            $this->logger->info($e);
        }

        $brand = new Company(type: 'unknown', name: null, brandname: null);

        try {
            $brand = $this->companyLoader->load($data['brand']);
        } catch (NotFoundException $e) {
            $this->logger->info($e);
        }

        /**
         * @var array<string, (bool|float|int|null)> $displayData
         * @phpstan-var array{width?: int|null, height?: int|null, touch?: bool|null, size?: int|float|null} $displayData
         */
        $displayData = (array) $data['display'];

        assert(array_key_exists('width', $displayData), '"width" property is required');
        assert(array_key_exists('height', $displayData), '"height" property is required');
        assert(array_key_exists('touch', $displayData), '"touch" property is required');
        assert(array_key_exists('size', $displayData), '"size" property is required');

        return new Device(
            deviceName: $deviceName,
            marketingName: $marketingName,
            manufacturer: $manufacturer,
            brand: $brand,
            type: $type,
            display: new Display(
                width: $displayData['width'],
                height: $displayData['height'],
                touch: $displayData['touch'],
                size: $displayData['size'],
            ),
            dualOrientation: $data['dualOrientation'] ?? null,
            simCount: $data['simCount'] ?? null,
        );
    }
}
