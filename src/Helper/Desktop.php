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

use BrowserDetector\Helper;
use Stringy\Stringy;

/**
 * a helper to detect Desktop devices
 */
class Desktop
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
     * @return \BrowserDetector\Helper\Desktop
     */
    public function __construct($useragent)
    {
        $this->useragent = $useragent;
    }

    public function isDesktopDevice()
    {
        if (preg_match('/firefox/i', $this->useragent) && preg_match('/anonym/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/trident/i', $this->useragent) && preg_match('/anonym/i', $this->useragent)) {
            return true;
        }

        $s = new Stringy($this->useragent);

        if ($s->containsAll(['windows nt', 'iphone', 'micromessenger'], false)) {
            return false;
        }

        // ignore mobile safari token if windows nt token is available
        if ($s->contains('windows nt', false)
            && $s->containsAny(['mobile safari', 'opera mobi', 'iphone'], false)
        ) {
            return true;
        }

        $noDesktops = [
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
            '<',
            '>',
        ];

        if ($s->containsAny($noDesktops, false)) {
            return false;
        }

        $othersDesktops = [
            'revolt',
            'akregator',
            'installatron',
            'lynx',
            'camino',
            'osf1',
            'barca',
            'the bat!',
        ];

        if ($s->containsAny($othersDesktops, false)) {
            return true;
        }

        if ((new Helper\Windows($this->useragent))->isWindows()) {
            return true;
        }

        if ((new Helper\Linux($this->useragent))->isLinux()) {
            return true;
        }

        if ((new Helper\Macintosh($this->useragent))->isMacintosh()) {
            return true;
        }

        $desktopCodes = [
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
        ];

        if (!$s->containsAny($desktopCodes, false)) {
            return false;
        }

        return true;
    }
}
