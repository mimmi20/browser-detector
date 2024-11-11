<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Header;

use BrowserDetector\Constants;
use BrowserDetector\Header\HeaderInterface;
use BrowserDetector\Header\HeaderLoader;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\NotFoundException;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\NormalizerFactory;

use function sprintf;

final class HeaderLoaderTest extends TestCase
{
    /** @throws NotFoundException */
    public function testLoadFail(): void
    {
        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $key = Constants::HEADER_TEST;

        $subject = new HeaderLoader(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(sprintf('the header with name "%s" was not found', $key));

        $subject->load($key, '');
    }

    /**
     * @param Constants::HEADER_* $key
     *
     * @throws Exception
     * @throws NotFoundException
     */
    #[DataProvider('providerHeader')]
    public function testLoadOk(string $key): void
    {
        $value = 'header-value';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $subject = new HeaderLoader(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        $header = $subject->load($key, $value);

        self::assertInstanceOf(HeaderInterface::class, $header);
        self::assertSame($value, $header->getValue());
    }

    /**
     * @param Constants::HEADER_* $key
     *
     * @throws ExpectationFailedException
     */
    #[DataProvider('providerHeader')]
    public function testHas(string $key): void
    {
        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $subject = new HeaderLoader(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        self::assertTrue($subject->has($key));
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerHeader(): array
    {
        return [
            [Constants::HEADER_USERAGENT],
            [Constants::HEADER_BAIDU_FLYFLOW],
            [Constants::HEADER_DEVICE_STOCK_UA],
            [Constants::HEADER_SEC_CH_UA],
            [Constants::HEADER_SEC_CH_UA_ARCH],
            [Constants::HEADER_SEC_CH_UA_BITNESS],
            [Constants::HEADER_SEC_CH_UA_FULL_VERSION],
            [Constants::HEADER_SEC_CH_UA_FULL_VERSION_LIST],
            [Constants::HEADER_SEC_CH_UA_MOBILE],
            [Constants::HEADER_SEC_CH_UA_MODEL],
            [Constants::HEADER_SEC_CH_UA_PLATFORM],
            [Constants::HEADER_SEC_CH_UA_PLATFORM_VERSION],
            [Constants::HEADER_UA_OS],
            [Constants::HEADER_ORIGINAL_UA],
            [Constants::HEADER_DEVICE_UA],
            [Constants::HEADER_OPERAMINI_PHONE],
            [Constants::HEADER_OPERAMINI_PHONE_UA],
            [Constants::HEADER_PUFFIN_UA],
            [Constants::HEADER_REQUESTED_WITH],
            [Constants::HEADER_UCBROWSER_DEVICE],
            [Constants::HEADER_UCBROWSER_DEVICE_UA],
            [Constants::HEADER_UCBROWSER_PHONE],
            [Constants::HEADER_UCBROWSER_PHONE_UA],
            [Constants::HEADER_UCBROWSER_UA],
        ];
    }
}
