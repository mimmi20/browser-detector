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
class PrestigioFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general prestigio device';

        if (preg_match('/PMT7077_3G/', $useragent)) {
            $deviceCode = 'pmt7077_3g';
        } elseif (preg_match('/PMT3287_3G/', $useragent)) {
            $deviceCode = 'pmt3287_3g';
        } elseif (preg_match('/PMT3277_3G/', $useragent)) {
            $deviceCode = 'pmt3277_3g';
        } elseif (preg_match('/PMT3037_3G/', $useragent)) {
            $deviceCode = 'pmt3037_3g';
        } elseif (preg_match('/PMT5587_Wi/', $useragent)) {
            $deviceCode = 'pmt5587_wi';
        } elseif (preg_match('/PMT3377_Wi/', $useragent)) {
            $deviceCode = 'pmt3377_wi';
        } elseif (preg_match('/PMP7480D3G_QUAD/', $useragent)) {
            $deviceCode = 'pmp7480d3g_quad';
        } elseif (preg_match('/PMP7380D3G/', $useragent)) {
            $deviceCode = 'pmp7380d3g';
        } elseif (preg_match('/PMP7280C3G_QUAD/', $useragent)) {
            $deviceCode = 'pmp7280c3g_quad';
        } elseif (preg_match('/PMP7280C3G/', $useragent)) {
            $deviceCode = 'pmp7280c3g';
        } elseif (preg_match('/PMP7170B3G/', $useragent)) {
            $deviceCode = 'pmp7170b3g';
        } elseif (preg_match('/PMP7100D3G/', $useragent)) {
            $deviceCode = 'pmp7100d3g';
        } elseif (preg_match('/PMP7079D_QUAD/', $useragent)) {
            $deviceCode = 'pmp7079d_quad';
        } elseif (preg_match('/PMP7079D3G_QUAD/', $useragent)) {
            $deviceCode = 'pmp7079d3g_quad';
        } elseif (preg_match('/PMP7074B3GRU/', $useragent)) {
            $deviceCode = 'pmp7074b3gru';
        } elseif (preg_match('/PMP7070C3G/', $useragent)) {
            $deviceCode = 'pmp7070c3g';
        } elseif (preg_match('/PMP5785C_QUAD/', $useragent)) {
            $deviceCode = 'pmp5785c_quad';
        } elseif (preg_match('/PMP5785C3G_QUAD/', $useragent)) {
            $deviceCode = 'pmp5785c3g_quad';
        } elseif (preg_match('/PMP5770D/', $useragent)) {
            $deviceCode = 'pmp5770d';
        } elseif (preg_match('/PMP5670C_DUO/', $useragent)) {
            $deviceCode = 'pmp5670c_duo';
        } elseif (preg_match('/PMP5580C/', $useragent)) {
            $deviceCode = 'pmp5580c';
        } elseif (preg_match('/PMP5570C/', $useragent)) {
            $deviceCode = 'pmp5570c';
        } elseif (preg_match('/PMP5297C_QUAD/', $useragent)) {
            $deviceCode = 'pmp5297c_quad';
        } elseif (preg_match('/PMP5197DULTRA/', $useragent)) {
            $deviceCode = 'pmp5197dultra';
        } elseif (preg_match('/PMP5101C_QUAD/', $useragent)) {
            $deviceCode = 'pmp5101c_quad';
        } elseif (preg_match('/PMP5080CPRO/', $useragent)) {
            $deviceCode = 'pmp5080cpro';
        } elseif (preg_match('/PMP5080B/', $useragent)) {
            $deviceCode = 'pmp5080b';
        } elseif (preg_match('/PMP3970B/', $useragent)) {
            $deviceCode = 'pmp3970b';
        } elseif (preg_match('/PMP3870C/', $useragent)) {
            $deviceCode = 'pmp3870c';
        } elseif (preg_match('/PMP3370B/', $useragent)) {
            $deviceCode = 'pmp3370b';
        } elseif (preg_match('/PMP3074BRU/', $useragent)) {
            $deviceCode = 'pmp3074bru';
        } elseif (preg_match('/PMP3007C/', $useragent)) {
            $deviceCode = 'pmp3007c';
        } elseif (preg_match('/PAP7600DUO/', $useragent)) {
            $deviceCode = 'pap7600duo';
        } elseif (preg_match('/PAP5503/', $useragent)) {
            $deviceCode = 'pap5503';
        } elseif (preg_match('/PAP5044DUO/', $useragent)) {
            $deviceCode = 'pap5044duo';
        } elseif (preg_match('/PAP5000TDUO/', $useragent)) {
            $deviceCode = 'pap5000tduo';
        } elseif (preg_match('/PAP5000DUO/', $useragent)) {
            $deviceCode = 'pap5000duo';
        } elseif (preg_match('/PAP4500DUO/', $useragent)) {
            $deviceCode = 'pap4500duo';
        } elseif (preg_match('/PAP4044DUO/', $useragent)) {
            $deviceCode = 'pap4044duo';
        } elseif (preg_match('/PAP3350DUO/', $useragent)) {
            $deviceCode = 'pap3350duo';
        } elseif (preg_match('/PSP8500/', $useragent)) {
            $deviceCode = 'psp8500';
        } elseif (preg_match('/PSP8400/', $useragent)) {
            $deviceCode = 'psp8400';
        } elseif (preg_match('/GV7777/', $useragent)) {
            $deviceCode = 'gv7777';
        }

        return (new Factory\DeviceFactory($this->cache))->get($deviceCode, $useragent);
    }
}
