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

final class SecChUaClientCode implements ClientCodeInterface
{
    use SortTrait;

    /** @throws void */
    #[Override]
    public function hasClientCode(string $value): bool
    {
        return $this->sort($value) !== [];
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
            'whale' => 'whale browser',
            'oculus browser' => 'oculus-browser',
            'coccoc' => 'coc_coc_browser',
            'opera crypto' => 'opera-crypto',
            'gener8' => 'gener8-browser',
            'crowbrowser' => 'crow-browser',
            'vewd core' => 'vewd-core',
            'edge side panel' => 'edge-side-panel',
            'headlessedg' => 'headless-edge',
            'wavebox' => 'wavebox-browser',
            'total browser' => 'total-browser',
            'version' => 'safari',
            default => $code,
        };
    }
}
