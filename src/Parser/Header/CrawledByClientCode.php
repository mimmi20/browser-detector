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
use UaParser\ClientCodeInterface;

use function array_key_first;
use function mb_strtolower;
use function str_contains;

final class CrawledByClientCode implements ClientCodeInterface
{
    use SortTrait;

    /** @throws void */
    #[Override]
    public function hasClientCode(string $value): bool
    {
        $list = $this->sort($value);

        if ($list === null || $list === []) {
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
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getClientCode(string $value): string | null
    {
        return null;
    }
}
