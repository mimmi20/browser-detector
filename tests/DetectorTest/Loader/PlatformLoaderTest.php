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
use BrowserDetector\Version\TestFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

use function assert;

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

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new PlatformLoader($logger, $initData, $companyLoader);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');

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

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new PlatformLoader($logger, $initData, $companyLoader);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');

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
            'manufacturer' => 'unknown',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        $company = ['type' => 'unknown'];

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new PlatformLoader($logger, $initData, $companyLoader);

        $result = $object->load('test-key', 'test-ua');

        self::assertIsArray($result);
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
            'manufacturer' => 'unknown',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        $company = ['type' => 'unknown'];

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new PlatformLoader($logger, $initData, $companyLoader);

        $result = $object->load('test-key', 'test-ua');

        self::assertIsArray($result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeGenericVersion(): void
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
            'manufacturer' => 'unknown',
            'name' => 'Mac OS X',
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        $company = ['type' => 'unknown'];

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new PlatformLoader($logger, $initData, $companyLoader);

        $result = $object->load('test-key', 'test/10.12');

        self::assertIsArray($result);

        self::assertSame('macOS', $result['name']);
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
            'manufacturer' => 'unknown',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        $company = ['type' => 'unknown'];

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new PlatformLoader($logger, $initData, $companyLoader);

        $result = $object->load('test-key', 'test/12.0');

        self::assertIsArray($result);
    }
}
