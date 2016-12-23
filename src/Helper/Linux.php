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
class Linux
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
     * @return \BrowserDetector\Helper\Linux
     */
    public function __construct($useragent)
    {
        $this->useragent = $useragent;
    }

    public function isLinux()
    {
        $s = new Stringy($this->useragent);

        $noLinux = [
            'loewe; sl121',
            'eeepc',
            'microsoft office',
            'microsoft outlook',
            'infegyatlas',
            'terra_101',
            'jobboerse',
            'msrbot',
            'cryptoapi',
            'velocitymicro',
            'gt-c3312r',
            'microsoft data access',
            'microsoft-webdav',
            'microsoft.outlook',
            'microsoft url control',
            'microsoft internet explorer',
            'commoncrawler',
            'freebsd',
            'netbsd',
            'openbsd',
            'bsd four',
            'microsearch',
            'juc(',
            'osf1',
            'solaris',
            'sunos',
            'infegyatlas',
            'jobboerse',
        ];

        if ($s->containsAny($noLinux, false)) {
            return false;
        }

        $linux = [
            // linux systems
            'linux',
            'debian',
            'ubuntu',
            'suse',
            'fedora',
            'mint',
            'redhat',
            'red hat',
            'slackware',
            'zenwalk gnu',
            'xentos',
            'kubuntu',
            'cros',
            'moblin',
            'esx',
            // browsers on linux
            'dillo',
            'gvfs',
            'libvlc',
            'lynx',
            'tinybrowser',
            // bots on linux
            'akregator',
            'installatron',
            // tv with linux
            'nettv',
            'hbbtv',
            'smart-tv',
            // general
            'x11',
        ];

        if (!$s->containsAny($linux, false)) {
            return false;
        }

        if (preg_match('/TBD\d{4}/', $this->useragent)) {
            return false;
        }

        if (preg_match('/TBD(B|C)\d{3,4}/', $this->useragent)) {
            return false;
        }

        if (preg_match('/Puffin\/[\d\.]+(A|I|W|M)(T|P)?/', $this->useragent)) {
            return false;
        }

        return true;
    }
}
