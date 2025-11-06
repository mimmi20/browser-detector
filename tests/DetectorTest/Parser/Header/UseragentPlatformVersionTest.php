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

use BrowserDetector\Parser\Header\UseragentPlatformVersion;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\Version;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use UaLoader\PlatformLoaderInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\PlatformParserInterface;

#[CoversClass(UseragentPlatformVersion::class)]
final class UseragentPlatformVersionTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithNormalizerException(): void
    {
        $value = 'abc';

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException(new Exception('x'));

        $header = new UseragentPlatformVersion(
            platformParser: $platformParser,
            platformLoader: $platformLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasPlatformVersion($value));
        self::assertInstanceOf(ForcedNullVersion::class, $header->getPlatformVersion($value));
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithNormalizer1(): void
    {
        $value = 'abc';

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn('');

        $header = new UseragentPlatformVersion(
            platformParser: $platformParser,
            platformLoader: $platformLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasPlatformVersion($value));
        self::assertInstanceOf(ForcedNullVersion::class, $header->getPlatformVersion($value));
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithNormalizer2(): void
    {
        $value = 'abc';

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn(null);

        $header = new UseragentPlatformVersion(
            platformParser: $platformParser,
            platformLoader: $platformLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasPlatformVersion($value));
        self::assertInstanceOf(ForcedNullVersion::class, $header->getPlatformVersion($value));
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa1')]
    public function testWithUasWithoutPlatformVersion(string $value): void
    {
        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentPlatformVersion(
            platformParser: $platformParser,
            platformLoader: $platformLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasPlatformVersion($value));
        self::assertInstanceOf(ForcedNullVersion::class, $header->getPlatformVersion($value));
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerUa1(): array
    {
        return [
            ['Android 17 - samsung meliuslte'],
            ['News Republic/12.1.5 (Linux; Android 26) Mobile Safari'],
            ['APP : Mozilla/5.0 (Linux; Android 23 ; LENOVO ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.98 Mobile Safari/537.36;mm-app-v2.0'],
            ['Mozilla/5.0 (Linux; Android 30.0.0 IOS; SM-A900F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.143 Mobile Safari/537.36'],
            ['SM-T970 (compatible; Tablet2.0) HandelsbladProduction, com.twipemobile.nrc 5.1.4 (511) / Android 33'],
            ['WNYC App/3.0.3 Android/24 device/Verizon-SM-G930V'],
        ];
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa2')]
    public function testWithUasWithPlatformVersion(string $value, string $expectedVersion): void
    {
        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $header = new UseragentPlatformVersion(
            platformParser: $platformParser,
            platformLoader: $platformLoader,
            normalizer: $normalizer,
        );

        self::assertTrue($header->hasPlatformVersion($value));

        $version = $header->getPlatformVersion($value);
        self::assertInstanceOf(Version::class, $version);
        self::assertSame($expectedVersion, $version->getVersion());
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerUa2(): array
    {
        return [
            ['dv(iPh4,1);pr(UCBrowser/10.2.0.517);ov(7_1_2);ss(320x416);bt(UC);pm(0);bv(0);nm(0);im(0);nt(1);', '7.1.2'],
            ['pf(Linux);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(Android 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);', '4.2.2'],
            ['Instagram 396.0.0.46.242 Android (35/15; 420dpi; 1080x2400; Xiaomi; 24030PN60G; aurora; qcom; de_DE; 785863896)', '15.0.0'],
            ['ICQ_Android/5.0 (Android; 17; 4.2.2; eng.rd2version.1388046998; Philips W8555; ru-RU)', '4.2.2'],
            ['GG-Android/4.0.0.20098 (OS;Android;17) (HWD;asus;ASUS Transformer Pad TF300T;4.2.1)', '4.2.1'],
        ];
    }
}
