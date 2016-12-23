<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <mimmi20@live.de>
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
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Helper;

use Stringy\Stringy;

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
        $s = new Stringy($this->useragent);

        if ($s->containsAll(['windows nt', 'iphone', 'micromessenger'], false)) {
            return false;
        }

        if ($s->containsAll(['windows nt', 'arm;'], false)) {
            return false;
        }

        // ignore mobile safari token if windows nt token is available
        if ($s->contains('windows nt', false)
            && $s->containsAny(['mobile safari', 'opera mobi', 'iphone'], false)
        ) {
            return true;
        }

        $isNotReallyAWindows = [
            // other OS and Mobile Windows
            'Linux',
            'Macintosh',
            'Mobi',
            'MSIE or Firefox mutant',
            'not on Windows server',
            'J2ME/MIDP',
            'PalmSource',
            '<',
            '>',
        ];

        if ($s->containsAny($isNotReallyAWindows, false)) {
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

        if (preg_match('/(DavClnt|revolt|Microsoft Outlook|WMPlayer|Lavf|NSPlayer)/', $this->useragent)) {
            return true;
        }

        $windows = [
            'win10',
            'win9',
            'win8',
            'win7',
            'winvista',
            'winxp',
            'win2000',
            'win98',
            'win95',
            'winnt',
            'win31',
            'winme',
            'windows nt',
            'windows 98',
            'windows 95',
            'windows 3.1',
            'win9x/nt 4.90',
            'windows xp',
            'windows me',
            'windows',
            'win32',
            'barca',
            'the bat!',
        ];

        if (!$s->containsAny($windows, false)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isMobileWindows()
    {
        if (preg_match('/Puffin\/[\d\.]+W(T|P)/', $this->useragent)) {
            return true;
        }

        $s = new Stringy($this->useragent);

        if ($s->containsAll(['windows nt', 'arm;'], false)) {
            return true;
        }

        $mobileWindows = [
            'windows ce',
            'windows phone',
            'windows mobile',
            'microsoft windows; ppc',
            'iemobile',
            'xblwp7',
            'zunewp7',
            'windowsmobile',
            'wpdesktop',
            'mobile version',
            'lumia',
        ];

        if (!$s->containsAny($mobileWindows, false)) {
            return false;
        }

        $isNotReallyAWindows = [
            // other OS
            'Linux',
            'Macintosh',
            'J2ME/MIDP',
        ];

        if ($s->containsAny($isNotReallyAWindows, false)) {
            return false;
        }

        return true;
    }
}
