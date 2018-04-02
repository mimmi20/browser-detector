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
namespace BrowserDetectorTest;

use BrowserDetector\Detector;
use BrowserDetector\DetectorFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Simple\FilesystemCache;

class DetectorFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $logger = new NullLogger();
        $cache  = new FilesystemCache('', 0, __DIR__ . '/../../cache/');

        $factory = new DetectorFactory($cache, $logger);
        $object  = $factory();

        self::assertInstanceOf(Detector::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(Detector::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
