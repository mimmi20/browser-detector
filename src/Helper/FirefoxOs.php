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
 * a helper for detecting safari and some of his derefered browsers
 *
 * @package   BrowserDetector
 */
class FirefoxOs
{
    /**
     * @var string the user agent to handle
     */
    private $_useragent = '';

    /**
     * @var \BrowserDetector\Helper\Utils the helper class
     */
    private $utils = null;

    /**
     * Class Constructor
     *
     * @return \BrowserDetector\Helper\FirefoxOs
     */
    public function __construct()
    {
        $this->utils = new Utils();
    }

    /**
     * sets the user agent to be handled
     *
     * @param string $userAgent
     *
     * @return \BrowserDetector\Helper\Safari
     */
    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        $this->utils->setUserAgent($userAgent);

        return $this;
    }

    /**
     * @return bool
     */
    public function isFirefoxOs()
    {
        if (!$this->utils->checkIfStartsWith('Mozilla/')
            || !$this->utils->checkIfContainsAll(array('rv:', 'Gecko', 'Firefox'))
        ) {
            return false;
        }

        $doMatch = preg_match('/^Mozilla\/5\.0 \(.*(Mobile|Tablet); rv:(\d+\.\d+).*\) Gecko\/(\d+\.\d+).* Firefox\/(\d+\.\d+).*/', $this->_useragent, $matches);

        if (!$doMatch) {
            return false;
        }

        return true;
    }
}