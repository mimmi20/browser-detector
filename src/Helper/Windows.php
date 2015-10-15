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
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Helper;

use UaHelper\Utils;

/**
 * a helper to detect windows
 *
 * @package   BrowserDetector
 */
class Windows
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = '';

    /**
     * @var \UaHelper\Utils the helper class
     */
    private $utils = null;

    /**
     * Class Constructor
     *
     * @return \BrowserDetector\Helper\Windows
     */
    public function __construct()
    {
        $this->utils = new Utils();
    }

    /**
     * sets the user agent to be handled
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Helper\Windows
     */
    public function setUserAgent($useragent)
    {
        $this->useragent = $useragent;
        $this->utils->setUserAgent($useragent);

        return $this;
    }

    public function isWindows()
    {
        $isNotReallyAWindows = array(
            // other OS and Mobile Windows
            'Linux',
            'Macintosh',
            'Mobi'
        );

        $spamHelper = new SpamCrawlerFake();
        $spamHelper->setUserAgent($this->useragent);

        if ($this->utils->checkIfContains($isNotReallyAWindows)
            || (!$spamHelper->isAnonymized() && $spamHelper->isFakeWindows())
            || $this->isMobileWindows()
        ) {
            return false;
        }

        $windows = array(
            'win10', 'win9', 'win8', 'win7', 'winvista', 'winxp', 'win2000', 'win98', 'win95',
            'winnt', 'win31', 'winme', 'windows nt', 'windows 98', 'windows 95',
            'windows 3.1', 'win9x/nt 4.90', 'windows xp', 'windows me',
            'windows', 'win32'
        );

        if (!$this->utils->checkIfContains($windows, true)
            && !$this->utils->checkIfContains(array('trident', 'Microsoft', 'outlook', 'msoffice', 'ms-office'), true)
        ) {
            return false;
        }

        if ($this->utils->checkIfContains('trident', true)
            && !$this->utils->checkIfContains($windows, true)
        ) {
            return false;
        }

        return true;
    }

    public function isMobileWindows()
    {
        $mobileWindows = array(
            'windows ce', 'windows phone', 'windows mobile',
            'microsoft windows; ppc', 'iemobile', 'xblwp7', 'zunewp7',
            'windowsmobile', 'wpdesktop', 'mobile version', 'wpdesktop'
        );

        if (!$this->utils->checkIfContains($mobileWindows, true)) {
            return false;
        }

        $isNotReallyAWindows = array(
            // other OS
            'Linux',
            'Macintosh',
        );

        if ($this->utils->checkIfContains($isNotReallyAWindows)) {
            return false;
        }

        return true;
    }
}
