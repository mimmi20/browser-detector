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
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

use function assert;
use function serialize;

final class CacheTest extends TestCase
{
    private const VERSION  = 6012;
    private const CACHE_ID = 'version';

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testVersion(): void
    {
        $adapter = $this->getMockBuilder(CacheInterface::class)
            ->disableOriginalClone()
            ->getMock();
        $adapter
            ->expects(self::once())
            ->method('set')
            ->with(self::CACHE_ID, ['content' => serialize(self::VERSION)])
            ->willReturn(true);
        $adapter
            ->expects(self::once())
            ->method('has')
            ->with(self::CACHE_ID)
            ->willReturn(true);
        $adapter
            ->expects(self::once())
            ->method('get')
            ->with(self::CACHE_ID)
            ->willReturn(['content' => serialize(self::VERSION)]);

        $cache = new Cache($adapter);

        $cache->setItem(self::CACHE_ID, self::VERSION);
        self::assertSame(self::VERSION, $cache->getItem(self::CACHE_ID));
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
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

        assert($adapter instanceof CacheInterface);
        $cache = new Cache($adapter);

        self::assertFalse($cache->setItem('version', 6012));
        self::assertNull($cache->getItem('version'));
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
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

        assert($adapter instanceof CacheInterface);
        $cache = new Cache($adapter);

        self::assertFalse($cache->setItem('version', 6012));
        self::assertNull($cache->getItem('version'));
    }

    /**
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
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

        assert($adapter instanceof CacheInterface);
        $cache = new Cache($adapter);

        self::assertFalse($cache->hasItem('version'));
    }
}
