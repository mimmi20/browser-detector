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

use IosBuild\IosBuild;
use Psr\Log\LoggerInterface;

final class IosFactory implements IosFactoryInterface
{
    /** @throws void */
    public function __invoke(LoggerInterface $logger): Ios
    {
        return new Ios(
            $logger,
            new VersionBuilder($logger),
            new IosBuild(),
        );
    }
}
