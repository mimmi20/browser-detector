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

namespace BrowserDetector\Detector\Browser;


use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\AbstractDevice;
use BrowserDetector\Detector\Engine\Trident;
use BrowserDetector\Detector\AbstractEngine;

use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MicrosoftMobileExplorer
    extends AbstractBrowser
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        // browser
        'wurflKey'                     => null, // not in wurfl
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
        if (!$this->utils->checkIfContains(array('IEMobile', 'Windows CE', 'MSIE', 'WPDesktop', 'XBLWP7', 'ZuneWP7'))) {
            return false;
        }

        $isNotReallyAnIE = array(
            // using also the Trident rendering engine
            'Maxthon',
            'MxBrowser',
            'Galeon',
            'Lunascape',
            'Opera',
            'PaleMoon',
            'Flock',
            'MyIE',
            //others
            'Linux',
            'MSOffice',
            'Outlook',
            'BlackBerry',
            'WebTV',
            'ArgClrInt'
        );

        if ($this->utils->checkIfContains($isNotReallyAnIE)) {
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
        return 'IEMobile';
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

        if ($this->utils->checkIfContains(array('XBLWP7', 'ZuneWP7'))) {
            return $detector->setVersion('9.0');
        }

        if ($this->utils->checkIfContains('WPDesktop') && !$this->utils->checkIfContains('rv:')) {
            return $detector->setVersion('10.0');
        }

        $searches = array('IEMobile', 'MSIE', 'rv\:');

        return $detector->detectVersion($searches);
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
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 828786;
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\AbstractEngine $engine
     * @param \BrowserDetector\Detector\AbstractOs     $os
     * @param \BrowserDetector\Detector\AbstractDevice $device
     *
     * @return \BrowserDetector\Detector\Browser\General\MicrosoftMobileExplorer
     */
    public function detectDependProperties(
        AbstractEngine $engine,
        AbstractOs $os,
        AbstractDevice $device
    ) {
        parent::detectDependProperties($engine, $os, $device);

        $engine->setCapability('html_web_3_2', false);
        $engine->setCapability('html_wi_oma_xhtmlmp_1_0', true);
        $engine->setCapability('chtml_table_support', false);
        $engine->setCapability('xhtml_select_as_radiobutton', false);
        $engine->setCapability('xhtml_avoid_accesskeys', false);
        $engine->setCapability('xhtml_select_as_dropdown', false);
        $engine->setCapability('xhtml_supports_forms_in_table', false);
        $engine->setCapability('xhtmlmp_preferred_mime_type', 'application/vnd.wap.xhtml+xml');
        $engine->setCapability('xhtml_select_as_popup', false);
        $engine->setCapability('xhtml_honors_bgcolor', false);
        $engine->setCapability('xhtml_file_upload', 'not_supported');
        $engine->setCapability('xhtml_table_support', true);
        $engine->setCapability('bmp', true);
        $engine->setCapability('wbmp', true);
        $engine->setCapability('max_url_length_in_requests', 512);
        $engine->setCapability('wml_make_phone_call_string', 'wtai://wp/mc;');
        $engine->setCapability('card_title_support', true);
        $engine->setCapability('table_support', true);
        $engine->setCapability('elective_forms_recommended', true);
        $engine->setCapability('menu_with_list_of_links_recommended', true);
        $engine->setCapability('break_list_of_links_with_br_element_recommended', true);
        $engine->setCapability('is_sencha_touch_ok', false);
        $engine->setCapability('viewport_width', 'device_width_token');
        $engine->setCapability('viewport_supported', true);
        $engine->setCapability('viewport_userscalable', 'no');
        $engine->setCapability('css_spriting', true);
        $engine->setCapability('supports_background_sounds', false);
        $engine->setCapability('supports_java_applets', false);

        $version = (float)$this->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        if ($version >= 8) {
            $engine->setCapability('tiff', true);
            $engine->setCapability('image_inlining', true);
        }

        $engine->setCapability('is_sencha_touch_ok', false);

        if ($version >= 10) {
            $engine->setCapability('jqm_grade', 'A');
            $engine->setCapability('is_sencha_touch_ok', true);
        } elseif ($version >= 8) {
            $engine->setCapability('jqm_grade', 'A');
        } elseif ($version >= 7) {
            $engine->setCapability('jqm_grade', 'B');
        } else {
            $engine->setCapability('jqm_grade', 'C');
        }

        if ($this->utils->checkIfContains('WPDesktop')) {
            $this->setCapability('mobile_browser_modus', 'Desktop Mode');
        }

        return $this;
    }
}
