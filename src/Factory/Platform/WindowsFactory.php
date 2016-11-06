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

namespace BrowserDetector\Factory\Platform;

use BrowserDetector\Factory;
use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;
use BrowserDetector\Loader\LoaderInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class WindowsFactory implements Factory\FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
        $this->loader = $loader;
    }

    /**
     * Gets the information about the platform by User Agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect($useragent)
    {
        $s = new Stringy($useragent);

        if ($s->containsAny(['Windows NT 10', 'Windows 10'], false)) {
            return $this->loader->load('windows nt 10', $useragent);
        }

        if ($s->containsAny(['Windows NT 6.4', 'Windows 6.4'], false)) {
            return $this->loader->load('windows nt 6.4', $useragent);
        }

        if ($s->containsAny(['Windows NT 6.3', 'Windows 6.3', 'Windows 8.1'], false)) {
            return $this->loader->load('windows nt 6.3', $useragent);
        }

        if ($s->containsAny(['Windows NT 6.2', 'Windows 6.2', 'Windows 8'], false)) {
            return $this->loader->load('windows nt 6.2', $useragent);
        }

        if ($s->containsAny(['Windows NT 6.1', 'Windows 6.1', 'Windows 7'], false)) {
            return $this->loader->load('windows nt 6.1', $useragent);
        }

        if ($s->containsAny(['Windows NT 6', 'Windows 6', 'Windows Vista'], false)) {
            return $this->loader->load('windows nt 6.0', $useragent);
        }

        if ($s->contains('Windows 2003', false)) {
            return $this->loader->load('windows 2003', $useragent);
        }

        if ($s->containsAny(['Windows NT 5.3', 'Windows 5.3'], false)) {
            return $this->loader->load('windows nt 5.3', $useragent);
        }

        if ($s->containsAny(['Windows NT 5.2', 'Windows 5.2'], false)) {
            return $this->loader->load('windows nt 5.2', $useragent);
        }

        if ($s->containsAny(['Windows NT 5.1', 'Windows 5.1', 'Windows XP'], false)) {
            return $this->loader->load('windows nt 5.1', $useragent);
        }

        if ($s->containsAny(['Windows NT 5.01', 'Windows 5.01'], false)) {
            return $this->loader->load('windows nt 5.01', $useragent);
        }

        if ($s->containsAny(['Windows NT 5.0', 'Windows 5.0', 'Windows 2000'], false)) {
            return $this->loader->load('windows nt 5.0', $useragent);
        }

        if ($s->containsAny(['win9x/NT 4.90', 'Win 9x 4.90', 'Win 9x4.90', 'Windows ME'], false)) {
            return $this->loader->load('windows me', $useragent);
        }

        if ($s->containsAny(['Win98', 'Windows 98'], false)) {
            return $this->loader->load('windows 98', $useragent);
        }

        if ($s->containsAny(['Win95', 'Windows 95'], false)) {
            return $this->loader->load('windows 95', $useragent);
        }

        if ($s->containsAny(['Windows NT 4.10', 'Windows 4.10'], false)) {
            return $this->loader->load('windows nt 4.10', $useragent);
        }

        if ($s->containsAny(['Windows NT 4.1', 'Windows 4.1'], false)) {
            return $this->loader->load('windows nt 4.1', $useragent);
        }

        if ($s->containsAny(['Windows NT 4.0', 'Windows 4.0'], false)) {
            return $this->loader->load('windows nt 4.0', $useragent);
        }

        if ($s->containsAny(['Windows NT 3.5', 'Windows 3.5'], false)) {
            return $this->loader->load('windows nt 3.5', $useragent);
        }

        if ($s->containsAny(['Windows NT 3.1'], false)) {
            return $this->loader->load('windows nt 3.1', $useragent);
        }

        if ($s->containsAny(['Windows NT'], false)) {
            return $this->loader->load('windows nt', $useragent);
        }

        if ($s->containsAny(['Windows 3.1'], false)) {
            return $this->loader->load('windows 3.1', $useragent);
        }

        return $this->loader->load('windows', $useragent);
    }
}
