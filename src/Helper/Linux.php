<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
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
            'android',
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
            'gt-i9100',
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
            'osf1',
            'solaris',
            'sunos',
            'infegyatlas',
            'jobboerse',
            'hp-ux',
            'hpux',
        ];

        if ($s->containsAny($noLinux, false)) {
            return false;
        }

        if ($s->startsWith('juc', false)) {
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
