<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\TestFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

use function assert;

final class DeviceLoaderTest extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
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
            ->method('getItem')
            ->with('test-key')
            ->willReturn(false);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new DeviceLoader($logger, $initData, $companyLoader);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');

        $object->load('test-key');
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
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

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new DeviceLoader($logger, $initData, $companyLoader);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');

        $object->load('test-key');
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeNoVersion(): void
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
            'version' => (object) ['class' => null],
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'type' => 'unknown',
            'deviceName' => null,
            'marketingName' => null,
            'platform' => null,
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new DeviceLoader($logger, $initData, $companyLoader);

        $result = $object->load('test-key');

        self::assertIsArray($result);
        self::assertArrayHasKey(0, $result);
        self::assertIsArray($result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeGenericVersionAndPlatformInvalidException(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
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
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'type' => 'unknown',
            'deviceName' => null,
            'marketingName' => null,
            'platform' => 'test-platform',
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new DeviceLoader($logger, $initData, $companyLoader);

        $result = $object->load('test-key');

        self::assertIsArray($result);
        self::assertArrayHasKey(0, $result);
        self::assertIsArray($result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertSame('test-platform', $result[1]);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeVersionAndPlatform(): void
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
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'type' => 'unknown',
            'deviceName' => 'test-device',
            'marketingName' => null,
            'platform' => 'test-platform',
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        assert($logger instanceof LoggerInterface);
        assert($initData instanceof DataInterface);
        $object = new DeviceLoader($logger, $initData, $companyLoader);

        $result = $object->load('test-key');

        self::assertIsArray($result);
        self::assertArrayHasKey(0, $result);
        $deviceResult = $result[0];

        self::assertIsArray($deviceResult);

        self::assertArrayHasKey(1, $result);
        self::assertSame('test-platform', $result[1]);

        self::assertSame('test-device', $deviceResult['deviceName']);
    }
}
