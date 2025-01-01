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

namespace BrowserDetector\Header;

use Override;

use function in_array;
use function mb_strtolower;

final class XUcbrowserPhone implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    #[Override]
    public function hasDeviceCode(): bool
    {
        return !in_array(mb_strtolower($this->value), ['maui browser', 'sunmicro'], true);
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(): string | null
    {
        $code = mb_strtolower($this->value);

        return match ($code) {
            'nokia701' => 'nokia=nokia 701',
            'nokiac3-01' => 'nokia=nokia c3-01',
            'nokia305' => 'nokia=nokia 305',
            'gt-s5233s' => 'samsung=samsung gt-s5233s',
            'sonyericssonj108i' => 'sony=sonyericsson j108i',
            default => null,
        };
    }

    /** @throws void */
    #[Override]
    public function hasClientCode(): bool
    {
        return $this->value === 'maui browser';
    }

    /** @throws void */
    #[Override]
    public function getClientCode(): string | null
    {
        return $this->value === 'maui browser' ? 'maui browser' : null;
    }
}
