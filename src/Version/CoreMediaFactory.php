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
use Psr\Log\LoggerInterface;

final class CoreMediaFactory implements CoreMediaFactoryInterface
{
    /** @throws void */
    #[Override]
    public function __invoke(LoggerInterface $logger): CoreMedia
    {
        return new CoreMedia(
            logger: $logger,
            versionBuilder: new VersionBuilder($logger),
        );
    }
}
