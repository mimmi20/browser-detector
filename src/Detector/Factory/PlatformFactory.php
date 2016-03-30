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
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Os;
use BrowserDetector\Helper\FirefoxOs as FirefoxOsHelper;
use BrowserDetector\Helper\Windows as WindowsHelper;
use UaHelper\Utils;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class PlatformFactory implements FactoryInterface
{
    /**
     * Gets the information about the platform by User Agent
     *
     * @param string $agent
     *
     * @return \UaResult\Os\OsInterface
     */
    public static function detect($agent)
    {
        $utils = new Utils();
        $utils->setUserAgent($agent);

        $isWindows     = false;
        $windowsHelper = new WindowsHelper($agent);

        if (!$windowsHelper->isMobileWindows()
            && $windowsHelper->isWindows()
        ) {
            $isWindows = true;
        }

        $firefoxOsHelper = new FirefoxOsHelper();
        $firefoxOsHelper->setUserAgent($agent);

        if (preg_match('/(Windows Phone OS|XBLWP7|ZuneWP7|Windows Phone|WPDesktop)/', $agent)) {
            $doMatchPhone = preg_match('/Windows Phone ([\d\.]+)/', $agent, $matchesPhone);
            if (!$doMatchPhone || $matchesPhone[1] >= 7) {
                $platform = new Os\WindowsPhoneOs($agent, []);
            } else {
                $platform = new Os\WindowsMobileOs($agent, []);
            }
        } elseif ($windowsHelper->isMobileWindows() && $utils->checkIfContains('Windows CE')) {
            $platform = new Os\WindowsCe($agent, []);
        } elseif ($windowsHelper->isMobileWindows()) {
            $doMatchMobile = preg_match('/mobile version([\d]+)/', $agent, $matchesMobile);

            if ($doMatchMobile && $matchesMobile[1] >= 70) {
                $platform = new Os\WindowsPhoneOs($agent, []);
            } else {
                $platform = new Os\WindowsMobileOs($agent, []);
            }
        } elseif ($isWindows && $utils->checkIfContains('ARM;')) {
            $platform = new Os\WindowsRt($agent, []);
        } elseif ($isWindows) {
            $platform = new Os\Windows($agent, []);
        } elseif (preg_match('/(SymbianOS|SymbOS|Symbian|Series 60|Series40|S60V3|S60V5)/', $agent)) {
            $platform = new Os\Symbianos($agent, []);
        } elseif ($utils->checkIfContains('Bada')) {
            $platform = new Os\Bada($agent, []);
        } elseif ($utils->checkIfContains('MeeGo')) {
            $platform = new Os\MeeGo($agent, []);
        } elseif (preg_match('/(maemo|like android|linux\/x2\/r1)/i', $agent)) {
            $platform = new Os\Maemo($agent, []);
        } elseif (preg_match('/(BlackBerry|BB10)/', $agent)) {
            $platform = new Os\RimOs($agent, []);
        } elseif (preg_match('/(WebOS|hpwOS|webOS)/', $agent)) {
            $platform = new Os\WebOs($agent, []);
        } elseif ($utils->checkIfContains('Tizen')) {
            $platform = new Os\Tizen($agent, []);
        } elseif ($firefoxOsHelper->isFirefoxOs()) {
            $platform = new Os\FirefoxOs($agent, []);
        } elseif ($utils->checkIfContains('darwin', true)) {
            $platform = new Os\Darwin($agent, []);
        } elseif ($utils->checkIfContains('playstation', true)) {
            $platform = new Os\CellOs($agent, []);
        } elseif (preg_match('/(IphoneOSX|iPhone OS|like Mac OS X|iPad|IPad|iPhone|iPod|CPU OS|CPU iOS|IUC\(U;iOS)/', $agent)
            && false === stripos($agent, 'technipad')
        ) {
            $platform = new Os\Ios($agent, []);
        } elseif (preg_match('/(android|silk|juc\(linux;u;|juc \(linux; u;|adr |gingerbread)/i', $agent)) {
            $platform = new Os\AndroidOs($agent, []);
        } elseif (preg_match('/Linux; U; (\d+[\d\.]+)/', $agent, $matches) && $matches[1] >= 4) {
            $platform = new Os\AndroidOs($agent, []);
        } elseif (preg_match('/(Macintosh|Mac_PowerPC|PPC|68K)/', $agent)
            && !$utils->checkIfContains('Mac OS X')
        ) {
            $platform = new Os\MacintoshOs($agent, []);
        } elseif (preg_match('/(Macintosh|Mac OS X)/', $agent)) {
            $platform = new Os\Macosx($agent, []);
        } elseif ($utils->checkIfContains('debian', true)) {
            $platform = new Os\Debian($agent, []);
        } elseif ($utils->checkIfContains('kubuntu', true)) {
            $platform = new Os\Kubuntu($agent, []);
        } elseif ($utils->checkIfContains('ubuntu', true)) {
            $platform = new Os\Ubuntu($agent, []);
        } elseif ($utils->checkIfContains(['RIM Tablet'])) {
            $platform = new Os\RimTabletOs($agent, []);
        } elseif ($utils->checkIfContains('centos', true)) {
            $platform = new Os\CentOs($agent, []);
        } elseif ($utils->checkIfContains('CrOS')) {
            $platform = new Os\CrOs($agent, []);
        } elseif ($utils->checkIfContains('Joli OS')) {
            $platform = new Os\JoliOs($agent, []);
        } elseif ($utils->checkIfContains('mandriva', true)) {
            $platform = new Os\Mandriva($agent, []);
        } elseif ($utils->checkIfContainsAll(['mint', 'linux'], true)) {
            $platform = new Os\Mint($agent, []);
        } elseif ($utils->checkIfContains('suse', true)) {
            $platform = new Os\Suse($agent, []);
        } elseif ($utils->checkIfContains('fedora', true)) {
            $platform = new Os\Fedora($agent, []);
        } elseif ($utils->checkIfContains('gentoo', true)) {
            $platform = new Os\Gentoo($agent, []);
        } elseif ($utils->checkIfContains(['redhat', 'red hat'], true)) {
            $platform = new Os\Redhat($agent, []);
        } elseif ($utils->checkIfContains('slackware', true)) {
            $platform = new Os\Slackware($agent, []);
        } elseif ($utils->checkIfContains('ventana', true)) {
            $platform = new Os\Ventana($agent, []);
        } elseif ($utils->checkIfContains('Moblin')) {
            $platform = new Os\Moblin($agent, []);
        } elseif ($utils->checkIfContains('Zenwalk GNU')) {
            $platform = new Os\ZenwalkGnu($agent, []);
        } elseif ($utils->checkIfContains('AIX')) {
            $platform = new Os\Aix($agent, []);
        } elseif ($utils->checkIfContains('AmigaOS')) {
            $platform = new Os\AmigaOs($agent, []);
        } elseif ($utils->checkIfContains('BREW')) {
            $platform = new Os\Brew($agent, []);
        } elseif ($utils->checkIfContains('cygwin', true)) {
            $platform = new Os\CygWin($agent, []);
        } elseif ($utils->checkIfContains('freebsd', true)) {
            $platform = new Os\FreeBsd($agent, []);
        } elseif ($utils->checkIfContains('NetBSD')) {
            $platform = new Os\NetBsd($agent, []);
        } elseif ($utils->checkIfContains('OpenBSD')) {
            $platform = new Os\OpenBsd($agent, []);
        } elseif ($utils->checkIfContains('DragonFly')) {
            $platform = new Os\DragonflyBsd($agent, []);
        } elseif ($utils->checkIfContains('BSD Four')) {
            $platform = new Os\BsdFour($agent, []);
        } elseif ($utils->checkIfContainsAll(['HP-UX', 'HPUX'])) {
            $platform = new Os\Hpux($agent, []);
        } elseif ($utils->checkIfContainsAll(['BeOS'])) {
            $platform = new Os\Beos($agent, []);
        } elseif ($utils->checkIfContains(['IRIX64', 'IRIX'])) {
            $platform = new Os\Irix($agent, []);
        } elseif ($utils->checkIfContains('solaris', true)) {
            $platform = new Os\Solaris($agent, []);
        } elseif ($utils->checkIfContains('sunos', true)) {
            $platform = new Os\SunOs($agent, []);
        } elseif ($utils->checkIfContains('RISC')) {
            $platform = new Os\RiscOs($agent, []);
        } elseif ($utils->checkIfContains('OpenVMS')) {
            $platform = new Os\OpenVms($agent, []);
        } elseif ($utils->checkIfContains(['Tru64 UNIX', 'Digital Unix'])) {
            $platform = new Os\Tru64Unix($agent, []);
        } elseif ($utils->checkIfContains('unix', true)) {
            $platform = new Os\Unix($agent, []);
        } elseif ($utils->checkIfContains(['os/2', 'warp'], true)) {
            $platform = new Os\Os2($agent, []);
        } elseif ($utils->checkIfContains(['NETTV', 'HbbTV', 'SMART-TV'])) {
            $platform = new Os\LinuxTv($agent, []);
        } elseif ($utils->checkIfContains(['Linux', 'linux', 'X11'])) {
            $platform = new Os\Linux($agent, []);
        } elseif ($utils->checkIfContains('CP/M')) {
            $platform = new Os\Cpm($agent, []);
        } elseif ($utils->checkIfContains(['Nintendo Wii', 'Nintendo 3DS'])) {
            $platform = new Os\NintendoOs($agent, []);
        } elseif ($utils->checkIfContains(['Nokia'])) {
            $platform = new Os\NokiaOs($agent, []);
        } elseif ($utils->checkIfContains('ruby', true)) {
            $platform = new Os\Ruby($agent, []);
        } elseif ($utils->checkIfContains('Palm OS')) {
            $platform = new Os\PalmOS($agent, []);
        } elseif ($utils->checkIfContains('WyderOS')) {
            $platform = new Os\WyderOs($agent, []);
        } elseif ($utils->checkIfContains('Liberate')) {
            $platform = new Os\Liberate($agent, []);
        } elseif (preg_match('/(Java|J2ME\/MIDP|Profile\/MIDP|JUC|UCWEB|NetFront|Nokia|Jasmine\/1.0|JavaPlatform|WAP\/OBIGO|Obigo\/WAP)/', $agent)) {
            $platform = new Os\Java($agent, []);
        } else {
            $platform = new Os\UnknownOs($agent, []);
        }

        return $platform;
    }
}
