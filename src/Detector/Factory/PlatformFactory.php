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

use BrowserDetector\Detector\Version\AndroidOs;
use BrowserDetector\Detector\Version\Debian;
use BrowserDetector\Detector\Version\FirefoxOs;
use BrowserDetector\Detector\Version\Ios;
use BrowserDetector\Detector\Version\Macosx;
use BrowserDetector\Detector\Version\RimOs;
use BrowserDetector\Detector\Version\Windows;
use BrowserDetector\Detector\Version\WindowsMobileOs;
use BrowserDetector\Detector\Version\WindowsPhoneOs;
use BrowserDetector\Helper\FirefoxOs as FirefoxOsHelper;
use BrowserDetector\Helper\Windows as WindowsHelper;
use BrowserDetector\Version\VersionFactory;
use UaHelper\Utils;
use BrowserDetector\Version\Version;
use BrowserDetector\Detector\Bits\Os as OsBits;
use UaResult\Os\Os;

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
     * @param string $useragent
     *
     * @return \UaResult\Os\OsInterface
     */
    public static function detect($useragent)
    {
        $utils = new Utils();
        $utils->setUserAgent($useragent);

        $isWindows     = false;
        $windowsHelper = new WindowsHelper($useragent);

        if (!$windowsHelper->isMobileWindows()
            && $windowsHelper->isWindows()
        ) {
            $isWindows = true;
        }

        $bits = (new OsBits($useragent))->getBits();

        if (preg_match('/(Windows Phone OS|XBLWP7|ZuneWP7|Windows Phone|WPDesktop)/', $useragent)) {
            $doMatchPhone = preg_match('/Windows Phone ([\d\.]+)/', $useragent, $matchesPhone);
            if (!$doMatchPhone || $matchesPhone[1] >= 7) {
                return new Os($useragent, 'Windows Phone OS', WindowsPhoneOs::detectVersion($useragent), CompanyFactory::get('Microsoft')->getName(), $bits);
            }

            return new Os($useragent, 'Windows Mobile OS', WindowsMobileOs::detectVersion($useragent), CompanyFactory::get('Microsoft')->getName(), $bits);
        }

        if ($windowsHelper->isMobileWindows() && $utils->checkIfContains('Windows CE')) {
            return new Os($useragent, 'Windows CE', new Version(0), CompanyFactory::get('Microsoft')->getName(), $bits);
        }

        if ($windowsHelper->isMobileWindows()) {
            $doMatchMobile = preg_match('/mobile version([\d]+)/', $useragent, $matchesMobile);

            if ($doMatchMobile && $matchesMobile[1] >= 70) {
                return new Os($useragent, 'Windows Phone OS', WindowsPhoneOs::detectVersion($useragent), CompanyFactory::get('Microsoft')->getName(), $bits);
            }

            return new Os($useragent, 'Windows Mobile OS', WindowsMobileOs::detectVersion($useragent), CompanyFactory::get('Microsoft')->getName(), $bits);
        }

        if ($isWindows && $utils->checkIfContains('ARM;')) {
            return new Os($useragent, 'Windows RT', Windows::detectVersion($useragent), CompanyFactory::get('Microsoft')->getName(), $bits);
        }

        if ($isWindows) {
            return new Os($useragent, 'Windows', Windows::detectVersion($useragent), CompanyFactory::get('Microsoft')->getName(), $bits);
        }

        if (preg_match('/(SymbianOS|SymbOS|Symbian|Series 60|Series40|S60V3|S60V5)/', $useragent)) {
            return new Os($useragent, 'Symbian OS', new Version(0), CompanyFactory::get('SymbianFoundation')->getName(), $bits);
        }

        if ($utils->checkIfContains('Bada')) {
            return new Os($useragent, 'Bada', VersionFactory::detectVersion($useragent, ['Bada']), CompanyFactory::get('Samsung')->getName(), $bits);
        }

        if ($utils->checkIfContains('MeeGo')) {
            return new Os($useragent, 'MeeGo', VersionFactory::detectVersion($useragent, ['MeeGo']), CompanyFactory::get('LinuxFoundation')->getName(), $bits);
        }

        if (preg_match('/(maemo|like android|linux\/x2\/r1|linux armv)/i', $useragent)) {
            return new Os($useragent, 'Linux Smartphone OS', VersionFactory::detectVersion($useragent, ['Maemo']), CompanyFactory::get('LinuxFoundation')->getName(), $bits);
        }

        if (preg_match('/(BlackBerry|BB10)/', $useragent)) {
            return new Os($useragent, 'RIM OS', RimOs::detectVersion($useragent), CompanyFactory::get('Rim')->getName(), $bits);
        }

        if (preg_match('/(webos|hpwos)/i', $useragent)) {
            return new Os($useragent, 'webOS', VersionFactory::detectVersion($useragent, ['WebOS', 'webOS', 'hpwOS']), CompanyFactory::get('Hp')->getName(), $bits);
        }

        if ($utils->checkIfContains('Tizen')) {
            return new Os($useragent, 'Tizen', VersionFactory::detectVersion($useragent, ['Tizen']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ((new FirefoxOsHelper($useragent))->isFirefoxOs()) {
            return new Os($useragent, 'FirefoxOS', FirefoxOs::detectVersion($useragent), CompanyFactory::get('MozillaFoundation')->getName(), $bits);
        }

        if ($utils->checkIfContains(['darwin', 'cfnetwork'], true)) {
            return Platform\DarwinFactory::detect($useragent);
        }

        if ($utils->checkIfContains('playstation', true)) {
            return new Os($useragent, 'CellOS', new Version(0), CompanyFactory::get('Sony')->getName(), $bits);
        }

        if (preg_match('/(micromaxx650|dolfin\/|yuanda50|wap[ \-]browser)/i', $useragent)) {
            return new Os($useragent, 'Java', new Version(0), CompanyFactory::get('Oracle')->getName(), $bits);
        }

        if (preg_match('/(android|silk|juc\(linux;u;|juc \(linux; u;|adr |gingerbread|mtk;|ucweb\/2\.0 \(linux; u; opera mini|maui|spreadtrum|vre;|linux; googletv)/i', $useragent)) {
            return new Os($useragent, 'Android', AndroidOs::detectVersion($useragent), CompanyFactory::get('Google')->getName(), $bits);
        }

        if (preg_match('/(IphoneOSX|iPhone OS|like Mac OS X|iPad|IPad|iPhone|iPod|CPU OS|CPU iOS|IUC\(U;iOS)/', $useragent)
            && false === stripos($useragent, 'technipad')
        ) {
            return new Os($useragent, 'iOS', Ios::detectVersion($useragent), CompanyFactory::get('Apple')->getName(), $bits);
        }

        if (preg_match('/(profile)/i', $useragent)) {
            return new Os($useragent, 'Java', new Version(0), CompanyFactory::get('Oracle'));
        }

        if (preg_match('/Linux; U; (\d+[\d\.]+)/', $useragent, $matches) && $matches[1] >= 4) {
            return new Os($useragent, 'Android', AndroidOs::detectVersion($useragent), CompanyFactory::get('Google')->getName(), $bits);
        }

        if (preg_match('/(Macintosh|Mac_PowerPC|PPC|68K)/', $useragent)
            && !$utils->checkIfContains('OS X')
        ) {
            return new Os($useragent, 'Macintosh', VersionFactory::detectVersion($useragent, ['Macintosh']), CompanyFactory::get('Apple')->getName(), $bits);
        }

        if (preg_match('/(Macintosh|Mac OS X)/', $useragent)) {
            $detectedVersion = Macosx::detectVersion($useragent);

            if (10.12 <= (float) $detectedVersion->getVersion(Version::MAJORMINOR)) {
                $osName = 'macOS';
            } else {
                $osName = 'Mac OS X';
            }

            return new Os($useragent, $osName, $detectedVersion, CompanyFactory::get('Apple')->getName(), $bits);
        }

        if ($utils->checkIfContains('debian', true)) {
            return new Os($useragent, 'Debian', Debian::detectVersion($useragent), CompanyFactory::get('SoftwareInThePublicInterest')->getName(), $bits);
        }

        if ($utils->checkIfContains('kubuntu', true)) {
            return new Os($useragent, 'Kubuntu', VersionFactory::detectVersion($useragent, ['Kubuntu', 'kubuntu']), CompanyFactory::get('Canonical')->getName(), $bits);
        }

        if ($utils->checkIfContains('ubuntu', true)) {
            return new Os($useragent, 'Ubuntu', VersionFactory::detectVersion($useragent, ['Ubuntu', 'ubuntu']), CompanyFactory::get('Canonical')->getName(), $bits);
        }

        if ($utils->checkIfContains(['RIM Tablet'])) {
            return new Os($useragent, 'RIM Tablet OS', VersionFactory::detectVersion($useragent, ['RIM Tablet OS']), CompanyFactory::get('Rim')->getName(), $bits);
        }

        if ($utils->checkIfContains('centos', true)) {
            return new Os($useragent, 'CentOS Linux', new Version(0), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('CrOS')) {
            return new Os($useragent, 'ChromeOS', VersionFactory::detectVersion($useragent, ['CrOS']), CompanyFactory::get('Google')->getName(), $bits);
        }

        if ($utils->checkIfContains('Joli OS')) {
            return new Os($useragent, 'Joli OS', VersionFactory::detectVersion($useragent, ['Joli OS']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('mandriva', true)) {
            return new Os($useragent, 'Mandriva Linux', new Version(0), CompanyFactory::get('Mandriva')->getName(), $bits);
        }

        if ($utils->checkIfContainsAll(['mint', 'linux'], true)) {
            return new Os($useragent, 'Linux Mint', VersionFactory::detectVersion($useragent, ['Mint', 'mint']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('suse', true)) {
            return new Os($useragent, 'Suse Linux', new Version(0), CompanyFactory::get('Suse')->getName(), $bits);
        }

        if ($utils->checkIfContains('fedora', true)) {
            return new Os($useragent, 'Fedora Linux', new Version(0), CompanyFactory::get('Redhat')->getName(), $bits);
        }

        if ($utils->checkIfContains('gentoo', true)) {
            return new Os($useragent, 'Gentoo Linux', new Version(0), CompanyFactory::get('Gentoo')->getName(), $bits);
        }

        if ($utils->checkIfContains(['redhat', 'red hat'], true)) {
            return new Os($useragent, 'Redhat Linux', new Version(0), CompanyFactory::get('Redhat')->getName(), $bits);
        }

        if ($utils->checkIfContains('slackware', true)) {
            return new Os($useragent, 'Slackware Linux', VersionFactory::detectVersion($useragent, ['Slackware']), CompanyFactory::get('Slackware')->getName(), $bits);
        }

        if ($utils->checkIfContains('ventana', true)) {
            return new Os($useragent, 'Ventana Linux', VersionFactory::detectVersion($useragent, ['Ventana Linux', 'Ventana']), CompanyFactory::get('Ventana')->getName(), $bits);
        }

        if ($utils->checkIfContains('Moblin')) {
            return new Os($useragent, 'Moblin', new Version(0), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('Zenwalk GNU')) {
            return new Os($useragent, 'Zenwalk GNU Linux', new Version(0), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('AIX')) {
            return new Os($useragent, 'AIX', VersionFactory::detectVersion($useragent, ['AIX']), CompanyFactory::get('Ibm')->getName(), $bits);
        }

        if ($utils->checkIfContains('AmigaOS')) {
            return new Os($useragent, 'Amiga OS', VersionFactory::detectVersion($useragent, ['AmigaOS']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('BREW')) {
            return new Os($useragent, 'Brew', VersionFactory::detectVersion($useragent, ['BREW']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('cygwin', true)) {
            return new Os($useragent, 'Cygwin', new Version(0), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('freebsd', true)) {
            return new Os($useragent, 'FreeBSD', VersionFactory::detectVersion($useragent, ['FreeBSD', 'freebsd']), CompanyFactory::get('FreeBsdFoundation')->getName(), $bits);
        }

        if ($utils->checkIfContains('NetBSD')) {
            return new Os($useragent, 'NetBSD', VersionFactory::detectVersion($useragent, ['NetBSD']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('OpenBSD')) {
            return new Os($useragent, 'OpenBSD', VersionFactory::detectVersion($useragent, ['OpenBSD']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('DragonFly')) {
            return new Os($useragent, 'DragonFly BSD', VersionFactory::detectVersion($useragent, ['DragonFly']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('BSD Four')) {
            return new Os($useragent, 'BSD', VersionFactory::detectVersion($useragent, ['BSD']), CompanyFactory::get('BerkleyUniversity')->getName(), $bits);
        }

        if ($utils->checkIfContainsAll(['HP-UX', 'HPUX'])) {
            return new Os($useragent, 'HP-UX', VersionFactory::detectVersion($useragent, ['HP-UX']), CompanyFactory::get('Hp')->getName(), $bits);
        }

        if ($utils->checkIfContainsAll(['BeOS'])) {
            return new Os($useragent, 'BeOS', VersionFactory::detectVersion($useragent, ['BeOS']), CompanyFactory::get('Access')->getName(), $bits);
        }

        if ($utils->checkIfContains(['IRIX64', 'IRIX'])) {
            return new Os($useragent, 'IRIX', VersionFactory::detectVersion($useragent, ['IRIX']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('solaris', true)) {
            return new Os($useragent, 'Solaris', VersionFactory::detectVersion($useragent, ['Solaris']), CompanyFactory::get('Oracle')->getName(), $bits);
        }

        if ($utils->checkIfContains('sunos', true)) {
            return new Os($useragent, 'SunOS', VersionFactory::detectVersion($useragent, ['SunOS']), CompanyFactory::get('Oracle')->getName(), $bits);
        }

        if ($utils->checkIfContains('RISC')) {
            return new Os($useragent, 'RISC OS', VersionFactory::detectVersion($useragent, ['RISC']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('OpenVMS')) {
            return new Os($useragent, 'OpenVMS', VersionFactory::detectVersion($useragent, ['OpenVMS']), CompanyFactory::get('Hp')->getName(), $bits);
        }

        if ($utils->checkIfContains(['Tru64 UNIX', 'Digital Unix'])) {
            return new Os($useragent, 'Tru64 UNIX', VersionFactory::detectVersion($useragent, ['Tru64 UNIX', 'Digital Unix']), CompanyFactory::get('Hp')->getName(), $bits);
        }

        if ($utils->checkIfContains('unix', true)) {
            return new Os($useragent, 'Unix', VersionFactory::detectVersion($useragent, ['Unix']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains(['os/2', 'warp'], true)) {
            return new Os($useragent, 'OS/2', VersionFactory::detectVersion($useragent, ['OS\/2', 'Warp']), CompanyFactory::get('Ibm')->getName(), $bits);
        }

        if ($utils->checkIfContains(['nettv', 'hbbtv', 'smart-tv', 'linux', 'x11', 'dillo', 'installatron', 'lynx'], true)) {
            return new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits);
        }

        if ($utils->checkIfContains('CP/M')) {
            return new Os($useragent, 'CP/M', new Version(0), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains(['Nintendo Wii', 'Nintendo 3DS'])) {
            return new Os($useragent, 'Nintendo OS', new Version(0), CompanyFactory::get('Nintendo')->getName(), $bits);
        }

        if ($utils->checkIfContains(['Nokia'])) {
            return new Os($useragent, 'Nokia OS', new Version(0), CompanyFactory::get('Nokia')->getName(), $bits);
        }

        if ($utils->checkIfContains('ruby', true)) {
            return new Os($useragent, 'Ruby', new Version(0), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('Palm OS')) {
            return new Os($useragent, 'PalmOS', VersionFactory::detectVersion($useragent, ['PalmOS']), CompanyFactory::get('Palm')->getName(), $bits);
        }

        if ($utils->checkIfContains('WyderOS')) {
            return new Os($useragent, 'WyderOS', VersionFactory::detectVersion($useragent, ['WyderOS']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if ($utils->checkIfContains('Liberate')) {
            return new Os($useragent, 'Liberate', VersionFactory::detectVersion($useragent, ['Liberate']), CompanyFactory::get('Unknown')->getName(), $bits);
        }

        if (preg_match('/(Java|J2ME\/MIDP|Profile\/MIDP|JUC|UCWEB|NetFront|Nokia|Jasmine\/1.0|JavaPlatform|WAP\/OBIGO|Obigo\/WAP|Dolfin\/)/', $useragent)) {
            return new Os($useragent, 'Java', new Version(0), CompanyFactory::get('Oracle')->getName(), $bits);
        }

        return new Os($useragent, 'unknown', new Version(0), CompanyFactory::get('Unknown')->getName(), $bits);
    }
}
