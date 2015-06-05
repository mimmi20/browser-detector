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

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Platform;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\FirefoxOs as FirefoxOsHelper;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Safari as SafariHelper;
use BrowserDetector\Helper\Utils;
use BrowserDetector\Helper\Windows as WindowsHelper;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class PlatformFactory implements FactoryInterface
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $agent
     *
     * @return \BrowserDetector\Detector\Platform
     */
    public static function detect($agent)
    {
        $utils = new Utils();
        $utils->setUserAgent($agent);

        $isWindows     = false;
        $windowsHelper = new WindowsHelper();
        $windowsHelper->setUserAgent($agent);

        if (!$windowsHelper->isMobileWindows()
            && $windowsHelper->isWindows()
        ) {
            $isWindows = true;
        }

        $firefoxOsHelper = new FirefoxOsHelper();
        $firefoxOsHelper->setUserAgent($agent);

        $safariHelper = new SafariHelper();
        $safariHelper->setUserAgent($agent);

        if (preg_match('/(Windows Phone OS|XBLWP7|ZuneWP7|Windows Phone|WPDesktop)/', $agent)) {
            $doMatchPhone = preg_match('/Windows Phone ([\d\.]+)/', $agent, $matchesPhone);
            if (!$doMatchPhone || $matchesPhone[1] >= 7) {
                $platformKey = 'Windows Phone OS';
            } else {
                $platformKey = 'Windows Mobile OS';
            }
        } elseif ($windowsHelper->isMobileWindows() && $utils->checkIfContains('Windows CE')) {
            $platformKey = 'Windows CE';
        } elseif ($windowsHelper->isMobileWindows()) {
            $doMatchMobile = preg_match('/mobile version([\d]+)/', $agent, $matchesMobile);

            if ($doMatchMobile && $matchesMobile[1] >= 70) {
                $platformKey = 'Windows Phone OS';
            } else {
                $platformKey = 'Windows Mobile OS';
            }
        } elseif ($isWindows && $utils->checkIfContains('ARM;')) {
            $platformKey = 'Windows RT';
        } elseif ($isWindows) {
            $platformKey = 'Windows';
        } elseif (preg_match('/(SymbianOS|SymbOS|Symbian|Series 60|S60V3|S60V5)/', $agent)) {
            $platformKey = 'Symbian OS';
        } elseif ($utils->checkIfContains('Bada')) {
            $platformKey = 'Bada';
        } elseif ($utils->checkIfContains('MeeGo')) {
            $platformKey = 'MeeGo';
        } elseif (preg_match('/(maemo|linux armv|like android|linux\/x2\/r1)/i', $agent)) {
            $platformKey = 'Maemo';
        } elseif (preg_match('/(BlackBerry|BB10)/', $agent)) {
            $platformKey = 'RIM OS';
        } elseif (preg_match('/(WebOS|hpwOS|webOS)/', $agent)) {
            $platformKey = 'webOS';
        } elseif ($utils->checkIfContains('Tizen')) {
            $platformKey = 'Tizen';
        } elseif ($firefoxOsHelper->isFirefoxOs()) {
            $platformKey = 'FirefoxOS';
        } elseif ($utils->checkIfContains('darwin', true)) {
            $platformKey = 'Darwin';
        } elseif (preg_match('/(IphoneOSX|iPhone OS|like Mac OS X|iPad|IPad|iPhone|iPod|CPU OS|CPU iOS|IUC\(U;iOS)/', $agent)) {
            $platformKey = 'iOS';
        } elseif (preg_match('/(Android|Silk|JUC\(Linux;U;|JUC \(Linux; U;)/', $agent)
            || $safariHelper->isMobileAsSafari()
        ) {
            $platformKey = 'AndroidOS';
        } elseif (preg_match('/Linux; U; (\d+[\d\.]+)/', $agent, $matches) && $matches[1] >= 4) {
            $platformKey = 'AndroidOS';
        } elseif (preg_match('/(Macintosh|Mac_PowerPC|PPC|68K)/', $agent)
            && !$utils->checkIfContains('Mac OS X')
        ) {
            $platformKey = 'Macintosh';
        } elseif (preg_match('/(Macintosh|Mac OS X)/', $agent)) {
            $platformKey = 'Mac OS X';
        } elseif ($utils->checkIfContains('debian', true)) {
            $platformKey = 'Debian';
        } elseif ($utils->checkIfContains('kubuntu', true)) {
            $platformKey = 'Kubuntu';
        } elseif ($utils->checkIfContains('ubuntu', true)) {
            $platformKey = 'Ubuntu';
        } elseif ($utils->checkIfContains(array('RIM Tablet'))) {
            $platformKey = 'RIM Tablet OS';
        } elseif ($utils->checkIfContains('centos', true)) {
            $platformKey = 'CentOs';
        } elseif ($utils->checkIfContains('CrOS')) {
            $platformKey = 'ChromeOS';
        } elseif ($utils->checkIfContains('Joli OS')) {
            $platformKey = 'Joli OS';
        } elseif ($utils->checkIfContains('mandriva', true)) {
            $platformKey = 'Mandriva';
        } elseif ($utils->checkIfContainsAll(array('mint', 'linux'), true)) {
            $platformKey = 'Mint';
        } elseif ($utils->checkIfContains('suse', true)) {
            $platformKey = 'Suse Linux';
        } elseif ($utils->checkIfContains('fedora', true)) {
            $platformKey = 'Fedora';
        } elseif ($utils->checkIfContains('gentoo', true)) {
            $platformKey = 'Gentoo';
        } elseif ($utils->checkIfContains(array('redhat', 'red hat'), true)) {
            $platformKey = 'Redhat Linux';
        } elseif ($utils->checkIfContains('slackware', true)) {
            $platformKey = 'Slackware Linux';
        } elseif ($utils->checkIfContains('ventana', true)) {
            $platformKey = 'Ventana Linux';
        } elseif ($utils->checkIfContains('Moblin')) {
            $platformKey = 'Moblin';
        } elseif ($utils->checkIfContains('Zenwalk GNU')) {
            $platformKey = 'Zenwalk GNU Linux';
        } elseif ($utils->checkIfContains('AIX')) {
            $platformKey = 'AIX';
        } elseif ($utils->checkIfContains('AmigaOS')) {
            $platformKey = 'AmigaOS';
        } elseif ($utils->checkIfContains('BREW')) {
            $platformKey = 'BREW';
        } elseif ($utils->checkIfContains('playstation', true)) {
            $platformKey = 'CellOS';
        } elseif ($utils->checkIfContains('cygwin', true)) {
            $platformKey = 'CygWin';
        } elseif ($utils->checkIfContains('freebsd', true)) {
            $platformKey = 'FreeBSD';
        } elseif ($utils->checkIfContains('NetBSD')) {
            $platformKey = 'NetBSD';
        } elseif ($utils->checkIfContains('OpenBSD')) {
            $platformKey = 'OpenBSD';
        } elseif ($utils->checkIfContains('DragonFly')) {
            $platformKey = 'DragonFlyBSD';
        } elseif ($utils->checkIfContains('BSD Four')) {
            $platformKey = 'BSD';
        } elseif ($utils->checkIfContainsAll(array('HP-UX', 'HPUX'))) {
            $platformKey = 'HP-UX';
        } elseif ($utils->checkIfContainsAll(array('BeOS'))) {
            $platformKey = 'BeOS';
        } elseif ($utils->checkIfContains(array('IRIX64', 'IRIX'))) {
            $platformKey = 'IRIX';
        } elseif ($utils->checkIfContains('solaris', true)) {
            $platformKey = 'Solaris';
        } elseif ($utils->checkIfContains('sunos', true)) {
            $platformKey = 'SunOS';
        } elseif ($utils->checkIfContains('RISC')) {
            $platformKey = 'RISC OS';
        } elseif ($utils->checkIfContains('OpenVMS')) {
            $platformKey = 'OpenVMS';
        } elseif ($utils->checkIfContains(array('Tru64 UNIX', 'Digital Unix'))) {
            $platformKey = 'Tru64 UNIX';
        } elseif ($utils->checkIfContains('unix', true)) {
            $platformKey = 'Unix';
        } elseif ($utils->checkIfContainsAll(array('os/2', 'warp'), true)) {
            $platformKey = 'OS/2';
        } elseif ($utils->checkIfContains(array('NETTV', 'HbbTV', 'SMART-TV'))) {
            $platformKey = 'Linux for TV';
        } elseif ($utils->checkIfContains(array('Linux', 'linux', 'X11'))) {
            $platformKey = 'Linux';
        } elseif ($utils->checkIfContains('CP/M')) {
            $platformKey = 'CP/M';
        } elseif ($utils->checkIfContains(array('Nintendo Wii', 'Nintendo 3DS'))) {
            $platformKey = 'Nintendo OS';
        } elseif ($utils->checkIfContains(array('Nokia', 'Series40'))) {
            $platformKey = 'Nokia OS';
        } elseif ($utils->checkIfContains('ruby', true)) {
            $platformKey = 'Ruby';
        } elseif ($utils->checkIfContains('Palm OS')) {
            $platformKey = 'PalmOS';
        } elseif ($utils->checkIfContains('WyderOS')) {
            $platformKey = 'WyderOS';
        } elseif ($utils->checkIfContains('Liberate')) {
            $platformKey = 'Liberate';
        } elseif (preg_match('/(Java|J2ME\/MIDP|Profile\/MIDP|JUC|UCWEB|NetFront|Nokia|Jasmine\/1.0|JavaPlatform|WAP\/OBIGO|Obigo\/WAP)/', $agent)) {
            $platformKey = 'Java';
        } else {
            $platformKey = 'UnknownOs';
        }

        $allPlatformProperties = require __DIR__ . '/../../../data/properties/platforms.php';

        if (!isset($allPlatformProperties[$platformKey])) {
            $platformKey = 'UnknownOs';
        }

        $platformProperties = $allPlatformProperties[$platformKey];
        $manufacturerName   = '\\BrowserDetector\\Detector\\Company\\' . $platformProperties['company'];
        $company            = new $manufacturerName();

        switch ($platformProperties['name']) {
            case 'Windows':
                // break omitted
            case 'Windows RT':
                $detector = self::detectWindowsVersion($agent, $utils);
                break;
            case 'Windows Phone OS':
                $detector = self::detectWindowsPhoneVersion($agent, $utils);
                break;
            case 'Windows Mobile OS':
                $detector = self::detectWindowsMobileVersion($agent, $utils);
                break;
            case 'Mac OS X':
                $detector = self::detectMacOsxVersion($agent);
                break;
            case 'iOS':
                $detector = self::detectIosVersion($agent);
                break;
            case 'Android':
                $detector = self::detectAndroidVersion($agent, $utils);
                break;
            case 'RIM OS':
                $detector = self::detectBlackBerryVersion($agent, $utils);
                break;
            default:
                $detector = new Version();
                $detector->setUserAgent($agent);

                if (isset($platformProperties['version'])) {
                    $detector->detectVersion($platformProperties['version']);
                } else {
                    $detector->setVersion('0.0');
                }
                break;
        }

        return new Platform($platformProperties['name'], $company, $detector, $platformProperties['properties']);
    }

    /**
     * @param string                        $agent
     * @param \BrowserDetector\Helper\Utils $utils
     *
     * @return \BrowserDetector\Detector\Version
     */
    private static function detectWindowsVersion($agent, Utils $utils)
    {
        $detector = new Version();
        $detector->setUserAgent($agent);
        $detector->setMode(Version::COMPLETE | Version::IGNORE_MINOR);

        if ($utils->checkIfContains(array('win9x/NT 4.90', 'Win 9x 4.90', 'Win 9x4.90'))) {
            return $detector->setVersion('ME');
        }

        if ($utils->checkIfContains(array('Win98'))) {
            return $detector->setVersion('98');
        }

        if ($utils->checkIfContains(array('Win95'))) {
            return $detector->setVersion('95');
        }

        if ($utils->checkIfContains(array('Windows-NT'))) {
            return $detector->setVersion('NT');
        }

        $doMatch = preg_match('/Windows NT ([\d\.]+)/', $agent, $matches);

        if ($doMatch) {
            switch ($matches[1]) {
                case '6.4':
                case '10.0':
                    $version = '10';
                    break;
                case '6.3':
                    $version = '8.1';
                    break;
                case '6.2':
                    $version = '8';
                    break;
                case '6.1':
                    $version = '7';
                    break;
                case '6.0':
                    $version = 'Vista';
                    break;
                case '5.3':
                case '5.2':
                case '5.1':
                    $version = 'XP';
                    break;
                case '5.0':
                case '5.01':
                    $version = '2000';
                    break;
                case '4.1':
                case '4.0':
                    $version = 'NT';
                    break;
                default:
                    $version = '';
                    break;
            }

            return $detector->setVersion($version);
        }

        $doMatch = preg_match('/Windows ([\d\.a-zA-Z]+)/', $agent, $matches);

        if ($doMatch) {
            switch ($matches[1]) {
                case '6.4':
                case '10.0':
                    $version = '10';
                    break;
                case '6.3':
                    $version = '8.1';
                    break;
                case '6.2':
                    $version = '8';
                    break;
                case '6.1':
                case '7':
                    $version = '7';
                    break;
                case '6.0':
                    $version = 'Vista';
                    break;
                case '2003':
                    $version = 'Server 2003';
                    break;
                case '5.3':
                case '5.2':
                case '5.1':
                case 'XP':
                    $version = 'XP';
                    break;
                case 'ME':
                    $version = 'ME';
                    break;
                case '2000':
                case '5.0':
                case '5.01':
                    $version = '2000';
                    break;
                case '3.1':
                    $version = '3.1';
                    break;
                case '95':
                    $version = '95';
                    break;
                case '98':
                    $version = '98';
                    break;
                case '4.1':
                case '4.0':
                case 'NT':
                    $version = 'NT';
                    break;
                default:
                    $version = '';
                    break;
            }

            return $detector->setVersion($version);
        }

        return $detector->setVersion('');
    }

    /**
     * @param string                        $agent
     * @param \BrowserDetector\Helper\Utils $utils
     *
     * @return \BrowserDetector\Detector\Version
     */
    private static function detectWindowsPhoneVersion($agent, Utils $utils)
    {
        $detector = new Version();
        $detector->setUserAgent($agent);

        if ($utils->checkIfContains(array('XBLWP7', 'ZuneWP7'))) {
            return $detector->setVersion('7.5');
        }

        if ($utils->checkIfContains(array('WPDesktop'))) {
            if ($utils->checkIfContains(array('Windows NT 6.2'))) {
                return $detector->setVersion('8.1');
            }

            return $detector->setVersion('8.0');
        }

        $searches = array('Windows Phone OS', 'Windows Phone');

        return $detector->detectVersion($searches);
    }

    /**
     * @param string                        $agent
     * @param \BrowserDetector\Helper\Utils $utils
     *
     * @return \BrowserDetector\Detector\Version
     */
    private static function detectWindowsMobileVersion($agent, Utils $utils)
    {
        $detector = new Version();
        $detector->setUserAgent($agent);

        if ($utils->checkIfContains('Windows NT 5.1')) {
            return $detector->setVersion('6.0');
        }

        if ($utils->checkIfContains(array('Windows CE', 'Windows Mobile', 'MSIEMobile'))) {
            $detector->setDefaulVersion('6.0');

            $searches = array('MSIEMobile');

            return $detector->detectVersion($searches);
        }

        $searches = array('Windows Phone');

        return $detector->detectVersion($searches);
    }

    /**
     * @param string                        $agent
     * @param \BrowserDetector\Helper\Utils $utils
     *
     * @return \BrowserDetector\Detector\Version
     */
    private static function detectBlackBerryVersion($agent, Utils $utils)
    {
        $detector = new Version();
        $detector->setUserAgent($agent);

        $searches = array('BlackBerry[0-9a-z]+', 'BlackBerrySimulator');

        if (!$utils->checkIfContains('Opera')) {
            $searches[] = 'Version';
        }

        return $detector->detectVersion($searches);
    }

    /**
     * @param string $agent
     *
     * @return \BrowserDetector\Detector\Version
     */
    private static function detectMacOsxVersion($agent)
    {
        $detector = new Version();
        $detector->setUserAgent($agent);
        $detector->setDefaulVersion('10');

        $searches = array('Mac OS X', 'Mac OS X v');

        $detector->detectVersion($searches);

        if ($detector->getVersion(Version::MAJORONLY) > 99) {
            $versions = array();
            $found    = preg_match('/(\d\d)(\d)/', $detector->getVersion(Version::MAJORONLY), $versions);

            if ($found) {
                $detector->setVersion($versions[1] . '.' . $versions[2]);
            }
        }

        return $detector;
    }

    /**
     * @param string $agent
     *
     * @return \BrowserDetector\Detector\Version
     */
    private static function detectIosVersion($agent)
    {
        $detector = new Version();
        $detector->setUserAgent($agent);

        $searches = array(
            'IphoneOSX',
            'CPU OS\_',
            'CPU OS',
            'CPU iOS',
            'CPU iPad OS',
            'iPhone OS',
            'iPhone_OS',
            'IUC\(U\;iOS'
        );

        $detector->detectVersion($searches);

        $doMatch = preg_match('/CPU like Mac OS X/', $agent, $matches);

        if ($doMatch) {
            $detector->setVersion('1.0');
        }

        return $detector;
    }

    /**
     * @param string                        $agent
     * @param \BrowserDetector\Helper\Utils $utils
     *
     * @return \BrowserDetector\Detector\Version
     */
    private static function detectAndroidVersion($agent, Utils $utils)
    {
        $detector = new Version();
        $detector->setUserAgent($agent);

        if ($utils->checkIfContains('android 2.1-update1', true)) {
            return $detector->setVersion('2.1.1');
        }

        $searches = array(
            'Android android',
            'Android AndroidHouse Team',
            'Android WildPuzzleROM v8 froyo',
            'Android',
            'JUC\(Linux;U;',
            'Android OS'
        );

        $detector->detectVersion($searches);

        if (!$detector->getVersion()) {
            if ($utils->checkIfContains('android eclair', true)) {
                $detector->setVersion('2.1');
            }

            if ($utils->checkIfContains('gingerbread', true)) {
                $detector->setVersion('2.3');
            }
        }

        return $detector;
    }
}
