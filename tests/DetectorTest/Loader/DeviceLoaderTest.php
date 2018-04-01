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
use BrowserDetector\Loader\DeviceLoader;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use Symfony\Component\Cache\Simple\FilesystemCache;

/**
 * Test class for \BrowserDetector\Loader\DeviceLoader
 */
class DeviceLoaderTest extends TestCase
{
    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testLoadNotAvailable(): void
    {
        $this->markTestSkipped();
//        $this->expectException('\BrowserDetector\Loader\NotFoundException');
//        $this->expectExceptionMessage('the device with key "does not exist" was not found');
//
//        $cache  = new FilesystemCache('', 0, 'cache/');
//        $logger = new NullLogger();
//
//        $object = new DeviceLoader(new Cache($cache), $logger, '.', '');
//
//        $object->load('does not exist', 'test-ua');
    }

    /**
     * @return void
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
//        $object = new DeviceLoader(new Cache($cache), $logger, '.', '');
//
//        self::assertFalse($object->has('does not exist'));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testLoadFail(): void
    {
        $this->markTestSkipped();
//        $this->expectException('\BrowserDetector\Loader\NotFoundException');
//        $this->expectExceptionMessage('the device with key "does not exist" was not found');
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
//        $object = new DeviceLoader(new Cache($cache), $logger, '.', '');
//
//        $object->load('does not exist');
    }
}
