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
use BrowserDetector\Version\VersionInterface;
use Override;
use Psr\Log\LoggerInterface;
use RuntimeException;
use UaLoader\Exception\NotFoundException;
use UaLoader\PlatformLoaderInterface;
use UaResult\Bits\Bits;
use UaResult\Company\Company;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function version_compare;

final class PlatformLoader implements PlatformLoaderInterface
{
    use VersionFactoryTrait;

    /**
     * @phpstan-param Data\DataInterface&Data\Os $initData
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
    public function load(string $key, string $useragent = ''): OsInterface
    {
        try {
            $this->initData->init();
        } catch (RuntimeException $e) {
            throw new NotFoundException('the platform with key "' . $key . '" was not found', 0, $e);
        }

        $platformData = $this->initData->getItem($key);

        if ($platformData === null) {
            throw new NotFoundException('the platform with key "' . $key . '" was not found');
        }

        return $this->fromArray($platformData, $useragent);
    }

    /** @throws void */
    private function fromArray(InitData\Os $data, string $useragent): OsInterface
    {
        $name          = $data->getName();
        $marketingName = $data->getMarketingName();
        $manufacturer  = new Company(type: 'unknown', name: null, brandname: null);

        if ($data->getManufacturer() !== null) {
            try {
                $manufacturer = $this->companyLoader->load($data->getManufacturer());
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

        $version = $this->getVersion($data->getVersion(), $useragent);

        try {
            $versionWithoutMicro = $version->getVersion(VersionInterface::IGNORE_MICRO);

            if ($versionWithoutMicro !== null) {
                if ($name === 'Mac OS X' && version_compare($versionWithoutMicro, '10.12', '>=')) {
                    $name          = 'macOS';
                    $marketingName = 'macOS';
                } elseif (
                    $name === 'iOS'
                    && version_compare($versionWithoutMicro, '4.0', '<')
                    && version_compare($versionWithoutMicro, '0.0', '>')
                ) {
                    $name          = 'iPhone OS';
                    $marketingName = 'iPhone OS';
                }
            }
        } catch (UnexpectedValueException $e) {
            $this->logger->info($e);
        }

        return new Os(
            name: $name,
            marketingName: $marketingName,
            manufacturer: $manufacturer,
            version: $version,
            bits: Bits::unknown,
        );
    }
}
