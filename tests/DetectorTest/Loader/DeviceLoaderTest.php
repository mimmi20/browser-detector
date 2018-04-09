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
use BrowserDetector\Loader\Helper\CacheKey;
use BrowserDetector\Loader\Helper\InitRules;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Seld\JsonLint\JsonParser;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use Symfony\Component\Finder\Finder;

class DeviceLoaderTest extends TestCase
{
    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $this->markTestSkipped();
        $logger = $this->createMock(NullLogger::class);

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->will(self::returnValue(true));
        $cache
            ->expects(self::once())
            ->method('getItem')
            ->will(self::returnValue(true));

        $finder = $this->getMockBuilder(Finder::class)
            ->disableOriginalConstructor()
            ->setMethods(['in'])
            ->getMock();
        $finder
            ->expects(self::any())
            ->method('in')
            ->will(self::returnSelf());

        $jsonParser = $this->createMock(JsonParser::class);
        $cacheKey   = $this->createMock(CacheKey::class);
        $initRules  = $this->createMock(InitRules::class);

        /** @var Cache $cache */
        /** @var NullLogger $logger */
        /** @var Finder $finder */
        /** @var JsonParser $jsonParser */
        /** @var CacheKey $cacheKey */
        /** @var InitRules $initRules */
        $object = new DeviceLoader(
            $cache,
            $logger,
            $finder,
            $jsonParser,
            $cacheKey,
            $initRules
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "does not exist" was not found');

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
