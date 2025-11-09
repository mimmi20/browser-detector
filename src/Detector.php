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
use BrowserDetector\Loader\Data\ClientData;
use BrowserDetector\Loader\Data\DeviceData;
use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Parser\Header\Exception\VersionContainsDerivateException;
use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\FireOs;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\LineageOs;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionInterface;
use Override;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaDeviceType\Type;
use UaLoader\BrowserLoaderInterface;
use UaLoader\Data\ClientDataInterface;
use UaLoader\Data\DeviceDataInterface;
use UaLoader\EngineLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaLoader\PlatformLoaderInterface;
use UaRequest\GenericRequestInterface;
use UaRequest\Header\HeaderInterface;
use UaRequest\RequestBuilderInterface;
use UaResult\Bits\Bits;
use UaResult\Browser\Browser;
use UaResult\Company\Company;
use UaResult\Device\Architecture;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function array_filter;
use function array_map;
use function assert;
use function explode;
use function is_array;
use function mb_strtolower;
use function reset;
use function sprintf;
use function str_contains;

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
     * @return array{headers: array<non-empty-string, string>, device: array{architecture: string|null, deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, dualOrientation: bool|null, simCount: int|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, type: string|null, ismobile: bool, istv: bool, bits: int|null}, os: array{name: string|null, marketingName: string|null, version: string|null, manufacturer: string|null}, client: array{name: string|null, version: string|null, manufacturer: string|null, type: string|null, isbot: bool}, engine: array{name: string|null, version: string|null, manufacturer: string|null}}
     *
     * @throws UnexpectedValueException
     */
    private function parse(GenericRequestInterface $request): array
    {
        $engineCodename  = null;
        $filteredHeaders = $request->getHeaders();

        /* detect device */
        $deviceIsMobile = $this->getDeviceIsMobile(filteredHeaders: $filteredHeaders);

        $deviceData = $this->getDeviceData(filteredHeaders: $filteredHeaders);

        $device              = $deviceData->getDevice();
        $deviceMarketingName = $device->getMarketingName();

        /* detect platform */
        $platform = $this->getPlatformData(
            filteredHeaders: $filteredHeaders,
            platformCodenameFromDevice: $deviceData->getOs(),
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
                    && str_contains(mb_strtolower($deviceMarketingName), 'ipad')
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
        $clientData = $this->getClientData(filteredHeaders: $filteredHeaders);

        $client = $clientData->getClient();

        /* detect engine */
        $engine = $this->getEngineData(
            filteredHeaders: $filteredHeaders,
            engineCodename: $engineCodename,
            engineCodenameFromClient: $clientData->getEngine(),
        );

        $architecture = $this->getDeviceArchitecture($filteredHeaders);
        $deviceBits   = $this->getDeviceBitness($filteredHeaders);

        return [
            'headers' => array_map(
                callback: static fn (HeaderInterface $header): string => $header->getValue(),
                array: $request->getHeaders(),
            ),
            'device' => [
                'architecture' => $architecture === Architecture::unknown ? null : $architecture->value,
                'deviceName' => $device->getDeviceName(),
                'marketingName' => $device->getMarketingName(),
                'manufacturer' => $device->getManufacturer()->getType(),
                'brand' => $device->getBrand()->getType(),
                'dualOrientation' => $device->getDualOrientation(),
                'simCount' => $device->getSimCount(),
                'display' => $device->getDisplay()->toArray(),
                'type' => $device->getType()->getType(),
                'ismobile' => $deviceIsMobile ?? $device->getType()->isMobile(),
                'istv' => $device->getType()->isTv(),
                'bits' => $deviceBits === Bits::unknown ? null : $deviceBits->value,
            ],
            'os' => [
                'name' => $platformName,
                'marketingName' => $platformMarketingName,
                'version' => $platform->getVersion()->getVersion(),
                'manufacturer' => $platform->getManufacturer()->getType(),
                'bits' => $deviceBits === Bits::unknown ? null : $deviceBits->value,
            ],
            'client' => [
                'name' => $client->getName(),
                'modus' => null,
                'version' => $client->getVersion()->getVersion(),
                'manufacturer' => $client->getManufacturer()->getType(),
                'type' => $client->getType()->getType(),
                'isbot' => $client->getType()->isBot(),
                'bits' => null,
            ],
            'engine' => [
                'name' => $engine->getName(),
                'version' => $engine->getVersion()->getVersion(),
                'manufacturer' => $engine->getManufacturer()->getType(),
            ],
        ];
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getDeviceArchitecture(array $filteredHeaders): Architecture
    {
        $headersWithDeviceArchitecture = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasDeviceArchitecture(),
        );

        $deviceArchitectureHeader = reset($headersWithDeviceArchitecture);

        if ($deviceArchitectureHeader instanceof HeaderInterface) {
            return $deviceArchitectureHeader->getDeviceArchitecture();
        }

        return Architecture::unknown;
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getDeviceBitness(array $filteredHeaders): Bits
    {
        $headersWithDeviceBitness = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasDeviceBitness(),
        );

        $deviceBitnessHeader = reset($headersWithDeviceBitness);

        if ($deviceBitnessHeader instanceof HeaderInterface) {
            return $deviceBitnessHeader->getDeviceBitness();
        }

        return Bits::unknown;
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
     * @throws void
     */
    private function getEngineVersion(array $filteredHeaders, string | null $engineCodename): VersionInterface
    {
        $headersWithEngineVersion = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasEngineVersion(),
        );

        $engineVersionHeader = reset($headersWithEngineVersion);

        if ($engineVersionHeader instanceof HeaderInterface) {
            return $engineVersionHeader->getEngineVersion($engineCodename);
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

        $engineVersion = $this->getEngineVersion($filteredHeaders, $engineCodename);

        if ($engineCodename !== null) {
            try {
                $engine = $this->engineLoader->load(
                    key: $engineCodename,
                    useragent: $engineHeader instanceof HeaderInterface ? $engineHeader->getValue() : '',
                );

                if ($engineVersion->getVersion() !== null) {
                    return $engine->withVersion($engineVersion);
                }

                return $engine;
            } catch (UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        return new Engine(
            name: null,
            manufacturer: new Company(type: 'unknown', name: null, brandname: null),
            version: $engineVersion,
        );
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getClientVersion(array $filteredHeaders, string | null $clientCodename): VersionInterface
    {
        $headersWithClientVersion = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasClientVersion(),
        );

        $clientVersionHeader = reset($headersWithClientVersion);

        if ($clientVersionHeader instanceof HeaderInterface) {
            return $clientVersionHeader->getClientVersion($clientCodename);
        }

        return new NullVersion();
    }

    /**
     * detect the client data
     *
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getClientData(array $filteredHeaders): ClientDataInterface
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

        $clientVersion = $this->getClientVersion($filteredHeaders, $clientCodename);

        if ($clientCodename !== null) {
            assert($clientHeader instanceof HeaderInterface);

            try {
                $clientData = $this->browserLoader->load(
                    key: $clientCodename,
                    useragent: $clientHeader->getValue(),
                );

                if ($clientVersion->getVersion() !== null) {
                    $client = $clientData->getClient();

                    return new ClientData(
                        client: $client->withVersion($clientVersion),
                        engine: $clientData->getEngine(),
                    );
                }

                return $clientData;
            } catch (UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        return new ClientData(
            client: new Browser(
                name: null,
                manufacturer: new Company(type: 'unknown', name: null, brandname: null),
                version: $clientVersion,
                type: \UaBrowserType\Type::Unknown,
                bits: Bits::unknown,
                modus: null,
            ),
            engine: null,
        );
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws VersionContainsDerivateException
     */
    private function getPlatformVersion(array $filteredHeaders, string | null $platformCodename): VersionInterface
    {
        $headersWithPlatformVersion = array_filter(
            $filteredHeaders,
            static fn (HeaderInterface $header): bool => $header->hasPlatformVersion(),
        );

        $platformHeaderVersion = reset($headersWithPlatformVersion);

        if ($platformHeaderVersion instanceof HeaderInterface) {
            return $platformHeaderVersion->getPlatformVersion($platformCodename);
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

        $platformVersion = match ($platformCodename) {
            'lineageos' => $this->getVersionForLineageOs($filteredHeaders),
            'fire-os' => $this->getVersionForFireOs($filteredHeaders),
            default => $this->getVersionForGeneric(
                $filteredHeaders,
                $platformCodename,
                $platformHeader,
            ),
        };

        if ($platformCodename !== null) {
            try {
                $platform = $this->platformLoader->load(
                    key: $platformCodename,
                    useragent: $platformHeader instanceof HeaderInterface ? $platformHeader->getValue() : '',
                );

                if (
                    $platformVersion instanceof VersionInterface
                    && ($platformVersion instanceof ForcedNullVersion || $platformVersion->getVersion() !== null)
                ) {
                    return $platform->withVersion($platformVersion);
                }

                return $platform;
            } catch (UnexpectedValueException $e) {
                $this->logger->info($e);
            }
        }

        return new Os(
            name: null,
            marketingName: null,
            manufacturer: new Company(type: 'unknown', name: null, brandname: null),
            version: new NullVersion(),
            bits: Bits::unknown,
        );
    }

    /**
     * detect the device data
     *
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getDeviceData(array $filteredHeaders): DeviceDataInterface
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
            } catch (NotFoundException $e) {
                $this->logger->info(
                    new UnexpectedValueException(
                        sprintf('Device "%s" of Manufacturer "%s" was not found', $key, $company),
                        0,
                        $e,
                    ),
                );
            }
        }

        return new DeviceData(
            device: new Device(
                architecture: Architecture::unknown,
                deviceName: null,
                marketingName: null,
                manufacturer: new Company(type: 'unknown', name: null, brandname: null),
                brand: new Company(type: 'unknown', name: null, brandname: null),
                type: Type::Unknown,
                display: new Display(width: null, height: null, touch: null, size: null),
                dualOrientation: null,
                simCount: null,
                bits: Bits::unknown,
            ),
            os: null,
        );
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getVersionForLineageOs(array $filteredHeaders): VersionInterface
    {
        try {
            $androidVersion = $this->getPlatformVersion($filteredHeaders, 'android')->getVersion(
                VersionInterface::IGNORE_MINOR_IF_EMPTY,
            );

            $lineageOsVersion = new LineageOs(new VersionBuilder());

            return $lineageOsVersion->getVersion($androidVersion ?? '');
        } catch (VersionContainsDerivateException | UnexpectedValueException | NotNumericException) {
            // do nothing
        }

        return new NullVersion();
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getVersionForFireOs(array $filteredHeaders): VersionInterface
    {
        try {
            $androidVersion = $this->getPlatformVersion($filteredHeaders, 'android')->getVersion(
                VersionInterface::IGNORE_MINOR_IF_EMPTY,
            );

            $fireOsVersion = new FireOs(new VersionBuilder());

            return $fireOsVersion->getVersion($androidVersion ?? '');
        } catch (VersionContainsDerivateException | UnexpectedValueException | NotNumericException) {
            // do nothing
        }

        return new NullVersion();
    }

    /**
     * @param array<non-empty-string, HeaderInterface> $filteredHeaders
     *
     * @throws void
     */
    private function getVersionForGeneric(
        array $filteredHeaders,
        string | null &$platformCodename,
        HeaderInterface | false $platformHeader,
    ): VersionInterface {
        try {
            return $this->getPlatformVersion($filteredHeaders, $platformCodename);
        } catch (VersionContainsDerivateException $e) {
            $derivate = $e->getDerivate();

            if ($platformHeader instanceof HeaderInterface && $derivate !== '') {
                $derivateCodename = $platformHeader->getPlatformCode($derivate);

                if ($derivateCodename !== null) {
                    $platformCodename = $derivateCodename;
                }
            }
        }

        return new NullVersion();
    }
}
