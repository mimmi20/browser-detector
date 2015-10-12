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

namespace BrowserDetector\Detector\Browser;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Engine\Blink;
use BrowserDetector\Detector\Engine\Presto;
use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\MobileDevice;
use UaMatcher\Browser\BrowserHasSpecificEngineInterface;
use UaMatcher\Browser\BrowserHasWurflKeyInterface;
use UaMatcher\Os\OsInterface;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Opera extends AbstractBrowser implements BrowserHasWurflKeyInterface, BrowserHasSpecificEngineInterface
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
        'rss_support'                  => false,
    );

    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains(array('Opera', 'OPR'))) {
            return false;
        }

        $isNotReallyAnOpera = array(
            // using also the Gecko rendering engine
            'Opera Mini',
            'Opera Mobi',
            'Opera Tablet',
            // Fakes
            'Mac; Mac OS ',
            'AppEngine-Google',
            'InettvBrowserInterface'
        );

        if ($this->utils->checkIfContains($isNotReallyAnOpera)) {
            return false;
        }

        $helper = new MobileDevice();
        $helper->setUserAgent($this->useragent);

        if ($helper->isMobile()) {
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
        return 'Opera';
    }

    /**
     * gets the maker of the browser
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Opera();
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
        $detector->setMode(Version::COMPLETE | Version::IGNORE_MICRO);

        $searches = array('Version', 'Opera', 'OPR');

        return $detector->detectVersion($searches);
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 13249665;
    }

    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return \UaMatcher\Engine\EngineInterface
     */
    public function getEngine()
    {
        $version = $this->detectVersion()->getVersion(Version::MAJORONLY);

        if ($version >= 15) {
            $engine = new Blink();
        } else {
            $engine = new Presto();
        }

        $engine->setUseragent($this->useragent);

        return $engine;
    }

    /**
     * returns the WurflKey
     *
     * @param \UaMatcher\Os\OsInterface $os
     *
     * @return string
     */
    public function getWurflKey(OsInterface $os)
    {
        $browserVersion = $this->detectVersion()->getVersion(Version::MAJORONLY);

        return 'opera_' . (int) $browserVersion;
    }
}
