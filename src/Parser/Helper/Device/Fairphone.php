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
final class Fairphone implements DeviceInterface
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
            'fp4' => 'fairphone=fairphone fp4',
            'fp3' => 'fairphone=fairphone fp3',
            'fairphone fp5', 'fp5' => 'fairphone=fairphone fp5',
            'fp2' => 'fairphone=fairphone fp2',
            'fairphone 6', 'fp6' => 'fairphone=fairphone fp6',
            // other
            default => null,
        };
    }
}
