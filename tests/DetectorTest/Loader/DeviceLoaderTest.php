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

namespace BrowserDetectorTest\Loader;

use AssertionError;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\DataInterface;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetector\Version\TestFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;
use UaDeviceType\TypeInterface;
use UaLoader\Exception\NotFoundException;
use UnexpectedValueException;

final class DeviceLoaderTest extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeNotInCache(): void
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(false);
        $initData
            ->expects(self::never())
            ->method('getItem');

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $object->load('test-key');
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeNullInCache(): void
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);
        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn(null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $object->load('test-key');
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testAssertLoad(): void
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'unknown1',
            'brand' => 'unknown2',
            'type' => 'unknown',
            'marketingName' => 'test-device-name',
            'platform' => 'test-platform',
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"deviceName" property is required');
        $this->expectExceptionCode(1);

        $object->load('test-key');
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testAssertLoad2(): void
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'unknown1',
            'brand' => 'unknown2',
            'type' => 'unknown',
            'deviceName' => 'test-device',
            'platform' => 'test-platform',
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"marketingName" property is required');
        $this->expectExceptionCode(1);

        $object->load('test-key');
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testAssertLoad3(): void
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'brand' => 'unknown2',
            'type' => 'unknown',
            'deviceName' => 'test-device',
            'marketingName' => 'test-device-name',
            'platform' => 'test-platform',
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"manufacturer" property is required');
        $this->expectExceptionCode(1);

        $object->load('test-key');
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testAssertLoad4(): void
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'unknown1',
            'type' => 'unknown',
            'deviceName' => 'test-device',
            'marketingName' => 'test-device-name',
            'platform' => 'test-platform',
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"brand" property is required');
        $this->expectExceptionCode(1);

        $object->load('test-key');
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testAssertLoad5(): void
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'unknown1',
            'brand' => 'unknown2',
            'deviceName' => 'test-device',
            'marketingName' => 'test-device-name',
            'platform' => 'test-platform',
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"type" property is required');
        $this->expectExceptionCode(1);

        $object->load('test-key');
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testAssertLoad6(): void
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'unknown1',
            'brand' => 'unknown2',
            'type' => 'unknown',
            'deviceName' => 'test-device',
            'marketingName' => 'test-device-name',
            'platform' => 'test-platform',
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"display" property is required');
        $this->expectExceptionCode(1);

        $object->load('test-key');
    }
}
