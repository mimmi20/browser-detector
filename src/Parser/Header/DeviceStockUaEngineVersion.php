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

use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\VersionInterface;
use Override;
use UaParser\EngineVersionInterface;

use function preg_match;
use function str_replace;

final class DeviceStockUaEngineVersion implements EngineVersionInterface
{
    use SetVersionTrait;

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
    public function getEngineVersion(string $value, string | null $code = null): VersionInterface
    {
        $matches = [];

        if (
            preg_match('/(?:trident|presto|webkit|gecko)[\/ ](?P<version>[\d._]+)/i', $value, $matches)
        ) {
            return $this->setVersion(str_replace('_', '.', $matches['version']));
        }

        return new ForcedNullVersion();
    }
}
