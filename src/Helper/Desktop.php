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
        $s = new Stringy($this->useragent);

        if ($s->containsAll(['firefox', 'anonym'], false)) {
            return true;
        }

        if ($s->containsAll(['trident', 'anonym'], false)) {
            return true;
        }

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
            'online-versicherungsportal.info',
            'versicherungssuchmaschine.net',
            'crkey',
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
            'hp-ux',
            'hpux',
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
