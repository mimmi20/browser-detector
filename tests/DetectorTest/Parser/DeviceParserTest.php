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

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Helper\DesktopInterface;
use BrowserDetector\Helper\MobileDeviceInterface;
use BrowserDetector\Helper\TvInterface;
use BrowserDetector\Parser\Device\DarwinParserInterface;
use BrowserDetector\Parser\Device\DesktopParserInterface;
use BrowserDetector\Parser\Device\MobileParserInterface;
use BrowserDetector\Parser\Device\TvParserInterface;
use BrowserDetector\Parser\DeviceParser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceParser::class)]
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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::never())
            ->method('isMobile');

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        $object = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result = $object->parse($useragent);

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::never())
            ->method('isMobile');

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        $object = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result = $object->parse($useragent);

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($key);

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::never())
            ->method('isMobile');

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        $object = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result = $object->parse($useragent);

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($key);

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(true);

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        $object = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result = $object->parse($useragent);

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($key);

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(false);

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::once())
            ->method('isTvDevice')
            ->willReturn(true);

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        $object = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result = $object->parse($useragent);

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($key);

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(false);

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::once())
            ->method('isTvDevice')
            ->willReturn(false);

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::once())
            ->method('isDesktopDevice')
            ->willReturn(true);

        $object = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result = $object->parse($useragent);

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(false);

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::once())
            ->method('isTvDevice')
            ->willReturn(false);

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::once())
            ->method('isDesktopDevice')
            ->willReturn(false);

        $object = new DeviceParser(
            $darwinParser,
            $mobileParser,
            $tvParser,
            $desktopParser,
            $mobileDevice,
            $tvDevice,
            $desktopDevice,
        );
        $result = $object->parse($useragent);

        self::assertSame($key . '=' . $company, $result);
    }
}
