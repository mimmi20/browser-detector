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
 * CatchAllUserAgentHandler
 *
 *
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
class WebkitWebos
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
        'is_bot'             => false,
        'is_transcoder'      => false,
        'device_claims_web_support' => true,
        
        // browser
        'mobile_browser'              => 'WebKit/webOS',
        'mobile_browser_version'      => null,
        'mobile_browser_bits'         => null, // not in wurfl
        'mobile_browser_manufacturer' => 'HP', // not in wurfl
        'mobile_browser_modus'        => null, // not in wurfl
        
        // product info
        'can_skip_aligned_link_row' => true,
        'device_claims_web_support' => false,
        
        // pdf
        'pdf_support' => true,
        
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
        if (!$this->_utils->checkIfContains(array('webOS', 'webOSBrowser', 'wOSBrowser', 'wOSSystem'))) {
            return false;
        }
        
        return true;
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
        
        $searches = array('webOS', 'webOSBrowser');
        
        $this->setCapability(
            'mobile_browser_version', $detector->detectVersion($searches)
        );
        
        return $this;
    }
    
    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectEngine()
    {
        $handler = new \Browscap\Detector\Engine\Webkit();
        $handler->setUseragent($this->_useragent);
        
        return $handler->detect();
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
        
        $engine->setCapability('html_wi_imode_compact_generic', false);
        $engine->setCapability('xhtml_avoid_accesskeys', true);
        $engine->setCapability('xhtml_supports_forms_in_table', true);
        $engine->setCapability('xhtml_file_upload', 'supported');
        $engine->setCapability('xhtml_supports_invisible_text', true);
        $engine->setCapability('xhtml_readable_background_color1', '#FFFFFF');
        $engine->setCapability('colors', 65536);
        $engine->setCapability('xhtml_allows_disabled_form_elements', true);
        
        $osVersion = $os->getCapability('device_os_version')->getVersion(
            Version::MAJORMINOR
        );
        
        if ($osVersion <= 2.3) {
            $engine->setCapability('xhtml_can_embed_video', 'play_and_stop');
            $engine->setCapability('bmp', true);
        }
        
        $engine->setCapability('preferred_markup', 'html_web_5_0');
        $engine->setCapability('wml_1_1', true);
        $engine->setCapability('html_wi_imode_compact_generic', false);
        $engine->setCapability('xhtml_honors_bgcolor', false);
        $engine->setCapability('xhtml_file_upload', 'supported');
        $engine->setCapability('xhtml_supports_css_cell_table_coloring', false);
        $engine->setCapability('xhtml_readable_background_color1', '#FFFFFF');
        $engine->setCapability('xhtml_supports_table_for_layout', false);
        $engine->setCapability('wbmp', true);
        $engine->setCapability('max_url_length_in_requests', 256);
        $engine->setCapability('ajax_support_getelementbyid', false);
        $engine->setCapability('ajax_xhr_type', 'none');
        $engine->setCapability('ajax_support_event_listener', false);
        $engine->setCapability('ajax_support_javascript', false);
        $engine->setCapability('ajax_manipulate_dom', false);
        $engine->setCapability('ajax_support_inner_html', false);
        $engine->setCapability('ajax_manipulate_css', false);
        $engine->setCapability('ajax_support_events', false);
        $engine->setCapability('ajax_preferred_geoloc_api', 'none');
        $engine->setCapability('table_support', true);
        $engine->setCapability('elective_forms_recommended', true);
        $engine->setCapability('menu_with_list_of_links_recommended', true);
        $engine->setCapability('break_list_of_links_with_br_element_recommended', true);
        $this->setCapability('pdf_support', false);
        $engine->setCapability('is_sencha_touch_ok', false);
        $engine->setCapability('html_preferred_dtd', 'xhtml_mp1');
        $engine->setCapability('css_gradient', 'webkit');
        
        return $this;
    }
}