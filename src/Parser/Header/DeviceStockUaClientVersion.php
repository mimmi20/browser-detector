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
use UaParser\ClientVersionInterface;

use function preg_match;

final class DeviceStockUaClientVersion implements ClientVersionInterface
{
    /** @throws void */
    #[Override]
    public function hasClientVersion(string $value): bool
    {
        return (bool) preg_match('/(?:opera mini|iemobile)\/[\d\.]+/i', $value);
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getClientVersion(string $value, string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/(?:opera mini|iemobile)\/(?P<version>[\d\.]+)/i', $value, $matches)) {
            return $matches['version'];
        }

        return null;
    }
}
