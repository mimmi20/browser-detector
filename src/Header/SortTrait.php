<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
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

use const SORT_DESC;
use const SORT_NUMERIC;

trait SortTrait
{
    /**
     * @return array<string, string>|null
     *
     * @throws void
     */
    private function sort(): array | null
    {
        $reg             = '/^"(?P<brand>[^"]+)"; ?v="(?P<version>[^"]+)"(?:, )?/';
        $list            = [];
        $value           = $this->value;
        $fullVersionList = [];

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
                'operamobile' => 3,
                'opera', 'google chrome', 'microsoft edge', 'yandex', 'huaweibrowser', 'atom', 'opera gx', 'avast secure browser', 'ccleaner browser' => 2,
                'chromium' => 1,
                default => 0,
            };
        }

        array_multisort($fullVersionList, SORT_DESC, SORT_NUMERIC, $list);

        return $list;
    }
}
