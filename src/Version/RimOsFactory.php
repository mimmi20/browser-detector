<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use Psr\Log\LoggerInterface;

final class RimOsFactory implements RimOsFactoryInterface
{
    /** @throws void */
    public function __invoke(LoggerInterface $logger): RimOs
    {
        return new RimOs(
            logger: $logger,
            versionBuilder: new VersionBuilder($logger),
        );
    }
}
