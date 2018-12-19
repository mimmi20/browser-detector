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
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

class DetectorFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        self::markTestIncomplete();
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $cache = new FilesystemCache('', 0, 'cache/');

        /** @var \Psr\Log\LoggerInterface $logger */
        $factory = new DetectorFactory($cache, $logger);
        $object  = $factory();

        self::assertInstanceOf(Detector::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(Detector::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
