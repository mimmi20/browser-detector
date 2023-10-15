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

namespace BrowserDetector\Header;

use function mb_strtolower;
use function trim;

final class SecChUaModel implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function hasDeviceCode(): bool
    {
        return true;
    }

    /** @throws void */
    public function getDeviceCode(): string | null
    {
        $value = trim($this->value, '"');
        $code  = mb_strtolower($value);

        return match ($code) {
            // LG
            'lm-g710' => 'lg=lg lm-g710',
            'lm-g910' => 'lg=lg lm-g910',
            'lm-g900' => 'lg=lg lm-g900',
            'lm-g850' => 'lg=lg lm-g850',
            // Acer
            'a100' => 'acer=acer a100',
            'a1-734' => 'acer=acer a1-734',
            'a3-a40' => 'acer=acer a3-a40',
            'b1-7a0' => 'acer=acer b1-7a0',
            'b1-860a' => 'acer=acer b1-860a',
            'b3-a32' => 'acer=acer b3-a32',
            'b3-a40' => 'acer=acer b3-a40',
            // AllCall
            'atom' => 'allcall=allcall atom',
            // Amazon
            'kfkawi' => 'amazon=amazon kfkawi',
            'kfgiwi' => 'amazon=amazon kfgiwi',
            'kffowi' => 'amazon=amazon kffowi',
            'kfmuwi' => 'amazon=amazon kfmuwi',
            'kfdowi' => 'amazon=amazon kfdowi',
            'kftrwi' => 'amazon=amazon kftrwi',
            'kftrpwi' => 'amazon=amazon kftrpwi',
            'kfrapwi' => 'amazon=amazon kfrapwi',
            // Asus
            'p024' => 'asus=asus p024',
            'asus_x00dd' => 'asus=asus x00dd',
            'asus_i005da' => 'asus=asus i005da',
            'asus_i003d' => 'asus=asus i003d',
            'asus_i003dd' => 'asus=asus i003dd',
            // Google
            'nexus 7' => 'google=google nexus 7',
            'pixel 3' => 'google=google pixel 3',
            'pixel 3a' => 'google=google pixel 3a',
            'pixel 4' => 'google=google pixel 4',
            'pixel 4 xl' => 'google=google pixel 4 xl',
            'pixel 4a (5g)' => 'google=google pixel 4a 5g',
            'pixel 5' => 'google=google pixel 5',
            'pixel 6' => 'google=google pixel 6',
            'pixel 6a' => 'google=google pixel 6a',
            'pixel 6 pro' => 'google=google pixel 6 pro',
            'pixel 7' => 'google=google pixel 7',
            'pixel 7a' => 'google=google pixel 7a',
            'pixel 7 pro' => 'google=google pixel 7 pro',
            // OnePlus
            'ac2003' => 'oneplus=oneplus ac2003',
            'in2023' => 'oneplus=oneplus in2023',
            'ne2213' => 'oneplus=oneplus ne2213',
            'le2113' => 'oneplus=oneplus le2113',
            'le2115' => 'oneplus=oneplus le2115',
            'in2013' => 'oneplus=oneplus in2013',
            'hd1903' => 'oneplus=oneplus hd1903',
            'kb2003' => 'oneplus=oneplus kb2003',
            'be2013' => 'oneplus=oneplus be2013',
            'le2123' => 'oneplus=oneplus le2123',
            'le2125' => 'oneplus=oneplus le2125',
            'le2120' => 'oneplus=oneplus le2120',
            // Oppo
            'cph2065' => 'oppo=oppo cph2065',
            'cph2211' => 'oppo=oppo cph2211',
            'cph2271' => 'oppo=oppo cph2271',
            'cph2339' => 'oppo=oppo cph2339',
            'cph2385' => 'oppo=oppo cph2385',
            'cph2195' => 'oppo=oppo cph2195',
            'cph2251' => 'oppo=oppo cph2251',
            'cph2197' => 'oppo=oppo cph2197',
            'cph2145' => 'oppo=oppo cph2145',
            'cph2135' => 'oppo=oppo cph2135',
            'cph2269' => 'oppo=oppo cph2269',
            // Xiaomi
            'redmi note 9 pro' => 'xiaomi=xiaomi redmi note 9 pro',
            'redmi note 8 pro' => 'xiaomi=xiaomi redmi note 8 pro',
            'mi 9 se' => 'xiaomi=xiaomi mi 9 se',
            'm2103k19g' => 'xiaomi=xiaomi m2103k19g',
            'm2103k19c' => 'xiaomi=xiaomi m2103k19c',
            'm2102k1g' => 'xiaomi=xiaomi m2102k1g',
            'm2102k1c' => 'xiaomi=xiaomi m2102k1c',
            'm2102k1ac' => 'xiaomi=xiaomi m2102k1ac',
            'm2101k9ai' => 'xiaomi=xiaomi m2101k9ai',
            'm2101k9ag' => 'xiaomi=xiaomi m2101k9ag',
            'm2101k9g' => 'xiaomi=xiaomi m2101k9g',
            'm2101k9c' => 'xiaomi=xiaomi m2101k9c',
            'm2101k9r' => 'xiaomi=xiaomi m2101k9r',
            'm2101k6g' => 'xiaomi=xiaomi m2101k6g',
            'm2101k6r' => 'xiaomi=xiaomi m2101k6r',
            'm2101k6p' => 'xiaomi=xiaomi m2101k6p',
            'm2011k2g' => 'xiaomi=xiaomi m2011k2g',
            'm2011k2c' => 'xiaomi=xiaomi m2011k2c',
            'm2101k7bny' => 'xiaomi=xiaomi m2101k7bny',
            'm2101k7bg' => 'xiaomi=xiaomi m2101k7bg',
            'm2101k7bi' => 'xiaomi=xiaomi m2101k7bi',
            'm2101k7bl' => 'xiaomi=xiaomi m2101k7bl',
            'm2010j19sy' => 'xiaomi=xiaomi m2010j19sy',
            'm2010j19sg' => 'xiaomi=xiaomi m2010j19sg',
            'm2101k7ag' => 'xiaomi=xiaomi m2101k7ag',
            'm2101k7ai' => 'xiaomi=xiaomi m2101k7ai',
            'm2007j22g' => 'xiaomi=xiaomi m2007j22g',
            'm2012k11ag' => 'xiaomi=xiaomi m2012k11ag',
            'm2102j20si' => 'xiaomi=xiaomi m2102j20si',
            'm2102j20sg' => 'xiaomi=xiaomi m2102j20sg',
            'm1908c3jgg' => 'xiaomi=xiaomi m1908c3jgg',
            '220333qny' => 'xiaomi=xiaomi 220333qny',
            '2201123g' => 'xiaomi=xiaomi 2201123g',
            '2201123c' => 'xiaomi=xiaomi 2201123c',
            '2201117ty' => 'xiaomi=xiaomi 2201117ty',
            '2201117tl' => 'xiaomi=xiaomi 2201117tl',
            '2201117ti' => 'xiaomi=xiaomi 2201117ti',
            '2201117tg' => 'xiaomi=xiaomi 2201117tg',
            '21121119sc' => 'xiaomi=xiaomi 21121119sc',
            '21091116ac' => 'xiaomi=xiaomi 21091116ac',
            '21081111rg' => 'xiaomi=xiaomi 21081111rg',
            '2201116sg' => 'xiaomi=xiaomi 2201116sg',
            '2109119dg' => 'xiaomi=xiaomi 2109119dg',
            '2107113sg' => 'xiaomi=xiaomi 2107113sg',
            '2201117sy' => 'xiaomi=xiaomi 2201117sy',
            '21061119dg' => 'xiaomi=xiaomi 21061119dg',
            '21061119ag' => 'xiaomi=xiaomi 21061119ag',
            'm2003j15sc' => 'xiaomi=xiaomi m2003j15sc',
            '2210132g' => 'xiaomi=xiaomi 2210132g',
            '22081212ug' => 'xiaomi=xiaomi 22081212ug',
            'm2010j19cg' => 'xiaomi=xiaomi m2010j19cg',
            '21051182g' => 'xiaomi=xiaomi 21051182g',
            '22011119uy' => 'xiaomi=xiaomi 22011119uy',
            '220733sg' => 'xiaomi=xiaomi 220733sg',
            'mi note 10 lite' => 'xiaomi=xiaomi mi note 10 lite',
            'mi note 10 pro' => 'xiaomi=xiaomi mi note 10 pro',
            '22101316ug' => 'xiaomi=xiaomi 22101316ug',
            '23028rn4dg' => 'xiaomi=xiaomi 23028rn4dg',
            '23021raa2y' => 'xiaomi=xiaomi 23021raa2y',
            '22126rn91y' => 'xiaomi=xiaomi 22126rn91y',
            '2211133g' => 'xiaomi=xiaomi 2211133g',
            '2112123ag' => 'xiaomi=xiaomi 2112123ag',
            '21091116ug' => 'xiaomi=xiaomi 21091116ug',
            'poco f2 pro' => 'xiaomi=xiaomi pocophone f2 pro',
            'm2002j9g' => 'xiaomi=xiaomi m2002j9g',
            '2209116ag' => 'xiaomi=xiaomi 2209116ag',
            'm2004j19c' => 'xiaomi=xiaomi m2004j19c',
            'm2012k11g' => 'xiaomi=xiaomi m2012k11g',
            'm2007j17g' => 'xiaomi=xiaomi m2007j17g',
            'm2006c3mng' => 'xiaomi=xiaomi m2006c3mng',
            '2201117pg' => 'xiaomi=xiaomi 2201117pg',
            '22071212ag' => 'xiaomi=xiaomi 22071212ag',
            '2201116pg' => 'xiaomi=xiaomi 2201116pg',
            // ZTE
            'zte a2121e' => 'zte=zte a2121e',
            'zte blade 10 vita' => 'zte=zte blade 10 vita',
            'zte blade a3 2020' => 'zte=zte blade a3 2020',
            'zte 8045' => 'zte=zte 8045',
            'zte a2322g' => 'zte=zte a2322g',
            // Samsung
            'sm-a405fn' => 'samsung=samsung sm-a405fn',
            'sm-a415f' => 'samsung=samsung sm-a415f',
            'sm-a505fn' => 'samsung=samsung sm-a505fn',
            'sm-a515f' => 'samsung=samsung sm-a515f',
            'sm-g960f' => 'samsung=samsung sm-g960f',
            'sm-g965f' => 'samsung=samsung sm-g965f',
            'sm-s901b' => 'samsung=samsung sm-s901b',
            'sm-s901u' => 'samsung=samsung sm-s901u',
            'sm-s901u1' => 'samsung=samsung sm-s901u1',
            'sm-s918b' => 'samsung=samsung sm-s918b',
            'sm-s908b' => 'samsung=samsung sm-s908b',
            'sm-s908u' => 'samsung=samsung sm-s908u',
            'sm-s908u1' => 'samsung=samsung sm-s908u1',
            'sm-g780g' => 'samsung=samsung sm-g780g',
            'sm-a536b' => 'samsung=samsung sm-a536b',
            'sm-a528b' => 'samsung=samsung sm-a528b',
            'sm-a135f' => 'samsung=samsung sm-a135f',
            'sm-t510' => 'samsung=samsung sm-t510',
            'sm-t970' => 'samsung=samsung sm-t970',
            'sm-t580' => 'samsung=samsung sm-t580',
            'sm-t550' => 'samsung=samsung sm-t550',
            'sm-t813' => 'samsung=samsung sm-t813',
            'sm-a336b' => 'samsung=samsung sm-a336b',
            'sm-a336e' => 'samsung=samsung sm-a336e',
            'sm-a127f' => 'samsung=samsung sm-a127f',
            'sm-g525f' => 'samsung=samsung sm-g525f',
            'sm-a226br' => 'samsung=samsung sm-a226br',
            'sm-a226b' => 'samsung=samsung sm-a226b',
            'sm-a546b' => 'samsung=samsung sm-a546b',
            'sm-t220' => 'samsung=samsung sm-t220',
            'sm-t225' => 'samsung=samsung sm-t225',
            'sm-t225n' => 'samsung=samsung sm-t225n',
            'sm-a326b' => 'samsung=samsung sm-a326b',
            'sm-a326u' => 'samsung=samsung sm-a326u',
            'sm-a725f' => 'samsung=samsung sm-a725f',
            'sm-g990b' => 'samsung=samsung sm-g990b',
            'sm-g990b2' => 'samsung=samsung sm-g990b2',
            'sm-g990e' => 'samsung=samsung sm-g990e',
            'sm-a125f' => 'samsung=samsung sm-a125f',
            'sm-p619' => 'samsung=samsung sm-p619',
            'sm-p613' => 'samsung=samsung sm-p613',
            'sm-a136b' => 'samsung=samsung sm-a136b',
            'sm-g736b' => 'samsung=samsung sm-g736b',
            'sm-f711b' => 'samsung=samsung sm-f711b',
            'sm-f711u' => 'samsung=samsung sm-f711u',
            'sm-a225f' => 'samsung=samsung sm-a225f',
            'sm-a137f' => 'samsung=samsung sm-a137f',
            'sm-a146p' => 'samsung=samsung sm-a146p',
            'sm-a236b' => 'samsung=samsung sm-a236b',
            'sm-a525f' => 'samsung=samsung sm-a525f',
            'sm-f731b' => 'samsung=samsung sm-f731b',
            'sm-f926b' => 'samsung=samsung sm-f926b',
            'sm-s906b' => 'samsung=samsung sm-s906b',
            'sm-s911b' => 'samsung=samsung sm-s911b',
            'sm-s916b' => 'samsung=samsung sm-s916b',
            'sm-x706b' => 'samsung=samsung sm-x706b',
            'sm-x700' => 'samsung=samsung sm-x700',
            'sm-x200' => 'samsung=samsung sm-x200',
            'sm-x205' => 'samsung=samsung sm-x205',
            'sm-t976b' => 'samsung=samsung sm-t976b',
            'sm-t870' => 'samsung=samsung sm-t870',
            'sm-t875' => 'samsung=samsung sm-t875',
            'sm-t575' => 'samsung=samsung sm-t575',
            'sm-m325fv' => 'samsung=samsung sm-m325fv',
            'sm-m325f' => 'samsung=samsung sm-m325f',
            'sm-m236b' => 'samsung=samsung sm-m236b',
            'sm-g985f' => 'samsung=samsung sm-g985f',
            'sm-g770f' => 'samsung=samsung sm-g770f',
            'sm-f721b' => 'samsung=samsung sm-f721b',
            'sm-a526b' => 'samsung=samsung sm-a526b',
            'sm-a526u' => 'samsung=samsung sm-a526u',
            'sm-a235f' => 'samsung=samsung sm-a235f',
            'sm-a047f' => 'samsung=samsung sm-a047f',
            'sm-a325f' => 'samsung=samsung sm-a325f',
            'sm-m536b' => 'samsung=samsung sm-m536b',
            'sm-m526br' => 'samsung=samsung sm-m526br',
            'sm-m127f' => 'samsung=samsung sm-m127f',
            'sm-f936b' => 'samsung=samsung sm-f936b',
            'sm-a145r' => 'samsung=samsung sm-a145r',
            'sm-a145p' => 'samsung=samsung sm-a145p',
            'sm-a045f' => 'samsung=samsung sm-a045f',
            'sm-a037g' => 'samsung=samsung sm-a037g',
            'sm-a037f' => 'samsung=samsung sm-a037f',
            'sm-a426b' => 'samsung=samsung sm-a426b',
            'sm-a042f' => 'samsung=samsung sm-a042f',
            'sm-a025g' => 'samsung=samsung sm-a025g',
            'sm-a025f' => 'samsung=samsung sm-a025f',
            'sm-m135f' => 'samsung=samsung sm-m135f',
            'sm-a035f' => 'samsung=samsung sm-a035f',
            'sm-a035m' => 'samsung=samsung sm-a035m',
            'sm-a035g' => 'samsung=samsung sm-a035g',
            'sm-m225fv' => 'samsung=samsung sm-m225fv',
            'sm-a022g' => 'samsung=samsung sm-a022g',
            'sm-a022f' => 'samsung=samsung sm-a022f',
            'sm-m336b' => 'samsung=samsung sm-m336b',
            'sm-m336bu' => 'samsung=samsung sm-m336bu',
            'sm-m115f' => 'samsung=samsung sm-m115f',
            // Huawei
            'mar-lx1b' => 'huawei=huawei mar-lx1b',
            'lya-l09' => 'huawei=huawei lya-l09',
            'vog-l29' => 'huawei=huawei vog-l29',
            'nen-lx1' => 'huawei=huawei nen-lx1',
            'ppa-lx1' => 'huawei=huawei ppa-lx1',
            'jad-lx9' => 'huawei=huawei jad-lx9',
            'rea-nx9' => 'huawei=huawei rea-nx9',
            'ntn-lx1' => 'huawei=huawei ntn-lx1',
            'lge-nx9' => 'huawei=huawei lge-nx9',
            'dby-w09' => 'huawei=huawei dby-w09',
            'nam-lx9' => 'huawei=huawei nam-lx9',
            'stk-lx1' => 'huawei=huawei stk-lx1',
            'ppa-lx2' => 'huawei=huawei ppa-lx2',
            // Lenovo
            'lenovo tb-x304f' => 'lenovo=lenovo tb-x304f',
            'lenovo yt-j706f' => 'lenovo=lenovo yt-j706f',
            'x1030x' => 'lenovo=lenovo x1030x',
            'lenovo tb-x306x' => 'lenovo=lenovo tb-x306x',
            'lenovo tb-x306xa' => 'lenovo=lenovo tb-x306xa',
            'lenovo tb-j616f' => 'lenovo=lenovo tb-j616f',
            'lenovo tb-j616x' => 'lenovo=lenovo tb-j616x',
            // Nokia
            'nokia g50' => 'nokia=nokia g50',
            'nokia g20' => 'nokia=nokia g20',
            'nokia x10' => 'nokia=nokia x10',
            'nokia x20' => 'nokia=nokia x20',
            'nokia g22' => 'nokia=nokia g22',
            'nokia c12' => 'nokia=nokia c12',
            'nokia 2.3' => 'nokia=nokia 2.3',
            // Microsoft
            'surface duo' => 'microsoft=microsoft surface duo',
            // realme
            'rmx3085' => 'realme=realme rmx3085',
            'rmx3231' => 'realme=realme rmx3231',
            'rmx3393' => 'realme=realme rmx3393',
            'rmx3370' => 'realme=realme rmx3370',
            'rmx3241' => 'realme=realme rmx3241',
            'rmx3501' => 'realme=realme rmx3501',
            'rmx3151' => 'realme=realme rmx3151',
            'rmx3263' => 'realme=realme rmx3263',
            'rmx3201' => 'realme=realme rmx3201',
            // Motorola
            'moto g200 5g' => 'motorola=motorola moto g200 5g',
            'motorola razr 5g' => 'motorola=motorola razr 5g',
            'moto g42' => 'motorola=motorola moto g42',
            'moto g(60)' => 'motorola=motorola moto g60',
            'moto g(50)' => 'motorola=motorola moto g50',
            'moto g(30)' => 'motorola=motorola moto g30',
            'moto g pro' => 'motorola=motorola moto g pro',
            'moto e32(s)' => 'motorola=motorola moto e32s',
            'moto e30' => 'motorola=motorola moto e30',
            'moto e20' => 'motorola=motorola moto e20',
            'moto e40' => 'motorola=motorola moto e40',
            // Sony
            'xq-cc54' => 'sony=sony xq-cc54',
            'xq-bq52' => 'sony=sony xq-bq52',
            'xq-be52' => 'sony=sony xq-be52',
            // Vivo
            'v2109' => 'vivo=vivo v2109',
            // Fairphone
            'fp4' => 'fairphone=fairphone fp4',
            'fp3' => 'fairphone=fairphone fp3',
            // Oukitel
            'wp16' => 'oukitel=oukitel wp16',
            // Ulefone
            'note 6p' => 'ulefone=ulefone note 6p',
            'armor 11t 5g' => 'ulefone=ulefone armor 11t 5g',
            // Doogee
            'n40pro' => 'doogee=doogee n40 pro',
            's88pro' => 'doogee=doogee s88 pro',
            // shiftphones
            'shift6mq' => 'shift=shift shift6mq',
            default => null,
        };
    }
}
