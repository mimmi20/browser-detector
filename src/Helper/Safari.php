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
class Safari
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
     * @return \BrowserDetector\Helper\Safari
     */
    public function __construct($useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isSafari()
    {
        $s = new Stringy($this->useragent);

        if (!$s->contains('Mozilla/')
            && !$s->contains('Safari')
            && !$s->contains('Mobile')
        ) {
            return false;
        }

        if (!$s->containsAny(['Safari', 'AppleWebKit', 'CFNetwork'])) {
            return false;
        }

        $isNotReallyAnSafari = [
            // using also the KHTML rendering engine
            '1Password',
            'AdobeAIR',
            'Arora',
            'BB10',
            'BlackBerry',
            'BrowserNG',
            'Chrome',
            'Chromium',
            'Coast',
            'Dolfin',
            'Dreamweaver',
            'Epiphany',
            'FBAN/',
            'FBAV/',
            'FBForIPhone',
            'Flock',
            'Galeon',
            'Google Earth',
            'iCab',
            'Iron',
            'konqueror',
            'Lunascape',
            'Maemo',
            'Maxthon',
            'MxBrowser',
            'Mercury',
            'Midori',
            'MQQBrowser',
            'NokiaBrowserInterface',
            'OmniWeb',
            'OPiOS',
            'Origin',
            'PaleMoon',
            'PhantomJS',
            'Qt',
            'QuickLook',
            'QupZilla',
            'rekonq',
            'Rockmelt',
            'Silk',
            'Shiira',
            'WebBrowser',
            'WebClip',
            'WeTab',
            'wOSBrowser',
            'Skyfire',
            'UCBrowser',
            'wkhtmltoimage',
            'wkhtmltopdf',
            'MicroMessenger',
            'DiigoBrowser',
            //Bots
            'GSA',
            'GoogleBot',
            'msnbot-media',
            'bingpreview',
            'spider-pig',
            'adsbot-google-mobile',
            'SMTBot',
            'Google Web Preview',
            'Google Page Speed Insights',
            'Google Markup Tester',
            'Mediapartners-Google',
            'bingbot',
            'adbeat',
            'profiller',
            'Kindle',
            'Slurp',
            'GINGERBREAD',
            'Nokia',
            'Twitter',
            'MobileTestLab',
            'Superbird',
            'ACHEETAHI',
            'Beamrise',
            'APUSBrowser',
            'Diglo',
            'Chedot',
            'kontact',
            //mobile Version
            'Tablet',
            'Android',
            'Tizen',
            // Fakes
            'Mac; Mac OS ',
        ];

        if ($s->containsAny($isNotReallyAnSafari, false)) {
            return false;
        }

        return true;
    }

    /**
     * maps different Safari Versions to a normalized format
     *
     * @param string $detectedVersion
     *
     * @return string
     */
    public function mapSafariVersions($detectedVersion)
    {
        if ($detectedVersion >= 10500) {
            $detectedVersion = '8.0';
        } elseif ($detectedVersion >= 9500) {
            $detectedVersion = '7.0';
        } elseif ($detectedVersion >= 8500) {
            $detectedVersion = '6.0';
        } elseif ($detectedVersion >= 7500) {
            $detectedVersion = '5.1';
        } elseif ($detectedVersion >= 6500) {
            $detectedVersion = '5.0';
        } elseif ($detectedVersion >= 1050) {
            $detectedVersion = '8.0';
        } elseif ($detectedVersion >= 950) {
            $detectedVersion = '7.0';
        } elseif ($detectedVersion >= 850) {
            $detectedVersion = '6.0';
        } elseif ($detectedVersion >= 750) {
            $detectedVersion = '5.1';
        } elseif ($detectedVersion >= 650) {
            $detectedVersion = '5.0';
        } elseif ($detectedVersion >= 500) {
            $detectedVersion = '4.0';
        }

        $regularVersions = [
            '3.0',
            '3.1',
            '3.2',
            '4.0',
            '4.1',
            '4.2',
            '4.3',
            '4.4',
            '5.0',
            '5.1',
            '5.2',
            '6.0',
            '6.1',
            '6.2',
            '7.0',
            '7.1',
            '8.0',
            '8.1',
        ];

        if (in_array(mb_substr($detectedVersion, 0, 3), $regularVersions)) {
            return $detectedVersion;
        }

        return '';
    }
}
