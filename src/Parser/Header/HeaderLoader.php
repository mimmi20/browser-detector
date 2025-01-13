<?php

/**
 * This file is part of the mimmi20/ua-generic-request package.
 *
 * Copyright (c) 2015-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Header;

use Closure;
use Override;
use UaLoader\BrowserLoaderInterface;
use UaLoader\EngineLoaderInterface;
use UaLoader\PlatformLoaderInterface;
use UaNormalizer\NormalizerFactory;
use UaParser\BrowserParserInterface;
use UaParser\DeviceParserInterface;
use UaParser\EngineParserInterface;
use UaParser\PlatformParserInterface;
use UaRequest\Constants;
use UaRequest\Header\ClientHeader;
use UaRequest\Header\DeviceCodeOnlyHeader;
use UaRequest\Header\FullHeader;
use UaRequest\Header\HeaderInterface;
use UaRequest\Header\HeaderLoaderInterface;
use UaRequest\Header\PlatformCodeOnlyHeader;
use UaRequest\Header\PlatformHeader;
use UaRequest\Header\PlatformVersionOnlyHeader;
use UaRequest\Header\SecChUaArch;
use UaRequest\Header\SecChUaBitness;
use UaRequest\Header\SecChUaFullVersion;
use UaRequest\Header\SecChUaMobile;
use UaRequest\Header\XOperaminiPhoneUa;
use UaRequest\Header\XPuffinUa;
use UaRequest\Header\XUcbrowserDeviceUa;
use UaRequest\Header\XUcbrowserPhoneUa;
use UaRequest\NotFoundException;

use function array_key_exists;
use function sprintf;

final class HeaderLoader implements HeaderLoaderInterface
{
    /** @var array<string, Closure(string): HeaderInterface> */
    private array $factories;

    /** @throws void */
    public function __construct(
        DeviceParserInterface $deviceParser,
        PlatformParserInterface $platformParser,
        BrowserParserInterface $browserParser,
        EngineParserInterface $engineParser,
        NormalizerFactory $normalizerFactory,
        BrowserLoaderInterface $browserLoader,
        PlatformLoaderInterface $platformLoader,
        EngineLoaderInterface $engineLoader,
    ) {
        $this->factories = [
            Constants::HEADER_BAIDU_FLYFLOW => static fn (string $header): HeaderInterface => new DeviceCodeOnlyHeader(
                value: $header,
                deviceCode: new BaiduFlyflow(deviceParser: $deviceParser),
            ),
            Constants::HEADER_DEVICE_STOCK_UA => static fn (string $header): HeaderInterface => new FullHeader(
                value: $header,
                deviceCode: new DeviceStockUaDeviceCode(
                    deviceParser: $deviceParser,
                ),
                clientCode: new DeviceStockUaClientCode(),
                clientVersion: new DeviceStockUaClientVersion(),
                platformCode: new DeviceStockUaPlatformCode(),
                platformVersion: new DeviceStockUaPlatformVersion(),
                engineCode: new DeviceStockUaEngineCode(),
                engineVersion: new DeviceStockUaEngineVersion(),
            ),
            Constants::HEADER_SEC_CH_UA => static fn (string $header): HeaderInterface => new ClientHeader(
                value: $header,
                clientCode: new SecChUaClientCode(),
                clientVersion: new SecChUaClientVersion(),
            ),
            Constants::HEADER_SEC_CH_UA_ARCH => static fn (string $header): HeaderInterface => new SecChUaArch(
                value: $header,
            ),
            Constants::HEADER_SEC_CH_UA_BITNESS => static fn (string $header): HeaderInterface => new SecChUaBitness(
                value: $header,
            ),
            Constants::HEADER_SEC_CH_UA_FULL_VERSION => static fn (string $header): HeaderInterface => new SecChUaFullVersion(
                value: $header,
            ),
            Constants::HEADER_SEC_CH_UA_FULL_VERSION_LIST => static fn (string $header): HeaderInterface => new SecChUaFullVersion(
                value: $header,
            ),
            Constants::HEADER_SEC_CH_UA_MOBILE => static fn (string $header): HeaderInterface => new SecChUaMobile(
                value: $header,
            ),
            Constants::HEADER_SEC_CH_UA_MODEL => static fn (string $header): HeaderInterface => new DeviceCodeOnlyHeader(
                value: $header,
                deviceCode: new SecChUaModel(),
            ),
            Constants::HEADER_SEC_CH_UA_PLATFORM => static fn (string $header): HeaderInterface => new PlatformCodeOnlyHeader(
                value: $header,
                platformCode: new SecChUaPlatform(),
            ),
            Constants::HEADER_SEC_CH_UA_PLATFORM_VERSION => static fn (string $header): HeaderInterface => new PlatformVersionOnlyHeader(
                value: $header,
                platformVersion: new SecChUaPlatformVersion(),
            ),
            Constants::HEADER_UA_OS => static fn (string $header): HeaderInterface => new PlatformHeader(
                value: $header,
                platformCode: new UaOsPlatformCode(),
                platformVersion: new UaOsPlatformVersion(),
            ),
            Constants::HEADER_CRAWLED_BY => static fn (string $header): HeaderInterface => new ClientHeader(
                value: $header,
                clientCode: new SecChUaClientCode(),
                clientVersion: new SecChUaClientVersion(),
            ),
            Constants::HEADER_USERAGENT => static fn (string $header): HeaderInterface => new FullHeader(
                value: $header,
                deviceCode: new UseragentDeviceCode(
                    deviceParser: $deviceParser,
                    normalizerFactory: $normalizerFactory,
                ),
                clientCode: new UseragentClientCode(
                    browserParser: $browserParser,
                    normalizerFactory: $normalizerFactory,
                ),
                clientVersion: new UseragentClientVersion(
                    browserParser: $browserParser,
                    browserLoader: $browserLoader,
                    normalizerFactory: $normalizerFactory,
                ),
                platformCode: new UseragentPlatformCode(
                    platformParser: $platformParser,
                    normalizerFactory: $normalizerFactory,
                ),
                platformVersion: new UseragentPlatformVersion(
                    platformParser: $platformParser,
                    platformLoader: $platformLoader,
                    normalizerFactory: $normalizerFactory,
                ),
                engineCode: new UseragentEngineCode(
                    engineParser: $engineParser,
                    normalizerFactory: $normalizerFactory,
                ),
                engineVersion: new UseragentEngineVersion(
                    engineParser: $engineParser,
                    engineLoader: $engineLoader,
                    normalizerFactory: $normalizerFactory,
                ),
            ),
            Constants::HEADER_ORIGINAL_UA => static fn (string $header): HeaderInterface => new FullHeader(
                value: $header,
                deviceCode: new UseragentDeviceCode(
                    deviceParser: $deviceParser,
                    normalizerFactory: $normalizerFactory,
                ),
                clientCode: new UseragentClientCode(
                    browserParser: $browserParser,
                    normalizerFactory: $normalizerFactory,
                ),
                clientVersion: new UseragentClientVersion(
                    browserParser: $browserParser,
                    browserLoader: $browserLoader,
                    normalizerFactory: $normalizerFactory,
                ),
                platformCode: new UseragentPlatformCode(
                    platformParser: $platformParser,
                    normalizerFactory: $normalizerFactory,
                ),
                platformVersion: new UseragentPlatformVersion(
                    platformParser: $platformParser,
                    platformLoader: $platformLoader,
                    normalizerFactory: $normalizerFactory,
                ),
                engineCode: new UseragentEngineCode(
                    engineParser: $engineParser,
                    normalizerFactory: $normalizerFactory,
                ),
                engineVersion: new UseragentEngineVersion(
                    engineParser: $engineParser,
                    engineLoader: $engineLoader,
                    normalizerFactory: $normalizerFactory,
                ),
            ),
            Constants::HEADER_DEVICE_UA => static fn (string $header): HeaderInterface => new DeviceCodeOnlyHeader(
                value: $header,
                deviceCode: new XDeviceUseragent(
                    deviceParser: $deviceParser,
                    normalizerFactory: $normalizerFactory,
                ),
            ),
            Constants::HEADER_OPERAMINI_PHONE => static fn (string $header): HeaderInterface => new DeviceCodeOnlyHeader(
                value: $header,
                deviceCode: new XOperaminiPhone(),
            ),
            Constants::HEADER_OPERAMINI_PHONE_UA => static fn (string $header): HeaderInterface => new XOperaminiPhoneUa(
                value: $header,
                deviceCode: new XOperaminiPhoneUaDeviceCode(
                    deviceParser: $deviceParser,
                    normalizerFactory: $normalizerFactory,
                ),
                clientCode: new XOperaminiPhoneUaClientCode(),
                clientVersion: new XOperaminiPhoneUaClientVersion(),
                platformCode: new XOperaminiPhoneUaPlatformCode(),
                engineCode: new XOperaminiPhoneUaEngineCode(
                    engineParser: $engineParser,
                    normalizerFactory: $normalizerFactory,
                ),
            ),
            Constants::HEADER_PUFFIN_UA => static fn (string $header): HeaderInterface => new XPuffinUa(
                value: $header,
                deviceCode: new XPuffinUaDeviceCode(),
                platformCode: new XPuffinUaPlatformCode(),
            ),
            Constants::HEADER_REQUESTED_WITH => static fn (string $header): HeaderInterface => new ClientHeader(
                value: $header,
                clientCode: new XRequestedWithClientCode(),
                clientVersion: new XRequestedWithClientVersion(),
            ),
            Constants::HEADER_UCBROWSER_DEVICE => static fn (string $header): HeaderInterface => new DeviceCodeOnlyHeader(
                value: $header,
                deviceCode: new XUcbrowserDevice(
                    deviceParser: $deviceParser,
                    normalizerFactory: $normalizerFactory,
                ),
            ),
            Constants::HEADER_UCBROWSER_DEVICE_UA => static fn (string $header): HeaderInterface => new XUcbrowserDeviceUa(
                value: $header,
                deviceCode: new XUcbrowserDeviceUaDeviceCode(
                    deviceParser: $deviceParser,
                    normalizerFactory: $normalizerFactory,
                ),
                platformCode: new XUcbrowserDeviceUaPlatformCode(
                    platformParser: $platformParser,
                    normalizerFactory: $normalizerFactory,
                ),
            ),
            Constants::HEADER_UCBROWSER_PHONE => static fn (string $header): HeaderInterface => new XUcbrowserPhoneUa(
                value: $header,
                deviceCode: new XUcbrowserPhoneDeviceCode(),
                clientCode: new XUcbrowserPhoneClientCode(),
            ),
            Constants::HEADER_UCBROWSER_PHONE_UA => static fn (string $header): HeaderInterface => new XUcbrowserPhoneUa(
                value: $header,
                deviceCode: new XUcbrowserPhoneDeviceCode(),
                clientCode: new XUcbrowserPhoneClientCode(),
            ),
            Constants::HEADER_UCBROWSER_UA => static fn (string $header): HeaderInterface => new FullHeader(
                value: $header,
                deviceCode: new XUcbrowserUaDeviceCode(deviceParser: $deviceParser),
                clientCode: new XUcbrowserUaClientCode(),
                clientVersion: new XUcbrowserUaClientVersion(),
                platformCode: new XUcbrowserUaPlatformCode(),
                platformVersion: new XUcbrowserUaPlatformVersion(),
                engineCode: new XUcbrowserUaEngineCode(),
                engineVersion: new XUcbrowserUaEngineVersion(),
            ),
        ];
    }

    /**
     * @param Constants::HEADER_* $key
     *
     * @throws void
     */
    #[Override]
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->factories);
    }

    /**
     * @param Constants::HEADER_* $key
     *
     * @throws NotFoundException
     */
    #[Override]
    public function load(string $key, string $value): HeaderInterface
    {
        if (!$this->has($key)) {
            throw new NotFoundException(sprintf('the header with name "%s" was not found', $key));
        }

        $factory = $this->factories[$key];

        return $factory($value);
    }
}
