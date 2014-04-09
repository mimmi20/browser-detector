<?php
namespace BrowserDetector\Detector\Browser\Mobile;

/**
 * PHP version 5.3
 *
 * LICENSE:
 *
 * Copyright (c) 2013, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * * Neither the name of the authors nor the names of its contributors may be
 *   used to endorse or promote products derived from this software without
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */

use BrowserDetector\Detector\BrowserHandler;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\Engine\Webkit;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\BrowserInterface;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
class Silk
    extends BrowserHandler
    implements MatcherInterface, BrowserInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array();

    /**
     * Class Constructor
     *
     * @return BrowserHandler
     */
    public function __construct()
    {
        parent::__construct();

        $this->properties = array(
            // kind of device
            'browser_type'                 => new BrowserType\Transcoder(), // not in wurfl

            // browser
            'mobile_browser'               => 'Silk',
            'mobile_browser_version'       => null,
            'mobile_browser_bits'          => null, // not in wurfl
            'mobile_browser_manufacturer'  => new Company\Amazon(), // not in wurfl
            'mobile_browser_modus'         => null, // not in wurfl

            // product info
            'can_skip_aligned_link_row'    => true,
            'device_claims_web_support'    => false,

            // pdf
            'pdf_support'                  => true,

            // bugs
            'empty_option_value_support'   => true,
            'basic_authentication_support' => true,
            'post_method_support'          => true,

            // rss
            'rss_support'                  => false,
        );
    }

    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains('Silk')) {
            return false;
        }

        return true;
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 225706;
    }

    /**
     * detects the browser version from the given user agent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->useragent);

        $searches = array('Silk');

        $this->setCapability(
            'mobile_browser_version', $detector->detectVersion($searches)
        );

        return $this;
    }

    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\OsHandler
     */
    public function detectEngine()
    {
        $handler = new Webkit();
        $handler->setUseragent($this->useragent);

        return $handler->detect();
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @return DeviceHandler
     */
    public function detectDependProperties(
        EngineHandler $engine, OsHandler $os, DeviceHandler $device
    ) {
        parent::detectDependProperties($engine, $os, $device);

        $engine->setCapability('html_wi_oma_xhtmlmp_1_0', false);
        $engine->setCapability('wml_1_1', true);
        $engine->setCapability('wml_1_2', true);
        $engine->setCapability('wml_1_3', true);
        $engine->setCapability('xhtml_support_level', 1);
        $engine->setCapability('html_wi_imode_compact_generic', false);
        $engine->setCapability('xhtml_avoid_accesskeys', true);
        $engine->setCapability('xhtml_supports_forms_in_table', true);
        $engine->setCapability('xhtmlmp_preferred_mime_type', 'application/vnd.wap.xhtml+xml');
        $engine->setCapability('xhtml_preferred_charset', 'utf8');
        $engine->setCapability('xhtml_make_phone_call_string', 'none');
        $engine->setCapability('xhtml_can_embed_video', 'play_and_stop');
        $engine->setCapability('xhtml_readable_background_color1', '#FFFFFF');
        $engine->setCapability('xhtml_format_as_css_property', true);
        $engine->setCapability('xhtml_marquee_as_css_property', true);
        $engine->setCapability('jpg', false);
        $engine->setCapability('png', false);
        $engine->setCapability('transparent_png_index', false);
        $engine->setCapability('transparent_png_alpha', false);
        $engine->setCapability('max_url_length_in_requests', 128);
        $engine->setCapability('ajax_preferred_geoloc_api', 'none');
        $engine->setCapability('is_sencha_touch_ok', true);
        $engine->setCapability('max_url_length_in_requests', 128);
        $engine->setCapability('max_url_length_in_requests', 128);

        if ($this->utils->checkIfContains('(Linux; U;')) {
            $this->setCapability('mobile_browser_modus', 'Desktop Mode');
        }

        $browserVersion = $this->getCapability('mobile_browser_version')->getVersion(
            Version::MAJORMINOR
        );

        if (2.2 <= (float)$browserVersion) {
            $engine->setCapability('xhtml_preferred_charset', 'utf8');
            $engine->setCapability('max_url_length_in_requests', 128);
            $engine->setCapability('ajax_preferred_geoloc_api', 'none');
            $this->setCapability('pdf_support', false);
            $engine->setCapability('is_sencha_touch_ok', true);
            // $engine->setCapability('ajax_preferred_geoloc_api', 'none');
            // $engine->setCapability('ajax_preferred_geoloc_api', 'none');
        }

        return $this;
    }
}