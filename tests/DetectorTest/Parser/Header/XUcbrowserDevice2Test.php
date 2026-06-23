<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Parser\Header;

use BrowserDetector\Parser\Header\XUcbrowserDevice;
use BrowserDetector\Parser\Helper\DeviceInterface;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\DeviceParserInterface;

#[CoversClass(XUcbrowserDevice::class)]
final class XUcbrowserDevice2Test extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetDeviceCodeWithNormalizerException(): void
    {
        $value     = 'test-value';
        $exception = new Exception('test');

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException($exception);

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::never())
            ->method('getDeviceCode');

        $object = new XUcbrowserDevice(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            deviceCodeHelper: $deviceCodeHelper,
        );

        self::assertNull($object->getDeviceCode($value));
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetDeviceCode(): void
    {
        $value = 'test-value';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn(null);

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::never())
            ->method('getDeviceCode');

        $object = new XUcbrowserDevice(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            deviceCodeHelper: $deviceCodeHelper,
        );

        self::assertNull($object->getDeviceCode($value));
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetDeviceCode2(): void
    {
        $value = 'test-value';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn('');

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::never())
            ->method('getDeviceCode');

        $object = new XUcbrowserDevice(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            deviceCodeHelper: $deviceCodeHelper,
        );

        self::assertNull($object->getDeviceCode($value));
    }
}
