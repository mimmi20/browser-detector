<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Version\Helper;

use BrowserDetector\Version\VersionInterface;

interface SafariInterface
{
    /**
     * maps different Safari Versions to a normalized format
     *
     * @param VersionInterface $detectedVersion
     *
     * @throws \UnexpectedValueException
     *
     * @return string|null
     */
    public function mapSafariVersion(VersionInterface $detectedVersion): ?string;
}
