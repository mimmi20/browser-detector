<?php


namespace BrowserDetector\Helper;

use Stringy\Stringy;

/**
 * a helper for detecting safari and some of his derefered browsers
 */
class FirefoxOs
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
     * @return \BrowserDetector\Helper\FirefoxOs
     */
    public function __construct($useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isFirefoxOs()
    {
        $s = new Stringy($this->useragent);

        if (!$s->startsWith('Mozilla/', false)
            || !$s->containsAll(['rv:', 'Gecko', 'Firefox'], false)
            || $s->contains('android', false)
        ) {
            return false;
        }

        $doMatch = preg_match('/^Mozilla\/5\.0 \(.*(Mobile|Tablet);.*rv:(\d+\.\d+).*\) Gecko\/(\d+).* Firefox\/(\d+\.\d+).*/', $this->useragent, $matches);

        if (!$doMatch) {
            return false;
        }

        return true;
    }
}
