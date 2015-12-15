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
use BrowserDetector\Detector\Engine\Webkit;
use UaBrowserType\Browser;
use UaResult\Version;
use UaMatcher\Browser\BrowserHasWurflKeyInterface;
use UaMatcher\Os\OsInterface;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Chrome extends AbstractBrowser implements BrowserHasWurflKeyInterface
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
        if (!$this->utils->checkIfContains(array('Mozilla/', 'Chrome/', 'CrMo/', 'CriOS/'))) {
            return false;
        }

        if (!$this->utils->checkIfContains(array('Chrome', 'CrMo', 'CriOS'))) {
            return false;
        }

        if ($this->utils->checkIfContains(array('Version/'))) {
            return false;
        }

        $isNotReallyAnChrome = array(
            // using also the KHTML rendering engine
            'Arora',
            'Chromium',
            'Comodo Dragon',
            'Dragon',
            'Flock',
            'Galeon',
            'Google Earth',
            'Iron',
            'Lunascape',
            'Maemo',
            'Maxthon',
            'MxBrowser',
            'Midori',
            'OPR',
            'PaleMoon',
            'RockMelt',
            'Silk',
            'YaBrowser',
            'Firefox',
            'Iceweasel',
            'Edge',
            'CoolNovo',
            'Amigo',
            'Viera',
            'Vivaldi',
            'SamsungBrowser',
            'Puffin',
            'WhiteHat Aviator',
            ' SE ',
            'Nichrome',
            'MxNitro',
            'LBBROWSER',
            'Seznam',
            'Diga',
            'Kenshoo',
            'coc_coc_browser',
            'Superbird',
            'ACHEETAHI',
            'Beamrise',
            'APUSBrowser',
            'Diglo',
            'Chedot',
            // Bots trying to be a Chrome
            'PagePeeker',
            'Google Web Preview',
            'Google Wireless Transcoder',
            'Google Page Speed',
            'Google Markup Tester',
            'HubSpot Webcrawler',
            'GomezAgent',
            'TagInspector',
            '360Spider',
            'QIHU 360EE',
            'QIHU 360SE',
            // Fakes
            'Mac; Mac OS '
        );

        if ($this->utils->checkIfContains($isNotReallyAnChrome)) {
            return false;
        }

        $detector = new Version();
        $detector->setUserAgent($this->useragent);
        $detector->detectVersion(array('Chrome'));

        if (1 <= $detector->getVersion(Version::MAJORONLY) && 0 != $detector->getVersion(Version::MINORONLY)) {
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
        return 'Chrome';
    }

    /**
     * gets the maker of the browser
     *
     * @return \UaMatcher\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company(new Company\Google());
    }

    /**
     * returns the type of the current device
     *
     * @return \UaBrowserType\TypeInterface
     */
    public function getBrowserType()
    {
        return new Browser();
    }

    /**
     * detects the browser version from the given user agent
     *
     * @return \UaResult\Version
     */
    public function detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->useragent);
        $detector->setMode(Version::COMPLETE | Version::IGNORE_MICRO);

        $searches = array('Chrome', 'CrMo', 'CriOS');

        return $detector->detectVersion($searches);
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 30000;
    }

    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @param \UaMatcher\Os\OsInterface $os
     *
     * @return \UaMatcher\Engine\EngineInterface
     */
    public function detectEngine(OsInterface $os = null)
    {
        $version = $this->detectVersion()->getVersion(Version::MAJORONLY);

        if (null !== $os && in_array($os->getName(), array('iOS'))) {
            $engine = new Webkit($this->useragent, $this->logger);
        } elseif ($version >= 28) {
            $engine = new Blink($this->useragent, $this->logger);
        } else {
            $engine = new Webkit($this->useragent, $this->logger);
        }

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
        $version = $this->detectVersion()->getVersion(Version::MAJORONLY);

        return 'google_chrome_' . (int) $version;
    }
}
