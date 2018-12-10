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

final class Tv
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
    public function isTvDevice(): bool
    {
        $tvDevices = [
            'boxee',
            'ce-html',
            'dlink.dsm380',
            'googletv',
            'hbbtv',
            'idl-6651n',
            'kdl40ex720',
            'netrangemmh',
            'loewe;',
            'smart-tv',
            'smarttv',
            'sonydtv',
            'viera',
            'xbox',
            'espial',
            'aquosbrowser',
            'gxt_dongle_3188',
            'lf1v307',
            'lf1v325',
            'lf1v373',
            'lf1v394',
            'lf1v401',
            'apple tv',
            'mxl661l32',
            'nettv',
            'netbox',
            'philipstv',
            'crkey',
            'metz',
            'omi/',
            'netcast',
        ];

        if ($this->useragent->containsAny($tvDevices, false)) {
            return true;
        }

        return false;
    }
}
