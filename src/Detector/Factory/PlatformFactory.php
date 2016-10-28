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
use BrowserDetector\Helper;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use UaHelper\Utils;
use BrowserDetector\Detector\Bits\Os as OsBits;

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
        $windowsHelper = new Helper\Windows($agent);

        $platformCode = 'unknown';

        if (!$windowsHelper->isMobileWindows()
            && $windowsHelper->isWindows()
        ) {
            $isWindows = true;
        }

        if ($windowsHelper->isMobileWindows()
            && $utils->checkIfContains(['Windows CE', 'Windows Mobile; WCE'])
        ) {
            $platformCode = 'windows ce';
        } elseif (preg_match('/(Windows Phone OS|XBLWP7|ZuneWP7|Windows Phone|WPDesktop| wds )/', $agent)) {
            $doMatchPhone = preg_match('/Windows Phone ([\d\.]+)/', $agent, $matchesPhone);

            if (!$doMatchPhone || $matchesPhone[1] >= 7) {
                $platformCode = 'windows phone os';
            } else {
                $platformCode = 'windows mobile os';
            }
        } elseif ($windowsHelper->isMobileWindows()) {
            if (preg_match('/mobile version([\d]+)/', $agent, $matchesMobile) && $matchesMobile[1] >= 70) {
                $platformCode = 'windows phone os';
            } elseif (preg_match('/Windows Mobile ([\d]+)/', $agent, $matchesMobile) && (float) $matchesMobile[1] >= 7.0) {
                $platformCode = 'windows phone os';
            } elseif (preg_match('/Windows NT ([\d\.]+); ARM; Lumia/', $agent, $matchesMobile) && (float) $matchesMobile[1] >= 7.0) {
                $platformCode = 'windows phone os';
            } else {
                $platformCode = 'windows mobile os';
            }
        } elseif ($isWindows && $utils->checkIfContains('ARM;')) {
            $platformCode = 'windows rt';
        } elseif ($isWindows) {
            return Platform\WindowsFactory::detect($agent);
        } elseif (preg_match('/(SymbianOS|SymbOS|Symbian|Series 60|S60V3|S60V5)/', $agent)) {
            $platformCode = 'symbian os';
        } elseif (preg_match('/(Series40)/', $agent)) {
            $platformCode = 'nokia os';
        } elseif ($utils->checkIfContains('Bada')) {
            $platformCode = 'bada';
        } elseif ($utils->checkIfContains('MeeGo')) {
            $platformCode = 'meego';
        } elseif (preg_match('/sailfish/i', $agent)) {
            $platformCode = 'sailfishos';
        } elseif (preg_match('/(android; linux arm)/i', $agent)) {
            $platformCode = 'android';
        } elseif ($utils->checkIfContains('Debian APT-HTTP')) {
            $platformCode = 'debian';
        } elseif ($utils->checkIfContains('linux mint', true)) {
            $platformCode = 'linux mint';
        } elseif ($utils->checkIfContains('kubuntu', true)) {
            $platformCode = 'kubuntu';
        } elseif ($utils->checkIfContains('ubuntu', true)) {
            $platformCode = 'ubuntu';
        } elseif ($utils->checkIfContains('fedora', true)) {
            $platformCode = 'fedora linux';
        } elseif ($utils->checkIfContains(['redhat', 'red hat'], true)) {
            $platformCode = 'redhat linux';
        } elseif (preg_match('/(maemo|like android|linux\/x2\/r1|linux arm)/i', $agent)) {
            $platformCode = 'linux smartphone os (maemo)';
        } elseif (preg_match('/(BlackBerry|BB10)/', $agent)) {
            $platformCode = 'rim os';
        } elseif (preg_match('/(webos|hpwos)/i', $agent)) {
            $platformCode = 'webos';
        } elseif ($utils->checkIfContains('Tizen')) {
            $platformCode = 'tizen';
        } elseif ((new Helper\FirefoxOs($agent))->isFirefoxOs()) {
            $platformCode = 'firefoxos';
        } elseif ($utils->checkIfContainsAll(['freebsd', 'kfreebsd'], true)) {
            $platformCode = 'debian with freebsd kernel';
        } elseif ($utils->checkIfContains('freebsd', true)) {
            $platformCode = 'freebsd';
        } elseif ($utils->checkIfContains(['darwin', 'cfnetwork'], true)) {
            return Platform\DarwinFactory::detect($agent);
        } elseif ($utils->checkIfContains('playstation', true)) {
            $platformCode = 'cellos';
        } elseif (preg_match('/(micromaxx650|dolfin\/|yuanda50|wap[ \-]browser)/i', $agent)) {
            $platformCode = 'java';
        } elseif (preg_match('/CommonCrawler/', $agent)) {
            $platformCode = 'unknown';
        } elseif (preg_match('/MIUI/', $agent)) {
            $platformCode = 'miui os';
        } elseif ((new Helper\AndroidOs($agent))->isAndroid()) {
            $platformCode = 'android';
        } elseif ((new Helper\Ios($agent))->isIos()) {
            $platformCode = 'ios';
        } elseif (preg_match('/\b(profile)\b/i', $agent)) {
            $platformCode = 'java';
        } elseif (preg_match('/Linux; U; (\d+[\d\.]+)/', $agent, $matches) && $matches[1] >= 4) {
            $platformCode = 'android';
        } elseif (preg_match('/(Macintosh|Mac_PowerPC|PPC|68K)/', $agent)
            && !$utils->checkIfContains('OS X')
        ) {
            $platformCode = 'macintosh';
        } elseif (preg_match('/(de|rasp)bian/i', $agent)) {
            $platformCode = 'debian';
        } elseif (preg_match('/(Macintosh|Mac OS X)/', $agent)) {
            $platformCode = 'mac os x';
        } elseif ($utils->checkIfContains(['RIM Tablet'])) {
            $platformCode = 'rim tablet os';
        } elseif ($utils->checkIfContains('centos', true)) {
            $platformCode = 'cent os linux';
        } elseif ($utils->checkIfContains('CrOS')) {
            $platformCode = 'chromeos';
        } elseif ($utils->checkIfContains('Joli OS')) {
            $platformCode = 'joli os';
        } elseif ($utils->checkIfContains('mandriva', true)) {
            $platformCode = 'mandriva linux';
        } elseif ($utils->checkIfContains('suse', true)) {
            $platformCode = 'suse linux';
        } elseif ($utils->checkIfContains('gentoo', true)) {
            $platformCode = 'gentoo linux';
        } elseif ($utils->checkIfContains('slackware', true)) {
            $platformCode = 'slackware linux';
        } elseif ($utils->checkIfContains('ventana', true)) {
            $platformCode = 'ventana linux';
        } elseif ($utils->checkIfContains('moblin', true)) {
            $platformCode = 'moblin';
        } elseif ($utils->checkIfContains('Zenwalk GNU')) {
            $platformCode = 'zenwalk gnu linux';
        } elseif ($utils->checkIfContains('AIX')) {
            $platformCode = 'aix';
        } elseif ($utils->checkIfContains('AmigaOS')) {
            $platformCode = 'amiga os';
        } elseif ($utils->checkIfContains('BREW')) {
            $platformCode = 'brew';
        } elseif ($utils->checkIfContains('cygwin', true)) {
            $platformCode = 'cygwin';
        } elseif ($utils->checkIfContains('NetBSD')) {
            $platformCode = 'netbsd';
        } elseif ($utils->checkIfContains('OpenBSD')) {
            $platformCode = 'openbsd';
        } elseif ($utils->checkIfContains('DragonFly')) {
            $platformCode = 'dragonfly bsd';
        } elseif ($utils->checkIfContains('BSD Four')) {
            $platformCode = 'bsd';
        } elseif ($utils->checkIfContains(['HP-UX', 'HPUX'])) {
            $platformCode = 'hp-ux';
        } elseif ($utils->checkIfContains(['beos'], true)) {
            $platformCode = 'beos';
        } elseif ($utils->checkIfContains(['IRIX64', 'IRIX'])) {
            $platformCode = 'irix';
        } elseif ($utils->checkIfContains('solaris', true)) {
            $platformCode = 'solaris';
        } elseif ($utils->checkIfContains('sunos', true)) {
            $platformCode = 'sunos';
        } elseif ($utils->checkIfContains('RISC')) {
            $platformCode = 'risc os';
        } elseif ($utils->checkIfContains('OpenVMS')) {
            $platformCode = 'openvms';
        } elseif ($utils->checkIfContains(['Tru64 UNIX', 'Digital Unix', 'OSF1'])) {
            $platformCode = 'tru64 unix';
        } elseif ($utils->checkIfContains('unix', true)) {
            $platformCode = 'unix';
        } elseif ($utils->checkIfContains(['os/2', 'warp'], true)) {
            $platformCode = 'os/2';
        } elseif ((new Helper\Linux($agent))->isLinux()) {
            $platformCode = 'linux';
        } elseif ($utils->checkIfContains('CP/M')) {
            $platformCode = 'cp/m';
        } elseif ($utils->checkIfContains(['Nintendo Wii', 'Nintendo 3DS'])) {
            $platformCode = 'nintendo os';
        } elseif ($utils->checkIfContains(['Nokia'])) {
            $platformCode = 'nokia os';
        } elseif ($utils->checkIfContains('ruby', true)) {
            $platformCode = 'ruby';
        } elseif ($utils->checkIfContains(['Palm OS', 'PalmSource'])) {
            $platformCode = 'palmos';
        } elseif ($utils->checkIfContains('WyderOS')) {
            $platformCode = 'wyderos';
        } elseif ($utils->checkIfContains('Liberate')) {
            $platformCode = 'liberate';
        } elseif ($utils->checkIfContains('Inferno')) {
            $platformCode = 'inferno os';
        } elseif ($utils->checkIfContains('Syllable')) {
            $platformCode = 'syllable';
        } elseif ($utils->checkIfContains(['Camino', 'PubSub', 'integrity'])) {
            $platformCode = 'mac os x';
        } elseif (preg_match('/(Java|J2ME\/MIDP|Profile\/MIDP|JUC|UCWEB|NetFront|Nokia|Jasmine\/1.0|JavaPlatform|WAP\/OBIGO|Obigo\/WAP|Dolfin\/|Spark284|Lemon B556|KKT20|GT\-C3312R)/', $agent)) {
            $platformCode = 'java';
        } elseif (preg_match('/(GT\-S5380)/', $agent)) {
            $platformCode = 'bada';
        } elseif (preg_match('/(Velocitymicro\/T408)/', $agent)) {
            $platformCode = 'android';
        }

        return self::get($platformCode, $agent);
    }

    /**
     * @param string $platformCode
     * @param string $useragent
     * @param string|null   $inputVersion
     *
     * @return \UaResult\Os\Os
     */
    public static function get($platformCode, $useragent, $inputVersion = null)
    {
        static $platforms = null;

        if (null === $platforms) {
            $platforms = json_decode(file_get_contents(__DIR__ . '/data/platforms.json'));
        }

        if (!isset($platforms->$platformCode)) {
            return new \UaResult\Os\Os(
                'unknown',
                'unknown',
                'unknown',
                'unknown',
                new Version(0)
            );
        }

        $engineVersionClass = $platforms->$platformCode->version->class;

        if (null !== $inputVersion && is_string($inputVersion)) {
            $version = VersionFactory::set($inputVersion);
        } elseif (!is_string($engineVersionClass)) {
            $version = new Version(0);
        } elseif ('VersionFactory' === $engineVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $platforms->$platformCode->version->search);
        } else {
            $version = $engineVersionClass::detectVersion($useragent);
        }

        return new \UaResult\Os\Os(
            $platforms->$platformCode->name,
            $platforms->$platformCode->marketingName,
            $platforms->$platformCode->manufacturer,
            $platforms->$platformCode->brand,
            $version,
            (new OsBits($useragent))->getBits()
        );
    }
}
