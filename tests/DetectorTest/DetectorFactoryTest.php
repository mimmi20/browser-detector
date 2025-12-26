<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest;

use BrowserDetector\Detector;
use BrowserDetector\DetectorFactory;
use Laminas\Hydrator\Exception\InvalidArgumentException;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use RuntimeException;

use function assert;

#[CoversClass(DetectorFactory::class)]
final class DetectorFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws RuntimeException
     * @throws InvalidArgumentException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvoke(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
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

        $cache = $this->createMock(CacheInterface::class);
        $cache
            ->expects(self::never())
            ->method('get');
        $cache
            ->expects(self::never())
            ->method('set');
        $cache
            ->expects(self::never())
            ->method('delete');
        $cache
            ->expects(self::never())
            ->method('clear');
        $cache
            ->expects(self::never())
            ->method('getMultiple');
        $cache
            ->expects(self::never())
            ->method('setMultiple');
        $cache
            ->expects(self::never())
            ->method('deleteMultiple');
        $cache
            ->expects(self::never())
            ->method('has');

        assert($logger instanceof LoggerInterface);
        assert($cache instanceof CacheInterface);
        $factory = new DetectorFactory($cache, $logger);
        $object  = $factory();

        self::assertInstanceOf(Detector::class, $object);

        $objectTwo = $factory();

        self::assertInstanceOf(Detector::class, $objectTwo);
        self::assertSame($objectTwo, $object);
    }
}
