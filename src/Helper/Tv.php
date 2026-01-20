<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Helper;

use Override;

use function preg_match;

final class Tv implements TvInterface
{
    /**
     * Returns true if the give $useragent is from a tv device
     *
     * @throws void
     */
    #[Override]
    public function isTvDevice(string $useragent): bool
    {
        return 0 < preg_match(
            '/boxee|ce-html|dlink\.dsm380|googletv|hbbtv|idl-6651n|kdl40ex720|netrangemmh|loewe;|smart-?tv|sonydtv|viera|xbox|espial|aquosbrowser|gxt_dongle_3188|lf1v\d{3}|apple tv|mxl661l32|nettv|netbox|philipstv|crkey|metz(?!ler)|(?<!xia)omi\/|netcast|netgem|webos\.tv|lgwebostv|; ?lge? ?;|tv safari|andr[o0]id tv|g[o0][o0]gle tv|gsmart tv/i',
            $useragent,
        );
    }
}
