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

use BrowserDetector\Data\Engine;
use BrowserDetector\Parser\Header\UseragentEngineCode;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\EngineParserInterface;

#[CoversClass(UseragentEngineCode::class)]
final class UseragentEngineCodeTest extends TestCase
{
    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa1')]
    public function testWithoutParsing(string $value, Engine $expected): void
    {
        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentEngineCode(engineParser: $engineParser, normalizer: $normalizer);

        self::assertTrue($header->hasEngineCode($value));
        self::assertSame(
            $expected,
            $header->getEngineCode($value),
        );
    }

    /**
     * @return array<int, array<int, Engine|string>>
     *
     * @throws void
     */
    public static function providerUa1(): array
    {
        return [
            ['pf(Linux);la(en-US);re(U2/1.0.0);dv(TECNO_S3);pr(UCBrowser/8.8.1.359);ov(4.2.2);pi(320*480);ss(320*480);up(U2/1.0.0);er(U);bt(GJ);pm(1);nm(0);im(0);sr(2);nt(99);', Engine::u2],
        ];
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa2')]
    public function testWithParsing(string $value, Engine $expected): void
    {
        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn($expected);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentEngineCode(engineParser: $engineParser, normalizer: $normalizer);

        self::assertTrue($header->hasEngineCode($value));
        self::assertSame(
            $expected,
            $header->getEngineCode($value),
        );
    }

    /**
     * @return array<int, array<int, Engine|string>>
     *
     * @throws void
     */
    public static function providerUa2(): array
    {
        return [
            ['WhatsApp/2.2587.9 W', Engine::unknown],
        ];
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUasWithoutDeviceCode2(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn('');

        $header = new UseragentEngineCode(engineParser: $engineParser, normalizer: $normalizer);

        self::assertTrue($header->hasEngineCode($value));
        self::assertSame(
            Engine::unknown,
            $header->getEngineCode($value),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUasWithoutDeviceCode3(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException(new \UaNormalizer\Normalizer\Exception\Exception('x'));

        $header = new UseragentEngineCode(engineParser: $engineParser, normalizer: $normalizer);

        self::assertTrue($header->hasEngineCode($value));
        self::assertSame(
            Engine::unknown,
            $header->getEngineCode($value),
        );
    }
}
