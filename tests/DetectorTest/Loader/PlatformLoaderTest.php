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
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetector\Version\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use UaResult\Company\CompanyInterface;
use UaResult\Os\OsInterface;

final class PlatformLoaderTest extends TestCase
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
            ->willReturn(false);

        $initData
            ->expects(self::never())
            ->method('getItem')
            ->with('test-key')
            ->will(self::throwException(new InvalidArgumentException('fail')));

        $initData
            ->expects(self::once())
            ->method('__invoke');

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $companyLoader
            ->expects(self::never())
            ->method('load');

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Loader\Helper\DataInterface $initData */
        $object = new PlatformLoader(
            $logger,
            $initData,
            $companyLoader
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');

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
            ->willReturn(true);

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn(null);

        $initData
            ->expects(self::once())
            ->method('__invoke');

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $companyLoader
            ->expects(self::never())
            ->method('load');

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Loader\Helper\DataInterface $initData */
        $object = new PlatformLoader(
            $logger,
            $initData,
            $companyLoader
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');

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

        $initData
            ->expects(self::once())
            ->method('__invoke');

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Loader\Helper\DataInterface $initData */
        $object = new PlatformLoader(
            $logger,
            $initData,
            $companyLoader
        );

        $result = $object->load('test-key', 'test-ua');

        self::assertInstanceOf(OsInterface::class, $result);
    }

    /**
     * @return void
     */
    public function testInvokeVersionSet(): void
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

        $initData
            ->expects(self::once())
            ->method('__invoke');

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Loader\Helper\DataInterface $initData */
        $object = new PlatformLoader(
            $logger,
            $initData,
            $companyLoader
        );

        $result = $object->load('test-key', 'test-ua');

        self::assertInstanceOf(OsInterface::class, $result);
    }

    /**
     * @return void
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

        $initData
            ->expects(self::once())
            ->method('__invoke');

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Loader\Helper\DataInterface $initData */
        $object = new PlatformLoader(
            $logger,
            $initData,
            $companyLoader
        );

        $result = $object->load('test-key', 'test/10.12');

        self::assertInstanceOf(OsInterface::class, $result);

        self::assertSame('macOS', $result->getName());
    }

    /**
     * @return void
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
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $platformData = (object) [
            'version' => (object) ['class' => Test::class],
            'manufacturer' => 'unknown',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($platformData);

        $initData
            ->expects(self::once())
            ->method('__invoke');

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('unknown')
            ->willReturn($company);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Loader\Helper\DataInterface $initData */
        $object = new PlatformLoader(
            $logger,
            $initData,
            $companyLoader
        );

        $result = $object->load('test-key', 'test/12.0');

        self::assertInstanceOf(OsInterface::class, $result);
    }
}
