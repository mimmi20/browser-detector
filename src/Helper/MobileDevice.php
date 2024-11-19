<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Helper;

use function preg_match;

final class MobileDevice implements MobileDeviceInterface
{
    /**
     * Returns true if the give $useragent is from a mobile device
     *
     * @throws void
     */
    public function isMobile(string $useragent): bool
    {
        if (preg_match('/wpdesktop|zunewp7|xblwp7|windows (phone|mobile|ce)|polaris/i', $useragent)) {
            return true;
        }

        if (
            preg_match(
                '/xbox|googletv|eeepc|smart-?tv|sonydtv|hbbtv|gxt_dongle_3188|apple tv|mxl661l32|nettv|crkey|lenovog780|windows iot|netcast|raspbian|bravia|tablet pc [12]\.|automobile|netgem|wordpress|webos\.tv|lgwebostv|; ?lge? ?;(?!.*(sprint|boost))/i',
                $useragent,
            )
        ) {
            return false;
        }

        if (preg_match('/iphone.*windows nt.*micromessenger/i', $useragent)) {
            return true;
        }

        if (preg_match('/windows nt.*arm;/i', $useragent)) {
            return true;
        }

        // ignore mobile safari token if windows nt token is available
        if (preg_match('/windows nt.*(mobile safari|opera mobi|iphone|openwave)/i', $useragent)) {
            return false;
        }

        if (preg_match('/Puffin\/[\d\.]+WD/', $useragent)) {
            return false;
        }

        if (preg_match('/UCWEB|Puffin\/[\d\.]+[AIWM][TP]?|TBD\d{4}|TBD[BCG]\d{3,4}/', $useragent)) {
            return true;
        }

        if (preg_match('/fbid\/desktop/i', $useragent)) {
            return false;
        }

        return 0 < preg_match(
            '/mobile;|mobileok|-mobile|office mobile|tablet|(?<!a)phone|wireless|(?<!ninesky-)android|adr |iph(one|\d)|ip[ao]d|ipd\d|samsung(?!browser|-agent)|j2me|micromax|htc|karbonn|hisense|docomo|siemens(?! ?(a\/s|testmanager|lms|ag))|ktouch|portalmmm|rim tablet|jolla|iball|symbos|symbian|remixos|webos|velocitymicro|samsung-(gt|sph)|lenovo|lumia|surftab|padfone|xda_diamond_2|transformer tf|touchpad|toshiba_ac_and_az|hpwos|silk|wap-browser|sailfish|crowsnest|folio_and_a|steelcore|m2 note|spice qt-75|spark284|lemon b556|terra_101|dino762|wetab|dataaccessd|lenovotablet|qtcarbrowser|onebrowser|stitcher|rss_?radio|antennapod|antenna\/|podcruncher|captivenetworksupport|(?<!c)ios;|audioboom.com\/boos|beyondpod|st80208|\[fban|wap2|up\.link|up\.browser|series ?[46]0|pocket ?pc|playstation|palm(?!a)|opera mobi|opera mini|openwave|obigo|nokia|nintendo|netfront|mqqbrowser|midp|meego|maemo|look-alike|like mac os x|kindle|juc ?\(linux; ?u;|iuc\(u;ios|iris|hp-tablet|hd_mini_t|gingerbread|folio100|foma|firefox or ie|embider|danger hiptop|cldc|blazer|dalvik|bolt|blackberry|bb10; ?(kbd|touch)|\b(bada|brew|mtk)\b|\btcl\b(?! http client)|aspen simulator|arm; touch|wap browser|kyy21|ebrd1101|ebrd1201|huawei-u8651|(?<!i)tizen|tecno[ _]|sonyericsson|lg[ \-]|(?<!ma)cos ?\d|cricket|mz601|clt-l29|ios\.watch|nook browser|kddi|kyocera/i',
            $useragent,
        );
    }
}
