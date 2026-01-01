<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Helper;

use Override;

use function preg_match;

final class Desktop implements DesktopInterface
{
    /**
     * Returns true if the give $useragent is from a desktop device
     *
     * @throws void
     */
    #[Override]
    public function isDesktopDevice(string $useragent): bool
    {
        if (
            preg_match(
                '/windows ?(phone|iot|mobile|ce)|iemobile|lumia|xblwp7|zunewp7|wpdesktop|mobile version|microsoft windows; ppc| wds |wpos:|netgem|xoom/i',
                $useragent,
            )
        ) {
            return false;
        }

        // Windows + Linux + macOS
        if (
            preg_match(
                '/davclnt|revolt|microsoft outlook|wmplayer|lavf|nsplayer|windows|win(10|8|7|vista|xp|2000|98|95|nt|3[12]|me|9x)|barca|cygwin|the bat!|linux|debian|ubuntu|cros|tinybrowser|red hat modified|fedora|gentoo|slackware|macintosh|darwin|mac(_powerpc|book|mini|pro)|(for|ppc) mac|mac ?os|integrity|camino|pubsub|(os\=|i|power)mac|syllable|morphos|dragonfly|charon|odyssey web browser|\(pc;|genix|ultrix|news-os|star-blade os|freebsd|openbsd|netbsd|bsd four|os\/2|warp|sunos|hp-?ux|beos|haiku|irix|solaris|openvms|aix|esx|unix|w3m|google desktop|eeepc|dillo|konqueror|eudora|masking-agent|safersurf|cybeye|google pp default|microsoft office|ms ?frontpage|akregator|installatron|lynx|osf1|libvlc|openvas|gvfs/i',
                $useragent,
            )
        ) {
            return true;
        }

        return (bool) preg_match(
            '/(?:CrOS [a-z0-9_]+ |.*Build\/R\d+-)\d{4,5}\.\d+\.\d+[^)]*\) .* Chrome\/\d+[\d.]+|(?:CrOS [a-z0-9_]+ |.*Build\/R\d+-)\d+[\d.]+/',
            $useragent,
        );
    }
}
