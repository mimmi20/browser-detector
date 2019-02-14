<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Helper;

final class MobileDevice implements MobileDeviceInterface
{
    /**
     * Returns true if the give $useragent is from a mobile device
     *
     * @param string $useragent
     *
     * @return bool
     */
    public function isMobile(string $useragent): bool
    {
        if (preg_match('/xbox|googletv|eeepc|smart-?tv|sonydtv|hbbtv|gxt_dongle_3188|apple tv|mxl661l32|nettv|crkey|lenovog780|windows iot|netcast|raspbian|bravia|tablet pc [12]\.|automobile|netgem|wordpress/i', $useragent)) {
            return false;
        }

        if (preg_match('/iphone.*windows nt.*micromessenger/i', $useragent)) {
            return true;
        }

        if (preg_match('/windows nt.*arm;/i', $useragent)) {
            return true;
        }

        // ignore mobile safari token if windows nt token is available
        if (preg_match('/windows nt.*(mobile safari|opera mobi|iphone)/i', $useragent)) {
            return false;
        }

        if (preg_match('/Puffin\/[\d\.]+WD/', $useragent)) {
            return false;
        }

        if (preg_match('/UCWEB|Puffin\/[\d\.]+[AIWM][TP]?|TBD\d{4}|TBD[BCG]\d{3,4}/', $useragent)) {
            return true;
        }

        if (preg_match('/mobile|tablet|phone|wireless|wpdesktop|zunewp7|xblwp7|android|iphone|ip[ao]d|samsung(?!browser)|tcl|j2me|micromax|htc|karbonn|hisense|docomo|siemens(?! a\/s|testmanager)|ktouch|portalmmm|rim tablet|jolla|iball|windows mobile|windows ce|symbos|symbian|remixos|webos|velocitymicro|samsung-(gt|sph)|lenovo|lumia|surftab|padfone|xda_diamond_2|transformer tf|touchpad|toshiba_ac_and_az|hpwos|silk|wap-browser|sailfish|crowsnest|folio_and_a|steelcore|m2 note|spice qt-75|spark284|lemon b556|terra_101|dino762|wetab|dataaccessd|mtk|lenovotablet|qtcarbrowser|onebrowser|stitcher|rss_?radio|antennapod|antenna\/|podcruncher|captivenetworksupport|ios;|audioboom.com\/boos|beyondpod|st80208|\[fban|wap2|up\.link|up\.browser|series ?[46]0|pocket ?pc|playstation|palm(?!a)|opera mobi|opera mini|openwave|obigo|nokia|nintendo|netfront|mqqbrowser|midp|meego|maemo|look-alike|linux armv|like mac os x|kindle|juc ?\(linux; ?u;|j2me|iuc\(u;ios|iris|hp-tablet|hd_mini_t|gingerbread|folio100|foma|firefox or ie|embider|danger hiptop|cldc|blazer|dalvik|brew(?!_)|bolt|blackberry|bb10|bada|aspen simulator|arm; touch|wap browser\/maui|kyy21/i', $useragent)) {
            return true;
        }

        return false;
    }
}
