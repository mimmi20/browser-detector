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

use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Version\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaResult\Browser\BrowserInterface;
use UaResult\Engine\EngineInterface;

final class BrowserLoaderTest extends TestCase
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
            ->willReturn(false);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the browser with key "test-key" was not found');

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

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the browser with key "test-key" was not found');

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

        $browserData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => null,
            'name' => null,
        ];

        $initData
            ->expects(static::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $result = $object->load('test-key', 'test-ua');

        static::assertIsArray($result);
        static::assertArrayHasKey(0, $result);
        static::assertInstanceOf(BrowserInterface::class, $result[0]);
        static::assertArrayHasKey(1, $result);
        static::assertNull($result[1]);
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
    public function testInvokeGenericVersionAndEngineException(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
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

        $browserData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => null,
        ];

        $initData
            ->expects(static::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $result = $object->load('test-key', 'test/1.0');

        static::assertIsArray($result);
        static::assertArrayHasKey(0, $result);
        static::assertInstanceOf(BrowserInterface::class, $result[0]);
        static::assertArrayHasKey(1, $result);
        static::assertInstanceOf(EngineInterface::class, $result[1]);
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
    public function testInvokeGenericVersionAndEngineInvalidException(): void
    {
        $exception = new NotFoundException('engine failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::once())
            ->method('warning')
            ->with($exception);
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

        $useragent   = 'test/1.0';
        $engineKey   = 'unknown';
        $browserData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => $engineKey,
            'name' => null,
        ];

        $initData
            ->expects(static::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::once())
            ->method('load')
            ->with($engineKey, $useragent)
            ->willThrowException($exception);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $result = $object->load('test-key', $useragent);

        static::assertIsArray($result);
        static::assertArrayHasKey(0, $result);
        static::assertInstanceOf(BrowserInterface::class, $result[0]);
        static::assertArrayHasKey(1, $result);
        static::assertNull($result[1]);
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
    public function testInvokeVersionAndEngine(): void
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

        $browserData = (object) [
            'version' => (object) ['class' => Test::class],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => 'test-browser',
        ];

        $initData
            ->expects(static::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $result = $object->load('test-key', 'test/1.0');

        static::assertIsArray($result);
        static::assertArrayHasKey(0, $result);
        /** @var BrowserInterface $browserResult */
        $browserResult = $result[0];
        static::assertInstanceOf(BrowserInterface::class, $browserResult);
        static::assertArrayHasKey(1, $result);
        /** @var EngineInterface $engineResult */
        $engineResult = $result[1];
        static::assertInstanceOf(EngineInterface::class, $engineResult);

        static::assertSame('test-browser', $browserResult->getName());
    }
}
