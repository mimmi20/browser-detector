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
use BrowserDetector\Detector\Device\AbstractDevice;
use BrowserDetector\Detector\Engine\Webkit;
use BrowserDetector\Detector\Engine\AbstractEngine;

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
            '/Safari\/([\d\.]+)/',
            $this->useragent,
            $matches
        );

        if ($doMatch) {
            return $detector->setVersion($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match('/Safari([\d\.]+)/', $this->useragent, $matches);

        if ($doMatch) {
            return $detector->setVersion($safariHelper->mapSafariVersions($matches[1]));
        }

        $doMatch = preg_match(
            '/MobileSafari\/([\d\.]+)/',
            $this->useragent,
            $matches
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
     * @param \BrowserDetector\Detector\Engine\AbstractEngine $engine
     * @param \BrowserDetector\Detector\Os\AbstractOs     $os
     * @param \BrowserDetector\Detector\Device\AbstractDevice $device
     *
     * @return \BrowserDetector\Detector\Browser\General\Safari
     */
    public function detectDependProperties(
        AbstractEngine $engine,
        AbstractOs $os,
        AbstractDevice $device
    ) {
        if ($device->getDeviceType()->isMobile()) {
            $engine->setCapability('xhtml_format_as_css_property', true);
            $engine->setCapability('css_gradient', 'webkit');

            if (!$device->getDeviceType()->isTablet()) {
                $engine->setCapability('xhtml_send_sms_string', 'sms:');
            }
        } else {
            $this->setCapability('rss_support', false);
        }

        parent::detectDependProperties($engine, $os, $device);

        $osVersion = (float)$os->detectVersion()->getVersion(
            Version::MAJORMINOR
        );

        if (!$device->getDeviceType()->isTablet() && $osVersion >= 6.0
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

        $engine->setCapability('chtml_table_support', false);

        if ('iOS' === $osname) {
            if ($osVersion >= 4.3) {
                $engine->setCapability('html_wi_oma_xhtmlmp_1_0', true);
                $engine->setCapability('html_wi_imode_compact_generic', true);
                $engine->setCapability('xhtml_select_as_radiobutton', false);
                $engine->setCapability('xhtml_avoid_accesskeys', false);
                $engine->setCapability('xhtml_select_as_dropdown', false);
                $engine->setCapability('xhtml_supports_forms_in_table', false);
                $engine->setCapability('xhtml_select_as_popup', false);
                $engine->setCapability('xhtml_file_upload', 'not_supported');
                $engine->setCapability('xhtml_supports_css_cell_table_coloring', true);
                $engine->setCapability('xhtml_can_embed_video', 'none');
                $engine->setCapability('xhtml_readable_background_color1', '#D9EFFF');
                $engine->setCapability('xhtml_supports_table_for_layout', true);
                $engine->setCapability('max_url_length_in_requests', 512);
                $engine->setCapability('ajax_preferred_geoloc_api', 'w3c_api');
                $engine->setCapability('canvas_support', 'full');
                $engine->setCapability('viewport_width', 'device_width_token');
                $engine->setCapability('viewport_supported', true);
                $engine->setCapability('viewport_userscalable', 'no');
                $engine->setCapability('css_gradient', 'none');
                $engine->setCapability('css_gradient_linear', 'none');
            }

            if ($osVersion >= 5.1) {
                $engine->setCapability('jqm_grade', 'A');
                $engine->setCapability('supports_java_applets', true);
            }

            if ((float)$browserVersion >= 5.1) {
                $engine->setCapability('css_gradient_linear', 'webkit');
            }
        }

        if ('Mac OS X' === $osname && 10.0 <= $osVersion) {
            $engine->setCapability('jqm_grade', 'A');
            $engine->setCapability('xhtml_make_phone_call_string', 'none');
            $engine->setCapability('xhtml_table_support', false);
            $engine->setCapability('css_gradient', 'none');
            $engine->setCapability('css_gradient_linear', 'none');
            $engine->setCapability('css_border_image', 'none');
            $engine->setCapability('css_rounded_corners', 'none');
            $engine->setCapability('chtml_table_support', true);

            $this->setCapability('wurflKey', 'safari_' . (int)$browserVersion . '_0_mac');
        }

        if ('Windows' === $osname) {
            $engine->setCapability('jqm_grade', 'A');
            $engine->setCapability('xhtml_make_phone_call_string', 'none');
            $engine->setCapability('xhtml_table_support', false);
            $engine->setCapability('css_gradient', 'none');
            $engine->setCapability('css_gradient_linear', 'none');
            $engine->setCapability('css_border_image', 'none');
            $engine->setCapability('css_rounded_corners', 'none');
            $engine->setCapability('chtml_table_support', true);

            $this->setCapability('wurflKey', 'safari_' . (int)$browserVersion . '_0_windows');
        }

        return $this;
    }
}
