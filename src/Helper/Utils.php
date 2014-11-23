<?php
/**
 * Copyright (c) 2012-2014, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Helper;

/**
 * a general helper
 *
 * @package   BrowserDetector
 */
class Utils
{
    /**
     * @var string the user agent to handle
     */
    private $_useragent = '';

    /**
     * sets the user agent to be handled
     *
     * @param $userAgent
     *
     * @return Utils
     */
    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;

        return $this;
    }

    /**
     * Returns true if $haystack contains $needle
     *
     * @param string $needle Needle
     * @param bool   $ci
     *
     * @return bool
     */
    public function checkIfContains($needle, $ci = false)
    {
        if (is_array($needle)) {
            foreach ($needle as $singleneedle) {
                if ($this->checkIfContains($singleneedle, $ci)) {
                    return true;
                }
            }

            return false;
        }

        if (!is_string($needle)) {
            return false;
        }

        if ($ci) {
            return stripos($this->_useragent, strtolower($needle)) !== false;
        }

        return strpos($this->_useragent, $needle) !== false;
    }

    /**
     * Returns true if $haystack contains all of the(string)needles in $needles
     *
     * @param array $needles Array of(string)needles
     * @param bool  $ci
     *
     * @return bool
     */
    public function checkIfContainsAll(array $needles = array(), $ci = false)
    {
        foreach ($needles as $needle) {
            if (!$this->checkIfContains($needle, $ci)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns true if $haystack starts with $needle
     *
     * @param string $needle Needle
     * @param bool   $ci
     *
     * @return bool
     */
    public function checkIfStartsWith($needle, $ci = false)
    {
        if (is_array($needle)) {
            foreach ($needle as $singleneedle) {
                if ($this->checkIfStartsWith($singleneedle, $ci)) {
                    return true;
                }
            }

            return false;
        }

        if (!is_string($needle)) {
            return false;
        }

        if ($ci) {
            return stripos($this->_useragent, $needle) === 0;
        }

        return strpos($this->_useragent, $needle) === 0;
    }
}
