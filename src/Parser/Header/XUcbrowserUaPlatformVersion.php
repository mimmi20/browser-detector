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
use UaParser\PlatformVersionInterface;

use function preg_match;
use function str_replace;

final class XUcbrowserUaPlatformVersion implements PlatformVersionInterface
{
    /** @throws void */
    #[Override]
    public function hasPlatformVersion(string $value): bool
    {
        return (bool) preg_match('/ov\((?:(wds|android) )?(?P<version>[\d_.]+)\);/i', $value);
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformVersion(string $value, string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/ov\((?:(wds|android) )?(?P<version>[\d_.]+)\);/i', $value, $matches)) {
            return str_replace('_', '.', $matches['version']);
        }

        return null;
    }
}
