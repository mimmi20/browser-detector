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
use UaParser\ClientVersionInterface;

use function preg_match;

final class XUcbrowserUaClientVersion implements ClientVersionInterface
{
    use SetVersionTrait;

    /** @throws void */
    #[Override]
    public function hasClientVersion(string $value): bool
    {
        return (bool) preg_match('/pr\([^\/]+\/[\d.]+\);/', $value);
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getClientVersion(string $value, string | null $code = null): VersionInterface
    {
        $matches = [];

        if (preg_match('/pr\([^\/]+\/(?P<version>[\d.]+)\);/', $value, $matches)) {
            return $this->setVersion($matches['version']);
        }

        return new ForcedNullVersion();
    }
}
