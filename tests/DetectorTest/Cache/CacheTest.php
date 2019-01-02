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
namespace BrowserDetectorTest\Cache;

use BrowserDetector\Cache\Cache;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Simple\ArrayCache;

final class CacheTest extends TestCase
{
    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testVersion(): void
    {
        $adapter = new ArrayCache();
        $cache   = new Cache($adapter);

        $cache->setItem('version', 6012);
        self::assertEquals(6012, $cache->getItem('version'));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testHasNotItem(): void
    {
        $adapter = $this->getMockBuilder(ArrayCache::class)
            ->disableOriginalConstructor()
            ->getMock();
        $adapter
            ->expects(self::once())
            ->method('has')
            ->with('version')
            ->will(self::returnValue(false));
        $adapter
            ->expects(self::once())
            ->method('set')
            ->will(self::returnValue(false));
        $adapter
            ->expects(self::never())
            ->method('get')
            ->will(self::returnValue(null));

        /** @var ArrayCache $adapter */
        $cache = new Cache($adapter);

        self::assertFalse($cache->setItem('version', 6012));
        self::assertNull($cache->getItem('version'));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testHasNotItem2(): void
    {
        $adapter = $this->getMockBuilder(ArrayCache::class)
            ->disableOriginalConstructor()
            ->getMock();
        $adapter
            ->expects(self::once())
            ->method('has')
            ->with('version')
            ->will(self::returnValue(true));
        $adapter
            ->expects(self::once())
            ->method('set')
            ->will(self::returnValue(false));
        $adapter
            ->expects(self::once())
            ->method('get')
            ->with('version')
            ->will(self::returnValue(null));

        /** @var ArrayCache $adapter */
        $cache = new Cache($adapter);

        self::assertFalse($cache->setItem('version', 6012));
        self::assertNull($cache->getItem('version'));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testHasNotItem3(): void
    {
        $adapter = $this->getMockBuilder(ArrayCache::class)
            ->disableOriginalConstructor()
            ->getMock();
        $adapter
            ->expects(self::once())
            ->method('has')
            ->with('version')
            ->will(self::returnValue(false));
        $adapter
            ->expects(self::never())
            ->method('set')
            ->will(self::returnValue(false));
        $adapter
            ->expects(self::never())
            ->method('get')
            ->will(self::returnValue(null));

        /** @var ArrayCache $adapter */
        $cache = new Cache($adapter);

        self::assertFalse($cache->hasItem('version'));
    }
}
