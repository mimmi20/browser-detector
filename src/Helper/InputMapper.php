<?php
/**
 * Copyright (c) 2012-2014, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Helper;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Detector\Version;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class InputMapper
{
    /**
     * mapps the browser
     *
     * @param string $browserInput
     *
     * @throws \UnexpectedValueException
     * @return string
     */
    public function mapBrowserName($browserInput)
    {
        if (null === $browserInput) {
            return null;
        }

        if (!is_string($browserInput)) {
            throw new \UnexpectedValueException(
                'a string is required as input in this function'
            );
        }

        $browserName = $browserInput;

        switch (strtolower($browserInput)) {
            case 'unknown':
            case 'other':
            case 'default browser':
            case 'generic':
                $browserName = null;
                break;
            case 'ie':
                $browserName = 'Internet Explorer';
                break;
            case 'iceweasel':
                $browserName = 'Iceweasel';
                break;
            case 'mobile safari':
                $browserName = 'Safari';
                break;
            case 'chrome mobile':
            case 'chrome mobile ios':
            case 'chrome frame':
                $browserName = 'Chrome';
                break;
            case 'android':
            case 'android browser':
                $browserName = 'Android Webkit';
                break;
            case 'googlebot':
                $browserName = 'Google Bot';
                break;
            case 'bingbot':
                $browserName = 'BingBot';
                break;
            case 'jakarta commons-httpclient':
                $browserName = 'Jakarta Commons HttpClient';
                break;
            case 'adsbot-google':
                $browserName = 'AdsBot Google';
                break;
            case 'seokicks-robot':
                $browserName = 'SEOkicks Robot';
                break;
            case 'gomeza':
            case 'gomezagent':
                $browserName = 'Gomez Site Monitor';
                break;
            case 'yandex.browser':
                $browserName = 'Yandex Browser';
                break;
            case 'ie mobile':
                $browserName = 'IEMobile';
                break;
            case 'ovi browser':
                $browserName = 'Nokia Proxy Browser';
                break;
            case 'firefox mobile':
            case 'mobile firefox mobile':
            case 'mobile firefox tablet':
            case 'mobile firefox':
                $browserName = 'Firefox';
                break;
            case 'dolfin/jasmine webkit':
            case 'dolphin':
                $browserName = 'Dolfin';
                break;
            case 'facebookexternalhit':
            case 'facebookbot':
                $browserName = 'FaceBook Bot';
                break;
            case 'java':
                $browserName = 'Generic Java Crawler';
                break;
            case 'nokia web browser':
                $browserName = 'Nokia Browser';
                break;
            case 'applemail':
                $browserName = 'Apple Mail';
                break;
            case 'sistrix':
                $browserName = 'Sistrix Crawler';
                break;
            case 'blackberry webkit':
            case 'blackberry browser':
                $browserName = 'BlackBerry';
                break;
            default:
                // nothing to do here
                break;
        }

        return $browserName;
    }

    /**
     * maps the browser version
     *
     * @param string $browserVersion
     * @param string $browserName
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function mapBrowserVersion($browserVersion, $browserName = null)
    {
        switch (strtolower($browserVersion)) {
            case 'unknown':
            case 'other':
                $browserVersion = null;
                break;
            default:
                // nothing to do here
                break;
        }

        switch (strtolower($browserName)) {
            case '':
            case 'unknown':
            case 'other':
                $browserVersion = null;
                break;
            default:
                // nothing to do here
                break;
        }

        $version = new Version();
        $version->setMode(
            Version::COMPLETE | Version::IGNORE_MINOR_IF_EMPTY | Version::IGNORE_MICRO_IF_EMPTY
        );

        return $version->setVersion($browserVersion);
    }

    /**
     * maps the browser type
     *
     * @param string $browserType
     * @param string $browserName
     *
     * @return BrowserType\TypeInterface
     */
    public function mapBrowserType($browserType, $browserName = null)
    {
        switch (strtolower($browserType)) {
            case 'mobile browser':
                $browserType = new BrowserType\Browser();
                break;
            case 'robot':
            case 'bot/crawler':
            case 'library':
                $browserType = new BrowserType\Bot();
                break;
            case '':
            case 'unknown':
            case 'other':
                $browserType = new BrowserType\Unknown();
                break;
            case 'email client':
                $browserType = new BrowserType\EmailClient();
                break;
            case 'feed reader':
                $browserType = new BrowserType\FeedReader();
                break;
            case 'multimedia player':
                $browserType = new BrowserType\MultimediaPlayer();
                break;
            case 'offline browser':
                $browserType = new BrowserType\OfflineBrowser();
                break;
            case 'useragent anonymizer':
                $browserType = new BrowserType\UseragentAnonymizer();
                break;
            case 'wap browser':
                $browserType = new BrowserType\WapBrowser();
                break;
            default:
                switch (strtolower($browserName)) {
                    case 'unknown':
                    case 'other':
                    case '':
                        $browserType = new BrowserType\Unknown();
                        break;
                    default:
                        $typeClass = '\\BrowserDetector\\Detector\\Type\\Browser\\' . $browserType;

                        $browserType = new $typeClass();
                        break;
                }
                break;
        }

        return $browserType;
    }

    /**
     * maps the maker of the browser, os, engine or device
     *
     * @param string $maker
     *
     * @return string
     */
    private function mapMaker($maker)
    {
        switch (strtolower(trim($maker))) {
            case '':
            case 'unknown':
            case 'other':
            case 'software in the public interest, inc.':
            case 'bot':
            case 'various':
                $maker = null;
                break;
            case 'microsoft corporation.':
                $maker = 'Microsoft Corporation';
                break;
            case 'apple inc.':
            case 'apple computer, inc.':
                $maker = 'Apple Inc';
                break;
            case 'google':
            case 'google inc.':
            case 'google, inc.':
                $maker = 'Google Inc';
                break;
            case 'lunascape & co., ltd.':
                $maker = 'Lunascape Corporation';
                break;
            case 'opera software asa.':
                $maker = 'Opera Software ASA';
                break;
            case 'sun microsystems, inc.':
                $maker = 'Oracle';
                break;
            case 'postbox, inc.':
                $maker = 'Postbox Inc';
                break;
            case 'comodo group, inc.':
                $maker = 'Comodo Group Inc';
                break;
            case 'canonical ltd.':
                $maker = 'Canonical Ltd';
                break;
            case 'gentoo foundation, inc.':
                $maker = 'Gentoo Foundation Inc';
                break;
            case 'omni development, inc.':
                $maker = 'Omni Development Inc';
                break;
            case 'slackware linux, inc.':
                $maker = 'Slackware Linux Inc';
                break;
            case 'red hat, inc.':
                $maker = 'Red Hat Inc';
                break;
            default:
                // nothing to do here
                break;
        }

        return $maker;
    }

    /**
     * maps the browser maker
     *
     * @param string $browserMaker
     * @param string $browserName
     *
     * @return string
     */
    public function mapBrowserMaker($browserMaker, $browserName = null)
    {
        $browserMaker = $this->mapMaker($browserMaker);

        switch (strtolower($browserName)) {
            case 'unknown':
            case 'other':
            case '':
                $browserMaker = null;
                break;
            default:
                // nothing to do here
                break;
        }

        return $browserMaker;
    }

    /**
     * maps the name of the operating system
     *
     * @param string $osName
     *
     * @return string
     */
    public function mapOsName($osName)
    {
        switch (strtolower($osName)) {
            case '':
            case 'unknown':
            case 'other':
                $osName = null;
                break;
            case 'winxp':
            case 'win7':
            case 'win8':
            case 'win8.1':
            case 'win9':
            case 'win10':
            case 'winvista':
            case 'win2000':
            case 'win2003':
            case 'win98':
            case 'win95':
            case 'winnt':
                $osName = 'Windows';
                break;
            case 'winphone7':
            case 'winphone7.5':
            case 'winphone8':
            case 'winphone8.1':
            case 'windows phone 7':
                $osName = 'Windows Phone OS';
                break;
            case 'winrt8':
            case 'winrt8.1':
                $osName = 'Windows RT';
                break;
            case 'blackberry os':
                $osName = 'RIM OS';
                break;
            case 'macosx':
            case 'os x':
                $osName = 'Mac OS X';
                break;
            case 'jvm':
            case 'java':
                $osName = 'Java';
                break;
            case 'bada os':
                $osName = 'Bada';
                break;
            case 'symbianos':
                $osName = 'Symbian OS';
                break;
            default:
                // nothing to do here
                break;
        }

        return $osName;
    }

    /**
     * maps the maker of the operating system
     *
     * @param string $osMaker
     * @param string $osName
     *
     * @return string
     */
    public function mapOsMaker($osMaker, $osName = null)
    {
        $osMaker = $this->mapMaker($osMaker);

        switch (strtolower($osName)) {
            case '':
            case 'unknown':
            case 'other':
                $osMaker = null;
                break;
            default:
                // nothing to do here
                break;
        }

        return $osMaker;
    }

    /**
     * maps the version of the operating system
     *
     * @param string $osVersion
     * @param string $osName
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function mapOsVersion($osVersion, $osName = null)
    {
        switch (strtolower($osVersion)) {
            case '':
            case 'unknown':
            case 'other':
                $osVersion = null;
                break;
            default:
                // nothing to do here
                break;
        }

        switch (strtolower($osName)) {
            case '':
            case 'unknown':
            case 'other':
                $osVersion = null;
                break;
            case 'winxp':
                $osVersion = 'XP';
                break;
            case 'win7':
            case 'winphone7':
            case 'windows phone 7':
                $osVersion = '7';
                break;
            case 'winphone7.5':
            case 'windows phone 7.5':
                $osVersion = '7.5';
                break;
            case 'win8':
            case 'winrt8':
            case 'winphone8':
            case 'windows phone 8':
                $osVersion = '8';
                break;
            case 'win8.1':
            case 'winrt8.1':
            case 'winphone8.1':
            case 'windows phone 8.1':
                $osVersion = '8.1';
                break;
            case 'win9':
                $osVersion = '9';
                break;
            case 'win10':
                $osVersion = '10';
                break;
            case 'winvista':
                $osVersion = 'Vista';
                break;
            case 'win2000':
                $osVersion = '2000';
                break;
            case 'win2003':
                $osVersion = '2003';
                break;
            case 'win98':
                $osVersion = '98';
                break;
            case 'win95':
                $osVersion = '95';
                break;
            case 'winnt':
                $osVersion = 'NT';
                break;
            default:
                // nothing to do here
                break;
        }

        $version = new Version();
        $version->setMode(
            Version::COMPLETE | Version::IGNORE_MINOR_IF_EMPTY | Version::IGNORE_MICRO_IF_EMPTY
        );

        return $version->setVersion($osVersion);
    }

    /**
     * maps the name of a device
     *
     * @param string $deviceType
     *
     * @return DeviceType\TypeInterface
     */
    public function mapDeviceType($deviceType)
    {
        switch (strtolower($deviceType)) {
            case 'smart-tv':
            case 'tv device':
                $deviceType = new DeviceType\Tv();
                break;
            case 'desktop':
                $deviceType = new DeviceType\Desktop();
                break;
            case 'fonepad':
                $deviceType = new DeviceType\FonePad();
                break;
            case 'tablet':
                $deviceType = new DeviceType\Tablet();
                break;
            case 'mobile phone':
                $deviceType = new DeviceType\MobilePhone();
                break;
            case 'mobile device':
                $deviceType = new DeviceType\MobileDevice();
                break;
            case 'robot':
                $deviceType = new DeviceType\Bot();
                break;
            case 'smartphone':
                $deviceType = new DeviceType\Smartphone();
                break;
            case 'feature phone':
                $deviceType = new DeviceType\FeaturePhone();
                break;
            case '':
            case 'unknown':
            case 'other non-mobile':
            default:
                $deviceType = new DeviceType\Unknown();
                break;
        }

        return $deviceType;
    }

    /**
     * maps the name of a device
     *
     * @param string $deviceName
     *
     * @return string
     */
    public function mapDeviceName($deviceName)
    {
        switch (strtolower($deviceName)) {
            case '':
            case 'pc':
            case 'android':
            case 'unknown':
            case 'other':
                $deviceName = null;
                break;
            case 'android 1.6':
            case 'android 2.0':
            case 'android 2.1':
            case 'android 2.2':
            case 'android 2.3':
            case 'android 3.0':
            case 'android 3.1':
            case 'android 3.2':
            case 'android 4.0':
            case 'android 4.1':
            case 'android 4.2':
            case 'android 4.3':
            case 'android 4.4':
            case 'android 4.1 tablet':
            case 'android 4.2 tablet':
            case 'android 4.3 tablet':
            case 'android 4.4 tablet':
            case 'disguised as macintosh':
            case 'mini 1':
            case 'mini 4':
            case 'mini 5':
            case 'mini 7':
            case 'windows mobile 6.5':
            case 'windows mobile 7':
            case 'windows mobile 7.5':
            case 'windows phone 7':
            case 'windows phone 7.5':
            case 'windows phone 8':
            case 'fennec tablet':
            case 'tablet on android':
            case 'fennec':
            case 'opera for series 60':
            case 'opera mini for s60':
            case 'windows mobile (opera)':
            case 'mobi for android':
            case 'nokia unrecognized ovi browser':
            case 'mozilla firefox for android':
            case 'firefox for android tablet':
            case 'firefox for android':
                $deviceName = 'general Mobile Device';
                break;
            case 'spider':
                $deviceName = 'general Bot';
                break;
            // Motorola
            case 'motomz616':
                $deviceName = 'MZ616';
                break;
            case 'motoxt610':
                $deviceName = 'XT610';
                break;
            case 'motxt912b':
                $deviceName = 'XT912B';
                break;
            // LG
            case 'lg/c550/v1.0':
                $deviceName = 'C550';
                break;
            // Samsung
            case 'gt s8500':
                $deviceName = 'GT-S8500';
                break;
            case 'gp-p6810':
                $deviceName = 'GT-P6810';
                break;
            case 'gt-i8350':
                $deviceName = 'GT-I8350';
                break;
            case 'gt-i9100':
                $deviceName = 'GT-I9100';
                break;
            case 'gt-i9300':
            case 'samsung gt-i9300/i9300xxdlih':
                $deviceName = 'GT-I9300';
                break;
            case 'gt-i5500':
                $deviceName = 'GT-I5500';
                break;
            case 'gt i7500':
                $deviceName = 'GT-I7500';
                break;
            case 'gt-p5110':
                $deviceName = 'GT-P5110';
                break;
            case 'gt s5620':
                $deviceName = 'GT-S5620';
                break;
            case 'sch-i699':
                $deviceName = 'SCH-I699';
                break;
            case 'sgh-i957':
                $deviceName = 'SGH-I957';
                break;
            case 'sgh-i900v':
                $deviceName = 'SGH-I900V';
                break;
            case 'sgh-i917':
                $deviceName = 'SGH-I917';
                break;
            case 'sgh i900':
                $deviceName = 'SGH-I900';
                break;
            case 'sph-930':
                $deviceName = 'SPH-M930';
                break;
            // Acer
            case 'acer e310':
                $deviceName = 'E310';
                break;
            case 'acer e320':
                $deviceName = 'E320';
                break;
            // HTC
            case 'sensationxe beats z715e':
                $deviceName = 'Sensation XE Beats Z715e';
                break;
            case 's510b':
                $deviceName = 'S510B';
                break;
            case 'htc desire sv':
                $deviceName = 'Desire SV';
                break;
            // Asus
            case 'asus-padfone':
                $deviceName = 'PadFone';
                break;
            case 'memopad smart 10':
            case 'memo pad smart 10':
                $deviceName = 'MeMO Pad Smart 10';
                break;
            // Creative
            case 'creative ziio7':
                $deviceName = 'ZiiO7';
                break;
            // HP
            case 'touchpad':
                $deviceName = 'Touchpad';
                break;
            // Huawei
            case 'u8800':
                $deviceName = 'U8800';
                break;
            // Amazon
            case 'd01400':
                $deviceName = 'Kindle';
                break;
            // Nokia
            case 'nokia asha 201':
                $deviceName = 'Asha 201';
                break;
            // Medion
            case 'p9514':
                $deviceName = 'LifeTab P9514';
                break;
            case 'lifetab s9512':
                $deviceName = 'LifeTab S9512';
                break;
            default:
                // nothing to do here
                break;
        }

        return $deviceName;
    }

    /**
     * maps the maker of a device
     *
     * @param string $deviceMaker
     * @param string $deviceName
     *
     * @return string
     */
    public function mapDeviceMaker($deviceMaker, $deviceName = null)
    {
        $deviceMaker = $this->mapMaker($deviceMaker);

        switch (strtolower($deviceName)) {
            case '':
            case 'unknown':
            case 'other':
            case 'various':
            case 'android 1.6':
            case 'android 2.0':
            case 'android 2.1':
            case 'android 2.2':
            case 'android 2.3':
            case 'android 3.0':
            case 'android 3.1':
            case 'android 3.2':
            case 'android 4.0':
            case 'android 4.1':
            case 'android 4.2':
            case 'android 4.3':
            case 'disguised as macintosh':
            case 'mini 1':
            case 'mini 4':
            case 'mini 5':
            case 'windows mobile 6.5':
            case 'windows mobile 7':
            case 'windows mobile 7.5':
            case 'windows phone 7':
            case 'windows phone 8':
            case 'fennec tablet':
            case 'tablet on android':
            case 'fennec':
            case 'opera for series 60':
            case 'opera mini for s60':
            case 'windows mobile (opera)':
            case 'mobi for android':
            case 'mozilla firefox for android':
            case 'firefox for android tablet':
            case 'firefox for android':
                $deviceMaker = null;
                break;
            // Motorola
            case 'motomz616':
            case 'motoxt610':
            case 'motxt912b':
                $deviceMaker = 'Motorola';
                break;
            // LG
            case 'lg/c550/v1.0':
                $deviceMaker = 'LG';
                break;
            // Samsung
            case 'gt s8500':
            case 'gp-p6810':
            case 'gt-i8350':
            case 'gt-i9001':
            case 'gt-i9100':
            case 'gt-i9300':
            case 'samsung gt-i9300/i9300xxdlih':
            case 'gt i7500':
            case 'gt-p5110':
            case 'gt s5620':
            case 'sch-i699':
            case 'sgh-i917':
            case 'sgh-i957':
            case 'sgh-i900v':
            case 'sgh i900':
            case 'sph-930':
                $deviceMaker = 'Samsung';
                break;
            // Acer
            case 'acer e310':
            case 'acer e320':
                $deviceMaker = 'Acer';
                break;
            // HTC
            case 'sensationxe beats z715e':
            case 's510b':
            case 'htc desire sv':
                $deviceMaker = 'HTC';
                break;
            // Asus
            case 'asus-padfone':
                $deviceMaker = 'Asus';
                break;
            // Creative
            case 'creative ziio7':
                $deviceMaker = 'Creative';
                break;
            // HP
            case 'touchpad':
                $deviceMaker = 'HP';
                break;
            // Huawei
            case 'u8800':
                $deviceMaker = 'Huawei';
                break;
            // Amazon
            case 'd01400':
                $deviceMaker = 'Amazon';
                break;
            // Nokia
            case 'nokia asha 201':
            case 'nokia unrecognized ovi browser':
                $deviceMaker = 'Nokia';
                break;
            // Medion
            case 'p9514':
            case 'lifetab p9514':
            case 'lifetab s9512':
                $deviceMaker = 'Medion';
                break;
            // Apple
            case 'ipad':
            case 'iphone':
                $deviceMaker = 'Apple Inc';
                break;
            default:
                // nothing to do here
                break;
        }

        return $deviceMaker;
    }

    /**
     * maps the marketing name of a device
     *
     * @param string $marketingName
     * @param string $deviceName
     *
     * @return string
     */
    public function mapDeviceMarketingName($marketingName, $deviceName = null)
    {
        switch (strtolower($marketingName)) {
            case '':
            case 'unknown':
            case 'other':
                $marketingName = null;
                break;
            case 'lg optimus chat':
                $marketingName = 'Optimus Chat';
                break;
            case 't mobile move balance':
                $marketingName = 'T-Mobile Move Balance';
                break;
            case 'xperia arc so-01c for docomo':
                $marketingName = 'Xperia Arc SO-01C for DoCoMo';
                break;
            case 'galaxy sii':
                $marketingName = 'Galaxy S II';
                break;
            case 'galaxy sii plus':
                $marketingName = 'Galaxy S II Plus';
                break;
            case 'galaxy siii':
            case 'galaxy s3':
                $marketingName = 'Galaxy S III';
                break;
            case 'galaxy s3 lte international':
                $marketingName = 'Galaxy S III LTE International';
                break;
            default:
                // nothing to do here
                break;
        }

        switch (strtolower($deviceName)) {
            case '':
            case 'unknown':
            case 'other':
            case 'various':
            case 'android 1.6':
            case 'android 2.0':
            case 'android 2.1':
            case 'android 2.2':
            case 'android 2.3':
            case 'android 3.0':
            case 'android 3.1':
            case 'android 3.2':
            case 'android 4.0':
            case 'android 4.1':
            case 'android 4.2':
            case 'android 4.3':
            case 'disguised as macintosh':
            case 'mini 1':
            case 'mini 4':
            case 'mini 5':
            case 'windows mobile 6.5':
            case 'windows mobile 7':
            case 'windows mobile 7.5':
            case 'windows phone 7':
            case 'windows phone 8':
            case 'fennec tablet':
            case 'tablet on android':
            case 'fennec':
            case 'opera for series 60':
            case 'opera mini for s60':
            case 'windows mobile (opera)':
            case 'mobi for android':
            case 'nokia unrecognized ovi browser':
            case 'mozilla firefox for android':
            case 'firefox for android tablet':
            case 'firefox for android':
                $marketingName = null;
                break;
            // Acer
            case 'acer e320':
                $marketingName = 'Liquid Express';
                break;
            // HP
            case 'touchpad':
                $marketingName = 'Touchpad';
                break;
            // Medion
            case 'p9514':
            case 'lifetab p9514':
                $marketingName = 'LifeTab P9514';
                break;
            case 'lifetab s9512':
                $marketingName = 'LifeTab S9512';
                break;
            // HTC
            case 'htc desire sv':
                $marketingName = 'Desire SV';
                break;
            // Apple
            case 'ipad':
                $marketingName = 'iPad';
                break;
            case 'iphone':
                $marketingName = 'iPhone';
                break;
            default:
                // nothing to do here
                break;
        }

        return $marketingName;
    }

    /**
     * maps the brand name of a device
     *
     * @param string $brandName
     * @param string $deviceName
     *
     * @return string
     */
    public function mapDeviceBrandName($brandName, $deviceName = null)
    {
        switch (strtolower($brandName)) {
            case 'htc corporation':
                $brandName = 'HTC';
                break;
            case '':
            case 'unknown':
            case 'other':
            case 'generic':
                $brandName = null;
                break;
            default:
                // nothing to do here
                break;
        }

        switch (strtolower($deviceName)) {
            case '':
            case 'unknown':
            case 'other':
            case 'various':
            case 'android 1.6':
            case 'android 2.0':
            case 'android 2.1':
            case 'android 2.2':
            case 'android 2.3':
            case 'android 3.0':
            case 'android 3.1':
            case 'android 3.2':
            case 'android 4.0':
            case 'android 4.1':
            case 'android 4.2':
            case 'android 4.3':
            case 'disguised as macintosh':
            case 'mini 1':
            case 'mini 4':
            case 'mini 5':
            case 'windows mobile 6.5':
            case 'windows mobile 7':
            case 'windows mobile 7.5':
            case 'windows phone 7':
            case 'windows phone 8':
            case 'fennec tablet':
            case 'tablet on android':
            case 'fennec':
            case 'opera for series 60':
            case 'opera mini for s60':
            case 'windows mobile (opera)':
            case 'nokia unrecognized ovi browser':
                $brandName = null;
                break;
            // Medion
            case 'p9514':
            case 'lifetab p9514':
            case 'lifetab s9512':
                $brandName = 'Medion';
                break;
            // HTC
            case 'htc desire sv':
                $brandName = 'HTC';
                break;
            // Apple
            case 'ipad':
            case 'iphone':
                $brandName = 'Apple';
                break;
            default:
                // nothing to do here
                break;
        }

        return $brandName;
    }

    /**
     * maps the value for the frame/iframe support
     *
     * @param string|boolean $support
     *
     * @return string
     */
    public function mapFrameSupport($support)
    {
        switch ($support) {
            case true:
                $support = 'full';
                break;
            case false:
                $support = 'none';
                break;
            default:
                // nothing to do here
                break;
        }

        return $support;
    }

    /**
     * maps the version of the operating system
     *
     * @param string $engineVersion
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function mapEngineVersion($engineVersion)
    {
        switch (strtolower($engineVersion)) {
            case '':
            case 'unknown':
            case 'other':
                $engineVersion = null;
                break;
            default:
                // nothing to do here
                break;
        }

        $version = new Version();
        $version->setMode(
            Version::COMPLETE | Version::IGNORE_MINOR_IF_EMPTY | Version::IGNORE_MICRO_IF_EMPTY
        );

        return $version->setVersion($engineVersion);
    }
}
