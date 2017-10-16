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
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class Macintosh
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
    public function isMacintosh(): bool
    {
        $noMac = [
            'freebsd',
            'raspbian',
        ];

        if ($this->useragent->containsAny($noMac, false)) {
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

        if (!$this->useragent->containsAny($mac, false)) {
            return false;
        }

        return true;
    }
}
