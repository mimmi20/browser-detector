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

use BrowserDetector\Header\SecChUaModel;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

final class SecChUaModelTest extends TestCase
{
    /** @throws ExpectationFailedException */
    #[DataProvider('providerUa')]
    public function testData(string $ua, string | null $model): void
    {
        $header = new SecChUaModel($ua);

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
        self::assertTrue($header->hasDeviceCode(), sprintf('device info mismatch for ua "%s"', $ua));
        self::assertSame(
            $model,
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse($header->hasClientCode(), sprintf('browser info mismatch for ua "%s"', $ua));
        self::assertNull(
            $header->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
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
        self::assertFalse($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));
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
     * @return array<int, array<int, string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['"A100"', 'acer=acer a100'],
            ['"B1-860A"', 'acer=acer b1-860a'],
            ['"Redmi Note 9 Pro"', 'xiaomi=xiaomi redmi note 9 pro'],
            ['"LM-G710"', 'lg=lg lm-g710'],
            ['"A1-734"', 'acer=acer a1-734'],
            ['"A3-A40"', 'acer=acer a3-a40'],
            ['"B1-7A0"', 'acer=acer b1-7a0'],
            ['"B1-860A"', 'acer=acer b1-860a'],
            ['"B3-A32"', 'acer=acer b3-a32'],
            ['"B3-A40"', 'acer=acer b3-a40'],
            ['"Atom"', 'allcall=allcall atom'],
            ['"KFKAWI"', 'amazon=amazon kfkawi'],
            ['"KFGIWI"', 'amazon=amazon kfgiwi'],
            ['"KFFOWI"', 'amazon=amazon kffowi'],
            ['"KFMUWI"', 'amazon=amazon kfmuwi'],
            ['"KFDOWI"', 'amazon=amazon kfdowi'],
            ['"P024"', 'asus=asus p024'],
            ['"ASUS_X00DD"', 'asus=asus x00dd'],
            ['"Nexus 7"', 'google=google nexus 7'],
            ['"AC2003"', 'oneplus=oneplus ac2003'],
            ['"CPH2065"', 'oppo=oppo cph2065'],
            ['"ZTE A2121E"', 'zte=zte a2121e'],
            ['"M2103K19G"', 'xiaomi=xiaomi m2103k19g'],
            ['"M2103K19C"', 'xiaomi=xiaomi m2103k19c'],
            ['"M2102K1AC"', 'xiaomi=xiaomi m2102k1ac'],
            ['"M2101K9AG"', 'xiaomi=xiaomi m2101k9ag'],
            ['"M2101K9AI"', 'xiaomi=xiaomi m2101k9ai'],
            ['"M2101K9G"', 'xiaomi=xiaomi m2101k9g'],
            ['"M2101K9C"', 'xiaomi=xiaomi m2101k9c'],
            ['"M2101K9R"', 'xiaomi=xiaomi m2101k9r'],
            ['"M2101K6G"', 'xiaomi=xiaomi m2101k6g'],
            ['"M2101K6R"', 'xiaomi=xiaomi m2101k6r'],
            ['"M2101K6P"', 'xiaomi=xiaomi m2101k6p'],
            ['"M2011K2G"', 'xiaomi=xiaomi m2011k2g'],
            ['"M2011K2C"', 'xiaomi=xiaomi m2011k2c'],
            ['"M2101K7BNY"', 'xiaomi=xiaomi m2101k7bny'],
            ['"M2101K7BG"', 'xiaomi=xiaomi m2101k7bg'],
            ['"M2101K7BI"', 'xiaomi=xiaomi m2101k7bi'],
            ['"M2101K7BL"', 'xiaomi=xiaomi m2101k7bl'],
            ['"M2010J19SG"', 'xiaomi=xiaomi m2010j19sg'],
            ['"M2010J19SY"', 'xiaomi=xiaomi m2010j19sy'],
            ['"M2101K7AG"', 'xiaomi=xiaomi m2101k7ag'],
            ['"M2101K7AI"', 'xiaomi=xiaomi m2101k7ai'],
            ['"M2007J22G"', 'xiaomi=xiaomi m2007j22g'],
            ['"M2012K11AG"', 'xiaomi=xiaomi m2012k11ag'],
            ['"M2102J20SG"', 'xiaomi=xiaomi m2102j20sg'],
            ['"M2102J20SI"', 'xiaomi=xiaomi m2102j20si'],
            ['"M1908C3JGG"', 'xiaomi=xiaomi m1908c3jgg'],
            ['"2201123G"', 'xiaomi=xiaomi 2201123g'],
            ['"2201123C"', 'xiaomi=xiaomi 2201123c'],
            ['"2201117TY"', 'xiaomi=xiaomi 2201117ty'],
            ['"2201117TG"', 'xiaomi=xiaomi 2201117tg'],
            ['"2201117TI"', 'xiaomi=xiaomi 2201117ti'],
            ['"2201117TL"', 'xiaomi=xiaomi 2201117tl'],
            ['"21091116AC"', 'xiaomi=xiaomi 21091116ac'],
            ['"21121119SC"', 'xiaomi=xiaomi 21121119sc'],
            ['"M2102K1G"', 'xiaomi=xiaomi m2102k1g'],
            ['"M2102K1C"', 'xiaomi=xiaomi m2102k1c'],
            ['"220333QNY"', 'xiaomi=xiaomi 220333qny'],
            ['"SM-A415F"', 'samsung=samsung sm-a415f'],
            ['"VOG-L29"', 'huawei=huawei vog-l29'],
            ['"SM-A505FN"', 'samsung=samsung sm-a505fn'],
            ['Redmi Note 8 Pro', 'xiaomi=xiaomi redmi note 8 pro'],
            ['"SM-A515F"', 'samsung=samsung sm-a515f'],
            ['"SM-G960F"', 'samsung=samsung sm-g960f'],
            ['"MAR-LX1B"', 'huawei=huawei mar-lx1b'],
            ['"SM-A405FN"', 'samsung=samsung sm-a405fn'],
            ['"IN2023"', 'oneplus=oneplus in2023'],
            ['"LYA-L09"', 'huawei=huawei lya-l09'],
            ['"Mi 9 SE"', 'xiaomi=xiaomi mi 9 se'],
            ['"ZTE Blade 10 Vita"', 'zte=zte blade 10 vita'],
            ['"ZTE Blade A3 2020"', 'zte=zte blade a3 2020'],
            ['"21081111RG"', 'xiaomi=xiaomi 21081111rg'],
            ['"2201116SG"', 'xiaomi=xiaomi 2201116sg'],
            ['"2109119DG"', 'xiaomi=xiaomi 2109119dg'],
            ['"2107113SG"', 'xiaomi=xiaomi 2107113sg'],
            ['"2201117SY"', 'xiaomi=xiaomi 2201117sy'],
            ['"21061119DG"', 'xiaomi=xiaomi 21061119dg'],
            ['"21061119AG"', 'xiaomi=xiaomi 21061119ag'],
            ['""', null],
        ];
    }
}
