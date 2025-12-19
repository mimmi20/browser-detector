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

namespace BrowserDetector\Collection;

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
use Psr\Log\LoggerInterface;
use UaDeviceType\Type;
use UaLoader\BrowserLoaderInterface;
use UaLoader\Data\ClientDataInterface;
use UaLoader\Data\DeviceDataInterface;
use UaLoader\EngineLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaLoader\PlatformLoaderInterface;
use UaRequest\GenericRequestInterface;
use UaRequest\Header\HeaderInterface;
use UaResult\Bits\Bits;
use UaResult\Browser\Browser;
use UaResult\Company\Company;
use UaResult\Device\Architecture;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UaResult\Device\FormFactor;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function array_filter;
use function assert;
use function explode;
use function reset;
use function sprintf;

final readonly class Headers
{
    /** @var array<non-empty-string, HeaderInterface> */
    private array $headers;

    /** @throws void */
    public function __construct(
        GenericRequestInterface $request,
        private LoggerInterface $logger,
        private DeviceLoaderFactoryInterface $deviceLoaderFactory,
        private PlatformLoaderInterface $platformLoader,
        private BrowserLoaderInterface $browserLoader,
        private EngineLoaderInterface $engineLoader,
    ) {
        $this->headers = $request->getHeaders();
    }

    /** @throws void */
    public function getDeviceArchitecture(): Architecture
    {
        $headersWithDeviceArchitecture = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasDeviceArchitecture(),
        );

        $deviceArchitectureHeader = reset($headersWithDeviceArchitecture);

        if ($deviceArchitectureHeader instanceof HeaderInterface) {
            return $deviceArchitectureHeader->getDeviceArchitecture();
        }

        return Architecture::unknown;
    }

    /** @throws void */
    public function getDeviceFormFactor(): FormFactor
    {
        $headersWithDeviceFormFactors = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasDeviceFormFactor(),
        );

        $deviceFormFactorsHeader = reset($headersWithDeviceFormFactors);

        if ($deviceFormFactorsHeader instanceof HeaderInterface) {
            return array_last(
                $deviceFormFactorsHeader->getDeviceFormFactor(),
            ) ?? FormFactor::unknown;
        }

        return FormFactor::unknown;
    }

    /** @throws void */
    public function getDeviceBitness(): Bits
    {
        $headersWithDeviceBitness = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasDeviceBitness(),
        );

        $deviceBitnessHeader = reset($headersWithDeviceBitness);

        if ($deviceBitnessHeader instanceof HeaderInterface) {
            return $deviceBitnessHeader->getDeviceBitness();
        }

        return Bits::unknown;
    }

    /** @throws void */
    public function getDeviceIsMobile(): bool | null
    {
        $headersWithDeviceMobile = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasDeviceIsMobile(),
        );

        $deviceMobileHeader = reset($headersWithDeviceMobile);

        if ($deviceMobileHeader instanceof HeaderInterface) {
            return $deviceMobileHeader->getDeviceIsMobile();
        }

        return null;
    }

    /**
     * detect the engine data
     *
     * @throws void
     */
    public function getEngineData(
        \UaData\EngineInterface $engine,
        string | null $engineCodenameFromClient,
    ): EngineInterface {
        $engineHeader = null;

        if ($engine === \BrowserDetector\Data\Engine::unknown) {
            $headersWithEngineName = array_filter(
                $this->headers,
                static fn (HeaderInterface $header): bool => $header->hasEngineCode(),
            );

            $engineHeader = reset($headersWithEngineName);

            if ($engineHeader instanceof HeaderInterface) {
                try {
                    $engine = $engineHeader->getEngineCode();
                } catch (\UaRequest\Exception\NotFoundException) {
                    // do nothing
                }
            }
        }

        if ($engine === \BrowserDetector\Data\Engine::unknown) {
            try {
                $engine = \BrowserDetector\Data\Engine::fromName((string) $engineCodenameFromClient);
            } catch (UnexpectedValueException) {
                // do nothing
            }
        }

        $engineVersion = $this->getEngineVersion($engine);

        if ($engine !== \BrowserDetector\Data\Engine::unknown) {
            try {
                $engineFrom = $this->engineLoader->loadFromEngine(
                    engine: $engine,
                    useragent: $engineHeader instanceof HeaderInterface ? $engineHeader->getValue() : '',
                );

                if ($engineVersion->getVersion() !== null) {
                    return $engineFrom->withVersion($engineVersion);
                }

                return $engineFrom;
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
     * detect the client data
     *
     * @throws void
     */
    public function getClientData(): ClientDataInterface
    {
        $clientCodename = null;
        $clientVersion  = new NullVersion();

        $headersWithClientCode = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasClientCode(),
        );

        $clientHeader = reset($headersWithClientCode);

        if ($clientHeader instanceof HeaderInterface) {
            $clientCodename = $clientHeader->getClientCode();
        }

        $clientVersion = $this->getClientVersion($clientCodename);

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
            ),
            engine: null,
        );
    }

    /**
     * detect the platform data
     *
     * @throws void
     */
    public function getPlatformData(string | null $platformCodenameFromDevice): OsInterface
    {
        $platform = \BrowserDetector\Data\Os::unknown;

        $headersWithPlatformCode = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasPlatformCode(),
        );

        $platformHeader = reset($headersWithPlatformCode);

        if ($platformHeader instanceof HeaderInterface) {
            try {
                $platform = $platformHeader->getPlatformCode();
            } catch (\UaRequest\Exception\NotFoundException) {
                // do nothing
            }
        }

        if ($platform === \BrowserDetector\Data\Os::unknown) {
            try {
                $platform = \BrowserDetector\Data\Os::fromName((string) $platformCodenameFromDevice);
            } catch (UnexpectedValueException) {
                // do nothing
            }
        }

        $platformVersion = match ($platform) {
            \BrowserDetector\Data\Os::lineageos => $this->getVersionForLineageOs(),
            \BrowserDetector\Data\Os::fireos => $this->getVersionForFireOs(),
            default => $this->getVersionForGeneric($platform, $platformHeader),
        };

        if ($platform !== \BrowserDetector\Data\Os::unknown) {
            try {
                $platformFromOs = $this->platformLoader->loadFromOs(
                    os: $platform,
                    useragent: $platformHeader instanceof HeaderInterface ? $platformHeader->getValue() : '',
                );

                if (
                    $platformVersion instanceof VersionInterface
                    && ($platformVersion instanceof ForcedNullVersion || $platformVersion->getVersion() !== null)
                ) {
                    return $platformFromOs->withVersion($platformVersion);
                }

                return $platformFromOs;
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
     * @throws void
     */
    public function getDeviceData(): DeviceDataInterface
    {
        $headersWithDeviceCode = array_filter(
            $this->headers,
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
                display: new Display(),
                dualOrientation: null,
                simCount: null,
                bits: Bits::unknown,
            ),
            os: null,
        );
    }

    /** @throws void */
    private function getEngineVersion(\UaData\EngineInterface $engine): VersionInterface
    {
        $headersWithEngineVersion = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasEngineVersion(),
        );

        $engineVersionHeader = reset($headersWithEngineVersion);

        if ($engineVersionHeader instanceof HeaderInterface) {
            return $engineVersionHeader->getEngineVersion($engine->getKey());
        }

        return new NullVersion();
    }

    /** @throws void */
    private function getClientVersion(string | null $clientCodename): VersionInterface
    {
        $headersWithClientVersion = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasClientVersion(),
        );

        $clientVersionHeader = reset($headersWithClientVersion);

        if ($clientVersionHeader instanceof HeaderInterface) {
            return $clientVersionHeader->getClientVersion($clientCodename);
        }

        return new NullVersion();
    }

    /** @throws VersionContainsDerivateException */
    private function getPlatformVersion(\UaData\OsInterface $platform): VersionInterface
    {
        $headersWithPlatformVersion = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasPlatformVersion(),
        );

        $platformHeaderVersion = reset($headersWithPlatformVersion);

        if ($platformHeaderVersion instanceof HeaderInterface) {
            return $platformHeaderVersion->getPlatformVersion($platform->getKey());
        }

        return new NullVersion();
    }

    /** @throws void */
    private function getVersionForLineageOs(): VersionInterface
    {
        try {
            $androidVersion = $this->getPlatformVersion(\BrowserDetector\Data\Os::android)->getVersion(
                VersionInterface::IGNORE_MINOR_IF_EMPTY,
            );

            $lineageOsVersion = new LineageOs(new VersionBuilder());

            return $lineageOsVersion->getVersion($androidVersion ?? '');
        } catch (VersionContainsDerivateException | UnexpectedValueException | NotNumericException) {
            // do nothing
        }

        return new NullVersion();
    }

    /** @throws void */
    private function getVersionForFireOs(): VersionInterface
    {
        try {
            $androidVersion = $this->getPlatformVersion(\BrowserDetector\Data\Os::android)->getVersion(
                VersionInterface::IGNORE_MINOR_IF_EMPTY,
            );

            $fireOsVersion = new FireOs(new VersionBuilder());

            return $fireOsVersion->getVersion($androidVersion ?? '');
        } catch (VersionContainsDerivateException | UnexpectedValueException | NotNumericException) {
            // do nothing
        }

        return new NullVersion();
    }

    /** @throws void */
    private function getVersionForGeneric(
        \UaData\OsInterface &$platform,
        HeaderInterface | false $platformHeader,
    ): VersionInterface {
        try {
            return $this->getPlatformVersion($platform);
        } catch (VersionContainsDerivateException $e) {
            $derivate = $e->getDerivate();

            if ($platformHeader instanceof HeaderInterface && $derivate !== '') {
                try {
                    $derivateOs = $platformHeader->getPlatformCode($derivate);

                    if ($derivateOs !== \BrowserDetector\Data\Os::unknown) {
                        $platform = $derivateOs;
                    }
                } catch (\UaRequest\Exception\NotFoundException) {
                    // do nothing
                }
            }
        }

        return new NullVersion();
    }
}
