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

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Yaml\Yaml;
use Psr\Log\LoggerInterface;

/**
 * detection class using regexes
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class RegexFactory implements FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var array|null
     */
    private $match = null;

    /**
     * @var string|null
     */
    private $useragent = null;

    /**
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface $cache
     * @param \Psr\Log\LoggerInterface          $logger
     */
    public function __construct(CacheItemPoolInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $useragent
     *
     * @return array|null|false
     */
    public function detect($useragent)
    {
        $regexes = $this->getRegexes();

        $this->match = null;
        $this->useragent = $useragent;

        if (!is_array($regexes)) {
            $this->logger->debug('no regexes are defined');
            return null;
        }

        foreach ($regexes as $regex) {
            $matches = [];

            if (preg_match($regex, $useragent, $matches)) {
                $this->logger->debug('a regex matched');
                $this->match = $matches;
                return true;
            }
        }

        $this->logger->debug('no regex did match');
        return false;
    }

    /**
     * @return \UaResult\Device\DeviceInterface|null
     */
    public function getDevice()
    {
        if (null === $this->useragent) {
            $this->logger->debug('no useragent was set');
            return null;
        }

        if (!array_key_exists('devicecode', $this->match)) {
            $this->logger->debug('device not detected via regexes');
            return null;
        }

        $deviceCode    = strtolower($this->match['devicecode']);
        $deviceFactory = new DeviceFactory($this->cache);

        if ('windows' === $deviceCode) {
            return $deviceFactory->get('windows desktop', $this->useragent);
        } elseif ('macintosh' === $deviceCode) {
            return $deviceFactory->get('macintosh', $this->useragent);
        }

        $device = $deviceFactory->get($deviceCode, $this->useragent);

        if (!in_array($device->getDeviceName(), ['unknown', null])) {
            $this->logger->debug('device detected via devicecode');
            return $device;
        }

        if (array_key_exists('manufacturercode', $this->match)) {
            $className = '\\BrowserDetector\\Factory\\Mobile\\' . ucfirst(strtolower($this->match['manufacturercode']));

            if (class_exists($className)) {
                $this->logger->debug('device detected via manufacturer');
                /** @var \BrowserDetector\Factory\FactoryInterface $factory */
                $factory = new $className($this->cache);
                return $factory->detect($this->useragent);
            }
        }

        if (array_key_exists('devicetype', $this->match)) {
            $className = '\\BrowserDetector\\Factory\\' . ucfirst(strtolower($this->match['devicetype']));

            if (class_exists($className)) {
                $this->logger->debug('device detected via device type (mobile or tv)');
                /** @var \BrowserDetector\Factory\FactoryInterface $factory */
                $factory = new $className($this->cache);
                return $factory->detect($this->useragent);
            }
        }

        return null;
    }

    /**
     * @return null
     */
    public function getPlatform()
    {
        if (null === $this->useragent) {
            $this->logger->debug('no useragent was set');
            return null;
        }

        if (!array_key_exists('osname', $this->match)) {
            $this->logger->debug('platform not detected via regexes');
            return null;
        }

        $platformCode = strtolower($this->match['osname']);

        if ('darwin' === $platformCode) {
            $darwinFactory = new Platform\DarwinFactory($this->cache);
            return $darwinFactory->detect($this->useragent);
        }

        $platformFactory = new DeviceFactory($this->cache);
        $platform = $platformFactory->get($platformCode, $this->useragent);

        if (!in_array($platform->getDeviceName(), ['unknown', null])) {
            return $platform;
        }

        return null;
    }

    /**
     * @return null
     */
    public function getBrowser()
    {
        if (null === $this->useragent) {
            $this->logger->debug('no useragent was set');
            return null;
        }

        if (!array_key_exists('browsername', $this->match)) {
            $this->logger->debug('browser not detected via regexes');
            return null;
        }

        $browserCode    = strtolower($this->match['browsername']);
        $browserFactory = new BrowserFactory($this->cache);
        $browser        = $browserFactory->get($browserCode, $this->useragent);

        if (!in_array($browser->getName(), ['unknown', null])) {
            return $browser;
        }

        return null;
    }

    /**
     * @return null
     */
    public function getEngine()
    {
        if (null === $this->useragent) {
            $this->logger->debug('no useragent was set');
            return null;
        }

        if (!array_key_exists('enginename', $this->match)) {
            $this->logger->debug('engine not detected via regexes');
            return null;
        }

        $engineCode    = strtolower($this->match['enginename']);
        $engineFactory = new EngineFactory($this->cache);

        if ('cfnetwork' === $engineCode) {
            return $engineFactory->get('webkit', $this->useragent);
        }

        if (in_array($engineCode, ['applewebkit', 'webkit'])) {
            if (array_key_exists('chromeversion', $this->match)) {
                $chromeversion = (int) $this->match['chromeversion'];
            } else {
                $chromeversion = 0;
            }

            if ($chromeversion >= 28) {
                $engineCode = 'blink';
            } else {
                $engineCode = 'webkit';
            }
        }

        $engine = $engineFactory->get($engineCode, $this->useragent);

        if (!in_array($engine->getName(), ['unknown', null])) {
            return $engine;
        }

        return null;
    }

    /**
     * @return array|null
     */
    public function getRegexes()
    {
        $cacheInitializedId = hash('sha512', 'regex-cache is initialized');
        $cacheInitialized   = $this->cache->getItem($cacheInitializedId);

        if (!$cacheInitialized->isHit() || !$cacheInitialized->get()) {
            $this->initCache($cacheInitialized);
        }

        $cacheItem = $this->cache->getItem(hash('sha512', 'regex-cache'));

        if (!$cacheItem->isHit()) {
            return null;
        }

        return $cacheItem->get();
    }

    /**
     * @param \Psr\Cache\CacheItemInterface $cacheInitialized
     */
    private function initCache(CacheItemInterface $cacheInitialized)
    {
        static $regexes = null;

        if (null === $regexes) {
            $regexes = Yaml::parse(file_get_contents(__DIR__ . '/../../data/regexes.yaml'));
        }

        if (!isset($regexes['regexes']) || !is_array($regexes['regexes'])) {
            return null;
        }

        $cacheItem = $this->cache->getItem(hash('sha512', 'regex-cache'));
        $cacheItem->set($regexes['regexes']);

        $this->cache->save($cacheItem);

        $cacheInitialized->set(true);
        $this->cache->save($cacheInitialized);
    }
}
