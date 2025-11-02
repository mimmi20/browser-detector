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
use UaDeviceType\Type;
use UaLoader\Data\DeviceDataInterface;
use UaLoader\DeviceLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\DeviceInterface;
use UaResult\Device\Display;

final readonly class DeviceLoader implements DeviceLoaderInterface
{
    /**
     * @phpstan-param Data\DataInterface&Data\Device $initData
     *
     * @throws void
     */
    public function __construct(
        private LoggerInterface $logger,
        private Data\DataInterface $initData,
        private CompanyLoaderInterface $companyLoader,
    ) {
        // nothing to do
    }

    /** @throws NotFoundException */
    #[Override]
    public function load(string $key): DeviceDataInterface
    {
        try {
            $this->initData->init();
        } catch (RuntimeException $e) {
            throw new NotFoundException('the device with key "' . $key . '" was not found', 0, $e);
        }

        $deviceData = $this->initData->getItem($key);

        if ($deviceData === null) {
            throw new NotFoundException('the device with key "' . $key . '" was not found');
        }

        $device = $this->fromArray($deviceData);

        return new DeviceData(device: $device, os: $deviceData->getPlatform());
    }

    /** @throws void */
    private function fromArray(InitData\Device $data): DeviceInterface
    {
        $manufacturer = new Company(type: 'unknown', name: null, brandname: null);

        if ($data->getManufacturer() !== null) {
            try {
                $manufacturer = $this->companyLoader->load($data->getManufacturer());
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $brand = new Company(type: 'unknown', name: null, brandname: null);

        if ($data->getBrand() !== null) {
            try {
                $brand = $this->companyLoader->load($data->getBrand());
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        return new Device(
            architecture: $data->getArchitecture(),
            deviceName: $data->getDeviceName(),
            marketingName: $data->getMarketingName(),
            manufacturer: $manufacturer,
            brand: $brand,
            type: $data->getType() ?? Type::Unknown,
            display: new Display(
                width: $data->getDisplay()['width'],
                height: $data->getDisplay()['height'],
                touch: $data->getDisplay()['touch'],
                size: $data->getDisplay()['size'],
            ),
            dualOrientation: $data->getDualOrientation(),
            simCount: $data->getSimCount(),
            bits: $data->getBits(),
        );
    }
}
