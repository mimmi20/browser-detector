<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Header;

use BrowserDetector\Header\DeviceStockUa;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

final class DeviceStockUaTest extends TestCase
{
    /** @throws ExpectationFailedException */
    #[DataProvider('providerUa')]
    public function testData(
        string $ua,
        bool $hasDeviceInfo,
        bool $hasClientInfo,
        string | null $clientCode,
        bool $hasClientVersion,
        string | null $clientVersion,
        bool $hasPlatformInfo,
        string | null $platformCode,
        bool $hasPlatformVersion,
        string | null $platformVersion,
        bool $hasEngineInfo,
    ): void {
        $header = new DeviceStockUa($ua);

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
        self::assertFalse($header->hasDeviceName(), sprintf('device info mismatch for ua "%s"', $ua));
        self::assertNull(
            $header->getDeviceName(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasDeviceInfo,
            $header->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientInfo,
            $header->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $clientCode,
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
        self::assertSame(
            $hasPlatformVersion,
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $platformVersion,
            $header->getPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasEngineInfo,
            $header->hasEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
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
     * @return array<int, array<int, bool|string>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S5380D/S5380DZHLB1; U; Bada/2.0; zh-cn) AppleWebKit/534.20 (KHTML, like Gecko) Dolfin/3.0 Mobile HVGA SMM-MMS/1.2.0 OPN-B', true, false, null, false, null, true, 'bada', true, '2.0', true],
            ['SAMSUNG-GT-S8500', true, false, null, false, null, false, null, false, null, false],
            ['Mozilla/5.0 (Linux; U; Android 4.2.5; zh-cn; MI 2SC Build/YunOS) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', true, false, null, false, null, true, 'android', true, '4.2.5', true],
            ['Mozilla/5.0 (Series40; Nokia501/11.1.1/java_runtime_version=Nokia_Asha_1_1_1; Profile/MIDP-2.1 Configuration/CLDC-1.1) Gecko/20100401 S40OviBrowser/3.9.0.0.22', true, false, null, false, null, false, null, false, null, true],
            ['Mozilla/5.0 (Series40; Nokia501/11.1.1/java_runtime_version=Nokia_Asha_1_1_1; Profile/MIDP-2.1 Configuration/CLDC-1.1) Gecko/20100401 S40OviBrowser/3.1.1.0.27', true, false, null, false, null, false, null, false, null, true],
            ['Mozilla/5.0 (Bada 2.0.0)', false, false, null, false, null, true, 'bada', true, '2.0.0', false],
            ['BlackBerry9700/5.0.0.235 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/1', true, false, null, false, null, true, 'rim os', true, '5.0.0.235', false],
            ['BlackBerry9300', true, false, null, false, null, true, 'rim os', false, null, false],
            ['BlackBerry8530/5.0.0.973 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/105', true, false, null, false, null, true, 'rim os', true, '5.0.0.973', false],
            ['NativeOperaMini(Haier;Native Opera Mini/4.2.99;id;BREW 3.1.5)', false, true, 'opera mini', true, '4.2.99', true, 'brew', true, '3.1.5', false],
            ['Mozilla/5.0_(Smartfren-E781A/E2_SQID_V0.1.6; U; REX/4.3;BREW/3.1.5.189; Profile/MIDP-2.0_Configuration/CLDC-1.1; 240*320; CTC/2.0)_Obigo Browser/Q7', true, false, null, false, null, true, 'brew', true, '3.1.5.189', false],
            ['Mozilla/4.0 (Brew MP 1.0.2; U; en-us; Kyocera; NetFront/4.1/AMB) Sprint E4255', true, false, null, false, null, true, 'brew', true, '1.0.2', false],
            ['Mozilla/4.0 (BREW 3.1.5; U; en-us; Sanyo; NetFront/3.5.1/AMB) Sprint SCP-6760', true, false, null, false, null, true, 'brew', true, '3.1.5', false],
            ['Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5', true, false, null, false, null, true, 'ios', true, '4.3.3', true],
            ['OperaMini(MAUI_MRE;Opera Mini/4.4.31223;en)', false, true, 'opera mini', true, '4.4.31223', true, 'mre', false, null, false],
            ['OperaMini(Fucus/Unknown;Opera Mini/4.4.31223;en)', false, true, 'opera mini', true, '4.4.31223', false, null, false, null, false],
            ['OperaMini(Lava-Discover135;Opera Mini/4.4.31762;en)', true, true, 'opera mini', true, '4.4.31762', false, null, false, null, false],
            ['OperaMini(Gionee_1305;Opera Mini/4.4.31989;en)', true, true, 'opera mini', true, '4.4.31989', false, null, false, null, false],
            ['NativeOperaMini(MRE_VER_3000;240X320;MT6256;V/;Opera Mini/6.1.27412;en)', false, true, 'opera mini', true, '6.1.27412', true, 'mre', false, null, false],
            ['NativeOperaMini(MTK;Native Opera Mini/4.2.1198;fr)', false, true, 'opera mini', true, '4.2.1198', true, 'nucleus os', false, null, false],
            ['NativeOperaMini(MTK;Opera Mini/5.1.3119;es)', false, true, 'opera mini', true, '5.1.3119', true, 'nucleus os', false, null, false],
            ['NativeOperaMini(MTK/Unknown;Opera Mini/7.0.32977;en-US)', false, true, 'opera mini', true, '7.0.32977', true, 'nucleus os', false, null, false],
            ['NativeOperaMini(Spreadtrum/Unknown;Native Opera Mini/4.4.29625;pt)', false, true, 'opera mini', true, '4.4.29625', false, null, false, null, false],
            ['NativeOperaMini(Spreadtrum/HW Version:        SC6531_OPENPHONE;Native Opera Mini/4.4.31227;en)', false, true, 'opera mini', true, '4.4.31227', false, null, false, null, false],
            ['PhilipsX2300/W1245_V12 ThreadX_OS/4.0 MOCOR/W12 Release/11.08.2012 Browser/Dorado1.0', true, false, null, false, null, false, null, false, null, false],
            ['ReksioVRE(196683)', false, false, null, false, null, false, null, false, null, false],
            ['Motorola', false, false, null, false, null, false, null, false, null, false],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; HTC_HD2_T8585; Windows Phone 6.5)', true, false, null, false, null, true, 'windows phone', true, '6.5', false],
            ['Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; NOKIA; Lumia 710)', true, true, 'iemobile', true, '9.0', true, 'windows phone', true, '7.5', true],
        ];
    }
}
