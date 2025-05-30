<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Cache;

use BrowserDetector\Cache\Cache;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

use function assert;
use function serialize;

#[CoversClass(Cache::class)]
final class CacheTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testVersion(): void
    {
        $version = 6012;
        $cacheId = 'version';

        $adapter = $this->createMock(CacheInterface::class);
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
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testHasNotItem(): void
    {
        $adapter = $this->createMock(CacheInterface::class);
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
            ->method('get');

        assert($adapter instanceof CacheInterface);
        $cache = new Cache($adapter);

        self::assertFalse($cache->setItem('version', 6012));
        self::assertNull($cache->getItem('version'));
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testHasNotItem2(): void
    {
        $adapter = $this->createMock(CacheInterface::class);
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
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testHasNotItem3(): void
    {
        $adapter = $this->createMock(CacheInterface::class);
        $adapter
            ->expects(self::once())
            ->method('has')
            ->with('version')
            ->willReturn(false);
        $adapter
            ->expects(self::never())
            ->method('set');
        $adapter
            ->expects(self::never())
            ->method('get');

        assert($adapter instanceof CacheInterface);
        $cache = new Cache($adapter);

        self::assertFalse($cache->hasItem('version'));
    }
}
