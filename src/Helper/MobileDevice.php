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
 * helper to get information if the device is a mobile
 */
class MobileDevice
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
     * Returns true if the give $useragent is from a mobile device
     *
     * @return bool
     */
    public function isMobile(): bool
    {
        $noMobiles = [
            'xbox',
            'badab',
            'badap',
            'simbar',
            'google-tr',
            'googlet',
            'google wireless transcoder',
            'eeepc',
            'i9988_custom',
            'i9999_custom',
            'wuid=',
            'smart-tv',
            'sonydtv',
            'hbbtv',
            'dolphin http client',
            'gxt_dongle_3188',
            'apple tv',
            'mxl661l32',
            'nettv',
            'commoncrawler',
            '<',
            '>',
            'ipodder',
            'tripadvisor',
            'nokia wap gateway',
            'crkey',
            'lenovog780',
            'windows iot',
        ];

        if ($this->useragent->containsAny($noMobiles, false)) {
            return false;
        }

        if ($this->useragent->containsAll(['windows nt', 'iphone', 'micromessenger'], false)) {
            return true;
        }

        if ($this->useragent->containsAll(['windows nt', 'arm;'], false)) {
            return true;
        }

        // ignore mobile safari token if windows nt token is available
        if ($this->useragent->contains('windows nt', false)
            && $this->useragent->containsAny(['mobile safari', 'opera mobi', 'iphone'], false)
        ) {
            return false;
        }

        /* @var array $mobiles Collection of mobile browser keywords */
        $mobiles = [
            'android',
            'arm; touch',
            'aspen simulator',
            'bada',
            'bb10',
            'blackberry',
            'blazer',
            'bolt',
            'brew',
            'cldc',
            'dalvik',
            'danger hiptop',
            'embider',
            'firefox or ie',
            'foma',
            'folio100',
            'gingerbread',
            'hd_mini_t',
            'hp-tablet',
            'hpwOS',
            'htc',
            'ipad',
            'iphone',
            'iphoneosx',
            'iphone os',
            'ipod',
            'iris',
            'iuc(u;ios',
            'j2me',
            'juc(linux;u;',
            'juc (linux; u;',
            'kindle',
            'lenovo',
            'like mac os x',
            'linux armv',
            'look-alike',
            'maemo',
            'meego',
            'midp',
            'mobile version',
            'mobile safari',
            'mqqbrowser',
            'netfront',
            'nintendo',
            'nokia',
            'obigo',
            'openwave',
            'opera mini',
            'opera mobi',
            'palm',
            'phone',
            'playstation',
            'pocket pc',
            'pocketpc',
            'rim tablet',
            'samsung',
            'series40',
            'series 60',
            'silk',
            'symbian',
            'symbianos',
            'symbos',
            'toshiba_ac_and_az',
            'touchpad',
            'transformer tf',
            'up.browser',
            'up.link',
            'xblwp7',
            'wap2',
            'webos',
            'wetab-browser',
            'windows ce',
            'windows mobile',
            'windows phone os',
            'wireless',
            'xda_diamond_2',
            'zunewp7',
            'wpdesktop',
            'jolla',
            'sailfish',
            'padfone',
            'st80208',
            'mtk',
            'onebrowser',
            'qtcarbrowser',
            'wap browser/maui',
            'wetab',
            '[fban',
            'dataaccessd',
            'crowsnest',
            'wap-browser',
            'dino762',
            'iball',
            'terra_101',
            'ktouch',
            'lemon b556',
            'spark284',
            'spice qt-75',
            'velocitymicro',
            'lumia',
            'surftab',
            'folio_and_a',
            'docomo',
            'portalmmm',
            'hisense',
            'siemens',
            'karbonn',
            'm2 note',
            'lenovotablet',
            'remixos',
            'micromax',
        ];

        if ($this->useragent->containsAny($mobiles, false)) {
            return true;
        }

        if ($this->useragent->contains('UCWEB', true)) {
            return true;
        }

        if ($this->useragent->contains('tablet', false)
            && !$this->useragent->contains('tablet pc', false)
        ) {
            return true;
        }

        if ($this->useragent->contains('mobile', false)
            && !$this->useragent->contains('automobile', false)
        ) {
            return true;
        }

        if (preg_match('/Puffin\/[\d\.]+[AIWM][TP]?/', (string) $this->useragent)) {
            return true;
        }

        if ((new AndroidOs($this->useragent))->isAndroid()) {
            return true;
        }

        if ((new Ios($this->useragent))->isIos()) {
            return true;
        }

        if (preg_match('/TBD\d{4}/', (string) $this->useragent)) {
            return true;
        }

        if (preg_match('/TBD[BCG]\d{3,4}/', (string) $this->useragent)) {
            return true;
        }

        return false;
    }
}
