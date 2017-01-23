<?php
/**
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
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
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Factory;

use BrowserDetector\Helper;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;
use UaResult\Os\OsFactory;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class PlatformFactory implements FactoryInterface, FactoryFromInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
        $this->loader = $loader;
    }

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
                $platformCode = 'windows phone';
            } else {
                $platformCode = 'windows mobile os';
            }
        } elseif ($windowsHelper->isMobileWindows()) {
            if (preg_match('/mobile version([\d]+)/', $agent, $matchesMobile) && $matchesMobile[1] >= 70) {
                $platformCode = 'windows phone';
            } elseif (preg_match('/Windows Mobile ([\d]+)/', $agent, $matchesMobile) && (float) $matchesMobile[1] >= 7.0) {
                $platformCode = 'windows phone';
            } elseif (preg_match('/Windows NT ([\d\.]+); ARM; Lumia/', $agent, $matchesMobile) && (float) $matchesMobile[1] >= 7.0) {
                $platformCode = 'windows phone';
            } else {
                $platformCode = 'windows mobile os';
            }
        } elseif ($isWindows && $s->contains('ARM;')) {
            $platformCode = 'windows rt';
        } elseif ($isWindows) {
            return (new Platform\WindowsFactory($this->cache, $this->loader))->detect($agent);
        } elseif (preg_match('/(SymbianOS|SymbOS|Symbian|Series 60|S60V3|S60V5)/', $agent)) {
            $platformCode = 'symbian';
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
        } elseif ($s->containsAny(['debian apt-http', 'linux mint', 'ubuntu', 'fedora', 'redhat', 'red hat', 'kfreebsd', 'centos', 'mandriva', 'suse', 'gentoo', 'slackware', 'ventana', 'moblin'], false)) {
            return (new Platform\LinuxFactory($this->cache, $this->loader))->detect($agent);
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
        } elseif ($s->contains('freebsd', false)) {
            $platformCode = 'freebsd';
        } elseif ($s->containsAny(['darwin', 'cfnetwork'], false)) {
            return (new Platform\DarwinFactory($this->cache, $this->loader))->detect($agent);
        } elseif ($s->contains('playstation', false)) {
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
            return (new Platform\LinuxFactory($this->cache, $this->loader))->detect($agent);
        } elseif (preg_match('/(Macintosh|Mac OS X)/', $agent)) {
            $platformCode = 'mac os x';
        } elseif ($s->containsAny(['RIM Tablet'])) {
            $platformCode = 'rim tablet os';
        } elseif ($s->containsAny(['CrOS', 'Joli OS', 'Zenwalk GNU'])) {
            return (new Platform\LinuxFactory($this->cache, $this->loader))->detect($agent);
        } elseif ($s->contains('AIX')) {
            $platformCode = 'aix';
        } elseif ($s->contains('AmigaOS')) {
            $platformCode = 'amiga os';
        } elseif ($s->contains('BREW')) {
            $platformCode = 'brew';
        } elseif ($s->contains('cygwin', false)) {
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
        } elseif ($s->containsAny(['beos'], false)) {
            $platformCode = 'beos';
        } elseif ($s->containsAny(['IRIX64', 'IRIX'])) {
            $platformCode = 'irix';
        } elseif ($s->contains('solaris', false)) {
            $platformCode = 'solaris';
        } elseif ($s->contains('sunos', false)) {
            $platformCode = 'sunos';
        } elseif ($s->contains('RISC')) {
            $platformCode = 'risc os';
        } elseif ($s->contains('OpenVMS')) {
            $platformCode = 'openvms';
        } elseif ($s->containsAny(['Tru64 UNIX', 'Digital Unix', 'OSF1'])) {
            $platformCode = 'tru64 unix';
        } elseif ($s->contains('unix', false)) {
            $platformCode = 'unix';
        } elseif ($s->containsAny(['os/2', 'warp'], false)) {
            $platformCode = 'os/2';
        } elseif ((new Helper\Linux($agent))->isLinux()) {
            return (new Platform\LinuxFactory($this->cache, $this->loader))->detect($agent);
        } elseif ($s->contains('CP/M')) {
            $platformCode = 'cp/m';
        } elseif ($s->containsAny(['Nintendo Wii', 'Nintendo 3DS'])) {
            $platformCode = 'nintendo os';
        } elseif ($s->containsAny(['Nokia'])) {
            $platformCode = 'nokia os';
        } elseif ($s->contains('ruby', false)) {
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

        return $this->loader->load($platformCode, $agent);
    }

    /**
     * @param array $data
     *
     * @return \UaResult\Os\OsInterface
     */
    public function fromArray(array $data)
    {
        return (new OsFactory())->fromArray($data);
    }

    /**
     * @param string $json
     *
     * @return \UaResult\Os\OsInterface
     */
    public function fromJson($json)
    {
        return (new OsFactory())->fromJson($json);
    }
}
