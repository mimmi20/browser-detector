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

use BrowserDetector\Detector\Os\Aix;
use BrowserDetector\Detector\Os\AmigaOS;
use BrowserDetector\Detector\Os\AndroidOs;
use BrowserDetector\Detector\Os\Bada;
use BrowserDetector\Detector\Os\Beos;
use BrowserDetector\Detector\Os\Brew;
use BrowserDetector\Detector\Os\BsdFour;
use BrowserDetector\Detector\Os\CellOs;
use BrowserDetector\Detector\Os\CentOs;
use BrowserDetector\Detector\Os\Cpm;
use BrowserDetector\Detector\Os\CrOs;
use BrowserDetector\Detector\Os\Cygwin;
use BrowserDetector\Detector\Os\Darwin;
use BrowserDetector\Detector\Os\Debian;
use BrowserDetector\Detector\Os\DragonflyBsd;
use BrowserDetector\Detector\Os\Fedora;
use BrowserDetector\Detector\Os\FirefoxOs;
use BrowserDetector\Detector\Os\FreeBsd;
use BrowserDetector\Detector\Os\Gentoo;
use BrowserDetector\Detector\Os\Hpux;
use BrowserDetector\Detector\Os\Ios;
use BrowserDetector\Detector\Os\Irix;
use BrowserDetector\Detector\Os\Java;
use BrowserDetector\Detector\Os\JoliOs;
use BrowserDetector\Detector\Os\Kubuntu;
use BrowserDetector\Detector\Os\Liberate;
use BrowserDetector\Detector\Os\Linux;
use BrowserDetector\Detector\Os\LinuxTv;
use BrowserDetector\Detector\Os\MacintoshOs;
use BrowserDetector\Detector\Os\Macosx;
use BrowserDetector\Detector\Os\Maemo;
use BrowserDetector\Detector\Os\Mandriva;
use BrowserDetector\Detector\Os\MeeGo;
use BrowserDetector\Detector\Os\Mint;
use BrowserDetector\Detector\Os\Moblin;
use BrowserDetector\Detector\Os\NetBsd;
use BrowserDetector\Detector\Os\NintendoWii;
use BrowserDetector\Detector\Os\NokiaOs;
use BrowserDetector\Detector\Os\OpenBsd;
use BrowserDetector\Detector\Os\OpenVms;
use BrowserDetector\Detector\Os\Os2;
use BrowserDetector\Detector\Os\PalmOs;
use BrowserDetector\Detector\Os\Redhat;
use BrowserDetector\Detector\Os\RimOs;
use BrowserDetector\Detector\Os\RimTabletOs;
use BrowserDetector\Detector\Os\RiscOs;
use BrowserDetector\Detector\Os\Ruby;
use BrowserDetector\Detector\Os\Slackware;
use BrowserDetector\Detector\Os\Solaris;
use BrowserDetector\Detector\Os\SunOs;
use BrowserDetector\Detector\Os\Suse;
use BrowserDetector\Detector\Os\Symbianos;
use BrowserDetector\Detector\Os\Tizen;
use BrowserDetector\Detector\Os\Tru64Unix;
use BrowserDetector\Detector\Os\Ubuntu;
use BrowserDetector\Detector\Os\Unix;
use BrowserDetector\Detector\Os\UnknownOs;
use BrowserDetector\Detector\Os\Ventana;
use BrowserDetector\Detector\Os\WebOs;
use BrowserDetector\Detector\Os\Windows;
use BrowserDetector\Detector\Os\WindowsMobileOs;
use BrowserDetector\Detector\Os\WindowsPhoneOs;
use BrowserDetector\Detector\Os\WindowsRt;
use BrowserDetector\Detector\Os\WyderOs;
use BrowserDetector\Detector\Os\ZenwalkGnu;
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
class OsFactory
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $agent
     *
     * @return \BrowserDetector\Detector\MatcherInterface\OsInterface
     */
    public static function detectPlatform($agent)
    {
        $utils = new Utils();
        $utils->setUserAgent($agent);

        $winPhoneCodes = array('Windows Phone OS', 'XBLWP7', 'ZuneWP7', 'Windows Phone', 'WPDesktop');

        if ($utils->checkIfContains($winPhoneCodes)) {
            $doMatchPhone = preg_match('/Windows Phone ([\d\.]+)/', $agent, $matchesPhone);
            if (!$doMatchPhone || $matchesPhone[1] >= 7) {
                return new WindowsPhoneOs();
            }
        }

        $isWindows = false;
        $windowsHelper = new WindowsHelper();
        $windowsHelper->setUserAgent($agent);

        $mobileDeviceHelper = new MobileDevice();
        $mobileDeviceHelper->setUserAgent($agent);

        if ($windowsHelper->isMobileWindows()) {
            $doMatchMobile = preg_match('/mobile version([\d]+)/', $agent, $matchesMobile);

            if ($doMatchMobile && $matchesMobile[1] >= 70) {
                return new WindowsPhoneOs();
            }

            return new WindowsMobileOs();
        }

        if (!$windowsHelper->isMobileWindows()
            && $windowsHelper->isWindows()
            && !$mobileDeviceHelper->isMobile()
        ) {
            $isWindows = true;
        }

        if ($isWindows && $utils->checkIfContains(array('ARM;'))) {
            return new WindowsRt();
        } elseif ($isWindows) {
            return new Windows();
        }

        if ($utils->checkIfContains(array('SymbianOS', 'SymbOS', 'Symbian', 'Series 60', 'S60V3', 'S60V5'))) {
            return new Symbianos();
        }

        if ($utils->checkIfContains('Bada')) {
            return new Bada();
        }

        if ($utils->checkIfContains('MeeGo')) {
            return new MeeGo();
        }

        if ($utils->checkIfContains(array('maemo', 'linux armv', 'like android', 'linux/x2/r1'), true)) {
            return new Maemo();
        }

        if ($utils->checkIfContains(array('BlackBerry', 'BB10'))) {
            return new RimOs();
        }

        if ($utils->checkIfContains(array('WebOS', 'hpwOS', 'webOS'))) {
            return new WebOs();
        }

        if ($utils->checkIfContains(array('Tizen'))) {
            return new Tizen();
        }

        $helper = new FirefoxOsHelper();
        $helper->setUserAgent($agent);

        if ($helper->isFirefoxOs()) {
            return new FirefoxOs();
        }

        $safariHelper = new SafariHelper();
        $safariHelper->setUserAgent($agent);

        if ($utils->checkIfContains(array('Android', 'Silk', 'JUC(Linux;U;', 'JUC (Linux; U;'))
            || $safariHelper->isMobileAsSafari()
        ) {
            return new AndroidOs();
        }

        $doMatch = preg_match('/Linux; U; (\d+[\d\.]+)/', $agent, $matches);
        if ($doMatch && $matches[1] >= 4) {
            return new AndroidOs();
        }

        if ($utils->checkIfContains('darwin', true)) {
            return new Darwin();
        }

        $ios = array(
            'IphoneOSX',
            'iPhone OS',
            'like Mac OS X',
            'iPad',
            'IPad',
            'iPhone',
            'iPod',
            'CPU OS',
            'CPU iOS',
            'IUC(U;iOS'
        );

        if ($utils->checkIfContains($ios)) {
            return new Ios();
        }

        if ($utils->checkIfContains(array('Macintosh', 'Mac_PowerPC', 'PPC', '68K'))
            && !$utils->checkIfContains('Mac OS X')
        ) {
            return new MacintoshOs();
        }

        if ($utils->checkIfContains(array('Macintosh', 'Mac OS X'))) {
            return new Macosx();
        }

        if ($utils->checkIfContains('debian', true)) {
            return new Debian();
        }

        if ($utils->checkIfContains('kubuntu', true)) {
            return new Kubuntu();
        }

        if ($utils->checkIfContains('ubuntu', true)) {
            return new Ubuntu();
        }

        if ($utils->checkIfContainsAll(array('RIM Tablet'))) {
            return new RimTabletOs();
        }

        if ($utils->checkIfContains('centos', true)) {
            return new CentOs();
        }

        if ($utils->checkIfContains('CrOS')) {
            return new CrOs();
        }

        if ($utils->checkIfContains('Joli OS')) {
            return new JoliOs();
        }

        if ($utils->checkIfContains('mandriva', true)) {
            return new Mandriva();
        }

        if ($utils->checkIfContainsAll(array('mint', 'linux'), true)) {
            return new Mint();
        }

        if ($utils->checkIfContains('suse', true)) {
            return new Suse();
        }

        if ($utils->checkIfContains('fedora', true)) {
            return new Fedora();
        }

        if ($utils->checkIfContains('gentoo', true)) {
            return new Gentoo();
        }

        if ($utils->checkIfContains(array('redhat', 'red hat'), true)) {
            return new Redhat();
        }

        if ($utils->checkIfContains('slackware', true)) {
            return new Slackware();
        }

        if ($utils->checkIfContains('ventana', true)) {
            return new Ventana();
        }

        if ($utils->checkIfContains('Moblin')) {
            return new Moblin();
        }

        if ($utils->checkIfContains('Zenwalk GNU')) {
            return new ZenwalkGnu();
        }

        if ($utils->checkIfContains('AIX')) {
            return new Aix();
        }

        if ($utils->checkIfContains('AmigaOS')) {
            return new AmigaOS();
        }

        if ($utils->checkIfContains('BREW')) {
            return new Brew();
        }

        if ($utils->checkIfContains('playstation', true)) {
            return new CellOs();
        }

        if ($utils->checkIfContains('cygwin', true)) {
            return new Cygwin();
        }

        if ($utils->checkIfContains('freebsd', true)) {
            return new FreeBsd();
        }

        if ($utils->checkIfContains('NetBSD')) {
            return new NetBsd();
        }

        if ($utils->checkIfContains('OpenBSD')) {
            return new OpenBsd();
        }

        if ($utils->checkIfContains('DragonFly')) {
            return new DragonflyBsd();
        }

        if ($utils->checkIfContains('BSD Four')) {
            return new BsdFour();
        }

        if ($utils->checkIfContainsAll(array('HP-UX', 'HPUX'))) {
            return new Hpux();
        }

        if ($utils->checkIfContainsAll(array('BeOS'))) {
            return new Beos();
        }

        if ($utils->checkIfContains(array('IRIX64', 'IRIX'))) {
            return new Irix();
        }

        if ($utils->checkIfContains('solaris', true)) {
            return new Solaris();
        }

        if ($utils->checkIfContains('sunos', true)) {
            return new SunOs();
        }

        if ($utils->checkIfContains('RISC')) {
            return new RiscOs();
        }

        if ($utils->checkIfContains('OpenVMS')) {
            return new OpenVms();
        }

        if ($utils->checkIfContains(array('Tru64 UNIX', 'Digital Unix'))) {
            return new Tru64Unix();
        }

        if ($utils->checkIfContains('unix', true)) {
            return new Unix();
        }

        if ($utils->checkIfContainsAll(array('os/2', 'warp'), true)) {
            return new Os2();
        }

        if ($utils->checkIfContains(array('NETTV', 'HbbTV', 'SMART-TV'))) {
            return new LinuxTv();
        }

        if ($utils->checkIfContains(array('Linux', 'linux', 'X11'))) {
            return new Linux();
        }

        if ($utils->checkIfContains('CP/M')) {
            return new Cpm();
        }

        if ($utils->checkIfContains(array('Nintendo Wii'))) {
            return new NintendoWii();
        }

        if ($utils->checkIfContains(array('Nokia', 'Series40'))) {
            return new NokiaOs();
        }

        if ($utils->checkIfContains('ruby', true)) {
            return new Ruby();
        }

        if ($utils->checkIfContains('Palm OS')) {
            return new PalmOs();
        }

        if ($utils->checkIfContains('WyderOS')) {
            return new WyderOs();
        }

        if ($utils->checkIfContains('Liberate')) {
            return new Liberate();
        }

        $javaCodes = array(
            'Java',
            'J2ME/MIDP',
            'Profile/MIDP',
            'JUC',
            'UCWEB',
            'NetFront',
            'Nokia',
            'Jasmine/1.0',
            'JavaPlatform',
            'WAP/OBIGO',
            'Obigo/WAP'
        );
        if ($utils->checkIfContains($javaCodes)) {
            return new Java();
        }

        return new UnknownOs();
    }
}
