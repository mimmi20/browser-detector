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

namespace BrowserDetector\Helper;

use UaHelper\Utils;

/**
 * a helper to detect windows
 */
class Windows
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = '';

    /**
     * Class Constructor
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Helper\Windows
     */
    public function __construct($useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isWindows()
    {
        $utils = new Utils();
        $utils->setUserAgent($this->useragent);
        
        $isNotReallyAWindows = [
            // other OS and Mobile Windows
            'Linux',
            'Macintosh',
            'Mobi',
            'MSIE or Firefox mutant',
            'not on Windows server',
        ];

        if ($utils->checkIfContains($isNotReallyAWindows)) {
            return false;
        }

        if ($this->isMobileWindows()) {
            return false;
        }

        if (preg_match('/firefox/i', $this->useragent) && preg_match('/anonym/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/trident/i', $this->useragent) && preg_match('/anonym/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/(DavClnt|revolt|Microsoft Outlook|WMPlayer|Lavf)/', $this->useragent)) {
            return true;
        }

        $windows = [
            'win10', 'win9', 'win8', 'win7', 'winvista', 'winxp', 'win2000', 'win98', 'win95',
            'winnt', 'win31', 'winme', 'windows nt', 'windows 98', 'windows 95',
            'windows 3.1', 'win9x/nt 4.90', 'windows xp', 'windows me',
            'windows', 'win32',
        ];

        if (!$utils->checkIfContains($windows, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isMobileWindows()
    {
        $utils = new Utils();
        $utils->setUserAgent($this->useragent);

        $mobileWindows = [
            'windows ce', 'windows phone', 'windows mobile',
            'microsoft windows; ppc', 'iemobile', 'xblwp7', 'zunewp7',
            'windowsmobile', 'wpdesktop', 'mobile version', 'wpdesktop',
        ];

        if (!$utils->checkIfContains($mobileWindows, true)) {
            return false;
        }

        $isNotReallyAWindows = [
            // other OS
            'Linux',
            'Macintosh',
        ];

        if ($utils->checkIfContains($isNotReallyAWindows)) {
            return false;
        }

        return true;
    }
}
