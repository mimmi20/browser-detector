<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\PlatformParserInterface;
use BrowserDetector\Version\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Os\OsInterface;

final class DeviceLoaderTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvokeNotInCache(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $initData
            ->expects(static::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(false);

        $initData
            ->expects(static::never())
            ->method('getItem')
            ->with('test-key')
            ->willReturn(false);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var PlatformParserInterface $platformParser */
        /** @var Data $initData */
        $object = new DeviceLoader(
            $logger,
            $initData,
            $companyLoader,
            $platformParser
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');

        $object->load('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeNullInCache(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $initData
            ->expects(static::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $initData
            ->expects(static::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn(null);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var PlatformParserInterface $platformParser */
        /** @var Data $initData */
        $object = new DeviceLoader(
            $logger,
            $initData,
            $companyLoader,
            $platformParser
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');

        $object->load('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeNoVersion(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $initData
            ->expects(static::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'name' => null,
            'platform' => null,
        ];

        $initData
            ->expects(static::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var PlatformParserInterface $platformParser */
        /** @var Data $initData */
        $object = new DeviceLoader(
            $logger,
            $initData,
            $companyLoader,
            $platformParser
        );

        $result = $object->load('test-key', 'test-ua');

        static::assertIsArray($result);
        static::assertArrayHasKey(0, $result);
        static::assertInstanceOf(DeviceInterface::class, $result[0]);
        static::assertArrayHasKey(1, $result);
        static::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeGenericVersionAndPlatformInvalidException(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::once())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $initData
            ->expects(static::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'name' => null,
            'platform' => 'test-platform',
        ];

        $initData
            ->expects(static::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser->expects(static::once())
            ->method('load')
            ->with('test-platform')
            ->willThrowException(new NotFoundException());

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var PlatformParserInterface $platformParser */
        /** @var Data $initData */
        $object = new DeviceLoader(
            $logger,
            $initData,
            $companyLoader,
            $platformParser
        );

        $result = $object->load('test-key', 'test/1.0');

        static::assertIsArray($result);
        static::assertArrayHasKey(0, $result);
        static::assertInstanceOf(DeviceInterface::class, $result[0]);
        static::assertArrayHasKey(1, $result);
        static::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeVersionAndPlatform(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $initData
            ->expects(static::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['class' => Test::class],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'deviceName' => 'test-device',
            'platform' => 'test-platform',
        ];

        $initData
            ->expects(static::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platform = $this->getMockBuilder(OsInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser->expects(static::once())
            ->method('load')
            ->with('test-platform')
            ->willReturn($platform);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var PlatformParserInterface $platformParser */
        /** @var Data $initData */
        $object = new DeviceLoader(
            $logger,
            $initData,
            $companyLoader,
            $platformParser
        );

        $result = $object->load('test-key', 'test/1.0');

        static::assertIsArray($result);
        static::assertArrayHasKey(0, $result);
        /** @var DeviceInterface $deviceResult */
        $deviceResult = $result[0];
        static::assertInstanceOf(DeviceInterface::class, $deviceResult);

        static::assertArrayHasKey(1, $result);
        /** @var OsInterface $platformResult */
        $platformResult = $result[1];
        static::assertInstanceOf(OsInterface::class, $platformResult);
        static::assertSame($platform, $platformResult);

        static::assertSame('test-device', $deviceResult->getDeviceName());
    }
}
