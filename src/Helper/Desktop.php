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

use BrowserDetector\Helper;
use Stringy\Stringy;

/**
 * a helper to detect Desktop devices
 */
class Desktop
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
    public function isDesktopDevice(): bool
    {
        if ($this->useragent->containsAll(['firefox', 'anonym'], false)) {
            return true;
        }

        if ($this->useragent->containsAll(['trident', 'anonym'], false)) {
            return true;
        }

        if ($this->useragent->containsAll(['windows nt', 'iphone', 'micromessenger'], false)) {
            return false;
        }

        // ignore mobile safari token if windows nt token is available
        if ($this->useragent->contains('windows nt', false)
            && $this->useragent->containsAny(['mobile safari', 'opera mobi', 'iphone'], false)
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
            'online-versicherungsportal.info',
            'versicherungssuchmaschine.net',
            'crkey',
            'netcast',
        ];

        if ($this->useragent->containsAny($noDesktops, false)) {
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
            'hp-ux',
            'hpux',
            'beos',
        ];

        if ($this->useragent->containsAny($othersDesktops, false)) {
            return true;
        }

        if ((new Helper\Windows($this->useragent))->isWindows()) {
            return true;
        }

        if ((new Helper\Linux($this->useragent))->isLinux()) {
            return true;
        }

        // macOS
        if (preg_match('/macintosh|darwin|mac(_powerpc|book|mini|pro)|(for|ppc) mac|mac ?os|integrity|camino|pubsub|(os\=|i|power)mac/i', (string) $this->useragent)) {
            return true;
        }

        $desktopCodes = [
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

        if (!$this->useragent->containsAny($desktopCodes, false)) {
            return false;
        }

        return true;
    }
}
