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
use BrowserDetector\Loader\Helper\CacheKey;
use BrowserDetector\Loader\Loader;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use UaDeviceType\TypeLoader;
use UaDeviceType\Unknown;
use UaResult\Company\Company;
use UaResult\Company\CompanyLoader;

class DeviceLoaderTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvokeCacheException(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['info'])
            ->getMock();

        $logger
            ->expects(self::never())
            ->method('info');

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

        $platformLoader = $this->getMockBuilder(Loader::class)
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
        /** @var Loader $platformLoader */
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
            ->setMethods(['info'])
            ->getMock();

        $logger
            ->expects(self::never())
            ->method('info');

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

        $platformLoader = $this->getMockBuilder(Loader::class)
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
        /** @var Loader $platformLoader */
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
}
