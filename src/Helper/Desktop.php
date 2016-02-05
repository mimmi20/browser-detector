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
use BrowserDetector\Helper\Windows as WindowsHelper;
use BrowserDetector\Helper\Linux as LinuxHelper;

/**
 * a helper to detect Desktop devices
 *
 * @package   BrowserDetector
 */
class Desktop
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
     * @param string $useragent
     *
     * @return \BrowserDetector\Helper\Desktop
     */
    public function __construct($useragent)
    {
        $this->utils = new Utils();

        $this->useragent = $useragent;
        $this->utils->setUserAgent($useragent);
    }

    public function isDesktopDevice()
    {
        $fakeHelper = new SpamCrawlerFake($this->useragent);

        if ($fakeHelper->isFakeBrowser() || $fakeHelper->isFakeWindows() || $fakeHelper->isFakeIe()) {
            return false;
        }

        if (preg_match('/firefox/i', $this->useragent) && preg_match('/anonym/i', $this->useragent)) {
            return true;
        }
        
        if (preg_match('/trident/i', $this->useragent) && preg_match('/anonym/i', $this->useragent)) {
            return true;
        }

        $noDesktops = array(
            'new-sogou-spider',
            'zollard',
            'socialradarbot',
            'microsoft office protocol discovery',
            'powermarks',
            'archivebot',
            'dino762',
            'marketwirebot',
            'microsoft-cryptoapi',
            'pad-bot',
            'terra_101',
            'butterfly',
            'james bot',
            'winhttp',
            'jobboerse',
        );

        if ($this->utils->checkIfContains($noDesktops, true)) {
            return false;
        }

        $othersDesktops = array(
            'revolt',
            'akregator',
            'installatron',
            'lynx',
        );

        if ($this->utils->checkIfContains($othersDesktops, true)) {
            return true;
        }

        $windowsHelper = new WindowsHelper($this->useragent);

        if ($windowsHelper->isWindows()) {
            return true;
        }

        $linuxHelper = new LinuxHelper($this->useragent);

        if ($linuxHelper->isLinux()) {
            return true;
        }

        $desktopCodes = array(
            // Mac
            'macintosh',
            'darwin',
            'mac_powerpc',
            'macbook',
            'for mac',
            'ppc mac',
            'mac os x',
            'imac',
            'macbookpro',
            'macbookair',
            'macbook',
            'macmini',
            // BSD
            'freebsd',
            'openbsd',
            'netbsd',
            'bsd four',
            // others
            'os/2',
            'warp',
            'sunos',
            'w3m',
            'google desktop',
            'eeepc',
            'dillo',
            'konqueror',
            'eudora',
            'masking-agent',
            'safersurf',
            'integrity',
            'davclnt',
            'cybeye',
            'google pp default',
            'microsoft office',
            'nsplayer',
            'msfrontpage',
            'ms frontpage',
        );

        if (!$this->utils->checkIfContains($desktopCodes, true)) {
            return false;
        }

        return true;
    }
}
