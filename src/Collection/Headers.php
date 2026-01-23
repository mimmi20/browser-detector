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
use function array_first;
use function array_key_exists;
use function array_last;
use function array_map;
use function assert;
use function count;
use function explode;
use function in_array;
use function is_string;
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

        $deviceArchitectureHeader = array_first($headersWithDeviceArchitecture);

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

        $deviceFormFactorsHeader = array_first($headersWithDeviceFormFactors);

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

        $deviceBitnessHeader = array_first($headersWithDeviceBitness);

        if ($deviceBitnessHeader instanceof HeaderInterface) {
            return $deviceBitnessHeader->getDeviceBitness();
        }

        return Bits::unknown;
    }

    /** @throws void */
    public function getDeviceIsWow64(): bool | null
    {
        $headersWithDeviceIsWow64 = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasDeviceIsWow64(),
        );

        $deviceIsWow64Header = array_first($headersWithDeviceIsWow64);

        if ($deviceIsWow64Header instanceof HeaderInterface) {
            return $deviceIsWow64Header->getDeviceIsWow64();
        }

        return null;
    }

    /** @throws void */
    public function getDeviceIsMobile(): bool | null
    {
        $headersWithDeviceMobile = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasDeviceIsMobile(),
        );

        $deviceMobileHeader = array_first($headersWithDeviceMobile);

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

            $engineHeader = array_first($headersWithEngineName);

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
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public function getClientData(): ClientDataInterface
    {
        $headersWithClientCode = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasClientCode(),
        );

        $clientCodes = array_map(
            static fn (HeaderInterface $clientHeader): string | null => $clientHeader->getClientCode(),
            $headersWithClientCode,
        );

        $firstClientCodename = array_first($clientCodes);

        if (is_string($firstClientCodename)) {
            switch ($firstClientCodename) {
                case 'android webview':
                    $lastClientCodename = array_last($clientCodes);

                    if (
                        is_string($lastClientCodename)
                        && $lastClientCodename !== $firstClientCodename
                    ) {
                        $firstClientCodename = $lastClientCodename;
                        $clientHeader        = array_last($headersWithClientCode);
                    } else {
                        $clientHeader = array_first($headersWithClientCode);
                    }

                    break;
                case 'chromium':
                    $lastClientCodename = array_last($clientCodes);
                    $clientHeader       = array_first($headersWithClientCode);

                    if (is_string($lastClientCodename)) {
                        switch ($lastClientCodename) {
                            case 'opera':
                            case 'silk':
                            case 'adblock browser':
                            case 'google-nest-hub':
                            case 'chrome for ios':
                            case 'chrome':
                            case 'ecosia':
                            case 'firefox':
                            case 'headline bot':
                            case 'hubspot crawler':
                                $firstClientCodename = $lastClientCodename;
                                $clientHeader        = array_last($headersWithClientCode);

                                break;
                            default:
                                // do nothing
                        }
                    }

                    break;
                case 'chrome':
                    $lastClientCodename = array_last($clientCodes);
                    $clientHeader       = array_first($headersWithClientCode);

                    if (is_string($lastClientCodename)) {
                        switch ($lastClientCodename) {
                            case 'opera':
                            case 'silk':
                            case 'adblock browser':
                            case 'google-nest-hub':
                            case 'chrome for ios':
                            case 'ecosia':
                            case 'duck-assist-bot':
                            case 'sogou web spider':
                            case 'googlebot':
                            case 'google-search':
                            case 'webpagetest':
                            case 'facebook lite':
                                $firstClientCodename = $lastClientCodename;
                                $clientHeader        = array_last($headersWithClientCode);

                                break;
                            default:
                                // do nothing
                        }
                    }

                    break;
                case 'headless-chrome':
                    $lastClientCodename = array_last($clientCodes);
                    $clientHeader       = array_first($headersWithClientCode);

                    if (is_string($lastClientCodename)) {
                        switch ($lastClientCodename) {
                            case 'amazon bot':
                            case 'facebookexternalhit':
                            case 'headline bot':
                            case 'hanalei-bot':
                                $firstClientCodename = $lastClientCodename;
                                $clientHeader        = array_last($headersWithClientCode);

                                break;
                            default:
                                // do nothing
                        }
                    }

                    break;
                case 'brave':
                    $lastClientCodename = array_last($clientCodes);
                    $clientHeader       = array_first($headersWithClientCode);

                    if (is_string($lastClientCodename)) {
                        switch ($lastClientCodename) {
                            case 'pageburst':
                                $firstClientCodename = $lastClientCodename;
                                $clientHeader        = array_last($headersWithClientCode);

                                break;
                            default:
                                // do nothing
                        }
                    }

                    break;
                case 'keplr-app':
                case 'lookr-app':
                case 'kimi-app':
                case 'opera mini':
                case 'baidu box app lite':
                case 'baidu box app':
                case 'nytimes-crossword':
                case 'visha':
                case 'search-craft':
                case 'duckduck app':
                    $clientHeader = array_last($headersWithClientCode);

                    break;
                default:
                    $clientHeader = array_first($headersWithClientCode);

                    break;
            }

            assert($clientHeader instanceof HeaderInterface);

            $clientVersions = $this->getClientVersions($firstClientCodename);
            $clientVersion  = match ($firstClientCodename) {
                'aloha-browser', 'opera touch', 'adblock browser', 'opera mini', 'baidu box app lite', 'opera', 'silk', 'mint browser', 'instagram app', 'bingsearch', 'stargon-browser', 'opera gx', 'yahoo! japan', 'hi-search', 'pi browser', 'soul-browser', 'kik', 'oupeng browser', 'snapchat app', 'reddit-app', 'nytimes-crossword', 'smart-life', 'firefox', 'duck-assist-bot', 'sogou web spider', 'headline bot', 'amazon bot', 'hubspot crawler', 'facebookexternalhit', 'opera mobile', 'miui browser', 'stoutner-privacy-browser', 'dogtorance-app', 'line', 'msn-app', 'pageburst', 'googlebot', 'google-search', 'webpagetest', 'hanalei-bot', 'facebook lite' => $clientVersions['user-agent']
                    ?? array_last($clientVersions),
                'duckduck app', 'huawei-browser', 'ucbrowser', 'edge', 'headless-chrome' => $clientVersions['sec-ch-ua-full-version-list']
                    ?? $clientVersions['sec-ch-ua']
                    ?? $clientVersions['sec-ch-ua-full-version']
                    ?? array_last($clientVersions),
                'ecosia' => $clientVersions['sec-ch-ua-full-version']
                    ?? array_last($clientVersions),
                'vivaldi' => $clientVersions['sec-ch-ua']
                    ?? array_last($clientVersions),
                default => array_first($clientVersions),
            };

            try {
                $clientData = $this->browserLoader->load(
                    key: $firstClientCodename,
                    useragent: $clientHeader->getValue(),
                );

                if ($clientVersion?->getVersion() !== null) {
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
                version: new NullVersion(),
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
        $headersWithPlatformCode = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasPlatformCode(),
        );

        try {
            $platformCodes = array_map(
                static fn (HeaderInterface $platformHeader): \UaData\OsInterface => $platformHeader->getPlatformCode(),
                $headersWithPlatformCode,
            );
        } catch (\UaRequest\Exception\NotFoundException) {
            $platformCodes = [\BrowserDetector\Data\Os::unknown];
        }

        $firstPlatformCode = array_first($platformCodes);

        if (
            (
                $firstPlatformCode instanceof \UaData\OsInterface
                && $firstPlatformCode === \BrowserDetector\Data\Os::unknown
            )
            || $firstPlatformCode === null
        ) {
            try {
                $firstPlatformCode = \BrowserDetector\Data\Os::fromName(
                    (string) $platformCodenameFromDevice,
                );
            } catch (UnexpectedValueException) {
                // do nothing
            }
        }

        if ($firstPlatformCode instanceof \UaData\OsInterface) {
            $platform       = $firstPlatformCode;
            $platformHeader = array_first($headersWithPlatformCode);

            switch ($firstPlatformCode) {
                case \BrowserDetector\Data\Os::linux:
                    $lastPlatformCode = array_last($platformCodes);

                    if (
                        $lastPlatformCode instanceof \UaData\OsInterface
                        && $lastPlatformCode !== $firstPlatformCode
                    ) {
                        $platform       = $lastPlatformCode;
                        $platformHeader = array_last($headersWithPlatformCode);
                    } else {
                        $platformHeader = array_first($headersWithPlatformCode);
                    }

                    break;
                case \BrowserDetector\Data\Os::macosx:
                    $lastPlatformCode = array_last($platformCodes);

                    if (
                        $lastPlatformCode instanceof \UaData\OsInterface
                        && $lastPlatformCode === \BrowserDetector\Data\Os::ios
                    ) {
                        $platform       = $lastPlatformCode;
                        $platformHeader = array_last($headersWithPlatformCode);
                    } else {
                        $platformHeader = array_first($headersWithPlatformCode);
                    }

                    break;
                case \BrowserDetector\Data\Os::windows:
                    $lastPlatformCode = array_last($platformCodes);
                    $platformHeader   = array_first($headersWithPlatformCode);

                    $headersWithPlatformVersion = array_filter(
                        $this->headers,
                        static fn (HeaderInterface $header): bool => $header->hasPlatformVersion(),
                    );

                    if (
                        $lastPlatformCode instanceof \UaData\OsInterface
                        && count($headersWithPlatformVersion) > 1
                        && !array_key_exists('sec-ch-ua-platform-version', $headersWithPlatformVersion)
                        && in_array(
                            $lastPlatformCode,
                            [\BrowserDetector\Data\Os::windows10, \BrowserDetector\Data\Os::windowsnt61, \BrowserDetector\Data\Os::windowsnt],
                            true,
                        )
                    ) {
                        $platform       = $lastPlatformCode;
                        $platformHeader = array_last($headersWithPlatformCode);
                    }

                    break;
                default:
                    // do nothing
                    break;
            }

            assert($platformHeader instanceof HeaderInterface || $platformHeader === null);

            $platformVersion = match ($platform) {
                \BrowserDetector\Data\Os::lineageos => $this->getVersionForLineageOs(),
                \BrowserDetector\Data\Os::fireos => $this->getVersionForFireOs(),
                \BrowserDetector\Data\Os::windows => $this->getVersionForWindows($platform),
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

        $deviceHeader   = array_first($headersWithDeviceCode);
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

        $engineVersionHeader = array_first($headersWithEngineVersion);

        if ($engineVersionHeader instanceof HeaderInterface) {
            return $engineVersionHeader->getEngineVersion($engine->getKey());
        }

        return new NullVersion();
    }

    /**
     * @return array<string, VersionInterface>
     *
     * @throws void
     */
    private function getClientVersions(string | null $clientCodename): array
    {
        $headersWithClientVersion = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasClientVersion(),
        );

        return array_map(
            static fn (HeaderInterface $clientVersionHeader): VersionInterface => $clientVersionHeader->getClientVersion(
                $clientCodename,
            ),
            $headersWithClientVersion,
        );
    }

    /** @throws VersionContainsDerivateException */
    private function getPlatformVersion(\UaData\OsInterface $platform): VersionInterface
    {
        $headersWithPlatformVersion = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasPlatformVersion(),
        );

        $platformHeaderVersion = array_first($headersWithPlatformVersion);

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
        HeaderInterface | null $platformHeader,
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

    /** @throws void */
    private function getVersionForWindows(\UaData\OsInterface &$platform): VersionInterface
    {
        $headersWithPlatformVersion = array_filter(
            $this->headers,
            static fn (HeaderInterface $header): bool => $header->hasPlatformVersion(),
        );

        $platformHeaderVersion = $headersWithPlatformVersion['sec-ch-ua-platform-version'] ?? array_first(
            $headersWithPlatformVersion,
        );

        if ($platformHeaderVersion instanceof HeaderInterface) {
            return $platformHeaderVersion->getPlatformVersion($platform->getKey());
        }

        return new NullVersion();
    }
}
