<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
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
    public function testData(string $ua, bool $hasModel, string | null $model): void
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
        self::assertSame(
            $hasModel,
            $header->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
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
     * @return array<int, array<int, bool|string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            // LG
            ['"LM-G710"', true, 'lg=lg lm-g710'],
            ['"LGE-NX9"', true, 'huawei=huawei lge-nx9'],
            ['"LM-G910"', true, 'lg=lg lm-g910'],
            ['"LM-G900"', true, 'lg=lg lm-g900'],
            ['"LM-G850"', true, 'lg=lg lm-g850'],
            ['"LM-Q630"', true, 'lg=lg lm-q630'],
            // Acer
            ['"A100"', true, 'acer=acer a100'],
            ['"B1-860A"', true, 'acer=acer b1-860a'],
            ['"A1-734"', true, 'acer=acer a1-734'],
            ['"A3-A40"', true, 'acer=acer a3-a40'],
            ['"B1-7A0"', true, 'acer=acer b1-7a0'],
            ['"B1-860A"', true, 'acer=acer b1-860a'],
            ['"B3-A32"', true, 'acer=acer b3-a32'],
            ['"B3-A40"', true, 'acer=acer b3-a40'],
            // AllCall
            ['"Atom"', true, 'allcall=allcall atom'],
            // Amazon
            ['"KFKAWI"', true, 'amazon=amazon kfkawi'],
            ['"KFGIWI"', true, 'amazon=amazon kfgiwi'],
            ['"KFFOWI"', true, 'amazon=amazon kffowi'],
            ['"KFMUWI"', true, 'amazon=amazon kfmuwi'],
            ['"KFDOWI"', true, 'amazon=amazon kfdowi'],
            ['"KFTRWI"', true, 'amazon=amazon kftrwi'],
            ['"KFTRPWI"', true, 'amazon=amazon kftrpwi'],
            ['"KFRAPWI"', true, 'amazon=amazon kfrapwi'],
            ['"KFONWI"', true, 'amazon=amazon kfonwi'],
            ['"KFMAWI"', true, 'amazon=amazon kfmawi'],
            ['"KFSUWI"', true, 'amazon=amazon kfsuwi'],
            // Asus
            ['"P024"', true, 'asus=asus p024'],
            ['"ASUS_X00DD"', true, 'asus=asus x00dd'],
            ['"ASUS_I005DA"', true, 'asus=asus i005da'],
            ['"ASUS_I003D"', true, 'asus=asus i003d'],
            ['"ASUS_I003DD"', true, 'asus=asus i003dd'],
            ['"ASUS_I006D"', true, 'asus=asus i006d'],
            ['"ZC554KL"', true, 'asus=asus x00id'],
            // Google
            ['"Nexus 7"', true, 'google=google nexus 7'],
            ['"Pixel 7 Pro"', true, 'google=google pixel 7 pro'],
            ['"Pixel 4 XL"', true, 'google=google pixel 4 xl'],
            ['"Pixel 6"', true, 'google=google pixel 6'],
            ['"Pixel 6 Pro"', true, 'google=google pixel 6 pro'],
            ['"Pixel 6a"', true, 'google=google pixel 6a'],
            ['"Pixel 4a (5G)"', true, 'google=google pixel 4a 5g'],
            ['"Pixel 7"', true, 'google=google pixel 7'],
            ['"Pixel 3a"', true, 'google=google pixel 3a'],
            ['"Pixel 3"', true, 'google=google pixel 3'],
            ['"Pixel 5"', true, 'google=google pixel 5'],
            ['"Pixel 7a"', true, 'google=google pixel 7a'],
            ['"Pixel 4"', true, 'google=google pixel 4'],
            // OnePlus
            ['"AC2003"', true, 'oneplus=oneplus ac2003'],
            ['"IN2023"', true, 'oneplus=oneplus in2023'],
            ['"NE2213"', true, 'oneplus=oneplus ne2213'],
            ['"LE2113"', true, 'oneplus=oneplus le2113'],
            ['"LE2115"', true, 'oneplus=oneplus le2115'],
            ['"IN2013"', true, 'oneplus=oneplus in2013'],
            ['"HD1903"', true, 'oneplus=oneplus hd1903'],
            ['"KB2003"', true, 'oneplus=oneplus kb2003'],
            ['"BE2013"', true, 'oneplus=oneplus be2013'],
            ['"LE2123"', true, 'oneplus=oneplus le2123'],
            ['"LE2125"', true, 'oneplus=oneplus le2125'],
            ['"LE2120"', true, 'oneplus=oneplus le2120'],
            ['"GM1913"', true, 'oneplus=oneplus gm1913'],
            ['"BE2029"', true, 'oneplus=oneplus be2029'],
            ['"CPH2399"', true, 'oneplus=oneplus cph2399'],
            ['"DN2103"', true, 'oneplus=oneplus dn2103'],
            ['"CPH2415"', true, 'oneplus=oneplus cph2415'],
            ['"EB2103"', true, 'oneplus=oneplus eb2103'],
            ['"IN2015"', true, 'oneplus=oneplus in2015'],
            ['"CPH2409"', true, 'oneplus=oneplus cph2409'],
            // Oppo
            ['"CPH2065"', true, 'oppo=oppo cph2065'],
            ['"CPH2211"', true, 'oppo=oppo cph2211'],
            ['"CPH2271"', true, 'oppo=oppo cph2271'],
            ['"CPH2339"', true, 'oppo=oppo cph2339'],
            ['"CPH2385"', true, 'oppo=oppo cph2385'],
            ['"CPH2195"', true, 'oppo=oppo cph2195'],
            ['"CPH2251"', true, 'oppo=oppo cph2251'],
            ['"CPH2197"', true, 'oppo=oppo cph2197'],
            ['"CPH2145"', true, 'oppo=oppo cph2145'],
            ['"CPH2135"', true, 'oppo=oppo cph2135'],
            ['"CPH2269"', true, 'oppo=oppo cph2269'],
            ['"CPH2173"', true, 'oppo=oppo cph2173'],
            ['"CPH2179"', true, 'oppo=oppo cph2179'],
            ['"CPH2219"', true, 'oppo=oppo cph2219'],
            ['"CPH2333"', true, 'oppo=oppo cph2333'],
            ['"CPH2305"', true, 'oppo=oppo cph2305'],
            ['"CPH2247"', true, 'oppo=oppo cph2247'],
            ['"CPH2375"', true, 'oppo=oppo cph2375'],
            ['"CPH2307"', true, 'oppo=oppo cph2307'],
            ['"CPH2161"', true, 'oppo=oppo cph2161'],
            ['"CPH2207"', true, 'oppo=oppo cph2207'],
            ['"CPH2091"', true, 'oppo=oppo cph2091'],
            ['"CPH2371"', true, 'oppo=oppo cph2371'],
            ['"CPH1907"', true, 'oppo=oppo cph1907'],
            ['"CPH2185"', true, 'oppo=oppo cph2185'],
            ['"CPH2343"', true, 'oppo=oppo cph2343'],
            ['"CPH2273"', true, 'oppo=oppo cph2273'],
            ['"CPH2127"', true, 'oppo=oppo cph2127'],
            // Xiaomi
            ['"Redmi Note 9 Pro"', true, 'xiaomi=xiaomi redmi note 9 pro'],
            ['"M2103K19G"', true, 'xiaomi=xiaomi m2103k19g'],
            ['"M2103K19C"', true, 'xiaomi=xiaomi m2103k19c'],
            ['"M2102K1AC"', true, 'xiaomi=xiaomi m2102k1ac'],
            ['"M2101K9AG"', true, 'xiaomi=xiaomi m2101k9ag'],
            ['"M2101K9AI"', true, 'xiaomi=xiaomi m2101k9ai'],
            ['"M2101K9G"', true, 'xiaomi=xiaomi m2101k9g'],
            ['"M2101K9C"', true, 'xiaomi=xiaomi m2101k9c'],
            ['"M2101K9R"', true, 'xiaomi=xiaomi m2101k9r'],
            ['"M2101K6G"', true, 'xiaomi=xiaomi m2101k6g'],
            ['"M2101K6R"', true, 'xiaomi=xiaomi m2101k6r'],
            ['"M2101K6P"', true, 'xiaomi=xiaomi m2101k6p'],
            ['"M2011K2G"', true, 'xiaomi=xiaomi m2011k2g'],
            ['"M2011K2C"', true, 'xiaomi=xiaomi m2011k2c'],
            ['"M2101K7BNY"', true, 'xiaomi=xiaomi m2101k7bny'],
            ['"M2101K7BG"', true, 'xiaomi=xiaomi m2101k7bg'],
            ['"M2101K7BI"', true, 'xiaomi=xiaomi m2101k7bi'],
            ['"M2101K7BL"', true, 'xiaomi=xiaomi m2101k7bl'],
            ['"M2010J19SG"', true, 'xiaomi=xiaomi m2010j19sg'],
            ['"M2010J19SY"', true, 'xiaomi=xiaomi m2010j19sy'],
            ['"M2101K7AG"', true, 'xiaomi=xiaomi m2101k7ag'],
            ['"M2101K7AI"', true, 'xiaomi=xiaomi m2101k7ai'],
            ['"M2007J22G"', true, 'xiaomi=xiaomi m2007j22g'],
            ['"M2012K11AG"', true, 'xiaomi=xiaomi m2012k11ag'],
            ['"M2102J20SG"', true, 'xiaomi=xiaomi m2102j20sg'],
            ['"M2102J20SI"', true, 'xiaomi=xiaomi m2102j20si'],
            ['"M1908C3JGG"', true, 'xiaomi=xiaomi m1908c3jgg'],
            ['"2201123G"', true, 'xiaomi=xiaomi 2201123g'],
            ['"2201123C"', true, 'xiaomi=xiaomi 2201123c'],
            ['"2201117TY"', true, 'xiaomi=xiaomi 2201117ty'],
            ['"2201117TG"', true, 'xiaomi=xiaomi 2201117tg'],
            ['"2201117TI"', true, 'xiaomi=xiaomi 2201117ti'],
            ['"2201117TL"', true, 'xiaomi=xiaomi 2201117tl'],
            ['"21091116AC"', true, 'xiaomi=xiaomi 21091116ac'],
            ['"21121119SC"', true, 'xiaomi=xiaomi 21121119sc'],
            ['"M2102K1G"', true, 'xiaomi=xiaomi m2102k1g'],
            ['"M2102K1C"', true, 'xiaomi=xiaomi m2102k1c'],
            ['"220333QNY"', true, 'xiaomi=xiaomi 220333qny'],
            ['Redmi Note 8 Pro', true, 'xiaomi=xiaomi redmi note 8 pro'],
            ['"Mi 9 SE"', true, 'xiaomi=xiaomi mi 9 se'],
            ['"21081111RG"', true, 'xiaomi=xiaomi 21081111rg'],
            ['"2201116SG"', true, 'xiaomi=xiaomi 2201116sg'],
            ['"2109119DG"', true, 'xiaomi=xiaomi 2109119dg'],
            ['"2107113SG"', true, 'xiaomi=xiaomi 2107113sg'],
            ['"2201117SY"', true, 'xiaomi=xiaomi 2201117sy'],
            ['"21061119DG"', true, 'xiaomi=xiaomi 21061119dg'],
            ['"21061119AG"', true, 'xiaomi=xiaomi 21061119ag'],
            ['"M2003J15SC"', true, 'xiaomi=xiaomi m2003j15sc'],
            ['"2210132G"', true, 'xiaomi=xiaomi 2210132g'],
            ['"22081212UG"', true, 'xiaomi=xiaomi 22081212ug'],
            ['"M2010J19CG"', true, 'xiaomi=xiaomi m2010j19cg'],
            ['"21051182G"', true, 'xiaomi=xiaomi 21051182g'],
            ['"22011119UY"', true, 'xiaomi=xiaomi 22011119uy'],
            ['"220733SG"', true, 'xiaomi=xiaomi 220733sg'],
            ['"Mi Note 10 Lite"', true, 'xiaomi=xiaomi mi note 10 lite'],
            ['"Mi Note 10 Pro"', true, 'xiaomi=xiaomi mi note 10 pro'],
            ['"22101316UG"', true, 'xiaomi=xiaomi 22101316ug'],
            ['"23028RN4DG"', true, 'xiaomi=xiaomi 23028rn4dg'],
            ['"23021RAA2Y"', true, 'xiaomi=xiaomi 23021raa2y'],
            ['"22126RN91Y"', true, 'xiaomi=xiaomi 22126rn91y'],
            ['"2211133G"', true, 'xiaomi=xiaomi 2211133g'],
            ['"2112123AG"', true, 'xiaomi=xiaomi 2112123ag'],
            ['"21091116UG"', true, 'xiaomi=xiaomi 21091116ug'],
            ['"POCO F2 Pro"', true, 'xiaomi=xiaomi pocophone f2 pro'],
            ['"M2002J9G"', true, 'xiaomi=xiaomi m2002j9g'],
            ['"2209116AG"', true, 'xiaomi=xiaomi 2209116ag'],
            ['"M2004J19C"', true, 'xiaomi=xiaomi m2004j19c'],
            ['"M2012K11G"', true, 'xiaomi=xiaomi m2012k11g'],
            ['"M2007J17G"', true, 'xiaomi=xiaomi m2007j17g'],
            ['"M2006C3MNG"', true, 'xiaomi=xiaomi m2006c3mng'],
            ['"2201117PG"', true, 'xiaomi=xiaomi 2201117pg'],
            ['"22071212AG"', true, 'xiaomi=xiaomi 22071212ag'],
            ['"2201116PG"', true, 'xiaomi=xiaomi 2201116pg'],
            ['"2203129G"', true, 'xiaomi=xiaomi 2203129g'],
            ['"21051182C"', true, 'xiaomi=xiaomi 21051182c'],
            ['"22111317PG"', true, 'xiaomi=xiaomi 22111317pg'],
            ['"M2103K19PG"', true, 'xiaomi=xiaomi m2103k19pg'],
            ['"Mi 10 Pro"', true, 'xiaomi=xiaomi mi 10 pro 5g'],
            ['"21121210G"', true, 'xiaomi=xiaomi 21121210g'],
            ['"22101320G"', true, 'xiaomi=xiaomi 22101320g'],
            ['"220233L2G"', true, 'xiaomi=xiaomi 220233l2g'],
            // ZTE
            ['"ZTE A2121E"', true, 'zte=zte a2121e'],
            ['"ZTE Blade 10 Vita"', true, 'zte=zte blade 10 vita'],
            ['"ZTE Blade A3 2020"', true, 'zte=zte blade a3 2020'],
            ['"ZTE 8045"', true, 'zte=zte 8045'],
            ['"ZTE A2322G"', true, 'zte=zte a2322g'],
            // Samsung
            ['"SM-A415F"', true, 'samsung=samsung sm-a415f'],
            ['"SM-A505FN"', true, 'samsung=samsung sm-a505fn'],
            ['"SM-A515F"', true, 'samsung=samsung sm-a515f'],
            ['"SM-G960F"', true, 'samsung=samsung sm-g960f'],
            ['"SM-A405FN"', true, 'samsung=samsung sm-a405fn'],
            ['"SM-S901B"', true, 'samsung=samsung sm-s901b'],
            ['"SM-S901U"', true, 'samsung=samsung sm-s901u'],
            ['"SM-S901U1"', true, 'samsung=samsung sm-s901u1'],
            ['"SM-S918B"', true, 'samsung=samsung sm-s918b'],
            ['"SM-S908B"', true, 'samsung=samsung sm-s908b'],
            ['"SM-S908U"', true, 'samsung=samsung sm-s908u'],
            ['"SM-S908U1"', true, 'samsung=samsung sm-s908u1'],
            ['"SM-G780G"', true, 'samsung=samsung sm-g780g'],
            ['"SM-A536B"', true, 'samsung=samsung sm-a536b'],
            ['"SM-A528B"', true, 'samsung=samsung sm-a528b'],
            ['"SM-A135F"', true, 'samsung=samsung sm-a135f'],
            ['"SM-T510"', true, 'samsung=samsung sm-t510'],
            ['"SM-T970"', true, 'samsung=samsung sm-t970'],
            ['"SM-T580"', true, 'samsung=samsung sm-t580'],
            ['"SM-T550"', true, 'samsung=samsung sm-t550'],
            ['"SM-T813"', true, 'samsung=samsung sm-t813'],
            ['"SM-A336B"', true, 'samsung=samsung sm-a336b'],
            ['"SM-A336E"', true, 'samsung=samsung sm-a336e'],
            ['"SM-A127F"', true, 'samsung=samsung sm-a127f'],
            ['"SM-G525F"', true, 'samsung=samsung sm-g525f'],
            ['"SM-A226BR"', true, 'samsung=samsung sm-a226br'],
            ['"SM-A226B"', true, 'samsung=samsung sm-a226b'],
            ['"SM-A546B"', true, 'samsung=samsung sm-a546b'],
            ['"SM-T220"', true, 'samsung=samsung sm-t220'],
            ['"SM-T225"', true, 'samsung=samsung sm-t225'],
            ['"SM-T225N"', true, 'samsung=samsung sm-t225n'],
            ['"SM-A326B"', true, 'samsung=samsung sm-a326b'],
            ['"SM-A326U"', true, 'samsung=samsung sm-a326u'],
            ['"SM-A725F"', true, 'samsung=samsung sm-a725f'],
            ['"SM-G990B"', true, 'samsung=samsung sm-g990b'],
            ['"SM-G990B2"', true, 'samsung=samsung sm-g990b2'],
            ['"SM-G990E"', true, 'samsung=samsung sm-g990e'],
            ['"SM-A125F"', true, 'samsung=samsung sm-a125f'],
            ['"SM-P619"', true, 'samsung=samsung sm-p619'],
            ['"SM-P613"', true, 'samsung=samsung sm-p613'],
            ['"SM-A136B"', true, 'samsung=samsung sm-a136b'],
            ['"SM-G736B"', true, 'samsung=samsung sm-g736b'],
            ['"SM-F711B"', true, 'samsung=samsung sm-f711b'],
            ['"SM-F711U"', true, 'samsung=samsung sm-f711u'],
            ['"SM-A225F"', true, 'samsung=samsung sm-a225f'],
            ['"SM-A137F"', true, 'samsung=samsung sm-a137f'],
            ['"SM-A146P"', true, 'samsung=samsung sm-a146p'],
            ['"SM-A236B"', true, 'samsung=samsung sm-a236b'],
            ['"SM-A525F"', true, 'samsung=samsung sm-a525f'],
            ['"SM-F731B"', true, 'samsung=samsung sm-f731b'],
            ['"SM-F926B"', true, 'samsung=samsung sm-f926b'],
            ['"SM-S906B"', true, 'samsung=samsung sm-s906b'],
            ['"SM-S911B"', true, 'samsung=samsung sm-s911b'],
            ['"SM-S916B"', true, 'samsung=samsung sm-s916b'],
            ['"SM-X706B"', true, 'samsung=samsung sm-x706b'],
            ['"SM-X700"', true, 'samsung=samsung sm-x700'],
            ['"SM-X200"', true, 'samsung=samsung sm-x200'],
            ['"SM-X205"', true, 'samsung=samsung sm-x205'],
            ['"SM-T976B"', true, 'samsung=samsung sm-t976b'],
            ['"SM-T870"', true, 'samsung=samsung sm-t870'],
            ['"SM-T875"', true, 'samsung=samsung sm-t875'],
            ['"SM-T575"', true, 'samsung=samsung sm-t575'],
            ['"SM-M325FV"', true, 'samsung=samsung sm-m325fv'],
            ['"SM-M325F"', true, 'samsung=samsung sm-m325f'],
            ['"SM-M236B"', true, 'samsung=samsung sm-m236b'],
            ['"SM-G985F"', true, 'samsung=samsung sm-g985f'],
            ['"SM-G770F"', true, 'samsung=samsung sm-g770f'],
            ['"SM-F721B"', true, 'samsung=samsung sm-f721b'],
            ['"SM-A526B"', true, 'samsung=samsung sm-a526b'],
            ['"SM-A526U"', true, 'samsung=samsung sm-a526u'],
            ['"SM-A235F"', true, 'samsung=samsung sm-a235f'],
            ['"SM-A047F"', true, 'samsung=samsung sm-a047f'],
            ['"SM-A325F"', true, 'samsung=samsung sm-a325f'],
            ['"SM-M536B"', true, 'samsung=samsung sm-m536b'],
            ['"SM-M526BR"', true, 'samsung=samsung sm-m526br'],
            ['"SM-M127F"', true, 'samsung=samsung sm-m127f'],
            ['"SM-F936B"', true, 'samsung=samsung sm-f936b'],
            ['"SM-A145R"', true, 'samsung=samsung sm-a145r'],
            ['"SM-A145P"', true, 'samsung=samsung sm-a145p'],
            ['"SM-A045F"', true, 'samsung=samsung sm-a045f'],
            ['"SM-A037G"', true, 'samsung=samsung sm-a037g'],
            ['"SM-A037F"', true, 'samsung=samsung sm-a037f'],
            ['"SM-A426B"', true, 'samsung=samsung sm-a426b'],
            ['"SM-A042F"', true, 'samsung=samsung sm-a042f'],
            ['"SM-A025G"', true, 'samsung=samsung sm-a025g'],
            ['"SM-A025F"', true, 'samsung=samsung sm-a025f'],
            ['"SM-M135F"', true, 'samsung=samsung sm-m135f'],
            ['"SM-A035F"', true, 'samsung=samsung sm-a035f'],
            ['"SM-A035M"', true, 'samsung=samsung sm-a035m'],
            ['"SM-A035G"', true, 'samsung=samsung sm-a035g'],
            ['"SM-M225FV"', true, 'samsung=samsung sm-m225fv'],
            ['"SM-A022G"', true, 'samsung=samsung sm-a022g'],
            ['"SM-A022F"', true, 'samsung=samsung sm-a022f'],
            ['"SM-M336B"', true, 'samsung=samsung sm-m336b'],
            ['"SM-M336BU"', true, 'samsung=samsung sm-m336bu'],
            ['"SM-M115F"', true, 'samsung=samsung sm-m115f'],
            ['"SM-T595"', true, 'samsung=samsung sm-t595'],
            ['"SM-T830"', true, 'samsung=samsung sm-t830'],
            ['"SM-T835"', true, 'samsung=samsung sm-t835'],
            ['"SM-T733"', true, 'samsung=samsung sm-t733'],
            ['"SM-T736B"', true, 'samsung=samsung sm-t736b'],
            ['"SM-X900"', true, 'samsung=samsung sm-x900'],
            ['"SM-X906B"', true, 'samsung=samsung sm-x906b'],
            ['"SM-G965F"', true, 'samsung=samsung sm-g965f'],
            ['"SM-G975F"', true, 'samsung=samsung sm-g975f'],
            ['"SM-A217F"', true, 'samsung=samsung sm-a217f'],
            ['"SM-G988B"', true, 'samsung=samsung sm-g988b'],
            ['"SM-A750FN"', true, 'samsung=samsung sm-a750fn'],
            ['"SM-N960F"', true, 'samsung=samsung sm-n960f'],
            ['"SM-G781B"', true, 'samsung=samsung sm-g781b'],
            ['"SM-A105FN"', true, 'samsung=samsung sm-a105fn'],
            ['SM-G920F', true, 'samsung=samsung sm-g920f'],
            // Huawei
            ['"VOG-L29"', true, 'huawei=huawei vog-l29'],
            ['"MAR-LX1B"', true, 'huawei=huawei mar-lx1b'],
            ['"LYA-L09"', true, 'huawei=huawei lya-l09'],
            ['"NEN-LX1"', true, 'huawei=huawei nen-lx1'],
            ['"PPA-LX1"', true, 'huawei=huawei ppa-lx1'],
            ['"JAD-LX9"', true, 'huawei=huawei jad-lx9'],
            ['"REA-NX9"', true, 'huawei=huawei rea-nx9'],
            ['"NTN-LX1"', true, 'huawei=huawei ntn-lx1'],
            ['"DBY-W09"', true, 'huawei=huawei dby-w09'],
            ['"NAM-LX9"', true, 'huawei=huawei nam-lx9'],
            ['"STK-LX1"', true, 'huawei=huawei stk-lx1'],
            ['"PPA-LX2"', true, 'huawei=huawei ppa-lx2'],
            ['"AGR-W09"', true, 'huawei=huawei agr-w09'],
            ['"AGS3K-W09"', true, 'huawei=huawei ags3k-w09'],
            ['"NTH-NX9"', true, 'huawei=huawei nth-nx9'],
            ['"NOH-AN01"', true, 'huawei=huawei noh-an01'],
            ['"HLK-L41"', true, 'huawei=huawei hlk-l41'],
            ['"BAH3-W59"', true, 'huawei=huawei bah3-w59'],
            ['"BAH3-W09"', true, 'huawei=huawei bah3-w09'],
            ['"BAH3-L09"', true, 'huawei=huawei bah3-l09'],
            ['"HRY-LX1T"', true, 'huawei=huawei hry-lx1t'],
            ['"HRY-LX1"', true, 'huawei=huawei hry-lx1'],
            ['"JSN-L21"', true, 'huawei=huawei jsn-l21'],
            ['"JKM-LX2"', true, 'huawei=huawei jkm-lx2'],
            ['"STK-L21"', true, 'huawei=huawei stk-l21'],
            ['"SNE-LX1"', true, 'huawei=huawei sne-lx1'],
            ['"INE-LX1"', true, 'huawei=huawei ine-lx1'],
            ['"INE-LX1r"', true, 'huawei=huawei ine-lx1r'],
            ['"FNE-NX9"', true, 'huawei=huawei fne-nx9'],
            ['"PGT-N19"', true, 'huawei=huawei pgt-n19'],
            ['"AGS2-W09"', true, 'huawei=huawei ags2-w09'],
            ['"ELS-NX9"', true, 'huawei=huawei els-nx9'],
            ['"ANE-LX1"', true, 'huawei=huawei ane-lx1'],
            ['"YAL-L41"', true, 'huawei=huawei yal-l41'],
            // Lenovo
            ['"Lenovo TB-X304F"', true, 'lenovo=lenovo tb-x304f'],
            ['"X1030X"', true, 'lenovo=lenovo x1030x'],
            ['"Lenovo YT-J706F"', true, 'lenovo=lenovo yt-j706f'],
            ['"Lenovo TB-X306X"', true, 'lenovo=lenovo tb-x306x'],
            ['"Lenovo TB-X306XA"', true, 'lenovo=lenovo tb-x306xa'],
            ['"Lenovo TB-J616F"', true, 'lenovo=lenovo tb-j616f'],
            ['"Lenovo TB-J616X"', true, 'lenovo=lenovo tb-j616x'],
            ['"Lenovo TB-X606F"', true, 'lenovo=lenovo tb-x606f'],
            ['"Lenovo TB-8705F"', true, 'lenovo=lenovo tb-8705f'],
            ['"Lenovo TB-8505X"', true, 'lenovo=lenovo tb-8505x'],
            // Nokia
            ['"Nokia G50"', true, 'nokia=nokia g50'],
            ['"Nokia G20"', true, 'nokia=nokia g20'],
            ['"Nokia X10"', true, 'nokia=nokia x10'],
            ['"Nokia X20"', true, 'nokia=nokia x20'],
            ['"Nokia G22"', true, 'nokia=nokia g22'],
            ['"Nokia C12"', true, 'nokia=nokia c12'],
            ['"Nokia 2.3"', true, 'nokia=nokia 2.3'],
            ['"Nokia 5.4"', true, 'nokia=nokia 5.4'],
            ['"Nokia 8.3 5G"', true, 'nokia=nokia 8.3 5g'],
            ['"Nokia G11"', true, 'nokia=nokia g11'],
            // Microsoft
            ['"Surface Duo"', true, 'microsoft=microsoft surface duo'],
            // realme
            ['"RMX3085"', true, 'realme=realme rmx3085'],
            ['"RMX3231"', true, 'realme=realme rmx3231'],
            ['"RMX3393"', true, 'realme=realme rmx3393'],
            ['"RMX3370"', true, 'realme=realme rmx3370'],
            ['"RMX3241"', true, 'realme=realme rmx3241'],
            ['"RMX3501"', true, 'realme=realme rmx3501'],
            ['"RMX3151"', true, 'realme=realme rmx3151'],
            ['"RMX3263"', true, 'realme=realme rmx3263'],
            ['"RMX3201"', true, 'realme=realme rmx3201'],
            ['"RMX2202"', true, 'realme=realme rmx2202'],
            ['"RMX2155"', true, 'realme=realme rmx2155'],
            ['"RMX3081"', true, 'realme=realme rmx3081'],
            ['"RMX2193"', true, 'realme=realme rmx2193'],
            ['"RMX3311"', true, 'realme=realme rmx3311'],
            ['"RMX3521"', true, 'realme=realme rmx3521'],
            ['"RMX3269"', true, 'realme=realme rmx3269'],
            ['"RMX3363"', true, 'realme=realme rmx3363'],
            ['"RMX3511"', true, 'realme=realme rmx3511'],
            ['"RMX3301"', true, 'realme=realme rmx3301'],
            ['"RMX3242"', true, 'realme=realme rmx3242'],
            ['"RMX3563"', true, 'realme=realme rmx3563'],
            ['"RMX3623"', true, 'realme=realme rmx3623'],
            ['"RMX1931"', true, 'realme=realme rmx1931'],
            // Motorola
            ['"moto g200 5G"', true, 'motorola=motorola moto g200 5g'],
            ['"motorola razr 5G"', true, 'motorola=motorola razr 5g'],
            ['"moto g42"', true, 'motorola=motorola moto g42'],
            ['"moto g(60)"', true, 'motorola=motorola moto g60'],
            ['"moto g(50)"', true, 'motorola=motorola moto g50'],
            ['"moto g(30)"', true, 'motorola=motorola moto g30'],
            ['"moto g pro"', true, 'motorola=motorola moto g pro'],
            ['"moto e32(s)"', true, 'motorola=motorola moto e32s'],
            ['"moto e30"', true, 'motorola=motorola moto e30'],
            ['"moto e20"', true, 'motorola=motorola moto e20'],
            ['"moto e40"', true, 'motorola=motorola moto e40'],
            ['"moto g(8) plus"', true, 'motorola=motorola moto g8 plus'],
            ['"motorola one macro"', true, 'motorola=motorola one macro'],
            ['"Motorola Defy"', true, 'motorola=motorola defy 2021'],
            ['"moto g 5G"', true, 'motorola=motorola moto g 5g'],
            ['"motorola edge 20"', true, 'motorola=motorola edge 20 2021'],
            ['"motorola edge 20 lite"', true, 'motorola=motorola edge 20 lite'],
            ['"motorola edge 20 pro"', true, 'motorola=motorola edge 20 pro'],
            ['"motorola edge 30 neo"', true, 'motorola=motorola edge 30 neo'],
            ['"motorola edge 30"', true, 'motorola=motorola edge 30'],
            ['"motorola edge 30 ultra"', true, 'motorola=motorola edge 30 ultra'],
            ['moto g(20)', true, 'motorola=motorola moto g20'],
            // Sony
            ['"XQ-CC54"', true, 'sony=sony xq-cc54'],
            ['"XQ-BQ52"', true, 'sony=sony xq-bq52'],
            ['"XQ-BE52"', true, 'sony=sony xq-be52'],
            ['"H8266"', true, 'sony=sony h8266'],
            // Vivo
            ['"V2109"', true, 'vivo=vivo v2109'],
            ['"vivo 1716"', true, 'vivo=vivo 1716'],
            ['"vivo 1920"', true, 'vivo=vivo 1920'],
            // Fairphone
            ['"FP4"', true, 'fairphone=fairphone fp4'],
            ['"FP3"', true, 'fairphone=fairphone fp3'],
            // Oukitel
            ['"WP16"', true, 'oukitel=oukitel wp16'],
            ['"WP18"', true, 'oukitel=oukitel wp18'],
            // Ulefone
            ['"Note 6P"', true, 'ulefone=ulefone note 6p'],
            ['"Armor 11T 5G"', true, 'ulefone=ulefone armor 11t 5g'],
            ['"Armor X5"', true, 'ulefone=ulefone armor x5'],
            // Doogee
            ['"N40Pro"', true, 'doogee=doogee n40 pro'],
            ['"S88Pro"', true, 'doogee=doogee s88 pro'],
            ['"S59Pro"', true, 'doogee=doogee s59 pro'],
            ['"S97Pro"', true, 'doogee=doogee s97 pro'],
            ['"X30"', true, 'doogee=doogee x30'],
            // shiftphones
            ['"SHIFT6mq"', true, 'shift-phones=shift-phones shift6mq'],
            // Cubot/Hafury
            ['"GT20"', true, 'cubot=cubot gt20'],
            // Aoyodkg
            ['"AOYODKG_A38"', true, 'aoyodkg=aoyodkg a38'],
            // gigaset
            ['"E940-2795-00"', true, 'gigaset=gigaset e940-2795-00'],
            // wiko
            ['"W-V750BN-EEA"', true, 'wiko=wiko w-v750bn-eea'],
            ['"W-V680-EEA"', true, 'wiko=wiko w-v680-eea'],
            // razer
            ['"Phone 2"', true, 'razer=razer phone 2'],
            // Alcatel
            ['"5024D_EEA"', true, 'alcatel=alcatel 5024d_eea'],
            // HTC
            ['"HTC Desire 19+"', true, 'htc=htc desire 19 plus'],
            // teclast
            ['"P30S_EEA"', true, 'teclast=teclast p30s_eea'],
            // other
            ['"Model"', false, null],
            ['""', false, null],
        ];
    }
}
