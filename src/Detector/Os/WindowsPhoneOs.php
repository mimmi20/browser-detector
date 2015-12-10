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

namespace BrowserDetector\Detector\Os;

use BrowserDetector\Detector\Company;
use UaResult\Version;
use UaMatcher\Browser\BrowserInterface;
use UaMatcher\Device\DeviceInterface;
use UaMatcher\Engine\EngineInterface;
use UaMatcher\Os\OsChangesBrowserInterface;
use UaMatcher\Os\OsChangesEngineInterface;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class WindowsPhoneOs extends AbstractOs implements OsChangesEngineInterface, OsChangesBrowserInterface
{
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
     * @return \UaResult\Version
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
     * @return \UaMatcher\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company(new Company\Microsoft());
    }

    /**
     * changes properties of the browser depending on properties of the Os
     *
     * @param \UaMatcher\Browser\BrowserInterface $browser
     *
     * @return \BrowserDetector\Detector\Os\WindowsPhoneOs
     */
    public function changeBrowserProperties(BrowserInterface $browser)
    {
        if ($this->utils->checkIfContains(array('XBLWP7', 'ZuneWP7'))) {
            $browser->setCapability('mobile_browser_modus', 'Desktop Mode');
        }

        return $this;
    }

    /**
     * changes properties of the engine depending on browser properties and depending on properties of the Os
     *
     * @param \UaMatcher\Engine\EngineInterface   $engine
     * @param \UaMatcher\Browser\BrowserInterface $browser
     * @param \UaMatcher\Device\DeviceInterface   $device
     *
     * @return \BrowserDetector\Detector\Os\WindowsPhoneOs
     */
    public function changeEngineProperties(EngineInterface $engine, BrowserInterface $browser, DeviceInterface $device)
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
