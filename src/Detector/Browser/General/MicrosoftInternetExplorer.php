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
use BrowserDetector\Detector\Engine\Trident;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MicrosoftInternetExplorer
    extends BrowserHandler
{
    private $patterns = array(
        '/Mozilla\/5\.0.*\(.*Trident\/7\.0.*rv\:11\.0.*\) like Gecko.*/' => '11.0',
        '/Mozilla\/5\.0.*\(.*MSIE 10\.0.*/'                              => '10.0',
        '/Mozilla\/5\.0.*\(.*MSIE 9\.0.*/'                               => '9.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 8\.0.*/'                            => '8.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 7\.0.*/'                            => '7.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 6\.0.*/'                            => '6.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.5.*/'                            => '5.5',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.23.*/'                           => '5.23',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.22.*/'                           => '5.22',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.17.*/'                           => '5.17',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.16.*/'                           => '5.16',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.01.*/'                           => '5.01',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.0.*/'                            => '5.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 4\.01.*/'                           => '4.01',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 4\.0.*/'                            => '4.0',
        '/Mozilla\/.*\(.*MSIE 3\..*/'                                    => '3.0',
        '/Mozilla\/.*\(.*MSIE 2\..*/'                                    => '2.0',
        '/Mozilla\/.*\(.*MSIE 1\..*/'                                    => '1.0'
    );

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
        if (!$this->utils->checkIfContains(array('Mozilla/', 'MSIE', 'Trident'))) {
            return false;
        }

        if ($this->utils->checkIfStartsWith('IE')) {
            return false;
        }

        $isNotReallyAnIE = array(
            'presto',
            'webkit',
            'khtml',
            // using also the Trident rendering engine
            'crazy browser',
            'flock',
            'galeon',
            'lunascape',
            'maxthon',
            'myie',
            'opera',
            'palemoon',
            'avant',
            // other Browsers
            'applewebkit',
            'chrome',
            'linux',
            'msoffice',
            'outlook',
            'iemobile',
            'blackberry',
            'webtv',
            'argclrint',
            'firefox',
            'msiecrawler',
            // mobile IE
            'xblwp7',
            'zunewp7',
            'wpdesktop',
            'htc_hd2',
            'gomezagent',
            // Fakes / Bots
            'mac; mac os ',
            'bingpreview',
            'crystalsemanticsbot',
            '360spider',
        );

        if ($this->utils->checkIfContains($isNotReallyAnIE, true)
            && !$this->utils->checkIfContains(array('Bitte Mozilla Firefox verwenden', 'chromeframe'))
        ) {
            return false;
        }

        if ($this->utils->checkIfContains('Gecko')
            && !$this->utils->checkIfContainsAll(array('like Gecko', 'rv:11.0'))
        ) {
            return false;
        }

        foreach (array_keys($this->patterns) as $pattern) {
            if (preg_match($pattern, $this->useragent)) {
                return true;
            }
        }

        return false;
    }

    /**
     * gets the name of the browser
     *
     * @return string
     */
    public function getName()
    {
        return 'Internet Explorer';
    }

    /**
     * gets the maker of the browser
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Microsoft();
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

        $engine = $this->detectEngine();

        $engineVersion = (int)$engine->detectVersion()->getVersion(
            Version::MAJORONLY
        );

        switch ($engineVersion) {
            case 4:
                return $detector->setVersion('8.0');
                break;
            case 5:
                return $detector->setVersion('9.0');
                break;
            case 6:
                return $detector->setVersion('10.0');
                break;
            case 7:
                return $detector->setVersion('11.0');
                break;
            default:
                //nothing to do
                break;
        }

        $doMatch = preg_match('/MSIE ([\d\.]+)/', $this->useragent, $matches);

        if ($doMatch) {
            return $detector->setVersion($matches[1]);
        }

        foreach ($this->patterns as $pattern => $version) {
            if (preg_match($pattern, $this->useragent)) {
                return $detector->setVersion($version);
            }
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
        return 369968046;
    }

    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return \BrowserDetector\Detector\Engine\Trident
     */
    public function detectEngine()
    {
        $handler = new Trident();
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
     * @return \BrowserDetector\Detector\Browser\General\MicrosoftInternetExplorer
     */
    public function detectDependProperties(
        EngineHandler $engine, OsHandler $os, DeviceHandler $device
    ) {
        $engineVersion = (int)$engine->detectVersion()->getVersion(
            Version::MAJORONLY
        );

        $browserVersion  = $this->detectVersion();

        $doMatch = preg_match('/MSIE ([\d\.]+)/', $this->useragent, $matches);

        if ($doMatch) {
            $browserVersion->setVersion($matches[1]);
        }

        $detectedVersion = $browserVersion->getVersion(Version::MAJORONLY);

        switch ($engineVersion) {
            case 4:
                if ($this->utils->checkIfContains('Trident/4.0')
                    && 8 > $detectedVersion
                ) {
                    $this->setCapability(
                        'mobile_browser_modus',
                        'IE ' . $detectedVersion . '.0 Compatibility Mode'
                    );
                }
                break;
            case 5:
                if (9 > $detectedVersion) {
                    $this->setCapability(
                        'mobile_browser_modus',
                        'IE ' . $detectedVersion . '.0 Compatibility Mode'
                    );
                }
                break;
            case 6:
                if (10 > $detectedVersion) {
                    $this->setCapability(
                        'mobile_browser_modus',
                        'IE ' . $detectedVersion . '.0 Compatibility Mode'
                    );
                }
                break;
            case 7:
                if (11 > $detectedVersion) {
                    $this->setCapability(
                        'mobile_browser_modus',
                        'IE ' . $detectedVersion . '.0 Compatibility Mode'
                    );
                }
                break;
            default:
                //nothing to do
                break;
        }

        parent::detectDependProperties($engine, $os, $device);

        $engine->setCapability('is_sencha_touch_ok', false);
        $engine->setCapability('image_inlining', false);
        $engine->setCapability('css_spriting', false);
        $engine->setCapability('jqm_grade', 'C');

        $browserVersion = (int)$browserVersion->getVersion(Version::MAJORONLY);

        switch ($browserVersion) {
            case 11:
                $engine->setCapability('jqm_grade', 'A');
                $engine->setCapability('is_sencha_touch_ok', true);
                $engine->setCapability('image_inlining', true);
                $engine->setCapability('css_spriting', true);
                $engine->setCapability('svgt_1_1', true);
                break;
            case 10:
                $engine->setCapability('jqm_grade', 'A');
                $engine->setCapability('is_sencha_touch_ok', true);
                $engine->setCapability('image_inlining', true);
                $engine->setCapability('css_spriting', true);
                $engine->setCapability('svgt_1_1', true);
                break;
            case 9:
                $engine->setCapability('jqm_grade', 'A');
                $engine->setCapability('is_sencha_touch_ok', true);
                $engine->setCapability('image_inlining', true); //wurflkey: msie_9
                $engine->setCapability('css_spriting', true);
                $engine->setCapability('svgt_1_1', true);
                break;
            case 8:
                $engine->setCapability('jqm_grade', 'A');
                $engine->setCapability('is_sencha_touch_ok', true);
                $engine->setCapability('image_inlining', false);
                $engine->setCapability('css_spriting', true);
                break;
            case 7:
                $engine->setCapability('jqm_grade', 'A');
                $engine->setCapability('is_sencha_touch_ok', true);
                $engine->setCapability('image_inlining', false);
                $engine->setCapability('css_spriting', true);
                break;
            case 6:
                $engine->setCapability('jqm_grade', 'A');
                $engine->setCapability('is_sencha_touch_ok', true);
                break;
            default:
                // nothing to do here
                break;
        }

        return $this;
    }
}
