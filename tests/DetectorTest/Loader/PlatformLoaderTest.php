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
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\TestFactory;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

final class PlatformLoaderTest extends TestCase
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
            ->willThrowException(new InvalidArgumentException('fail'));

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $object->load('test-key', 'test-ua');
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
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $object->load('test-key', 'test-ua');
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

        $platformData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'xyz',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $company = ['type' => 'xyz-type'];

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $result = $object->load('test-key', 'test-ua');

        $expected = [
            'name' => null,
            'marketingName' => null,
            'version' => null,
            'manufacturer' => 'xyz-type',
            'bits' => null,
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeVersionSet(): void
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

        $platformData = (object) [
            'version' => (object) ['class' => null, 'value' => '1.0'],
            'manufacturer' => 'xyz',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $company = ['type' => 'xyz-type'];

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $version = $this->createMock(VersionInterface::class);
        $matcher = self::exactly(2);
        $version
            ->expects($matcher)
            ->method('getVersion')
            ->willReturnCallback(
                static function (int $mode) use ($matcher): string {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame(VersionInterface::IGNORE_MICRO, $mode),
                        default => self::assertSame(VersionInterface::COMPLETE, $mode),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1 => '1.0',
                        default => '1.0.0',
                    };
                },
            );

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('1.0')
            ->willReturn($version);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $result = $object->load('test-key', 'test-ua');

        $expected = [
            'name' => null,
            'marketingName' => null,
            'version' => '1.0.0',
            'manufacturer' => 'xyz-type',
            'bits' => null,
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeGenericVersionForMacos(): void
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

        $platformData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'xyz',
            'name' => 'Mac OS X',
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $company = ['type' => 'xyz-type'];

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $version = $this->createMock(VersionInterface::class);
        $matcher = self::exactly(3);
        $version
            ->expects($matcher)
            ->method('getVersion')
            ->willReturnCallback(
                static function (int $mode) use ($matcher): string {
                    match ($matcher->numberOfInvocations()) {
                        1, 2 => self::assertSame(VersionInterface::IGNORE_MICRO, $mode),
                        default => self::assertSame(VersionInterface::COMPLETE, $mode),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1, 2 => '10.12',
                        default => '10.12.0',
                    };
                },
            );

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::once())
            ->method('detectVersion')
            ->with('test/10.12', ['test'])
            ->willReturn($version);

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $result = $object->load('test-key', 'test/10.12');

        $expected = [
            'name' => 'macOS',
            'marketingName' => 'macOS',
            'version' => '10.12.0',
            'manufacturer' => 'xyz-type',
            'bits' => null,
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeGenericVersionIos(): void
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

        $platformData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'xyz',
            'name' => 'iOS',
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $company = ['type' => 'xyz-type'];

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $version = $this->createMock(VersionInterface::class);
        $matcher = self::exactly(4);
        $version
            ->expects($matcher)
            ->method('getVersion')
            ->willReturnCallback(
                static function (int $mode) use ($matcher): string {
                    match ($matcher->numberOfInvocations()) {
                        1, 2, 3 => self::assertSame(VersionInterface::IGNORE_MICRO, $mode),
                        default => self::assertSame(VersionInterface::COMPLETE, $mode),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1, 2, 3 => '3.0',
                        default => '3.0.0',
                    };
                },
            );

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::once())
            ->method('detectVersion')
            ->with('test/3.0', ['test'])
            ->willReturn($version);

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $result = $object->load('test-key', 'test/3.0');

        $expected = [
            'name' => 'iPhone OS',
            'marketingName' => 'iPhone OS',
            'version' => '3.0.0',
            'manufacturer' => 'xyz-type',
            'bits' => null,
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeVersion(): void
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

        $platformData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'xyz',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $company = ['type' => 'xyz-type'];

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $result = $object->load('test-key', 'test/12.0');

        $expected = [
            'name' => null,
            'marketingName' => null,
            'version' => '1.11.111.1111.11111',
            'manufacturer' => 'xyz-type',
            'bits' => null,
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeVersionWithException(): void
    {
        $exception = new NotFoundException('test');

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception, []);
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

        $platformData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'xyz',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willThrowException($exception);

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $result = $object->load('test-key', 'test/12.0');

        $expected = [
            'name' => null,
            'marketingName' => null,
            'version' => '1.11.111.1111.11111',
            'manufacturer' => 'unknown',
            'bits' => null,
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeNullVersion(): void
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

        $platformData = (object) [
            'version' => null,
            'manufacturer' => 'xyz',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $company = ['type' => 'xyz-type'];

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::never())
            ->method('set');
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $result = $object->load('test-key', 'test/12.0');

        $expected = [
            'name' => null,
            'marketingName' => null,
            'version' => null,
            'manufacturer' => 'xyz-type',
            'bits' => null,
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeStringVersion(): void
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

        $platformData = (object) [
            'version' => '1.0',
            'manufacturer' => 'xyz',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $company = ['type' => 'xyz-type'];

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $version = $this->createMock(VersionInterface::class);
        $matcher = self::exactly(2);
        $version
            ->expects($matcher)
            ->method('getVersion')
            ->willReturnCallback(
                static function (int $mode) use ($matcher): string {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame(VersionInterface::IGNORE_MICRO, $mode),
                        default => self::assertSame(VersionInterface::COMPLETE, $mode),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1 => '1.0',
                        default => '1.0.0',
                    };
                },
            );

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('1.0')
            ->willReturn($version);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $result = $object->load('test-key', 'test/12.0');

        $expected = [
            'name' => null,
            'marketingName' => null,
            'version' => '1.0.0',
            'manufacturer' => 'xyz-type',
            'bits' => null,
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeStringVersionWithException(): void
    {
        $exception = new NotNumericException('test');

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
            ->expects(self::once())
            ->method('error')
            ->with($exception, []);
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

        $platformData = (object) [
            'version' => '1.0',
            'manufacturer' => 'xyz',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $company = ['type' => 'xyz-type'];

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('1.0')
            ->willThrowException($exception);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $result = $object->load('test-key', 'test/12.0');

        $expected = [
            'name' => null,
            'marketingName' => null,
            'version' => null,
            'manufacturer' => 'xyz-type',
            'bits' => null,
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeVersionObject(): void
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

        $platformData = (object) [
            'version' => (object) ['value' => '1.0'],
            'manufacturer' => 'xyz',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $company = ['type' => 'xyz-type'];

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $version = $this->createMock(VersionInterface::class);
        $matcher = self::exactly(2);
        $version
            ->expects($matcher)
            ->method('getVersion')
            ->willReturnCallback(
                static function (int $mode) use ($matcher): string {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame(VersionInterface::IGNORE_MICRO, $mode),
                        default => self::assertSame(VersionInterface::COMPLETE, $mode),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1 => '1.0',
                        default => '1.0.0',
                    };
                },
            );

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('1.0')
            ->willReturn($version);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $result = $object->load('test-key', 'test/12.0');

        $expected = [
            'name' => null,
            'marketingName' => null,
            'version' => '1.0.0',
            'manufacturer' => 'xyz-type',
            'bits' => null,
        ];

        self::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeVersionObjectWithException(): void
    {
        $exception = new NotNumericException('test');

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
            ->expects(self::once())
            ->method('error')
            ->with($exception, []);
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

        $platformData = (object) [
            'version' => (object) ['value' => '1.0'],
            'manufacturer' => 'xyz',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $company = ['type' => 'xyz-type'];

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $versionFactory = $this->createMock(VersionFactoryInterface::class);
        $versionFactory
            ->expects(self::never())
            ->method('setRegex');
        $versionFactory
            ->expects(self::once())
            ->method('set')
            ->with('1.0')
            ->willThrowException($exception);
        $versionFactory
            ->expects(self::never())
            ->method('detectVersion');

        $object = new PlatformLoader($logger, $initData, $companyLoader, $versionFactory);

        $result = $object->load('test-key', 'test/12.0');

        $expected = [
            'name' => null,
            'marketingName' => null,
            'version' => null,
            'manufacturer' => 'xyz-type',
            'bits' => null,
        ];

        self::assertSame($expected, $result);
    }
}
