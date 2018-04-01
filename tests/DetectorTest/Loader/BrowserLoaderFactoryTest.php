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
use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\BrowserLoaderFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use Symfony\Component\Cache\Simple\FilesystemCache;

class BrowserLoaderFactoryTest extends TestCase
{
    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testInvoke(): void
    {
        /** @var NullLogger $logger */
        $logger = $this->createMock(NullLogger::class);

        /** @var Cache $cache */
        $cache = $this->createMock(Cache::class);

        $factory = new BrowserLoaderFactory($cache, $logger);
        $object  = $factory('default');

        self::assertInstanceOf(BrowserLoader::class, $object);

        $objectTwo = $factory('default');

        self::assertInstanceOf(BrowserLoader::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
