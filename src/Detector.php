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

namespace BrowserDetector;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Collection\Headers;
use BrowserDetector\Data\Engine;
use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use Override;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaDeviceType\Type;
use UaLoader\BrowserLoaderInterface;
use UaLoader\EngineLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaLoader\PlatformLoaderInterface;
use UaRequest\GenericRequestInterface;
use UaRequest\Header\HeaderInterface;
use UaRequest\RequestBuilderInterface;
use UaResult\Bits\Bits;
use UaResult\Device\FormFactor;
use UaResult\Result\Result;
use UnexpectedValueException;

use function array_map;
use function assert;
use function in_array;
use function is_array;
use function mb_strtolower;
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
         * a logger instance
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
     * @return array{headers?: array<string, string>, device?: array{architecture: string, deviceName: string|null, marketingName: string|null, manufacturer: string, brand: string, type: string, ismobile: bool, istv: bool, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, dualOrientation: bool|null, simCount: int|null, bits: int}, client?: array{name: string|null, modus: string|null, version: string|null, manufacturer: string, type: string, isbot: bool, bits: int}, os?: array{name: string|null, marketingName: string|null, version: string|null, manufacturer: string, bits: int}, engine?: array{name: string|null, version: string|null, manufacturer: string}}
     *
     * @throws void
     */
    #[Override]
    public function getBrowser(array | GenericRequestInterface | MessageInterface | string $headers): array
    {
        try {
            $genericRequest = $this->requestBuilder->buildRequest($headers);
        } catch (UnexpectedValueException $e) {
            $this->logger->error($e);

            return [];
        }

        $cacheId = $genericRequest->getHash();

        try {
            if ($this->cache->hasItem($cacheId)) {
                /** @var array{headers?: array<string, string>, device?: array{architecture: string, deviceName: string|null, marketingName: string|null, manufacturer: string, brand: string, type: string, ismobile: bool, istv: bool, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, dualOrientation: bool|null, simCount: int|null, bits: int}, client?: array{name: string|null, modus: string|null, version: string|null, manufacturer: string, type: string, isbot: bool, bits: int}, os?: array{name: string|null, marketingName: string|null, version: string|null, manufacturer: string, bits: int}, engine?: array{name: string|null, version: string|null, manufacturer: string}} $item */
                $item = $this->cache->getItem($cacheId);
                assert(is_array($item));

                return $item;
            }

            $item = $this->parse($genericRequest)->toArray();

            $this->cache->setItem($cacheId, $item);
        } catch (InvalidArgumentException | UnexpectedValueException $e) {
            $this->logger->error($e);

            return [];
        }

        return $item;
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    private function parse(GenericRequestInterface $genericRequest): Result
    {
        $engineCodename = Engine::unknown;

        $headers = new Headers(
            genericRequest: $genericRequest,
            logger: $this->logger,
            deviceLoaderFactory: $this->deviceLoaderFactory,
            platformLoader: $this->platformLoader,
            browserLoader: $this->browserLoader,
            engineLoader: $this->engineLoader,
        );

        /* detect device */
        $deviceFormFactor = $headers->getDeviceFormFactor();
        $deviceData       = $headers->getDeviceData();
        $device           = $deviceData->getDevice();

        /* detect platform */
        $os = $headers->getPlatformData(
            platformCodenameFromDevice: $deviceData->getOs(),
        );

        $platformName          = $os->getName();
        $platformMarketingName = $os->getMarketingName();

        if (mb_strtolower($platformName ?? '') === 'ios') {
            $engineCodename = Engine::webkit;

            $version = $os->getVersion();

            try {
                $iosVersion = (int) $version->getVersion(VersionInterface::IGNORE_MINOR);
            } catch (UnexpectedValueException $e) {
                $this->logger->error($e);

                $iosVersion = 0;
            }

            $deviceMarketingName = $device->getMarketingName();

            if (
                $deviceMarketingName !== null
                && str_contains(mb_strtolower($deviceMarketingName), 'ipad')
                && $iosVersion >= 13
            ) {
                $platformName          = 'iPadOS';
                $platformMarketingName = 'iPadOS';
            }
        }

        if (
            in_array(
                $device->getMarketingName(),
                ['Windows Desktop', 'general Mobile Phone'],
                strict: true,
            )
            && in_array(mb_strtolower($platformName ?? ''), ['macos', 'mac os x'], strict: true)
        ) {
            $company = 'apple';
            $key     = 'macintosh';

            $deviceLoader = ($this->deviceLoaderFactory)($company);

            try {
                $device = $deviceLoader->load($key)->getDevice();
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

        /* detect client */
        $clientData = $headers->getClientData();
        $browser    = $clientData->getClient();

        /* detect engine */
        $engine = $headers->getEngineData(
            engine: $engineCodename,
            engineCodenameFromClient: $clientData->getEngine(),
            browser: $browser,
            platformName: $platformName,
        );

        $architecture = $headers->getDeviceArchitecture();
        $deviceBits   = $headers->getDeviceBitness();
        $deviceType   = $device->getType();

        if ($deviceFormFactor === FormFactor::unknown || $deviceFormFactor === FormFactor::mobile) {
            $isMobile = $headers->getDeviceIsMobile() ?? $deviceType->isMobile();
        } elseif ($deviceFormFactor === FormFactor::desktop) {
            if (!$deviceType->isMobile()) {
                $deviceType = Type::Desktop;
            }

            $isMobile = $deviceType->isMobile();
        } else {
            $deviceType = match ($deviceFormFactor) {
                FormFactor::watch => Type::SmartWatch,
                FormFactor::automotive => Type::CarEntertainmentSystem,
                FormFactor::xr => Type::Wearable,
                default => $device->getSimCount() === 0 ? Type::Tablet : Type::FonePad,
            };

            $isMobile = $deviceType->isMobile();
        }

        return new Result(
            headers: array_map(
                callback: static fn (HeaderInterface $header): string => $header->getValue(),
                array: $genericRequest->getHeaders(),
            ),
            device: $device
                ->withArchitecture($architecture)
                ->withType($deviceType)
                ->withIsMobile($isMobile)
                ->withBits($deviceBits),
            os: $os
                ->withBits($deviceBits)
                ->withName($platformName)
                ->withMarketingName($platformMarketingName),
            browser: $browser->withBits(
                $headers->getDeviceIsWow64()
                    ? Bits::thirtytwo
                    : $deviceBits,
            ),
            engine: $engine,
        );
    }
}
