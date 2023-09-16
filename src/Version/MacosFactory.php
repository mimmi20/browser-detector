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

namespace BrowserDetector\Version;

use MacosBuild\MacosBuild;
use Psr\Log\LoggerInterface;

final class MacosFactory implements MacosFactoryInterface
{
    /** @throws void */
    public function __invoke(LoggerInterface $logger): Macos
    {
        return new Macos(
            $logger,
            new VersionBuilder($logger),
            new MacosBuild(),
        );
    }
}
