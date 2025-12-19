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
use UaLoader\PlatformLoaderInterface;
use UaRequest\GenericRequestInterface;
use UaRequest\Header\HeaderInterface;
use UaRequest\RequestBuilderInterface;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;
use UaResult\Device\FormFactor;
use UnexpectedValueException;

use function array_map;
use function assert;
use function is_array;
use function mb_strtolower;
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
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    private function parse(GenericRequestInterface $request): array
    {
        $engineCodename = Engine::unknown;

        $headerCollection = new Headers(
            request: $request,
            logger: $this->logger,
            deviceLoaderFactory: $this->deviceLoaderFactory,
            platformLoader: $this->platformLoader,
            browserLoader: $this->browserLoader,
            engineLoader: $this->engineLoader,
        );

        /* detect device */
        $deviceFormFactor = $headerCollection->getDeviceFormFactor();
        $deviceData       = $headerCollection->getDeviceData();
        $device           = $deviceData->getDevice();

        /* detect platform */
        $platform = $headerCollection->getPlatformData(
            platformCodenameFromDevice: $deviceData->getOs(),
        );

        $platformName          = $platform->getName();
        $platformMarketingName = $platform->getMarketingName();

        if (mb_strtolower($platformName ?? '') === 'ios') {
            $engineCodename = Engine::webkit;

            try {
                $version             = $platform->getVersion();
                $iosVersion          = $version->getVersion(VersionInterface::IGNORE_MINOR);
                $deviceMarketingName = $device->getMarketingName();

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
        $clientData = $headerCollection->getClientData();

        $client = $clientData->getClient();

        /* detect engine */
        $engine = $headerCollection->getEngineData(
            engine: $engineCodename,
            engineCodenameFromClient: $clientData->getEngine(),
        );

        $architecture = $headerCollection->getDeviceArchitecture();
        $deviceBits   = $headerCollection->getDeviceBitness();

        if ($deviceFormFactor === FormFactor::unknown) {
            $deviceType = $device->getType();
            $isMobile   = $headerCollection->getDeviceIsMobile() ?? $deviceType->isMobile();
        } else {
            $deviceType = match ($deviceFormFactor) {
                FormFactor::mobile => Type::Smartphone,
                FormFactor::desktop => Type::Desktop,
                FormFactor::watch => Type::SmartWatch,
                FormFactor::tablet => $device->getSimCount() === 0 ? Type::Tablet : Type::FonePad,
                FormFactor::automotive => Type::CarEntertainmentSystem,
                FormFactor::xr => Type::Wearable,
                default => Type::Unknown,
            };

            $isMobile = match ($deviceFormFactor) {
                FormFactor::mobile, FormFactor::watch, FormFactor::tablet, FormFactor::xr => true,
                default => false,
            };
        }

        return [
            'headers' => array_map(
                callback: static fn (HeaderInterface $header): string => $header->getValue(),
                array: $request->getHeaders(),
            ),
            'device' => [
                'architecture' => $architecture === Architecture::unknown ? null : $architecture->value,
                'deviceName' => $device->getDeviceName(),
                'marketingName' => $device->getMarketingName(),
                'manufacturer' => $device->getManufacturer()->getKey(),
                'brand' => $device->getBrand()->getKey(),
                'dualOrientation' => $device->getDualOrientation(),
                'simCount' => $device->getSimCount(),
                'display' => $device->getDisplay()->toArray(),
                'type' => $deviceType->getType(),
                'ismobile' => $isMobile,
                'istv' => $deviceType->isTv(),
                'bits' => $deviceBits === Bits::unknown ? null : $deviceBits->value,
            ],
            'os' => [
                'name' => $platformName,
                'marketingName' => $platformMarketingName,
                'version' => $platform->getVersion()->getVersion(),
                'manufacturer' => $platform->getManufacturer()->getKey(),
                'bits' => $deviceBits === Bits::unknown ? null : $deviceBits->value,
            ],
            'client' => [
                'name' => $client->getName(),
                'modus' => null,
                'version' => $client->getVersion()->getVersion(),
                'manufacturer' => $client->getManufacturer()->getKey(),
                'type' => $client->getType()->getType(),
                'isbot' => $client->getType()->isBot(),
                'bits' => null,
            ],
            'engine' => [
                'name' => $engine->getName(),
                'version' => $engine->getVersion()->getVersion(),
                'manufacturer' => $engine->getManufacturer()->getKey(),
            ],
        ];
    }
}
