<?php
namespace Browscap\Detector\Browser\General;

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
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
class Firefox
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
        'mobile_browser'              => 'Firefox',
        'mobile_browser_version'      => null,
        'mobile_browser_bits'         => null, // not in wurfl
        'mobile_browser_manufacturer' => 'Mozilla Foundation', // not in wurfl
        'mobile_browser_modus'        => null, // not in wurfl
        
        // product info
        'can_skip_aligned_link_row' => true,
        'device_claims_web_support' => true,
        
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
        if (!$this->_utils->checkIfContains('Mozilla/4.0')
            && !$this->_utils->checkIfContains('Mozilla/5.0')
        ) {
            return false;
        }
        
        $firefoxCodes = array(
            'Firefox', 'Minefield', 'Nightly', 'Shiretoko', 'BonEcho',
            'Namoroka', 'Fennec'
        );
        
        if (!$this->_utils->checkIfContains($firefoxCodes)) {
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
            //Nutch
            'Nutch',
            'CazoodleBot',
            'LOOQ',
            //others
            'MSIE',
            // Fakes
            'Mac; Mac OS '
        );
        
        if ($this->_utils->checkIfContains($isNotReallyAnFirefox)) {
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
        $detector->setMode(Version::COMPLETE | Version::IGNORE_MICRO_IF_EMPTY);
        
        $searches = array(
            'Firefox', 'Minefield', 'Shiretoko', 'BonEcho', 'Namoroka', 'Fennec'
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
        return 163495370;
    }
    
    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectEngine()
    {
        $handler = new \Browscap\Detector\Engine\Gecko();
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
        
        if ($device->getCapability('is_wireless_device')
            && 'Android' == $os->getCapability('device_os')
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
            
            if (!$device->getCapability('is_tablet')) {
                $device->setCapability('sms_enabled', true);
                $device->setCapability('nfc_support', true);
            }
        }
        
        return $this;
    }
}