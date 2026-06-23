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

use BrowserDetector\Parser\Header\UseragentDeviceCode;
use BrowserDetector\Parser\Helper\DeviceInterface;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\DeviceParserInterface;

use function mb_strtolower;

#[CoversClass(UseragentDeviceCode::class)]
final class UseragentDeviceCodeTest extends TestCase
{
    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa1')]
    public function testWithUasWithoutDeviceCode(string $value, string $expected): void
    {
        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::never())
            ->method('getDeviceCode');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentDeviceCode(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            deviceCodeHelper: $deviceCodeHelper,
        );

        self::assertTrue($header->hasDeviceCode($value));
        self::assertSame(
            $expected,
            $header->getDeviceCode($value),
        );
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerUa1(): array
    {
        return [
            ['WhatsApp/2.2587.9 A', 'unknown=general mobile phone'],
            ['WhatsApp/2.2587.9 W', 'unknown=windows desktop'],
            ['WhatsApp/2.2587.9 i', 'apple=general apple device'],
            ['WhatsApp/2.2587.9 N', 'apple=macintosh'],
            ['WhatsApp/2.2587.9/i', 'apple=general apple device'],
        ];
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUas2(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::never())
            ->method('getDeviceCode');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn('');

        $header = new UseragentDeviceCode(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            deviceCodeHelper: $deviceCodeHelper,
        );

        self::assertTrue($header->hasDeviceCode($value));
        self::assertNull(
            $header->getDeviceCode($value),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUas3(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::never())
            ->method('getDeviceCode');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException(new \UaNormalizer\Normalizer\Exception\Exception('x'));

        $header = new UseragentDeviceCode(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            deviceCodeHelper: $deviceCodeHelper,
        );

        self::assertTrue($header->hasDeviceCode($value));
        self::assertNull(
            $header->getDeviceCode($value),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUas4(): void
    {
        $value = 'A/8.1.0/ANS/L51/msm8909/unknown/QCX3/l3584062258010650401/-/+490760838/-/ANS/110712/110713/-/2.5/1/W';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn('');

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::once())
            ->method('getDeviceCode')
            ->with(mb_strtolower($value))
            ->willReturn(null);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentDeviceCode(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            deviceCodeHelper: $deviceCodeHelper,
        );

        self::assertTrue($header->hasDeviceCode($value));
        self::assertNull(
            $header->getDeviceCode($value),
        );
    }
}
