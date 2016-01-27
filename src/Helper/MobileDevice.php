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
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Helper;

use UaHelper\Utils;

/**
 * helper to get information if the device is a mobile
 *
 * @package   BrowserDetector
 */
class MobileDevice
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = '';

    /**
     * @var \UaHelper\Utils the helper class
     */
    private $utils = null;

    /**
     * Class Constructor
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Helper\MobileDevice
     */
    public function __construct($useragent)
    {
        $this->utils = new Utils();

        $this->useragent = $useragent;
        $this->utils->setUserAgent($useragent);
    }

    /**
     * Returns true if the give $useragent is from a mobile device
     *
     * @return bool
     */
    public function isMobile()
    {
        $fakeHelper = new SpamCrawlerFake($this->useragent);

        if ($fakeHelper->isFakeBrowser()) {
            return false;
        }

        /**
         * @var array Collection of mobile browser keywords
         */
        $mobileBrowsers = array(
            'android',
            'arm; touch',
            'aspen simulator',
            'bada',
            'bb10',
            'blackberry',
            'blazer',
            'bolt',
            'brew',
            'cldc',
            'dalvik',
            'danger hiptop',
            'embider',
            'fennec',
            'firefox or ie',
            'foma',
            'folio100',
            'gingerbread',
            'hd_mini_t',
            'hp-tablet',
            'hpwOS',
            'htc',
            'ipad',
            'iphone',
            'iphoneosx',
            'iphone os',
            'ipod',
            'iris',
            'iuc(u;ios',
            'j2me',
            'juc(linux;u;',
            'juc (linux; u;',
            'kindle',
            'lenovo',
            'like mac os x',
            'linux armv',
            'look-alike',
            'maemo',
            'meego',
            'midp',
            'mobile version',
            'mobile safari',
            'mqqbrowser',
            'netfront',
            'nintendo',
            'nokia',
            'obigo',
            'openwave',
            'opera mini',
            'opera mobi',
            'palm',
            'phone',
            'playstation',
            'pocket pc',
            'pocketpc',
            'rim tablet',
            'samsung',
            'series40',
            'series 60',
            'silk',
            'symbian',
            'symbianos',
            'symbos',
            'toshiba_ac_and_az',
            'touchpad',
            'transformer tf',
            'up.browser',
            'up.link',
            'xblwp7',
            'wap2',
            'webos',
            'wetab-browser',
            'windows ce',
            'windows mobile',
            'windows phone os',
            'wireless',
            'xda_diamond_2',
            'zunewp7',
            'wpdesktop',
            'jolla',
            'sailfish',
            'padfone',
            'st80208',
            'mtk',
            'onebrowser',
            'qtcarbrowser',
            'wap browser/maui',
            'wetab',
            '[fban',
            'dataaccessd',
            'crowsnest',
            'wap-browser',
            'dino762',
            'iball',
            'terra_101',
        );

        if ($this->utils->checkIfContains($mobileBrowsers, true)) {
            $noMobiles = array(
                'xbox', 'badab', 'badap', 'simbar', 'google-tr', 'googlet',
                'google wireless transcoder', 'eeepc', 'i9988_custom',
                'i9999_custom', 'wuid=', 'smart-tv', 'sonydtv', 'hbbtv',
                'dolphin http client',
            );

            if ($this->utils->checkIfContains($noMobiles, true)) {
                return false;
            }

            return true;
        }

        if ($this->utils->checkIfContains('tablet', true)
            && !$this->utils->checkIfContains('tablet pc', true)
        ) {
            return true;
        }

        if ($this->utils->checkIfContains('mobile', true)
            && !$this->utils->checkIfContains('automobile', true)
        ) {
            return true;
        }

        if ($this->utils->checkIfContains('sonydtv', true)) {
            return false;
        }

        if ($this->utils->checkIfContains(array('ARM;'))
            && $this->utils->checkIfContains(array('Windows NT 6.2', 'Windows NT 6.3'))
        ) {
            return true;
        }

        $doMatch = preg_match('/\d+\*\d+/', $this->useragent);
        if ($doMatch) {
            return true;
        }

        $helper = new FirefoxOs();
        $helper->setUserAgent($this->useragent);

        if ($helper->isFirefoxOs()) {
            return true;
        }

        $windowsHelper = new Windows($this->useragent);

        if ($windowsHelper->isWindows() && $this->utils->checkIfContains('touch', true)) {
            return true;
        }

        if (preg_match('/Puffin\/[\d\.]+(I|A)(T|P)/', $this->useragent)) {
            return true;
        }

        if (preg_match('/TBD\d{4}/', $this->useragent)) {
            return true;
        }

        if (preg_match('/TBD(B|C)\d{3,4}/', $this->useragent)) {
            return true;
        }

        return false;
    }
}
