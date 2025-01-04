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

namespace BrowserDetector\Version;

use Override;

final class GeckoFactory implements GeckoFactoryInterface
{
    /** @throws void */
    #[Override]
    public function __invoke(): Gecko
    {
        return new Gecko(
            versionBuilder: new VersionBuilder(),
        );
    }
}
