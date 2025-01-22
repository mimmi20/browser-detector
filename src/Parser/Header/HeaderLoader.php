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

namespace BrowserDetector\Parser\Header;

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
use UaRequest\Headers;
use UaRequest\NotFoundException;

use function sprintf;

final readonly class HeaderLoader implements HeaderLoaderInterface
{
    /** @throws void */
    public function __construct(
        private DeviceParserInterface $deviceParser,
        private PlatformParserInterface $platformParser,
        private BrowserParserInterface $browserParser,
        private EngineParserInterface $engineParser,
        private NormalizerFactory $normalizerFactory,
        private BrowserLoaderInterface $browserLoader,
        private PlatformLoaderInterface $platformLoader,
        private EngineLoaderInterface $engineLoader,
    ) {
        // nothing to do
    }

    /**
     * @param Constants::HEADER_* $key
     *
     * @throws void
     */
    #[Override]
    public function has(string $key): bool
    {
        return Headers::tryFrom($key) !== null;
    }

    /**
     * @param Constants::HEADER_* $key
     *
     * @throws NotFoundException
     */
    #[Override]
    public function load(string $key, string $value): HeaderInterface
    {
        $header = Headers::tryFrom($key);

        $normalizer = $this->normalizerFactory->build();

        return match ($header) {
            Headers::HEADER_BAIDU_FLYFLOW => new DeviceCodeOnlyHeader(
                value: $value,
                deviceCode: new BaiduFlyflow(deviceParser: $this->deviceParser),
            ),
            Headers::HEADER_DEVICE_STOCK_UA => new FullHeader(
                value: $value,
                deviceCode: new DeviceStockUaDeviceCode(
                    deviceParser: $this->deviceParser,
                ),
                clientCode: new DeviceStockUaClientCode(),
                clientVersion: new DeviceStockUaClientVersion(),
                platformCode: new DeviceStockUaPlatformCode(),
                platformVersion: new DeviceStockUaPlatformVersion(),
                engineCode: new DeviceStockUaEngineCode(),
                engineVersion: new DeviceStockUaEngineVersion(),
            ),
            Headers::HEADER_SEC_CH_UA => new ClientHeader(
                value: $value,
                clientCode: new SecChUaClientCode(),
                clientVersion: new SecChUaClientVersion(),
            ),
            Headers::HEADER_SEC_CH_UA_ARCH => new SecChUaArch(value: $value),
            Headers::HEADER_SEC_CH_UA_BITNESS => new SecChUaBitness(value: $value),
            Headers::HEADER_SEC_CH_UA_FULL_VERSION => new SecChUaFullVersion(value: $value),
            Headers::HEADER_SEC_CH_UA_FULL_VERSION_LIST => new SecChUaFullVersion(value: $value),
            Headers::HEADER_SEC_CH_UA_MOBILE => new SecChUaMobile(value: $value),
            Headers::HEADER_SEC_CH_UA_MODEL => new DeviceCodeOnlyHeader(
                value: $value,
                deviceCode: new SecChUaModel(),
            ),
            Headers::HEADER_SEC_CH_UA_PLATFORM => new PlatformCodeOnlyHeader(
                value: $value,
                platformCode: new SecChUaPlatform(),
            ),
            Headers::HEADER_SEC_CH_UA_PLATFORM_VERSION => new PlatformVersionOnlyHeader(
                value: $value,
                platformVersion: new SecChUaPlatformVersion(),
            ),
            Headers::HEADER_UA_OS => new PlatformHeader(
                value: $value,
                platformCode: new UaOsPlatformCode(),
                platformVersion: new UaOsPlatformVersion(),
            ),
            Headers::HEADER_CRAWLED_BY => new ClientHeader(
                value: $value,
                clientCode: new CrawledByClientCode(),
                clientVersion: new CrawledByClientVersion(),
            ),
            Headers::HEADER_USERAGENT, Headers::HEADER_ORIGINAL_UA => new FullHeader(
                value: $value,
                deviceCode: new UseragentDeviceCode(
                    deviceParser: $this->deviceParser,
                    normalizer: $normalizer,
                ),
                clientCode: new UseragentClientCode(
                    browserParser: $this->browserParser,
                    normalizer: $normalizer,
                ),
                clientVersion: new UseragentClientVersion(
                    browserParser: $this->browserParser,
                    browserLoader: $this->browserLoader,
                    normalizer: $normalizer,
                ),
                platformCode: new UseragentPlatformCode(
                    platformParser: $this->platformParser,
                    normalizer: $normalizer,
                ),
                platformVersion: new UseragentPlatformVersion(
                    platformParser: $this->platformParser,
                    platformLoader: $this->platformLoader,
                    normalizer: $normalizer,
                ),
                engineCode: new UseragentEngineCode(
                    engineParser: $this->engineParser,
                    normalizer: $normalizer,
                ),
                engineVersion: new UseragentEngineVersion(
                    engineParser: $this->engineParser,
                    engineLoader: $this->engineLoader,
                    normalizer: $normalizer,
                ),
            ),
            Headers::HEADER_DEVICE_UA => new DeviceCodeOnlyHeader(
                value: $value,
                deviceCode: new XDeviceUseragent(
                    deviceParser: $this->deviceParser,
                    normalizer: $normalizer,
                ),
            ),
            Headers::HEADER_OPERAMINI_PHONE => new DeviceCodeOnlyHeader(
                value: $value,
                deviceCode: new XOperaminiPhone(),
            ),
            Headers::HEADER_OPERAMINI_PHONE_UA => new XOperaminiPhoneUa(
                value: $value,
                deviceCode: new XOperaminiPhoneUaDeviceCode(
                    deviceParser: $this->deviceParser,
                    normalizer: $normalizer,
                ),
                clientCode: new XOperaminiPhoneUaClientCode(),
                clientVersion: new XOperaminiPhoneUaClientVersion(),
                platformCode: new XOperaminiPhoneUaPlatformCode(),
                engineCode: new XOperaminiPhoneUaEngineCode(
                    engineParser: $this->engineParser,
                    normalizer: $normalizer,
                ),
            ),
            Headers::HEADER_PUFFIN_UA => new XPuffinUa(
                value: $value,
                deviceCode: new XPuffinUaDeviceCode(),
                platformCode: new XPuffinUaPlatformCode(),
            ),
            Headers::HEADER_REQUESTED_WITH => new ClientHeader(
                value: $value,
                clientCode: new XRequestedWithClientCode(),
                clientVersion: new XRequestedWithClientVersion(),
            ),
            Headers::HEADER_UCBROWSER_DEVICE => new DeviceCodeOnlyHeader(
                value: $value,
                deviceCode: new XUcbrowserDevice(
                    deviceParser: $this->deviceParser,
                    normalizer: $normalizer,
                ),
            ),
            Headers::HEADER_UCBROWSER_DEVICE_UA => new XUcbrowserDeviceUa(
                value: $value,
                deviceCode: new XUcbrowserDeviceUaDeviceCode(
                    deviceParser: $this->deviceParser,
                    normalizer: $normalizer,
                ),
                platformCode: new XUcbrowserDeviceUaPlatformCode(
                    platformParser: $this->platformParser,
                    normalizer: $normalizer,
                ),
            ),
            Headers::HEADER_UCBROWSER_PHONE, Headers::HEADER_UCBROWSER_PHONE_UA => new XUcbrowserPhoneUa(
                value: $value,
                deviceCode: new XUcbrowserPhoneDeviceCode(),
                clientCode: new XUcbrowserPhoneClientCode(),
            ),
            Headers::HEADER_UCBROWSER_UA => new FullHeader(
                value: $value,
                deviceCode: new XUcbrowserUaDeviceCode(deviceParser: $this->deviceParser),
                clientCode: new XUcbrowserUaClientCode(),
                clientVersion: new XUcbrowserUaClientVersion(),
                platformCode: new XUcbrowserUaPlatformCode(),
                platformVersion: new XUcbrowserUaPlatformVersion(),
                engineCode: new XUcbrowserUaEngineCode(),
                engineVersion: new XUcbrowserUaEngineVersion(),
            ),
            default => throw new NotFoundException(
                sprintf('the header with name "%s" was not found', $key),
            ),
        };
    }
}
