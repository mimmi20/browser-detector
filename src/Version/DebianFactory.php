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

final class DebianFactory implements DebianFactoryInterface
{
    /** @throws void */
    #[Override]
    public function __invoke(): Debian
    {
        return new Debian(
            versionBuilder: new VersionBuilder(),
        );
    }
}
