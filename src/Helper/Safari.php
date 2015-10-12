<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Helper;

use UaHelper\Utils;

/**
 * a helper for detecting safari and some of his derefered browsers
 *
 * @package   BrowserDetector
 */
class Safari
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = '';

    /**
     * @var \UaHelper\Utils the helper class
     */
    private $utils = null;

    /**
     * Class Constructor
     *
     * @return \BrowserDetector\Helper\Safari
     */
    public function __construct()
    {
        $this->utils = new Utils();
    }

    /**
     * sets the user agent to be handled
     *
     * @param string $userAgent
     *
     * @return \BrowserDetector\Helper\Safari
     */
    public function setUserAgent($userAgent)
    {
        $this->useragent = $userAgent;
        $this->utils->setUserAgent($userAgent);

        return $this;
    }

    /**
     * @return bool
     */
    public function isSafari()
    {
        if (!$this->utils->checkIfContains('Mozilla/')
            && !$this->utils->checkIfContains('Safari')
            && !$this->utils->checkIfContains('Mobile')
        ) {
            return false;
        }

        if (!$this->utils->checkIfContains(array('Safari', 'AppleWebKit', 'CFNetwork'))) {
            return false;
        }

        $isNotReallyAnSafari = array(
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
            //mobile Version
            'Tablet',
            'Android',
            'Tizen',
            // Fakes
            'Mac; Mac OS '
        );

        if ($this->utils->checkIfContains($isNotReallyAnSafari, true)) {
            return false;
        }

        return true;
    }

    public function isMobileAsSafari()
    {
        if (!$this->isSafari()) {
            return false;
        }

        $mobileDeviceHelper = new MobileDevice();
        $mobileDeviceHelper->setUserAgent($this->useragent);

        if (!$mobileDeviceHelper->isMobile()) {
            return false;
        }

        if ($this->utils->checkIfContains(
            array('PLAYSTATION', 'Browser/AppleWebKit', 'CFNetwork', 'BlackBerry; U; BlackBerry')
        )
        ) {
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

        $regularVersions = array(
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
        );

        if (in_array(substr($detectedVersion, 0, 3), $regularVersions)) {
            return $detectedVersion;
        }

        return '';
    }
}
