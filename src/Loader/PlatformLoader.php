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

use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionInterface;
use Override;
use Psr\Log\LoggerInterface;
use RuntimeException;
use stdClass;
use UaLoader\PlatformLoaderInterface;
use UnexpectedValueException;

use function array_key_exists;
use function assert;
use function version_compare;

final class PlatformLoader implements PlatformLoaderInterface
{
    use VersionFactoryTrait;

    public const string DATA_PATH = __DIR__ . '/../../data/platforms';

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

    /**
     * @return array{name: string|null, marketingName: string|null, version: string|null, manufacturer: string}
     *
     * @throws NotFoundException
     */
    #[Override]
    public function load(string $key, string $useragent = ''): array
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the platform with key "' . $key . '" was not found');
        }

        $platformData = $this->initData->getItem($key);

        if ($platformData === null) {
            throw new NotFoundException('the platform with key "' . $key . '" was not found');
        }

        assert($platformData instanceof stdClass);

        return $this->fromArray((array) $platformData, $useragent);
    }

    /**
     * @param array<string, (int|stdClass|string|null)> $data
     * @phpstan-param array{name?: string|null, marketingName?: string|null, manufacturer?: string, version?: stdClass|string|null} $data
     *
     * @return array{name: string|null, marketingName: string|null, version: string|null, manufacturer: string}
     *
     * @throws void
     */
    private function fromArray(array $data, string $useragent): array
    {
        assert(array_key_exists('name', $data), '"name" property is required');
        assert(array_key_exists('marketingName', $data), '"marketingName" property is required');
        assert(array_key_exists('manufacturer', $data), '"manufacturer" property is required');
        assert(array_key_exists('version', $data), '"version" property is required');

        $name          = $data['name'];
        $marketingName = $data['marketingName'];
        $manufacturer  = ['type' => 'unknown'];

        try {
            $manufacturer = $this->companyLoader->load($data['manufacturer']);
        } catch (NotFoundException $e) {
            $this->logger->info($e);
        }

        $version = $this->getVersion($data['version'], $useragent, $this->logger);

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

            $versionString = $version->getVersion();
        } catch (UnexpectedValueException $e) {
            $this->logger->info($e);

            $versionString = null;
        }

        return [
            'name' => $name,
            'marketingName' => $marketingName,
            'version' => $versionString,
            'manufacturer' => $manufacturer['type'],
        ];
    }
}
