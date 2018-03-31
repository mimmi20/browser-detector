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
use BrowserDetector\Loader\PlatformLoader;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use Symfony\Component\Cache\Simple\FilesystemCache;

/**
 * Test class for \BrowserDetector\Loader\PlatformLoader
 */
class PlatformLoaderTest extends TestCase
{
    /**
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testLoadNotAvailable(): void
    {
        $this->markTestSkipped();
//        $this->expectException('\BrowserDetector\Loader\NotFoundException');
//        $this->expectExceptionMessage('the platform with key "does not exist" was not found');
//
//        $cache  = new FilesystemCache('', 0, 'cache/');
//        $logger = new NullLogger();
//
//        $object = PlatformLoader::getInstance(new Cache($cache), $logger);
//
//        $object->load('does not exist', 'test-ua');
    }

    /**
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testHasFail(): void
    {
        $this->markTestSkipped();
//        $cache = $this->getMockBuilder(Cache::class)
//            ->disableOriginalConstructor()
//            ->setMethods(['hasItem'])
//            ->getMock();
//        $cache->expects(self::once())->method('hasItem')->willThrowException(new InvalidArgumentException());
//
//        $logger = new NullLogger();
//
//        $object = PlatformLoader::getInstance($cache, $logger);
//
//        self::assertFalse($object->has('does not exist'));
    }

    /**
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testLoadFail(): void
    {
        $this->markTestSkipped();
//        $this->expectException('\BrowserDetector\Loader\NotFoundException');
//        $this->expectExceptionMessage('the platform with key "does not exist" was not found');
//
//        $cache = $this->getMockBuilder(Cache::class)
//            ->disableOriginalConstructor()
//            ->setMethods(['hasItem', 'getItem'])
//            ->getMock();
//        $cache->expects(self::once())->method('hasItem')->willReturn(true);
//        $cache->expects(self::once())->method('getItem')->willThrowException(new InvalidArgumentException());
//
//        $logger = new NullLogger();
//
//        $object = PlatformLoader::getInstance($cache, $logger);
//
//        $object->load('does not exist');
    }
}
