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
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\LoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetector\Version\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;
use Psr\Log\NullLogger;
use UaResult\Company\CompanyInterface;
use UaResult\Os\OsInterface;

final class PlatformLoaderTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvokeNotInCache(): void
    {
        self::markTestIncomplete();
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

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var Data $initData */
        $object = new PlatformLoader(
            $logger,
            $companyLoader,
            $initData
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');

        $object('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeNullInCache(): void
    {
        self::markTestIncomplete();
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

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var Data $initData */
        $object = new PlatformLoader(
            $logger,
            $companyLoader,
            $initData
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');

        $object('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeNoVersion(): void
    {
        self::markTestIncomplete();
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

        $platformData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'Unknown',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($platformData));

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn($company);

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var Data $initData */
        $object = new PlatformLoader(
            $logger,
            $companyLoader,
            $initData
        );

        $result = $object('test-key', 'test-ua');

        self::assertInstanceOf(OsInterface::class, $result);
    }

    /**
     * @return void
     */
    public function testInvokeVersionSet(): void
    {
        self::markTestIncomplete();
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

        $platformData = (object) [
            'version' => (object) ['class' => null, 'value' => '1.0'],
            'manufacturer' => 'Unknown',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($platformData));

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn($company);

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var Data $initData */
        $object = new PlatformLoader(
            $logger,
            $companyLoader,
            $initData
        );

        $result = $object('test-key', 'test-ua');

        self::assertInstanceOf(OsInterface::class, $result);
    }

    /**
     * @return void
     */
    public function testInvokeGenericVersion(): void
    {
        self::markTestIncomplete();
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

        $platformData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'Unknown',
            'name' => 'Mac OS X',
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($platformData));

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn($company);

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var Data $initData */
        $object = new PlatformLoader(
            $logger,
            $companyLoader,
            $initData
        );

        $result = $object('test-key', 'test/10.12');

        self::assertInstanceOf(OsInterface::class, $result);

        self::assertSame('macOS', $result->getName());
    }

    /**
     * @return void
     */
    public function testInvokeVersion(): void
    {
        self::markTestIncomplete();
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

        $platformData = (object) [
            'version' => (object) ['class' => Test::class],
            'manufacturer' => 'Unknown',
            'name' => null,
            'marketingName' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($platformData));

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn($company);

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var Data $initData */
        $object = new PlatformLoader(
            $logger,
            $companyLoader,
            $initData
        );

        $result = $object('test-key', 'test/12.0');

        self::assertInstanceOf(OsInterface::class, $result);
    }
}
