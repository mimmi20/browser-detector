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

namespace BrowserDetector\Parser\Header;

use Override;
use UaParser\DeviceCodeInterface;

use function in_array;
use function mb_strtolower;

final class XUcbrowserPhoneDeviceCode implements DeviceCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        return !in_array(mb_strtolower($value), ['maui browser', 'sunmicro'], true);
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        $code = mb_strtolower($value);

        return match ($code) {
            'nokia701' => 'nokia=nokia 701',
            'nokiac3-01' => 'nokia=nokia c3-01',
            'nokia305' => 'nokia=nokia 305',
            'gt-s5233s' => 'samsung=samsung gt-s5233s',
            'sonyericssonj108i' => 'sony=sonyericsson j108i',
            default => null,
        };
    }
}
