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
use Stringable;
use UaDeviceType\TypeInterface;
use UaDeviceType\TypeLoaderInterface;
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

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

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

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

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
    public function testInvokeVersionAndPlatform(): void
    {
        $typeException     = new \UaDeviceType\Exception\NotFoundException('type');
        $companyException1 = new NotFoundException('type');
        $companyException2 = new NotFoundException('type');

        $logger  = $this->createMock(LoggerInterface::class);
        $matcher = self::exactly(3);
        $logger
            ->expects($matcher)
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($matcher, $typeException, $companyException1, $companyException2): void {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame($typeException, $message, (string) $invocation),
                        2 => self::assertSame($companyException1, $message, (string) $invocation),
                        default => self::assertSame($companyException2, $message, (string) $invocation),
                    };

                    self::assertSame([], $context, (string) $invocation);
                },
            );
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
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $matcher       = self::exactly(2);
        $companyLoader
            ->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key) use ($matcher, $companyException1, $companyException2): array {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('unknown1', $key, (string) $invocation),
                        default => self::assertSame('unknown2', $key, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => throw $companyException1,
                        default => throw $companyException2,
                    };
                },
            );

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willThrowException($typeException);

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

        $result = $object->load('test-key');

        $expected = [
            'deviceName' => 'test-device',
            'marketingName' => 'test-device-name',
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'display' => [
                'width' => null,
                'height' => null,
                'touch' => null,
                'size' => null,
            ],
            'type' => 'unknown',
            'dualOrientation' => null,
            'simCount' => null,
        ];

        self::assertArrayHasKey('os', $result);
        self::assertArrayHasKey('device', $result);

        self::assertSame('test-platform', $result['os']);

        self::assertSame($expected, $result['device']->toArray());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeVersionAndPlatform2(): void
    {
        $typeException     = new \UaDeviceType\Exception\NotFoundException('type');
        $companyException1 = new NotFoundException('type');
        $companyException2 = new NotFoundException('type');

        $logger  = $this->createMock(LoggerInterface::class);
        $matcher = self::exactly(3);
        $logger
            ->expects($matcher)
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($matcher, $typeException, $companyException1, $companyException2): void {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame($typeException, $message, (string) $invocation),
                        2 => self::assertSame($companyException1, $message, (string) $invocation),
                        default => self::assertSame($companyException2, $message, (string) $invocation),
                    };

                    self::assertSame([], $context, (string) $invocation);
                },
            );
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
            'type' => 12,
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
        $matcher       = self::exactly(2);
        $companyLoader
            ->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key) use ($matcher, $companyException1, $companyException2): array {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('unknown1', $key, (string) $invocation),
                        default => self::assertSame('unknown2', $key, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => throw $companyException1,
                        default => throw $companyException2,
                    };
                },
            );

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('12')
            ->willThrowException($typeException);

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

        $result = $object->load('test-key');

        $expected = [
            'deviceName' => 'test-device',
            'marketingName' => 'test-device-name',
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'display' => [
                'width' => null,
                'height' => null,
                'touch' => null,
                'size' => null,
            ],
            'type' => 'unknown',
            'dualOrientation' => null,
            'simCount' => null,
        ];

        self::assertArrayHasKey('os', $result);
        self::assertArrayHasKey('device', $result);

        self::assertSame('test-platform', $result['os']);

        self::assertSame($expected, $result['device']->toArray());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeVersionAndPlatform3(): void
    {
        $typeException     = new \UaDeviceType\Exception\NotFoundException('type');
        $companyException1 = new NotFoundException('type');
        $companyException2 = new NotFoundException('type');

        $logger  = $this->createMock(LoggerInterface::class);
        $matcher = self::exactly(3);
        $logger
            ->expects($matcher)
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($matcher, $typeException, $companyException1, $companyException2): void {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame($typeException, $message, (string) $invocation),
                        2 => self::assertSame($companyException1, $message, (string) $invocation),
                        default => self::assertSame($companyException2, $message, (string) $invocation),
                    };

                    self::assertSame([], $context, (string) $invocation);
                },
            );
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
            'type' => 12,
            'deviceName' => 'test-device',
            'marketingName' => '',
            'platform' => 'test-platform',
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $matcher       = self::exactly(2);
        $companyLoader
            ->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key) use ($matcher, $companyException1, $companyException2): array {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('unknown1', $key, (string) $invocation),
                        default => self::assertSame('unknown2', $key, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => throw $companyException1,
                        default => throw $companyException2,
                    };
                },
            );

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('12')
            ->willThrowException($typeException);

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

        $result = $object->load('test-key');

        $expected = [
            'deviceName' => 'test-device',
            'marketingName' => null,
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'display' => [
                'width' => null,
                'height' => null,
                'touch' => null,
                'size' => null,
            ],
            'type' => 'unknown',
            'dualOrientation' => null,
            'simCount' => null,
        ];

        self::assertArrayHasKey('os', $result);
        self::assertArrayHasKey('device', $result);

        self::assertSame('test-platform', $result['os']);

        self::assertSame($expected, $result['device']->toArray());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeVersionAndPlatform4(): void
    {
        $typeException     = new \UaDeviceType\Exception\NotFoundException('type');
        $companyException1 = new NotFoundException('type');
        $companyException2 = new NotFoundException('type');

        $logger  = $this->createMock(LoggerInterface::class);
        $matcher = self::exactly(3);
        $logger
            ->expects($matcher)
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($matcher, $typeException, $companyException1, $companyException2): void {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame($typeException, $message, (string) $invocation),
                        2 => self::assertSame($companyException1, $message, (string) $invocation),
                        default => self::assertSame($companyException2, $message, (string) $invocation),
                    };

                    self::assertSame([], $context, (string) $invocation);
                },
            );
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
            'type' => 12,
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
        $matcher       = self::exactly(2);
        $companyLoader
            ->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key) use ($matcher, $companyException1, $companyException2): array {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('unknown1', $key, (string) $invocation),
                        default => self::assertSame('unknown2', $key, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => throw $companyException1,
                        default => throw $companyException2,
                    };
                },
            );

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('12')
            ->willThrowException($typeException);

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

        $result = $object->load('test-key');

        $expected = [
            'deviceName' => 'test-device',
            'marketingName' => null,
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'display' => [
                'width' => null,
                'height' => null,
                'touch' => null,
                'size' => null,
            ],
            'type' => 'unknown',
            'dualOrientation' => null,
            'simCount' => null,
        ];

        self::assertArrayHasKey('os', $result);
        self::assertArrayHasKey('device', $result);

        self::assertSame('test-platform', $result['os']);

        self::assertSame($expected, $result['device']->toArray());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeVersionAndPlatform5(): void
    {
        $typeException     = new \UaDeviceType\Exception\NotFoundException('type');
        $companyException1 = new NotFoundException('type');
        $companyException2 = new NotFoundException('type');

        $logger  = $this->createMock(LoggerInterface::class);
        $matcher = self::exactly(3);
        $logger
            ->expects($matcher)
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($matcher, $typeException, $companyException1, $companyException2): void {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame($typeException, $message, (string) $invocation),
                        2 => self::assertSame($companyException1, $message, (string) $invocation),
                        default => self::assertSame($companyException2, $message, (string) $invocation),
                    };

                    self::assertSame([], $context, (string) $invocation);
                },
            );
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
            'deviceName' => '',
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
        $matcher       = self::exactly(2);
        $companyLoader
            ->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key) use ($matcher, $companyException1, $companyException2): array {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('unknown1', $key, (string) $invocation),
                        default => self::assertSame('unknown2', $key, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => throw $companyException1,
                        default => throw $companyException2,
                    };
                },
            );

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willThrowException($typeException);

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

        $result = $object->load('test-key');

        $expected = [
            'deviceName' => null,
            'marketingName' => 'test-device-name',
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'display' => [
                'width' => null,
                'height' => null,
                'touch' => null,
                'size' => null,
            ],
            'type' => 'unknown',
            'dualOrientation' => null,
            'simCount' => null,
        ];

        self::assertArrayHasKey('os', $result);
        self::assertArrayHasKey('device', $result);

        self::assertSame('test-platform', $result['os']);

        self::assertSame($expected, $result['device']->toArray());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeVersionAndPlatform6(): void
    {
        $typeException     = new \UaDeviceType\Exception\NotFoundException('type');
        $companyException1 = new NotFoundException('type');
        $companyException2 = new NotFoundException('type');

        $logger  = $this->createMock(LoggerInterface::class);
        $matcher = self::exactly(3);
        $logger
            ->expects($matcher)
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($matcher, $typeException, $companyException1, $companyException2): void {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame($typeException, $message, (string) $invocation),
                        2 => self::assertSame($companyException1, $message, (string) $invocation),
                        default => self::assertSame($companyException2, $message, (string) $invocation),
                    };

                    self::assertSame([], $context, (string) $invocation);
                },
            );
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
            'deviceName' => null,
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
        $matcher       = self::exactly(2);
        $companyLoader
            ->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key) use ($matcher, $companyException1, $companyException2): array {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('unknown1', $key, (string) $invocation),
                        default => self::assertSame('unknown2', $key, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => throw $companyException1,
                        default => throw $companyException2,
                    };
                },
            );

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willThrowException($typeException);

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

        $result = $object->load('test-key');

        $expected = [
            'deviceName' => null,
            'marketingName' => 'test-device-name',
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'display' => [
                'width' => null,
                'height' => null,
                'touch' => null,
                'size' => null,
            ],
            'type' => 'unknown',
            'dualOrientation' => null,
            'simCount' => null,
        ];

        self::assertArrayHasKey('os', $result);
        self::assertArrayHasKey('device', $result);

        self::assertSame('test-platform', $result['os']);

        self::assertSame($expected, $result['device']->toArray());
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

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

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

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

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

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

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

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

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

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

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

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"display" property is required');
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
    public function testAssertLoad7(): void
    {
        $typeException     = new \UaDeviceType\Exception\NotFoundException('type');
        $companyException1 = new NotFoundException('type');
        $companyException2 = new NotFoundException('type');

        $logger  = $this->createMock(LoggerInterface::class);
        $matcher = self::exactly(3);
        $logger
            ->expects($matcher)
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($matcher, $typeException, $companyException1, $companyException2): void {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame($typeException, $message, (string) $invocation),
                        2 => self::assertSame($companyException1, $message, (string) $invocation),
                        default => self::assertSame($companyException2, $message, (string) $invocation),
                    };

                    self::assertSame([], $context, (string) $invocation);
                },
            );
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
            'platform' => 12,
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $matcher       = self::exactly(2);
        $companyLoader
            ->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key) use ($matcher, $companyException1, $companyException2): array {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        1 => self::assertSame('unknown1', $key, (string) $invocation),
                        default => self::assertSame('unknown2', $key, (string) $invocation),
                    };

                    match ($invocation) {
                        1 => throw $companyException1,
                        default => throw $companyException2,
                    };
                },
            );

        $type = $this->createMock(TypeInterface::class);
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('isMobile');

        $typeLoader = $this->createMock(TypeLoaderInterface::class);
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willThrowException($typeException);

        $object = new DeviceLoader($logger, $initData, $companyLoader, $typeLoader);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"platform" property is required');
        $this->expectExceptionCode(1);

        $object->load('test-key');
    }
}
