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
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\LoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Version\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use UaBrowserType\TypeLoader;
use UaBrowserType\Unknown;
use UaResult\Browser\BrowserInterface;
use UaResult\Company\Company;
use UaResult\Company\CompanyInterface;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

class BrowserLoaderTest extends TestCase
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
            ->willReturn(false);

        $initData
            ->expects(self::never())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue(false));

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $companyLoader
            ->expects(self::never())
            ->method('load');

        $typeLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $typeLoader
            ->expects(self::never())
            ->method('load');

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $engineParser
            ->expects(self::never())
            ->method('load');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineParser,
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

        $typeLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $typeLoader
            ->expects(self::never())
            ->method('load');

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $engineParser
            ->expects(self::never())
            ->method('load');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineParser,
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

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn($company);

        $typeLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $engineParser
            ->expects(self::never())
            ->method('load');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineParser,
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
        self::markTestIncomplete();
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()

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

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn($company);

        $typeLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with('unknown', 'test/1.0')
            ->willThrowException(new NotFoundException('engine not found'));

        $engineParser
            ->expects(self::once())
            ->method('init');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineParser,
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
        self::markTestIncomplete();
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()

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

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn($company);

        $typeLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with('unknown', 'test/1.0')
            ->willThrowException(new NotFoundException('engine key not found'));

        $engineParser
            ->expects(self::once())
            ->method('init');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineParser,
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

        $companyLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $company = $this->createMock(CompanyInterface::class);

        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn($company);

        $typeLoader = $this->getMockBuilder(LoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();

        $engine = $this->createMock(EngineInterface::class);

        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with('unknown', 'test/1.0')
            ->willReturn($engine);

        $engineParser
            ->expects(self::once())
            ->method('init');

        /** @var NullLogger $logger */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $companyLoader,
            $typeLoader,
            $engineParser,
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
