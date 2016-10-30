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

namespace BrowserDetector\Factory;

use BrowserDetector\Bits\Os as OsBits;
use BrowserDetector\Helper;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Stringy\Stringy;
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
     * @param string $agent
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect($agent)
    {
        $s = new Stringy($agent);

        $isWindows     = false;
        $windowsHelper = new Helper\Windows($agent);

        $platformCode = 'unknown';

        if (!$windowsHelper->isMobileWindows()
            && $windowsHelper->isWindows()
        ) {
            $isWindows = true;
        }

        if ($windowsHelper->isMobileWindows()
            && $s->containsAny(['Windows CE', 'Windows Mobile; WCE'])
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
        } elseif ($isWindows && $s->contains('ARM;')) {
            $platformCode = 'windows rt';
        } elseif ($isWindows) {
            return (new Platform\WindowsFactory())->detect($agent);
        } elseif (preg_match('/(SymbianOS|SymbOS|Symbian|Series 60|S60V3|S60V5)/', $agent)) {
            $platformCode = 'symbian os';
        } elseif (preg_match('/(Series40)/', $agent)) {
            $platformCode = 'nokia os';
        } elseif ($s->contains('Bada')) {
            $platformCode = 'bada';
        } elseif ($s->contains('MeeGo')) {
            $platformCode = 'meego';
        } elseif (preg_match('/sailfish/i', $agent)) {
            $platformCode = 'sailfishos';
        } elseif (preg_match('/(android; linux arm)/i', $agent)) {
            $platformCode = 'android';
        } elseif ($s->contains('Debian APT-HTTP')) {
            $platformCode = 'debian';
        } elseif ($s->contains('linux mint', true)) {
            $platformCode = 'linux mint';
        } elseif ($s->contains('kubuntu', true)) {
            $platformCode = 'kubuntu';
        } elseif ($s->contains('ubuntu', true)) {
            $platformCode = 'ubuntu';
        } elseif ($s->contains('fedora', true)) {
            $platformCode = 'fedora linux';
        } elseif ($s->containsAny(['redhat', 'red hat'], true)) {
            $platformCode = 'redhat linux';
        } elseif (preg_match('/(maemo|like android|linux\/x2\/r1|linux arm)/i', $agent)) {
            $platformCode = 'linux smartphone os (maemo)';
        } elseif (preg_match('/(BlackBerry|BB10)/', $agent)) {
            $platformCode = 'rim os';
        } elseif (preg_match('/(webos|hpwos)/i', $agent)) {
            $platformCode = 'webos';
        } elseif ($s->contains('Tizen')) {
            $platformCode = 'tizen';
        } elseif ((new Helper\FirefoxOs($agent))->isFirefoxOs()) {
            $platformCode = 'firefoxos';
        } elseif ($s->containsAll(['freebsd', 'kfreebsd'], true)) {
            $platformCode = 'debian with freebsd kernel';
        } elseif ($s->contains('freebsd', true)) {
            $platformCode = 'freebsd';
        } elseif ($s->containsAny(['darwin', 'cfnetwork'], true)) {
            return (new Platform\DarwinFactory())->detect($agent);
        } elseif ($s->contains('playstation', true)) {
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
            && !$s->contains('OS X')
        ) {
            $platformCode = 'macintosh';
        } elseif (preg_match('/(de|rasp)bian/i', $agent)) {
            $platformCode = 'debian';
        } elseif (preg_match('/(Macintosh|Mac OS X)/', $agent)) {
            $platformCode = 'mac os x';
        } elseif ($s->containsAny(['RIM Tablet'])) {
            $platformCode = 'rim tablet os';
        } elseif ($s->contains('centos', true)) {
            $platformCode = 'cent os linux';
        } elseif ($s->contains('CrOS')) {
            $platformCode = 'chromeos';
        } elseif ($s->contains('Joli OS')) {
            $platformCode = 'joli os';
        } elseif ($s->contains('mandriva', true)) {
            $platformCode = 'mandriva linux';
        } elseif ($s->contains('suse', true)) {
            $platformCode = 'suse linux';
        } elseif ($s->contains('gentoo', true)) {
            $platformCode = 'gentoo linux';
        } elseif ($s->contains('slackware', true)) {
            $platformCode = 'slackware linux';
        } elseif ($s->contains('ventana', true)) {
            $platformCode = 'ventana linux';
        } elseif ($s->contains('moblin', true)) {
            $platformCode = 'moblin';
        } elseif ($s->contains('Zenwalk GNU')) {
            $platformCode = 'zenwalk gnu linux';
        } elseif ($s->contains('AIX')) {
            $platformCode = 'aix';
        } elseif ($s->contains('AmigaOS')) {
            $platformCode = 'amiga os';
        } elseif ($s->contains('BREW')) {
            $platformCode = 'brew';
        } elseif ($s->contains('cygwin', true)) {
            $platformCode = 'cygwin';
        } elseif ($s->contains('NetBSD')) {
            $platformCode = 'netbsd';
        } elseif ($s->contains('OpenBSD')) {
            $platformCode = 'openbsd';
        } elseif ($s->contains('DragonFly')) {
            $platformCode = 'dragonfly bsd';
        } elseif ($s->contains('BSD Four')) {
            $platformCode = 'bsd';
        } elseif ($s->containsAny(['HP-UX', 'HPUX'])) {
            $platformCode = 'hp-ux';
        } elseif ($s->containsAny(['beos'], true)) {
            $platformCode = 'beos';
        } elseif ($s->containsAny(['IRIX64', 'IRIX'])) {
            $platformCode = 'irix';
        } elseif ($s->contains('solaris', true)) {
            $platformCode = 'solaris';
        } elseif ($s->contains('sunos', true)) {
            $platformCode = 'sunos';
        } elseif ($s->contains('RISC')) {
            $platformCode = 'risc os';
        } elseif ($s->contains('OpenVMS')) {
            $platformCode = 'openvms';
        } elseif ($s->containsAny(['Tru64 UNIX', 'Digital Unix', 'OSF1'])) {
            $platformCode = 'tru64 unix';
        } elseif ($s->contains('unix', true)) {
            $platformCode = 'unix';
        } elseif ($s->containsAny(['os/2', 'warp'], true)) {
            $platformCode = 'os/2';
        } elseif ((new Helper\Linux($agent))->isLinux()) {
            $platformCode = 'linux';
        } elseif ($s->contains('CP/M')) {
            $platformCode = 'cp/m';
        } elseif ($s->containsAny(['Nintendo Wii', 'Nintendo 3DS'])) {
            $platformCode = 'nintendo os';
        } elseif ($s->containsAny(['Nokia'])) {
            $platformCode = 'nokia os';
        } elseif ($s->contains('ruby', true)) {
            $platformCode = 'ruby';
        } elseif ($s->containsAny(['Palm OS', 'PalmSource'])) {
            $platformCode = 'palmos';
        } elseif ($s->contains('WyderOS')) {
            $platformCode = 'wyderos';
        } elseif ($s->contains('Liberate')) {
            $platformCode = 'liberate';
        } elseif ($s->contains('Inferno')) {
            $platformCode = 'inferno os';
        } elseif ($s->contains('Syllable')) {
            $platformCode = 'syllable';
        } elseif ($s->containsAny(['Camino', 'PubSub', 'integrity'])) {
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
     * @param string      $platformCode
     * @param string      $useragent
     * @param string|null $inputVersion
     *
     * @return \UaResult\Os\OsInterface
     */
    public function get($platformCode, $useragent, $inputVersion = null)
    {
        static $platforms = null;

        if (null === $platforms) {
            $platforms = json_decode(file_get_contents(__DIR__ . '/../../data/platforms.json'));
        }

        if (!isset($platforms->$platformCode)) {
            return new Os(
                'unknown',
                'unknown',
                'unknown',
                'unknown',
                new Version(0)
            );
        }

        $platformVersionClass = $platforms->$platformCode->version->class;

        if (null !== $inputVersion && is_string($inputVersion)) {
            $version = VersionFactory::set($inputVersion);
        } elseif (!is_string($platformVersionClass)) {
            $version = new Version(0);
        } elseif ('VersionFactory' === $platformVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $platforms->$platformCode->version->search);
        } else {
            /** @var \BrowserDetector\Version\VersionFactoryInterface $platformVersionClass */
            $version = $platformVersionClass::detectVersion($useragent);
        }

        return new Os(
            $platforms->$platformCode->name,
            $platforms->$platformCode->marketingName,
            $platforms->$platformCode->manufacturer,
            $platforms->$platformCode->brand,
            $version,
            (new OsBits($useragent))->getBits()
        );
    }
}
