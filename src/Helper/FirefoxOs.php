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
 * a helper for detecting safari and some of his derefered browsers
 */
class FirefoxOs
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
    public function isFirefoxOs(): bool
    {
        if (!$this->useragent->startsWith('mozilla/', false)
            || !$this->useragent->containsAll(['rv:', 'gecko', 'firefox'], false)
            || $this->useragent->contains('android', false)
        ) {
            return false;
        }

        $doMatch = preg_match(
            '/^Mozilla\/5\.0 \(.*(Mobile|Tablet);.*rv:(\d+\.\d+).*\) Gecko\/(\d+).* Firefox\/(\d+\.\d+).*/',
            (string) $this->useragent
        );

        if (!$doMatch) {
            return false;
        }

        return true;
    }
}
