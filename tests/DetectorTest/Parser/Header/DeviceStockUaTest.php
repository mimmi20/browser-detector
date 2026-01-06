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
use BrowserDetector\Parser\Header\DeviceStockUaClientCode;
use BrowserDetector\Parser\Header\DeviceStockUaClientVersion;
use BrowserDetector\Parser\Header\DeviceStockUaDeviceCode;
use BrowserDetector\Parser\Header\DeviceStockUaEngineCode;
use BrowserDetector\Parser\Header\DeviceStockUaEngineVersion;
use BrowserDetector\Parser\Header\DeviceStockUaPlatformCode;
use BrowserDetector\Parser\Header\DeviceStockUaPlatformVersion;
use BrowserDetector\Version\ForcedNullVersion;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaParser\DeviceParserInterface;
use UaRequest\Header\FullHeader;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;
use UnexpectedValueException;

use function preg_match;
use function sprintf;

#[CoversClass(DeviceStockUaClientCode::class)]
#[CoversClass(DeviceStockUaClientVersion::class)]
#[CoversClass(DeviceStockUaPlatformCode::class)]
#[CoversClass(DeviceStockUaPlatformVersion::class)]
#[CoversClass(DeviceStockUaEngineCode::class)]
#[CoversClass(DeviceStockUaEngineVersion::class)]
#[CoversClass(DeviceStockUaDeviceCode::class)]
final class DeviceStockUaTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider('providerUa')]
    public function testData(
        string $ua,
        bool $hasDeviceInfo,
        string $deviceCode,
        bool $hasClientInfo,
        string | null $clientCode,
        bool $hasClientVersion,
        string | null $clientVersion,
        bool $hasPlatformInfo,
        Os $platformCode,
        bool $hasPlatformVersion,
        string | null $platformVersion,
        bool $hasEngineInfo,
        Engine $engineCode,
        bool $hasEngineVersion,
        string | null $engineVersion,
    ): void {
        $searchCode = false;
        $isNull     = false;

        if (
            preg_match(
                '/samsung|nokia|blackberry|smartfren|sprint|iphone|lava|gionee|philips|htc|mi 2sc/i',
                $ua,
            )
        ) {
            $searchCode = true;
        }

        if (!$searchCode || $deviceCode === '') {
            $isNull = true;
        }

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects($searchCode ? self::once() : self::never())
            ->method('parse')
            ->with($ua)
            ->willReturn($deviceCode);

        $header = new FullHeader(
            value: $ua,
            deviceCode: new DeviceStockUaDeviceCode(
                deviceParser: $deviceParser,
            ),
            clientCode: new DeviceStockUaClientCode(),
            clientVersion: new DeviceStockUaClientVersion(),
            platformCode: new DeviceStockUaPlatformCode(),
            platformVersion: new DeviceStockUaPlatformVersion(),
            engineCode: new DeviceStockUaEngineCode(),
            engineVersion: new DeviceStockUaEngineVersion(),
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
            !$isNull ? $deviceCode : null,
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

        if ($clientVersion === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $header->getClientVersion(),
                sprintf('browser info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $clientVersion,
                $header->getClientVersion()->getVersion(),
                sprintf('browser info mismatch for ua "%s"', $ua),
            );
        }

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

        if ($platformVersion === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $header->getPlatformVersion(),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $platformVersion,
                $header->getPlatformVersion()->getVersion(),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        }

        self::assertSame(
            $hasEngineInfo,
            $header->hasEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $engineCode,
            $header->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasEngineVersion,
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );

        if ($engineVersion === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $header->getEngineVersion(),
                sprintf('engine info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $engineVersion,
                $header->getEngineVersion()->getVersion(),
                sprintf('engine info mismatch for ua "%s"', $ua),
            );
        }
    }

    /**
     * @return list<array<string, bool|Engine|Os|string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            [
                'ua' => 'Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S5380D/S5380DZHLB1; U; Bada/2.0; zh-cn) AppleWebKit/534.20 (KHTML, like Gecko) Dolfin/3.0 Mobile HVGA SMM-MMS/1.2.0 OPN-B',
                'hasDeviceInfo' => true,
                'deviceCode' => 'GT-S5380D',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::bada,
                'hasPlatformVersion' => true,
                'platformVersion' => '2.0.0',
                'hasEngineInfo' => true,
                'engineCode' => Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.20.0',
            ],
            [
                'ua' => 'SAMSUNG-GT-S8500',
                'hasDeviceInfo' => true,
                'deviceCode' => 'GT-S8500',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'Mozilla/5.0 (Linux; U; Android 4.2.5; zh-cn; MI 2SC Build/YunOS) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'hasDeviceInfo' => true,
                'deviceCode' => 'MI 2SC',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.5',
                'hasEngineInfo' => true,
                'engineCode' => Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.30.0',
            ],
            [
                'ua' => 'Mozilla/5.0 (Series40; Nokia501/11.1.1/java_runtime_version=Nokia_Asha_1_1_1; Profile/MIDP-2.1 Configuration/CLDC-1.1) Gecko/20100401 S40OviBrowser/3.9.0.0.22',
                'hasDeviceInfo' => true,
                'deviceCode' => 'Nokia501',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineCode' => Engine::gecko,
                'hasEngineVersion' => true,
                'engineVersion' => '20100401.0.0',
            ],
            [
                'ua' => 'Mozilla/5.0 (Series40; Nokia501/11.1.1/java_runtime_version=Nokia_Asha_1_1_1; Profile/MIDP-2.1 Configuration/CLDC-1.1) Gecko/20100401 S40OviBrowser/3.1.1.0.27',
                'hasDeviceInfo' => true,
                'deviceCode' => 'Nokia501',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineCode' => Engine::gecko,
                'hasEngineVersion' => true,
                'engineVersion' => '20100401.0.0',
            ],
            [
                'ua' => 'Mozilla/5.0 (Bada 2.0.0)',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::bada,
                'hasPlatformVersion' => true,
                'platformVersion' => '2.0.0',
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'BlackBerry9700/5.0.0.235 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/1',
                'hasDeviceInfo' => true,
                'deviceCode' => 'BlackBerry9700',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::rimOs,
                'hasPlatformVersion' => true,
                'platformVersion' => '5.0.0.235',
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'BlackBerry9300',
                'hasDeviceInfo' => true,
                'deviceCode' => 'BlackBerry9300',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::rimOs,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'BlackBerry8530/5.0.0.973 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/105',
                'hasDeviceInfo' => true,
                'deviceCode' => 'BlackBerry8530',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::rimOs,
                'hasPlatformVersion' => true,
                'platformVersion' => '5.0.0.973',
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'NativeOperaMini(Haier;Native Opera Mini/4.2.99;id;BREW 3.1.5)',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => true,
                'clientCode' => 'opera mini',
                'hasClientVersion' => true,
                'clientVersion' => '4.2.99',
                'hasPlatformInfo' => true,
                'platformCode' => Os::brew,
                'hasPlatformVersion' => true,
                'platformVersion' => '3.1.5',
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'Mozilla/5.0_(Smartfren-E781A/E2_SQID_V0.1.6; U; REX/4.3;BREW/3.1.5.189; Profile/MIDP-2.0_Configuration/CLDC-1.1; 240*320; CTC/2.0)_Obigo Browser/Q7',
                'hasDeviceInfo' => true,
                'deviceCode' => 'E781A',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::brew,
                'hasPlatformVersion' => true,
                'platformVersion' => '3.1.5.189',
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'Mozilla/4.0 (Brew MP 1.0.2; U; en-us; Kyocera; NetFront/4.1/AMB) Sprint E4255',
                'hasDeviceInfo' => true,
                'deviceCode' => 'E4255',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::brew,
                'hasPlatformVersion' => true,
                'platformVersion' => '1.0.2',
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'Mozilla/4.0 (BREW 3.1.5; U; en-us; Sanyo; NetFront/3.5.1/AMB) Sprint SCP-6760',
                'hasDeviceInfo' => true,
                'deviceCode' => 'SCP-6760',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::brew,
                'hasPlatformVersion' => true,
                'platformVersion' => '3.1.5',
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5',
                'hasDeviceInfo' => true,
                'deviceCode' => 'iPhone',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::ios,
                'hasPlatformVersion' => true,
                'platformVersion' => '4.3.3',
                'hasEngineInfo' => true,
                'engineCode' => Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '533.17.9',
            ],
            [
                'ua' => 'OperaMini(MAUI_MRE;Opera Mini/4.4.31223;en)',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => true,
                'clientCode' => 'opera mini',
                'hasClientVersion' => true,
                'clientVersion' => '4.4.31223',
                'hasPlatformInfo' => true,
                'platformCode' => Os::mre,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'OperaMini(Fucus/Unknown;Opera Mini/4.4.31223;en)',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => true,
                'clientCode' => 'opera mini',
                'hasClientVersion' => true,
                'clientVersion' => '4.4.31223',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'OperaMini(Lava-Discover135;Opera Mini/4.4.31762;en)',
                'hasDeviceInfo' => true,
                'deviceCode' => 'Lava-Discover135',
                'hasClientInfo' => true,
                'clientCode' => 'opera mini',
                'hasClientVersion' => true,
                'clientVersion' => '4.4.31762',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'OperaMini(Gionee_1305;Opera Mini/4.4.31989;en)',
                'hasDeviceInfo' => true,
                'deviceCode' => 'Gionee_1305',
                'hasClientInfo' => true,
                'clientCode' => 'opera mini',
                'hasClientVersion' => true,
                'clientVersion' => '4.4.31989',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'NativeOperaMini(MRE_VER_3000;240X320;MT6256;V/;Opera Mini/6.1.27412;en)',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => true,
                'clientCode' => 'opera mini',
                'hasClientVersion' => true,
                'clientVersion' => '6.1.27412',
                'hasPlatformInfo' => true,
                'platformCode' => Os::mre,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'NativeOperaMini(MTK;Native Opera Mini/4.2.1198;fr)',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => true,
                'clientCode' => 'opera mini',
                'hasClientVersion' => true,
                'clientVersion' => '4.2.1198',
                'hasPlatformInfo' => true,
                'platformCode' => Os::nucleus,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'NativeOperaMini(MTK;Opera Mini/5.1.3119;es)',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => true,
                'clientCode' => 'opera mini',
                'hasClientVersion' => true,
                'clientVersion' => '5.1.3119',
                'hasPlatformInfo' => true,
                'platformCode' => Os::nucleus,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'NativeOperaMini(MTK/Unknown;Opera Mini/7.0.32977;en-US)',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => true,
                'clientCode' => 'opera mini',
                'hasClientVersion' => true,
                'clientVersion' => '7.0.32977',
                'hasPlatformInfo' => true,
                'platformCode' => Os::nucleus,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'NativeOperaMini(Spreadtrum/Unknown;Native Opera Mini/4.4.29625;pt)',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => true,
                'clientCode' => 'opera mini',
                'hasClientVersion' => true,
                'clientVersion' => '4.4.29625',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'NativeOperaMini(Spreadtrum/HW Version:        SC6531_OPENPHONE;Native Opera Mini/4.4.31227;en)',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => true,
                'clientCode' => 'opera mini',
                'hasClientVersion' => true,
                'clientVersion' => '4.4.31227',
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'PhilipsX2300/W1245_V12 ThreadX_OS/4.0 MOCOR/W12 Release/11.08.2012 Browser/Dorado1.0',
                'hasDeviceInfo' => true,
                'deviceCode' => 'PhilipsX2300',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'ReksioVRE(196683)',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'Motorola',
                'hasDeviceInfo' => false,
                'deviceCode' => '',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => false,
                'platformCode' => Os::unknown,
                'hasPlatformVersion' => false,
                'platformVersion' => null,
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; HTC_HD2_T8585; Windows Phone 6.5)',
                'hasDeviceInfo' => true,
                'deviceCode' => 'HTC_HD2_T8585',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::windowsphone,
                'hasPlatformVersion' => true,
                'platformVersion' => '6.5.0',
                'hasEngineInfo' => false,
                'engineCode' => Engine::unknown,
                'hasEngineVersion' => false,
                'engineVersion' => null,
            ],
            [
                'ua' => 'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; NOKIA; Lumia 710)',
                'hasDeviceInfo' => true,
                'deviceCode' => '',
                'hasClientInfo' => true,
                'clientCode' => 'iemobile',
                'hasClientVersion' => true,
                'clientVersion' => '9.0.0',
                'hasPlatformInfo' => true,
                'platformCode' => Os::windowsphone,
                'hasPlatformVersion' => true,
                'platformVersion' => '7.5.0',
                'hasEngineInfo' => true,
                'engineCode' => Engine::trident,
                'hasEngineVersion' => true,
                'engineVersion' => '5.0.0',
            ],
            [
                'ua' => 'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone 7.5; Trident/5.0; IEMobile/9.0; NOKIA; Lumia 710)',
                'hasDeviceInfo' => true,
                'deviceCode' => '',
                'hasClientInfo' => true,
                'clientCode' => 'iemobile',
                'hasClientVersion' => true,
                'clientVersion' => '9.0.0',
                'hasPlatformInfo' => true,
                'platformCode' => Os::windowsphone,
                'hasPlatformVersion' => true,
                'platformVersion' => '7.5.0',
                'hasEngineInfo' => true,
                'engineCode' => Engine::trident,
                'hasEngineVersion' => true,
                'engineVersion' => '5.0.0',
            ],
            [
                'ua' => 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533_17_9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5',
                'hasDeviceInfo' => true,
                'deviceCode' => 'iPhone',
                'hasClientInfo' => false,
                'clientCode' => null,
                'hasClientVersion' => false,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => Os::ios,
                'hasPlatformVersion' => true,
                'platformVersion' => '4.3.3',
                'hasEngineInfo' => true,
                'engineCode' => Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '533.17.9',
            ],
        ];
    }
}
