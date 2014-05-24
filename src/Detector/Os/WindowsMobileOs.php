<?php
namespace BrowserDetector\Detector\Os;

/**
 * PHP version 5.3
 *
 * LICENSE:
 *
 * Copyright (c) 2013, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * * Neither the name of the authors nor the names of its contributors may be
 *   used to endorse or promote products derived from this software without
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

use BrowserDetector\Detector\Browser\Mobile\MicrosoftInternetExplorer;
use BrowserDetector\Detector\Browser\Mobile\MicrosoftMobileExplorer;
use BrowserDetector\Detector\Browser\Mobile\Opera;
use BrowserDetector\Detector\Browser\Mobile\OperaMini;
use BrowserDetector\Detector\Browser\Mobile\OperaMobile;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\OsInterface;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Windows as WindowsHelper;

/**
 * MSIEAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class WindowsMobileOs
    extends OsHandler
    implements MatcherInterface, OsInterface
{
    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        if ($this->utils->checkIfContains(array('Windows Phone OS', 'ZuneWP7', 'XBLWP7'))) {
            return false;
        }

        $mobileDeviceHelper = new MobileDevice();
        $mobileDeviceHelper->setUserAgent($this->_useragent);

        $windowsHelper = new WindowsHelper();
        $windowsHelper->setUserAgent($this->_useragent);

        if (!$windowsHelper->isMobileWindows()
            && !($windowsHelper->isWindows() && $mobileDeviceHelper->isMobileBrowser())
        ) {
            return false;
        }

        $doMatch = preg_match('/Windows Phone ([\d\.]+)/', $this->_useragent, $matches);
        if ($doMatch && $matches[1] >= 7) {
            return false;
        }

        $doMatch = preg_match('/mobile version([\d]+)/', $this->_useragent, $matches);
        if ($doMatch && $matches[1] >= 70) {
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
        return 'Windows Mobile OS';
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function getVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->_useragent);

        if ($this->utils->checkIfContains('Windows NT 5.1')) {
            return $detector->setVersion('6.0');
        }

        if ($this->utils->checkIfContains(array('Windows CE', 'Windows Mobile', 'MSIEMobile'))) {
            $detector->setDefaulVersion('6.0');

            $searches = array('MSIEMobile');

            return $detector->detectVersion($searches);
        }

        $searches = array('Windows Phone');

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
        return 42347;
    }

    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\OsHandler
     */
    public function detectBrowser()
    {
        $browsers = array(
            new MicrosoftInternetExplorer(),
            new MicrosoftMobileExplorer(),
            new OperaMobile(),
            new OperaMini(),
            new Opera()
        );

        $chain = new Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }
}