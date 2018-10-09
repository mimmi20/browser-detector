<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
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
     * @var \Stringy\Stringy the user agent to handle
     */
    private $useragent;

    /**
     * Class Constructor
     *
     * @param \Stringy\Stringy $useragent
     */
    public function __construct(Stringy $useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isLinux(): bool
    {
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
            'irix',
            'hpwos',
            'webos',
            'web0s',
            'remix',
            'msostatic',
        ];

        if ($this->useragent->containsAny($noLinux, false)) {
            return false;
        }

        if ($this->useragent->startsWith('juc', false)) {
            return false;
        }

        $linux = [
            // linux systems
            'linux',
            'debian',
            'raspbian',
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
            'windows aarch64',
            'moblin',
            'esx',
            'netcast',
            'kantonix',
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

        if (!$this->useragent->containsAny($linux, false)) {
            return false;
        }

        if (preg_match('/TBD\d{4}/', (string) $this->useragent)) {
            return false;
        }

        if (preg_match('/TBD[BC]\d{3,4}/', (string) $this->useragent)) {
            return false;
        }

        if (preg_match('/Puffin\/[\d\.]+[AIMW][PT]?/', (string) $this->useragent)) {
            return false;
        }

        return true;
    }
}
