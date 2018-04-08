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
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\EngineLoaderFactory;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Exception\InvalidArgumentException;

class EngineLoaderTest extends TestCase
{
    /**
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testLoadNotAvailable(): void
    {
        $this->markTestSkipped();
        /** @var NullLogger $logger */
        $logger = $this->createMock(NullLogger::class);

        /** @var Cache $cache */
        $cache = $this->createMock(Cache::class);

        $factory = new EngineLoaderFactory($cache, $logger);
        $object  = $factory();

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the engine with key "does not exist" was not found');

        $object->load('does not exist', 'test-ua');
    }

    /**
     * @throws \ReflectionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $this->markTestSkipped();
        /** @var NullLogger $logger */
        $logger = $this->createMock(NullLogger::class);

        /** @var Cache $cache */
        $cache = $this->createMock(Cache::class);

        $factory = new EngineLoaderFactory($cache, $logger);
        $object  = $factory();

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the engine with key "does not exist" was not found');

        $object('test-ua');
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
//        $object = EngineLoader::getInstance($cache, $logger);
//
//        self::assertFalse($object->has('does not exist'));
    }

    /**
     * @return void
     */
    public function testLoadFail(): void
    {
        $this->markTestSkipped();
//        $this->expectException('\BrowserDetector\Loader\NotFoundException');
//        $this->expectExceptionMessage('the engine with key "does not exist" was not found');
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
//        $object = EngineLoader::getInstance($cache, $logger);
//
//        $object->load('does not exist');
    }
}
