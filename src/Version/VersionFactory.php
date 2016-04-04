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

use Version\Stability;

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
        $matches = [];

        $regex = '/^' .
            'v?' .
            '(?:(\d+)[-|\.])?' .
            '(?:(\d+)[-|\.])?' .
            '(?:(\d+)[-|\.])?' .
            '(?:(\d+)\.)?' .
            '(?:(\d+))?' .
            '(?:' . Stability::REGEX . ')?' .
            '$/';

        if (preg_match($regex, $version, $matches)) {
            $numbers = self::mapMatches($matches);
        } else {
            $secondMatches = [];
            $secondRegex   = '/^' .
                'v?' .
                '(?:(\d+)[-|\.])?' .
                '(?:(\d+)[-|\.])?' .
                '(?:(\d+)[-|\.])?' .
                '(?:(\d+)\.)?' .
                '(?:(\d+))?' .
                '.*$/';

            if (!preg_match($secondRegex, $version, $secondMatches)) {
                return new Version();
            }

            $numbers = self::mapMatches($secondMatches);
        }

        if (empty($numbers)) {
            return new Version();
        }

        $major = (isset($numbers[0]) ? $numbers[0] : '0');
        $minor = (isset($numbers[1]) ? $numbers[1] : '0');
        $patch = (isset($numbers[2]) ? $numbers[2] : '0') . (isset($numbers[3]) ? '.' . $numbers[3] : '') . (isset($numbers[4]) ? '.' . $numbers[4] : '');

        $stability = (!empty($matches['6'])) ? $matches['6'] : null;

        if (strlen($stability) == 0) {
            $stability = 'stable';
        }
        $stability = strtolower($stability);
        switch ($stability) {
            case 'rc':
                $stability = 'RC';
                break;
            case 'patch':
            case 'pl':
            case 'p':
                $stability = 'patch';
                break;
            case 'beta':
            case 'b':
                $stability = 'beta';
                break;
            case 'alpha':
            case 'a':
                $stability = 'alpha';
                break;
            case 'dev':
            case 'd':
                $stability = 'dev';
                break;
        }

        $build = (!empty($matches['7'])) ? $matches['7'] : null;

        return new Version($major, $minor, $patch, $stability, $build);
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
                $compareString = '/' . $search . $modifier[0] . '(\d+[\d\.\_\-\+abcdehlprstv]*)' . $modifier[1] . '/i';

                $doMatch = preg_match(
                    $compareString,
                    $useragent,
                    $matches
                );

                if ($doMatch) {
                    $version = strtolower(str_replace('_', '.', $matches[1]));
                    break 2;
                }
            }
        }

        return self::set($version);
    }

    /**
     * @param array $matches
     *
     * @return array
     */
    private static function mapMatches(array $matches)
    {
        $numbers = [];

        if (isset($matches[1]) && strlen($matches[1]) > 0) {
            $numbers[] = $matches[1];
        }
        if (isset($matches[2]) && strlen($matches[2]) > 0) {
            $numbers[] = $matches[2];
        }
        if (isset($matches[3]) && strlen($matches[3]) > 0) {
            $numbers[] = $matches[3];
        }
        if (isset($matches[4]) && strlen($matches[4]) > 0) {
            $numbers[] = $matches[4];
        }
        if (isset($matches[5]) && strlen($matches[5]) > 0) {
            $numbers[] = $matches[5];
        }

        return $numbers;
    }
}
