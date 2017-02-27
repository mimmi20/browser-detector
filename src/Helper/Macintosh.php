<?php


namespace BrowserDetector\Helper;

use Stringy\Stringy;

/**
 * a helper to detect windows
 */
class Macintosh
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
     * @return \BrowserDetector\Helper\Macintosh
     */
    public function __construct($useragent)
    {
        $this->useragent = $useragent;
    }

    public function isMacintosh()
    {
        $s = new Stringy($this->useragent);

        $noMac = [
            'freebsd',
            'raspbian',
        ];

        if ($s->containsAny($noMac, false)) {
            return false;
        }

        $mac = [
            'Macintosh',
            'Darwin',
            'Mac_PowerPC',
            'MacBook',
            'for Mac',
            'PPC Mac',
            'Mac OS X',
            '(MacOS)',
            'integrity',
            'camino',
            'pubsub',
        ];

        if (!$s->containsAny($mac, false)) {
            return false;
        }

        return true;
    }
}
