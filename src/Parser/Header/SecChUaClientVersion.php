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

use function reset;

final class SecChUaClientVersion implements ClientVersionInterface
{
    use SortTrait;

    /** @throws void */
    #[Override]
    public function hasClientVersion(string $value): bool
    {
        return $this->sort($value) !== [];
    }

    /**
     * @return non-empty-string|null
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getClientVersion(string $value, string | null $code = null): string | null
    {
        $list = $this->sort($value);

        if ($list === []) {
            return null;
        }

        $version = reset($list);

        if ($version === '') {
            return null;
        }

        return $version;
    }
}
