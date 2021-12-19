<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\Macos;
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use Exception;
use MacosBuild\MacosBuild;
use MacosBuild\MacosBuildInterface;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UnexpectedValueException;

final class MacosTest extends TestCase
{
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     *
     * @dataProvider providerVersion
     */
    public function testTestdetectVersion(string $useragent, ?string $expectedVersion): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new Macos($logger, new VersionFactory(), new MacosBuild());

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function providerVersion(): array
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
        ];
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFail(): void
    {
        $useragent = 'Downcast/2.9.11 (Mac OS X Version 10.11.3 (Build 15D13b))';
        $exception = new NotNumericException('not numeric');
        $version   = '10.11.3-beta+2';

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with($version)
            ->willThrowException($exception);

        $macosBuild = $this->getMockBuilder(MacosBuildInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $macosBuild
            ->expects(self::once())
            ->method('getVersion')
            ->with('15D13b')
            ->willReturn($version);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception);
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new Macos($logger, $versionFactory, $macosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFail2(): void
    {
        $useragent = 'Apple Mac OS X v10.6.8 CoreMedia v1.0.4.10K540';
        $exception = new NotNumericException('not numeric');
        $version   = '10.11.3-beta+2';

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with($version)
            ->willThrowException($exception);

        $macosBuild = $this->getMockBuilder(MacosBuildInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $macosBuild
            ->expects(self::once())
            ->method('getVersion')
            ->with('10K540')
            ->willReturn($version);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception);
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new Macos($logger, $versionFactory, $macosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFail3(): void
    {
        $useragent = 'Mail/3445.1.3 CFNetwork/887 Darwin/17.0.0 (x86_64)';
        $exception = new NotNumericException('not numeric');
        $version   = '10.13.0';

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with($version)
            ->willThrowException($exception);

        $macosBuild = $this->getMockBuilder(MacosBuildInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $macosBuild
            ->expects(self::never())
            ->method('getVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception);
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new Macos($logger, $versionFactory, $macosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFail4(): void
    {
        $useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10102) AppleWebKit/640.3.18 (KHTML like Gecko) Version/10.0.2 Safari/640.3.18';
        $exception = new NotNumericException('not numeric');
        $version   = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn('10102');

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, Macos::SEARCHES)
            ->willReturn($version);
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('10.10.2')
            ->willThrowException($exception);

        $macosBuild = $this->getMockBuilder(MacosBuildInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $macosBuild
            ->expects(self::never())
            ->method('getVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception);
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new Macos($logger, $versionFactory, $macosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFail5(): void
    {
        $useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 1084) AppleWebKit/536.29.13 (KHTML like Gecko) Version/6.0.4 Safari/536.29.13';
        $exception = new NotNumericException('not numeric');
        $version   = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn('1084');

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('detectVersion')
            ->with($useragent, Macos::SEARCHES)
            ->willReturn($version);
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('10.8.4')
            ->willThrowException($exception);

        $macosBuild = $this->getMockBuilder(MacosBuildInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $macosBuild
            ->expects(self::never())
            ->method('getVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception);
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new Macos($logger, $versionFactory, $macosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }

    /**
     * @throws UnexpectedValueException
     */
    public function testDetectVersionFail6(): void
    {
        $useragent = 'QuickTime/7.6 (qtver=7.6;cpu=IA32;os=Mac 10,5,7)';
        $exception = new NotNumericException('not numeric');
        $version   = $this->getMockBuilder(VersionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $version
            ->expects(self::never())
            ->method('getVersion');

        $versionFactory = $this->getMockBuilder(VersionFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $versionFactory
            ->expects(self::once())
            ->method('detectVersion')
            ->with('QuickTime/7.6 (qtver=7.6;cpu=IA32;os=Mac 10.5.7)', Macos::SEARCHES)
            ->willThrowException($exception);
        $versionFactory
            ->expects(self::never())
            ->method('set');

        $macosBuild = $this->getMockBuilder(MacosBuildInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $macosBuild
            ->expects(self::never())
            ->method('getVersion');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception);
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $object = new Macos($logger, $versionFactory, $macosBuild);

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertInstanceOf(NullVersion::class, $detectedVersion);
    }
}
