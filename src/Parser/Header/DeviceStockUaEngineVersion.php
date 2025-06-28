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
use UaParser\EngineVersionInterface;

use function preg_match;
use function str_replace;

final class DeviceStockUaEngineVersion implements EngineVersionInterface
{
    /** @throws void */
    #[Override]
    public function hasEngineVersion(string $value): bool
    {
        return (bool) preg_match('/(?:trident|presto|webkit|gecko)[\/ ]([\d._]+)/i', $value);
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getEngineVersion(string $value, string | null $code = null): string | null
    {
        $matches = [];

        if (
            preg_match('/(?:trident|presto|webkit|gecko)[\/ ](?P<version>[\d._]+)/i', $value, $matches)
        ) {
            return str_replace('_', '.', $matches['version']);
        }

        return null;
    }
}
