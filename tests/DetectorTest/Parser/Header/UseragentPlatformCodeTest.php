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

use BrowserDetector\Data\Os;
use BrowserDetector\Parser\Header\UseragentPlatformCode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\PlatformParserInterface;

#[CoversClass(className: UseragentPlatformCode::class)]
final class UseragentPlatformCodeTest extends TestCase
{
    /** @throws Exception */
    #[DataProvider(methodName: 'providerUa1')]
    public function testWithUas(string $value, Os $os): void
    {
        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $useragentPlatformCode = new UseragentPlatformCode(
            platformParser: $platformParser,
            normalizer: $normalizer,
        );

        self::assertTrue($useragentPlatformCode->hasPlatformCode($value));
        self::assertSame(
            $os,
            $useragentPlatformCode->getPlatformCode($value),
        );
    }

    /**
     * @return array<int, array<int, Os|string>>
     *
     * @throws void
     */
    public static function providerUa1(): array
    {
        return [
            ['WhatsApp/2.2587.9 A', Os::android],
            ['WhatsApp/2.2587.9 W', Os::windows],
            ['WhatsApp/2.2587.9 i', Os::ios],
            ['WhatsApp/2.2587.9 N', Os::macosx],
            ['WhatsApp/2.2587.9/i', Os::ios],
        ];
    }

    /** @throws Exception */
    public function testWithUas2(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

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

        $useragentPlatformCode = new UseragentPlatformCode(
            platformParser: $platformParser,
            normalizer: $normalizer,
        );

        self::assertTrue($useragentPlatformCode->hasPlatformCode($value));
        self::assertSame(
            Os::unknown,
            $useragentPlatformCode->getPlatformCode($value),
        );
    }

    /** @throws Exception */
    public function testWithUas3(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException(new \UaNormalizer\Normalizer\Exception\Exception('x'));

        $useragentPlatformCode = new UseragentPlatformCode(
            platformParser: $platformParser,
            normalizer: $normalizer,
        );

        self::assertTrue($useragentPlatformCode->hasPlatformCode($value));
        self::assertSame(
            Os::unknown,
            $useragentPlatformCode->getPlatformCode($value),
        );
    }

    /** @throws Exception */
    public function testWithUas4(): void
    {
        $value = 'A/8.1.0/ANS/L51/msm8909/unknown/QCX3/l3584062258010650401/-/+490760838/-/ANS/110712/110713/-/2.5/1/W';

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $useragentPlatformCode = new UseragentPlatformCode(
            platformParser: $platformParser,
            normalizer: $normalizer,
        );

        self::assertTrue($useragentPlatformCode->hasPlatformCode($value));
        self::assertSame(
            Os::android,
            $useragentPlatformCode->getPlatformCode($value),
        );
    }
}
