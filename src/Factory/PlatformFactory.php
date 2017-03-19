<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use BrowserDetector\Helper;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
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
class PlatformFactory implements FactoryInterface
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
     * @param string $useragent
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect($useragent)
    {
        $s = new Stringy($useragent);

        $isWindows     = false;
        $windowsHelper = new Helper\Windows($useragent);

        if (!$windowsHelper->isMobileWindows()
            && $windowsHelper->isWindows()
        ) {
            $isWindows = true;
        }

        if ($windowsHelper->isMobileWindows()
            && $s->containsAny(['Windows CE', 'Windows Mobile; WCE'])
        ) {
            return $this->loader->load('windows ce', $useragent);
        }

        if (preg_match('/(Windows Phone OS|XBLWP7|ZuneWP7|Windows Phone|WPDesktop| wds )/', $useragent)) {
            $doMatchPhone = preg_match('/Windows Phone ([\d\.]+)/', $useragent, $matchesPhone);

            if (!$doMatchPhone || $matchesPhone[1] >= 7) {
                return $this->loader->load('windows phone', $useragent);
            }

            return $this->loader->load('windows mobile os', $useragent);
        }

        if ($windowsHelper->isMobileWindows()) {
            if (preg_match('/mobile version([\d]+)/', $useragent, $matchesMobile) && $matchesMobile[1] >= 70) {
                return $this->loader->load('windows phone', $useragent);
            }

            if (preg_match('/Windows Mobile ([\d]+)/', $useragent, $matchesMobile) && (float) $matchesMobile[1] >= 7.0) {
                return $this->loader->load('windows phone', $useragent);
            }

            if (preg_match('/Windows NT ([\d\.]+); ARM; Lumia/', $useragent, $matchesMobile) && (float) $matchesMobile[1] >= 7.0) {
                return $this->loader->load('windows phone', $useragent);
            }

            return $this->loader->load('windows mobile os', $useragent);
        }

        if ($isWindows && $s->contains('ARM;')) {
            return $this->loader->load('windows rt', $useragent);
        }

        if ($isWindows) {
            return (new Platform\WindowsFactory($this->cache, $this->loader))->detect($useragent);
        }

        if (preg_match('/(SymbianOS|SymbOS|Symbian|Series 60|S60V3|S60V5)/', $useragent)) {
            return $this->loader->load('symbian', $useragent);
        }

        if (preg_match('/(Series40)/', $useragent)) {
            return $this->loader->load('nokia os', $useragent);
        }

        if ($s->contains('Bada')) {
            return $this->loader->load('bada', $useragent);
        }

        if ($s->contains('MeeGo')) {
            return $this->loader->load('meego', $useragent);
        }

        if (preg_match('/sailfish/i', $useragent)) {
            return $this->loader->load('sailfishos', $useragent);
        }

        if (preg_match('/(android; linux arm)/i', $useragent)) {
            return $this->loader->load('android', $useragent);
        }

        if ($s->containsAny(['debian apt-http', 'linux mint', 'ubuntu', 'fedora', 'redhat', 'red hat', 'kfreebsd', 'centos', 'mandriva', 'suse', 'gentoo', 'slackware', 'ventana', 'moblin'], false)) {
            return (new Platform\LinuxFactory($this->cache, $this->loader))->detect($useragent);
        }

        if (preg_match('/(maemo|like android|linux\/x2\/r1|linux arm)/i', $useragent)) {
            return $this->loader->load('linux smartphone os (maemo)', $useragent);
        }

        if (preg_match('/(BlackBerry|BB10)/', $useragent)) {
            return $this->loader->load('rim os', $useragent);
        }

        if (preg_match('/(webos|hpwos)/i', $useragent)) {
            return $this->loader->load('webos', $useragent);
        }

        if ($s->contains('Tizen')) {
            return $this->loader->load('tizen', $useragent);
        }

        if ((new Helper\FirefoxOs($useragent))->isFirefoxOs()) {
            return $this->loader->load('firefoxos', $useragent);
        }

        if ($s->contains('freebsd', false)) {
            return $this->loader->load('freebsd', $useragent);
        }

        if ($s->containsAny(['darwin', 'cfnetwork'], false)) {
            return (new Platform\DarwinFactory($this->cache, $this->loader))->detect($useragent);
        }

        if ($s->contains('playstation', false)) {
            return $this->loader->load('cellos', $useragent);
        }

        if (preg_match('/(micromaxx650|dolfin\/|yuanda50|wap[ \-]browser)/i', $useragent)) {
            return $this->loader->load('java', $useragent);
        }

        if (preg_match('/CommonCrawler/', $useragent)) {
            return $this->loader->load('unknown', $useragent);
        }

        if (preg_match('/MIUI/', $useragent)) {
            return $this->loader->load('miui os', $useragent);
        }

        if ((new Helper\AndroidOs($useragent))->isAndroid()) {
            return $this->loader->load('android', $useragent);
        }

        if ((new Helper\Ios($useragent))->isIos()) {
            return $this->loader->load('ios', $useragent);
        }

        if (preg_match('/\b(profile)\b/i', $useragent)) {
            return $this->loader->load('java', $useragent);
        }

        if (preg_match('/Linux; U; (\d+[\d\.]+)/', $useragent, $matches) && $matches[1] >= 4) {
            return $this->loader->load('android', $useragent);
        }

        if (preg_match('/(Macintosh|Mac_PowerPC|PPC|68K)/', $useragent)
            && !$s->containsAny(['OS X', 'os=Mac 10'])
        ) {
            return $this->loader->load('macintosh', $useragent);
        }

        if (preg_match('/(de|rasp)bian/i', $useragent)) {
            return (new Platform\LinuxFactory($this->cache, $this->loader))->detect($useragent);
        }

        if ($s->containsAny(['macintosh', 'mac os x', 'os=mac 10'], false)) {
            return $this->loader->load('mac os x', $useragent);
        }

        if ($s->containsAny(['RIM Tablet'])) {
            return $this->loader->load('rim tablet os', $useragent);
        }

        if ($s->containsAny(['CrOS', 'Joli OS', 'Zenwalk GNU'])) {
            return (new Platform\LinuxFactory($this->cache, $this->loader))->detect($useragent);
        }

        if ($s->contains('AIX')) {
            return $this->loader->load('aix', $useragent);
        }

        if ($s->contains('AmigaOS')) {
            return $this->loader->load('amiga os', $useragent);
        }

        if ($s->contains('BREW')) {
            return $this->loader->load('brew', $useragent);
        }

        if ($s->contains('cygwin', false)) {
            return $this->loader->load('cygwin', $useragent);
        }

        if ($s->contains('NetBSD')) {
            return $this->loader->load('netbsd', $useragent);
        }

        if ($s->contains('OpenBSD')) {
            return $this->loader->load('openbsd', $useragent);
        }

        if ($s->contains('DragonFly')) {
            return $this->loader->load('dragonfly bsd', $useragent);
        }

        if ($s->contains('BSD Four')) {
            return $this->loader->load('bsd', $useragent);
        }

        if ($s->containsAny(['HP-UX', 'HPUX'])) {
            return $this->loader->load('hp-ux', $useragent);
        }

        if ($s->containsAny(['beos'], false)) {
            return $this->loader->load('beos', $useragent);
        }

        if ($s->containsAny(['IRIX64', 'IRIX'])) {
            return $this->loader->load('irix', $useragent);
        }

        if ($s->contains('solaris', false)) {
            return $this->loader->load('solaris', $useragent);
        }

        if ($s->contains('sunos', false)) {
            return $this->loader->load('sunos', $useragent);
        }

        if ($s->contains('RISC')) {
            return $this->loader->load('risc os', $useragent);
        }

        if ($s->contains('OpenVMS')) {
            return $this->loader->load('openvms', $useragent);
        }

        if ($s->containsAny(['Tru64 UNIX', 'Digital Unix', 'OSF1'])) {
            return $this->loader->load('tru64 unix', $useragent);
        }

        if ($s->contains('unix', false)) {
            return $this->loader->load('unix', $useragent);
        }

        if ($s->containsAny(['os/2', 'warp'], false)) {
            return $this->loader->load('os/2', $useragent);
        }

        if ((new Helper\Linux($useragent))->isLinux()) {
            return (new Platform\LinuxFactory($this->cache, $this->loader))->detect($useragent);
        }

        if ($s->contains('CP/M')) {
            return $this->loader->load('cp/m', $useragent);
        }

        if ($s->containsAny(['Nintendo Wii', 'Nintendo 3DS'])) {
            return $this->loader->load('nintendo os', $useragent);
        }

        if ($s->containsAny(['Nokia'])) {
            return $this->loader->load('nokia os', $useragent);
        }

        if ($s->contains('ruby', false)) {
            return $this->loader->load('ruby', $useragent);
        }

        if ($s->containsAny(['Palm OS', 'PalmSource'])) {
            return $this->loader->load('palmos', $useragent);
        }

        if ($s->contains('WyderOS')) {
            return $this->loader->load('wyderos', $useragent);
        }

        if ($s->contains('Liberate')) {
            return $this->loader->load('liberate', $useragent);
        }

        if ($s->contains('Inferno')) {
            return $this->loader->load('inferno os', $useragent);
        }

        if ($s->contains('Syllable')) {
            return $this->loader->load('syllable', $useragent);
        }

        if ($s->containsAny(['Camino', 'PubSub', 'integrity'])) {
            return $this->loader->load('mac os x', $useragent);
        }

        if (preg_match('/(Java|J2ME\/MIDP|Profile\/MIDP|JUC|UCWEB|NetFront|Nokia|Jasmine\/1.0|JavaPlatform|WAP\/OBIGO|Obigo\/WAP|Dolfin\/|Spark284|Lemon B556|KKT20|GT\-C3312R)/', $useragent)) {
            return $this->loader->load('java', $useragent);
        }

        if (preg_match('/(GT\-S5380)/', $useragent)) {
            return $this->loader->load('bada', $useragent);
        }

        if (preg_match('/(Velocitymicro\/T408)/', $useragent)) {
            return $this->loader->load('android', $useragent);
        }

        return $this->loader->load('unknown', $useragent);
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Os\OsInterface
     */
    public function fromArray(LoggerInterface $logger, array $data)
    {
        return (new OsFactory())->fromArray($this->cache, $logger, $data);
    }
}
