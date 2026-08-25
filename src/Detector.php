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
use UaResult\Device\Architecture;
use UaResult\Device\FormFactor;
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
     * @return array<mixed>
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    #[Override]
    public function getBrowser(array | GenericRequestInterface | MessageInterface | string $headers): array
    {
        $genericRequest = $this->requestBuilder->buildRequest($headers);
        $cacheId        = $genericRequest->getHash();

        if ($this->cache->hasItem($cacheId)) {
            $item = $this->cache->getItem($cacheId);
            assert(is_array($item));

            return $item;
        }

        $item = $this->parse($genericRequest);

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
    private function parse(GenericRequestInterface $genericRequest): array
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

            try {
                $version             = $os->getVersion();
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

            try {
                $deviceLoader = ($this->deviceLoaderFactory)($company);

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

        return [
            'headers' => array_map(
                callback: static fn (HeaderInterface $header): string => $header->getValue(),
                array: $genericRequest->getHeaders(),
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
                'version' => $os->getVersion()->getVersion(),
                'manufacturer' => $os->getManufacturer()->getKey(),
                'bits' => $deviceBits === Bits::unknown ? null : $deviceBits->value,
            ],
            'client' => [
                'name' => $browser->getName(),
                'modus' => null,
                'version' => $browser->getVersion()->getVersion(),
                'manufacturer' => $browser->getManufacturer()->getKey(),
                'type' => $browser->getType()->getType(),
                'isbot' => $browser->getType()->isBot(),
                'bits' => $headers->getDeviceIsWow64() ? 32 : ($deviceBits === Bits::unknown ? null : $deviceBits->value),
            ],
            'engine' => [
                'name' => $engine->getName(),
                'version' => $engine->getVersion()->getVersion(),
                'manufacturer' => $engine->getManufacturer()->getKey(),
            ],
        ];
    }
}
