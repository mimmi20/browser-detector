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
use BrowserDetector\Detector\Engine\Gecko;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\SpamCrawlerFake;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Firefox
    extends BrowserHandler
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        // browser
        'wurflKey'                     => 'firefox', // not in wurfl
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
        $spamHelper = new SpamCrawlerFake();
        $spamHelper->setUserAgent($this->useragent);

        if (!$this->utils->checkIfContains('Mozilla/')
            && !$spamHelper->isAnonymized()
        ) {
            return false;
        }

        $firefoxCodes = array(
            'Firefox', 'Minefield', 'Nightly', 'Shiretoko', 'BonEcho',
            'Namoroka', 'Fennec'
        );

        if (!$this->utils->checkIfContains($firefoxCodes)) {
            return false;
        }

        $isNotReallyAnFirefox = array(
            // using also the Gecko rendering engine
            'Maemo',
            'Maxthon',
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
            //others
            'MSIE',
            'Trident',
            // Fakes
            'Mac; Mac OS '
        );

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
        return 'Firefox';
    }

    /**
     * gets the maker of the browser
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\MozillaFoundation();
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
        $detector->setMode(Version::COMPLETE | Version::IGNORE_MICRO_IF_EMPTY);

        $searches = array(
            'Firefox', 'Minefield', 'Shiretoko', 'BonEcho', 'Namoroka', 'Fennec'
        );

        return $detector->detectVersion($searches);
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 330161978;
    }

    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return \BrowserDetector\Detector\Engine\Gecko
     */
    public function detectEngine()
    {
        $handler = new Gecko();
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
     * @return \BrowserDetector\Detector\Browser\General\Firefox
     */
    public function detectDependProperties(
        EngineHandler $engine, OsHandler $os, DeviceHandler $device
    ) {
        parent::detectDependProperties($engine, $os, $device);

        $engine->setCapability('xhtml_table_support', false);

        if ($device->getDeviceType()->isMobile()
            && 'Android' == $os->getName()
        ) {
            $device->setCapability('has_qwerty_keyboard', true);
            $device->setCapability('pointing_method', 'touchscreen');
            $engine->setCapability('html_wi_oma_xhtmlmp_1_0', true);
            $engine->setCapability('chtml_table_support', false);
            $engine->setCapability('xhtml_select_as_radiobutton', false);
            $engine->setCapability('xhtml_select_as_dropdown', false);
            $engine->setCapability('xhtml_select_as_popup', false);
            $engine->setCapability('xhtml_file_upload', 'not_supported');
            $engine->setCapability('xhtml_supports_css_cell_table_coloring', true);
            $engine->setCapability('xhtml_allows_disabled_form_elements', true);
            $engine->setCapability('xhtml_table_support', true);
            $engine->setCapability('xhtml_can_embed_video', 'play_and_stop');
            $engine->setCapability('xhtml_supports_table_for_layout', true);
            $engine->setCapability('canvas_support', 'full');
            $engine->setCapability('viewport_supported', true);
            $engine->setCapability('viewport_width', 'device_width_token');
            $engine->setCapability('viewport_userscalable', 'no');
            $engine->setCapability('css_gradient', 'mozilla');
            $engine->setCapability('css_border_image', 'mozilla');
            $engine->setCapability('css_rounded_corners', 'mozilla');

            if (!$device->getDeviceType()->isTablet()) {
                $device->setCapability('sms_enabled', true);
                $device->setCapability('nfc_support', true);
            }
        }

        $version = $this->detectVersion()->getVersion(Version::MAJORONLY);

        if ($version >= 12) {
            $engine->setCapability('css_gradient', 'mozilla');
        }

        if ($version >= 16) {
            $engine->setCapability('css_gradient', 'css3');
        }

        if ($version >= 28) {
            $engine->setCapability('css_gradient_linear', 'css3');
            $engine->setCapability('css_border_image', 'css3');
            $engine->setCapability('css_rounded_corners', 'css3');
        }

        if ($version >= 34) {
            $engine->setCapability('svgt_1_1', false);
        }

        $browserVersion = (float) $this->detectVersion()->getVersion(Version::MAJORMINOR);

        switch ($browserVersion) {
            case 3.5:
                $this->setCapability('wurflKey', 'firefox_3_5');
                break;
            default:
                $this->setCapability('wurflKey', 'firefox_' . (int) $browserVersion . '_0');
                break;
        }

        return $this;
    }
}
