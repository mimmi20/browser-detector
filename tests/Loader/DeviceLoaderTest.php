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
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        DeviceLoader::resetInstance();
    }

    /**
     * @return void
     */
    public function testLoadNotAvailable(): void
    {
        $this->expectException('\BrowserDetector\Loader\NotFoundException');
        $this->expectExceptionMessage('the device with key "does not exist" was not found');

        $cache  = new FilesystemCache('', 0, 'cache/');
        $logger = new NullLogger();

        $object = DeviceLoader::getInstance(new Cache($cache), $logger);

        $object->load('does not exist', 'test-ua');
    }

    /**
     * @return void
     */
    public function testHasFail(): void
    {
        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem'])
            ->getMock();
        $cache->expects(self::once())->method('hasItem')->willThrowException(new InvalidArgumentException());

        $logger = new NullLogger();

        $object = DeviceLoader::getInstance($cache, $logger);

        self::assertFalse($object->has('does not exist'));
    }

    /**
     * @return void
     */
    public function testLoadFail(): void
    {
        $this->expectException('\BrowserDetector\Loader\NotFoundException');
        $this->expectExceptionMessage('the device with key "does not exist" was not found');

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();
        $cache->expects(self::once())->method('hasItem')->willReturn(true);
        $cache->expects(self::once())->method('getItem')->willThrowException(new InvalidArgumentException());

        $logger = new NullLogger();

        $object = DeviceLoader::getInstance($cache, $logger);

        $object->load('does not exist');
    }
}
