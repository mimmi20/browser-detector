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

namespace BrowserDetectorTest\Parser\Header;

use BrowserDetector\Parser\Header\HeaderLoader;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaLoader\BrowserLoaderInterface;
use UaLoader\EngineLoaderInterface;
use UaLoader\PlatformLoaderInterface;
use UaNormalizer\NormalizerFactory;
use UaParser\BrowserParserInterface;
use UaParser\DeviceParserInterface;
use UaParser\EngineParserInterface;
use UaParser\PlatformParserInterface;
use UaRequest\Constants;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\HeaderInterface;

use function sprintf;

#[CoversClass(HeaderLoader::class)]
final class HeaderLoaderTest extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testLoadFail(): void
    {
        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');
        $platformLoader
            ->expects(self::never())
            ->method('loadFromOs');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::never())
            ->method('loadFromEngine');

        $normalizerFactory = new NormalizerFactory();

        $key = Constants::HEADER_TEST;

        $subject = new HeaderLoader(
            deviceParser: $deviceParser,
            platformParser: $platformParser,
            browserParser: $browserParser,
            engineParser: $engineParser,
            normalizerFactory: $normalizerFactory,
            browserLoader: $browserLoader,
            platformLoader: $platformLoader,
            engineLoader: $engineLoader,
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
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerHeader')]
    public function testLoadOk(string $key): void
    {
        $value = 'header-value';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');
        $platformLoader
            ->expects(self::never())
            ->method('loadFromOs');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::never())
            ->method('loadFromEngine');

        $normalizerFactory = new NormalizerFactory();

        $subject = new HeaderLoader(
            deviceParser: $deviceParser,
            platformParser: $platformParser,
            browserParser: $browserParser,
            engineParser: $engineParser,
            normalizerFactory: $normalizerFactory,
            browserLoader: $browserLoader,
            platformLoader: $platformLoader,
            engineLoader: $engineLoader,
        );

        $header = $subject->load($key, $value);

        self::assertInstanceOf(HeaderInterface::class, $header);
        self::assertSame($value, $header->getValue());
    }

    /**
     * @param Constants::HEADER_* $key
     *
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerHeader')]
    public function testHas(string $key): void
    {
        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');
        $platformLoader
            ->expects(self::never())
            ->method('loadFromOs');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::never())
            ->method('loadFromEngine');

        $normalizerFactory = new NormalizerFactory();

        $subject = new HeaderLoader(
            deviceParser: $deviceParser,
            platformParser: $platformParser,
            browserParser: $browserParser,
            engineParser: $engineParser,
            normalizerFactory: $normalizerFactory,
            browserLoader: $browserLoader,
            platformLoader: $platformLoader,
            engineLoader: $engineLoader,
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
            [Constants::HEADER_CRAWLED_BY],
            [Constants::HEADER_SEC_CH_FORM_FACTORS],
            [Constants::HEADER_SEC_CH_WOW64],
        ];
    }
}
