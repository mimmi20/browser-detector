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
use \Browscap\Detector\OsHandler;
use \Browscap\Detector\Version;

/**
 * MSIEAgentHandler
 *
 *
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
class MicrosoftInternetExplorer
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
        
        // device
        // 'model_name'                => null,
        // 'manufacturer_name'         => null,
        // 'brand_name'                => 'Microsoft',
        // 'model_extra_info'          => null,
        // 'marketing_name'            => null,
        'has_qwerty_keyboard'       => true,
        // 'pointing_method'           => 'mouse',
        'device_claims_web_support' => true,
        
        // browser
        'mobile_browser'              => 'Internet Explorer',
        'mobile_browser_version'      => null,
        'mobile_browser_bits'         => null, // not in wurfl
        'mobile_browser_manufacturer' => 'Microsoft', // not in wurfl
        'mobile_browser_modus'        => null, // not in wurfl
        
        // product info
        'can_skip_aligned_link_row' => true,
        'device_claims_web_support' => false,
        
        // markup
        'utf8_support' => null,
        'multipart_support' => null,
        'html_web_3_2' => null,
        'html_web_4_0' => null,
        'html_wi_oma_xhtmlmp_1_0' => null,
        'wml_1_1' => null,
        'wml_1_2' => null,
        'wml_1_3' => null,
        'html_wi_imode_html_1' => null,
        'html_wi_imode_html_2' => null,
        'html_wi_imode_html_3' => null,
        'html_wi_imode_html_4' => null,
        'html_wi_imode_html_5' => null,
        'html_wi_imode_htmlx_1' => null,
        'html_wi_imode_htmlx_1_1' => null,
        'html_wi_w3_xhtmlbasic' => null,
        'html_wi_imode_compact_generic' => null,
        'voicexml' => null,
        
        // chtml
        'chtml_table_support' => null,
        'imode_region' => null,
        'chtml_can_display_images_and_text_on_same_line' => null,
        'chtml_displays_image_in_center' => null,
        'chtml_make_phone_call_string' => null,
        'chtml_display_accesskey' => null,
        'emoji' => null,
        
        // xhtml
        'xhtml_select_as_radiobutton' => null,
        'xhtml_avoid_accesskeys' => null,
        'xhtml_select_as_dropdown' => null,
        'xhtml_supports_iframe' => null,
        'xhtml_supports_forms_in_table' => null,
        'xhtmlmp_preferred_mime_type' => null,
        'xhtml_select_as_popup' => null,
        'xhtml_honors_bgcolor' => null,
        'xhtml_file_upload' => null,
        'xhtml_preferred_charset' => null,
        'xhtml_supports_css_cell_table_coloring' => null,
        'xhtml_autoexpand_select' => null,
        'accept_third_party_cookie' => null,
        'xhtml_make_phone_call_string' => null,
        'xhtml_allows_disabled_form_elements' => null,
        'xhtml_supports_invisible_text' => null,
        'cookie_support' => null,
        'xhtml_send_mms_string' => null,
        'xhtml_table_support' => null,
        'xhtml_display_accesskey' => null,
        'xhtml_can_embed_video' => null,
        'xhtml_supports_monospace_font' => null,
        'xhtml_supports_inline_input' => null,
        'xhtml_document_title_support' => null,
        'xhtml_support_wml2_namespace' => null,
        'xhtml_readable_background_color1' => null,
        'xhtml_format_as_attribute' => null,
        'xhtml_supports_table_for_layout' => null,
        'xhtml_readable_background_color2' => null,
        'xhtml_send_sms_string' => null,
        'xhtml_format_as_css_property' => null,
        'opwv_xhtml_extensions_support' => null,
        'xhtml_marquee_as_css_property' => null,
        'xhtml_nowrap_mode' => null,
        
        // image format
        'jpg' => null,
        'gif' => null,
        'bmp' => null,
        'wbmp' => null,
        'gif_animated' => null,
        'colors' => null,
        'png' => null,
        'greyscale' => null,
        'transparent_png_index' => null,
        'epoc_bmp' => null,
        'svgt_1_1_plus' => null,
        'svgt_1_1' => null,
        'transparent_png_alpha' => null,
        'tiff' => null,
        
        // security
        'https_support' => null,
        
        // storage
        'max_url_length_bookmark' => null,
        'max_url_length_cached_page' => null,
        'max_url_length_in_requests' => null,
        'max_url_length_homepage' => null,
        
        // ajax
        'ajax_support_getelementbyid' => null,
        'ajax_xhr_type' => null,
        'ajax_support_event_listener' => null,
        'ajax_support_javascript' => null,
        'ajax_manipulate_dom' => null,
        'ajax_support_inner_html' => null,
        'ajax_manipulate_css' => null,
        'ajax_support_events' => null,
        'ajax_preferred_geoloc_api' => null,
        
        // wml
        'wml_make_phone_call_string' => null,
        'card_title_support' => null,
        'table_support' => null,
        'elective_forms_recommended' => null,
        'menu_with_list_of_links_recommended' => null,
        'break_list_of_links_with_br_element_recommended' => null,
        'icons_on_menu_items_support' => null,
        'opwv_wml_extensions_support' => null,
        'built_in_back_button_support' => null,
        'proportional_font' => null,
        'insert_br_element_after_widget_recommended' => null,
        'wizards_recommended' => null,
        'wml_can_display_images_and_text_on_same_line' => null,
        'softkey_support' => null,
        'deck_prefetch_support' => null,
        'menu_with_select_element_recommended' => null,
        'numbered_menus' => null,
        'image_as_link_support' => null,
        'wrap_mode_support' => null,
        'access_key_support' => null,
        'wml_displays_image_in_center' => null,
        'times_square_mode_support' => null,
        
        // pdf
        'pdf_support' => null,
        
        // third_party
        'jqm_grade' => null,
        'is_sencha_touch_ok' => null,
        
        // html
        'image_inlining' => null,
        'canvas_support' => null,
        'viewport_width' => null,
        'html_preferred_dtd' => null,
        'viewport_supported' => null,
        'viewport_minimum_scale' => null,
        'viewport_initial_scale' => null,
        'mobileoptimized' => null,
        'viewport_maximum_scale' => null,
        'viewport_userscalable' => null,
        'handheldfriendly' => null,
        
        // css
        'css_spriting' => null,
        'css_gradient' => null,
        'css_border_image' => null,
        'css_rounded_corners' => null,
        'css_supports_width_as_percentage' => null,
        
        // cache
        'time_to_live_support' => null,
        'total_cache_disable_support' => null,
        
        // bugs
        'emptyok' => null,
        'empty_option_value_support' => null,
        'basic_authentication_support' => null,
        'post_method_support' => null,
        
        // rss
        'rss_support' => null,
    );
    
    private $_patterns = array(
        '/Mozilla\/5\.0 \(.*MSIE 11\.0.*/' => '11.0',
        '/Mozilla\/5\.0 \(.*MSIE 10\.0.*/' => '10.0',
        '/Mozilla\/5\.0 \(.*MSIE 9\.0.*/'  => '9.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 8\.0.*/'  => '8.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 7\.0.*/'  => '7.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 6\.0.*/'  => '6.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.5.*/'  => '5.5',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.23.*/' => '5.23',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.22.*/' => '5.22',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.01.*/' => '5.01',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.0.*/'  => '5.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 4\.01.*/' => '4.01',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 4\.0.*/'  => '4.0',
        '/Mozilla\/.*\(.*MSIE 3\..*/'          => '3.0',
        '/Mozilla\/.*\(.*MSIE 2\..*/'          => '2.0',
        '/Mozilla\/.*\(.*MSIE 1\..*/'          => '1.0'
    );
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->_utils->checkIfStartsWith('Mozilla/')) {
            return false;
        }
        
        if (!$this->_utils->checkIfContains('MSIE')) {
            return false;
        }
        
        $isNotReallyAnIE = array(
            'Gecko',
            'Presto',
            'Webkit',
            'KHTML',
            // using also the Trident rendering engine
            'Avant Browser',
            'Crazy Browser',
            'Flock',
            'Galeon',
            'Lunascape',
            'Maxthon',
            'MyIE',
            'Opera',
            'PaleMoon',
            // other Browsers
            'AppleWebKit',
            'Chrome',
            'Linux',
            'MSOffice',
            'Outlook',
            'IEMobile',
            'BlackBerry',
            'WebTV',
            'ArgClrInt',
            'Firefox',
            'MSIECrawler',
            // mobile IE
            'XBLWP7',
            'ZuneWP7',
            // Fakes
            'Mac; Mac OS '
        );
        
        if ($this->_utils->checkIfContains($isNotReallyAnIE)
            && !$this->_utils->checkIfContains('Bitte Mozilla Firefox verwenden')
        ) {
            return false;
        }
        
        foreach (array_keys($this->_patterns) as $pattern) {
            if (preg_match($pattern, $this->_useragent)) {
                return true;
            }
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
        $detector->setMode(Version::COMPLETE | Version::IGNORE_MICRO);
        
        $doMatch = preg_match('/MSIE ([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->setCapability(
                'mobile_browser_version', $detector->setVersion($matches[1])
            );
            
            return $this;
        }
        
        foreach ($this->_patterns as $pattern => $version) {
            if (preg_match($pattern, $this->_useragent)) {
                $this->setCapability(
                    'mobile_browser_version', $detector->setVersion($version)
                );
                
                return $this;
            }
        }
        
        $this->setCapability(
            'mobile_browser_version', $detector->setVersion('')
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
        return 175451664;
    }
    
    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectEngine()
    {
        $handler = new \Browscap\Detector\Engine\Trident();
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
        EngineHandler $engine, OsHandler $os)
    {
        $engineVersion = (int) $engine->getCapability('renderingengine_version')->getVersion(
            Version::MAJORONLY
        );
        
        $browserVersion  = $this->getCapability('mobile_browser_version');
        $detectedVersion = $browserVersion->getVersion(Version::MAJORONLY);
        
        switch ($engineVersion) {
            case 4:
                if ($this->_utils->checkIfContains('Trident/4.0')) {
                    $browserVersion->setVersion('8.0');
                    
                    $this->setCapability(
                        'mobile_browser_modus', 
                        'IE ' . $detectedVersion . ' Compatibility Mode'
                    );
                }
                break;
            case 5:
                if (9 != $detectedVersion) {
                    $browserVersion->setVersion('9.0');
                    
                    $this->setCapability(
                        'mobile_browser_modus', 
                        'IE ' . $detectedVersion . ' Compatibility Mode'
                    );
                }
                break;
            case 6:
                if (10 != $detectedVersion) {
                    $browserVersion->setVersion('10.0');
                    
                    $this->setCapability(
                        'mobile_browser_modus', 
                        'IE ' . $detectedVersion . ' Compatibility Mode'
                    );
                }
                break;
            default:
                //nothing to do
                break;
        }
        
        parent::detectDependProperties($engine, $os);
        
        return $this;
    }
}