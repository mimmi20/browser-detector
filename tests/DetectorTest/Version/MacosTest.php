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
use BrowserDetector\Version\Macos;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionInterface;
use Exception;
use MacosBuild\Exception\NotFoundException;
use MacosBuild\MacosBuild;
use MacosBuild\MacosBuildInterface;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

#[CoversClass(Macos::class)]
final class MacosTest extends TestCase
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
        $object = new Macos(new VersionBuilder(), new MacosBuild());

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerVersion(): array
    {
        return [
            [
                'Downcast/2.9.11 (Mac OS X Version 10.11.3 (Build 15D13b))',
                '10.11.3-beta+2',
            ],
            [
                'Mail/3445.1.3 CFNetwork/887 Darwin/17.0.0 (x86_64)',
                '10.13.0',
            ],
            [
                'Darwin/17.0.0 Mail/3445.1.3 CFNetwork/887 (x86_64)',
                '10.13.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10) AppleWebKit/534.48.3 (KHTML like Gecko) Version/5.1 Safari/534.48.3',
                '10.0.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 107) AppleWebKit/534.48.3 (KHTML like Gecko) Version/5.1 Safari/534.48.3',
                '10.7.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 1084) AppleWebKit/536.29.13 (KHTML like Gecko) Version/6.0.4 Safari/536.29.13',
                '10.8.4',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.5.17 (KHTML, like Gecko) Version/8.0.5 Safari/600.5.17',
                '10.10.4',
            ],
            [
                'Apple Mac OS X v10.11.3 CoreMedia v1.0.0.15D13b',
                '10.11.3-beta+2',
            ],
            [
                'Apple Mac OS X v10.11.3 CoreMedia v1.0.0.1X7',
                '10.11.3',
            ],
            [
                'Downcast/2.9.11 (Mac OS X Version 10.11.3 (Build 1X7))',
                '10.11.3',
            ],
            [
                'QuickTime/7.6 (qtver=7.6;cpu=IA32;os=Mac 10,5,7)',
                '10.5.7',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10102) AppleWebKit/640.3.18 (KHTML like Gecko) Version/10.0.2 Safari/640.3.18',
                '10.10.2',
            ],
            [
                'Safari/19616.2.9.11.7 CFNetwork/1485 Darwin/23.0.0',
                '14.0.0',
            ],
            [
                'Safari/19616.2.9.11.7 CFNetwork/1485 Darwin/23.1.0',
                '14.1.0',
            ],
            [
                'Safari/19616.2.9.11.7 CFNetwork/1485 Darwin/23.2.0',
                '14.2.0',
            ],
            [
                'Safari/19616.2.9.11.7 CFNetwork/1485 Darwin/24.0.0',
                '15.0.0',
            ],
            [
                'Safari/19616.2.9.11.7 CFNetwork/1485 Darwin/24.1.0',
                '15.1.0',
            ],
            [
                'Safari/19616.2.9.11.7 CFNetwork/1485 Darwin/24.2.0',
                '15.2.0',
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
        $useragent = 'Downcast/2.9.11 (Mac OS X Version 10.11.3 (Build 15D13b))';
        $exception = new NotNumericException('not numeric');
        $version   = '10.11.3-beta+2';

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($version)
            ->willThrowException($exception);

        $macosBuild = $this->createMock(MacosBuildInterface::class);
        $macosBuild
            ->expects(self::once())
            ->method('getVersion')
            ->with('15D13b')
            ->willReturn($version);

        $object = new Macos($versionBuilder, $macosBuild);

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
        $useragent = 'Apple Mac OS X v10.6.8 CoreMedia v1.0.4.10K540';
        $exception = new NotNumericException('not numeric');
        $version   = '10.11.3-beta+2';

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($version)
            ->willThrowException($exception);

        $macosBuild = $this->createMock(MacosBuildInterface::class);
        $macosBuild
            ->expects(self::once())
            ->method('getVersion')
            ->with('10K540')
            ->willReturn($version);

        $object = new Macos($versionBuilder, $macosBuild);

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
    public function testDetectVersionFail3(): void
    {
        $useragent = 'Mail/3445.1.3 CFNetwork/887 Darwin/17.0.0 (x86_64)';
        $exception = new NotNumericException('not numeric');
        $version   = '10.13.0';

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($version)
            ->willThrowException($exception);

        $macosBuild = $this->createMock(MacosBuildInterface::class);
        $macosBuild
            ->expects(self::never())
            ->method('getVersion');

        $object = new Macos($versionBuilder, $macosBuild);

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
        $useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10102) AppleWebKit/640.3.18 (KHTML like Gecko) Version/10.0.2 Safari/640.3.18';
        $exception = new NotNumericException('not numeric');

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn('10102');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, Macos::SEARCHES)
            ->willReturn($version);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('10.10.2')
            ->willThrowException($exception);

        $macosBuild = $this->createMock(MacosBuildInterface::class);
        $macosBuild
            ->expects(self::never())
            ->method('getVersion');

        $object = new Macos($versionBuilder, $macosBuild);

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
        $useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 1084) AppleWebKit/536.29.13 (KHTML like Gecko) Version/6.0.4 Safari/536.29.13';
        $exception = new NotNumericException('not numeric');

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn('1084');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, Macos::SEARCHES)
            ->willReturn($version);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with('10.8.4')
            ->willThrowException($exception);

        $macosBuild = $this->createMock(MacosBuildInterface::class);
        $macosBuild
            ->expects(self::never())
            ->method('getVersion');

        $object = new Macos($versionBuilder, $macosBuild);

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
        $useragent = 'QuickTime/7.6 (qtver=7.6;cpu=IA32;os=Mac 10,5,7)';
        $exception = new NotNumericException('not numeric');

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::never())
            ->method('getVersion');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('detectVersion')
            ->with('QuickTime/7.6 (qtver=7.6;cpu=IA32;os=Mac 10.5.7)', Macos::SEARCHES)
            ->willThrowException($exception);
        $versionBuilder
            ->expects(self::never())
            ->method('set');

        $macosBuild = $this->createMock(MacosBuildInterface::class);
        $macosBuild
            ->expects(self::never())
            ->method('getVersion');

        $object = new Macos($versionBuilder, $macosBuild);

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
        $useragent = 'Downcast/2.9.11 (Mac OS X Version 10.11.3 (Build 15D13b))';
        $exception = new NotFoundException('not numeric');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent)
            ->willReturn(new NullVersion());
        $versionBuilder
            ->expects(self::never())
            ->method('set');

        $macosBuild = $this->createMock(MacosBuildInterface::class);
        $macosBuild
            ->expects(self::once())
            ->method('getVersion')
            ->with('15D13b')
            ->willThrowException($exception);

        $object = new Macos($versionBuilder, $macosBuild);

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
        $useragent = 'Apple Mac OS X v10.6.8 CoreMedia v1.0.4.10K540';
        $exception = new NotFoundException('not numeric');

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent)
            ->willReturn(new NullVersion());
        $versionBuilder
            ->expects(self::never())
            ->method('set');

        $macosBuild = $this->createMock(MacosBuildInterface::class);
        $macosBuild
            ->expects(self::once())
            ->method('getVersion')
            ->with('10K540')
            ->willThrowException($exception);

        $object = new Macos($versionBuilder, $macosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }
}
