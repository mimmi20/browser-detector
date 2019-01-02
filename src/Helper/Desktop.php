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

final class Desktop implements DesktopInterface
{
    /**
     * Returns true if the give $useragent is from a desktop device
     *
     * @param \Stringy\Stringy $useragent
     *
     * @return bool
     */
    public function isDesktopDevice(Stringy $useragent): bool
    {
        if (preg_match('/windows ?(phone|iot|mobile|ce)|iemobile|lumia|xblwp7|zunewp7|wpdesktop|mobile version|microsoft windows; ppc| wds |wpos:|netgem/i', (string) $useragent)) {
            return false;
        }

        // windows
        if (preg_match('/davclnt|revolt|microsoft outlook|wmplayer|lavf|nsplayer|windows|win(10|8|7|vista|xp|2000|98|95|nt|3[12]|me|9x)|barca|cygwin|the bat!/i', (string) $useragent)) {
            return true;
        }

        // linux
        if (preg_match('/linux|debian|ubuntu|cros|tinybrowser/i', (string) $useragent)) {
            return true;
        }

        // macOS
        if (preg_match('/macintosh|darwin|mac(_powerpc|book|mini|pro)|(for|ppc) mac|mac ?os|integrity|camino|pubsub|(os\=|i|power)mac/i', (string) $useragent)) {
            return true;
        }

        $othersDesktops = [
            // BSD
            'freebsd',
            'openbsd',
            'netbsd',
            'bsd four',
            // other platforms
            'os/2',
            'warp',
            'sunos',
            'hp-ux',
            'hpux',
            'beos',
            'irix',
            'solaris',
            'openvms',
            'aix',
            'esx',
            'unix',
            // desktop apps
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
            'revolt',
            'akregator',
            'installatron',
            'lynx',
            'camino',
            'osf1',
            'barca',
            'the bat!',
            'libvlc',
            'openvas',
            'gvfs',
        ];

        if ($useragent->containsAny($othersDesktops, false)) {
            return true;
        }

        return false;
    }
}
