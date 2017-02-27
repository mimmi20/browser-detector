<?php


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
