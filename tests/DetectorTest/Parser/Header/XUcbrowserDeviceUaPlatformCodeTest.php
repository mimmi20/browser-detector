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

namespace BrowserDetectorTest\Parser\Header;

use BrowserDetector\Parser\Header\XUcbrowserDeviceUaPlatformCode;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\PlatformParserInterface;

#[CoversClass(XUcbrowserDeviceUaPlatformCode::class)]
final class XUcbrowserDeviceUaPlatformCodeTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetPlatformCodeWithNormalizerException(): void
    {
        $value     = 'test-value';
        $derivate  = null;
        $exception = new Exception('test');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException($exception);

        $object = new XUcbrowserDeviceUaPlatformCode(
            platformParser: $platformParser,
            normalizer: $normalizer,
        );

        self::assertNull($object->getPlatformCode($value, $derivate));
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetPlatformCode(): void
    {
        $value    = 'test-value';
        $derivate = null;

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn(null);

        $object = new XUcbrowserDeviceUaPlatformCode(
            platformParser: $platformParser,
            normalizer: $normalizer,
        );

        self::assertNull($object->getPlatformCode($value, $derivate));
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetPlatformCode2(): void
    {
        $value    = 'test-value';
        $derivate = null;

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn('');

        $object = new XUcbrowserDeviceUaPlatformCode(
            platformParser: $platformParser,
            normalizer: $normalizer,
        );

        self::assertNull($object->getPlatformCode($value, $derivate));
    }
}
