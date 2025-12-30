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

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\Helper\Safari as SafariHelper;
use BrowserDetector\Version\Helper\SafariInterface;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\Safari;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function assert;

#[CoversClass(Safari::class)]
final class SafariTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     * @throws Exception
     */
    #[DataProvider('providerVersion')]
    public function testTestdetectVersion(string $useragent, string | null $expectedVersion): void
    {
        $object = new Safari(new VersionBuilder(), new SafariHelper());

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array<int, array<int, string|null>>
     *
     * @throws void
     */
    public static function providerVersion(): array
    {
        return [
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; ru-ru; ImPAD 9708 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                '4.0.0',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.22 (KHTML, like Gecko) Safari/537.22 anonymized by Abelssoft 480578327',
                '4.0.0',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                null,
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 12_1_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/16C50 Safari/605.1.15 Version/12.2.0.0.1',
                '12.2.0.0.1',
            ],
            [
                'mozilla/5.0 (macintosh; intel mac os x 10_15_7) applewebkit/605.1.15 (khtml, like gecko) version/16.3 safari/605.1.15',
                '16.3.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Safari/605.1.15',
                '17.1.0',
            ],
            [
                'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36',
                '4.0.0',
            ],
            [
                'NetworkingExtension/8620.2.3 CFNetwork/3826.400.110 Darwin/24.3.0',
                '6.0.0',
            ],
            [
                'NetworkingExtension/8620.2.3 Network/4277.80.14.0.2 iOS/18.3',
                '18.3.0',
            ],
            [
                'com.apple.WebKit.Networking/20620.2.3 CFNetwork/3826.400.110 Darwin/24.3.0',
                '18.3.0',
            ],
        ];
    }

    /**
     * @throws UnexpectedValueException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail(): void
    {
        $exception = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('4.0')
            ->willThrowException($exception);

        $safariHelper = $this->createMock(SafariInterface::class);
        $safariHelper
            ->expects(self::never())
            ->method('mapSafariVersion');

        assert($versionBuilder instanceof VersionFactoryInterface);
        assert($safariHelper instanceof SafariInterface);
        $object = new Safari($versionBuilder, $safariHelper);

        $detectedVersion = $object->detectVersion(
            'Mozilla/5.0 (Linux; U; Android 4.2.2; ru-ru; ImPAD 9708 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
        );

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws UnexpectedValueException
     * @throws NotNumericException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFailSecond(): void
    {
        $mappedVersion  = new Version('2');
        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('4.0')
            ->willReturn($mappedVersion);

        $safariHelper = $this->createMock(SafariInterface::class);
        $safariHelper
            ->expects(self::once())
            ->method('mapSafariVersion')
            ->with($mappedVersion)
            ->willReturn(null);

        assert($versionBuilder instanceof VersionFactoryInterface);
        assert($safariHelper instanceof SafariInterface);
        $object = new Safari($versionBuilder, $safariHelper);

        $detectedVersion = $object->detectVersion(
            'Mozilla/5.0 (Linux; U; Android 4.2.2; ru-ru; ImPAD 9708 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
        );

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws UnexpectedValueException
     * @throws NotNumericException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFailThird(): void
    {
        $exception = new NotNumericException('set failed');

        $mappedVersionOne = new Version('2');
        $versionBuilder   = $this->createMock(VersionBuilderInterface::class);
        $matcher          = self::exactly(2);
        $versionBuilder
            ->expects($matcher)
            ->method('set')
            ->willReturnCallback(
                static function (string $version) use ($matcher, $mappedVersionOne, $exception): Version {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('4.0', $version, (string) $invocation),
                        default => self::assertSame('1.0', $version, (string) $invocation),
                    };

                    return match ($invocation) {
                        1 => $mappedVersionOne,
                        default => throw $exception,
                    };
                },
            );

        $safariHelper = $this->createMock(SafariInterface::class);
        $safariHelper
            ->expects(self::once())
            ->method('mapSafariVersion')
            ->with($mappedVersionOne)
            ->willReturn('1.0');

        assert($versionBuilder instanceof VersionFactoryInterface);
        assert($safariHelper instanceof SafariInterface);
        $object = new Safari($versionBuilder, $safariHelper);

        $detectedVersion = $object->detectVersion(
            'Mozilla/5.0 (Linux; U; Android 4.2.2; ru-ru; ImPAD 9708 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
        );

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws UnexpectedValueException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail4(): void
    {
        $exception = new NotNumericException('set failed');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('537.36')
            ->willThrowException($exception);

        $safariHelper = $this->createMock(SafariInterface::class);
        $safariHelper
            ->expects(self::never())
            ->method('mapSafariVersion');

        assert($versionBuilder instanceof VersionFactoryInterface);
        assert($safariHelper instanceof SafariInterface);
        $object = new Safari($versionBuilder, $safariHelper);

        $detectedVersion = $object->detectVersion(
            'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36',
        );

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws UnexpectedValueException
     * @throws NotNumericException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail5(): void
    {
        $exception = new NotNumericException('set failed');

        $mappedVersionOne = new Version('2');
        $versionBuilder   = $this->createMock(VersionBuilderInterface::class);
        $matcher          = self::exactly(2);
        $versionBuilder
            ->expects($matcher)
            ->method('set')
            ->willReturnCallback(
                static function (string $version) use ($matcher, $mappedVersionOne, $exception): Version {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('537.36', $version, (string) $invocation),
                        default => self::assertSame('1.0', $version, (string) $invocation),
                    };

                    return match ($invocation) {
                        1 => $mappedVersionOne,
                        default => throw $exception,
                    };
                },
            );

        $safariHelper = $this->createMock(SafariInterface::class);
        $safariHelper
            ->expects(self::once())
            ->method('mapSafariVersion')
            ->with($mappedVersionOne)
            ->willReturn('1.0');

        assert($versionBuilder instanceof VersionFactoryInterface);
        assert($safariHelper instanceof SafariInterface);
        $object = new Safari($versionBuilder, $safariHelper);

        $detectedVersion = $object->detectVersion(
            'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36',
        );

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }

    /**
     * @throws UnexpectedValueException
     * @throws NotNumericException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail6(): void
    {
        $mappedVersionOne = new Version('2');
        $versionBuilder   = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('537.36')
            ->willReturn($mappedVersionOne);

        $safariHelper = $this->createMock(SafariInterface::class);
        $safariHelper
            ->expects(self::once())
            ->method('mapSafariVersion')
            ->with($mappedVersionOne)
            ->willReturn(null);

        assert($versionBuilder instanceof VersionFactoryInterface);
        assert($safariHelper instanceof SafariInterface);
        $object = new Safari($versionBuilder, $safariHelper);

        $detectedVersion = $object->detectVersion(
            'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36',
        );

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
        self::assertNull($detectedVersion->getVersion());
    }
}
