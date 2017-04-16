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
use Stringy\Stringy;

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
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
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
            return (new Platform\WindowsFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/Linux; U; (\d+[\d\.]+)/', $useragent, $matches) && $matches[1] >= 4) {
            return $this->loader->load('android', $useragent);
        }

        if ($s->containsAny(['symbianos', 'symbos', 'symbian', 'series 60', 's60v3', 's60v5'], false)) {
            return $this->loader->load('symbian', $useragent);
        }

        if ($s->contains('series40', false)) {
            return $this->loader->load('nokia os', $useragent);
        }

        if ($s->contains('Bada')) {
            return $this->loader->load('bada', $useragent);
        }

        if ($s->contains('MeeGo')) {
            return $this->loader->load('meego', $useragent);
        }

        if ($s->contains('sailfish', false)) {
            return $this->loader->load('sailfishos', $useragent);
        }

        if ($s->contains('android; linux arm', false)) {
            return $this->loader->load('android', $useragent);
        }

        if ((new Helper\Linux($useragent))->isLinux()) {
            return (new Platform\LinuxFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['maemo', 'like android', 'linux/x2/r1', 'linux arm'], false)) {
            return $this->loader->load('linux smartphone os (maemo)', $useragent);
        }

        if ($s->containsAny(['blackberry', 'bb10'], false)) {
            return $this->loader->load('rim os', $useragent);
        }

        if ($s->containsAny(['webos', 'hpwos'], false)) {
            return $this->loader->load('webos', $useragent);
        }

        if ($s->contains('Tizen')) {
            return $this->loader->load('tizen', $useragent);
        }

        if ((new Helper\FirefoxOs($useragent))->isFirefoxOs()) {
            return $this->loader->load('firefoxos', $useragent);
        }

        if ($s->contains('kfreebsd', false)) {
            // Debian with the FreeBSD kernel
            return $this->loader->load('debian with freebsd kernel', $useragent);
        }

        if ($s->contains('freebsd', false)) {
            return $this->loader->load('freebsd', $useragent);
        }

        if ($s->containsAny(['darwin', 'cfnetwork'], false)) {
            return (new Platform\DarwinFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('playstation', false)) {
            return $this->loader->load('cellos', $useragent);
        }

        if ($s->containsAny(['micromaxx650', 'dolfin/', 'yuanda50', 'wap browser', 'wap-browser'], false)) {
            return $this->loader->load('java', $useragent);
        }

        if ($s->contains('commoncrawler', false)) {
            return $this->loader->load('unknown', $useragent);
        }

        if ($s->contains('MIUI', true)) {
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

        if ($s->containsAny(['macintosh', 'mac os x', 'os=mac 10'], false)) {
            return $this->loader->load('mac os x', $useragent);
        }

        if ($s->containsAny(['mac_powerpc', 'ppc', '68k'], false)) {
            return $this->loader->load('macintosh', $useragent);
        }

        if ($s->contains('rim tablet', false)) {
            return $this->loader->load('rim tablet os', $useragent);
        }

        if ($s->contains('aix', false)) {
            return $this->loader->load('aix', $useragent);
        }

        if ($s->contains('amigaos', false)) {
            return $this->loader->load('amiga os', $useragent);
        }

        if ($s->contains('brew', false)) {
            return $this->loader->load('brew', $useragent);
        }

        if ($s->contains('cygwin', false)) {
            return $this->loader->load('cygwin', $useragent);
        }

        if ($s->contains('netbsd', false)) {
            return $this->loader->load('netbsd', $useragent);
        }

        if ($s->contains('openbsd', false)) {
            return $this->loader->load('openbsd', $useragent);
        }

        if ($s->contains('dragonfly', false)) {
            return $this->loader->load('dragonfly bsd', $useragent);
        }

        if ($s->contains('bsd four', false)) {
            return $this->loader->load('bsd', $useragent);
        }

        if ($s->containsAny(['hp-ux', 'hpux'], false)) {
            return $this->loader->load('hp-ux', $useragent);
        }

        if ($s->contains('beos', false)) {
            return $this->loader->load('beos', $useragent);
        }

        if ($s->contains('irix', false)) {
            return $this->loader->load('irix', $useragent);
        }

        if ($s->contains('solaris', false)) {
            return $this->loader->load('solaris', $useragent);
        }

        if ($s->contains('sunos', false)) {
            return $this->loader->load('sunos', $useragent);
        }

        if ($s->contains('risc', false)) {
            return $this->loader->load('risc os', $useragent);
        }

        if ($s->contains('openvms', false)) {
            return $this->loader->load('openvms', $useragent);
        }

        if ($s->containsAny(['tru64 unix', 'digital unix', 'osf1'], false)) {
            return $this->loader->load('tru64 unix', $useragent);
        }

        if ($s->contains('unix', false)) {
            return $this->loader->load('unix', $useragent);
        }

        if ($s->containsAny(['os/2', 'warp'], false)) {
            return $this->loader->load('os/2', $useragent);
        }

        if ($s->contains('cp/m', false)) {
            return $this->loader->load('cp/m', $useragent);
        }

        if ($s->containsAny(['nintendo wii', 'nintendo 3ds'], false)) {
            return $this->loader->load('nintendo os', $useragent);
        }

        if ($s->contains('nokia', false)) {
            return $this->loader->load('nokia os', $useragent);
        }

        if ($s->contains('ruby', false)) {
            return $this->loader->load('ruby', $useragent);
        }

        if ($s->containsAny(['palm os', 'palmsource'], false)) {
            return $this->loader->load('palmos', $useragent);
        }

        if ($s->contains('wyderos', false)) {
            return $this->loader->load('wyderos', $useragent);
        }

        if ($s->contains('liberate', false)) {
            return $this->loader->load('liberate', $useragent);
        }

        if ($s->contains('inferno', false)) {
            return $this->loader->load('inferno os', $useragent);
        }

        if ($s->contains('syllable', false)) {
            return $this->loader->load('syllable', $useragent);
        }

        if ($s->containsAny(['camino', 'pubsub', 'integrity'], false)) {
            return $this->loader->load('mac os x', $useragent);
        }

        if ($s->containsAny(['gt-s5380', 's8500'], false)) {
            return $this->loader->load('bada', $useragent);
        }

        if ($s->containsAny(['java', 'j2me/midp', 'profile/midp', 'juc', 'ucweb', 'netfront', 'jasmine/1.0', 'javaplatform', 'wap/obigo', 'obigo/WAP', 'dolfin/', 'spark284', 'lemon b556', 'kkt20', 'gt-c3312r'], false)) {
            return $this->loader->load('java', $useragent);
        }

        if ($s->contains('velocitymicro/t408', false)) {
            return $this->loader->load('android', $useragent);
        }

        return $this->loader->load('unknown', $useragent);
    }
}
