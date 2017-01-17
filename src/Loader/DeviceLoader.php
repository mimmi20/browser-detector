<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <mimmi20@live.de>
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
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Loader;

use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Device detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DeviceLoader implements LoaderInterface
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
     * initializes cache
     */
    private function init()
    {
        $cacheInitializedId = hash('sha512', 'device-cache is initialized');
        $cacheInitialized   = $this->cache->getItem($cacheInitializedId);

        if (!$cacheInitialized->isHit() || !$cacheInitialized->get()) {
            $this->initCache($cacheInitialized);
        }
    }

    /**
     * @param string $deviceKey
     *
     * @return bool
     */
    public function has($deviceKey)
    {
        $this->init();

        $cacheItem = $this->cache->getItem(hash('sha512', 'device-cache-' . $deviceKey));

        return $cacheItem->isHit();
    }

    /**
     * @param string $deviceKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     * @return \UaResult\Device\DeviceInterface
     */
    public function load($deviceKey, $useragent = '')
    {
        $this->init();

        if (!$this->has($deviceKey)) {
            throw new NotFoundException('the device with key "' . $deviceKey . '" was not found');
        }

        $cacheItem = $this->cache->getItem(hash('sha512', 'device-cache-' . $deviceKey));

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
            $platform = (new PlatformLoader($this->cache))->load($platformKey, $useragent);
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
