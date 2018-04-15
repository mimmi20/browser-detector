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
use BrowserDetector\Loader\Helper\CacheKey;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetector\Version\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use UaResult\Company\Company;
use UaResult\Company\CompanyLoader;
use UaResult\Os\OsInterface;

class PlatformLoaderTest extends TestCase
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
            ['platform_default__initialized', true],
            ['platform_default__generic-platform', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('platform_default__key')
            ->will(self::throwException(new InvalidArgumentException('fail')));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'platform_default__key'],
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

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        $object = new PlatformLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');

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
            ['platform_default__initialized', true],
            ['platform_default__generic-platform', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('platform_default__key')
            ->will(self::returnValue(null));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'platform_default__key'],
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

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        $object = new PlatformLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');

        $object('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeNoVersion(): void
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
            ['platform_default__initialized', true],
            ['platform_default__generic-platform', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $platformData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'Unknown',
            'name' => null,
            'marketingName' => null,
        ];

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('platform_default__key')
            ->will(self::returnValue($platformData));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'platform_default__key'],
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
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn(new Company('Unknown'));

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        $object = new PlatformLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader
        );

        $result = $object('test-key', 'test-ua');

        self::assertInstanceOf(OsInterface::class, $result);
    }

    /**
     * @return void
     */
    public function testInvokeVersionSet(): void
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
            ['platform_default__initialized', true],
            ['platform_default__generic-platform', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $platformData = (object) [
            'version' => (object) ['class' => null, 'value' => '1.0'],
            'manufacturer' => 'Unknown',
            'name' => null,
            'marketingName' => null,
        ];

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('platform_default__key')
            ->will(self::returnValue($platformData));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'platform_default__key'],
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
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn(new Company('Unknown'));

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        $object = new PlatformLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader
        );

        $result = $object('test-key', 'test-ua');

        self::assertInstanceOf(OsInterface::class, $result);
    }

    /**
     * @return void
     */
    public function testInvokeGenericVersion(): void
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
            ['platform_default__initialized', true],
            ['platform_default__generic-platform', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $platformData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'Unknown',
            'name' => 'Mac OS X',
            'marketingName' => null,
        ];

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('platform_default__key')
            ->will(self::returnValue($platformData));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'platform_default__key'],
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
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn(new Company('Unknown'));

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        $object = new PlatformLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader
        );

        $result = $object('test-key', 'test/10.12');

        self::assertInstanceOf(OsInterface::class, $result);

        self::assertSame('macOS', $result->getName());
    }

    /**
     * @return void
     */
    public function testInvokeVersion(): void
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
            ['platform_default__initialized', true],
            ['platform_default__generic-platform', true],
        ];

        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->will(self::returnValueMap($map));

        $platformData = (object) [
            'version' => (object) ['class' => Test::class],
            'manufacturer' => 'Unknown',
            'name' => null,
            'marketingName' => null,
        ];

        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with('platform_default__key')
            ->will(self::returnValue($platformData));

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $map = [
            ['test-key', 'platform_default__key'],
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
            ->expects(self::once())
            ->method('load')
            ->with('Unknown')
            ->willReturn(new Company('Unknown'));

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        /** @var CompanyLoader $companyLoader */
        $object = new PlatformLoader(
            $cache,
            $logger,
            $cacheKey,
            $companyLoader
        );

        $result = $object('test-key', 'test/12.0');

        self::assertInstanceOf(OsInterface::class, $result);
    }
}
