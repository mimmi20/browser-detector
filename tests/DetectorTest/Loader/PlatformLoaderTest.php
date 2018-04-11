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
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Exception\InvalidArgumentException;

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

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        $object = new PlatformLoader(
            $cache,
            $logger,
            $cacheKey
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

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var CacheKey $cacheKey */
        $object = new PlatformLoader(
            $cache,
            $logger,
            $cacheKey
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the platform with key "test-key" was not found');

        $object('test-key', 'test-ua');
    }
}
