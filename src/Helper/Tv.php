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
 * a helper to detect TV devices
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class Tv
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
        if ($this->useragent->containsAll(['windows nt', 'iphone', 'micromessenger'], false)) {
            return false;
        }

        $noTvs = [
            'new-sogou-spider',
            'zollard',
            'socialradarbot',
            'microsoft office protocol discovery',
            'powermarks',
            'archivebot',
            'dino762',
            'marketwirebot',
            'microsoft-cryptoapi',
            'pad-bot',
            'terra_101',
            'butterfly',
            'james bot',
            'winhttp',
            'jobboerse',
            '<',
            '>',
        ];

        if ($this->useragent->containsAny($noTvs, false)) {
            return false;
        }

        $tvDevices = [
            'boxee',
            'ce-html',
            'dlink.dsm380',
            'googletv',
            'hbbtv',
            'idl-6651n',
            'kdl40ex720',
            'netrangemmh',
            'loewe; sl121',
            'loewe; sl150',
            'smart-tv',
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
        ];

        if (!$this->useragent->containsAny($tvDevices, false)) {
            return false;
        }

        return true;
    }
}
