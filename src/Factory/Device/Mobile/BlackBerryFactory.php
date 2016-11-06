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
class BlackBerryFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general blackberry device';

        if (preg_match('/BB10; Kbd/i', $useragent)) {
            $deviceCode = 'kbd';
        } elseif (preg_match('/BB10; Touch/i', $useragent)) {
            $deviceCode = 'z10';
        } elseif (preg_match('/PlayBook/i', $useragent)) {
            $deviceCode = 'playbook';
        } elseif (preg_match('/RIM Tablet/i', $useragent)) {
            $deviceCode = 'tablet';
        } elseif (preg_match('/9981/i', $useragent)) {
            $deviceCode = 'blackberry 9981';
        } elseif (preg_match('/9900/i', $useragent)) {
            $deviceCode = 'blackberry bold touch 9900';
        } elseif (preg_match('/9860/i', $useragent)) {
            $deviceCode = 'blackberry torch 9860';
        } elseif (preg_match('/9810/i', $useragent)) {
            $deviceCode = 'blackberry 9810';
        } elseif (preg_match('/9800/i', $useragent)) {
            $deviceCode = 'blackberry 9800';
        } elseif (preg_match('/9790/i', $useragent)) {
            $deviceCode = 'blackberry 9790';
        } elseif (preg_match('/9780/i', $useragent)) {
            $deviceCode = 'blackberry 9780';
        } elseif (preg_match('/9720/i', $useragent)) {
            $deviceCode = 'blackberry 9720';
        } elseif (preg_match('/9700/i', $useragent)) {
            $deviceCode = 'blackberry 9700';
        } elseif (preg_match('/9670/i', $useragent)) {
            $deviceCode = 'blackberry 9670';
        } elseif (preg_match('/9630/i', $useragent)) {
            $deviceCode = 'blackberry 9630';
        } elseif (preg_match('/9550/i', $useragent)) {
            $deviceCode = 'blackberry 9550';
        } elseif (preg_match('/9520/i', $useragent)) {
            $deviceCode = 'blackberry 9520';
        } elseif (preg_match('/9500/i', $useragent)) {
            $deviceCode = 'blackberry 9500';
        } elseif (preg_match('/9380/i', $useragent)) {
            $deviceCode = 'blackberry 9380';
        } elseif (preg_match('/9360/i', $useragent)) {
            $deviceCode = 'blackberry 9360';
        } elseif (preg_match('/9320/i', $useragent)) {
            $deviceCode = 'blackberry 9320';
        } elseif (preg_match('/9300/i', $useragent)) {
            $deviceCode = 'blackberry 9300';
        } elseif (preg_match('/9220/i', $useragent)) {
            $deviceCode = 'blackberry 9220';
        } elseif (preg_match('/9105/i', $useragent)) {
            $deviceCode = 'blackberry 9105';
        } elseif (preg_match('/9000/i', $useragent)) {
            $deviceCode = 'blackberry 9000';
        } elseif (preg_match('/8900/i', $useragent)) {
            $deviceCode = 'blackberry 8900';
        } elseif (preg_match('/8830/i', $useragent)) {
            $deviceCode = 'blackberry 8830';
        } elseif (preg_match('/8800/i', $useragent)) {
            $deviceCode = 'blackberry 8800';
        } elseif (preg_match('/8700/i', $useragent)) {
            $deviceCode = 'blackberry 8700';
        } elseif (preg_match('/8530/i', $useragent)) {
            $deviceCode = 'blackberry 8530';
        } elseif (preg_match('/8520/i', $useragent)) {
            $deviceCode = 'blackberry 8520';
        } elseif (preg_match('/8350i/i', $useragent)) {
            $deviceCode = 'blackberry 8350i';
        } elseif (preg_match('/8310/i', $useragent)) {
            $deviceCode = 'blackberry 8310';
        } elseif (preg_match('/8230/i', $useragent)) {
            $deviceCode = 'blackberry 8230';
        } elseif (preg_match('/8110/i', $useragent)) {
            $deviceCode = 'blackberry 8110';
        } elseif (preg_match('/8100/i', $useragent)) {
            $deviceCode = 'blackberry 8100';
        } elseif (preg_match('/7520/i', $useragent)) {
            $deviceCode = 'blackberry 7520';
        } elseif (preg_match('/7130/i', $useragent)) {
            $deviceCode = 'blackberry 7130';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
