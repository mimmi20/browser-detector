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

namespace BrowserDetector\Detector\Os;

use BrowserDetector\Detector\Browser\Desktop\YouWaveAndroidOnPc;
use BrowserDetector\Detector\Browser\General\AndroidWebView;
use BrowserDetector\Detector\Browser\General\Googlebot;
use BrowserDetector\Detector\Browser\General\GooglebotMobileBot;
use BrowserDetector\Detector\Browser\General\GooglePageSpeed;
use BrowserDetector\Detector\Browser\General\GooglePageSpeedInsights;
use BrowserDetector\Detector\Browser\Mobile\Android;
use BrowserDetector\Detector\Browser\Mobile\AndroidDownloadManager;
use BrowserDetector\Detector\Browser\Mobile\Chrome;
use BrowserDetector\Detector\Browser\Mobile\Dalvik;
use BrowserDetector\Detector\Browser\Mobile\Dolfin;
use BrowserDetector\Detector\Browser\Mobile\Firefox;
use BrowserDetector\Detector\Browser\Mobile\FlyFlow;
use BrowserDetector\Detector\Browser\Mobile\Maxthon;
use BrowserDetector\Detector\Browser\Mobile\MqqBrowser;
use BrowserDetector\Detector\Browser\Mobile\NetFrontLifeBrowser;
use BrowserDetector\Detector\Browser\Mobile\Opera;
use BrowserDetector\Detector\Browser\Mobile\OperaMini;
use BrowserDetector\Detector\Browser\Mobile\OperaMobile;
use BrowserDetector\Detector\Browser\Mobile\Silk;
use BrowserDetector\Detector\Browser\Mobile\Ucweb;
use BrowserDetector\Detector\Browser\Mobile\YaBrowser;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\BrowserHandler;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface\OsInterface;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\FirefoxOs as FirefoxOsHelper;
use BrowserDetector\Helper\Safari as SafariHelper;

/**
 * MSIEAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AndroidOs
    extends OsHandler
    implements OsInterface
{
    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        $noAndroid = array(
            'SymbianOS',
            'SymbOS',
            'Symbian',
            'Series 60',
            'S60V3',
            'Bada',
            'MeeGo',
            'BlackBerry; U; ',
            'webOS',
            'hpwOS',
            'like Android',
            'BB10',
            'Windows Phone'
        );

        if ($this->utils->checkIfContains($noAndroid)) {
            return false;
        }

        $firefoxOshelper = new FirefoxOsHelper();
        $firefoxOshelper->setUserAgent($this->useragent);

        if ($firefoxOshelper->isFirefoxOs()) {
            return false;
        }

        $safariHelper = new SafariHelper();
        $safariHelper->setUserAgent($this->useragent);

        if ($this->utils->checkIfContains(
                array('Android', 'Silk', 'JUC(Linux;U;', 'JUC (Linux; U;')
            ) || $safariHelper->isMobileAsSafari()
        ) {
            return true;
        }

        $doMatch = preg_match('/Linux; U; (\d+[\d\.]+)/', $this->useragent, $matches);
        if ($doMatch && $matches[1] >= 4) {
            return true;
        }

        return false;
    }

    /**
     * returns the name of the operating system/platform
     *
     * @return string
     */
    public function getName()
    {
        return 'Android';
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->useragent);

        if ($this->utils->checkIfContains('android 2.1-update1', true)) {
            return $detector->setVersion('2.1.1');
        }

        $searches = array(
            'Android android',
            'Android AndroidHouse Team',
            'Android WildPuzzleROM v8 froyo',
            'Android',
            'JUC\(Linux;U;',
            'Android OS'
        );

        $detector->detectVersion($searches);

        if (!$detector->getVersion()) {
            if ($this->utils->checkIfContains('android eclair', true)) {
                $detector->setVersion('2.1');
            }

            if ($this->utils->checkIfContains('gingerbread', true)) {
                $detector->setVersion('2.3');
            }
        }

        return $detector;
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Google();
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 44624696;
    }

    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\BrowserHandler
     */
    public function detectBrowser()
    {
        $browsers = array(
            new Android(),
            new Chrome(),
            new Dalvik(),
            new Silk(),
            new Dolfin(),
            new NetFrontLifeBrowser(),
            new Googlebot(),
            new Opera(),
            new OperaMini(),
            new OperaMobile(),
            new Firefox(),
            new YouWaveAndroidOnPc(),
            new AndroidDownloadManager(),
            new Ucweb(),
            new YaBrowser(),
            new MqqBrowser(),
            new FlyFlow(),
            new Maxthon(),
            new GooglebotMobileBot(),
            new GooglePageSpeed(),
            new GooglePageSpeedInsights(),
            new AndroidWebView(),
        );

        $chain = new Chain();
        $chain->setUserAgent($this->useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }
}
