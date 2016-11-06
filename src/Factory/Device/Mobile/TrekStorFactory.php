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

namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class TrekStorFactory implements Factory\FactoryInterface
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
     * @return \UaResult\Device\DeviceInterface
     */
    public function detect($useragent)
    {
        $deviceCode = 'general trekstor device';

        if (preg_match('/SurfTab duo W1 10\.1/', $useragent)) {
            $deviceCode = 'surftab duo w1 10.1';
        } elseif (preg_match('/WP 4\.7/', $useragent)) {
            $deviceCode = 'winphone 4.7 hd';
        } elseif (preg_match('/VT10416\-2/', $useragent)) {
            $deviceCode = 'vt10416-2';
        } elseif (preg_match('/VT10416\-1/', $useragent)) {
            $deviceCode = 'vt10416-1';
        } elseif (preg_match('/(ST701041|SurfTab\_7\.0)/', $useragent)) {
            $deviceCode = 'st701041';
        } elseif (preg_match('/ST10216\-2/', $useragent)) {
            $deviceCode = 'st10216-2';
        } elseif (preg_match('/ST80216/', $useragent)) {
            $deviceCode = 'st80216';
        } elseif (preg_match('/ST80208/', $useragent)) {
            $deviceCode = 'st80208';
        } elseif (preg_match('/ST70104/', $useragent)) {
            $deviceCode = 'st70104';
        } elseif (preg_match('/ST10416\-1/', $useragent)) {
            $deviceCode = 'st10416-1';
        } elseif (preg_match('/ST10216\-1/', $useragent)) {
            $deviceCode = 'st10216-1';
        } elseif (preg_match('/trekstor_liro_color/', $useragent)) {
            $deviceCode = 'liro color';
        } elseif (preg_match('/breeze 10\.1 quad/', $useragent)) {
            $deviceCode = 'surftab breeze 10.1 quad';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
