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

namespace BrowserDetector\Parser\Helper\Device;

use BrowserDetector\Parser\Helper\DeviceInterface;
use Override;

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
final class Acer implements DeviceInterface
{
    /**
     * @return non-empty-string|null
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[Override]
    public function getDeviceCode(string $code): string | null
    {
        return match ($code) {
            // Acer
            // has a conflict with blackview A100
            // 'a100' => 'acer=acer a100',
            'a1-734' => 'acer=acer a1-734',
            'a3-a40' => 'acer=acer a3-a40',
            'b1-7a0' => 'acer=acer b1-7a0',
            'b1-860a' => 'acer=acer b1-860a',
            'b3-a32' => 'acer=acer b3-a32',
            'b3-a40' => 'acer=acer b3-a40',
            'b3-a50fhd' => 'acer=acer b3-a50fhd',
            'b3-a40fhd' => 'acer=acer b3-a40fhd',
            'b3-a20' => 'acer=acer b3-a20',
            'b3-a42' => 'acer=acer b3-a42',
            'b3-a30' => 'acer=acer b3-a30',
            'b3-a20b' => 'acer=acer b3-a20b',
            'b3-a10' => 'acer=acer b3-a10',
            'b1-850' => 'acer=acer b1-850',
            'b1-830' => 'acer=acer b1-830',
            'b1-820' => 'acer=acer b1-820',
            'b1-810' => 'acer=acer b1-810',
            'b1-790' => 'acer=acer b1-790',
            'b1-780' => 'acer=acer b1-780',
            'm10-12_eea' => 'acer=acer m10-12_eea',
            'a10-21_eea' => 'acer=acer a10-21_eea',
            'a410_4g' => 'acer=acer a410_4g',
            'chromebook 14 (cb3-431)', 'chromebook 14 (cb3-431' => 'acer=acer chromebook 14',
            'm10-11' => 'acer=acer m10-11',
            'b3-a50' => 'acer=acer b3-a50',
            'acer chromebook 15 (cb3-532)', 'acer chromebook 15 (cb3-532' => 'acer=acer chromebook 15',
            'aceraitv' => 'acer=acer aitv',
            // other
            default => null,
        };
    }
}
