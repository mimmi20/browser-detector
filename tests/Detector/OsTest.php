<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Detector;

use BrowserDetector\Detector\Os;
use BrowserDetector\Factory\Regex\NoMatchException;
use BrowserDetector\Loader\NotFoundException;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class OsTest extends \PHPUnit_Framework_TestCase
{
    public function testDetectSuccess()
    {
        $testUa     = 'This is a test useragent';
        $testResult = new \UaResult\Os\Os('abc', 'abc');

        $cache  = $this->createMock('\Cache\Adapter\Filesystem\FilesystemCachePool');
        $logger = $this->getMockBuilder('\Monolog\Logger')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['error', 'critical', 'info', 'debug'])
            ->getMock();
        $logger->expects(self::never())->method('error');
        $logger->expects(self::never())->method('critical');
        $logger->expects(self::never())->method('info');
        $logger->expects(self::once())->method('debug');

        $regexFactory = $this->getMockBuilder('\BrowserDetector\Factory\RegexFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['getPlatform'])
            ->getMock();
        $regexFactory->expects(self::once())->method('getPlatform')->willReturn($testResult);

        $platformFactory = $this->getMockBuilder('\BrowserDetector\Factory\PlatformFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['detect'])
            ->getMock();
        $platformFactory->expects(self::never())->method('detect');

        $object = new Os($cache, $logger, $regexFactory, $platformFactory);
        self::assertSame($testResult, $object->detect($testUa));
    }

    public function testDetectFailInvalid()
    {
        $testUa     = 'This is a test useragent';
        $testResult = ['this is a test result'];
        $exception  = new \InvalidArgumentException();

        $cache  = $this->createMock('\Cache\Adapter\Filesystem\FilesystemCachePool');
        $logger = $this->getMockBuilder('\Monolog\Logger')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['error', 'critical', 'info', 'debug'])
            ->getMock();
        $logger->expects(self::once())->method('error')->with($exception);
        $logger->expects(self::never())->method('critical');
        $logger->expects(self::never())->method('info');
        $logger->expects(self::exactly(2))->method('debug');

        $regexFactory = $this->getMockBuilder('\BrowserDetector\Factory\RegexFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['getPlatform'])
            ->getMock();
        $regexFactory->expects(self::once())->method('getPlatform')->willThrowException($exception);

        $deviceFactory = $this->getMockBuilder('\BrowserDetector\Factory\PlatformFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['detect'])
            ->getMock();
        $deviceFactory->expects(self::once())->method('detect')->with($testUa)->willReturn($testResult);

        $object = new Os($cache, $logger, $regexFactory, $deviceFactory);
        self::assertSame($testResult, $object->detect($testUa));
    }

    public function testDetectFailINoMatch()
    {
        $testUa     = 'This is a test useragent';
        $testResult = ['this is a test result'];
        $exception  = new NoMatchException();

        $cache  = $this->createMock('\Cache\Adapter\Filesystem\FilesystemCachePool');
        $logger = $this->getMockBuilder('\Monolog\Logger')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['error', 'critical', 'info', 'debug'])
            ->getMock();
        $logger->expects(self::never())->method('error');
        $logger->expects(self::never())->method('critical');
        $logger->expects(self::never())->method('info');
        $logger->expects(self::exactly(2))->method('debug');

        $regexFactory = $this->getMockBuilder('\BrowserDetector\Factory\RegexFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['getPlatform'])
            ->getMock();
        $regexFactory->expects(self::once())->method('getPlatform')->willThrowException($exception);

        $deviceFactory = $this->getMockBuilder('\BrowserDetector\Factory\PlatformFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['detect'])
            ->getMock();
        $deviceFactory->expects(self::once())->method('detect')->with($testUa)->willReturn($testResult);

        $object = new Os($cache, $logger, $regexFactory, $deviceFactory);
        self::assertSame($testResult, $object->detect($testUa));
    }

    public function testDetectFailMatchesNotFound()
    {
        $testUa     = 'This is a test useragent';
        $testResult = ['this is a test result'];
        $exception  = new NotFoundException();

        $cache  = $this->createMock('\Cache\Adapter\Filesystem\FilesystemCachePool');
        $logger = $this->getMockBuilder('\Monolog\Logger')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['error', 'critical', 'info', 'debug'])
            ->getMock();
        $logger->expects(self::never())->method('error');
        $logger->expects(self::never())->method('critical');
        $logger->expects(self::once())->method('info')->with($exception);
        $logger->expects(self::exactly(2))->method('debug');

        $regexFactory = $this->getMockBuilder('\BrowserDetector\Factory\RegexFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['getPlatform'])
            ->getMock();
        $regexFactory->expects(self::once())->method('getPlatform')->willThrowException($exception);

        $deviceFactory = $this->getMockBuilder('\BrowserDetector\Factory\PlatformFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['detect'])
            ->getMock();
        $deviceFactory->expects(self::once())->method('detect')->with($testUa)->willReturn($testResult);

        $object = new Os($cache, $logger, $regexFactory, $deviceFactory);
        self::assertSame($testResult, $object->detect($testUa));
    }

    public function testDetectFailGeneralException()
    {
        $testUa     = 'This is a test useragent';
        $testResult = ['this is a test result'];
        $exception  = new \Exception();

        $cache  = $this->createMock('\Cache\Adapter\Filesystem\FilesystemCachePool');
        $logger = $this->getMockBuilder('\Monolog\Logger')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['error', 'critical', 'info', 'debug'])
            ->getMock();
        $logger->expects(self::never())->method('error');
        $logger->expects(self::once())->method('critical')->with($exception);
        $logger->expects(self::never())->method('info');
        $logger->expects(self::exactly(2))->method('debug');

        $regexFactory = $this->getMockBuilder('\BrowserDetector\Factory\RegexFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['getPlatform'])
            ->getMock();
        $regexFactory->expects(self::once())->method('getPlatform')->willThrowException($exception);

        $deviceFactory = $this->getMockBuilder('\BrowserDetector\Factory\PlatformFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['detect'])
            ->getMock();
        $deviceFactory->expects(self::once())->method('detect')->with($testUa)->willReturn($testResult);

        $object = new Os($cache, $logger, $regexFactory, $deviceFactory);
        self::assertSame($testResult, $object->detect($testUa));
    }

    public function testDetectFailLoadFailed()
    {
        $testUa     = 'This is a test useragent';
        $testResult = new \UaResult\Os\Os(null, null);
        $exception  = new NotFoundException();

        $cache  = $this->createMock('\Cache\Adapter\Filesystem\FilesystemCachePool');
        $logger = $this->getMockBuilder('\Monolog\Logger')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['error', 'critical', 'info', 'debug'])
            ->getMock();
        $logger->expects(self::never())->method('error');
        $logger->expects(self::never())->method('critical');
        $logger->expects(self::exactly(2))->method('info')->with($exception);
        $logger->expects(self::exactly(2))->method('debug');

        $regexFactory = $this->getMockBuilder('\BrowserDetector\Factory\RegexFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['getPlatform'])
            ->getMock();
        $regexFactory->expects(self::once())->method('getPlatform')->willThrowException($exception);

        $deviceFactory = $this->getMockBuilder('\BrowserDetector\Factory\PlatformFactory')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['detect'])
            ->getMock();
        $deviceFactory->expects(self::once())->method('detect')->with($testUa)->willThrowException($exception);

        $object = new Os($cache, $logger, $regexFactory, $deviceFactory);
        self::assertEquals($testResult, $object->detect($testUa));
    }
}
