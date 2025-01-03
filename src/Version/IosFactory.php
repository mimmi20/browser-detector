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

use IosBuild\IosBuild;
use Override;

final class IosFactory implements IosFactoryInterface
{
    /** @throws void */
    #[Override]
    public function __invoke(): Ios
    {
        return new Ios(
            versionBuilder: new VersionBuilder(),
            iosBuild: new IosBuild(),
        );
    }
}
