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

use BrowserDetector\Data\Engine;
use BrowserDetector\Parser\Header\XOperaminiPhoneUaEngineCode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\EngineParserInterface;

#[CoversClass(className: XOperaminiPhoneUaEngineCode::class)]
final class XOperaminiPhoneUaEngineCodeTest extends TestCase
{
    /** @throws \PHPUnit\Framework\Exception */
    public function testGetDeviceCodeWithNormalizerException(): void
    {
        $value     = 'test-value';
        $exception = new Exception('test');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException($exception);

        $xOperaminiPhoneUaEngineCode = new XOperaminiPhoneUaEngineCode(
            engineParser: $engineParser,
            normalizer: $normalizer,
        );

        self::assertSame(Engine::unknown, $xOperaminiPhoneUaEngineCode->getEngineCode($value));
    }

    /** @throws \PHPUnit\Framework\Exception */
    public function testGetDeviceCode(): void
    {
        $value = 'test-value';

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn(value: null);

        $xOperaminiPhoneUaEngineCode = new XOperaminiPhoneUaEngineCode(
            engineParser: $engineParser,
            normalizer: $normalizer,
        );

        self::assertSame(Engine::unknown, $xOperaminiPhoneUaEngineCode->getEngineCode($value));
    }

    /** @throws \PHPUnit\Framework\Exception */
    public function testGetDeviceCode2(): void
    {
        $value = 'test-value';

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

        $xOperaminiPhoneUaEngineCode = new XOperaminiPhoneUaEngineCode(
            engineParser: $engineParser,
            normalizer: $normalizer,
        );

        self::assertSame(Engine::unknown, $xOperaminiPhoneUaEngineCode->getEngineCode($value));
    }
}
