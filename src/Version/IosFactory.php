<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Version;

use IosBuild\IosBuild;

final class IosFactory implements IosFactoryInterface
{
    /**
     * @return \BrowserDetector\Version\Ios
     */
    public function __invoke(): Ios
    {
        return new Ios(
            new VersionFactory(),
            new IosBuild()
        );
    }
}
