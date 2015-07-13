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


use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\AbstractDevice;
use BrowserDetector\Detector\Engine\UnknownEngine;
use BrowserDetector\Detector\Engine\Webkit;
use BrowserDetector\Detector\Engine\AbstractEngine;

use BrowserDetector\Detector\Os\AbstractOs;
use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class NokiaBrowser
    extends AbstractBrowser
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
        if (!$this->utils->checkIfContains(array('NokiaAbstractBrowser', 'Nokia'))) {
            return false;
        }

        if ($this->utils->checkIfContains(array('OviBrowser', 'UCWEB', 'S40OviBrowser'))) {
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
        return 'Nokia Browser';
    }

    /**
     * gets the maker of the browser
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Nokia();
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

        $searches = array('BrowserNG', 'NokiaAbstractBrowser');

        return $detector->detectVersion($searches);
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 260003;
    }

    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return \BrowserDetector\Detector\Engine\AbstractEngine
     */
    public function detectEngine()
    {
        $engines = array(
            new Webkit()
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
     * @param \BrowserDetector\Detector\Engine\AbstractEngine $engine
     * @param \BrowserDetector\Detector\Os\AbstractOs     $os
     * @param \BrowserDetector\Detector\Device\AbstractDevice $device
     *
     * @return \BrowserDetector\Detector\Browser\NokiaBrowser
     */
    public function detectDependProperties(
        AbstractEngine $engine,
        AbstractOs $os,
        AbstractDevice $device
    ) {
        $engine->setCapability('multipart_support', true);
        $engine->setCapability('wml_1_1', true);
        $engine->setCapability('wml_1_2', true);
        $engine->setCapability('wml_1_3', true);
        $engine->setCapability('html_wi_imode_compact_generic', false);
        $engine->setCapability('xhtml_avoid_accesskeys', true);
        $engine->setCapability('xhtmlmp_preferred_mime_type', 'application/xhtml+xml');
        $engine->setCapability('xhtml_file_upload', 'supported');
        $engine->setCapability('xhtml_make_phone_call_string', 'wtai://wp/mc;');
        $engine->setCapability('xhtml_send_mms_string', 'mmsto:');
        $engine->setCapability('xhtml_can_embed_video', 'play_and_stop');
        $engine->setCapability('xhtml_readable_background_color1', '#FFFFFF');
        $engine->setCapability('xhtml_send_sms_string', 'sms:');
        $engine->setCapability('xhtml_format_as_css_property', true);
        $engine->setCapability('wbmp', true);
        $engine->setCapability('epoc_bmp', true);
        $engine->setCapability('transparent_png_alpha', true);
        $engine->setCapability('tiff', true);
        $engine->setCapability('max_url_length_bookmark', 255);
        $engine->setCapability('max_url_length_cached_page', 128);
        $engine->setCapability('max_url_length_in_requests', 255);
        $engine->setCapability('max_url_length_homepage', 100);
        $engine->setCapability('ajax_preferred_geoloc_api', 'none');
        $engine->setCapability('jqm_grade', 'B');
        $engine->setCapability('is_sencha_touch_ok', false);
        $engine->setCapability('image_inlining', false); // version 8.3
        $engine->setCapability('canvas_support', 'none');
        $engine->setCapability('css_border_image', 'none');
        $engine->setCapability('css_rounded_corners', 'none');

        return $this;
    }
}

