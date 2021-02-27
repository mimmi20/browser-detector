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
namespace BrowserDetectorTest\Cache;

use BrowserDetector\Cache\Cache;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

final class CacheTest extends TestCase
{
    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     *
     * @return void
     */
    public function testVersion(): void
    {
        $version = 6012;
        $cacheId = 'version';

        $adapter = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalClone()
            ->getMock();
        $adapter
            ->expects(self::once())
            ->method('set')
            ->with($cacheId, ['content' => serialize($version)])
            ->willReturn(true);
        $adapter
            ->expects(self::once())
            ->method('has')
            ->with($cacheId)
            ->willReturn(true);
        $adapter
            ->expects(self::once())
            ->method('get')
            ->with($cacheId)
            ->willReturn(['content' => serialize($version)]);

        $cache = new Cache($adapter);

        $cache->setItem($cacheId, $version);
        self::assertSame($version, $cache->getItem($cacheId));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     *
     * @return void
     */
    public function testHasNotItem(): void
    {
        $adapter = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $adapter
            ->expects(self::once())
            ->method('has')
            ->with('version')
            ->willReturn(false);
        $adapter
            ->expects(self::once())
            ->method('set')
            ->willReturn(false);
        $adapter
            ->expects(self::never())
            ->method('get')
            ->willReturn(null);

        \assert($adapter instanceof CacheInterface);
        $cache = new Cache($adapter);

        self::assertFalse($cache->setItem('version', 6012));
        self::assertNull($cache->getItem('version'));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     *
     * @return void
     */
    public function testHasNotItem2(): void
    {
        $adapter = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $adapter
            ->expects(self::once())
            ->method('has')
            ->with('version')
            ->willReturn(true);
        $adapter
            ->expects(self::once())
            ->method('set')
            ->willReturn(false);
        $adapter
            ->expects(self::once())
            ->method('get')
            ->with('version')
            ->willReturn(null);

        \assert($adapter instanceof CacheInterface);
        $cache = new Cache($adapter);

        self::assertFalse($cache->setItem('version', 6012));
        self::assertNull($cache->getItem('version'));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     *
     * @return void
     */
    public function testHasNotItem3(): void
    {
        $adapter = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $adapter
            ->expects(self::once())
            ->method('has')
            ->with('version')
            ->willReturn(false);
        $adapter
            ->expects(self::never())
            ->method('set')
            ->willReturn(false);
        $adapter
            ->expects(self::never())
            ->method('get')
            ->willReturn(null);

        \assert($adapter instanceof CacheInterface);
        $cache = new Cache($adapter);

        self::assertFalse($cache->hasItem('version'));
    }
}
