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
class Windows
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
    public function isWindows(): bool
    {
        if ($this->useragent->containsAll(['windows nt', 'iphone', 'micromessenger'], false)) {
            return false;
        }

        // ignore mobile safari token if windows nt token is available
        if ($this->useragent->contains('windows nt', false)
            && $this->useragent->containsAny(['mobile safari', 'opera mobi', 'iphone'], false)
        ) {
            return true;
        }

        if ($this->isMobileWindows()) {
            return false;
        }

        $isNotReallyAWindows = [
            // other OS and Mobile Windows
            'linux',
            'macintosh',
            'mobi',
            'msie or firefox mutant',
            'not on windows server',
            'j2me',
            'palmsource',
            '<',
            '>',
            'aarch64',
        ];

        if ($this->useragent->containsAny($isNotReallyAWindows, false)) {
            return false;
        }

        if ($this->useragent->containsAll(['firefox', 'anonym'], false)) {
            return true;
        }

        if ($this->useragent->containsAll(['trident', 'anonym'], false)) {
            return true;
        }

        if (preg_match('/(DavClnt|revolt|Microsoft Outlook|WMPlayer|Lavf|NSPlayer)/', (string) $this->useragent)) {
            return true;
        }

        $windows = [
            'windows nt',
            'windows iot',
            'win10',
            'win9',
            'win8',
            'win7',
            'winvista',
            'winxp',
            'win2000',
            'win98',
            'win95',
            'winnt',
            'win31',
            'winme',
            'windows 98',
            'windows 95',
            'windows 3.1',
            'win9x/nt 4.90',
            'windows xp',
            'windows me',
            'windows',
            'win32',
            'barca',
            'the bat!',
            'cygwin',
        ];

        if (!$this->useragent->containsAny($windows, false)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isMobileWindows(): bool
    {
        $mobileWindows = [
            'windows ce',
            'windows phone',
            'windows iot',
            'windows mobile',
            'microsoft windows; ppc',
            'iemobile',
            'xblwp7',
            'zunewp7',
            'windowsmobile',
            'wpdesktop',
            'mobile version',
            'lumia',
            ' wds ',
            'wpos:',
        ];

        if (!$this->useragent->containsAny($mobileWindows, false)) {
            return false;
        }

        return true;
    }
}
