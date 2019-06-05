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

use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use UaResult\Company\CompanyInterface;
use UaResult\Engine\EngineInterface;

final class EngineLoaderTest extends TestCase
{
    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
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
            ->will(static::throwException(new InvalidArgumentException('fail')));

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $companyLoader
            ->expects(static::never())
            ->method('load');

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Loader\Helper\DataInterface $initData */
        $object = new EngineLoader(
            $logger,
            $initData,
            $companyLoader
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the engine with key "test-key" was not found');

        $object->load('test-key', 'test-ua');
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
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

        $companyLoader
            ->expects(static::never())
            ->method('load');

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Loader\Helper\DataInterface $initData */
        $object = new EngineLoader(
            $logger,
            $initData,
            $companyLoader
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the engine with key "test-key" was not found');

        $object->load('test-key', 'test-ua');
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
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

        $engineData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'unknown',
            'name' => null,
        ];

        $initData
            ->expects(static::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($engineData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(static::exactly(2))
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \BrowserDetector\Loader\CompanyLoader $companyLoader */
        /** @var \BrowserDetector\Loader\Helper\DataInterface $initData */
        $object = new EngineLoader(
            $logger,
            $initData,
            $companyLoader
        );

        $result = $object->load('test-key', 'test-ua');

        static::assertInstanceOf(EngineInterface::class, $result);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testInvokeGenericVersion(): void
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

        $engineData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'unknown',
            'name' => null,
        ];

        $initData
            ->expects(static::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($engineData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(static::exactly(2))
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var DataInterface $initData */
        $object = new EngineLoader(
            $logger,
            $initData,
            $companyLoader
        );

        $result = $object->load('test-key', 'test-ua');

        static::assertInstanceOf(EngineInterface::class, $result);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testInvokeVersion(): void
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

        $engineData = (object) [
            'version' => (object) ['class' => Test::class],
            'manufacturer' => 'unknown',
            'name' => null,
        ];

        $initData
            ->expects(static::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($engineData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(static::exactly(2))
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var DataInterface $initData */
        $object = new EngineLoader(
            $logger,
            $initData,
            $companyLoader
        );

        $result = $object->load('test-key', 'test-ua');

        static::assertInstanceOf(EngineInterface::class, $result);
    }
}
