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

namespace BrowserDetector\Factory\Device;

use BrowserDetector\Factory;
use BrowserDetector\Helper;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DesktopFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general desktop';

        if ((new Helper\Windows($useragent))->isWindows()) {
            $deviceCode = 'windows desktop';
        } elseif (preg_match('/Raspbian/', $useragent)) {
            $deviceCode = 'raspberry pi';
        } elseif (preg_match('/debian/i', $useragent) && preg_match('/rpi/', $useragent)) {
            $deviceCode = 'raspberry pi';
        } elseif ((new Helper\Linux($useragent))->isLinux()) {
            $deviceCode = 'linux desktop';
        } elseif (preg_match('/iMac/', $useragent)) {
            $deviceCode = 'imac';
        } elseif (preg_match('/macbookpro/i', $useragent)) {
            $deviceCode = 'macbook pro';
        } elseif (preg_match('/macbookair/i', $useragent)) {
            $deviceCode = 'macbook air';
        } elseif (preg_match('/macbook/i', $useragent)) {
            $deviceCode = 'macbook';
        } elseif (preg_match('/macmini/i', $useragent)) {
            $deviceCode = 'mac mini';
        } elseif (preg_match('/macpro/i', $useragent)) {
            $deviceCode = 'macpro';
        } elseif (preg_match('/(powermac|power%20macintosh)/i', $useragent)) {
            $deviceCode = 'powermac';
        } elseif ((new Helper\Macintosh($useragent))->isMacintosh()) {
            $deviceCode = 'macintosh';
        } elseif (preg_match('/eeepc/i', $useragent)) {
            $deviceCode = 'eee pc';
        } elseif (preg_match('/hp\-ux 9000/i', $useragent)) {
            $deviceCode = '9000';
        } elseif (preg_match('/Dillo/', $useragent)) {
            $deviceCode = 'linux desktop';
        }

        return (new Factory\DeviceFactory($this->cache))->get($deviceCode, $useragent);
    }
}
