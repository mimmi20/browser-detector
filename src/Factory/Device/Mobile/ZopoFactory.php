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

namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ZopoFactory implements Factory\FactoryInterface
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
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return array
     */
    public function detect($useragent)
    {
        $deviceCode = 'general zopo device';

        if (preg_match('/ZP980/', $useragent)) {
            $deviceCode = 'zp980';
        } elseif (preg_match('/ZP950\+/', $useragent)) {
            $deviceCode = 'zp950+';
        } elseif (preg_match('/ZP950/', $useragent)) {
            $deviceCode = 'zp950';
        } elseif (preg_match('/ZP9(10|00H)/', $useragent)) {
            $deviceCode = 'zp910';
        } elseif (preg_match('/ZP900/', $useragent)) {
            $deviceCode = 'zp900';
        } elseif (preg_match('/ZP8(10|00H)/', $useragent)) {
            $deviceCode = 'zp810';
        } elseif (preg_match('/ZP500/', $useragent)) {
            $deviceCode = 'zp500';
        } elseif (preg_match('/ZP300/', $useragent)) {
            $deviceCode = 'zp300';
        } elseif (preg_match('/ZP200/', $useragent)) {
            $deviceCode = 'zp200';
        } elseif (preg_match('/ZP100/', $useragent)) {
            $deviceCode = 'zp100';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
