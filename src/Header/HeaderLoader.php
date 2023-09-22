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

namespace BrowserDetector\Header;

use BrowserDetector\Constants;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\NotFoundException;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use Closure;
use UaNormalizer\NormalizerFactory;

use function array_key_exists;

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
            Constants::HEADER_BAIDU_FLYFLOW => static fn (string $header): HeaderInterface => new BaiduFlyflow(
                $header,
                $deviceParser,
            ),
            Constants::HEADER_DEVICE_STOCK_UA => static fn (string $header): HeaderInterface => new DeviceStockUa(
                $header,
                $deviceParser,
            ),
            Constants::HEADER_SEC_CH_UA => static fn (string $header): HeaderInterface => new SecChUa(
                $header,
            ),
            Constants::HEADER_SEC_CH_UA_ARCH => static fn (string $header): HeaderInterface => new SecChUaArch(
                $header,
            ),
            Constants::HEADER_SEC_CH_UA_BITNESS => static fn (string $header): HeaderInterface => new SecChUaBitness(
                $header,
            ),
            Constants::HEADER_SEC_CH_UA_FULL_VERSION => static fn (string $header): HeaderInterface => new SecChUaFullVersion(
                $header,
            ),
            Constants::HEADER_SEC_CH_UA_FULL_VERSION_LIST => static fn (string $header): HeaderInterface => new SecChUa(
                $header,
            ),
            Constants::HEADER_SEC_CH_UA_MOBILE => static fn (string $header): HeaderInterface => new SecChUaMobile(
                $header,
            ),
            Constants::HEADER_SEC_CH_UA_MODEL => static fn (string $header): HeaderInterface => new SecChUaModel(
                $header,
            ),
            Constants::HEADER_SEC_CH_UA_PLATFORM => static fn (string $header): HeaderInterface => new SecChUaPlatform(
                $header,
            ),
            Constants::HEADER_SEC_CH_UA_PLATFORM_VERSION => static fn (string $header): HeaderInterface => new SecChUaPlatformVersion(
                $header,
            ),
            Constants::HEADER_UA_OS => static fn (string $header): HeaderInterface => new UaOs($header),
            Constants::HEADER_USERAGENT => static fn (string $header): HeaderInterface => new Useragent(
                $header,
                $deviceParser,
                $platformParser,
                $browserParser,
                $engineParser,
                $normalizerFactory,
                $browserLoader,
                $platformLoader,
                $engineLoader,
            ),
            Constants::HEADER_ORIGINAL_UA => static fn (string $header): HeaderInterface => new Useragent(
                $header,
                $deviceParser,
                $platformParser,
                $browserParser,
                $engineParser,
                $normalizerFactory,
                $browserLoader,
                $platformLoader,
                $engineLoader,
            ),
            Constants::HEADER_DEVICE_UA => static fn (string $header): HeaderInterface => new XDeviceUseragent(
                $header,
                $deviceParser,
                $normalizerFactory,
            ),
            Constants::HEADER_OPERAMINI_PHONE => static fn (string $header): HeaderInterface => new XOperaminiPhone(
                $header,
            ),
            Constants::HEADER_OPERAMINI_PHONE_UA => static fn (string $header): HeaderInterface => new XOperaminiPhoneUa(
                $header,
                $deviceParser,
                $engineParser,
                $normalizerFactory,
            ),
            Constants::HEADER_PUFFIN_UA => static fn (string $header): HeaderInterface => new XPuffinUa(
                $header,
            ),
            Constants::HEADER_REQUESTED_WITH => static fn (string $header): HeaderInterface => new XRequestedWith(
                $header,
            ),
            Constants::HEADER_UCBROWSER_DEVICE => static fn (string $header): HeaderInterface => new XUcbrowserDevice(
                $header,
                $deviceParser,
                $normalizerFactory,
            ),
            Constants::HEADER_UCBROWSER_DEVICE_UA => static fn (string $header): HeaderInterface => new XUcbrowserDeviceUa(
                $header,
                $deviceParser,
                $platformParser,
                $normalizerFactory,
            ),
            Constants::HEADER_UCBROWSER_PHONE => static fn (string $header): HeaderInterface => new XUcbrowserPhone(
                $header,
            ),
            Constants::HEADER_UCBROWSER_PHONE_UA => static fn (string $header): HeaderInterface => new XUcbrowserPhoneUa(
                $header,
            ),
            Constants::HEADER_UCBROWSER_UA => static fn (string $header): HeaderInterface => new XUcbrowserUa(
                $header,
                $deviceParser,
            ),
        ];
    }

    /** @throws void */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->factories);
    }

    /** @throws NotFoundException */
    public function load(string $key, string $value): HeaderInterface
    {
        if (!$this->has($key)) {
            throw new NotFoundException('the header with name "' . $key . '" was not found');
        }

        $factory = $this->factories[$key];

        return $factory($value);
    }
}
