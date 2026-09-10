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

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Helper\Desktop;
use BrowserDetector\Helper\DesktopInterface;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\MobileDeviceInterface;
use BrowserDetector\Helper\Tv;
use BrowserDetector\Helper\TvInterface;
use BrowserDetector\Parser\Device\DarwinParser;
use BrowserDetector\Parser\Device\DarwinParserInterface;
use BrowserDetector\Parser\Device\DesktopParser;
use BrowserDetector\Parser\Device\DesktopParserInterface;
use BrowserDetector\Parser\Device\MobileParser;
use BrowserDetector\Parser\Device\MobileParserInterface;
use BrowserDetector\Parser\Device\TvParser;
use BrowserDetector\Parser\Device\TvParserInterface;
use BrowserDetector\Parser\DeviceParser;
use BrowserDetector\Parser\Helper\RulefileParser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

#[CoversClass(className: DeviceParser::class)]
#[CoversClass(className: DesktopParser::class)]
#[CoversClass(className: TvParser::class)]
#[CoversClass(className: MobileParser::class)]
#[CoversClass(className: DarwinParser::class)]
#[CoversClass(className: RulefileParser::class)]
#[CoversClass(className: Desktop::class)]
#[CoversClass(className: Tv::class)]
#[CoversClass(className: MobileDevice::class)]
final class DeviceParserTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseUnknown(): void
    {
        $company   = 'unknown';
        $key       = 'unknown';
        $useragent = '<device-test>';

        $darwinParser = $this->createMock(DarwinParserInterface::class);
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->createMock(MobileParserInterface::class);
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->createMock(TvParserInterface::class);
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->createMock(DesktopParserInterface::class);
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->createMock(MobileDeviceInterface::class);
        $mobileDevice
            ->expects(self::never())
            ->method('isMobile');

        $tvDevice = $this->createMock(TvInterface::class);
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->createMock(DesktopInterface::class);
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        $deviceParser = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result       = $deviceParser->parse($useragent);

        self::assertSame($key . '=' . $company, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseUnknown2(): void
    {
        $company   = 'unknown';
        $key       = 'unknown';
        $useragent = 'Mozilla/5.0 (compatible; Zollard; Linux)';

        $darwinParser = $this->createMock(DarwinParserInterface::class);
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->createMock(MobileParserInterface::class);
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->createMock(TvParserInterface::class);
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->createMock(DesktopParserInterface::class);
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->createMock(MobileDeviceInterface::class);
        $mobileDevice
            ->expects(self::never())
            ->method('isMobile');

        $tvDevice = $this->createMock(TvInterface::class);
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->createMock(DesktopInterface::class);
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        $deviceParser = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result       = $deviceParser->parse($useragent);

        self::assertSame($key . '=' . $company, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseDarwin(): void
    {
        $key       = 'unknown';
        $useragent = 'test-Darwin';

        $darwinParser = $this->createMock(DarwinParserInterface::class);
        $darwinParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($key);

        $mobileParser = $this->createMock(MobileParserInterface::class);
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->createMock(TvParserInterface::class);
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->createMock(DesktopParserInterface::class);
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->createMock(MobileDeviceInterface::class);
        $mobileDevice
            ->expects(self::never())
            ->method('isMobile');

        $tvDevice = $this->createMock(TvInterface::class);
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->createMock(DesktopInterface::class);
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        $deviceParser = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result       = $deviceParser->parse($useragent);

        self::assertSame($key, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseMobile(): void
    {
        $key       = 'unknown';
        $useragent = 'test-device';

        $darwinParser = $this->createMock(DarwinParserInterface::class);
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->createMock(MobileParserInterface::class);
        $mobileParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($key);

        $tvParser = $this->createMock(TvParserInterface::class);
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->createMock(DesktopParserInterface::class);
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->createMock(MobileDeviceInterface::class);
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(value: true);

        $tvDevice = $this->createMock(TvInterface::class);
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->createMock(DesktopInterface::class);
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        $deviceParser = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result       = $deviceParser->parse($useragent);

        self::assertSame($key, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseTv(): void
    {
        $key       = 'unknown';
        $useragent = 'test-device';

        $darwinParser = $this->createMock(DarwinParserInterface::class);
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->createMock(MobileParserInterface::class);
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->createMock(TvParserInterface::class);
        $tvParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($key);

        $desktopParser = $this->createMock(DesktopParserInterface::class);
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->createMock(MobileDeviceInterface::class);
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(value: false);

        $tvDevice = $this->createMock(TvInterface::class);
        $tvDevice
            ->expects(self::once())
            ->method('isTvDevice')
            ->willReturn(value: true);

        $desktopDevice = $this->createMock(DesktopInterface::class);
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        $deviceParser = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result       = $deviceParser->parse($useragent);

        self::assertSame($key, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseDesktop(): void
    {
        $key       = 'unknown';
        $useragent = 'FreeBSD Darwin';

        $darwinParser = $this->createMock(DarwinParserInterface::class);
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->createMock(MobileParserInterface::class);
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->createMock(TvParserInterface::class);
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->createMock(DesktopParserInterface::class);
        $desktopParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($key);

        $mobileDevice = $this->createMock(MobileDeviceInterface::class);
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(value: false);

        $tvDevice = $this->createMock(TvInterface::class);
        $tvDevice
            ->expects(self::once())
            ->method('isTvDevice')
            ->willReturn(value: false);

        $desktopDevice = $this->createMock(DesktopInterface::class);
        $desktopDevice
            ->expects(self::once())
            ->method('isDesktopDevice')
            ->willReturn(value: true);

        $deviceParser = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result       = $deviceParser->parse($useragent);

        self::assertSame($key, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseFallback(): void
    {
        $company   = 'unknown';
        $key       = 'unknown';
        $useragent = 'test-device';

        $darwinParser = $this->createMock(DarwinParserInterface::class);
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->createMock(MobileParserInterface::class);
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->createMock(TvParserInterface::class);
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->createMock(DesktopParserInterface::class);
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->createMock(MobileDeviceInterface::class);
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(value: false);

        $tvDevice = $this->createMock(TvInterface::class);
        $tvDevice
            ->expects(self::once())
            ->method('isTvDevice')
            ->willReturn(value: false);

        $desktopDevice = $this->createMock(DesktopInterface::class);
        $desktopDevice
            ->expects(self::once())
            ->method('isDesktopDevice')
            ->willReturn(value: false);

        $deviceParser = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result       = $deviceParser->parse($useragent);

        self::assertSame($key . '=' . $company, $result);
    }
}
