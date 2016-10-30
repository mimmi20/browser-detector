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

namespace BrowserDetector\Version;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Ios implements VersionFactoryInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\Version
     */
    public static function detectVersion($useragent)
    {
        $doMatch = preg_match('/CPU like Mac OS X/', $useragent, $matches);

        if ($doMatch) {
            return VersionFactory::set('1.0');
        }

        $searches = [
            'IphoneOSX',
            'CPU OS\_',
            'CPU OS',
            'CPU iOS',
            'CPU iPad OS',
            'iPhone OS\;FBSV',
            'iPhone OS',
            'iPhone_OS',
            'IUC\(U\;iOS',
            'iPh OS',
            'iosv',
            'iOS',
        ];

        $detectedVersion = VersionFactory::detectVersion($useragent, $searches);

        if ($detectedVersion->getVersion(Version::MAJORONLY) > 999) {
            $versions = [];
            $found    = preg_match('/(\d\d)(\d)(\d)/', $detectedVersion->getVersion(Version::MAJORONLY), $versions);

            if ($found) {
                return VersionFactory::set($versions[1] . '.' . $versions[2] . '.' . $versions[3]);
            }
        }

        if ($detectedVersion->getVersion(Version::MAJORONLY) > 99) {
            $versions = [];
            $found    = preg_match('/(\d)(\d)(\d)/', $detectedVersion->getVersion(Version::MAJORONLY), $versions);

            if ($found) {
                return VersionFactory::set($versions[1] . '.' . $versions[2] . '.' . $versions[3]);
            }
        }

        if ('10.10' === $detectedVersion->getVersion(Version::MAJORMINOR)) {
            return VersionFactory::set('8.0.0');
        }

        return $detectedVersion;
    }
}
