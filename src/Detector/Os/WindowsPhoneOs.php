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

use BrowserDetector\Detector\Browser\Mobile\MicrosoftInternetExplorer;
use BrowserDetector\Detector\Browser\Mobile\MicrosoftMobileExplorer;
use BrowserDetector\Detector\Browser\Mobile\Opera;
use BrowserDetector\Detector\Browser\Mobile\OperaMobile;
use BrowserDetector\Detector\Browser\UnknownAbstractBrowser;

use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\AbstractDevice;
use BrowserDetector\Detector\AbstractEngine;
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
class WindowsPhoneAbstractOs
    extends AbstractOs
    implements OsInterface
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
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\AbstractOs
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
        $chain->setDefaultHandler(new UnknownAbstractBrowser());

        return $chain->detect();
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\AbstractBrowser $browser
     * @param \BrowserDetector\Detector\AbstractEngine  $engine
     * @param \BrowserDetector\Detector\AbstractDevice  $device
     *
     * @return AbstractDevice
     */
    public function detectDependProperties(
        AbstractBrowser $browser,
        AbstractEngine $engine,
        AbstractDevice $device
    ) {
        parent::detectDependProperties($browser, $engine, $device);

        if ($this->utils->checkIfContains(array('XBLWP7', 'ZuneWP7'))) {
            $browser->setCapability('mobile_browser_modus', 'Desktop Mode');
        }

        $browserVersion = (float)$browser->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        if ($browserVersion < 10.0) {
            $engine->setCapability('is_sencha_touch_ok', false);
        }

        return $this;
    }
}
