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
            ['"SM-S901B"', 'samsung=samsung sm-s901b'],
            ['"SM-S901U"', 'samsung=samsung sm-s901u'],
            ['"SM-S901U1"', 'samsung=samsung sm-s901u1'],
            ['"SM-S918B"', 'samsung=samsung sm-s918b'],
            ['"SM-S908B"', 'samsung=samsung sm-s908b'],
            ['"SM-S908U"', 'samsung=samsung sm-s908u'],
            ['"SM-S908U1"', 'samsung=samsung sm-s908u1'],
            ['"SM-G780G"', 'samsung=samsung sm-g780g'],
            ['"SM-A536B"', 'samsung=samsung sm-a536b'],
            ['"SM-A528B"', 'samsung=samsung sm-a528b'],
            ['"SM-A135F"', 'samsung=samsung sm-a135f'],
            ['"Pixel 7 Pro"', 'google=google pixel 7 pro'],
            ['"ZTE 8045"', 'zte=zte 8045'],
            ['"M2003J15SC"', 'xiaomi=xiaomi m2003j15sc'],
            ['"2210132G"', 'xiaomi=xiaomi 2210132g'],
            ['"22081212UG"', 'xiaomi=xiaomi 22081212ug'],
            ['"M2010J19CG"', 'xiaomi=xiaomi m2010j19cg'],
            ['"SM-T510"', 'samsung=samsung sm-t510'],
            ['"21051182G"', 'xiaomi=xiaomi 21051182g'],
            ['"KFTRWI"', 'amazon=amazon kftrwi'],
            ['"KFTRPWI"', 'amazon=amazon kftrpwi'],
            ['"Lenovo TB-X304F"', 'lenovo=lenovo tb-x304f'],
            ['"SM-T970"', 'samsung=samsung sm-t970'],
            ['"SM-T580"', 'samsung=samsung sm-t580'],
            ['"X1030X"', 'lenovo=lenovo x1030x'],
            ['"SM-T550"', 'samsung=samsung sm-t550'],
            ['"SM-T813"', 'samsung=samsung sm-t813'],
            ['"Nokia G50"', 'nokia=nokia g50'],
            ['"SM-A336B"', 'samsung=samsung sm-a336b'],
            ['"SM-A336E"', 'samsung=samsung sm-a336e'],
            ['"Surface Duo"', 'microsoft=microsoft surface duo'],
            ['"SM-A127F"', 'samsung=samsung sm-a127f'],
            ['"Pixel 4 XL"', 'google=google pixel 4 xl'],
            ['"Pixel 6"', 'google=google pixel 6'],
            ['"Pixel 6 Pro"', 'google=google pixel 6 pro'],
            ['"Pixel 6a"', 'google=google pixel 6a'],
            ['"ZTE A2322G"', 'zte=zte a2322g'],
            ['"Pixel 4a (5G)"', 'google=google pixel 4a 5g'],
            ['"Pixel 7"', 'google=google pixel 7'],
            ['"Pixel 3a"', 'google=google pixel 3a'],
            ['"Pixel 3"', 'google=google pixel 3'],
            ['"Pixel 5"', 'google=google pixel 5'],
            ['"SM-G525F"', 'samsung=samsung sm-g525f'],
            ['"SM-A226BR"', 'samsung=samsung sm-a226br'],
            ['"SM-A226B"', 'samsung=samsung sm-a226b'],
            ['"SM-A546B"', 'samsung=samsung sm-a546b'],
            ['"SM-T220"', 'samsung=samsung sm-t220'],
            ['"SM-T225"', 'samsung=samsung sm-t225'],
            ['"SM-T225N"', 'samsung=samsung sm-t225n'],
            ['"SM-A326B"', 'samsung=samsung sm-a326b'],
            ['"SM-A326U"', 'samsung=samsung sm-a326u'],
            ['"Nokia G20"', 'nokia=nokia g20'],
            ['"SM-A725F"', 'samsung=samsung sm-a725f'],
            ['"SM-G990B"', 'samsung=samsung sm-g990b'],
            ['"SM-G990B2"', 'samsung=samsung sm-g990b2'],
            ['"SM-G990E"', 'samsung=samsung sm-g990e'],
            ['"NEN-LX1"', 'huawei=huawei nen-lx1'],
            ['"22011119UY"', 'xiaomi=xiaomi 22011119uy'],
            ['"Lenovo YT-J706F"', 'lenovo=lenovo yt-j706f'],
            ['"SM-A125F"', 'samsung=samsung sm-a125f'],
            ['"220733SG"', 'xiaomi=xiaomi 220733sg'],
            ['"Mi Note 10 Lite"', 'xiaomi=xiaomi mi note 10 lite'],
            ['"Mi Note 10 Pro"', 'xiaomi=xiaomi mi note 10 pro'],
            ['"CPH2211"', 'oppo=oppo cph2211'],
            ['"CPH2271"', 'oppo=oppo cph2271'],
            ['"RMX3085"', 'realme=realme rmx3085'],
            ['"SM-P619"', 'samsung=samsung sm-p619'],
            ['"SM-P613"', 'samsung=samsung sm-p613'],
            ['"SM-A136B"', 'samsung=samsung sm-a136b'],
            ['"22101316UG"', 'xiaomi=xiaomi 22101316ug'],
            ['"RMX3231"', 'realme=realme rmx3231'],
            ['"SM-G736B"', 'samsung=samsung sm-g736b'],
            ['"SM-F711B"', 'samsung=samsung sm-f711b'],
            ['"SM-F711U"', 'samsung=samsung sm-f711u'],
            ['"SM-A225F"', 'samsung=samsung sm-a225f'],
            ['"SM-A137F"', 'samsung=samsung sm-a137f'],
            ['"SM-A146P"', 'samsung=samsung sm-a146p'],
            ['"SM-A236B"', 'samsung=samsung sm-a236b'],
            ['"SM-A525F"', 'samsung=samsung sm-a525f'],
            ['"PPA-LX1"', 'huawei=huawei ppa-lx1'],
            ['"JAD-LX9"', 'huawei=huawei jad-lx9'],
            ['"moto g200 5G"', 'motorola=motorola moto g200 5g'],
            ['"SM-F731B"', 'samsung=samsung sm-f731b'],
            ['"SM-F926B"', 'samsung=samsung sm-f926b'],
            ['"SM-S906B"', 'samsung=samsung sm-s906b'],
            ['"SM-S911B"', 'samsung=samsung sm-s911b'],
            ['"SM-S916B"', 'samsung=samsung sm-s916b'],
            ['"XQ-CC54"', 'sony=sony xq-cc54'],
            ['"XQ-BQ52"', 'sony=sony xq-bq52'],
            ['"XQ-BE52"', 'sony=sony xq-be52'],
            ['"V2109"', 'vivo=vivo v2109'],
            ['"SM-X706B"', 'samsung=samsung sm-x706b'],
            ['"SM-X700"', 'samsung=samsung sm-x700'],
            ['"SM-X200"', 'samsung=samsung sm-x200'],
            ['"SM-X205"', 'samsung=samsung sm-x205'],
            ['"SM-T976B"', 'samsung=samsung sm-t976b'],
            ['"SM-T870"', 'samsung=samsung sm-t870'],
            ['"SM-T875"', 'samsung=samsung sm-t875'],
            ['"SM-T575"', 'samsung=samsung sm-t575'],
            ['"SM-M325FV"', 'samsung=samsung sm-m325fv'],
            ['"SM-M325F"', 'samsung=samsung sm-m325f'],
            ['"SM-M236B"', 'samsung=samsung sm-m236b'],
            ['"SM-G985F"', 'samsung=samsung sm-g985f'],
            ['"SM-G770F"', 'samsung=samsung sm-g770f'],
            ['"SM-F721B"', 'samsung=samsung sm-f721b'],
            ['"SM-A526B"', 'samsung=samsung sm-a526b'],
            ['"SM-A526U"', 'samsung=samsung sm-a526u'],
            ['"SM-A235F"', 'samsung=samsung sm-a235f'],
            ['"SM-A047F"', 'samsung=samsung sm-a047f'],
            ['"SM-A325F"', 'samsung=samsung sm-a325f'],
            ['"SM-M536B"', 'samsung=samsung sm-m536b'],
            ['"SM-M526BR"', 'samsung=samsung sm-m526br'],
            ['"SM-M127F"', 'samsung=samsung sm-m127f'],
            ['"SM-F936B"', 'samsung=samsung sm-f936b'],
            ['"SM-A145R"', 'samsung=samsung sm-a145r'],
            ['"SM-A145P"', 'samsung=samsung sm-a145p'],
            ['"SM-A045F"', 'samsung=samsung sm-a045f'],
            ['"SM-A037G"', 'samsung=samsung sm-a037g'],
            ['"SM-A037F"', 'samsung=samsung sm-a037f'],
            ['"RMX3393"', 'realme=realme rmx3393'],
            ['"RMX3370"', 'realme=realme rmx3370'],
            ['"RMX3241"', 'realme=realme rmx3241'],
            ['"REA-NX9"', 'huawei=huawei rea-nx9'],
            ['"Pixel 7a"', 'google=google pixel 7a'],
            ['"Nokia X10"', 'nokia=nokia x10'],
            ['"Nokia X20"', 'nokia=nokia x20'],
            ['"NTN-LX1"', 'huawei=huawei ntn-lx1'],
            ['"LGE-NX9"', 'huawei=huawei lge-nx9'],
            ['"CPH2339"', 'oppo=oppo cph2339'],
            ['"CPH2385"', 'oppo=oppo cph2385'],
            ['"CPH2195"', 'oppo=oppo cph2195'],
            ['"23028RN4DG"', 'xiaomi=xiaomi 23028rn4dg'],
            ['"23021RAA2Y"', 'xiaomi=xiaomi 23021raa2y'],
            ['"22126RN91Y"', 'xiaomi=xiaomi 22126rn91y'],
            ['"2211133G"', 'xiaomi=xiaomi 2211133g'],
            ['"2112123AG"', 'xiaomi=xiaomi 2112123ag'],
            ['"21091116UG"', 'xiaomi=xiaomi 21091116ug'],
            ['"motorola razr 5G"', 'motorola=motorola razr 5g'],
            ['"moto g42"', 'motorola=motorola moto g42'],
            ['"moto g(60)"', 'motorola=motorola moto g60'],
            ['"moto g(50)"', 'motorola=motorola moto g50'],
            ['"moto g(30)"', 'motorola=motorola moto g30'],
            ['"moto g pro"', 'motorola=motorola moto g pro'],
            ['"moto e32(s)"', 'motorola=motorola moto e32s'],
            ['"SM-A426B"', 'samsung=samsung sm-a426b'],
            ['"SM-A042F"', 'samsung=samsung sm-a042f'],
            ['"SM-A025G"', 'samsung=samsung sm-a025g'],
            ['"SM-A025F"', 'samsung=samsung sm-a025f'],
            ['"SM-M135F"', 'samsung=samsung sm-m135f'],
            ['"RMX3501"', 'realme=realme rmx3501'],
            ['"RMX3151"', 'realme=realme rmx3151'],
            ['"POCO F2 Pro"', 'xiaomi=xiaomi pocophone f2 pro'],
            ['"Nokia G22"', 'nokia=nokia g22'],
            ['"Nokia C12"', 'nokia=nokia c12'],
            ['"NE2213"', 'oneplus=oneplus ne2213'],
            ['"M2002J9G"', 'xiaomi=xiaomi m2002j9g'],
            ['"LM-G910"', 'lg=lg lm-g910'],
            ['"LM-G900"', 'lg=lg lm-g900'],
            ['"LM-G850"', 'lg=lg lm-g850'],
            ['"LE2113"', 'oneplus=oneplus le2113'],
            ['"LE2115"', 'oneplus=oneplus le2115'],
            ['"IN2013"', 'oneplus=oneplus in2013'],
            ['"DBY-W09"', 'huawei=huawei dby-w09'],
            ['"HD1903"', 'oneplus=oneplus hd1903'],
            ['"FP4"', 'fairphone=fairphone fp4'],
            ['"FP3"', 'fairphone=fairphone fp3'],
            ['"CPH2251"', 'oppo=oppo cph2251'],
            ['"CPH2197"', 'oppo=oppo cph2197'],
            ['"CPH2145"', 'oppo=oppo cph2145'],
            ['"CPH2135"', 'oppo=oppo cph2135'],
            ['"ASUS_I005DA"', 'asus=asus i005da'],
            ['"ASUS_I003D"', 'asus=asus i003d'],
            ['"ASUS_I003DD"', 'asus=asus i003dd'],
            ['"2209116AG"', 'xiaomi=xiaomi 2209116ag'],
            ['"moto e30"', 'motorola=motorola moto e30'],
            ['"moto e20"', 'motorola=motorola moto e20'],
            ['"WP16"', 'oukitel=oukitel wp16'],
            ['"SM-A035F"', 'samsung=samsung sm-a035f'],
            ['"SM-A035M"', 'samsung=samsung sm-a035m'],
            ['"SM-A035G"', 'samsung=samsung sm-a035g'],
            ['"SM-M225FV"', 'samsung=samsung sm-m225fv'],
            ['"SM-A022G"', 'samsung=samsung sm-a022g'],
            ['"SM-A022F"', 'samsung=samsung sm-a022f'],
            ['"Pixel 4"', 'google=google pixel 4'],
            ['"RMX3263"', 'realme=realme rmx3263'],
            ['"M2004J19C"', 'xiaomi=xiaomi m2004j19c'],
            ['"Note 6P"', 'ulefone=ulefone note 6p'],
            ['"Nokia 2.3"', 'nokia=nokia 2.3'],
            ['"N40Pro"', 'doogee=doogee n40 pro'],
            ['"M2012K11G"', 'xiaomi=xiaomi m2012k11g'],
            ['"M2007J17G"', 'xiaomi=xiaomi m2007j17g'],
            ['"M2006C3MNG"', 'xiaomi=xiaomi m2006c3mng'],
            ['"Lenovo TB-X306X"', 'lenovo=lenovo tb-x306x'],
            ['"Lenovo TB-X306XA"', 'lenovo=lenovo tb-x306xa'],
            ['"KFRAPWI"', 'amazon=amazon kfrapwi'],
            ['"KB2003"', 'oneplus=oneplus kb2003'],
            ['"CPH2269"', 'oppo=oppo cph2269'],
            ['"BE2013"', 'oneplus=oneplus be2013'],
            ['""', null],
        ];
    }
}
