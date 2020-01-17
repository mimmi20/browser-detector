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
namespace BrowserDetector\Helper;

interface MobileDeviceInterface
{
    /**
     * Returns true if the give $useragent is from a mobile device
     *
     * @param string $useragent
     *
     * @return bool
     */
    public function isMobile(string $useragent): bool;
}
