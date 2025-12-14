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
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

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

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa')]
    public function testParse(string $ua, string $expected): void
    {
        $logger = $this->createMock(LoggerInterface::class);
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

        $fileParser    = new RulefileParser(logger: $logger);
        $darwinParser  = new DarwinParser(fileParser: $fileParser);
        $mobileParser  = new MobileParser(fileParser: $fileParser);
        $tvParser      = new TvParser(fileParser: $fileParser);
        $desktopParser = new DesktopParser(fileParser: $fileParser);

        $object = new DeviceParser(
            darwinParser: $darwinParser,
            mobileParser: $mobileParser,
            tvParser: $tvParser,
            desktopParser: $desktopParser,
            mobileDevice: new MobileDevice(),
            tvDevice: new Tv(),
            desktopDevice: new Desktop(),
        );
        $result = $object->parse($ua);

        self::assertSame($expected, $result);
    }

    /**
     * @return array<int, array<int, mixed>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            [
                'Mozilla/5.0 (iPhone; CPU iPhone OS 15_1_1 like Mac OS X; zh-CN) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/19B81 UCBrowser/13.7.2.1636 Mobile AliApp(TUnionSDK/0.1.20.4) dv(iPh14,5);pr(UCBrowser/13.7.2.1636);ov(15_1_1);ss(390x844);bt(UC);pm(0);bv(0);nm(0);im(0);nt(1);',
                'apple=apple iphone 14,5',
            ],
            [
                'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 [FBAN/FBIOS;FBDV/iPhone9,3;FBMD/iPhone;FBSN/iOS;FBSV/13.2.3;FBSS/2;FBID/phone;FBLC/hu_HU;FBOP/5;FBCR/Telenor HU]',
                'apple=apple iphone 9,3',
            ],
        ];
    }
}
