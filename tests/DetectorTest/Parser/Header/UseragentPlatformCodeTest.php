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

namespace Parser\Header;

use BrowserDetector\Data\Os;
use BrowserDetector\Parser\Header\UseragentPlatformCode;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\PlatformParserInterface;

#[CoversClass(UseragentPlatformCode::class)]
final class UseragentPlatformCodeTest extends TestCase
{
    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa1')]
    public function testWithUasWithoutDeviceCode(string $value, Os $expected): void
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

        $header = new UseragentPlatformCode(platformParser: $platformParser, normalizer: $normalizer);

        self::assertTrue($header->hasPlatformCode($value));
        self::assertSame(
            $expected,
            $header->getPlatformCode($value),
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
        ];
    }
}
