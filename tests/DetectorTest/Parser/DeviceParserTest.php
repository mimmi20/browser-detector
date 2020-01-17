<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Parser;

use BrowserDetector\Helper\DesktopInterface;
use BrowserDetector\Helper\MobileDeviceInterface;
use BrowserDetector\Helper\TvInterface;
use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Loader\DeviceLoaderInterface;
use BrowserDetector\Parser\Device\DarwinParserInterface;
use BrowserDetector\Parser\Device\DesktopParserInterface;
use BrowserDetector\Parser\Device\MobileParserInterface;
use BrowserDetector\Parser\Device\TvParserInterface;
use BrowserDetector\Parser\DeviceParser;
use PHPUnit\Framework\TestCase;

final class DeviceParserTest extends TestCase
{
    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testInvokeUnknown(): void
    {
        $company    = 'unknown';
        $key        = 'unknown';
        $useragent  = '<device-test>';
        $testResult = ['test-result'];

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

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('load')
            ->with($key, $useragent)
            ->willReturn($testResult);

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($company)
            ->willReturn($loader);

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

        /** @var \BrowserDetector\Parser\Device\DarwinParserInterface $darwinParser */
        /** @var \BrowserDetector\Parser\Device\MobileParserInterface $mobileParser */
        /** @var \BrowserDetector\Parser\Device\TvParserInterface $tvParser */
        /** @var \BrowserDetector\Parser\Device\DesktopParserInterface $desktopParser */
        /** @var \BrowserDetector\Loader\DeviceLoaderFactoryInterface $loaderFactory */
        /** @var \BrowserDetector\Helper\MobileDeviceInterface $mobileDevice */
        /** @var \BrowserDetector\Helper\TvInterface $tvDevice */
        /** @var \BrowserDetector\Helper\DesktopInterface $desktopDevice */
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($testResult, $result);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testInvokeUnknown2(): void
    {
        $company    = 'unknown';
        $key        = 'unknown';
        $useragent  = 'Mozilla/5.0 (compatible; Zollard; Linux)';
        $testResult = ['test-result'];

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

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('load')
            ->with($key, $useragent)
            ->willReturn($testResult);

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($company)
            ->willReturn($loader);

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

        /** @var \BrowserDetector\Parser\Device\DarwinParserInterface $darwinParser */
        /** @var \BrowserDetector\Parser\Device\MobileParserInterface $mobileParser */
        /** @var \BrowserDetector\Parser\Device\TvParserInterface $tvParser */
        /** @var \BrowserDetector\Parser\Device\DesktopParserInterface $desktopParser */
        /** @var \BrowserDetector\Loader\DeviceLoaderFactoryInterface $loaderFactory */
        /** @var \BrowserDetector\Helper\MobileDeviceInterface $mobileDevice */
        /** @var \BrowserDetector\Helper\TvInterface $tvDevice */
        /** @var \BrowserDetector\Helper\DesktopInterface $desktopDevice */
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($testResult, $result);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testInvokeDarwin(): void
    {
        $useragent  = 'test-darwin';
        $testResult = ['test-result'];

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($testResult);

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

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::never())
            ->method('load');

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke');

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

        /** @var \BrowserDetector\Parser\Device\DarwinParserInterface $darwinParser */
        /** @var \BrowserDetector\Parser\Device\MobileParserInterface $mobileParser */
        /** @var \BrowserDetector\Parser\Device\TvParserInterface $tvParser */
        /** @var \BrowserDetector\Parser\Device\DesktopParserInterface $desktopParser */
        /** @var \BrowserDetector\Loader\DeviceLoaderFactoryInterface $loaderFactory */
        /** @var \BrowserDetector\Helper\MobileDeviceInterface $mobileDevice */
        /** @var \BrowserDetector\Helper\TvInterface $tvDevice */
        /** @var \BrowserDetector\Helper\DesktopInterface $desktopDevice */
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($testResult, $result);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testInvokeMobile(): void
    {
        $useragent  = 'test-device';
        $testResult = ['test-result'];

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
            ->willReturn($testResult);

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

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::never())
            ->method('load');

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke');

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

        /** @var \BrowserDetector\Parser\Device\DarwinParserInterface $darwinParser */
        /** @var \BrowserDetector\Parser\Device\MobileParserInterface $mobileParser */
        /** @var \BrowserDetector\Parser\Device\TvParserInterface $tvParser */
        /** @var \BrowserDetector\Parser\Device\DesktopParserInterface $desktopParser */
        /** @var \BrowserDetector\Loader\DeviceLoaderFactoryInterface $loaderFactory */
        /** @var \BrowserDetector\Helper\MobileDeviceInterface $mobileDevice */
        /** @var \BrowserDetector\Helper\TvInterface $tvDevice */
        /** @var \BrowserDetector\Helper\DesktopInterface $desktopDevice */
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($testResult, $result);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testInvokeTv(): void
    {
        $useragent  = 'test-device';
        $testResult = ['test-result'];

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
            ->willReturn($testResult);

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::never())
            ->method('load');

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke');

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

        /** @var \BrowserDetector\Parser\Device\DarwinParserInterface $darwinParser */
        /** @var \BrowserDetector\Parser\Device\MobileParserInterface $mobileParser */
        /** @var \BrowserDetector\Parser\Device\TvParserInterface $tvParser */
        /** @var \BrowserDetector\Parser\Device\DesktopParserInterface $desktopParser */
        /** @var \BrowserDetector\Loader\DeviceLoaderFactoryInterface $loaderFactory */
        /** @var \BrowserDetector\Helper\MobileDeviceInterface $mobileDevice */
        /** @var \BrowserDetector\Helper\TvInterface $tvDevice */
        /** @var \BrowserDetector\Helper\DesktopInterface $desktopDevice */
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($testResult, $result);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testInvokeDesktop(): void
    {
        $useragent  = 'test-device';
        $testResult = ['test-result'];

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
            ->willReturn($testResult);

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::never())
            ->method('load');

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke');

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

        /** @var \BrowserDetector\Parser\Device\DarwinParserInterface $darwinParser */
        /** @var \BrowserDetector\Parser\Device\MobileParserInterface $mobileParser */
        /** @var \BrowserDetector\Parser\Device\TvParserInterface $tvParser */
        /** @var \BrowserDetector\Parser\Device\DesktopParserInterface $desktopParser */
        /** @var \BrowserDetector\Loader\DeviceLoaderFactoryInterface $loaderFactory */
        /** @var \BrowserDetector\Helper\MobileDeviceInterface $mobileDevice */
        /** @var \BrowserDetector\Helper\TvInterface $tvDevice */
        /** @var \BrowserDetector\Helper\DesktopInterface $desktopDevice */
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($testResult, $result);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testInvokeFallback(): void
    {
        $company    = 'unknown';
        $key        = 'unknown';
        $useragent  = 'test-device';
        $testResult = ['test-result'];

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

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('load')
            ->with($key, $useragent)
            ->willReturn($testResult);

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($company)
            ->willReturn($loader);

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

        /** @var \BrowserDetector\Parser\Device\DarwinParserInterface $darwinParser */
        /** @var \BrowserDetector\Parser\Device\MobileParserInterface $mobileParser */
        /** @var \BrowserDetector\Parser\Device\TvParserInterface $tvParser */
        /** @var \BrowserDetector\Parser\Device\DesktopParserInterface $desktopParser */
        /** @var \BrowserDetector\Loader\DeviceLoaderFactoryInterface $loaderFactory */
        /** @var \BrowserDetector\Helper\MobileDeviceInterface $mobileDevice */
        /** @var \BrowserDetector\Helper\TvInterface $tvDevice */
        /** @var \BrowserDetector\Helper\DesktopInterface $desktopDevice */
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($testResult, $result);
    }
}
