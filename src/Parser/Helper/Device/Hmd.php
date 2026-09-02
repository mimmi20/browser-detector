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
final class Hmd implements DeviceInterface
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
        $specialDevices = [];

        return match ($code) {
            'hmd fusion' => 'hmd-global=hmd-global fusion',
            'hmd arc' => 'hmd-global=hmd-global arc',
            'hmd xr21' => 'hmd-global=hmd-global xr21',
            'hmd crest' => 'hmd-global=hmd-global crest',
            'hmd skyline' => 'hmd-global=hmd-global skyline',
            'n159v' => 'hmd-global=hmd-global n159v',
            'hmd vibe' => 'hmd-global=hmd-global vibe',
            'hmd pulse pro' => 'hmd-global=hmd-global pulse pro',
            'hmd pulse' => 'hmd-global=hmd-global pulse',
            'hmd vibe 5g' => 'hmd-global=hmd-global vibe 5g',
            'hmd t21' => 'hmd-global=hmd-global t21',
            'hmd aura' => 'hmd-global=hmd-global aura',
            'hmd crest max' => 'hmd-global=hmd-global crest max',
            'hmd key' => 'hmd-global=hmd-global key',
            'hmd aura2' => 'hmd-global=hmd-global aura 2',
            // other
            default => null,
        };
    }
}
