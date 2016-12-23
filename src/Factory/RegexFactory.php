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

namespace BrowserDetector\Factory;

use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetector\Loader\RegexLoader;
use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;
use Symfony\Component\Yaml\Yaml;
use Psr\Log\LoggerInterface;

/**
 * detection class using regexes
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
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
     * @var \BrowserDetector\Loader\RegexLoader
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface $cache
     * @param \Psr\Log\LoggerInterface          $logger
     */
    public function __construct(CacheItemPoolInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
        $this->loader = new RegexLoader($cache, $logger);
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $useragent
     *
     * @return bool
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \InvalidArgumentException
     * @throws \BrowserDetector\Factory\Regex\NoMatchException
     */
    public function detect($useragent)
    {
        $regexes = $this->loader->getRegexes();

        $this->match     = null;
        $this->useragent = $useragent;

        if (!is_array($regexes)) {
            throw new \InvalidArgumentException('no regexes are defined');
        }

        foreach ($regexes as $regex) {
            $matches = [];

            if (preg_match($regex, $useragent, $matches)) {
                $this->logger->debug('a regex matched');
                $this->match = $matches;
                return true;
            }
        }

        throw new Regex\NoMatchException('no regex did match');
    }

    /**
     * @return \UaResult\Device\DeviceInterface
     */
    public function getDevice()
    {
        if (null === $this->useragent) {
            throw new \InvalidArgumentException('no useragent was set');
        }

        if (!array_key_exists('devicecode', $this->match) || '' === $this->match['devicecode']) {
            throw new Regex\NoMatchException('device not detected via regexes');
        }

        $deviceCode   = strtolower($this->match['devicecode']);
        $deviceLoader = new DeviceLoader($this->cache);

        if ('windows' === $deviceCode) {
            return $deviceLoader->load('windows desktop', $this->useragent);
        } elseif ('macintosh' === $deviceCode) {
            return $deviceLoader->load('macintosh', $this->useragent);
        } elseif ('touch' === $deviceCode
            && array_key_exists('osname', $this->match)
            && 'bb10' === strtolower($this->match['osname'])
        ) {
            return $deviceLoader->load('z10', $this->useragent);
        }

        if (array_key_exists('manufacturercode', $this->match)) {
            $manufacturercode = strtolower($this->match['manufacturercode']);
        } else {
            $manufacturercode = '';
        }

        if ($deviceLoader->has($manufacturercode . ' ' . $deviceCode)) {
            $this->logger->debug('device detected via manufacturercode and devicecode');
            return $deviceLoader->load($manufacturercode . ' ' . $deviceCode, $this->useragent);
        }

        if ($deviceLoader->has($deviceCode)) {
            $device = $deviceLoader->load($deviceCode, $this->useragent);

            if (!in_array($device->getDeviceName(), ['unknown', null])) {
                $this->logger->debug('device detected via devicecode');
                return $device;
            }
        }

        if ('' !== $manufacturercode) {
            $className = '\\BrowserDetector\\Factory\\Mobile\\' . ucfirst($manufacturercode);

            if (class_exists($className)) {
                $this->logger->debug('device detected via manufacturer');
                /** @var \BrowserDetector\Factory\FactoryInterface $factory */
                $factory = new $className($this->cache);
                return $factory->detect($this->useragent);
            }

            $this->logger->info('device manufacturer class was not found');
        }

        if (array_key_exists('devicetype', $this->match)) {
            $className = '\\BrowserDetector\\Factory\\' . ucfirst(strtolower($this->match['devicetype']));

            if (class_exists($className)) {
                $this->logger->debug('device detected via device type (mobile or tv)');
                /** @var \BrowserDetector\Factory\FactoryInterface $factory */
                $factory = new $className($this->cache);
                return $factory->detect($this->useragent);
            }

            $this->logger->info('device type class was not found');
        }

        throw new NotFoundException('device not found via regexes');
    }

    /**
     * @return \UaResult\Os\OsInterface
     */
    public function getPlatform()
    {
        if (null === $this->useragent) {
            throw new \InvalidArgumentException('no useragent was set');
        }

        $platformLoader = new PlatformLoader($this->cache);

        if (!array_key_exists('osname', $this->match)
            && array_key_exists('manufacturercode', $this->match)
            && 'blackberry' === strtolower($this->match['manufacturercode'])
        ) {
            $this->logger->debug('platform forced to rim os');
            return $platformLoader->load('rim os', $this->useragent);
        }

        if (!array_key_exists('osname', $this->match) || '' === $this->match['osname']) {
            throw new Regex\NoMatchException('platform not detected via regexes');
        }

        $platformCode = strtolower($this->match['osname']);

        if ('darwin' === $platformCode) {
            $darwinFactory = new Platform\DarwinFactory($this->cache, $platformLoader);
            return $darwinFactory->detect($this->useragent);
        }

        $s = new Stringy($this->useragent);

        if ('linux' === $platformCode && array_key_exists('devicecode', $this->match)) {
            // Android Desktop Mode
            $platformCode = 'android';
        } elseif ('adr' === $platformCode) {
            // Android Desktop Mode with UCBrowser
            $platformCode = 'android';
        } elseif ('linux' === $platformCode && $s->containsAll(['opera mini', 'ucbrowser'], false)) {
            // Android Desktop Mode with UCBrowser
            $platformCode = 'android';
        } elseif ('linux' === $platformCode) {
            $linuxFactory = new Platform\LinuxFactory($this->cache, $platformLoader);
            return $linuxFactory->detect($this->useragent);
        } elseif ('bb10' === $platformCode || 'blackberry' === $platformCode) {
            // Rim OS
            $platformCode = 'rim os';
        } elseif ('cros' === $platformCode) {
            $platformCode = 'chromeos';
        }

        if (false !== strpos($platformCode, 'windows nt') && array_key_exists('devicetype', $this->match)) {
            // Windows Phone Desktop Mode
            $platformCode = 'windows phone';
        }

        if ($platformLoader->has($platformCode)) {
            $platform = $platformLoader->load($platformCode, $this->useragent);

            if (!in_array($platform->getName(), ['unknown', null])) {
                return $platform;
            }

            $this->logger->info('platform with code "' . $platformCode . '" not found via regexes');
        }

        throw new NotFoundException('platform not found via regexes');
    }

    /**
     * @return \UaResult\Browser\BrowserInterface
     */
    public function getBrowser()
    {
        if (null === $this->useragent) {
            throw new \InvalidArgumentException('no useragent was set');
        }

        if (!array_key_exists('browsername', $this->match) || '' === $this->match['browsername']) {
            throw new Regex\NoMatchException('browser not detected via regexes');
        }

        $browserCode   = strtolower($this->match['browsername']);
        $browserLoader = new BrowserLoader($this->cache);

        switch ($browserCode) {
            case 'opr':
                $browserCode = 'opera';
                break;
            case 'msie':
                $browserCode = 'internet explorer';
                break;
            case 'ucweb':
            case 'ubrowser':
                $browserCode = 'ucbrowser';
                break;
            case 'crmo':
                $browserCode = 'chrome';
                break;
            case 'granparadiso':
                $browserCode = 'firefox';
                break;
            default:
                // do nothing here
        }

        if ('safari' === $browserCode) {
            if (array_key_exists('osname', $this->match)) {
                $osname = strtolower($this->match['osname']);

                if ('android' === $osname || 'linux' === $osname) {
                    return $browserLoader->load('android webkit', $this->useragent);
                }

                if ('tizen' === $osname) {
                    return $browserLoader->load('samsungbrowser', $this->useragent);
                }

                if ('blackberry' === $osname) {
                    return $browserLoader->load('blackberry', $this->useragent);
                }

                if ('symbian' === $osname || 'symbianos' === $osname) {
                    return $browserLoader->load('android webkit', $this->useragent);
                }
            }

            if (array_key_exists('manufacturercode', $this->match)) {
                $devicemaker = strtolower($this->match['manufacturercode']);

                if ('nokia' === $devicemaker) {
                    return $browserLoader->load('nokiabrowser', $this->useragent);
                }
            }
        }

        if ($browserLoader->has($browserCode)) {
            $browser = $browserLoader->load($browserCode, $this->useragent);

            if (!in_array($browser->getName(), ['unknown', null])) {
                return $browser;
            }

            $this->logger->info('browser with code "' . $browserCode . '" not found via regexes');
        }

        throw new NotFoundException('browser not found via regexes');
    }

    /**
     * @return \UaResult\Engine\EngineInterface
     */
    public function getEngine()
    {
        if (null === $this->useragent) {
            throw new \InvalidArgumentException('no useragent was set');
        }

        if (!array_key_exists('enginename', $this->match) || '' === $this->match['enginename']) {
            throw new Regex\NoMatchException('engine not detected via regexes');
        }

        $engineCode   = strtolower($this->match['enginename']);
        $engineLoader = new EngineLoader($this->cache);

        if ('cfnetwork' === $engineCode) {
            return $engineLoader->load('webkit', $this->useragent);
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

        if ($engineLoader->has($engineCode)) {
            $engine = $engineLoader->load($engineCode, $this->useragent);

            if (!in_array($engine->getName(), ['unknown', null])) {
                return $engine;
            }

            $this->logger->info('engine with code "' . $engineCode . '" not found via regexes');
        }

        throw new NotFoundException('engine not found via regexes');
    }
}
