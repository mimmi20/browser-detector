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
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;

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
        $adapter = new Psr16Cache(new ArrayAdapter());
        $cache   = new Cache($adapter);

        $cache->setItem('version', 6012);
        static::assertSame(6012, $cache->getItem('version'));
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
        $adapter = $this->getMockBuilder(Psr16Cache::class)
            ->disableOriginalConstructor()
            ->getMock();
        $adapter
            ->expects(static::once())
            ->method('has')
            ->with('version')
            ->willReturn(false);
        $adapter
            ->expects(static::once())
            ->method('set')
            ->willReturn(false);
        $adapter
            ->expects(static::never())
            ->method('get')
            ->willReturn(null);

        /** @var Psr16Cache $adapter */
        $cache = new Cache($adapter);

        static::assertFalse($cache->setItem('version', 6012));
        static::assertNull($cache->getItem('version'));
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
        $adapter = $this->getMockBuilder(Psr16Cache::class)
            ->disableOriginalConstructor()
            ->getMock();
        $adapter
            ->expects(static::once())
            ->method('has')
            ->with('version')
            ->willReturn(true);
        $adapter
            ->expects(static::once())
            ->method('set')
            ->willReturn(false);
        $adapter
            ->expects(static::once())
            ->method('get')
            ->with('version')
            ->willReturn(null);

        /** @var Psr16Cache $adapter */
        $cache = new Cache($adapter);

        static::assertFalse($cache->setItem('version', 6012));
        static::assertNull($cache->getItem('version'));
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
        $adapter = $this->getMockBuilder(Psr16Cache::class)
            ->disableOriginalConstructor()
            ->getMock();
        $adapter
            ->expects(static::once())
            ->method('has')
            ->with('version')
            ->willReturn(false);
        $adapter
            ->expects(static::never())
            ->method('set')
            ->willReturn(false);
        $adapter
            ->expects(static::never())
            ->method('get')
            ->willReturn(null);

        /** @var Psr16Cache $adapter */
        $cache = new Cache($adapter);

        static::assertFalse($cache->hasItem('version'));
    }
}
