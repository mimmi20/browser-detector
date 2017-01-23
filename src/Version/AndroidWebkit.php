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

namespace BrowserDetector\Version;

use BrowserDetector\Helper\Safari as SafariHelper;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AndroidWebkit implements VersionCacheFactoryInterface
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
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\Version
     */
    public function detectVersion($useragent)
    {
        $safariHelper = new SafariHelper($useragent);

        $doMatch = preg_match(
            '/Version\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($safariHelper->mapSafariVersions($matches[1]));
        }

        if (preg_match('/android eclair/i', $useragent)) {
            return VersionFactory::set('2.1');
        }

        if (preg_match('/gingerbread/i', $useragent)) {
            return VersionFactory::set('2.3');
        }

        $doMatch = preg_match(
            '/Safari\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match(
            '/AppleWebKit\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match(
            '/MobileSafari\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match(
            '/Android\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($matches[1]);
        }

        $searches = ['Version', 'Safari', 'JUC \(Linux\; U\;'];

        return VersionFactory::detectVersion($useragent, $searches);
    }
}
