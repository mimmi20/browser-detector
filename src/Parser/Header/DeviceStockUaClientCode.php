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
use UaParser\ClientCodeInterface;

use function mb_strtolower;
use function preg_match;

final class DeviceStockUaClientCode implements ClientCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasClientCode(string $value): bool
    {
        return (bool) preg_match('/opera mini|iemobile/i', $value);
    }

    /** @throws void */
    #[Override]
    public function getClientCode(string $value): string | null
    {
        $matches = [];

        if (preg_match('/(?P<client>opera mini|iemobile)/i', $value, $matches)) {
            return mb_strtolower($matches['client']);
        }

        return null;
    }
}
