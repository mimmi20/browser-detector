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
class AsusFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general asus device';

        if (preg_match('/TF101G/i', $useragent)) {
            $deviceCode = 'eee pad transformer tf101g';
        } elseif (preg_match('/(Transformer TF201|Transformer Prime TF201)/i', $useragent)) {
            $deviceCode = 'asus eee pad tf201';
        } elseif (preg_match('/z00ad/i', $useragent)) {
            $deviceCode = 'z00ad';
        } elseif (preg_match('/k00c/i', $useragent)) {
            $deviceCode = 'k00c';
        } elseif (preg_match('/k00f/i', $useragent)) {
            $deviceCode = 'k00f';
        } elseif (preg_match('/k00z/i', $useragent)) {
            $deviceCode = 'k00z';
        } elseif (preg_match('/k01e/i', $useragent)) {
            $deviceCode = 'k01e';
        } elseif (preg_match('/k01a/i', $useragent)) {
            $deviceCode = 'k01a';
        } elseif (preg_match('/k017/i', $useragent)) {
            $deviceCode = 'k017';
        } elseif (preg_match('/K013/i', $useragent)) {
            $deviceCode = 'k013';
        } elseif (preg_match('/K012/i', $useragent)) {
            $deviceCode = 'k012';
        } elseif (preg_match('/(K00E|ME372CG)/i', $useragent)) {
            $deviceCode = 'k00e';
        } elseif (preg_match('/ME172V/i', $useragent)) {
            $deviceCode = 'me172v';
        } elseif (preg_match('/ME173X/i', $useragent)) {
            $deviceCode = 'me173x';
        } elseif (preg_match('/ME301T/i', $useragent)) {
            $deviceCode = 'me301t';
        } elseif (preg_match('/ME302C/i', $useragent)) {
            $deviceCode = 'me302c';
        } elseif (preg_match('/ME302KL/i', $useragent)) {
            $deviceCode = 'me302kl';
        } elseif (preg_match('/ME371MG/i', $useragent)) {
            $deviceCode = 'me371mg';
        } elseif (preg_match('/P1801\-T/i', $useragent)) {
            $deviceCode = 'p1801-t';
        } elseif (preg_match('/T00J/', $useragent)) {
            $deviceCode = 't00j';
        } elseif (preg_match('/T00N/', $useragent)) {
            $deviceCode = 't00n';
        } elseif (preg_match('/P01Y/', $useragent)) {
            $deviceCode = 'p01y';
        } elseif (preg_match('/TF101/i', $useragent)) {
            $deviceCode = 'tf101';
        } elseif (preg_match('/TF300TL/i', $useragent)) {
            $deviceCode = 'tf300tl';
        } elseif (preg_match('/TF300TG/i', $useragent)) {
            $deviceCode = 'tf300tg';
        } elseif (preg_match('/TF300T/i', $useragent)) {
            $deviceCode = 'tf300t';
        } elseif (preg_match('/TF700T/i', $useragent)) {
            $deviceCode = 'tf700t';
        } elseif (preg_match('/Slider SL101/i', $useragent)) {
            $deviceCode = 'sl101';
        } elseif (preg_match('/Garmin\-Asus A50/i', $useragent)) {
            $deviceCode = 'a50';
        } elseif (preg_match('/Garmin\-Asus A10/i', $useragent)) {
            $deviceCode = 'asus a10';
        } elseif (preg_match('/Transformer Prime/i', $useragent)) {
            $deviceCode = 'asus eee pad tf201';
        } elseif (preg_match('/padfone t004/i', $useragent)) {
            $deviceCode = 'padfone t004';
        } elseif (preg_match('/padfone 2/i', $useragent)) {
            $deviceCode = 'a68';
        } elseif (preg_match('/padfone/i', $useragent)) {
            $deviceCode = 'padfone';
        } elseif (preg_match('/nexus[ _]?7/i', $useragent)) {
            $deviceCode = 'nexus 7';
        } elseif (preg_match('/asus;galaxy6/i', $useragent)) {
            $deviceCode = 'galaxy6';
        } elseif (preg_match('/eee_701/i', $useragent)) {
            $deviceCode = 'eee 701';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
