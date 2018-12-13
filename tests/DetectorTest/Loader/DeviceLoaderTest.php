<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\LoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\PlatformParserInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use UaDeviceType\TypeLoader;
use UaDeviceType\Unknown;
use UaResult\Company\Company;
use UaResult\Company\CompanyInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

class DeviceLoaderTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvokeNotInCache(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(false));

        $initData
            ->expects(self::never())
            ->method('getItem')
            ->with('test-key')
            ->will(self::throwException(new InvalidArgumentException('fail')));

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $companyLoader
            ->expects(self::never())
            ->method('load');

        $typeLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $typeLoader
            ->expects(self::never())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $platformParser
            ->expects(self::never())
            ->method('load');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var PlatformParserInterface $platformParser */
        /** @var Data $initData */
        $object = new DeviceLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $platformParser,
            $initData
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');

        $object('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeNullInCache(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue(null));

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $companyLoader
            ->expects(self::never())
            ->method('load');

        $typeLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $typeLoader
            ->expects(self::never())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $platformParser
            ->expects(self::never())
            ->method('load');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var PlatformParserInterface $platformParser */
        /** @var Data $initData */
        $object = new DeviceLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $platformParser,
            $initData
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');

        $object('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeNoVersion(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $deviceData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'Unknown',
            'brand' => 'Unknown',
            'type' => 'unknown',
            'platform' => null,
            'deviceName' => null,
            'marketingName' => null,
            'display' => [
                'width' => null,
                'height' => null,
                'touch' => null,
                'type' => null,
            ],
            'dualOrientation' => true,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($deviceData));

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('Unknown')
            ->willReturn($company);

        $typeLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $platformParser
            ->expects(self::never())
            ->method('load');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var PlatformParserInterface $platformParser */
        /** @var Data $initData */
        $object = new DeviceLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $platformParser,
            $initData
        );

        $result = $object('test-key', 'test-ua');

        self::assertInternalType('array', $result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(DeviceInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeGenericVersionAndPlatformException(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
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
            ->expects(self::once())
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $deviceData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'Unknown',
            'brand' => 'Unknown',
            'type' => 'unknown',
            'platform' => 'unknown',
            'deviceName' => null,
            'marketingName' => null,
            'display' => [
                'width' => null,
                'height' => null,
                'touch' => null,
                'type' => null,
            ],
            'dualOrientation' => true,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($deviceData));

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('Unknown')
            ->willReturn($company);

        $typeLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $platformParser
            ->expects(self::once())
            ->method('load')
            ->with('unknown', 'test/1.0')
            ->willThrowException(new NotFoundException('engine not found'));

        $platformParser
            ->expects(self::once())
            ->method('init')
            ->willReturnSelf();

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var PlatformParserInterface $platformParser */
        /** @var Data $initData */
        $object = new DeviceLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $platformParser,
            $initData
        );

        $result = $object('test-key', 'test/1.0');

        self::assertInternalType('array', $result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(DeviceInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeVersionAndPlatform(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $deviceData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'Unknown',
            'brand' => 'Unknown',
            'type' => 'unknown',
            'platform' => 'unknown',
            'deviceName' => 'test-device',
            'marketingName' => null,
            'display' => [
                'width' => null,
                'height' => null,
                'touch' => null,
                'type' => null,
            ],
            'dualOrientation' => true,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($deviceData));

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('Unknown')
            ->willReturn($company);

        $typeLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $os = $this->createMock(OsInterface::class);

        $platformParser
            ->expects(self::once())
            ->method('load')
            ->with('unknown', 'test/1.0')
            ->willReturn($os);

        $platformParser
            ->expects(self::once())
            ->method('init')
            ->willReturnSelf();

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var PlatformParserInterface $platformParser */
        /** @var Data $initData */
        $object = new DeviceLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $platformParser,
            $initData
        );

        $result = $object('test-key', 'test/1.0');

        self::assertInternalType('array', $result);
        self::assertArrayHasKey(0, $result);
        /** @var DeviceInterface $resultDevice */
        $resultDevice = $result[0];
        self::assertInstanceOf(DeviceInterface::class, $resultDevice);
        self::assertArrayHasKey(1, $result);
        /** @var OsInterface $resultPlatform */
        $resultPlatform = $result[1];
        self::assertInstanceOf(OsInterface::class, $resultPlatform);

        self::assertSame('test-device', $resultDevice->getDeviceName());
    }
}
