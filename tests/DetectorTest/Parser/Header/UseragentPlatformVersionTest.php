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

use BrowserDetector\Data\Company;
use BrowserDetector\Data\Os;
use BrowserDetector\Parser\Header\UseragentPlatformVersion;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionInterface;
use JsonException;
use Override;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use UaLoader\Exception\NotFoundException;
use UaLoader\PlatformLoaderInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\PlatformParserInterface;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function json_encode;

use const JSON_THROW_ON_ERROR;

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
        $platformLoader
            ->expects(self::never())
            ->method('loadFromOs');

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
        $platformLoader
            ->expects(self::never())
            ->method('loadFromOs');

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
        $platformLoader
            ->expects(self::never())
            ->method('loadFromOs');

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
    public function testWithNormalizer3(): void
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
        $platformLoader
            ->expects(self::never())
            ->method('loadFromOs');

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
        self::assertInstanceOf(
            ForcedNullVersion::class,
            $header->getPlatformVersion($value, 'wrong value'),
        );
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithNormalizer4(): void
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
        $platformLoader
            ->expects(self::never())
            ->method('loadFromOs');

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
        self::assertInstanceOf(
            ForcedNullVersion::class,
            $header->getPlatformVersionWithOs($value, Os::android),
        );
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
        $platformLoader
            ->expects(self::never())
            ->method('loadFromOs');

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
    public function testWithUasWithPlatformVersion(string $value, string | null $expectedVersion): void
    {
        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');
        $platformLoader
            ->expects(self::never())
            ->method('loadFromOs');

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

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa3')]
    public function testWithUasWithPlatformVersion2(string $value, string $expectedVersion): void
    {
        $code = Os::android;

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($expectedVersion);

        $os = $this->createMock(OsInterface::class);
        $os
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn($version);

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn($code);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');
        $platformLoader
            ->expects(self::once())
            ->method('loadFromOs')
            ->with($code, $value)
            ->willReturn($os);

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
    public static function providerUa3(): array
    {
        return [
            ['Gospel_Library 2.6.1.7 / Android 4.3 279372.1 / HTC HTC One max', '4.3.0'],
        ];
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa4')]
    public function testWithUasWithoutPlatformVersion2(string $value, \UaData\OsInterface $os): void
    {
        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn($os);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');
        $platformLoader
            ->expects(self::never())
            ->method('loadFromOs');

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
     * @return array<int, array<int, Os::unknown|string>>
     *
     * @throws void
     */
    public static function providerUa4(): array
    {
        return [
            ['Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko; compatible; pageburst) Chrome/141.0.7390.122 Safari/537.36', Os::unknown],
        ];
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUasWithoutPlatformVersion3(): void
    {
        $value = 'Gospel_Library 2.6.1.7 / Android 4.3 279372.1 / HTC HTC One max';
        $os    = Os::android;

        $loadedOs = new \UaResult\Os\Os(
            name: 'Android',
            marketingName: 'Android',
            manufacturer: Company::unknown,
            version: new NullVersion(),
        );

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn($os);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');
        $platformLoader
            ->expects(self::once())
            ->method('loadFromOs')
            ->with($os, $value)
            ->willReturn($loadedOs);

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
        self::assertInstanceOf(NullVersion::class, $header->getPlatformVersion($value));
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUasWithoutPlatformVersion4(): void
    {
        $value = 'Gospel_Library 2.6.1.7 / Android 4.3 279372.1 / HTC HTC One max';
        $os    = Os::android;

        $exception = new NotFoundException('not found');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn($os);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');
        $platformLoader
            ->expects(self::once())
            ->method('loadFromOs')
            ->with($os, $value)
            ->willThrowException($exception);

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
        self::assertInstanceOf(NullVersion::class, $header->getPlatformVersion($value));
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testWithUasWithoutPlatformVersion5(): void
    {
        $value = 'Gospel_Library 2.6.1.7 / Android 4.3 279372.1 / HTC HTC One max';
        $os    = Os::android;

        $loadedOs = new \UaResult\Os\Os(
            name: 'Android',
            marketingName: 'Android',
            manufacturer: Company::unknown,
            version: new readonly class ([]) implements VersionInterface {
                /**
                 * @param array<int, bool|string|null> $searches
                 *
                 * @throws void
                 */
                public function __construct(private array $searches)
                {
                    // nothing to do
                }

                /**
                 * returns the detected version
                 *
                 * @throws UnexpectedValueException
                 * @throws JsonException
                 */
                #[Override]
                public function getVersion(int $mode = VersionInterface::COMPLETE): string | null
                {
                    throw new UnexpectedValueException(
                        $mode . '::' . json_encode($this->searches, JSON_THROW_ON_ERROR),
                    );
                }

                /**
                 * @return array<string, string|null>
                 *
                 * @throws void
                 */
                #[Override]
                public function toArray(): array
                {
                    return [];
                }

                /** @throws void */
                #[Override]
                public function getMajor(): string | null
                {
                    return null;
                }

                /** @throws void */
                #[Override]
                public function getMinor(): string | null
                {
                    return null;
                }

                /** @throws void */
                #[Override]
                public function getMicro(): string | null
                {
                    return null;
                }

                /** @throws void */
                #[Override]
                public function getPatch(): string | null
                {
                    return null;
                }

                /** @throws void */
                #[Override]
                public function getMicropatch(): string | null
                {
                    return null;
                }

                /** @throws void */
                #[Override]
                public function getBuild(): string | null
                {
                    return null;
                }

                /** @throws void */
                #[Override]
                public function getStability(): string | null
                {
                    return null;
                }

                /** @throws void */
                #[Override]
                public function isAlpha(): bool
                {
                    return false;
                }

                /** @throws void */
                #[Override]
                public function isBeta(): bool
                {
                    return false;
                }
            },
        );

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn($os);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');
        $platformLoader
            ->expects(self::once())
            ->method('loadFromOs')
            ->with($os, $value)
            ->willReturn($loadedOs);

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
        self::assertInstanceOf(NullVersion::class, $header->getPlatformVersion($value));
    }
}
