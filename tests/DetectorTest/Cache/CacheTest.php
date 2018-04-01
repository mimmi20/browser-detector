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
namespace BrowserDetectorTest\Cache;

use BrowserDetector\Cache\Cache;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Simple\ArrayCache;

final class CacheTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstruct(): void
    {
        $adapter = new ArrayCache();
        $cache   = new Cache($adapter);

        self::assertInstanceOf(Cache::class, $cache);
    }

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
}
