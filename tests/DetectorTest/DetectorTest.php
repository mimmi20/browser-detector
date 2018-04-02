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

use BrowserDetector\Detector;
use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Seld\JsonLint\ParsingException;
use UaRequest\Constants;
use UaRequest\GenericRequestFactory;
use UaResult\Browser\Browser;
use UaResult\Device\Device;
use UaResult\Engine\Engine;
use UaResult\Os\Os;
use UaResult\Result\Result;
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
            ->setMethods(['debug', 'info'])
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Device(), new Os()]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Os()));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Browser(), new Engine()]));

        $engineLoader = $this->getMockBuilder(EngineLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineLoader
            ->expects(self::never())
            ->method('__invoke');
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $object = new Detector($logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);

        /* @var \UaResult\Result\Result $result */
        $result = $object->getBrowser('testagent');

        self::assertInstanceOf(Result::class, $result);
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
            ->setMethods(['debug', 'info'])
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Device(), new Os()]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Os()));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Browser(), new Engine()]));

        $engineLoader = $this->getMockBuilder(EngineLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineLoader
            ->expects(self::never())
            ->method('__invoke');
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $object = new Detector($logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);

        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        /* @var Result $result */
        $result = $object($request);

        self::assertInstanceOf(Result::class, $result);
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
            ->setMethods(['debug', 'info'])
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Device(), new Os()]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Os()));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Browser(), new Engine()]));

        $engineLoader = $this->getMockBuilder(EngineLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineLoader
            ->expects(self::never())
            ->method('__invoke');
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $object = new Detector($logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);

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
            ->setMethods(['debug', 'info'])
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Device(), new Os()]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Os()));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Browser(), new Engine()]));

        $engineLoader = $this->getMockBuilder(EngineLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineLoader
            ->expects(self::never())
            ->method('__invoke');
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $object = new Detector($logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);

        /* @var \UaResult\Result\Result $result */
        $result = $object('testagent');

        self::assertInstanceOf(Result::class, $result);
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
            ->setMethods(['debug', 'info'])
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Device(), new Os()]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Os()));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Browser(), new Engine()]));

        $engineLoader = $this->getMockBuilder(EngineLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineLoader
            ->expects(self::never())
            ->method('__invoke');
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $object = new Detector($logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);

        /* @var Result $result */
        $result = $object([Constants::HEADER_HTTP_USERAGENT => 'testagent']);

        self::assertInstanceOf(Result::class, $result);
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
            ->setMethods(['debug', 'info'])
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Device('testDevice'), new Os()]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Os()));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Browser(), new Engine()]));

        $engineLoader = $this->getMockBuilder(EngineLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineLoader
            ->expects(self::never())
            ->method('__invoke');
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $object = new Detector($logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromUnknownDevice(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info'])
            ->getMock();
        $logger
            ->expects(self::exactly(3))
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new NotFoundException('test')));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Os('test-os')));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Browser(), new Engine()]));

        $engineLoader = $this->getMockBuilder(EngineLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineLoader
            ->expects(self::never())
            ->method('__invoke');
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $object = new Detector($logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
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
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info'])
            ->getMock();
        $logger
            ->expects(self::exactly(4))
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new NotFoundException('test')));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new NotFoundException('test')));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Browser(), new Engine()]));

        $engineLoader = $this->getMockBuilder(EngineLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineLoader
            ->expects(self::never())
            ->method('__invoke');
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $object = new Detector($logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
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
            ->setMethods(['debug', 'info'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Device('testDevice'), new Os()]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Os()));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Browser(), null]));

        $engineLoader = $this->getMockBuilder(EngineLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Engine('test-engine')));
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $object = new Detector($logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
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
            ->setMethods(['debug', 'info'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
        $logger
            ->expects(self::once())
            ->method('info');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Device('testDevice'), new Os()]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Os()));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Browser(), null]));

        $engineLoader = $this->getMockBuilder(EngineLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new ParsingException('test')));
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $object = new Detector($logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
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
            ->setMethods(['debug', 'info'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Device('testDevice'), new Os('iOS')]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Os()));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([new Browser(), null]));

        $engineLoader = $this->getMockBuilder(EngineLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineLoader
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue(new Engine('test-engine')));
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with('webkit', 'testagent')
            ->will(self::returnValue(new Engine('webkit-test')));

        $object = new Detector($logger, $deviceFactory, $platformFactory, $browserFactory, $engineLoader);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertSame('webkit-test', $result->getEngine()->getName());
        self::assertSame('iOS', $result->getOs()->getName());
    }
}
