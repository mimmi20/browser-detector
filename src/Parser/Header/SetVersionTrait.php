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

namespace BrowserDetector\Parser\Header;

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionInterface;

trait SetVersionTrait
{
    /** @throws void */
    private function setVersion(string $version): VersionInterface
    {
        try {
            return (new VersionBuilder())->set($version);
        } catch (NotNumericException) {
            return new NullVersion();
        }
    }
}
