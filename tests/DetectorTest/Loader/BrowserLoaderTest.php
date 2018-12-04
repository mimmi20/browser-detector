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

use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\GenericLoader;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use UaBrowserType\TypeLoader;
use UaBrowserType\Unknown;
use UaResult\Browser\BrowserInterface;
use UaResult\Company\Company;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

class BrowserLoaderTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvokeNotInCache(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
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

        $initData = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
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
            ->will(self::returnValue(false));

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::never())
            ->method('load');

        $typeLoader = $this->getMockBuilder(TypeLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $typeLoader
            ->expects(self::never())
            ->method('load');

        $engineLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $engineLoader
            ->expects(self::never())
            ->method('load');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $engineLoader */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineLoader,
            $initData
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the browser with key "test-key" was not found');

        $object('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeNullInCache(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
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

        $initData = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
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

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::never())
            ->method('load');

        $typeLoader = $this->getMockBuilder(TypeLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $typeLoader
            ->expects(self::never())
            ->method('load');

        $engineLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $engineLoader
            ->expects(self::never())
            ->method('load');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $engineLoader */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineLoader,
            $initData
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the browser with key "test-key" was not found');

        $object('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeNoVersion(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
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

        $initData = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $browserData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'Unknown',
            'type' => 'unknown',
            'engine' => null,
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($browserData));

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn(new Company('Unknown'));

        $typeLoader = $this->getMockBuilder(TypeLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $engineLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $engineLoader
            ->expects(self::never())
            ->method('load');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $engineLoader */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineLoader,
            $initData
        );

        $result = $object('test-key', 'test-ua');

        self::assertInternalType('array', $result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(BrowserInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeGenericVersionAndEngineException(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
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
            ->expects(self::once())
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

        $initData = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $browserData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'Unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($browserData));

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn(new Company('Unknown'));

        $typeLoader = $this->getMockBuilder(TypeLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $engineLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load', 'init'])
            ->getMock();

        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown', 'test/1.0')
            ->willThrowException(new NotFoundException('engine not found'));

        $engineLoader
            ->expects(self::once())
            ->method('init');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $engineLoader */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineLoader,
            $initData
        );

        $result = $object('test-key', 'test/1.0');

        self::assertInternalType('array', $result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(BrowserInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeGenericVersionAndEngineInvalidException(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
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
            ->expects(self::once())
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

        $initData = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $browserData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'Unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($browserData));

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn(new Company('Unknown'));

        $typeLoader = $this->getMockBuilder(TypeLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $engineLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load', 'init'])
            ->getMock();

        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown', 'test/1.0')
            ->willThrowException(new NotFoundException('engine key not found'));

        $engineLoader
            ->expects(self::once())
            ->method('init');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $engineLoader */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineLoader,
            $initData
        );

        $result = $object('test-key', 'test/1.0');

        self::assertInternalType('array', $result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(BrowserInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeVersionAndEngine(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
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

        $initData = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $browserData = (object) [
            'version' => (object) ['class' => Test::class],
            'manufacturer' => 'Unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => 'test-browser',
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($browserData));

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn(new Company('Unknown'));

        $typeLoader = $this->getMockBuilder(TypeLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $engineLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load', 'init'])
            ->getMock();

        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown', 'test/1.0')
            ->willReturn(new Engine());

        $engineLoader
            ->expects(self::once())
            ->method('init');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $engineLoader */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineLoader,
            $initData
        );

        $result = $object('test-key', 'test/1.0');

        self::assertInternalType('array', $result);
        self::assertArrayHasKey(0, $result);
        /** @var BrowserInterface $browserResult */
        $browserResult = $result[0];
        self::assertInstanceOf(BrowserInterface::class, $browserResult);
        self::assertArrayHasKey(1, $result);
        /** @var EngineInterface $engineResult */
        $engineResult = $result[1];
        self::assertInstanceOf(EngineInterface::class, $engineResult);

        self:self::assertSame('test-browser', $browserResult->getName());
    }
}
