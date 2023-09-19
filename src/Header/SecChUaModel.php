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

        if ($value === '') {
            return null;
        }

        $code = mb_strtolower($value);

        return match ($code) {
            // LG
            'lm-g710' => 'lg=lg lm-g710',
            // Acer
            'a100' => 'acer=acer a100',
            'a1-734' => 'acer=acer a1-734',
            'b3-a32' => 'acer=acer b3-a32',
            'a3-a40' => 'acer=acer a3-a40',
            'b1-7a0' => 'acer=acer b1-7a0',
            'b1-860a' => 'acer=acer b1-860a',
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
            // OnePlus + Oppo
            'ac2003' => 'oneplus=oneplus ac2003',
            'cph2065' => 'oppo=oppo cph2065',
            // Xiaomi
            'redmi note 9 pro' => 'xiaomi=xiaomi redmi note 9 pro',
            default => null,
        };
    }
}
