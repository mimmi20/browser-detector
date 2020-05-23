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

use MacosBuild\MacosBuild;

final class MacosFactory implements MacosFactoryInterface
{
    /**
     * @return \BrowserDetector\Version\Macos
     */
    public function __invoke(): Macos
    {
        return new Macos(
            new VersionFactory(),
            new MacosBuild()
        );
    }
}
