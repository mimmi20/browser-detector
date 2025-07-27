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

use function array_key_first;
use function current;
use function key;
use function mb_strtolower;
use function reset;
use function str_contains;

final class SecChUaClientVersion implements ClientVersionInterface
{
    use SortTrait;

    /** @throws void */
    #[Override]
    public function hasClientVersion(string $value): bool
    {
        $list = $this->sort($value);

        if ($list === []) {
            return false;
        }

        $key  = array_key_first($list);
        $code = mb_strtolower($key);

        return !str_contains($code, 'brand') && $code !== 'chromium';
    }

    /**
     * @return non-empty-string|null
     *
     * @throws void
     */
    #[Override]
    public function getClientVersion(string $value, string | null $code = null): string | null
    {
        $list = $this->sort($value);

        if ($list === []) {
            return null;
        }

        reset($list);
        $version = current($list);
        $key     = key($list);

        $code = mb_strtolower($key);

        if (str_contains($code, 'brand') || $version === '') {
            return null;
        }

        return $version;
    }
}
