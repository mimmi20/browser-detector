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

use function current;
use function key;
use function mb_strtolower;
use function reset;

final class SecChUa implements HeaderInterface
{
    use HeaderTrait;
    use SortTrait;

    /** @throws void */
    public function hasClientCode(): bool
    {
        return true;
    }

    /** @throws void */
    public function getClientCode(): string | null
    {
        $list = $this->sort();

        if ($list === null || $list === []) {
            return null;
        }

        $code    = reset($list);
        $version = current($list);
        $key     = key($list);

        if ($code === false || $version === false || $key === null) {
            return null;
        }

        $code = mb_strtolower($key);

        if ($code === 'chromium') {
            return null;
        }

        return match ($code) {
            'operamobile' => 'opera mobile',
            'huaweibrowser' => 'huawei-browser',
            'yandex' => 'yabrowser',
            'microsoft edge' => 'edge mobile',
            'google chrome' => 'chrome',
            'chromium', 'opera', 'atom', 'opera gx', 'avast secure browser', 'ccleaner browser' => $code,
            default => null,
        };
    }

    /** @throws void */
    public function hasClientVersion(): bool
    {
        return true;
    }

    /** @throws void */
    public function getClientVersion(): string | null
    {
        $list = $this->sort();

        if ($list === null || $list === []) {
            return null;
        }

        $code    = reset($list);
        $version = current($list);
        $key     = key($list);

        if ($code === false || $version === false || $key === null) {
            return null;
        }

        $code = mb_strtolower($key);

        if ($code === 'chromium') {
            return null;
        }

        return $version;
    }
}
