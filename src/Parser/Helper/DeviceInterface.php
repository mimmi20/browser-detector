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

namespace BrowserDetector\Parser\Helper;

interface DeviceInterface
{
    /**
     * @return non-empty-string|null
     *
     * @throws void
     */
    public function getDeviceCode(string $code): string | null;
}
