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

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\Ios;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionInterface;
use Exception;
use IosBuild\Exception\NotFoundException;
use IosBuild\IosBuild;
use IosBuild\IosBuildInterface;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

#[CoversClass(Ios::class)]
final class IosTest extends TestCase
{
    /**
     * @throws Exception
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     */
    #[DataProvider('providerVersion')]
    public function testTestdetectVersion(string $useragent, string | null $expectedVersion): void
    {
        $object = new Ios(new VersionBuilder(), new IosBuild());

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array<int, array<int, string|null>>
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerVersion(): array
    {
        return [
            [
                'Mozilla/5.0 (iPod; U; CPU like Mac OS X; de-de) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3',
                '1.0.0',
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 8_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) CriOS/42.0.2311.47 Mobile/12B401 Safari/600.1.4',
                '8.1.0',
            ],
            [
                'TestApp/1.0 CFNetwork/808.2.16 Darwin/16.3.0',
                '10.3.0',
            ],
            [
                'Darwin/16.3.0 TestApp/1.0 CFNetwork/808.2.16',
                '10.3.0',
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 7_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) CriOS/42.0.2311.47 Mobile/11D167 Safari/9537.53',
                '7.1.0',
            ],
            [
                'Mozilla/5.0 (iPhone; CPU iPhone OS 10_10 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile Safari/600.1.4',
                '8.0.0',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                null,
            ],
            [
                'AppleCoreMedia/1.0.0.12D5480a (iPad; U; CPU OS 8_2 like Mac OS X; sv_se)',
                '8.2.0-beta+5',
            ],
            [
                'Apple-iPhone3C1/902.206',
                '5.1.1',
            ],
            [
                'Apple-iPhone9C4/1602.92',
                '12.1.0',
            ],
            [
                'Apple-iPhone3C1/902.206 Test',
                null,
            ],
            [
                'Apple-iPhone9C4/1602.92 Test',
                null,
            ],
            [
                'Test Apple-iPhone3C1/902.206',
                null,
            ],
            [
                'Test Apple-iPhone9C4/1602.92',
                null,
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 7_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) CriOS/42.0.2311.47 Mobile/1X7 Safari/9537.53',
                '7.1.0',
            ],
            [
                'AppleCoreMedia/1.0.0.1X7 (iPad; U; CPU OS 8_2 like Mac OS X; sv_se)',
                null,
            ],
            [
                'Outlook-iOS/711.2620504.prod.iphone (3.34.0)',
                null,
            ],
            [
                'com.google.GoogleMobile/46.0.0 iPhone/12.4 hw/iPhone10_4',
                '12.4.0',
            ],
            [
                'iOS/6.1.3 (10B329) dataaccessd/1.0',
                '6.1.3',
            ],
            [
                'Mozilla/5.0 (iPhone; CPU iPhone OS 6_1_3 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Mobile/10B329',
                '6.1.3',
            ],
            [
                'Mozilla/5.0 (iPhone; CPU iPhone OS 4_1_1 like Mac OS X) AppleWebKit/533.17.9 (KHTML, like Gecko) Mobile/10B329',
                '4.1.1',
            ],
            [
                'Mozilla/5.0 (iPod; U; CPU iPhone OS 433 like Mac OS X; zh-CN) AppleWebKit/533.17.9 (KHTML like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5',
                '4.3.3',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/23.0.0',
                '17.0.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/23.1.0',
                '17.1.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/23.2.0',
                '17.2.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/24.0.0',
                '18.0.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/24.1.0',
                '18.1.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/24.2.0',
                '18.2.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/24.3.0',
                '18.3.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/24.4.0',
                '18.4.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/24.5.0',
                '18.5.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/23.3.0',
                '17.3.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/23.4.0',
                '17.4.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/23.5.0',
                '17.5.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/23.6.0',
                '17.6.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/24.6.0',
                '18.6.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/25.0.0',
                '26.0.0',
            ],
            [
                'Darwin/24.5.0 (Watch7,11; watchOS 11.4) MatomoTrackerSDK/7.7.0',
                '11.4.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/25.1.0',
                '26.1.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/25.2.0',
                '26.2.0',
            ],
            [
                'com.apple.WebKit.Networking/8616.2.9.10.11 CFNetwork/1485 Darwin/25.3.0',
                '26.3.0',
            ],
            [
                'kicktipp-ios 2.2.6 on iPhone3,1 with iOS 7.0.6 at 640x960',
                '7.0.6',
            ],
        ];
    }

    /**
     * @throws UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail(): void
    {
        $useragent = 'iOS/6.1.3 (10B329) dataaccessd/1.0';
        $exception = new NotFoundException('not found');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder
            ->expects(self::never())
            ->method('set');

        $iosBuild = $this->createMock(IosBuildInterface::class);
        $iosBuild
            ->expects(self::once())
            ->method('getVersion')
            ->with('10B329')
            ->willThrowException($exception);

        $object = new Ios($versionBuilder, $iosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail2(): void
    {
        $useragent = 'Mozilla/5.0 (iPod; U; CPU like Mac OS X; de-de) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3';
        $exception = new NotNumericException('not numeric');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('1.0')
            ->willThrowException($exception);

        $iosBuild = $this->createMock(IosBuildInterface::class);
        $iosBuild
            ->expects(self::never())
            ->method('getVersion');

        $object = new Ios($versionBuilder, $iosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail4(): void
    {
        $useragent = 'AppleCoreMedia/1.0.0.12D5480a (iPad; U; CPU OS 8_2 like Mac OS X; sv_se)';
        $exception = new NotNumericException('not numeric');
        $version   = '6.1.3';

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($version)
            ->willThrowException($exception);

        $iosBuild = $this->createMock(IosBuildInterface::class);
        $iosBuild
            ->expects(self::once())
            ->method('getVersion')
            ->with('12D5480a')
            ->willReturn($version);

        $object = new Ios($versionBuilder, $iosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail5(): void
    {
        $useragent = 'TestApp/1.0 CFNetwork/808.2.16 Darwin/16.3.0';
        $exception = new NotNumericException('not numeric');
        $version   = '10.3';

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($version)
            ->willThrowException($exception);

        $iosBuild = $this->createMock(IosBuildInterface::class);
        $iosBuild
            ->expects(self::never())
            ->method('getVersion');

        $object = new Ios($versionBuilder, $iosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail6(): void
    {
        $useragent = 'Apple-iPhone3C1/902.206';
        $exception = new NotNumericException('not numeric');
        $version   = '5.1.1';

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($version)
            ->willThrowException($exception);

        $iosBuild = $this->createMock(IosBuildInterface::class);
        $iosBuild
            ->expects(self::never())
            ->method('getVersion');

        $object = new Ios($versionBuilder, $iosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail7(): void
    {
        $useragent = 'iOS/6.1.3 (10B329) dataaccessd/1.0';
        $exception = new NotNumericException('not numeric');
        $version   = '5.1.1';

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($version)
            ->willThrowException($exception);

        $iosBuild = $this->createMock(IosBuildInterface::class);
        $iosBuild
            ->expects(self::once())
            ->method('getVersion')
            ->with('10B329')
            ->willReturn($version);

        $object = new Ios($versionBuilder, $iosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail8(): void
    {
        $useragent = 'Mozilla/5.0 (iPad; CPU OS 8_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) CriOS/42.0.2311.47 Mobile Safari/600.1.4';
        $exception = new NotNumericException('not numeric');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, Ios::SEARCHES)
            ->willThrowException($exception);
        $versionBuilder
            ->expects(self::never())
            ->method('set');

        $iosBuild = $this->createMock(IosBuildInterface::class);
        $iosBuild
            ->expects(self::never())
            ->method('getVersion');

        $object = new Ios($versionBuilder, $iosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail9(): void
    {
        $useragent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_10 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile Safari/600.1.4';
        $exception = new NotNumericException('not numeric');

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MICRO)
            ->willReturn('10.10');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, Ios::SEARCHES)
            ->willReturn($version);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('8.0.0')
            ->willThrowException($exception);

        $iosBuild = $this->createMock(IosBuildInterface::class);
        $iosBuild
            ->expects(self::never())
            ->method('getVersion');

        $object = new Ios($versionBuilder, $iosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail10(): void
    {
        $useragent = 'AppleCoreMedia/1.0.0.12D5480a (iPad; U; CPU OS 8_2 like Mac OS X; sv_se)';
        $exception = new NotFoundException('not numeric');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder
            ->expects(self::never())
            ->method('set');

        $iosBuild = $this->createMock(IosBuildInterface::class);
        $iosBuild
            ->expects(self::once())
            ->method('getVersion')
            ->with('12D5480a')
            ->willThrowException($exception);

        $object = new Ios($versionBuilder, $iosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testDetectVersionFail11(): void
    {
        $useragent = 'Mozilla/5.0 (iPod; U; CPU iPhone OS 433 like Mac OS X; zh-CN) AppleWebKit/533.17.9 (KHTML like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5';
        $exception = new NotNumericException('not numeric');

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::exactly(2))
            ->method('getVersion')
            ->willReturnMap(
                [
                    [VersionInterface::IGNORE_MICRO, '433.0'],
                    [VersionInterface::IGNORE_MINOR, '433'],
                ],
            );

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, Ios::SEARCHES)
            ->willReturn($version);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('4.3.3')
            ->willThrowException($exception);

        $iosBuild = $this->createMock(IosBuildInterface::class);
        $iosBuild
            ->expects(self::never())
            ->method('getVersion');

        $object = new Ios($versionBuilder, $iosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }
}
