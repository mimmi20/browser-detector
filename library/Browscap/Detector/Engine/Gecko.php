<?php
namespace Browscap\Detector\Engine;

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

use \Browscap\Detector\EngineHandler;
use \Browscap\Detector\MatcherInterface;

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
class Gecko extends EngineHandler
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $_properties = array(
        // engine
        'renderingengine_name'         => 'Gecko', // not in wurfl
        'renderingengine_version'      => '', // not in wurfl
        'renderingengine_manufacturer' => 'Mozilla',
        
        // markup
        'utf8_support' => false,
        'multipart_support' => false,
        'supports_background_sounds' => false, // not in wurfl
        'supports_vb_script' => false, // not in wurfl
        'supports_java_applets' => true, // not in wurfl
        'supports_activex_controls' => false, // not in wurfl
        'preferred_markup' => 'html_web_4_0',
        'html_web_3_2' => true,
        'html_web_4_0' => true,
        'html_wi_oma_xhtmlmp_1_0' => false,
        'wml_1_1' => false,
        'wml_1_2' => false,
        'wml_1_3' => false,
        'xhtml_support_level' => 4,
        'html_wi_imode_html_1' => false,
        'html_wi_imode_html_2' => false,
        'html_wi_imode_html_3' => false,
        'html_wi_imode_html_4' => false,
        'html_wi_imode_html_5' => false,
        'html_wi_imode_htmlx_1' => false,
        'html_wi_imode_htmlx_1_1' => false,
        'html_wi_w3_xhtmlbasic' => true,
        'html_wi_imode_compact_generic' => false,
        'voicexml' => false,
        
        // chtml
        'chtml_table_support' => true,
        'imode_region' => 'none',
        'chtml_can_display_images_and_text_on_same_line' => false,
        'chtml_displays_image_in_center' => false,
        'chtml_make_phone_call_string' => 'tel:',
        'chtml_display_accesskey' => false,
        'emoji' => false,
        
        // xhtml
        'xhtml_select_as_radiobutton' => true,
        'xhtml_avoid_accesskeys' => true,
        'xhtml_select_as_dropdown' => true,
        'xhtml_supports_iframe' => 'full',
        'xhtml_supports_forms_in_table' => true,
        'xhtmlmp_preferred_mime_type' => 'text/html',
        'xhtml_select_as_popup' => true,
        'xhtml_honors_bgcolor' => true,
        'xhtml_file_upload' => 'supported',
        'xhtml_preferred_charset' => 'utf8',
        'xhtml_supports_css_cell_table_coloring' => false,
        'xhtml_autoexpand_select' => false,
        'accept_third_party_cookie' => true,
        'xhtml_make_phone_call_string' => 'tel:',
        'xhtml_allows_disabled_form_elements' => false,
        'xhtml_supports_invisible_text' => false,
        'cookie_support' => true,
        'xhtml_send_mms_string' => 'none',
        'xhtml_table_support' => true,
        'xhtml_display_accesskey' => false,
        'xhtml_can_embed_video' => 'none',
        'xhtml_supports_monospace_font' => false,
        'xhtml_supports_inline_input' => false,
        'xhtml_document_title_support' => true,
        'xhtml_support_wml2_namespace' => false,
        'xhtml_readable_background_color1' => '#FFFFFF',
        'xhtml_format_as_attribute' => false,
        'xhtml_supports_table_for_layout' => false,
        'xhtml_readable_background_color2' => '#FFFFFF',
        'xhtml_send_sms_string' => 'none',
        'xhtml_format_as_css_property' => false,
        'opwv_xhtml_extensions_support' => false,
        'xhtml_marquee_as_css_property' => false,
        'xhtml_nowrap_mode' => false,
        
        // image format
        'jpg' => true,
        'gif' => true,
        'bmp' => true,
        'wbmp' => false,
        'gif_animated' => true,
        'png' => true,
        'greyscale' => false,
        'transparent_png_index' => false,
        'epoc_bmp' => false,
        'svgt_1_1_plus' => false,
        'svgt_1_1' => false,
        'transparent_png_alpha' => false,
        'tiff' => false,
        
        // security
        'https_support' => true,
        
        // storage
        'max_url_length_bookmark' => 0,
        'max_url_length_cached_page' => 0,
        'max_url_length_in_requests' => 128,
        'max_url_length_homepage' => 0,
        
        // ajax
        'ajax_support_getelementbyid' => true,
        'ajax_xhr_type' => 'standard',
        'ajax_support_event_listener' => true,
        'ajax_support_javascript' => true,
        'ajax_manipulate_dom' => true,
        'ajax_support_inner_html' => true,
        'ajax_manipulate_css' => true,
        'ajax_support_events' => true,
        'ajax_preferred_geoloc_api' => 'none',
        
        // wml
        'wml_make_phone_call_string' => 'none',
        'card_title_support' => false,
        'table_support' => false,
        'elective_forms_recommended' => false,
        'menu_with_list_of_links_recommended' => false,
        'break_list_of_links_with_br_element_recommended' => false,
        'icons_on_menu_items_support' => false,
        'opwv_wml_extensions_support' => false,
        'built_in_back_button_support' => false,
        'proportional_font' => false,
        'insert_br_element_after_widget_recommended' => false,
        'wizards_recommended' => false,
        'wml_can_display_images_and_text_on_same_line' => false,
        'softkey_support' => false,
        'deck_prefetch_support' => false,
        'menu_with_select_element_recommended' => false,
        'numbered_menus' => false,
        'image_as_link_support' => false,
        'wrap_mode_support' => false,
        'access_key_support' => false,
        'wml_displays_image_in_center' => false,
        'times_square_mode_support' => false,
        
        // third_party
        'jqm_grade' => 'A',
        'is_sencha_touch_ok' => true,
        
        // html
        'image_inlining' => true,
        'canvas_support' => 'none',
        'viewport_width' => null,
        'html_preferred_dtd' => 'html4',
        'viewport_supported' => false,
        'viewport_minimum_scale' => null,
        'viewport_initial_scale' => null,
        'mobileoptimized' => false,
        'viewport_maximum_scale' => null,
        'viewport_userscalable' => null,
        'handheldfriendly' => false,
        
        // css
        'css_spriting' => true,
        'css_gradient' => 'none',
        'css_gradient_linear' => 'none',
        'css_border_image' => 'none',
        'css_rounded_corners' => 'none',
        'css_supports_width_as_percentage' => true,
    );
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->_utils->checkIfContains(array('Gecko', 'Firefox'))) {
            return false;
        }
        
        if ($this->_utils->checkIfContains(array('KHTML', 'AppleWebKit', 'WebKit', 'Presto'))) {
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
        
        $searches = array('rv\:');
        
        $this->setCapability(
            'renderingengine_version', $detector->detectVersion($searches)
        );
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 5244;
    }
}