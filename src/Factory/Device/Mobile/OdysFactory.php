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
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class OdysFactory implements Factory\FactoryInterface
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
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function detect($useragent)
    {
        $deviceCode = 'general odys device';

        if (preg_match('/MAVEN_10_PLUS/', $useragent)) {
            $deviceCode = 'maven 10 plus';
        } elseif (preg_match('/xtreme/i', $useragent)) {
            $deviceCode = 'xtreme';
        } elseif (preg_match('/XPRESS PRO/', $useragent)) {
            $deviceCode = 'xpress pro';
        } elseif (preg_match('/xpress/i', $useragent)) {
            $deviceCode = 'xpress';
        } elseif (preg_match('/(XENO10|XENO 10)/', $useragent)) {
            $deviceCode = 'xeno 10';
        } elseif (preg_match('/XelioPT2Pro/', $useragent)) {
            $deviceCode = 'xelio pt2 pro';
        } elseif (preg_match('/(Xelio10Pro|Xelio 10 Pro)/i', $useragent)) {
            $deviceCode = 'xelio 10 pro';
        } elseif (preg_match('/(XELIO10EXTREME|Xelio 10 Extreme)/', $useragent)) {
            $deviceCode = 'xelio 10 extreme';
        } elseif (preg_match('/(XELIO7PRO|Xelio 7 pro)/', $useragent)) {
            $deviceCode = 'xelio 7 pro';
        } elseif (preg_match('/xelio/i', $useragent)) {
            $deviceCode = 'xelio';
        } elseif (preg_match('/UNO\_X10/', $useragent)) {
            $deviceCode = 'uno x10';
        } elseif (preg_match('/SPACE10_PLUS_3G/', $useragent)) {
            $deviceCode = 'space 10 plus 3g';
        } elseif (preg_match('/Space/', $useragent)) {
            $deviceCode = 'space';
        } elseif (preg_match('/sky plus/i', $useragent)) {
            $deviceCode = 'sky plus 3g';
        } elseif (preg_match('/ODYS\-Q/', $useragent)) {
            $deviceCode = 'q';
        } elseif (preg_match('/noon/i', $useragent)) {
            $deviceCode = 'noon';
        } elseif (preg_match('/ADM816HC/', $useragent)) {
            $deviceCode = 'adm816hc';
        } elseif (preg_match('/ADM816KC/', $useragent)) {
            $deviceCode = 'adm816kc';
        } elseif (preg_match('/NEO\_QUAD10/', $useragent)) {
            $deviceCode = 'neo quad 10';
        } elseif (preg_match('/loox plus/i', $useragent)) {
            $deviceCode = 'loox plus';
        } elseif (preg_match('/loox/i', $useragent)) {
            $deviceCode = 'loox';
        } elseif (preg_match('/IEOS_QUAD_10_PRO/', $useragent)) {
            $deviceCode = 'ieos quad 10 pro';
        } elseif (preg_match('/IEOS_QUAD_W/', $useragent)) {
            $deviceCode = 'ieos quad w';
        } elseif (preg_match('/IEOS_QUAD/', $useragent)) {
            $deviceCode = 'ieos quad';
        } elseif (preg_match('/CONNECT7PRO/', $useragent)) {
            $deviceCode = 'connect 7 pro';
        } elseif (preg_match('/genesis/i', $useragent)) {
            $deviceCode = 'genesis';
        } elseif (preg_match('/evo/i', $useragent)) {
            $deviceCode = 'evo';
        }

        return (new Factory\DeviceFactory($this->cache))->get($deviceCode, $useragent);
    }
}
