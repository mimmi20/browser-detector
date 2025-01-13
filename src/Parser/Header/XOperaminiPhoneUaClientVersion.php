<?php

/**
 * This file is part of the mimmi20/ua-generic-request package.
 *
 * Copyright (c) 2015-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Header;

use Override;
use UaParser\ClientVersionInterface;

use function preg_match;

final class XOperaminiPhoneUaClientVersion implements ClientVersionInterface
{
    /** @throws void */
    #[Override]
    public function hasClientVersion(string $value): bool
    {
        return (bool) preg_match('/opera mini\/[\d\.]+/i', $value);
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getClientVersion(string $value, string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/opera mini\/(?P<version>[\d\.]+)/i', $value, $matches)) {
            return $matches['version'];
        }

        return null;
    }
}
