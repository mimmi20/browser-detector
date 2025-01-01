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

namespace BrowserDetector\Header;

use function array_keys;
use function array_multisort;
use function mb_strlen;
use function mb_strtolower;
use function mb_substr;
use function preg_match;

use const SORT_ASC;
use const SORT_DESC;
use const SORT_NATURAL;
use const SORT_NUMERIC;

trait SortTrait
{
    /**
     * @return non-empty-array<string, string>|null
     *
     * @throws void
     */
    private function sort(): array | null
    {
        $reg             = '/^"(?P<brand>[^"]+)"; ?v="(?P<version>[^"]+)"(?:, )?/';
        $list            = [];
        $value           = $this->value;
        $fullVersionList = [];
        $nameList        = [];

        while (preg_match($reg, $value, $matches)) {
            $list[$matches['brand']] = $matches['version'];
            $value                   = mb_substr($value, mb_strlen($matches[0]));
        }

        if ($list === []) {
            return null;
        }

        foreach (array_keys($list) as $brand) {
            $code = mb_strtolower($brand);

            $fullVersionList[$brand] = match ($code) {
                'opera', 'google chrome', 'microsoft edge', 'yandex', 'yabrowser', 'huaweibrowser', 'atom', 'opera gx', 'avast secure browser', 'avastsecurebrowser', 'ccleaner browser', 'wavebrowser', 'android webview', 'brave', 'duckduckgo', 'samsung internet', 'norton secure browser', 'norton private browser', 'headlesschrome', 'vivaldi', 'avg secure browser' => 2,
                'operamobile', 'microsoft edge webview2', 'yowser' => 3,
                'chromium' => 1,
                default => 0,
            };

            $nameList[$brand] = $code;
        }

        array_multisort(
            $fullVersionList,
            SORT_DESC,
            SORT_NUMERIC,
            $nameList,
            SORT_ASC,
            SORT_NATURAL,
            $list,
        );

        return $list;
    }
}
