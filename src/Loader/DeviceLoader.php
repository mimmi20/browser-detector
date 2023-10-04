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

namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\DataInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;
use stdClass;
use UaDeviceType\TypeLoaderInterface;
use UaDeviceType\Unknown;

use function array_key_exists;
use function assert;
use function is_string;

final class DeviceLoader implements DeviceLoaderInterface
{
    /** @throws RuntimeException */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly DataInterface $initData,
        private readonly CompanyLoaderInterface $companyLoader,
        private readonly TypeLoaderInterface $typeLoader,
    ) {
        $initData();
    }

    /**
     * @return array<int, (array<mixed>|string|null)>
     * @phpstan-return array{0: array{deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, dualOrientation: bool|null, simCount: int|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, type: string, ismobile: bool, istv: bool}, 1: string|null}
     *
     * @throws NotFoundException
     */
    public function load(string $key): array
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

        assert(is_string($deviceData->platform) || $deviceData->platform === null);

        return [$device, $deviceData->platform];
    }

    /**
     * @param array<string, (int|stdClass|string|null)> $data
     * @phpstan-param array{deviceName?: (string|null), marketingName?: (string|null), manufacturer?: string, brand?: string, type?: (string|null), display?: (array{width?: (int|null), height?: (int|null), touch?: (bool|null), size?: (int|float|null)}|stdClass|null)} $data
     *
     * @return array{deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, dualOrientation: bool|null, simCount: int|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, type: string, ismobile: bool, istv: bool}
     *
     * @throws void
     */
    private function fromArray(array $data): array
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

        $type = new Unknown();

        try {
            $type = $this->typeLoader->load((string) $data['type']);
        } catch (\UaDeviceType\NotFoundException $e) {
            $this->logger->info($e);
        }

        $manufacturer = ['type' => 'unknown'];

        try {
            $manufacturer = $this->companyLoader->load($data['manufacturer']);
        } catch (NotFoundException $e) {
            $this->logger->info($e);
        }

        $brand = ['type' => 'unknown'];

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

        return [
            'deviceName' => $deviceName,
            'marketingName' => $marketingName,
            'manufacturer' => $manufacturer['type'] ?? null,
            'brand' => $brand['type'] ?? null,
            'dualOrientation' => $data['dualOrientation'] ?? null,
            'simCount' => $data['simCount'] ?? null,
            'display' => $displayData,
            'type' => $type->getType(),
            'ismobile' => $type->isMobile(),
            'istv' => $type->isTv(),
        ];
    }
}
