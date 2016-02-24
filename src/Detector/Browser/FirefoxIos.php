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
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Browser;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Engine\Webkit;
use BrowserDetector\Helper\SpamCrawlerFake;
use UaBrowserType\Browser;
use UaMatcher\Browser\BrowserHasSpecificEngineInterface;
use UaMatcher\Browser\BrowserHasWurflKeyInterface;
use UaMatcher\Os\OsInterface;
use UaResult\Version;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class FirefoxIos extends AbstractBrowser implements BrowserHasWurflKeyInterface, BrowserHasSpecificEngineInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = [
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
    ];

    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        $spamHelper = new SpamCrawlerFake($this->useragent);

        if (!$this->utils->checkIfContains('Mozilla/') && !$spamHelper->isAnonymized()
        ) {
            return false;
        }

        $firefoxCodes = [
            'Firefox',
            'Minefield',
            'Nightly',
            'Shiretoko',
            'BonEcho',
            'Namoroka',
            'Fennec',
        ];

        if (!$this->utils->checkIfContains($firefoxCodes)) {
            return false;
        }

        $isNotReallyAnFirefox = [
            // using also the Gecko rendering engine
            'Maemo',
            'Maxthon',
            'MxBrowser',
            'Camino',
            'CometBird',
            'Epiphany',
            'Galeon',
            'Lunascape',
            'Opera',
            'PaleMoon',
            'SeaMonkey',
            'Flock',
            'IceCat',
            'Iceweasel',
            'Iceowl',
            'Icedove',
            'Iceape',
            'Firebird',
            'IceDragon',
            'TenFourFox',
            'WaterFox',
            'Waterfox',
            'K-Meleon',
            //Bots
            'Nutch',
            'CazoodleBot',
            'LOOQ',
            'GoogleImageProxy',
            'GomezAgent',
            '360Spider',
            'Spinn3r',
            'Yahoo!',
            'Slurp',
            'adbeat.com',
            'myibrow',
            //others
            'MSIE',
            'Trident',
            // Fakes
            'Mac; Mac OS ',
        ];

        if ($this->utils->checkIfContains($isNotReallyAnFirefox)) {
            return false;
        }

        if ($this->utils->checkIfContains('developers.google.com/+/web/snippet/', true)) {
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
        return 'Firefox for iOS';
    }

    /**
     * gets the maker of the browser
     *
     * @return \UaMatcher\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company(new Company\MozillaFoundation());
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

        $searches = ['FxiOS'];

        return $detector->detectVersion($searches);
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return int
     */
    public function getWeight()
    {
        return 10000;
    }

    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return \BrowserDetector\Detector\Engine\Gecko
     */
    public function getEngine()
    {
        return new Webkit($this->useragent, $this->logger);
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
        $browserVersion = (float) $this->detectVersion()->getVersion(Version::MAJORMINOR);

        if (3.5 === $browserVersion) {
            $wurflKey = 'firefox_3_5';
        } else {
            $wurflKey = 'firefox_' . (int) $browserVersion . '_0';
        }

        return $wurflKey;
    }
}
