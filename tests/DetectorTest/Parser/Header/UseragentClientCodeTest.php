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

use BrowserDetector\Parser\Header\UseragentClientCode;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\BrowserParserInterface;
use UnexpectedValueException;

#[CoversClass(UseragentClientCode::class)]
final class UseragentClientCodeTest extends TestCase
{
    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa1')]
    public function testWithWithoutParsing(string $value, string $expected): void
    {
        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientCode(browserParser: $browserParser, normalizer: $normalizer);

        self::assertTrue($header->hasClientCode($value));
        self::assertSame(
            $expected,
            $header->getClientCode($value),
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
            ['Instagram 396.0.0.46.242 Android (35/15; 420dpi; 1080x2400; Xiaomi; 24030PN60G; aurora; qcom; de_DE; 785863896)', 'instagram app'],
            ['Virgin Radio/45.2.0.22026 / (Linux; Android 14) ExoPlayerLib/2.17.1 / samsung (SM-G996B)', 'virgin-radio'],
            ['TiviMate/4.7.0 (Onn. 4K Streaming Box; Android 12)', 'tivimate-app'],
            ['PugpigBolt 3.8.10 (samsung, Android 13) on phone (model SM-G998U)', 'pugpig-bolt'],
            ['NRC Audio/2.0.0 (nl.nrc.audio; build:29; Android 12; Sdk:31; Manufacturer:samsung; Model: SM-G975F) OkHttp/4.9.3', 'nrc-audio'],
            ['Classic FM/65.0.0 Android 12/vivo V2111', 'classic-fm'],
            ['com.huawei.hmos.browser (2in1;OpenHarmony-6.0.2.130;HAD-W24) NetworkSDK/8.0.10.309', 'huawei-browser'],
            ['Snapchat/10.86.0.55 (SM-A705FN; Android 10#A705FNXXU5BTF1#29; gzip) V/MUSHROOM', 'snapchat app'],
            ['dv(iPh4,1);pr(UCBrowser/10.2.0.517);ov(7_1_2);ss(320x416);bt(UC);pm(0);bv(0);nm(0);im(0);nt(1);', 'ucbrowser'],
        ];
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa2')]
    public function testWithWithParsing(string $value, string $expected): void
    {
        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
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

        $header = new UseragentClientCode(browserParser: $browserParser, normalizer: $normalizer);

        self::assertTrue($header->hasClientCode($value));
        self::assertSame(
            $expected,
            $header->getClientCode($value),
        );
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerUa2(): array
    {
        return [
            ['WhatsApp/2.2587.9 A', 'unknown'],
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

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn('');

        $header = new UseragentClientCode(browserParser: $browserParser, normalizer: $normalizer);

        self::assertTrue($header->hasClientCode($value));
        self::assertNull(
            $header->getClientCode($value),
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

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException(new \UaNormalizer\Normalizer\Exception\Exception('x'));

        $header = new UseragentClientCode(browserParser: $browserParser, normalizer: $normalizer);

        self::assertTrue($header->hasClientCode($value));
        self::assertNull(
            $header->getClientCode($value),
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

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn('');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientCode(browserParser: $browserParser, normalizer: $normalizer);

        self::assertTrue($header->hasClientCode($value));
        self::assertNull(
            $header->getClientCode($value),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUas5(): void
    {
        $value = 'A/8.1.0/ANS/L51/msm8909/unknown/QCX3/l3584062258010650401/-/+490760838/-/ANS/110712/110713/-/2.5/1/W';

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willThrowException(new UnexpectedValueException('z'));

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientCode(browserParser: $browserParser, normalizer: $normalizer);

        self::assertTrue($header->hasClientCode($value));
        self::assertNull(
            $header->getClientCode($value),
        );
    }

    /**
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUas6(): void
    {
        $value = 'A/8.1.0/ANS/L51/msm8909/unknown/QCX3/l3584062258010650401/-/+490760838/-/ANS/110712/110713/-/2.5/1/W';
        $code  = 'xyz';

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn($code);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentClientCode(browserParser: $browserParser, normalizer: $normalizer);

        self::assertTrue($header->hasClientCode($value));
        self::assertSame(
            $code,
            $header->getClientCode($value),
        );
    }
}
