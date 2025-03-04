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

namespace BrowserDetector\Version\Helper;

use BrowserDetector\Version\VersionInterface;
use UnexpectedValueException;

interface SafariInterface
{
    /**
     * maps different Safari Versions to a normalized format
     *
     * @throws UnexpectedValueException
     */
    public function mapSafariVersion(VersionInterface $detectedVersion): string | null;
}
