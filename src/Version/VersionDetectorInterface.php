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

use UnexpectedValueException;

interface VersionDetectorInterface
{
    /**
     * detects the bit count by this browser from the given user agent
     *
     * @throws UnexpectedValueException
     */
    public function detectVersion(string $useragent): VersionInterface;
}
