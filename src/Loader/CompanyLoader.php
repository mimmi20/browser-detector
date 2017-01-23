<?php
/**
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
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
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Loader;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use UaResult\Company\Company;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class CompanyLoader implements LoaderInterface
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
        $cacheInitializedId = hash('sha512', 'company-cache is initialized');
        $cacheInitialized   = $this->cache->getItem($cacheInitializedId);

        if (!$cacheInitialized->isHit() || !$cacheInitialized->get()) {
            $this->initCache($cacheInitialized);
        }
    }

    /**
     * detects if the company is available
     *
     * @param string $companyKey
     *
     * @return bool
     */
    public function has($companyKey)
    {
        $this->init();

        $cacheItem = $this->cache->getItem(hash('sha512', 'company-cache-' . $companyKey));

        return $cacheItem->isHit();
    }

    /**
     * Gets the information about the company
     *
     * @param string $companyKey
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     * @return \UaResult\Company\Company
     */
    public function load($companyKey)
    {
        $this->init();

        if (!$this->has($companyKey)) {
            throw new NotFoundException('the company with key "' . $companyKey . '" was not found');
        }

        $cacheItem = $this->cache->getItem(hash('sha512', 'company-cache-' . $companyKey));

        $company = $cacheItem->get();

        if (isset($company->name)) {
            $name = $company->name;
        } else {
            $name = 'unknown';
        }

        if (isset($company->brandname)) {
            $brandname = $company->brandname;
        } else {
            $brandname = 'unknown';
        }

        return new Company($name, $brandname);
    }

    /**
     * @param \Psr\Cache\CacheItemInterface $cacheInitialized
     */
    private function initCache(CacheItemInterface $cacheInitialized)
    {
        static $companies = null;

        if (null === $companies) {
            $companies = json_decode(file_get_contents(__DIR__ . '/../../data/companies.json'));
        }

        foreach ($companies as $companyKey => $companyData) {
            $cacheItem = $this->cache->getItem(hash('sha512', 'company-cache-' . $companyKey));
            $cacheItem->set($companyData);

            $this->cache->save($cacheItem);
        }

        $cacheInitialized->set(true);
        $this->cache->save($cacheInitialized);
    }
}
