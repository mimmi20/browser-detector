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
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\TestFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use UaResult\Company\CompanyInterface;
use UaResult\Engine\EngineInterface;
use UnexpectedValueException;

use function assert;

final class EngineLoaderTest extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeNotInCache(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
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
            ->will(self::throwException(new InvalidArgumentException('fail')));

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $companyLoader
            ->expects(self::never())
            ->method('load');

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new EngineLoader($logger, $initData, $companyLoader);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the engine with key "test-key" was not found');

        $object->load('test-key', 'test-ua');
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeNullInCache(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
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

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $companyLoader
            ->expects(self::never())
            ->method('load');

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new EngineLoader($logger, $initData, $companyLoader);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the engine with key "test-key" was not found');

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
        $logger = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $engineData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'unknown',
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($engineData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new EngineLoader($logger, $initData, $companyLoader);

        $result = $object->load('test-key', 'test-ua');

        self::assertInstanceOf(EngineInterface::class, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeGenericVersion(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $engineData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'unknown',
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($engineData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new EngineLoader($logger, $initData, $companyLoader);

        $result = $object->load('test-key', 'test-ua');

        self::assertInstanceOf(EngineInterface::class, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeVersion(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $engineData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'unknown',
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($engineData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($initData instanceof DataInterface);
        $object = new EngineLoader($logger, $initData, $companyLoader);

        $result = $object->load('test-key', 'test-ua');

        self::assertInstanceOf(EngineInterface::class, $result);
    }
}
