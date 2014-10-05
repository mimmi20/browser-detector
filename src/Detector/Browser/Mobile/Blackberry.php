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

namespace BrowserDetector\Detector\Browser\Mobile;

use BrowserDetector\Detector\BrowserHandler;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\Engine\BlackBerry as BlackBerryEngine;
use BrowserDetector\Detector\Engine\UnknownEngine;
use BrowserDetector\Detector\Engine\Webkit;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\BrowserInterface;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Version;

/**
 * BlackBerryUserAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Blackberry
    extends BrowserHandler
    implements MatcherInterface, BrowserInterface
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
        'pdf_support'                  => false,

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
        if ($this->utils->checkIfContains('MQQBrowser')) {
            return false;
        }

        if ($this->utils->checkIfContains(array('BlackBerry', 'Blackberry', 'BB10'))) {
            return true;
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
        return 'BlackBerry';
    }

    /**
     * gets the maker of the browser
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Rim();
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

        $searches = array(
            'BlackBerry[0-9a-z]+', 'BlackBerrySimulator', 'Version'
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
        return 216731;
    }

    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return \BrowserDetector\Detector\EngineHandler
     */
    public function detectEngine()
    {
        $engines = array(
            new Webkit(),
            new BlackBerryEngine()
        );

        $chain = new Chain();
        $chain->setUseragent($this->useragent);
        $chain->setHandlers($engines);
        $chain->setDefaultHandler(new UnknownEngine());

        return $chain->detect();
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\EngineHandler $engine
     * @param \BrowserDetector\Detector\OsHandler     $os
     * @param \BrowserDetector\Detector\DeviceHandler $device
     *
     * @return \BrowserDetector\Detector\Browser\Mobile\Blackberry
     */
    public function detectDependProperties(
        EngineHandler $engine, OsHandler $os, DeviceHandler $device
    ) {
        parent::detectDependProperties($engine, $os, $device);

        $engine->setCapability('multipart_support', true);
        $engine->setCapability('wml_1_1', true);
        $engine->setCapability('wml_1_2', true);
        $engine->setCapability('wml_1_3', true);
        $engine->setCapability('html_wi_imode_html_1', true);
        $engine->setCapability('xhtml_avoid_accesskeys', true);
        $engine->setCapability('xhtml_file_upload', 'supported');
        $engine->setCapability('xhtml_supports_css_cell_table_coloring', false);
        $engine->setCapability('xhtml_make_phone_call_string', 'wtai://wp/mc;');
        $engine->setCapability('xhtml_readable_background_color1', '#FFFFFF');
        $engine->setCapability('xhtml_supports_table_for_layout', false);
        $engine->setCapability('bmp', false);
        $engine->setCapability('wbmp', true);
        $engine->setCapability('max_url_length_in_requests', 256);
        $engine->setCapability('ajax_preferred_geoloc_api', 'gears');
        $engine->setCapability('is_sencha_touch_ok', false);
        $engine->setCapability('viewport_minimum_scale', '1.0');
        $engine->setCapability('viewport_initial_scale', '1.0');
        $engine->setCapability('viewport_maximum_scale', '1.0');
        $engine->setCapability('handheldfriendly', true);
        $engine->setCapability('css_border_image', 'none');
        $engine->setCapability('css_rounded_corners', 'none');
        $engine->setCapability('wml_1_1', true);

        $osVersion = $os->detectVersion()->getVersion(Version::MAJORMINOR);

        if ($osVersion == 6.0) {
            $this->setCapability('pdf_support', true);
        }

        return $this;
    }
}