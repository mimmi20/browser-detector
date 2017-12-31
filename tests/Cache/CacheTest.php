<?php
declare(strict_types = 1);

namespace BrowserDetectorTest\Cache;

use BrowserDetector\Cache\Cache;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Simple\ArrayCache;

final class CacheTest extends TestCase
{
    public function testConstruct() : void
    {
        $adapter = new ArrayCache();
        $cache = new Cache($adapter);

        self::assertInstanceOf(Cache::class, $cache);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testVersion() : void
    {
        $adapter = new ArrayCache();
        $cache = new Cache($adapter);

        $cache->setItem('version', 6012);
        self::assertEquals(6012, $cache->getItem('version'));
    }
}
