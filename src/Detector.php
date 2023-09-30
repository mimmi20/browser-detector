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

namespace BrowserDetector;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Header\HeaderInterface;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UnexpectedValueException;

use function array_filter;
use function assert;
use function explode;
use function in_array;
use function is_array;
use function mb_strtolower;
use function reset;
use function str_starts_with;

final class Detector implements DetectorInterface
{
    /**
     * sets the cache used to make the detection faster
     *
     * @throws void
     */
    public function __construct(
        /**
         * an logger instance
         */
        private readonly LoggerInterface $logger,
        private readonly CacheInterface $cache,
        private readonly RequestBuilderInterface $requestBuilder,
        private readonly DeviceLoaderFactoryInterface $deviceLoaderFactory,
        private readonly PlatformLoaderInterface $platformLoader,
        private readonly BrowserLoaderInterface $browserLoader,
        private readonly EngineLoaderInterface $engineLoader,
    ) {
        // nothing to do
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param array<non-empty-string, non-empty-string>|GenericRequestInterface|MessageInterface|string $headers
     *
     * @return array<mixed>
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function getBrowser(array | GenericRequestInterface | MessageInterface | string $headers): array
    {
        $request = $this->requestBuilder->buildRequest($headers);
        $cacheId = $request->getHash();

        if ($this->cache->hasItem($cacheId)) {
            $item = $this->cache->getItem($cacheId);
            assert(is_array($item));

            return $item;
        }

        $item = $this->parse($request);

        $this->cache->setItem($cacheId, $item);

        return $item;
    }

    /**
     * @return array{headers: array<non-empty-string, non-empty-string>, device: array{architecture: string|null, deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, dualOrientation: bool|null, simCount: int|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, type: string|null, ismobile: bool, istv: bool, bits: int|null}, os: array{name: string|null, marketingName: string|null, version: string|null, manufacturer: string|null}, client: array{name: string|null, version: string|null, manufacturer: string|null, type: string|null, isbot: bool}, engine: array{name: string|null, version: string|null, manufacturer: string|null}}
     *
     * @throws void
     */
    private function parse(GenericRequestInterface $request): array
    {
        $engineCodename  = null;
        $filteredHeaders = $request->getFilteredHeaders();

        /* detect device */
        $deviceIsMobile = $this->getDeviceIsMobile($filteredHeaders);

        [$deviceName, $deviceMarketingName, $deviceManufacturer, $brand, $dualOrientation, $simCount, $display, $deviceType, $deviceIsMobileFromDevice, $deviceIsTv, $platformCodenameFromDevice] = $this->getDeviceData(
            filteredHeaders: $filteredHeaders,
            deviceIsMobile: $deviceIsMobile,
        );

        /* detect platform */
        [$platformName, $platformMarketingName, $platformManufacturer, $platformVersion] = $this->getPlatformData(
            filteredHeaders: $filteredHeaders,
            platformCodenameFromDevice: $platformCodenameFromDevice,
        );

        if (in_array(mb_strtolower($platformName ?? ''), ['ios'], true)) {
            $engineCodename = 'webkit';

            $versionBuilder = new VersionBuilder($this->logger);

            try {
                $version    = $versionBuilder->set((string) $platformVersion);
                $iosVersion = (int) $version->getVersion(VersionInterface::IGNORE_MINOR);

                if (
                    $deviceMarketingName !== null
                    && str_starts_with(mb_strtolower($deviceMarketingName), 'ipad')
                    && $iosVersion >= 13
                ) {
                    $platformName          = 'iPadOS';
                    $platformMarketingName = 'iPadOS';
                }
            } catch (NotNumericException | UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        /* detect client */
        [$clientName, $clientVersion, $clientManufacturer, $clientType, $isBot, $engineCodenameFromClient] = $this->getClientData(
            filteredHeaders: $filteredHeaders,
        );

        /* detect engine */
        [$engineName, $engineVersion, $engineManufaturer] = $this->getEngineData(
            filteredHeaders: $filteredHeaders,
            engineCodename: $engineCodename,
            engineCodenameFromClient: $engineCodenameFromClient,
        );

        return [
            'headers' => $request->getHeaders(),
            'device' => [
                'architecture' => $this->getDeviceArchitecture($filteredHeaders),
                'deviceName' => $deviceName,
                'marketingName' => $deviceMarketingName,
                'manufacturer' => $deviceManufacturer,
                'brand' => $brand,
                'dualOrientation' => $dualOrientation,
                'simCount' => $simCount,
                'display' => $display,
                'type' => $deviceType,
                'ismobile' => $deviceIsMobile ?? $deviceIsMobileFromDevice,
                'istv' => $deviceIsTv,
                'bits' => $this->getDeviceBitness($filteredHeaders),
            ],
            'os' => [
                'name' => $platformName,
                'marketingName' => $platformMarketingName,
                'version' => $platformVersion,
                'manufacturer' => $platformManufacturer,
            ],
            'client' => [
                'name' => $clientName,
                'version' => $clientVersion,
                'manufacturer' => $clientManufacturer,
                'type' => $clientType,
                'isbot' => $isBot,
            ],
            'engine' => [
                'name' => $engineName,
                'version' => $engineVersion,
                'manufacturer' => $engineManufaturer,
            ],
        ];
    }

    /**
     * @throws NotNumericException
     * @throws UnexpectedValueException
     */
    private function getVersion(string | null $inputVersion): string | null
    {
        $versionBuilder = new VersionBuilder($this->logger);
        $version        = $versionBuilder->set($inputVersion ?? '');

        return $version->getVersion();
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getDeviceArchitecture(array $filteredHeaders): string | null
    {
        $headersWithDeviceArchitecture = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasDeviceArchitecture(),
        );

        $deviceArchitectureHeader = reset($headersWithDeviceArchitecture);

        if ($deviceArchitectureHeader instanceof HeaderInterface) {
            return $deviceArchitectureHeader->getDeviceArchitecture();
        }

        return null;
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getDeviceBitness(array $filteredHeaders): int | null
    {
        $headersWithDeviceBitness = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasDeviceBitness(),
        );

        $deviceBitnessHeader = reset($headersWithDeviceBitness);

        if ($deviceBitnessHeader instanceof HeaderInterface) {
            return $deviceBitnessHeader->getDeviceBitness();
        }

        return null;
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getDeviceIsMobile(array $filteredHeaders): bool | null
    {
        $headersWithDeviceMobile = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasDeviceIsMobile(),
        );

        $deviceMobileHeader = reset($headersWithDeviceMobile);

        if ($deviceMobileHeader instanceof HeaderInterface) {
            return $deviceMobileHeader->getDeviceIsMobile();
        }

        return null;
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws NotNumericException
     * @throws UnexpectedValueException
     */
    private function getEngineVersion(array $filteredHeaders, string | null $engineCodename): string | null
    {
        $headersWithEngineVersion = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasEngineVersion(),
        );

        $engineVersionHeader = reset($headersWithEngineVersion);

        if ($engineVersionHeader instanceof HeaderInterface) {
            return $this->getVersion($engineVersionHeader->getEngineVersion($engineCodename));
        }

        return null;
    }

    /**
     * detect the engine data
     *
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @return array{0: string|null, 1: string|null, 2: string|null}
     *
     * @throws void
     */
    private function getEngineData(
        array $filteredHeaders,
        string | null $engineCodename,
        string | null $engineCodenameFromClient,
    ): array {
        $engineHeader  = null;
        $engineVersion = null;

        if ($engineCodename === null) {
            $headersWithEngineName = array_filter(
                $filteredHeaders,
                static fn (HeaderInterface $header): bool => $header->hasEngineCode(),
            );

            $engineHeader = reset($headersWithEngineName);

            if ($engineHeader instanceof HeaderInterface) {
                $engineCodename = $engineHeader->getEngineCode();
            }
        }

        if ($engineCodename === null) {
            $engineCodename = $engineCodenameFromClient;
        }

        try {
            $engineVersion = $this->getEngineVersion($filteredHeaders, $engineCodename);
        } catch (NotNumericException | UnexpectedValueException $e) {
            $this->logger->info($e);
        }

        if ($engineCodename !== null) {
            try {
                $engine = $this->engineLoader->load(
                    key: $engineCodename,
                    useragent: $engineHeader instanceof HeaderInterface ? $engineHeader->getValue() : '',
                );

                return [$engine['name'], $engineVersion ?? $engine['version'], $engine['manufacturer']];
            } catch (UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        return [null, $engineVersion, null];
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws NotNumericException
     * @throws UnexpectedValueException
     */
    private function getClientVersion(array $filteredHeaders, string | null $clientCodename): string | null
    {
        $headersWithClientVersion = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasClientVersion(),
        );

        $clientVersionHeader = reset($headersWithClientVersion);

        if ($clientVersionHeader instanceof HeaderInterface) {
            return $this->getVersion($clientVersionHeader->getClientVersion($clientCodename));
        }

        return null;
    }

    /**
     * detect the client data
     *
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @return array{0: string|null, 1: string|null, 2: string|null, 3: string|null, 4: bool, 5: string|null}
     *
     * @throws void
     */
    private function getClientData(array $filteredHeaders): array
    {
        $clientCodename = null;
        $clientVersion  = null;

        $headersWithClientCode = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasClientCode(),
        );

        $clientHeader = reset($headersWithClientCode);

        if ($clientHeader instanceof HeaderInterface) {
            $clientCodename = $clientHeader->getClientCode();
        }

        try {
            $clientVersion = $this->getClientVersion($filteredHeaders, $clientCodename);
        } catch (NotNumericException | UnexpectedValueException $e) {
            $this->logger->info($e);
        }

        if ($clientCodename !== null) {
            try {
                [$client, $engineCodenameFromClient] = $this->browserLoader->load(
                    key: $clientCodename,
                    useragent: $clientHeader instanceof HeaderInterface ? $clientHeader->getValue() : '',
                );

                return [
                    $client['name'],
                    $clientVersion ?? $client['version'],
                    $client['manufacturer'],
                    $client['type'],
                    $client['isbot'],
                    $engineCodenameFromClient,
                ];
            } catch (UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        return [null, $clientVersion, null, null, false, null];
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws NotNumericException
     * @throws UnexpectedValueException
     */
    private function getPlatformVersion(array $filteredHeaders, string | null $platformCodename): string | null
    {
        $headersWithPlatformVersion = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasPlatformVersion(),
        );

        $platformHeaderVerion = reset($headersWithPlatformVersion);

        if ($platformHeaderVerion instanceof HeaderInterface) {
            return $this->getVersion(
                $platformHeaderVerion->getPlatformVersion($platformCodename),
            );
        }

        return null;
    }

    /**
     * detect the platform data
     *
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @return array{0: string|null, 1: string|null, 2: string|null, 3: string|null}
     *
     * @throws void
     */
    private function getPlatformData(array $filteredHeaders, string | null $platformCodenameFromDevice): array
    {
        $platformCodename = null;
        $platformVersion  = null;

        $headersWithPlatformCode = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasPlatformCode(),
        );

        $platformHeader = reset($headersWithPlatformCode);

        if ($platformHeader instanceof HeaderInterface) {
            $platformCodename = $platformHeader->getPlatformCode();
        }

        if ($platformCodename === null) {
            $platformCodename = $platformCodenameFromDevice;
        }

        try {
            $platformVersion = $this->getPlatformVersion($filteredHeaders, $platformCodename);
        } catch (NotNumericException | UnexpectedValueException $e) {
            $this->logger->info($e);
        }

        if ($platformCodename !== null) {
            try {
                $platform = $this->platformLoader->load(
                    key: $platformCodename,
                    useragent: $platformHeader instanceof HeaderInterface ? $platformHeader->getValue() : '',
                );

                return [
                    $platform['name'],
                    $platform['marketingName'],
                    $platform['manufacturer'],
                    $platformVersion ?? $platform['version'],
                ];
            } catch (UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        return [null, null, null, $platformVersion];
    }

    /**
     * detect the device data
     *
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @return array{0: string|null, 1: string|null, 2: string|null, 3: string|null, 4: bool|null, 5: int|null, 6: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, 7: string|null, 8: bool, 9: bool, 10: string|null}
     *
     * @throws void
     */
    private function getDeviceData(array $filteredHeaders, bool | null $deviceIsMobile): array
    {
        $headersWithDeviceCode = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasDeviceCode(),
        );

        $deviceHeader   = reset($headersWithDeviceCode);
        $deviceCodename = null;

        if ($deviceHeader instanceof HeaderInterface) {
            $deviceCodename = $deviceHeader->getDeviceCode();
        }

        if ($deviceCodename !== null) {
            [$company, $key] = explode('=', $deviceCodename, 2);

            try {
                $deviceLoader = ($this->deviceLoaderFactory)($company);

                [$device, $platformCodenameFromDevice] = $deviceLoader->load($key);

                return [
                    $device['deviceName'],
                    $device['marketingName'],
                    $device['manufacturer'],
                    $device['brand'],
                    $device['dualOrientation'],
                    $device['simCount'],
                    [
                        'width' => $device['display']['width'] ?? null,
                        'height' => $device['display']['height'] ?? null,
                        'touch' => $device['display']['touch'] ?? null,
                        'size' => $device['display']['size'] ?? null,
                    ],
                    $device['type'],
                    $deviceIsMobile ?? $device['ismobile'],
                    $device['istv'],
                    $platformCodenameFromDevice,
                ];
            } catch (UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        return [
            null,
            null,
            null,
            null,
            false,
            null,
            [
                'width' => null,
                'height' => null,
                'touch' => null,
                'size' => null,
            ],
            null,
            false,
            false,
            null,
        ];
    }
}
