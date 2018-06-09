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

use BrowserDetector\Cache\Cache;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetector\Loader\GenericLoader;
use BrowserDetector\Loader\Helper\CacheKey;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use UaDeviceType\TypeLoader;
use UaDeviceType\Unknown;
use UaResult\Company\Company;
use UaResult\Company\CompanyLoader;
use UaResult\Device\DeviceInterface;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

class DeviceLoaderTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvokeCacheException(): void
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

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();

        $map = [
            ['device_default__initialized', true],
            ['device_default__generic-device', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('device_default__key')
            ->will(self::throwException(new InvalidArgumentException('fail')));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'device_default__key'],
        ];

        $cacheKey
            ->expects(self::once())
            ->method('__invoke')
            ->with('test-key')
            ->will(self::returnValueMap($map));

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::never())
            ->method('load')
            ->with('Unknown')
            ->willReturn(new Company('Unknown'));

        $typeLoader = $this->getMockBuilder(TypeLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $typeLoader
            ->expects(self::never())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $platformLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $platformLoader
            ->expects(self::never())
            ->method('load');

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $platformLoader */
        $object = new DeviceLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader,
            $typeLoader,
            $platformLoader
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');

        $object('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeCacheNotFound(): void
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

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();

        $map = [
            ['device_default__initialized', true],
            ['device_default__generic-device', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('device_default__key')
            ->will(self::returnValue(null));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'device_default__key'],
        ];

        $cacheKey
            ->expects(self::once())
            ->method('__invoke')
            ->with('test-key')
            ->will(self::returnValueMap($map));

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::never())
            ->method('load')
            ->with('Unknown')
            ->willReturn(new Company('Unknown'));

        $typeLoader = $this->getMockBuilder(TypeLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $typeLoader
            ->expects(self::never())
            ->method('load')
            ->with('unknown')
            ->willReturn(new Unknown());

        $platformLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $platformLoader
            ->expects(self::never())
            ->method('load');

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $platformLoader */
        $object = new DeviceLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader,
            $typeLoader,
            $platformLoader
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');

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

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();

        $map = [
            ['device_default__initialized', true],
            ['device_default__generic-device', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $deviceData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'Unknown',
            'brand' => 'Unknown',
            'type' => 'unknown',
            'platform' => null,
            'codename' => null,
            'marketingName' => null,
            'pointingMethod' => null,
            'resolutionWidth' => null,
            'resolutionHeight' => null,
            'dualOrientation' => true,
        ];

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('device_default__key')
            ->will(self::returnValue($deviceData));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'device_default__key'],
        ];

        $cacheKey
            ->expects(self::once())
            ->method('__invoke')
            ->with('test-key')
            ->will(self::returnValueMap($map));

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::exactly(2))
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

        $platformLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $platformLoader
            ->expects(self::never())
            ->method('load');

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $platformLoader */
        $object = new DeviceLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader,
            $typeLoader,
            $platformLoader
        );

        $result = $object('test-key', 'test-ua');

        self::assertInternalType('array', $result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(DeviceInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeGenericVersionAndPlatformException(): void
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

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();

        $map = [
            ['device_default__initialized', true],
            ['device_default__generic-device', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $deviceData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'Unknown',
            'brand' => 'Unknown',
            'type' => 'unknown',
            'platform' => 'unknown',
            'codename' => null,
            'marketingName' => null,
            'pointingMethod' => null,
            'resolutionWidth' => null,
            'resolutionHeight' => null,
            'dualOrientation' => true,
        ];

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('device_default__key')
            ->will(self::returnValue($deviceData));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'device_default__key'],
        ];

        $cacheKey
            ->expects(self::once())
            ->method('__invoke')
            ->with('test-key')
            ->will(self::returnValueMap($map));

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::exactly(2))
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

        $platformLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load', 'init'])
            ->getMock();

        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown', 'test/1.0')
            ->willThrowException(new NotFoundException('engine not found'));

        $platformLoader
            ->expects(self::once())
            ->method('init')
            ->willReturnSelf();

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $platformLoader */
        $object = new DeviceLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader,
            $typeLoader,
            $platformLoader
        );

        $result = $object('test-key', 'test/1.0');

        self::assertInternalType('array', $result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(DeviceInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeGenericVersionAndPlatformInvalidException(): void
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

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();

        $map = [
            ['device_default__initialized', true],
            ['device_default__generic-device', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $deviceData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'Unknown',
            'brand' => 'Unknown',
            'type' => 'unknown',
            'platform' => 'unknown',
            'codename' => null,
            'marketingName' => null,
            'pointingMethod' => null,
            'resolutionWidth' => null,
            'resolutionHeight' => null,
            'dualOrientation' => true,
        ];

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('device_default__key')
            ->will(self::returnValue($deviceData));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'device_default__key'],
        ];

        $cacheKey
            ->expects(self::once())
            ->method('__invoke')
            ->with('test-key')
            ->will(self::returnValueMap($map));

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::exactly(2))
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

        $platformLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load', 'init'])
            ->getMock();

        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown', 'test/1.0')
            ->willThrowException(new InvalidArgumentException('engine key not found'));

        $platformLoader
            ->expects(self::once())
            ->method('init')
            ->willReturnSelf();

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $platformLoader */
        $object = new DeviceLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader,
            $typeLoader,
            $platformLoader
        );

        $result = $object('test-key', 'test/1.0');

        self::assertInternalType('array', $result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(DeviceInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeVersionAndPlatform(): void
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

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();

        $map = [
            ['device_default__initialized', true],
            ['device_default__generic-device', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $deviceData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'Unknown',
            'brand' => 'Unknown',
            'type' => 'unknown',
            'platform' => 'unknown',
            'codename' => 'test-device',
            'marketingName' => null,
            'pointingMethod' => null,
            'resolutionWidth' => null,
            'resolutionHeight' => null,
            'dualOrientation' => true,
        ];

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('device_default__key')
            ->will(self::returnValue($deviceData));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'device_default__key'],
        ];

        $cacheKey
            ->expects(self::once())
            ->method('__invoke')
            ->with('test-key')
            ->will(self::returnValueMap($map));

        $companyLoader = $this->getMockBuilder(CompanyLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load'])
            ->getMock();

        $companyLoader
            ->expects(self::exactly(2))
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

        $platformLoader = $this->getMockBuilder(GenericLoader::class)
            ->disableOriginalConstructor()
            ->setMethods(['load', 'init'])
            ->getMock();

        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown', 'test/1.0')
            ->willReturn(new Os());

        $platformLoader
            ->expects(self::once())
            ->method('init')
            ->willReturnSelf();

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        /** @var TypeLoader $typeLoader */
        /** @var GenericLoader $platformLoader */
        $object = new DeviceLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader,
            $typeLoader,
            $platformLoader
        );

        $result = $object('test-key', 'test/1.0');

        self::assertInternalType('array', $result);
        self::assertArrayHasKey(0, $result);
        /** @var DeviceInterface $resultDevice */
        $resultDevice = $result[0];
        self::assertInstanceOf(DeviceInterface::class, $resultDevice);
        self::assertArrayHasKey(1, $result);
        /** @var OsInterface $resultPlatform */
        $resultPlatform = $result[1];
        self::assertInstanceOf(OsInterface::class, $resultPlatform);

        self::assertSame('test-device', $resultDevice->getDeviceName());
    }
}
