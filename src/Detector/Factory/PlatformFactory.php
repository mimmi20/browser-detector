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

        $mobileDeviceHelper = new MobileDevice();
        $mobileDeviceHelper->setUserAgent($agent);

        if (!$windowsHelper->isMobileWindows()
            && $windowsHelper->isWindows()
            && !$mobileDeviceHelper->isMobile()
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
        } elseif (preg_match('/(Android|Silk|JUC\(Linux;U;|JUC \(Linux; U;)/', $agent)
            || $safariHelper->isMobileAsSafari()
        ) {
            $platformKey = 'AndroidOS';
        } elseif (preg_match('/Linux; U; (\d+[\d\.]+)/', $agent, $matches) && $matches[1] >= 4) {
            $platformKey = 'AndroidOS';
        } elseif ($utils->checkIfContains('darwin', true)) {
            $platformKey = 'Darwin';
        } elseif (preg_match('/(IphoneOSX|iPhone OS|like Mac OS X|iPad|IPad|iPhone|iPod|CPU OS|CPU iOS|IUC\(U;iOS)/', $agent)) {
            $platformKey = 'iOS';
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
        } elseif ($utils->checkIfContains(array('Nintendo Wii'))) {
            $platformKey = 'Nintendo Wii OS';
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

        $allPlatformProperties = require 'data/properties/platforms.php';

        if (!isset($allPlatformProperties[$platformKey])) {
            $platformKey = 'UnknownOs';
        }

        $platformProperties = $allPlatformProperties[$platformKey];
        $manufacturerName   = '\\Detector\\Company\\' . $platformProperties['company'];
        $company            = new $manufacturerName();

        $detector = new Version();
        $detector->setUserAgent($agent);

        if (isset($platformProperties['version'])) {
            $detector->detectVersion($platformProperties['version']);
        } else {
            $detector->setVersion('0.0');
        }

        return new Platform($platformProperties['name'], $company, $detector, $platformProperties['properties']);
    }
}
