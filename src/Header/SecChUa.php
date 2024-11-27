<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Header;

use function array_key_first;
use function current;
use function key;
use function mb_strtolower;
use function reset;
use function str_contains;

final class SecChUa implements HeaderInterface
{
    use HeaderTrait;
    use SortTrait;

    /** @throws void */
    public function hasClientCode(): bool
    {
        $list = $this->sort();

        if ($list === null || $list === []) {
            return false;
        }

        $key  = array_key_first($list);
        $code = mb_strtolower($key);

        return !str_contains($code, 'brand') && $code !== 'chromium';
    }

    /** @throws void */
    public function getClientCode(): string | null
    {
        $list = $this->sort();

        if ($list === null || $list === []) {
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
            default => $code,
        };
    }

    /** @throws void */
    public function hasClientVersion(): bool
    {
        $list = $this->sort();

        if ($list === null || $list === []) {
            return false;
        }

        $key  = array_key_first($list);
        $code = mb_strtolower($key);

        return !str_contains($code, 'brand') && $code !== 'chromium';
    }

    /** @throws void */
    public function getClientVersion(string | null $code = null): string | null
    {
        $list = $this->sort();

        if ($list === null || $list === []) {
            return null;
        }

        reset($list);
        $version = current($list);
        $key     = key($list);

        $code = mb_strtolower($key);

        if (str_contains($code, 'brand')) {
            return null;
        }

        return $version;
    }
}
