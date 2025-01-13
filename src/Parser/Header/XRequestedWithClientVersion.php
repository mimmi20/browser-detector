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

final class XRequestedWithClientVersion implements ClientVersionInterface
{
    /** @throws void */
    #[Override]
    public function hasClientVersion(string $value): bool
    {
        $match = preg_match('/xmlhttprequest|fake\./i', $value);

        return $match === 0;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getClientVersion(string $value, string | null $code = null): string | null
    {
        return null;
    }
}
