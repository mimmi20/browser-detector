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
namespace BrowserDetectorTest;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Detector;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use ExceptionalJSON\DecodeErrorException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use UaRequest\Constants;
use UaRequest\GenericRequestFactory;
use UaResult\Browser\Browser;
use UaResult\Browser\BrowserInterface;
use UaResult\Device\Device;
use UaResult\Device\DeviceInterface;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;
use Zend\Diactoros\ServerRequestFactory;

class DetectorTest extends TestCase
{
    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromUaOld(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        $device = $this->createMock(DeviceInterface::class);
        $os     = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');
        $engineParser
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        /* @var \UaResult\Result\Result $result */
        $result = $object->getBrowser('testagent');

        self::assertInstanceOf(ResultInterface::class, $result);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromGenericRequest(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        $device = $this->createMock(DeviceInterface::class);
        $os     = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');
        $engineParser
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        /* @var Result $result */
        $result = $object($request);

        self::assertInstanceOf(ResultInterface::class, $result);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromGenericRequest2(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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

        $device = $this->createMock(DeviceInterface::class);
        $os     = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');
        $engineParser
            ->expects(self::never())
            ->method('load');

        $mockResult = $this->createMock(ResultInterface::class);

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::exactly(2))
            ->method('hasItem')
            ->willReturn(true);
        $cache
            ->expects(self::exactly(2))
            ->method('getItem')
            ->willReturn($mockResult);
        $cache
            ->expects(self::never())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        /* @var Result $result */
        $result = $object($request);

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($mockResult, $result);

        /* @var Result $result2 */
        $result2 = $object($message);

        self::assertSame($result, $result2);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromInvalid(): void
    {
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

        $device = $this->createMock(DeviceInterface::class);
        $os     = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');
        $engineParser
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::never())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('the request parameter has to be a string, an array or an instance of \Psr\Http\Message\MessageInterface');

        $object(new \stdClass());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromUa(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        $device = $this->createMock(DeviceInterface::class);
        $os     = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');
        $engineParser
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        /* @var \UaResult\Result\Result $result */
        $result = $object('testagent');

        self::assertInstanceOf(ResultInterface::class, $result);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromArray(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        $device = $this->createMock(DeviceInterface::class);
        $os     = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');
        $engineParser
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        /* @var Result $result */
        $result = $object([Constants::HEADER_HTTP_USERAGENT => 'testagent']);

        self::assertInstanceOf(ResultInterface::class, $result);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromPsr7Message(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');
        $engineParser
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromUnknownDevice(): void
    {
        self::markTestIncomplete();
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::exactly(2))
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

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new NotFoundException('test')));

        $os = $this->getMockBuilder(OsInterface::class)->getMock();
        $os->expects(self::once())
            ->method('getName')
            ->willReturn('test-os');

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');
        $engineParser
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertNull($result->getDevice()->getDeviceName());
        self::assertSame('test-os', $result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromUnknownDeviceAndPlatform(): void
    {
        self::markTestIncomplete();
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::exactly(2))
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

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new NotFoundException('test')));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new NotFoundException('test')));

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');
        $engineParser
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertNull($result->getDevice()->getDeviceName());
        self::assertNull($result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngine(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->getMockBuilder(EngineInterface::class)->getMock();
        $engine->expects(self::once())
            ->method('getName')
            ->willReturn('test-engine');

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, null]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($engine));
        $engineParser
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertSame('test-engine', $result->getEngine()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngine2(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->createMock(OsInterface::class);

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, null]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new InvalidArgumentException('test')));
        $engineParser
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertNull($result->getEngine()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngineIos(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');

        $os = $this->getMockBuilder(OsInterface::class)->getMock();
        $os->expects(self::exactly(2))
            ->method('getName')
            ->willReturn('iOS');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $os = $this->createMock(OsInterface::class);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, null]));

        $engine = $this->getMockBuilder(EngineInterface::class)->getMock();
        $engine->expects(self::never())
            ->method('getName')
            ->willReturn('test-engine');

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($engine));

        $engine2 = $this->getMockBuilder(EngineInterface::class)->getMock();
        $engine2->expects(self::once())
            ->method('getName')
            ->willReturn('webkit-test');
        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with('webkit', 'testagent')
            ->will(self::returnValue($engine2));

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertSame('webkit-test', $result->getEngine()->getName());
        self::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngineIosFail(): void
    {
        self::markTestIncomplete();
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->getMockBuilder(OsInterface::class)->getMock();
        $os->expects(self::once())
            ->method('getName')
            ->willReturn('iOS');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $os = $this->createMock(OsInterface::class);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, null]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');
        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with('webkit', 'testagent')
            ->will(self::throwException(new DecodeErrorException(0, 'parsing failed', '')));

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertNull($result->getEngine()->getName());
        self::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngineIosFail2(): void
    {
        self::markTestIncomplete();
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::exactly(2))
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->getMockBuilder(OsInterface::class)->getMock();
        $os->expects(self::once())
            ->method('getName')
            ->willReturn('iOS');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $os = $this->createMock(OsInterface::class);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, null]));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');
        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with('webkit', 'testagent')
            ->will(self::throwException(new NotFoundException('something not found')));

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertNull($result->getEngine()->getName());
        self::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithBrowserFactoryFail(): void
    {
        self::markTestIncomplete();
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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

        $device = $this->getMockBuilder(DeviceInterface::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->getMockBuilder(OsInterface::class)->getMock();
        $os->expects(self::once())
            ->method('getName')
            ->willReturn('iOS');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $os = $this->createMock(OsInterface::class);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->willThrowException(new DecodeErrorException(0, 'parsing failed', ''));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('__invoke');

        $engine2 = $this->getMockBuilder(EngineInterface::class)->getMock();
        $engine2->expects(self::once())
            ->method('getName')
            ->willReturn('webkit-test');

        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with('webkit', 'testagent')
            ->will(self::returnValue($engine2));

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var CacheInterface $cache */
        /** @var DeviceParserInterface $deviceParser */
        /** @var PlatformParserInterface $platformParser */
        /** @var BrowserParserInterface $browserParser */
        /** @var EngineParserInterface $engineParser */
        $object = new Detector($logger, $cache, $deviceParser, $platformParser, $browserParser, $engineParser);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertInstanceOf(BrowserInterface::class, $result->getBrowser());
        self::assertNull($result->getBrowser()->getName());
    }
}
