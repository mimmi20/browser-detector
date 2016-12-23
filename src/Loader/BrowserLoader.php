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

use BrowserDetector\Bits\Browser as BrowserBits;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use UaBrowserType;
use UaResult\Browser\Browser;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserLoader implements LoaderInterface
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
        $cacheInitializedId = hash('sha512', 'browser-cache is initialized');
        $cacheInitialized   = $this->cache->getItem($cacheInitializedId);

        if (!$cacheInitialized->isHit() || !$cacheInitialized->get()) {
            $this->initCache($cacheInitialized);
        }
    }

    /**
     * @param string $browserKey
     *
     * @return bool
     */
    public function has($browserKey)
    {
        $this->init();

        $cacheItem = $this->cache->getItem(hash('sha512', 'browser-cache-' . $browserKey));

        return $cacheItem->isHit();
    }

    /**
     * @param string $browserKey
     * @param string $useragent
     *
     * @return \UaResult\Browser\BrowserInterface
     * @throws \BrowserDetector\Loader\NotFoundException
     */
    public function load($browserKey, $useragent)
    {
        $this->init();

        if (!$this->has($browserKey)) {
            throw new NotFoundException('the browser with key "' . $browserKey . '" was not found');
        }

        $engineLoader = new EngineLoader($this->cache);
        $cacheItem    = $this->cache->getItem(hash('sha512', 'browser-cache-' . $browserKey));

        $browser = $cacheItem->get();

        $browserVersionClass = $browser->version->class;

        if (!is_string($browserVersionClass)) {
            $version = new Version(0);
        } elseif ('VersionFactory' === $browserVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $browser->version->search);
        } else {
            /** @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $browserVersionClass($this->cache);
            $version      = $versionClass->detectVersion($useragent);
        }

        $typeClass = '\\UaBrowserType\\' . $browser->type;

        return new Browser(
            $browser->name,
            $browser->manufacturer,
            $browser->brand,
            $version,
            $engineLoader->load($browser->engine, $useragent),
            new $typeClass(),
            (new BrowserBits($useragent))->getBits(),
            $browser->pdfSupport,
            $browser->rssSupport,
            $browser->canSkipAlignedLinkRow,
            $browser->claimsWebSupport,
            $browser->supportsEmptyOptionValues,
            $browser->supportsBasicAuthentication,
            $browser->supportsPostMethod
        );
    }

    /**
     * @param \Psr\Cache\CacheItemInterface $cacheInitialized
     */
    private function initCache(CacheItemInterface $cacheInitialized)
    {
        static $browsers = null;

        if (null === $browsers) {
            $browsers = json_decode(file_get_contents(__DIR__ . '/../../data/browsers.json'));
        }

        foreach ($browsers as $browserKey => $browserData) {
            $cacheItem = $this->cache->getItem(hash('sha512', 'browser-cache-' . $browserKey));
            $cacheItem->set($browserData);

            $this->cache->save($cacheItem);
        }

        $cacheInitialized->set(true);
        $this->cache->save($cacheInitialized);
    }
}
