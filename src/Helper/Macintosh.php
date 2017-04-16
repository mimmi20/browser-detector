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
            'macintosh',
            'darwin',
            'mac_powerpc',
            'macbook',
            'for mac',
            'ppc mac',
            'mac os x',
            '(macos)',
            'integrity',
            'camino',
            'pubsub',
            'os=mac',
            'imac',
            'macmini',
            'macpro',
            'powermac',
            'power%20macintosh',
        ];

        if (!$s->containsAny($mac, false)) {
            return false;
        }

        return true;
    }
}
