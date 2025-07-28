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

final class SecChUaClientCode implements ClientCodeInterface
{
    use SortTrait;

    /** @throws void */
    #[Override]
    public function hasClientCode(string $value): bool
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
    public function getClientCode(string $value): string | null
    {
        $list = $this->sort($value);

        if ($list === []) {
            return null;
        }

        $key  = array_key_first($list);
        $code = mb_strtolower($key);

        if (str_contains($code, 'brand')) {
            return null;
        }

        return match ($code) {
            'operamobile' => 'opera mobile',
            'huaweibrowser' => 'huawei-browser',
            'yandex' => 'yabrowser',
            'microsoft edge' => 'edge mobile',
            'google chrome' => 'chrome',
            'avastsecurebrowser' => 'avast secure browser',
            'wavebrowser' => 'wave-browser',
            'duckduckgo' => 'duckduck app',
            'samsung internet' => 'samsungbrowser',
            'norton secure browser', 'norton private browser' => 'norton-secure-browser',
            'microsoft edge webview2' => 'edge webview',
            'headlesschrome' => 'headless-chrome',
            'brave browser' => 'brave',
            'avira secure browser' => 'avira-secure-browser',
            default => $code,
        };
    }
}
