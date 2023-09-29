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
            // Asus
            'p024' => 'asus=asus p024',
            'asus_x00dd' => 'asus=asus x00dd',
            // Google
            'nexus 7' => 'google=google nexus 7',
            'pixel 7 pro' => 'google=google pixel 7 pro',
            // OnePlus
            'ac2003' => 'oneplus=oneplus ac2003',
            'in2023' => 'oneplus=oneplus in2023',
            // Oppo
            'cph2065' => 'oppo=oppo cph2065',
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
            // ZTE
            'zte a2121e' => 'zte=zte a2121e',
            'zte blade 10 vita' => 'zte=zte blade 10 vita',
            'zte blade a3 2020' => 'zte=zte blade a3 2020',
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
            // Huawei
            'mar-lx1b' => 'huawei=huawei mar-lx1b',
            'lya-l09' => 'huawei=huawei lya-l09',
            'vog-l29' => 'huawei=huawei vog-l29',
            default => null,
        };
    }
}
