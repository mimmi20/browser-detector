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
use UaParser\ClientVersionInterface;

use function array_first;

final class SecChUaClientVersion implements ClientVersionInterface
{
    use SetVersionTrait;
    use SortTrait;

    /** @throws void */
    #[Override]
    public function hasClientVersion(string $value): bool
    {
        return $this->sort($value) !== [];
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getClientVersion(string $value, string | null $code = null): VersionInterface
    {
        $list = $this->sort($value);

        $version = array_first($list);

        if ($version === null) {
            return new ForcedNullVersion();
        }

        return $this->setVersion($version);
    }
}
