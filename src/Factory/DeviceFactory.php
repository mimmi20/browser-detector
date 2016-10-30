<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Factory;

use BrowserDetector\Helper\Desktop;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Tv as TvHelper;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use UaHelper\Utils;

/**
 * Device detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DeviceFactory implements FactoryInterface
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function detect($useragent)
    {
        $utils = new Utils();
        $utils->setUserAgent($useragent);

        if (!$utils->checkIfContains(['freebsd', 'raspbian'], true)
            && $utils->checkIfContains(['darwin', 'cfnetwork'], true)
        ) {
            return (new Device\DarwinFactory())->detect($useragent);
        }

        if ((new MobileDevice($useragent))->isMobile()) {
            return (new Device\MobileFactory())->detect($useragent);
        }

        if ((new TvHelper($useragent))->isTvDevice()) {
            return (new Device\TvFactory())->detect($useragent);
        }

        if ((new Desktop($useragent))->isDesktopDevice()) {
            return (new Device\DesktopFactory())->detect($useragent);
        }

        return self::get('unknown', $useragent);
    }

    /**
     * @param string $deviceKey
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function get($deviceKey, $useragent)
    {
        static $devices = null;

        if (null === $devices) {
            $devices = json_decode(file_get_contents(__DIR__ . '/../../data/devices.json'));
        }

        if (!isset($devices->$deviceKey)) {
            return new \UaResult\Device\Device('unknown', 'unknown', 'unknown', 'unknown', new Version(0));
        }

        if (!isset($devices->$deviceKey->version->class)) {
            $version = null;
        } else {
            $engineVersionClass = $devices->$deviceKey->version->class;

            if (!is_string($engineVersionClass)) {
                $version = new Version(0);
            } elseif ('VersionFactory' === $engineVersionClass) {
                $version = VersionFactory::detectVersion($useragent, $devices->$deviceKey->version->search);
            } else {
                /** @var \BrowserDetector\Version\VersionFactoryInterface $engineVersionClass */
                $version = $engineVersionClass::detectVersion($useragent);
            }
        }

        $typeClass   = '\\UaDeviceType\\' . $devices->$deviceKey->type;
        $platformKey = $devices->$deviceKey->platform;

        if (null === $platformKey) {
            $platform = null;
        } else {
            $platform = (new PlatformFactory())->get($platformKey, $useragent);
        }

        return new \UaResult\Device\Device(
            $devices->$deviceKey->codename,
            $devices->$deviceKey->marketingName,
            $devices->$deviceKey->manufacturer,
            $devices->$deviceKey->brand,
            $version,
            $platform,
            new $typeClass(),
            $devices->$deviceKey->pointingMethod,
            (int) $devices->$deviceKey->resolutionWidth,
            (int) $devices->$deviceKey->resolutionHeight,
            (bool) $devices->$deviceKey->dualOrientation,
            (int) $devices->$deviceKey->colors,
            (bool) $devices->$deviceKey->smsSupport,
            (bool) $devices->$deviceKey->nfcSupport,
            (bool) $devices->$deviceKey->hasQwertyKeyboard
        );
    }
}
