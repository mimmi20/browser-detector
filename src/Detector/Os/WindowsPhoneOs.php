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

use BrowserDetector\Detector\Browser\AbstractBrowser;
use BrowserDetector\Detector\Browser\MicrosoftInternetExplorer;
use BrowserDetector\Detector\Browser\MicrosoftMobileExplorer;
use BrowserDetector\Detector\Browser\Opera;
use BrowserDetector\Detector\Browser\OperaMobile;
use BrowserDetector\Detector\Browser\UnknownBrowser;

use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\AbstractDevice;
use BrowserDetector\Detector\Engine\AbstractEngine;
use BrowserDetector\Detector\MatcherInterface\Os\OsChangesBrowserInterface;
use BrowserDetector\Detector\MatcherInterface\Os\OsChangesEngineInterface;
use BrowserDetector\Detector\MatcherInterface\OsInterface;

use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Windows as WindowsHelper;

/**
 * MSIEAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class WindowsPhoneOs
    extends AbstractOs
    implements OsInterface, OsChangesEngineInterface, OsChangesBrowserInterface
{
    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        $mobileDeviceHelper = new MobileDevice();
        $mobileDeviceHelper->setUserAgent($this->useragent);

        $windowsHelper = new WindowsHelper();
        $windowsHelper->setUserAgent($this->useragent);

        if (!$windowsHelper->isMobileWindows()
            && !($windowsHelper->isWindows() && $mobileDeviceHelper->isMobile())
        ) {
            return false;
        }

        $winPhoneCodes = array('Windows Phone OS', 'XBLWP7', 'ZuneWP7', 'Windows Phone', 'WPDesktop');

        if (!$this->utils->checkIfContains($winPhoneCodes)) {
            return false;
        }

        $doMatch = preg_match('/Windows Phone ([\d\.]+)/', $this->useragent, $matches);
        if ($doMatch && $matches[1] < 7) {
            return false;
        }

        return true;
    }

    /**
     * returns the name of the operating system/platform
     *
     * @return string
     */
    public function getName()
    {
        return 'Windows Phone OS';
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

        if ($this->utils->checkIfContains(array('XBLWP7', 'ZuneWP7'))) {
            return $detector->setVersion('7.5');
        }

        if ($this->utils->checkIfContains(array('WPDesktop'))) {
            if ($this->utils->checkIfContains(array('Windows NT 6.2'))) {
                return $detector->setVersion('8.1');
            }

            return $detector->setVersion('8.0');
        }

        $searches = array('Windows Phone OS', 'Windows Phone');

        return $detector->detectVersion($searches);
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Microsoft();
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 805140;
    }

    /**
     * returns the Browser which used on the device
     *
     * @return \BrowserDetector\Detector\Browser\AbstractBrowser
     */
    public function detectBrowser()
    {
        $browsers = array(
            new MicrosoftInternetExplorer(),
            new MicrosoftMobileExplorer(),
            new OperaMobile(),
            new Opera()
        );

        $chain = new Chain();
        $chain->setUserAgent($this->useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }

    /**
     * changes properties of the browser depending on properties of the Os
     *
     * @param \BrowserDetector\Detector\Browser\AbstractBrowser $browser
     *
     * @return \BrowserDetector\Detector\Os\WindowsPhoneOs
     */
    public function changeBrowserProperties(AbstractBrowser $browser)
    {
        if ($this->utils->checkIfContains(array('XBLWP7', 'ZuneWP7'))) {
            $browser->setCapability('mobile_browser_modus', 'Desktop Mode');
        }

        return $this;
    }

    /**
     * changes properties of the engine depending on browser properties and depending on properties of the Os
     *
     * @param \BrowserDetector\Detector\Engine\AbstractEngine   $engine
     * @param \BrowserDetector\Detector\Browser\AbstractBrowser $browser
     * @param \BrowserDetector\Detector\Device\AbstractDevice   $device
     *
     * @return \BrowserDetector\Detector\Os\WindowsPhoneOs
     */
    public function changeEngineProperties(AbstractEngine $engine, AbstractBrowser $browser, AbstractDevice $device)
    {
        $browserVersion = (float)$browser->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        if ($browserVersion < 10.0) {
            $engine->setCapability('is_sencha_touch_ok', false);
        }

        return $this;
    }
}
