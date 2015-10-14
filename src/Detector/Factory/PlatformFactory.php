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

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Helper\FirefoxOs as FirefoxOsHelper;
use BrowserDetector\Helper\Safari as SafariHelper;
use BrowserDetector\Helper\Windows as WindowsHelper;
use Psr\Log\LoggerInterface;
use UaHelper\Utils;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class PlatformFactory implements FactoryInterface
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $agent
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \UaMatcher\Os\OsInterface
     */
    public static function detect($agent, LoggerInterface $logger)
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
                $platformKey = 'WindowsPhoneOs';
            } else {
                $platformKey = 'WindowsMobileOs';
            }
        } elseif ($windowsHelper->isMobileWindows() && $utils->checkIfContains('Windows CE')) {
            $platformKey = 'WindowsCe';
        } elseif ($windowsHelper->isMobileWindows()) {
            $doMatchMobile = preg_match('/mobile version([\d]+)/', $agent, $matchesMobile);

            if ($doMatchMobile && $matchesMobile[1] >= 70) {
                $platformKey = 'WindowsPhoneOs';
            } else {
                $platformKey = 'WindowsMobileOs';
            }
        } elseif ($isWindows && $utils->checkIfContains('ARM;')) {
            $platformKey = 'WindowsRt';
        } elseif ($isWindows) {
            $platformKey = 'Windows';
        } elseif (preg_match('/(SymbianOS|SymbOS|Symbian|Series 60|Series40|S60V3|S60V5)/', $agent)) {
            $platformKey = 'Symbianos';
        } elseif ($utils->checkIfContains('Bada')) {
            $platformKey = 'Bada';
        } elseif ($utils->checkIfContains('MeeGo')) {
            $platformKey = 'MeeGo';
        } elseif (preg_match('/(maemo|like android|linux\/x2\/r1)/i', $agent)) {
            $platformKey = 'Maemo';
        } elseif (preg_match('/(BlackBerry|BB10)/', $agent)) {
            $platformKey = 'RimOs';
        } elseif (preg_match('/(WebOS|hpwOS|webOS)/', $agent)) {
            $platformKey = 'WebOs';
        } elseif ($utils->checkIfContains('Tizen')) {
            $platformKey = 'Tizen';
        } elseif ($firefoxOsHelper->isFirefoxOs()) {
            $platformKey = 'FirefoxOs';
        } elseif ($utils->checkIfContains('darwin', true)) {
            $platformKey = 'Darwin';
        } elseif ($utils->checkIfContains('playstation', true)) {
            $platformKey = 'CellOs';
        } elseif (preg_match('/(IphoneOSX|iPhone OS|like Mac OS X|iPad|IPad|iPhone|iPod|CPU OS|CPU iOS|IUC\(U;iOS)/', $agent)
            && false === stripos($agent, 'technipad')
        ) {
            $platformKey = 'Ios';
        } elseif (preg_match('/(android|silk|juc\(linux;u;|juc \(linux; u;|adr )/i', $agent)
            || $safariHelper->isMobileAsSafari()
        ) {
            $platformKey = 'AndroidOs';
        } elseif (preg_match('/Linux; U; (\d+[\d\.]+)/', $agent, $matches) && $matches[1] >= 4) {
            $platformKey = 'AndroidOs';
        } elseif (preg_match('/(Macintosh|Mac_PowerPC|PPC|68K)/', $agent)
            && !$utils->checkIfContains('Mac OS X')
        ) {
            $platformKey = 'MacintoshOs';
        } elseif (preg_match('/(Macintosh|Mac OS X)/', $agent)) {
            $platformKey = 'Macosx';
        } elseif ($utils->checkIfContains('debian', true)) {
            $platformKey = 'Debian';
        } elseif ($utils->checkIfContains('kubuntu', true)) {
            $platformKey = 'Kubuntu';
        } elseif ($utils->checkIfContains('ubuntu', true)) {
            $platformKey = 'Ubuntu';
        } elseif ($utils->checkIfContains(array('RIM Tablet'))) {
            $platformKey = 'RimTabletOs';
        } elseif ($utils->checkIfContains('centos', true)) {
            $platformKey = 'CentOs';
        } elseif ($utils->checkIfContains('CrOS')) {
            $platformKey = 'CrOs';
        } elseif ($utils->checkIfContains('Joli OS')) {
            $platformKey = 'JoliOs';
        } elseif ($utils->checkIfContains('mandriva', true)) {
            $platformKey = 'Mandriva';
        } elseif ($utils->checkIfContainsAll(array('mint', 'linux'), true)) {
            $platformKey = 'Mint';
        } elseif ($utils->checkIfContains('suse', true)) {
            $platformKey = 'Suse';
        } elseif ($utils->checkIfContains('fedora', true)) {
            $platformKey = 'Fedora';
        } elseif ($utils->checkIfContains('gentoo', true)) {
            $platformKey = 'Gentoo';
        } elseif ($utils->checkIfContains(array('redhat', 'red hat'), true)) {
            $platformKey = 'Redhat';
        } elseif ($utils->checkIfContains('slackware', true)) {
            $platformKey = 'Slackware';
        } elseif ($utils->checkIfContains('ventana', true)) {
            $platformKey = 'Ventana';
        } elseif ($utils->checkIfContains('Moblin')) {
            $platformKey = 'Moblin';
        } elseif ($utils->checkIfContains('Zenwalk GNU')) {
            $platformKey = 'ZenwalkGnu';
        } elseif ($utils->checkIfContains('AIX')) {
            $platformKey = 'Aix';
        } elseif ($utils->checkIfContains('AmigaOS')) {
            $platformKey = 'AmigaOs';
        } elseif ($utils->checkIfContains('BREW')) {
            $platformKey = 'Brew';
        } elseif ($utils->checkIfContains('cygwin', true)) {
            $platformKey = 'CygWin';
        } elseif ($utils->checkIfContains('freebsd', true)) {
            $platformKey = 'FreeBsd';
        } elseif ($utils->checkIfContains('NetBSD')) {
            $platformKey = 'NetBsd';
        } elseif ($utils->checkIfContains('OpenBSD')) {
            $platformKey = 'OpenBsd';
        } elseif ($utils->checkIfContains('DragonFly')) {
            $platformKey = 'DragonFlyBsd';
        } elseif ($utils->checkIfContains('BSD Four')) {
            $platformKey = 'BsdFour';
        } elseif ($utils->checkIfContainsAll(array('HP-UX', 'HPUX'))) {
            $platformKey = 'HP-UX';
        } elseif ($utils->checkIfContainsAll(array('BeOS'))) {
            $platformKey = 'Beos';
        } elseif ($utils->checkIfContains(array('IRIX64', 'IRIX'))) {
            $platformKey = 'IRIX';
        } elseif ($utils->checkIfContains('solaris', true)) {
            $platformKey = 'Solaris';
        } elseif ($utils->checkIfContains('sunos', true)) {
            $platformKey = 'SunOs';
        } elseif ($utils->checkIfContains('RISC')) {
            $platformKey = 'RiscOs';
        } elseif ($utils->checkIfContains('OpenVMS')) {
            $platformKey = 'OpenVms';
        } elseif ($utils->checkIfContains(array('Tru64 UNIX', 'Digital Unix'))) {
            $platformKey = 'Tru64Unix';
        } elseif ($utils->checkIfContains('unix', true)) {
            $platformKey = 'Unix';
        } elseif ($utils->checkIfContains(array('os/2', 'warp'), true)) {
            $platformKey = 'Os2';
        } elseif ($utils->checkIfContains(array('NETTV', 'HbbTV', 'SMART-TV'))) {
            $platformKey = 'LinuxTv';
        } elseif ($utils->checkIfContains(array('Linux', 'linux', 'X11'))) {
            $platformKey = 'Linux';
        } elseif ($utils->checkIfContains('CP/M')) {
            $platformKey = 'Cpm';
        } elseif ($utils->checkIfContains(array('Nintendo Wii', 'Nintendo 3DS'))) {
            $platformKey = 'NintendoOs';
        } elseif ($utils->checkIfContains(array('Nokia'))) {
            $platformKey = 'NokiaOs';
        } elseif ($utils->checkIfContains('ruby', true)) {
            $platformKey = 'Ruby';
        } elseif ($utils->checkIfContains('Palm OS')) {
            $platformKey = 'PalmOS';
        } elseif ($utils->checkIfContains('WyderOS')) {
            $platformKey = 'WyderOs';
        } elseif ($utils->checkIfContains('Liberate')) {
            $platformKey = 'Liberate';
        } elseif (preg_match('/(Java|J2ME\/MIDP|Profile\/MIDP|JUC|UCWEB|NetFront|Nokia|Jasmine\/1.0|JavaPlatform|WAP\/OBIGO|Obigo\/WAP)/', $agent)) {
            $platformKey = 'Java';
        } else {
            $platformKey = 'UnknownOs';
        }

        $platformName = '\\BrowserDetector\\Detector\\Os\\' . $platformKey;

        return new $platformName($agent, $logger);
    }
}
