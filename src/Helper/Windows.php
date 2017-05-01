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
class Windows
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
     * @return \BrowserDetector\Helper\Windows
     */
    public function __construct($useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isWindows()
    {
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
            'j2me/midp',
            'palmsource',
            '<',
            '>',
        ];

        if ($s->containsAny($isNotReallyAWindows, false)) {
            return false;
        }

        if (preg_match('/firefox/i', $this->useragent) && preg_match('/anonym/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/trident/i', $this->useragent) && preg_match('/anonym/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/(DavClnt|revolt|Microsoft Outlook|WMPlayer|Lavf|NSPlayer)/', $this->useragent)) {
            return true;
        }

        $windows = [
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
            'windows nt',
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
        ];

        if (!$s->containsAny($windows, false)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isMobileWindows()
    {
        $s = new Stringy($this->useragent);

        $mobileWindows = [
            'windows ce',
            'windows phone',
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
        ];

        if (!$s->containsAny($mobileWindows, false)) {
            return false;
        }

        return true;
    }
}
