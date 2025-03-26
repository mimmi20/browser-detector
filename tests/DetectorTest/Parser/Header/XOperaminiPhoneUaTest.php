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

use BrowserDetector\Parser\Header\XOperaminiPhoneUaClientCode;
use BrowserDetector\Parser\Header\XOperaminiPhoneUaClientVersion;
use BrowserDetector\Parser\Header\XOperaminiPhoneUaDeviceCode;
use BrowserDetector\Parser\Header\XOperaminiPhoneUaEngineCode;
use BrowserDetector\Parser\Header\XOperaminiPhoneUaPlatformCode;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\NormalizerFactory;
use UaParser\DeviceParserInterface;
use UaParser\EngineParserInterface;
use UaRequest\Header\XOperaminiPhoneUa;

use function sprintf;

#[CoversClass(XOperaminiPhoneUaClientCode::class)]
#[CoversClass(XOperaminiPhoneUaClientVersion::class)]
#[CoversClass(XOperaminiPhoneUaDeviceCode::class)]
#[CoversClass(XOperaminiPhoneUaEngineCode::class)]
#[CoversClass(XOperaminiPhoneUaPlatformCode::class)]
final class XOperaminiPhoneUaTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \PHPUnit\Framework\Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerUa')]
    public function testData(
        string $ua,
        bool $hasDeviceInfo,
        string $deviceCode,
        bool $hasClientInfo,
        bool $hasClientVersion,
        string | null $clientVersion,
        bool $hasPlatformInfo,
        string | null $platformCode,
        bool $hasEngineInfo,
        string $engineCode,
    ): void {
        $deviceIsNull = false;
        $engineIsNull = false;

        if ($deviceCode === '') {
            $deviceIsNull = true;
        }

        if ($engineCode === '') {
            $engineIsNull = true;
        }

        $normalizerFactory = new NormalizerFactory();
        $normalizer        = $normalizerFactory->build();

        $normalitedUa = $normalizer->normalize($ua);

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalitedUa)
            ->willReturn($deviceCode);

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalitedUa)
            ->willReturn($engineCode);

        $header = new XOperaminiPhoneUa(
            value: $ua,
            deviceCode: new XOperaminiPhoneUaDeviceCode(
                deviceParser: $deviceParser,
                normalizer: $normalizer,
            ),
            clientCode: new XOperaminiPhoneUaClientCode(),
            clientVersion: new XOperaminiPhoneUaClientVersion(),
            platformCode: new XOperaminiPhoneUaPlatformCode(),
            engineCode: new XOperaminiPhoneUaEngineCode(
                engineParser: $engineParser,
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
        self::assertNull(
            $header->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
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
        self::assertSame(
            $hasClientInfo,
            $header->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            'opera mini',
            $header->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientVersion,
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $clientVersion,
            $header->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasPlatformInfo,
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $platformCode,
            $header->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasEngineInfo,
            $header->hasEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            !$engineIsNull ? $engineCode : null,
            $header->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }

    /**
     * @return array<int, array<int, bool|string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['BlackBerry8520/5.0.0.681 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/613', true, 'test-device-code', false, false, null, true, 'rim os', false, ''],
            ['BlackBerry8900/5.0.0.1113 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/100', true, 'test-device-code', false, false, null, true, 'rim os', false, ''],
            ['SAMSUNG-GT-i8000/1.0 (Windows CE; Opera Mobi; U; en) Opera 9.5 UNTRUSTED/1.0', true, 'test-device-code', false, false, null, true, 'windows ce', false, ''],
            ['Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S5380D/S5380DZHLB1; U; Bada/2.0; zh-cn) AppleWebKit/534.20 (KHTML, like Gecko) Dolfin/3.0 Mobile HVGA SMM-MMS/1.2.0 OPN-B', true, 'test-device-code', false, false, null, true, 'bada', true, 'test-engine-code'],
            ['HTC_Touch_Pro_T7272', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['SAMSUNG-GT-S8500', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['Mozilla/5.0 (Linux; U; Android 4.2.5; zh-cn; MI 2SC Build/YunOS) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', true, 'test-device-code', false, false, null, true, 'android', true, ''],
            ['Mozilla/5.0 (Series40; Nokia501/11.1.1/java_runtime_version=Nokia_Asha_1_1_1; Profile/MIDP-2.1 Configuration/CLDC-1.1) Gecko/20100401 S40OviBrowser/3.9.0.0.22', true, 'test-device-code', false, false, null, false, null, true, 'test-engine-code'],
            ['Mozilla/5.0 (Series40; Nokia501/11.1.1/java_runtime_version=Nokia_Asha_1_1_1; Profile/MIDP-2.1 Configuration/CLDC-1.1) Gecko/20100401 S40OviBrowser/3.1.1.0.27', true, 'test-device-code', false, false, null, false, null, true, 'test-engine-code'],
            ['Mozilla/5.0 (Bada 2.0.0)', false, '', false, false, null, true, 'bada', false, ''],
            ['BlackBerry8520/5.0.0.1036 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/613', true, 'test-device-code', false, false, null, true, 'rim os', false, ''],
            ['BlackBerry9700/5.0.0.235 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/1', true, 'test-device-code', false, false, null, true, 'rim os', false, ''],
            ['BlackBerry9300', true, '', false, false, null, true, 'rim os', false, ''],
            ['BlackBerry8530/5.0.0.973 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/105', true, 'test-device-code', false, false, null, true, 'rim os', false, ''],
            ['Samsung SCH-U380', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['Pantech TXT8045', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['ZTE F-450', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['LG VN271', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['Casio C781', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['Samsung SCH-U485', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['Pantech CDM8992', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['LG VN530', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['Samsung SCH-U680', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['Pantech CDM8999', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['NativeOperaMini(Haier;Native Opera Mini/4.2.99;id;BREW 3.1.5)', false, '', true, true, '4.2.99', true, 'brew', false, ''],
            ['Mozilla/5.0_(Smartfren-E781A/E2_SQID_V0.1.6; U; REX/4.3;BREW/3.1.5.189; Profile/MIDP-2.0_Configuration/CLDC-1.1; 240*320; CTC/2.0)_Obigo Browser/Q7', true, 'test-device-code', false, false, null, true, 'brew', false, ''],
            ['Mozilla/4.0 (Brew MP 1.0.2; U; en-us; Kyocera; NetFront/4.1/AMB) Sprint E4255', true, 'test-device-code', false, false, null, true, 'brew', false, ''],
            ['Mozilla/4.0 (BREW 3.1.5; U; en-us; Sanyo; NetFront/3.5.1/AMB) Sprint SCP-6760', true, 'test-device-code', false, false, null, true, 'brew', false, ''],
            ['Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5', true, 'test-device-code', false, false, null, true, 'ios', true, 'test-engine-code'],
            ['OperaMini(MAUI_MRE;Opera Mini/4.4.31223;en)', false, '', true, true, '4.4.31223', true, 'mre', false, ''],
            ['OperaMini(Fucus/Unknown;Opera Mini/4.4.31223;en)', false, '', true, true, '4.4.31223', false, null, false, ''],
            ['OperaMini(Lava-Discover135;Opera Mini/4.4.31762;en)', true, 'test-device-code', true, true, '4.4.31762', false, null, false, ''],
            ['OperaMini(Gionee_1305;Opera Mini/4.4.31989;en)', true, 'test-device-code', true, true, '4.4.31989', false, null, false, ''],
            ['NativeOperaMini(MRE_VER_3000;240X320;MT6256;V/;Opera Mini/6.1.27412;en)', false, '', true, true, '6.1.27412', true, 'mre', false, ''],
            ['NativeOperaMini(MTK;Native Opera Mini/4.2.1198;fr)', false, '', true, true, '4.2.1198', true, 'nucleus os', false, ''],
            ['NativeOperaMini(MTK;Opera Mini/5.1.3119;es)', false, '', true, true, '5.1.3119', true, 'nucleus os', false, ''],
            ['NativeOperaMini(MTK/Unknown;Opera Mini/7.0.32977;en-US)', false, '', true, true, '7.0.32977', true, 'nucleus os', false, ''],
            ['NativeOperaMini(Spreadtrum/Unknown;Native Opera Mini/4.4.29625;pt)', false, '', true, true, '4.4.29625', false, null, false, ''],
            ['NativeOperaMini(Spreadtrum/HW Version:        SC6531_OPENPHONE;Native Opera Mini/4.4.31227;en)', false, '', true, true, '4.4.31227', false, null, false, ''],
            ['PhilipsX2300/W1245_V12 ThreadX_OS/4.0 MOCOR/W12 Release/11.08.2012 Browser/Dorado1.0', true, 'test-device-code', false, false, null, false, null, false, ''],
            ['ReksioVRE(196683)', false, '', false, false, null, false, null, false, ''],
            ['Motorola', false, '', false, false, null, false, null, false, ''],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; HTC_HD2_T8585; Windows Phone 6.5)', true, 'test-device-code', false, false, null, true, 'windows phone', false, ''],
            ['Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; NOKIA; Lumia 710)', true, 'test-device-code', false, false, null, true, 'windows phone', true, 'test-engine-code'],
            ['Mozilla/5.0 (Linux; Android 11; SM-G900F Build/RQ3A.211001.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/108.0.5359.128 Mobile Safari/537.36', true, 'test-device-code', false, false, null, true, 'android', true, 'test-engine-code'],
            ['Mozilla/5.0 (Linux; U; Android 2.3.6; de-de; GT-I9000 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1', true, 'test-device-code', false, false, null, true, 'android', true, 'test-engine-code'],
            ['Mozilla/5.0 (Linux; U; Android 2.3.6; de-de; GT-S5830i Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1', true, 'test-device-code', false, false, null, true, 'android', true, 'test-engine-code'],
            ['Mozilla/5.0 (Linux; Android 10; SNE-LX1 Build/HUAWEISNE-L21; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.4896.79 Mobile Safari/537.36', true, 'test-device-code', false, false, null, true, 'android', true, 'test-engine-code'],
            ['Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; de) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.1033 Mobile Safari/534.11+', true, 'test-device-code', false, false, null, true, 'rim os', true, 'webkit'],
        ];
    }
}
