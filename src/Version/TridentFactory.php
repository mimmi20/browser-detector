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

namespace BrowserDetector\Version;

use Override;

final class TridentFactory implements TridentFactoryInterface
{
    /** @throws void */
    #[Override]
    public function __invoke(): Trident
    {
        return new Trident(
            versionBuilder: new VersionBuilder(),
        );
    }
}
