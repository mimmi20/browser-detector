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
namespace BrowserDetectorTest;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Detector;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaRequest\Constants;
use UaRequest\GenericRequestFactory;
use UaResult\Browser\BrowserInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Engine\EngineInterface;
use UaResult\Os\OsInterface;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;
use Zend\Diactoros\ServerRequestFactory;

final class DetectorTest extends TestCase
{
    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromUaOld(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
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

        $device = $this->createMock(DeviceInterface::class);
        $os     = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        /** @var \UaResult\Result\Result $result */
        $result = $object->getBrowser($useragent);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        static::assertSame($engine, $result->getEngine());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromGenericRequest(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
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

        $device = $this->createMock(DeviceInterface::class);
        $os     = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        /** @var Result $result */
        $result = $object->__invoke($request);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        static::assertSame($engine, $result->getEngine());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromGenericRequest2(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::exactly(2))
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

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::never())
            ->method('parse');

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::never())
            ->method('parse');

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');
        $engineParser
            ->expects(static::never())
            ->method('load');

        $mockResult = $this->createMock(ResultInterface::class);

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::exactly(2))
            ->method('hasItem')
            ->willReturn(true);
        $cache
            ->expects(static::exactly(2))
            ->method('getItem')
            ->willReturn($mockResult);
        $cache
            ->expects(static::never())
            ->method('setItem');

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        /** @var Result $result */
        $result = $object($request);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($mockResult, $result);

        /** @var Result $result2 */
        $result2 = $object->__invoke($message);

        static::assertSame($result, $result2);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromInvalid(): void
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

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::never())
            ->method('parse');

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::never())
            ->method('parse');

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::never())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::never())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('the request parameter has to be a string, an array or an instance of \Psr\Http\Message\MessageInterface');

        $object->__invoke(new \stdClass());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromUa(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
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

        $device = $this->createMock(DeviceInterface::class);
        $os     = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        /** @var \UaResult\Result\Result $result */
        $result = $object->__invoke($useragent);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        static::assertSame($engine, $result->getEngine());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromArray(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
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

        $device = $this->createMock(DeviceInterface::class);
        $os     = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        /** @var Result $result */
        $result = $object->__invoke([Constants::HEADER_HTTP_USERAGENT => $useragent]);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        static::assertSame($engine, $result->getEngine());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromPsr7Message(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(static::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        /** @var Result $result */
        $result = $object->__invoke($message);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        static::assertSame($engine, $result->getEngine());

        static::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        static::assertSame('testDevice', $result->getDevice()->getDeviceName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromUnknownDevice(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::once())
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

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->will(static::throwException(new NotFoundException('test')));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        /** @var Result $result */
        $result = $object->__invoke($message);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($browser, $result->getBrowser());
        static::assertSame($engine, $result->getEngine());

        static::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        static::assertNull($result->getDevice()->getDeviceName());
        static::assertNull($result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromUnknownDeviceAndPlatform(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::once())
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

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->will(static::throwException(new NotFoundException('test')));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        /** @var Result $result */
        $result = $object->__invoke($message);

        static::assertInstanceOf(ResultInterface::class, $result);
        //self::assertSame($device, $result->getDevice());
        //self::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        static::assertSame($engine, $result->getEngine());

        static::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        static::assertNull($result->getDevice()->getDeviceName());
        static::assertNull($result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngine(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::exactly(2))
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(static::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->getMockBuilder(EngineInterface::class)->getMock();
        $engine->expects(static::once())
            ->method('getName')
            ->willReturn('test-engine');

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($engine);
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        /** @var Result $result */
        $result = $object->__invoke($message);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        static::assertSame($engine, $result->getEngine());

        static::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        static::assertSame('testDevice', $result->getDevice()->getDeviceName());
        static::assertSame('test-engine', $result->getEngine()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngine2(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::exactly(2))
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
            ->expects(static::once())
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(static::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->will(static::throwException(new NotFoundException('test')));
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        /** @var Result $result */
        $result = $object->__invoke($message);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        //self::assertSame($engine, $result->getEngine());

        static::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        static::assertSame('testDevice', $result->getDevice()->getDeviceName());
        static::assertNull($result->getEngine()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngineIos(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(static::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');

        $os = $this->getMockBuilder(OsInterface::class)->getMock();
        $os->expects(static::exactly(2))
            ->method('getName')
            ->willReturn('iOS');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');

        $engine = $this->getMockBuilder(EngineInterface::class)->getMock();
        $engine->expects(static::once())
            ->method('getName')
            ->willReturn('webkit-test');
        $engineParser
            ->expects(static::once())
            ->method('load')
            ->with('webkit', $useragent)
            ->willReturn($engine);

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        /** @var Result $result */
        $result = $object->__invoke($message);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        static::assertSame($engine, $result->getEngine());

        static::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        static::assertSame('testDevice', $result->getDevice()->getDeviceName());
        static::assertSame('webkit-test', $result->getEngine()->getName());
        static::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngineIosFail(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::once())
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(static::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->getMockBuilder(OsInterface::class)->getMock();
        $os->expects(static::exactly(2))
            ->method('getName')
            ->willReturn('iOS');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');
        $engineParser
            ->expects(static::once())
            ->method('load')
            ->with('webkit', $useragent)
            ->will(static::throwException(new \UnexpectedValueException('parsing failed')));

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        /** @var Result $result */
        $result = $object->__invoke($message);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        //self::assertSame($engine, $result->getEngine());

        static::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        static::assertSame('testDevice', $result->getDevice()->getDeviceName());
        static::assertNull($result->getEngine()->getName());
        static::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngineIosFail2(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::once())
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(static::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->getMockBuilder(OsInterface::class)->getMock();
        $os->expects(static::exactly(2))
            ->method('getName')
            ->willReturn('iOS');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');
        $engineParser
            ->expects(static::once())
            ->method('load')
            ->with('webkit', $useragent)
            ->will(static::throwException(new NotFoundException('something not found')));

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        /** @var Result $result */
        $result = $object->__invoke($message);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        //self::assertSame($engine, $result->getEngine());

        static::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        static::assertSame('testDevice', $result->getDevice()->getDeviceName());
        static::assertNull($result->getEngine()->getName());
        static::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserWithBrowserFactoryFail(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
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
            ->expects(static::once())
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(static::never())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->getMockBuilder(OsInterface::class)->getMock();
        $os->expects(static::once())
            ->method('getName')
            ->willReturn('iOS');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $platformParser
            ->expects(static::never())
            ->method('parse');

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willThrowException(new NotFoundException('parsing failed'));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::never())
            ->method('parse');

        $engine2 = $this->getMockBuilder(EngineInterface::class)->getMock();
        $engine2->expects(static::never())
            ->method('getName');

        $engineParser
            ->expects(static::once())
            ->method('load')
            ->with('webkit', $useragent)
            ->willReturn($engine2);

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        /** @var Result $result */
        $result = $object->__invoke($message);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        //self::assertSame($browser, $result->getBrowser());
        //self::assertSame($engine, $result->getEngine());

        static::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        static::assertInstanceOf(BrowserInterface::class, $result->getBrowser());
        static::assertNull($result->getBrowser()->getName());
        static::assertNull($result->getBrowser()->getBits());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetDeviceWithoutPlatform(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::exactly(3))
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(static::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, null]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($os);

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->getMockBuilder(EngineInterface::class)->getMock();
        $engine->expects(static::once())
            ->method('getName')
            ->willReturn('test-engine');

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($engine);
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        /** @var Result $result */
        $result = $object->__invoke($message);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        static::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        static::assertSame($engine, $result->getEngine());

        static::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        static::assertSame('testDevice', $result->getDevice()->getDeviceName());
        static::assertSame('test-engine', $result->getEngine()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetDeviceWithoutPlatformAndError(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::exactly(3))
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::once())
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(static::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$device, null]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willThrowException(new NotFoundException('platform not found'));

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->getMockBuilder(EngineInterface::class)->getMock();
        $engine->expects(static::once())
            ->method('getName')
            ->willReturn('test-engine');

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(static::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($engine);
        $engineParser
            ->expects(static::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache
            ->expects(static::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(static::never())
            ->method('getItem');
        $cache
            ->expects(static::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        /** @var Result $result */
        $result = $object->__invoke($message);

        static::assertInstanceOf(ResultInterface::class, $result);
        static::assertSame($device, $result->getDevice());
        //self::assertSame($os, $result->getOs());
        static::assertSame($browser, $result->getBrowser());
        static::assertSame($engine, $result->getEngine());

        static::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        static::assertSame('testDevice', $result->getDevice()->getDeviceName());
        static::assertSame('test-engine', $result->getEngine()->getName());

        static::assertNull($result->getOs()->getName());
        static::assertNull($result->getOs()->getMarketingName());
        static::assertNull($result->getOs()->getBits());
    }
}
