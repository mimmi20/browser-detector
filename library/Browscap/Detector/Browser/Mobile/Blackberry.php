<?php
namespace Browscap\Detector\Browser\Mobile;

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
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */

use \Browscap\Detector\BrowserHandler;
use \Browscap\Helper\Utils;
use \Browscap\Detector\MatcherInterface;
use \Browscap\Detector\MatcherInterface\BrowserInterface;
use \Browscap\Detector\EngineHandler;
use \Browscap\Detector\DeviceHandler;
use \Browscap\Detector\OsHandler;
use \Browscap\Detector\Version;

/**
 * BlackBerryUserAgentHandler
 * 
 *
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
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
    protected $_properties = array(
        'wurflKey' => null, // not in wurfl
        
        // kind of device
        'is_bot'                => false,
        'is_transcoder'         => false,
        'is_syndication_reader' => false,     // not in wurfl
        'browser_type'          => 'Browser', // not in wurfl
        'is_banned'             => false,     // not in wurfl
        
        // browser
        'mobile_browser'              => 'BlackBerry',
        'mobile_browser_version'      => null,
        'mobile_browser_bits'         => null, // not in wurfl
        'mobile_browser_manufacturer' => 'RIM', // not in wurfl
        'mobile_browser_modus'        => null, // not in wurfl
        
        // product info
        'can_skip_aligned_link_row' => true,
        'device_claims_web_support' => true,
        
        // pdf
        'pdf_support' => false,
        
        // bugs
        'empty_option_value_support' => true,
        'basic_authentication_support' => true,
        'post_method_support' => true,
        
        // rss
        'rss_support' => false,
    );
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if ($this->_utils->checkIfContains('MQQBrowser')) {
            return false;
        }
        
        if ($this->_utils->checkIfContains(array('BlackBerry', 'Blackberry'))) {
            return true;
        }
        
        return false;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $detector = new \Browscap\Detector\Version();
        $detector->setUserAgent($this->_useragent);
        
        $searches = array(
            'BlackBerry[0-9a-z]+', 'BlackBerrySimulator', 'Version'
        );
        
        $this->setCapability(
            'mobile_browser_version', $detector->detectVersion($searches)
        );
        
        return $this;
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 99383;
    }
    
    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectEngine()
    {
        $engines = array(
            new \Browscap\Detector\Engine\Webkit(),
            new \Browscap\Detector\Engine\BlackBerry()
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUseragent($this->_useragent);
        $chain->setHandlers($engines);
        $chain->setDefaultHandler(new \Browscap\Detector\Engine\Unknown());
        
        return $chain->detect();
    }
    
    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @return DeviceHandler
     */
    public function detectDependProperties(
        EngineHandler $engine, OsHandler $os, DeviceHandler $device)
    {
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
        
        $osVersion = $os->getCapability('device_os_version')->getVersion(Version::MAJORMINOR);
        
        if ($osVersion == 6.0) {
            $this->setCapability('pdf_support', true);
        }
        
        return $this;
    }
}