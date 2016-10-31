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
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class TvFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general tv device';

        if (preg_match('/xbox one/i', $useragent)) {
            $deviceCode = 'xbox one';
        } elseif (preg_match('/xbox/i', $useragent)) {
            $deviceCode = 'xbox 360';
        } elseif (preg_match('/dlink\.dsm380/i', $useragent)) {
            $deviceCode = 'dsm 380';
        } elseif (preg_match('/NSZ\-GS7\/GX70/', $useragent)) {
            $deviceCode = 'nsz-gs7/gx70';
        } elseif (preg_match('/googletv/i', $useragent)) {
            $deviceCode = 'google tv';
        } elseif (preg_match('/idl\-6651n/i', $useragent)) {
            $deviceCode = 'idl-6651n';
        } elseif (preg_match('/loewe; sl32x/i', $useragent)) {
            $deviceCode = 'sl32x';
        } elseif (preg_match('/loewe; sl121/i', $useragent)) {
            $deviceCode = 'sl121';
        } elseif (preg_match('/loewe; sl150/i', $useragent)) {
            $deviceCode = 'sl150';
        } elseif (preg_match('/lf1v464/i', $useragent)) {
            $deviceCode = 'lf1v464';
        } elseif (preg_match('/lf1v401/i', $useragent)) {
            $deviceCode = 'lf1v401';
        } elseif (preg_match('/lf1v394/i', $useragent)) {
            $deviceCode = 'lf1v394';
        } elseif (preg_match('/lf1v373/i', $useragent)) {
            $deviceCode = 'lf1v373';
        } elseif (preg_match('/lf1v325/i', $useragent)) {
            $deviceCode = 'lf1v325';
        } elseif (preg_match('/lf1v307/i', $useragent)) {
            $deviceCode = 'lf1v307';
        } elseif (preg_match('/NETRANGEMMH/', $useragent)) {
            $deviceCode = 'netrangemmh';
        } elseif (preg_match('/viera/i', $useragent)) {
            $deviceCode = 'viera tv';
        } elseif (preg_match('/AVM\-2012/', $useragent)) {
            $deviceCode = 'blueray player';
        } elseif (preg_match('/\(; Philips; ; ; ; \)/', $useragent)) {
            $deviceCode = 'general philips tv';
        } elseif (preg_match('/Mxl661L32/', $useragent)) {
            $deviceCode = 'samsung smart tv';
        } elseif (preg_match('/SMART\-TV/', $useragent)) {
            $deviceCode = 'samsung smart tv';
        } elseif (preg_match('/KDL32HX755/', $useragent)) {
            $deviceCode = 'kdl32hx755';
        } elseif (preg_match('/KDL32W655A/', $useragent)) {
            $deviceCode = 'kdl32w655a';
        } elseif (preg_match('/KDL37EX720/', $useragent)) {
            $deviceCode = 'kdl37ex720';
        } elseif (preg_match('/KDL42W655A/', $useragent)) {
            $deviceCode = 'kdl42w655a';
        } elseif (preg_match('/KDL40EX720/', $useragent)) {
            $deviceCode = 'kdl40ex720';
        } elseif (preg_match('/KDL50W815B/', $useragent)) {
            $deviceCode = 'kdl50w815b';
        } elseif (preg_match('/SonyDTV115/', $useragent)) {
            $deviceCode = 'dtv115';
        } elseif (preg_match('/technisat digicorder isio s/i', $useragent)) {
            $deviceCode = 'digicorder isio s';
        } elseif (preg_match('/technisat digit isio s/i', $useragent)) {
            $deviceCode = 'digit isio s';
        } elseif (preg_match('/TechniSat MultyVision ISIO/', $useragent)) {
            $deviceCode = 'multyvision isio';
        } elseif (preg_match('/AQUOSBrowser/', $useragent)) {
            $deviceCode = 'aquos tv';
        } elseif (preg_match('/(CX919|gxt_dongle_3188)/', $useragent)) {
            $deviceCode = 'cx919';
        } elseif (preg_match('/Apple TV/', $useragent)) {
            $deviceCode = 'appletv';
        }

        return (new Factory\DeviceFactory($this->cache))->get($deviceCode, $useragent);
    }
}
