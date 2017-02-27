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
 */
class Tv
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
     * @return \BrowserDetector\Helper\Tv
     */
    public function __construct($useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isTvDevice()
    {
        $s = new Stringy($this->useragent);

        if ($s->containsAll(['windows nt', 'iphone', 'micromessenger'], false)) {
            return false;
        }

        $noDesktops = [
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

        if ($s->containsAny($noDesktops, false)) {
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
        ];

        if (!$s->containsAny($tvDevices, false)) {
            return false;
        }

        return true;
    }
}
