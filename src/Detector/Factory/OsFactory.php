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

use BrowserDetector\Detector\Browser\General\Chrome;
use BrowserDetector\Detector\Engine\BlackBerry;
use BrowserDetector\Detector\Engine\Blink;
use BrowserDetector\Detector\Engine\Edge;
use BrowserDetector\Detector\Engine\Gecko;
use BrowserDetector\Detector\Engine\Khtml;
use BrowserDetector\Detector\Engine\NetFront;
use BrowserDetector\Detector\Engine\Presto;
use BrowserDetector\Detector\Engine\T5;
use BrowserDetector\Detector\Engine\Tasman;
use BrowserDetector\Detector\Engine\Teleca;
use BrowserDetector\Detector\Engine\Trident;
use BrowserDetector\Detector\Engine\U2;
use BrowserDetector\Detector\Engine\U3;
use BrowserDetector\Detector\Engine\UnknownEngine;
use BrowserDetector\Detector\Engine\WebKit;
use BrowserDetector\Detector\Os\AndroidOs;
use BrowserDetector\Detector\Os\Bada;
use BrowserDetector\Detector\Os\CentOs;
use BrowserDetector\Detector\Os\CrOs;
use BrowserDetector\Detector\Os\Debian;
use BrowserDetector\Detector\Os\Fedora;
use BrowserDetector\Detector\Os\FirefoxOs;
use BrowserDetector\Detector\Os\Gentoo;
use BrowserDetector\Detector\Os\Ios;
use BrowserDetector\Detector\Os\JoliOs;
use BrowserDetector\Detector\Os\Kubuntu;
use BrowserDetector\Detector\Os\Linux;
use BrowserDetector\Detector\Os\Mandriva;
use BrowserDetector\Detector\Os\MeeGo;
use BrowserDetector\Detector\Os\Mint;
use BrowserDetector\Detector\Os\Moblin;
use BrowserDetector\Detector\Os\Redhat;
use BrowserDetector\Detector\Os\RimOs;
use BrowserDetector\Detector\Os\Slackware;
use BrowserDetector\Detector\Os\Suse;
use BrowserDetector\Detector\Os\Symbianos;
use BrowserDetector\Detector\Os\Ubuntu;
use BrowserDetector\Detector\Os\UnknownOs;
use BrowserDetector\Detector\Os\Ventana;
use BrowserDetector\Detector\Os\WebOs;
use BrowserDetector\Detector\Os\Windows;
use BrowserDetector\Detector\Os\WindowsMobileOs;
use BrowserDetector\Detector\Os\WindowsPhoneOs;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\Utils;
use BrowserDetector\Helper\Windows as WindowsHelper;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\FirefoxOs as FirefoxOsHelper;
use BrowserDetector\Helper\Safari as SafariHelper;

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
    public static function detectEngine($agent)
    {
        $utils = new Utils();
        $utils->setUserAgent($agent);

        $winPhoneCodes = array('Windows Phone OS', 'XBLWP7', 'ZuneWP7', 'Windows Phone', 'WPDesktop', 'mobile version');

        if ($utils->checkIfContains($winPhoneCodes)) {
            $doMatch = preg_match('/Windows Phone ([\d\.]+)/', $agent, $matches);
            if (!$doMatch || $matches[1] >= 7) {
                return new WindowsPhoneOs();
            }

            $doMatch = preg_match('/mobile version([\d]+)/', $agent, $matches);
            if ($doMatch && $matches[1] >= 70) {
                return new WindowsPhoneOs();
            }
        }

        $isWindows = false;
        $windowsHelper = new WindowsHelper();
        $windowsHelper->setUserAgent($agent);

        $mobileDeviceHelper = new MobileDevice();
        $mobileDeviceHelper->setUserAgent($agent);

        if ($windowsHelper->isMobileWindows()) {
            return new WindowsMobileOs();
        }

        if (!$windowsHelper->isMobileWindows()
            && $windowsHelper->isWindows()
            && !$mobileDeviceHelper->isMobile()
            && !$utils->checkIfContains(array('ARM;'))
        ) {
            $isWindows = true;
        }

        if ($isWindows) {
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

        if ($utils->checkIfContains(array('BlackBerry', 'BB10'))) {
            return new RimOs();
        }

        if ($utils->checkIfContains(array('WebOS', 'hpwOS', 'webOS'))) {
            return new WebOs();
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

        $otherOs = array(
            'Darwin',
            'Windows Phone'
        );

        if ($utils->checkIfContains($ios) && !$utils->checkIfContains($otherOs)) {
            return new Ios();
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

        if ($utils->checkIfContains(array('Linux', 'linux', 'X11'))) {
            return new Linux();
        }

        return new UnknownOs();
    }
}
