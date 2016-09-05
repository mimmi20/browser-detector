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

namespace BrowserDetector\Detector\Version;

use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AndroidOs
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
        if (false !== stripos($useragent, 'android 2.1-update1')) {
            return VersionFactory::set('2.1.1');
        }

        $searches = [
            'android android',
            'android androidhouse team',
            'android wildpuzzlerom v8 froyo',
            'juc\(linux;u;',
            'juc \(linux; u;',
            'linux; googletv',
            'android os',
            'android;',
            'android_',
            'android ',
            'android\/',
            'android',
            'adr ',
        ];

        $detector = VersionFactory::detectVersion($useragent, $searches);

        if ('0.0.0' !== $detector->getVersion()) {
            return $detector;
        }

        if (false !== stripos($useragent, 'android eclair')) {
            return VersionFactory::set('2.1.0');
        }

        if (false !== stripos($useragent, 'gingerbread')) {
            return VersionFactory::set('2.3.0');
        }

        return new Version(0);
    }
}
