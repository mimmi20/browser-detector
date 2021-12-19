<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
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
use BrowserDetector\Version\NotNumericException;
use Laminas\Diactoros\ServerRequestFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use stdClass;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaRequest\Constants;
use UaRequest\GenericRequestFactory;
use UaRequest\GenericRequestInterface;
use UaResult\Browser\BrowserInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Engine\EngineInterface;
use UaResult\Os\OsInterface;
use UaResult\Result\ResultInterface;
use UnexpectedValueException;

use function assert;
use function get_class;
use function sprintf;

final class DetectorTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserFromUaOld(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $result = $object->getBrowser($useragent);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserFromGenericRequest(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        $result = $object->__invoke($request);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserFromGenericRequest2(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
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

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');
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
            ->method('setItem');

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::never())
            ->method('normalize');

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        $result = $object($request);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($mockResult, $result);

        $result2 = $object->__invoke($message);
        assert($result2 instanceof ResultInterface, sprintf('$result2 should be an instance of %s, but is %s', ResultInterface::class, get_class($result2)));

        self::assertSame($result, $result2);
    }

    /**
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NotNumericException
     */
    public function testGetBrowserFromInvalid(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
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

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::never())
            ->method('normalize');

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('the request parameter has to be a string, an array or an instance of \Psr\Http\Message\MessageInterface');

        $object->__invoke(new stdClass());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserFromUa(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $result = $object->__invoke($useragent);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserFromArray(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $result = $object->__invoke([Constants::HEADER_HTTP_USERAGENT => $useragent]);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserFromPsr7Message(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserFromUnknownDevice(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('parse')
            ->with($normalizedUseragent)
            ->will(self::throwException(new NotFoundException('test')));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = $this->getMockBuilder(GenericRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $message
            ->expects(self::once())
            ->method('getDeviceUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::never())
            ->method('getPlatformUserAgent');
        $message
            ->expects(self::once())
            ->method('getBrowserUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getEngineUserAgent')
            ->willReturn($useragent);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertNull($result->getDevice()->getDeviceName());
        self::assertNull($result->getOs()->getName());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserFromUnknownDeviceAndPlatform(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('parse')
            ->with($normalizedUseragent)
            ->will(self::throwException(new NotFoundException('test')));

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);
        $engine  = $this->createMock(EngineInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, $engine]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = $this->getMockBuilder(GenericRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $message
            ->expects(self::once())
            ->method('getDeviceUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::never())
            ->method('getPlatformUserAgent');
        $message
            ->expects(self::once())
            ->method('getBrowserUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getEngineUserAgent')
            ->willReturn($useragent);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        //self::assertSame($device, $result->getDevice());
        //self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertNull($result->getDevice()->getDeviceName());
        self::assertNull($result->getOs()->getName());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserWithoutEngine(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn($engine);
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = $this->getMockBuilder(GenericRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $message
            ->expects(self::once())
            ->method('getDeviceUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::never())
            ->method('getPlatformUserAgent');
        $message
            ->expects(self::once())
            ->method('getBrowserUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getEngineUserAgent')
            ->willReturn($useragent);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertSame('test-engine', $result->getEngine()->getName());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserWithoutEngine2(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->will(self::throwException(new NotFoundException('test')));
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = $this->getMockBuilder(GenericRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $message
            ->expects(self::once())
            ->method('getDeviceUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::never())
            ->method('getPlatformUserAgent');
        $message
            ->expects(self::once())
            ->method('getBrowserUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getEngineUserAgent')
            ->willReturn($useragent);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        //self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertNull($result->getEngine()->getName());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserWithoutEngineIos(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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

        $os = $this->getMockBuilder(OsInterface::class)->getMock();
        $os->expects(self::exactly(2))
            ->method('getName')
            ->willReturn('iOS');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $engine = $this->getMockBuilder(EngineInterface::class)->getMock();
        $engine->expects(self::once())
            ->method('getName')
            ->willReturn('webkit-test');
        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with('webkit', $normalizedUseragent)
            ->willReturn($engine);

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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = $this->getMockBuilder(GenericRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $message
            ->expects(self::once())
            ->method('getDeviceUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::never())
            ->method('getPlatformUserAgent');
        $message
            ->expects(self::once())
            ->method('getBrowserUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getEngineUserAgent')
            ->willReturn($useragent);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertSame('webkit-test', $result->getEngine()->getName());
        self::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserWithoutEngineIosFail(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
        $os->expects(self::exactly(2))
            ->method('getName')
            ->willReturn('iOS');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');
        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with('webkit', $normalizedUseragent)
            ->will(self::throwException(new UnexpectedValueException('parsing failed')));

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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = $this->getMockBuilder(GenericRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $message
            ->expects(self::once())
            ->method('getDeviceUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::never())
            ->method('getPlatformUserAgent');
        $message
            ->expects(self::once())
            ->method('getBrowserUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getEngineUserAgent')
            ->willReturn($useragent);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        //self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertNull($result->getEngine()->getName());
        self::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserWithoutEngineIosFail2(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
        $os->expects(self::exactly(2))
            ->method('getName')
            ->willReturn('iOS');

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browser = $this->createMock(BrowserInterface::class);

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');
        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with('webkit', $normalizedUseragent)
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = $this->getMockBuilder(GenericRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $message
            ->expects(self::once())
            ->method('getDeviceUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::never())
            ->method('getPlatformUserAgent');
        $message
            ->expects(self::once())
            ->method('getBrowserUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getEngineUserAgent')
            ->willReturn($useragent);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        //self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertNull($result->getEngine()->getName());
        self::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserWithBrowserFactoryFail(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
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
        $device->expects(self::never())
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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, $os]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browserParser = $this->getMockBuilder(BrowserParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willThrowException(new NotFoundException('parsing failed'));

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $engine2 = $this->getMockBuilder(EngineInterface::class)->getMock();
        $engine2->expects(self::never())
            ->method('getName');

        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with('webkit', $normalizedUseragent)
            ->willReturn($engine2);

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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(3))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = $this->getMockBuilder(GenericRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $message
            ->expects(self::once())
            ->method('getDeviceUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::never())
            ->method('getPlatformUserAgent');
        $message
            ->expects(self::once())
            ->method('getBrowserUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getEngineUserAgent')
            ->willReturn($useragent);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        //self::assertSame($browser, $result->getBrowser());
        //self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertInstanceOf(BrowserInterface::class, $result->getBrowser());
        self::assertNull($result->getBrowser()->getName());
        self::assertNull($result->getBrowser()->getBits());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetDeviceWithoutPlatform(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::exactly(3))
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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, null]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn($os);

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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn($engine);
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(4))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = $this->getMockBuilder(GenericRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $message
            ->expects(self::once())
            ->method('getDeviceUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getPlatformUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getBrowserUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getEngineUserAgent')
            ->willReturn($useragent);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertSame('test-engine', $result->getEngine()->getName());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetDeviceWithoutPlatformAndError(): void
    {
        $useragent           = 'testagent';
        $normalizedUseragent = 'normalized testagent';
        $logger              = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::exactly(3))
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

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$device, null]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willThrowException(new NotFoundException('platform not found'));

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
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalizedUseragent)
            ->willReturn($engine);
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(4))
            ->method('normalize')
            ->with($useragent)
            ->willReturn($normalizedUseragent);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = $this->getMockBuilder(GenericRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $message
            ->expects(self::once())
            ->method('getDeviceUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getPlatformUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getBrowserUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getEngineUserAgent')
            ->willReturn($useragent);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        //self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertSame('test-engine', $result->getEngine()->getName());

        self::assertNull($result->getOs()->getName());
        self::assertNull($result->getOs()->getMarketingName());
        self::assertNull($result->getOs()->getBits());
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetDeviceWithoutPlatformAndError2(): void
    {
        $useragent = 'testagent';

        $exception = new \UaNormalizer\Normalizer\Exception('test');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::exactly(3))
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
            ->expects(self::exactly(3))
            ->method('error')
            ->with($exception);
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

        $deviceParser = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with('')
            ->willReturn([$device, null]);

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser
            ->expects(self::never())
            ->method('parse');

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
            ->method('parse')
            ->with('')
            ->willReturn([$browser, null]);

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::once())
            ->method('parse')
            ->with('')
            ->willReturn($engine);
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

        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer
            ->expects(self::exactly(4))
            ->method('normalize')
            ->with($useragent)
            ->willThrowException($exception);

        $object = new Detector(
            $logger,
            $cache,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizer
        );

        $message = $this->getMockBuilder(GenericRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $message
            ->expects(self::once())
            ->method('getDeviceUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getPlatformUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getBrowserUserAgent')
            ->willReturn($useragent);
        $message
            ->expects(self::once())
            ->method('getEngineUserAgent')
            ->willReturn($useragent);

        $result = $object->__invoke($message);
        assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        self::assertInstanceOf(ResultInterface::class, $result);
        self::assertSame($device, $result->getDevice());
        //self::assertSame($os, $result->getOs());
        self::assertSame($browser, $result->getBrowser());
        self::assertSame($engine, $result->getEngine());

        self::assertInstanceOf(DeviceInterface::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertSame('test-engine', $result->getEngine()->getName());

        self::assertNull($result->getOs()->getName());
        self::assertNull($result->getOs()->getMarketingName());
        self::assertNull($result->getOs()->getBits());
    }
}
