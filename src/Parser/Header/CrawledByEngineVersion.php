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

namespace BrowserDetector\Parser\Header;

use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\VersionInterface;
use Override;
use UaData\EngineInterface;
use UaParser\ClientVersionInterface;
use UaParser\EngineVersionInterface;

final class CrawledByEngineVersion implements EngineVersionInterface
{
    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function hasEngineVersion(string $value): bool
    {
        return true;
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getEngineVersionWithEngine(string $value, EngineInterface $engine): VersionInterface
    {
        return new ForcedNullVersion();
    }
}
