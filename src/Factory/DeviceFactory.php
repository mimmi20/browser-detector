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
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;

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
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface $cache
     */
    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function detect($useragent)
    {
        $s = new Stringy($useragent);

        if (!$s->containsAny(['freebsd', 'raspbian'], false)
            && $s->containsAny(['darwin', 'cfnetwork'], false)
        ) {
            return (new Device\DarwinFactory($this->cache))->detect($useragent);
        }

        if ((new MobileDevice($useragent))->isMobile()) {
            return (new Device\MobileFactory($this->cache))->detect($useragent);
        }

        if ((new TvHelper($useragent))->isTvDevice()) {
            return (new Device\TvFactory($this->cache))->detect($useragent);
        }

        if ((new Desktop($useragent))->isDesktopDevice()) {
            return (new Device\DesktopFactory($this->cache))->detect($useragent);
        }

        return $this->get('unknown', $useragent);
    }

    /**
     * @param string $deviceKey
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function get($deviceKey, $useragent)
    {
        $cacheInitializedId = hash('sha512', 'device-cache is initialized');
        $cacheInitialized   = $this->cache->getItem($cacheInitializedId);

        if (!$cacheInitialized->isHit() || !$cacheInitialized->get()) {
            $this->initCache($cacheInitialized);
        }

        $cacheItem = $this->cache->getItem(hash('sha512', 'device-cache-' . $deviceKey));

        if (!$cacheItem->isHit()) {
            return new \UaResult\Device\Device('unknown', 'unknown', 'unknown', 'unknown', new Version(0));
        }

        $device = $cacheItem->get();

        if (!isset($device->version->class)) {
            $version = null;
        } else {
            $deviceVersionClass = $device->version->class;

            if (!is_string($deviceVersionClass)) {
                $version = new Version(0);
            } elseif ('VersionFactory' === $deviceVersionClass) {
                $version = VersionFactory::detectVersion($useragent, $device->version->search);
            } else {
                /** @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
                $versionClass = new $deviceVersionClass($this->cache);
                $version      = $versionClass->detectVersion($useragent);
            }
        }

        $typeClass   = '\\UaDeviceType\\' . $device->type;
        $platformKey = $device->platform;

        if (null === $platformKey) {
            $platform = null;
        } else {
            $platform = (new PlatformFactory($this->cache))->get($platformKey, $useragent);
        }

        return new \UaResult\Device\Device(
            $device->codename,
            $device->marketingName,
            $device->manufacturer,
            $device->brand,
            $version,
            $platform,
            new $typeClass(),
            $device->pointingMethod,
            (int) $device->resolutionWidth,
            (int) $device->resolutionHeight,
            (bool) $device->dualOrientation,
            (int) $device->colors,
            (bool) $device->smsSupport,
            (bool) $device->nfcSupport,
            (bool) $device->hasQwertyKeyboard
        );
    }

    /**
     * @param \Psr\Cache\CacheItemInterface $cacheInitialized
     */
    private function initCache(CacheItemInterface $cacheInitialized)
    {
        static $devices = null;

        if (null === $devices) {
            $devices = json_decode(file_get_contents(__DIR__ . '/../../data/devices.json'));
        }

        foreach ($devices as $deviceKey => $deviceData) {
            $cacheItem = $this->cache->getItem(hash('sha512', 'device-cache-' . $deviceKey));
            $cacheItem->set($deviceData);

            $this->cache->save($cacheItem);
        }

        $cacheInitialized->set(true);
        $this->cache->save($cacheInitialized);
    }
}
