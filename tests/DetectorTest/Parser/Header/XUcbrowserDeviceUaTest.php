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
use BrowserDetector\Data\Os;
use BrowserDetector\Parser\Header\XUcbrowserDeviceUaDeviceCode;
use BrowserDetector\Parser\Header\XUcbrowserDeviceUaPlatformCode;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\NormalizerFactory;
use UaParser\DeviceParserInterface;
use UaParser\PlatformParserInterface;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\XUcbrowserDeviceUa;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;

use function sprintf;

#[CoversClass(XUcbrowserDeviceUaDeviceCode::class)]
#[CoversClass(XUcbrowserDeviceUaPlatformCode::class)]
final class XUcbrowserDeviceUaTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     * @throws NotFoundException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider('providerUa')]
    public function testData(
        string $ua,
        bool $hasDeviceInfo,
        string $deviceCode,
        bool $hasPlatformInfo,
        Os $platformCode,
    ): void {
        $deviceIsNull   = false;
        $platformIsNull = false;

        if ($deviceCode === '') {
            $deviceIsNull = true;
        }

        if ($platformCode === Os::unknown) {
            $platformIsNull = true;
        }

        $normalizerFactory = new NormalizerFactory();
        $normalizer        = $normalizerFactory->build();

        $normalitedUa = $normalizer->normalize($ua);

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects($ua === '?' ? self::never() : self::once())
            ->method('parse')
            ->with($normalitedUa)
            ->willReturn($deviceCode);

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects($ua === '?' ? self::never() : self::once())
            ->method('parse')
            ->with($normalitedUa)
            ->willReturn($platformCode);

        $header = new XUcbrowserDeviceUa(
            value: $ua,
            deviceCode: new XUcbrowserDeviceUaDeviceCode(
                deviceParser: $deviceParser,
                normalizer: $normalizer,
            ),
            platformCode: new XUcbrowserDeviceUaPlatformCode(
                platformParser: $platformParser,
                normalizer: $normalizer,
            ),
        );

        self::assertSame($ua, $header->getValue(), sprintf('value mismatch for ua "%s"', $ua));
        self::assertSame(
            $ua,
            $header->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Architecture::unknown,
            $header->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Bits::unknown,
            $header->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasDeviceInfo,
            $header->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            !$deviceIsNull ? $deviceCode : null,
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $header->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasPlatformInfo,
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            !$platformIsNull ? $platformCode : Os::unknown,
            $header->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $header->getPlatformVersionWithOs(Os::unknown),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));

        try {
            $header->getEngineCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertFalse(
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $header->getEngineVersionWithEngine(Engine::unknown),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }

    /**
     * @return array<int, array<string, bool|Os|string>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            [
                'ua' => 'Mozilla/5.0 (Linux; U; Android 2.3.5; en-US; Micromax_A36 Build/MocorDroid2.3.5_Trout) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0 (Linux; U; Android 4.0.4; en-US; GT-S7562 Build/IMM76I) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0 (Linux; U; Android 4.1.2; en-US; Nokia_X Build/JZO54K) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0 (Linux; U; Android 4.2.2; en-US; KYY21 Build/209.0.1700) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0 (Linux; U; Android 4.2.2; en-us; TECNO S3 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0 (Series40; Nokia200/11.81; Profile/MIDP-2.1 Configuration/CLDC-1.1) Gecko/20100401 S40OviBrowser/3.7.0.0.11',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => '?',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'SAMSUNG-GT-C3312/1.0 NetFront/4.2 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'SAMSUNG-GT-S3770K/S3770KDDKH4 NetFront/4.1 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'MOT-A1200e/1.0 LinuxOS/2.4.20 Release/1.31.2007 Browser/Opera8.00 Profile/MIDP-2.0 Configuration/CLDC-1.1 Software/R541_G_11.56.11R',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'SAMSUNG-GT-S3850/1.0 SHP/VPP/R5 Dolfin/2.0 NexPlayer/3.0 SMM-MMS/1.2.0 profile/MIDP-2.1 configuration/CLDC-1.1 OPN-B',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S5250/S5250XEKC1; U; Bada/1.0; uk-ua) AppleWebKit/533.1 (KHTML, like Gecko) Dolfin/2.0 Mobile WQVGA SMM-MMS/1.2.0 NexPlayer/3.0 profile/MIDP-2.1 configuration/CLDC-1.1 OPN-B',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0 (SymbianOS/9.2; U; Series60/3.1 NOKIA6120c/07.20; Profile/MIDP-2.0 Configuration/CLDC-1.1) AppleWebKit/413 (KHTML, like Gecko) Safari/413',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0 (Symbian/3; Series60/5.3 NokiaE7-00/1.040.1511; Profile/MIDP-2.1 Configuration/CLDC-1.1 ) AppleWebKit/533.4 (KHTML, like Gecko) NokiaBrowser/7.4.1.14 Mobile Safari/533.4 3gpp-gba',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Nokia501s/2.0 (10.0.12) Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Nokia501/2.0 (14.0.4) Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Nokia501/2.0 (10.0.14) Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Nokia503s/2.0 (14.0.4) Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'NokiaAsha230DualSIM/2.0 (14.0.4) Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S5380D/S5380DGTLE1; U; Bada/2.0; en-us) AppleWebKit/534.20 (KHTML, like Gecko) Dolfin/3.0 Mobile HVGA SMM-MMS/1.2.0 OPN-B',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S5380K/S5380KDDLD1; U; Bada/2.0; en-us) AppleWebKit/534.20 (KHTML, like Gecko) Dolfin/3.0 Mobile HVGA SMM-MMS/1.2.0 OPN-B',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S5253/S5253DDJI7; U; Bada/1.0; en-us) AppleWebKit/533.1 (KHTML, like Gecko) Dolfin/2.0 Mobile WQVGA SMM-MMS/1.2.0 OPN-B',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/4.0 (BREW 3.1.5; U; en-us; Sanyo; NetFront/3.5.1/AMB) Boost SCP6760',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'Mozilla/5.0_(OneTouch-710C/710C_OMH_V1.6; U; REX/4.3;BREW/3.1.5.189; Profile/MIDP-2.0_Configuration/CLDC-1.1; 240*320; CTC/2.0)_Obigo Browser/1.14',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'NetFront/3.5.1(BREW 5.0.2.1; U; en-us; Samsung ; NetFront/3.5.1/WAP) Boost M260 MMP/2.0 Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'MOT-EX226 MIDP-2.0/CLDC-1.1 Release/31.12.2010 Browser/Opera Sync/SyncClient1.1 Profile/MIDP-2.0 Configuration/CLDC-1.1 Opera/9.80 (MTK; U; en-US) Presto/2.5.28 Version/10.10',
                'hasDeviceInfo' => true,
                'deviceCode' => '',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
            [
                'ua' => 'ASTRO36_TD/v3 (MRE\2.3.00(20480) resolution\320480 chipset\MT6255 touch\1 tpannel\1 camera\0 gsensor\0 keyboard\reduced) MAUI/10A1032MP_ASTRO_W1052 Release/31.12.2010 Browser/Opera Profile/MIDP-2.0 Configuration/CLDC-1.1 Sync/SyncClient1.1 Opera/9.80 (MTK; Nucleus; Opera Mobi/4000; U; en-US) Presto/2.5.28 Version/10.10',
                'hasDeviceInfo' => true,
                'deviceCode' => 'test-device-code',
                'hasPlatformInfo' => true,
                'platformCode' => Os::unknown,
            ],
        ];
    }
}
