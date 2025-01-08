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

namespace BrowserDetector;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use Override;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaBrowserType\Unknown;
use UaLoader\BrowserLoaderInterface;
use UaLoader\EngineLoaderInterface;
use UaLoader\PlatformLoaderInterface;
use UaRequest\GenericRequestInterface;
use UaRequest\Header\HeaderInterface;
use UaRequest\RequestBuilderInterface;
use UaResult\Browser\Browser;
use UaResult\Browser\BrowserInterface;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\DeviceInterface;
use UaResult\Device\Display;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function array_filter;
use function assert;
use function explode;
use function is_array;
use function is_string;
use function mb_strpos;
use function mb_strtolower;
use function mb_substr;
use function reset;
use function sprintf;
use function str_contains;
use function str_starts_with;
use function trim;

final readonly class Detector implements DetectorInterface
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
        private LoggerInterface $logger,
        private CacheInterface $cache,
        private RequestBuilderInterface $requestBuilder,
        private DeviceLoaderFactoryInterface $deviceLoaderFactory,
        private PlatformLoaderInterface $platformLoader,
        private BrowserLoaderInterface $browserLoader,
        private EngineLoaderInterface $engineLoader,
        private VersionBuilderFactoryInterface $versionBuilderFactory,
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
    #[Override]
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
     * @throws UnexpectedValueException
     */
    private function parse(GenericRequestInterface $request): array
    {
        $engineCodename  = null;
        $filteredHeaders = $request->getFilteredHeaders();

        /* detect device */
        $deviceIsMobile = $this->getDeviceIsMobile(filteredHeaders: $filteredHeaders);

        ['device' => $device, 'os' => $platformCodenameFromDevice] = $this->getDeviceData(
            filteredHeaders: $filteredHeaders,
        );

        $deviceMarketingName = $device->getMarketingName();

        /* detect platform */
        $platform = $this->getPlatformData(
            filteredHeaders: $filteredHeaders,
            platformCodenameFromDevice: $platformCodenameFromDevice,
        );

        $platformName          = $platform->getName();
        $platformMarketingName = $platform->getMarketingName();

        if (mb_strtolower($platformName ?? '') === 'ios') {
            $engineCodename = 'webkit';

            try {
                $version    = $platform->getVersion();
                $iosVersion = $version->getVersion(VersionInterface::IGNORE_MINOR);

                if (
                    $deviceMarketingName !== null
                    && str_starts_with(mb_strtolower($deviceMarketingName), 'ipad')
                    && $iosVersion >= 13
                ) {
                    $platformName          = 'iPadOS';
                    $platformMarketingName = 'iPadOS';
                }
            } catch (UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        /* detect client */
        ['client' => $client, 'engine' => $engineCodenameFromClient] = $this->getClientData(
            filteredHeaders: $filteredHeaders,
        );

        /* detect engine */
        $engine = $this->getEngineData(
            filteredHeaders: $filteredHeaders,
            engineCodename: $engineCodename,
            engineCodenameFromClient: $engineCodenameFromClient,
        );

        return [
            'headers' => $request->getHeaders(),
            'device' => [
                'architecture' => $this->getDeviceArchitecture($filteredHeaders),
                'deviceName' => $device->getDeviceName(),
                'marketingName' => $device->getMarketingName(),
                'manufacturer' => $device->getManufacturer()->getType(),
                'brand' => $device->getBrand()->getType(),
                'dualOrientation' => $device->getDualOrientation(),
                'simCount' => $device->getSimCount(),
                'display' => $device->getDisplay()?->toArray() ?? ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
                'type' => $device->getType()->getType(),
                'ismobile' => $deviceIsMobile ?? $device->getType()->isMobile(),
                'istv' => $device->getType()->isTv(),
                'bits' => $this->getDeviceBitness($filteredHeaders),
            ],
            'os' => [
                'name' => $platformName,
                'marketingName' => $platformMarketingName,
                'version' => $platform->getVersion()->getVersion(),
                'manufacturer' => $platform->getManufacturer()->getType(),
            ],
            'client' => [
                'name' => $client->getName(),
                'version' => $client->getVersion()->getVersion(),
                'manufacturer' => $client->getManufacturer()->getType(),
                'type' => $client->getType()->getType(),
                'isbot' => $client->getType()->isBot(),
            ],
            'engine' => [
                'name' => $engine->getName(),
                'version' => $engine->getVersion()->getVersion(),
                'manufacturer' => $engine->getManufacturer()->getType(),
            ],
        ];
    }

    /** @throws NotNumericException */
    private function getVersion(string | null $inputVersion): VersionInterface
    {
        $versionBuilder = ($this->versionBuilderFactory)();

        return $versionBuilder->set($inputVersion ?? '');
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
     */
    private function getEngineVersion(array $filteredHeaders, string | null $engineCodename): VersionInterface
    {
        $headersWithEngineVersion = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasEngineVersion(),
        );

        $engineVersionHeader = reset($headersWithEngineVersion);

        if ($engineVersionHeader instanceof HeaderInterface) {
            return $this->getVersion($engineVersionHeader->getEngineVersion($engineCodename));
        }

        return new NullVersion();
    }

    /**
     * detect the engine data
     *
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getEngineData(
        array $filteredHeaders,
        string | null $engineCodename,
        string | null $engineCodenameFromClient,
    ): EngineInterface {
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
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        if ($engineCodename !== null) {
            try {
                $engine = $this->engineLoader->load(
                    key: $engineCodename,
                    useragent: $engineHeader instanceof HeaderInterface ? $engineHeader->getValue() : '',
                );

                if ($engineVersion !== null) {
                    return new Engine(
                        name: $engine->getName(),
                        manufacturer: $engine->getManufacturer(),
                        version: $engineVersion,
                    );
                }

                return $engine;
            } catch (UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        return new Engine(
            name: null,
            manufacturer: new Company(type: 'unknown', name: null, brandname: null),
            version: $engineVersion ?? new NullVersion(),
        );
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws NotNumericException
     */
    private function getClientVersion(array $filteredHeaders, string | null $clientCodename): VersionInterface
    {
        $headersWithClientVersion = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasClientVersion(),
        );

        $clientVersionHeader = reset($headersWithClientVersion);

        if ($clientVersionHeader instanceof HeaderInterface) {
            return $this->getVersion($clientVersionHeader->getClientVersion($clientCodename));
        }

        return new NullVersion();
    }

    /**
     * detect the client data
     *
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @return array{client: BrowserInterface, engine: string|null}
     *
     * @throws void
     */
    private function getClientData(array $filteredHeaders): array
    {
        $clientCodename = null;
        $clientVersion  = new NullVersion();

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
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        if ($clientCodename !== null) {
            assert($clientHeader instanceof HeaderInterface);

            try {
                ['client' => $client, 'engine' => $engine] = $this->browserLoader->load(
                    key: $clientCodename,
                    useragent: $clientHeader->getValue(),
                );

                if ($clientVersion->getVersion() !== null) {
                    return [
                        'client' => new Browser(
                            name: $client->getName(),
                            manufacturer: $client->getManufacturer(),
                            version: $clientVersion,
                            type: $client->getType(),
                            bits: $client->getBits(),
                            modus: $client->getModus(),
                        ),
                        'engine' => $engine,
                    ];
                }

                return ['client' => $client, 'engine' => $engine];
            } catch (UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        return [
            'client' => new Browser(
                name: null,
                manufacturer: new Company(type: 'unknown', name: null, brandname: null),
                version: $clientVersion,
                type: new Unknown(),
                bits: null,
                modus: null,
),
            'engine' => null,
        ];
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws NotNumericException
     */
    private function getPlatformVersion(
        array $filteredHeaders,
        string | null $platformCodename,
    ): VersionInterface | string {
        $headersWithPlatformVersion = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasPlatformVersion(),
        );

        $platformHeaderVerion = reset($headersWithPlatformVersion);

        if ($platformHeaderVerion instanceof HeaderInterface) {
            $platformVersion = $platformHeaderVerion->getPlatformVersion($platformCodename);

            if ($platformVersion !== null && str_contains($platformVersion, ';')) {
                return $platformVersion;
            }

            return $this->getVersion($platformVersion);
        }

        return new NullVersion();
    }

    /**
     * detect the platform data
     *
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getPlatformData(array $filteredHeaders, string | null $platformCodenameFromDevice): OsInterface
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
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        if (is_string($platformVersion)) {
            $derivatePosition = mb_strpos($platformVersion, ';');

            if ($derivatePosition !== false) {
                // the platform contains information about a derivate of the platform
                $derivate        = trim(mb_substr($platformVersion, $derivatePosition + 1));
                $platformVersion = null;

                if ($platformHeader instanceof HeaderInterface) {
                    $derivateCodename = $platformHeader->getPlatformCode($derivate);

                    if ($derivateCodename !== null) {
                        $platformCodename = $derivateCodename;
                    }
                }
            }
        }

        if ($platformCodename !== null) {
            try {
                $platform = $this->platformLoader->load(
                    key: $platformCodename,
                    useragent: $platformHeader instanceof HeaderInterface ? $platformHeader->getValue() : '',
                );

                if (
                    $platformVersion instanceof VersionInterface
                    && $platformVersion->getVersion() !== null
                ) {
                    return new Os(
                        name: $platform->getName(),
                        marketingName: $platform->getMarketingName(),
                        manufacturer: $platform->getManufacturer(),
                        version: $platformVersion,
                        bits: $platform->getBits(),
                    );
                }

                return $platform;
            } catch (UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        if (is_string($platformVersion)) {
            try {
                $platformVersion = (new VersionBuilder())->set($platformVersion);
            } catch (NotNumericException $e) {
                $this->logger->info($e);

                $platformVersion = null;
            }
        }

        if (!$platformVersion instanceof VersionInterface) {
            $platformVersion = null;
        }

        return new Os(
            name: null,
            marketingName: null,
            manufacturer: new Company(type: 'unknown', name: null, brandname: null),
            version: $platformVersion ?? new NullVersion(),
        );
    }

    /**
     * detect the device data
     *
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @return array{device: DeviceInterface, os: string|null}
     *
     * @throws void
     */
    private function getDeviceData(array $filteredHeaders): array
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

                return $deviceLoader->load($key);
            } catch (UnexpectedValueException $e) {
                $this->logger->info(
                    new UnexpectedValueException(
                        sprintf('Device %s of Manufacturer %s was not found', $key, $company),
                        0,
                        $e,
                    ),
                );
            }
        }

        return [
            'device' => new Device(
                deviceName: null,
                marketingName: null,
                manufacturer: new Company(type: 'unknown', name: null, brandname: null),
                brand: new Company(type: 'unknown', name: null, brandname: null),
                type: new \UaDeviceType\Unknown(),
                display: new Display(width: null, height: null, touch: null, size: null),
                dualOrientation: null,
                simCount: null,
            ),
            'os' => null,
        ];
    }
}
