<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Matcher\Device;

/**
 * interface for all devices to detect
 *
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
interface DeviceHasSpecificPlatformInterface
{
    /**
     * returns a specific Operating System
     *
     * @return \UaResult\Os\OsInterface|null
     */
    public function detectOs();
}
