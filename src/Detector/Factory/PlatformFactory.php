<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @copyright 2012-2016 Thomas Mueller
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
 * @copyright 2012-2016 Thomas Mueller
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

        if (preg_match('/(Windows Phone OS|XBLWP7|ZuneWP7|Windows Phone|WPDesktop)/', $agent)) {
            $doMatchPhone = preg_match('/Windows Phone ([\d\.]+)/', $agent, $matchesPhone);
            if (!$doMatchPhone || $matchesPhone[1] >= 7) {
                return new Os\WindowsPhoneOs($agent);
            }

            return new Os\WindowsMobileOs($agent);
        }

        if ($windowsHelper->isMobileWindows() && $utils->checkIfContains('Windows CE')) {
            return new Os\WindowsCe($agent);
        }

        if ($windowsHelper->isMobileWindows()) {
            $doMatchMobile = preg_match('/mobile version([\d]+)/', $agent, $matchesMobile);

            if ($doMatchMobile && $matchesMobile[1] >= 70) {
                return new Os\WindowsPhoneOs($agent);
            }

            return new Os\WindowsMobileOs($agent);
        }

        if ($isWindows && $utils->checkIfContains('ARM;')) {
            return new Os\WindowsRt($agent);
        }

        if ($isWindows) {
            return new Os\Windows($agent);
        }

        if (preg_match('/(SymbianOS|SymbOS|Symbian|Series 60|Series40|S60V3|S60V5)/', $agent)) {
            return new Os\Symbianos($agent);
        }

        if ($utils->checkIfContains('Bada')) {
            return new Os\Bada($agent);
        }

        if ($utils->checkIfContains('MeeGo')) {
            return new Os\MeeGo($agent);
        }

        if (preg_match('/(maemo|like android|linux\/x2\/r1|linux armv)/i', $agent)) {
            return new Os\Maemo($agent);
        }

        if (preg_match('/(BlackBerry|BB10)/', $agent)) {
            return new Os\RimOs($agent);
        }

        if (preg_match('/(webos|hpwos)/i', $agent)) {
            return new Os\WebOs($agent);
        }

        if ($utils->checkIfContains('Tizen')) {
            return new Os\Tizen($agent);
        }

        if ((new FirefoxOsHelper($agent))->isFirefoxOs()) {
            return new Os\FirefoxOs($agent);
        }

        if ($utils->checkIfContains(['darwin', 'cfnetwork'], true)) {
            return Platform\DarwinFactory::detect($agent);
        }

        if ($utils->checkIfContains('playstation', true)) {
            return new Os\CellOs($agent);
        }

        if (preg_match('/(micromaxx650|dolfin\/|yuanda50|wap[ \-]browser)/i', $agent)) {
            return new Os\Java($agent);
        }

        if (preg_match('/MIUI/', $agent)) {
            return new Os\MiuiOs($agent);
        }

        if (preg_match('/(android|silk|juc\(linux;u;|juc \(linux; u;|adr |gingerbread|mtk;|ucweb\/2\.0 \(linux; u; opera mini|maui|spreadtrum|vre;|linux; googletv)/i', $agent)) {
            return new Os\AndroidOs($agent);
        }

        if (preg_match('/(IphoneOSX|iPhone OS|like Mac OS X|iPad|IPad|iPhone|iPod|CPU OS|CPU iOS|IUC\(U;iOS)/', $agent)
            && false === stripos($agent, 'technipad')
        ) {
            return new Os\Ios($agent);
        }

        if (preg_match('/(profile)/i', $agent)) {
            return new Os\Java($agent);
        }

        if (preg_match('/Linux; U; (\d+[\d\.]+)/', $agent, $matches) && $matches[1] >= 4) {
            return new Os\AndroidOs($agent);
        }

        if (preg_match('/(Macintosh|Mac_PowerPC|PPC|68K)/', $agent)
            && !$utils->checkIfContains('OS X')
        ) {
            return new Os\MacintoshOs($agent);
        }

        if (preg_match('/(Macintosh|Mac OS X)/', $agent)) {
            return new Os\Macosx($agent);
        }

        if ($utils->checkIfContains('debian', true)) {
            return new Os\Debian($agent);
        }

        if ($utils->checkIfContains('kubuntu', true)) {
            return new Os\Kubuntu($agent);
        }

        if ($utils->checkIfContains('ubuntu', true)) {
            return new Os\Ubuntu($agent);
        }

        if ($utils->checkIfContains(['RIM Tablet'])) {
            return new Os\RimTabletOs($agent);
        }

        if ($utils->checkIfContains('centos', true)) {
            return new Os\CentOs($agent);
        }

        if ($utils->checkIfContains('CrOS')) {
            return new Os\CrOs($agent);
        }

        if ($utils->checkIfContains('Joli OS')) {
            return new Os\JoliOs($agent);
        }

        if ($utils->checkIfContains('mandriva', true)) {
            return new Os\Mandriva($agent);
        }

        if ($utils->checkIfContainsAll(['mint', 'linux'], true)) {
            return new Os\Mint($agent);
        }

        if ($utils->checkIfContains('suse', true)) {
            return new Os\Suse($agent);
        }

        if ($utils->checkIfContains('fedora', true)) {
            return new Os\Fedora($agent);
        }

        if ($utils->checkIfContains('gentoo', true)) {
            return new Os\Gentoo($agent);
        }

        if ($utils->checkIfContains(['redhat', 'red hat'], true)) {
            return new Os\Redhat($agent);
        }

        if ($utils->checkIfContains('slackware', true)) {
            return new Os\Slackware($agent);
        }

        if ($utils->checkIfContains('ventana', true)) {
            return new Os\Ventana($agent);
        }

        if ($utils->checkIfContains('Moblin')) {
            return new Os\Moblin($agent);
        }

        if ($utils->checkIfContains('Zenwalk GNU')) {
            return new Os\ZenwalkGnu($agent);
        }

        if ($utils->checkIfContains('AIX')) {
            return new Os\Aix($agent);
        }

        if ($utils->checkIfContains('AmigaOS')) {
            return new Os\AmigaOs($agent);
        }

        if ($utils->checkIfContains('BREW')) {
            return new Os\Brew($agent);
        }

        if ($utils->checkIfContains('cygwin', true)) {
            return new Os\Cygwin($agent);
        }

        if ($utils->checkIfContains('freebsd', true)) {
            return new Os\FreeBsd($agent);
        }

        if ($utils->checkIfContains('NetBSD')) {
            return new Os\NetBsd($agent);
        }

        if ($utils->checkIfContains('OpenBSD')) {
            return new Os\OpenBsd($agent);
        }

        if ($utils->checkIfContains('DragonFly')) {
            return new Os\DragonflyBsd($agent);
        }

        if ($utils->checkIfContains('BSD Four')) {
            return new Os\BsdFour($agent);
        }

        if ($utils->checkIfContainsAll(['HP-UX', 'HPUX'])) {
            return new Os\Hpux($agent);
        }

        if ($utils->checkIfContainsAll(['BeOS'])) {
            return new Os\Beos($agent);
        }

        if ($utils->checkIfContains(['IRIX64', 'IRIX'])) {
            return new Os\Irix($agent);
        }

        if ($utils->checkIfContains('solaris', true)) {
            return new Os\Solaris($agent);
        }

        if ($utils->checkIfContains('sunos', true)) {
            return new Os\SunOs($agent);
        }

        if ($utils->checkIfContains('RISC')) {
            return new Os\RiscOs($agent);
        }

        if ($utils->checkIfContains('OpenVMS')) {
            return new Os\OpenVms($agent);
        }

        if ($utils->checkIfContains(['Tru64 UNIX', 'Digital Unix'])) {
            return new Os\Tru64Unix($agent);
        }

        if ($utils->checkIfContains('unix', true)) {
            return new Os\Unix($agent);
        }

        if ($utils->checkIfContains(['os/2', 'warp'], true)) {
            return new Os\Os2($agent);
        }

        if ($utils->checkIfContains(['nettv', 'hbbtv', 'smart-tv', 'linux', 'x11', 'dillo', 'installatron', 'lynx'], true)) {
            return new Os\Linux($agent);
        }

        if ($utils->checkIfContains('CP/M')) {
            return new Os\Cpm($agent);
        }

        if ($utils->checkIfContains(['Nintendo Wii', 'Nintendo 3DS'])) {
            return new Os\NintendoOs($agent);
        }

        if ($utils->checkIfContains(['Nokia'])) {
            return new Os\NokiaOs($agent);
        }

        if ($utils->checkIfContains('ruby', true)) {
            return new Os\Ruby($agent);
        }

        if ($utils->checkIfContains('Palm OS')) {
            return new Os\PalmOS($agent);
        }

        if ($utils->checkIfContains('WyderOS')) {
            return new Os\WyderOs($agent);
        }

        if ($utils->checkIfContains('Liberate')) {
            return new Os\Liberate($agent);
        }

        if (preg_match('/(Java|J2ME\/MIDP|Profile\/MIDP|JUC|UCWEB|NetFront|Nokia|Jasmine\/1.0|JavaPlatform|WAP\/OBIGO|Obigo\/WAP|Dolfin\/)/', $agent)) {
            return new Os\Java($agent);
        }

        return new Os\UnknownOs($agent);
    }
}
