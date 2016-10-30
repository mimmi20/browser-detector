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

use BrowserDetector\Factory\EngineFactory;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MicrosoftInternetExplorer implements VersionFactoryInterface
{
    private static $patterns = [
        '/Mozilla\/5\.0.*\(.*\) AppleWebKit\/.*\(KHTML, like Gecko\) Chrome\/.*Edge\/12\.0.*/' => '12.0',
        '/Mozilla\/5\.0.*\(.*Trident\/7\.0.*rv\:11\.0.*\) like Gecko.*/'                       => '11.0',
        '/Mozilla\/5\.0.*\(.*MSIE 10\.0.*/'                                                    => '10.0',
        '/Mozilla\/(4|5)\.0.*\(.*MSIE 9\.0.*/'                                                 => '9.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 8\.0.*/'                                                  => '8.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 7\.0.*/'                                                  => '7.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 6\.0.*/'                                                  => '6.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.5.*/'                                                  => '5.5',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.23.*/'                                                 => '5.23',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.22.*/'                                                 => '5.22',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.17.*/'                                                 => '5.17',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.16.*/'                                                 => '5.16',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.01.*/'                                                 => '5.01',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.0.*/'                                                  => '5.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 4\.01.*/'                                                 => '4.01',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 4\.0.*/'                                                  => '4.0',
        '/Mozilla\/.*\(.*MSIE 3\..*/'                                                          => '3.0',
        '/Mozilla\/.*\(.*MSIE 2\..*/'                                                          => '2.0',
        '/Mozilla\/.*\(.*MSIE 1\..*/'                                                          => '1.0',
    ];

    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\Version
     */
    public static function detectVersion($useragent)
    {
        $engine  = (new EngineFactory())->get('trident', $useragent);
        $version = $engine->getVersion();

        if (null !== $version) {
            $engineVersion = (int) $version->getMajor();

            switch ($engineVersion) {
                case 4:
                    return VersionFactory::set('8.0');
                    break;
                case 5:
                    return VersionFactory::set('9.0');
                    break;
                case 6:
                    return VersionFactory::set('10.0');
                    break;
                case 7:
                    return VersionFactory::set('11.0');
                    break;
                default:
                    //nothing to do
                    break;
            }
        }

        $doMatch = preg_match('/MSIE ([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            return VersionFactory::set($matches[1]);
        }

        foreach (self::$patterns as $pattern => $version) {
            if (preg_match($pattern, $useragent)) {
                return VersionFactory::set($version);
            }
        }

        return new Version(0);
    }
}
