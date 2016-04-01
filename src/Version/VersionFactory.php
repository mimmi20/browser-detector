<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Version;

/**
 * a general version detector factory
 *
 * @category  BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class VersionFactory
{
    /**
     * sets the detected version
     *
     * @param string $version
     *
     * @throws \UnexpectedValueException
     * @return \BrowserDetector\Version\Version
     */
    public static function set($version)
    {
        $parts = [];
        if (!preg_match(
            '#^'
            . '(?P<core>(?:[0-9]|[1-9][0-9]+)(?:\.(?:[0-9]|[1-9][0-9]+)){2,4})'
            . '(?:\-(?P<preRelease>[0-9A-Za-z\-\.]+))?'
            . '(?:\+(?P<build>[0-9A-Za-z\-\.]+))?'
            . '$#',
            $version,
            $parts
        )) {
            return new self();
        }

        list($major, $minor, $patch) = explode('.', $parts['core'], 3);

        $preRelease = (!empty($parts['preRelease'])) ? $parts['preRelease'] : null;
        $build      = (!empty($parts['build'])) ? $parts['build'] : null;

        return new self($major, $minor, $patch, $preRelease, $build);
    }

    /**
     * detects the bit count by this browser from the given user agent
     *
     * @param string       $useragent
     * @param string|array $searches
     * @param string       $default
     *
     * @return \BrowserDetector\Version\Version
     */
    public static function detectVersion($useragent, $searches = '', $default = '0')
    {
        if (!is_array($searches) && !is_string($searches)) {
            throw new \UnexpectedValueException(
                'a string or an array of strings is expected as parameter'
            );
        }

        if (!is_array($searches)) {
            $searches = [$searches];
        }

        $modifiers = [
            ['\/', ''],
            ['\(', '\)'],
            [' ', ''],
            ['', ''],
            [' \(', '\;'],
        ];

        /** @var $version string */
        $version   = $default;

        if (false !== strpos($useragent, '%')) {
            $useragent = urldecode($useragent);
        }

        foreach ($searches as $search) {
            if (!is_string($search)) {
                continue;
            }

            if (false !== strpos($search, '%')) {
                $search = urldecode($search);
            }

            foreach ($modifiers as $modifier) {
                $compareString = '/' . $search . $modifier[0] . '(\d+[\d\.\_ab]*)' . $modifier[1] . '/';

                $doMatch = preg_match(
                    $compareString,
                    $useragent,
                    $matches
                );

                if ($doMatch) {
                    $version = $matches[1];
                    break 2;
                }
            }
        }

        return self::set($version);
    }
}
