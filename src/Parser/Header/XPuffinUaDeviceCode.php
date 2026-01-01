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

namespace BrowserDetector\Parser\Header;

use Override;
use UaParser\DeviceCodeInterface;

use function mb_strtolower;
use function preg_match;

final class XPuffinUaDeviceCode implements DeviceCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        return (bool) preg_match('/android|iphone os/i', $value);
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        $matches = [];

        if (preg_match('/(?:android|iphone os)\/(?P<device>[^\/]+)/i', $value, $matches)) {
            $code = mb_strtolower($matches['device']);

            return match ($code) {
                'ipad4,1' => 'apple=apple ipad 4,1',
                'iphone7,1' => 'apple=apple iphone 7,1',
                'iphone6,1' => 'apple=apple iphone 6,1',
                'iphone 3gs' => 'apple=apple iphone 2,1',
                'd6503' => 'sony=sony d6503',
                'sm-g900f' => 'samsung=samsung sm-g900f',
                'samsung-sm-n910a' => 'samsung=samsung sm-n910a',
                'sm-t310' => 'samsung=samsung sm-t310',
                'nexus 10' => 'google=google nexus 10',
                'bq edison' => 'bq=bq edison',
                'lenovoa3300-hv' => 'lenovo=lenovo a3300-hv',
                default => null,
            };
        }

        return null;
    }
}
