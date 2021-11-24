<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Factory;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use Psr\Log\LoggerInterface;
use stdClass;
use UaDeviceType\TypeLoaderInterface;
use UaDeviceType\Unknown;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\DeviceInterface;

use function array_key_exists;
use function assert;

/**
 * Device detection class
 */
final class DeviceFactory
{
    private const DEVICE_NAME    = 'deviceName';
    private const MARKETING_NAME = 'marketingName';
    private TypeLoaderInterface $typeLoader;

    private CompanyLoaderInterface $companyLoader;

    private DisplayFactoryInterface $displayFactory;

    private LoggerInterface $logger;

    public function __construct(
        CompanyLoaderInterface $companyLoader,
        TypeLoaderInterface $typeLoader,
        DisplayFactoryInterface $displayFactory,
        LoggerInterface $logger
    ) {
        $this->companyLoader  = $companyLoader;
        $this->typeLoader     = $typeLoader;
        $this->displayFactory = $displayFactory;
        $this->logger         = $logger;
    }

    /**
     * @param array<string, (string|stdClass|int|null)> $data
     * @phpstan-param array{deviceName?: (string|null), marketingName?: (string|null), manufacturer?: string, brand?: string, type?: (string|null), display?: (array{width?: (int|null), height?: (int|null), touch?: (bool|null), size?: (int|float|null)}|stdClass|null)} $data
     */
    public function fromArray(array $data, string $useragent): DeviceInterface
    {
        assert(array_key_exists(self::DEVICE_NAME, $data), '"deviceName" property is required');
        assert(array_key_exists(self::MARKETING_NAME, $data), '"marketingName" property is required');
        assert(array_key_exists('manufacturer', $data), '"manufacturer" property is required');
        assert(array_key_exists('brand', $data), '"brand" property is required');
        assert(array_key_exists('type', $data), '"type" property is required');
        assert(array_key_exists('display', $data), '"display" property is required');

        $deviceName    = null !== $data[self::DEVICE_NAME] && '' !== $data[self::DEVICE_NAME] ? $data[self::DEVICE_NAME] : null;
        $marketingName = null !== $data[self::MARKETING_NAME] && '' !== $data[self::MARKETING_NAME] ? $data[self::MARKETING_NAME] : null;

        $type = new Unknown();
        try {
            $type = $this->typeLoader->load((string) $data['type']);
        } catch (\UaDeviceType\NotFoundException $e) {
            $this->logger->info($e);
        }

        try {
            $manufacturer = $this->companyLoader->load($data['manufacturer'], $useragent);
        } catch (NotFoundException $e) {
            $this->logger->info($e);

            $manufacturer = new Company(
                'unknown',
                null,
                null
            );
        }

        try {
            $brand = $this->companyLoader->load($data['brand'], $useragent);
        } catch (NotFoundException $e) {
            $this->logger->info($e);

            $brand = new Company(
                'unknown',
                null,
                null
            );
        }

        /**
         * @var array<string, (int|bool|float|null)> $displayData
         * @phpstan-var array{width?: int|null, height?: int|null, touch?: bool|null, size?: int|float|null} $displayData
         */
        $displayData = (array) $data['display'];
        $display     = $this->displayFactory->fromArray($this->logger, $displayData);

        return new Device($deviceName, $marketingName, $manufacturer, $brand, $type, $display);
    }
}
