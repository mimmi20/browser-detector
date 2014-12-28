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

namespace BrowserDetector\Detector\Browser\General;

use BrowserDetector\Detector\BrowserHandler;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\Engine\Webkit;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\Safari as SafariHelper;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Safari
    extends BrowserHandler
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        // browser
        'mobile_browser_modus'         => null, // not in wurfl

        // product info
        'can_skip_aligned_link_row'    => true,
        'device_claims_web_support'    => true,

        // pdf
        'pdf_support'                  => true,

        // bugs
        'empty_option_value_support'   => true,
        'basic_authentication_support' => true,
        'post_method_support'          => true,

        // rss
        'rss_support'                  => true,
    );

    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        $safariHelper = new SafariHelper();
        $safariHelper->setUserAgent($this->useragent);

        if (!$safariHelper->isSafari()) {
            return false;
        }

        if (!$this->utils->checkIfContains(array('Safari', 'Mobile'))) {
            return false;
        }

        return true;
    }

    /**
     * gets the name of the browser
     *
     * @return string
     */
    public function getName()
    {
        return 'Safari';
    }

    /**
     * gets the maker of the browser
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Apple();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Type\Device\TypeInterface
     */
    public function getBrowserType()
    {
        return new BrowserType\Browser();
    }

    /**
     * detects the browser version from the given user agent
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->useragent);

        $safariHelper = new SafariHelper();
        $safariHelper->setUserAgent($this->useragent);

        $doMatch = preg_match('/Version\/([\d\.]+)/', $this->useragent, $matches);

        if ($doMatch) {
            return $detector->setVersion($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match(
            '/Safari\/([\d\.]+)/', $this->useragent, $matches
        );

        if ($doMatch) {
            return $detector->setVersion($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match('/Safari([\d\.]+)/', $this->useragent, $matches);

        if ($doMatch) {
            return $detector->setVersion($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match(
            '/MobileSafari\/([\d\.]+)/', $this->useragent, $matches
        );

        if ($doMatch) {
            return $detector->setVersion($safariHelper->mapSafariVersions($matches[1]));
        }

        return $detector->setVersion('');
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 93432480;
    }

    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return \BrowserDetector\Detector\Engine\Webkit
     */
    public function detectEngine()
    {
        $handler = new Webkit();
        $handler->setUseragent($this->useragent);

        return $handler;
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\EngineHandler $engine
     * @param \BrowserDetector\Detector\OsHandler     $os
     * @param \BrowserDetector\Detector\DeviceHandler $device
     *
     * @return \BrowserDetector\Detector\Browser\General\Safari
     */
    public function detectDependProperties(
        EngineHandler $engine, OsHandler $os, DeviceHandler $device
    ) {
        if ($device->getDeviceType()->isMobile()) {
            $engine->setCapability('xhtml_format_as_css_property', true);

            if (!$device->getDeviceType()->isTablet()) {
                $engine->setCapability('xhtml_send_sms_string', 'sms:');
                $engine->setCapability('css_gradient', 'webkit');
            }
        } else {
            $this->setCapability('rss_support', false);
        }

        parent::detectDependProperties($engine, $os, $device);

        $osVersion = (float)$os->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        if (!$device->getDeviceType()->isTablet()
            && $osVersion >= 6.0
        ) {
            $engine->setCapability('xhtml_file_upload', 'supported'); //iPhone with iOS 6.0 and Safari 6.0
        }

        $browserVersion = $this->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        if ((float)$browserVersion < 4.0) {
            $engine->setCapability('jqm_grade', 'B');
        }

        $osname    = $os->getName();
        $osVersion = (float)$os->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        if ('iOS' === $osname && 5.1 <= $osVersion) {
            $engine->setCapability('jqm_grade', 'A');
            $engine->setCapability('supports_java_applets', true);
        }

        if ('Mac OS X' === $osname && 10.0 <= $osVersion) {
            $engine->setCapability('jqm_grade', 'A');
        }

        return $this;
    }
}
