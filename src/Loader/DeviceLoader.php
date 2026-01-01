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
use UnexpectedValueException;

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
        $manufacturer     = new Company(type: 'unknown', name: null, brandname: null);
        $manufacturerName = $data->getManufacturer();

        if ($manufacturerName !== null) {
            try {
                $company = \BrowserDetector\Data\Company::fromName($manufacturerName);

                $manufacturerName = $company->getBrandname() ?? 'unknown';
            } catch (UnexpectedValueException) {
                // do nothing
            }

            try {
                $manufacturer = $this->companyLoader->load($manufacturerName);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $brand     = new Company(type: 'unknown', name: null, brandname: null);
        $brandName = $data->getBrand();

        if ($brandName !== null) {
            try {
                $company = \BrowserDetector\Data\Company::fromName($brandName);

                $brandName = $company->getBrandname() ?? 'unknown';
            } catch (UnexpectedValueException) {
                // do nothing
            }

            try {
                $brand = $this->companyLoader->load($brandName);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $deviceType = $data->getType() ?? Type::Unknown;
        $simCount   = $data->getSimCount();

        if (!$deviceType->isPhone()) {
            $simCount = 0;
        } elseif ($simCount === null) {
            $simCount = 1;
        }

        $displayData          = $data->getDisplay();
        $displayData['touch'] = $deviceType->hasTouch();

        return new Device(
            architecture: $data->getArchitecture(),
            deviceName: $data->getDeviceName(),
            marketingName: $data->getMarketingName(),
            manufacturer: $manufacturer,
            brand: $brand,
            type: $deviceType,
            display: new Display(
                width: $displayData['width'],
                height: $displayData['height'],
                touch: $displayData['touch'],
                size: $displayData['size'],
            ),
            dualOrientation: $data->getDualOrientation(),
            simCount: $simCount,
            bits: $data->getBits(),
        );
    }
}
