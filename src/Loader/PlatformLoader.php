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
    public function load(string $key, string $useragent = ''): OsInterface
    {
        try {
            $os = \BrowserDetector\Data\Os::fromName($key);
        } catch (UnexpectedValueException) {
            $os = \BrowserDetector\Data\Os::unknown;
        }

        $name          = $os->getName();
        $marketingName = $os->getMarketingName();
        $manufacturer  = new Company(type: 'unknown', name: null, brandname: null);
        $version       = $this->getVersion((object) $os->getVersion(), $useragent);

        if ($os->getManufacturer()->getBrandname() !== null) {
            try {
                $manufacturer = $this->companyLoader->load($os->getManufacturer()->getBrandname());
            } catch (NotFoundException $e) {
                $this->logger->info($e);
            }
        }

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
