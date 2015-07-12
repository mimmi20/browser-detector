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

namespace BrowserDetector\Detector\Engine;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface\EngineInterface;

/**
 * MSIEAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Tasman
    extends AbstractEngine
    implements EngineInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        // markup
        'utf8_support'                                    => null,
        'multipart_support'                               => null,
        'supports_background_sounds'                      => false, // not in wurfl
        'supports_vb_script'                              => false, // not in wurfl
        'supports_java_applets'                           => true, // not in wurfl
        'supports_activex_controls'                       => false, // not in wurfl
        'preferred_markup'                                => null,
        'html_web_3_2'                                    => null,
        'html_web_4_0'                                    => null,
        'html_wi_oma_xhtmlmp_1_0'                         => null,
        'wml_1_1'                                         => null,
        'wml_1_2'                                         => null,
        'wml_1_3'                                         => null,
        'xhtml_support_level'                             => null,
        'html_wi_imode_html_1'                            => null,
        'html_wi_imode_html_2'                            => null,
        'html_wi_imode_html_3'                            => null,
        'html_wi_imode_html_4'                            => null,
        'html_wi_imode_html_5'                            => null,
        'html_wi_imode_htmlx_1'                           => null,
        'html_wi_imode_htmlx_1_1'                         => null,
        'html_wi_w3_xhtmlbasic'                           => null,
        'html_wi_imode_compact_generic'                   => null,
        'voicexml'                                        => null,
        // chtml
        'chtml_table_support'                             => null,
        'imode_region'                                    => null,
        'chtml_can_display_images_and_text_on_same_line'  => null,
        'chtml_displays_image_in_center'                  => null,
        'chtml_make_phone_call_string'                    => null,
        'chtml_display_accesskey'                         => null,
        'emoji'                                           => null,
        // xhtml
        'xhtml_select_as_radiobutton'                     => null,
        'xhtml_avoid_accesskeys'                          => null,
        'xhtml_select_as_dropdown'                        => null,
        'xhtml_supports_iframe'                           => null,
        'xhtml_supports_forms_in_table'                   => null,
        'xhtmlmp_preferred_mime_type'                     => null,
        'xhtml_select_as_popup'                           => null,
        'xhtml_honors_bgcolor'                            => null,
        'xhtml_file_upload'                               => null,
        'xhtml_preferred_charset'                         => null,
        'xhtml_supports_css_cell_table_coloring'          => null,
        'xhtml_autoexpand_select'                         => null,
        'accept_third_party_cookie'                       => null,
        'xhtml_make_phone_call_string'                    => null,
        'xhtml_allows_disabled_form_elements'             => null,
        'xhtml_supports_invisible_text'                   => null,
        'cookie_support'                                  => null,
        'xhtml_send_mms_string'                           => null,
        'xhtml_table_support'                             => null,
        'xhtml_display_accesskey'                         => null,
        'xhtml_can_embed_video'                           => null,
        'xhtml_supports_monospace_font'                   => null,
        'xhtml_supports_inline_input'                     => null,
        'xhtml_document_title_support'                    => null,
        'xhtml_support_wml2_namespace'                    => null,
        'xhtml_readable_background_color1'                => null,
        'xhtml_format_as_attribute'                       => null,
        'xhtml_supports_table_for_layout'                 => null,
        'xhtml_readable_background_color2'                => null,
        'xhtml_send_sms_string'                           => null,
        'xhtml_format_as_css_property'                    => null,
        'opwv_xhtml_extensions_support'                   => null,
        'xhtml_marquee_as_css_property'                   => null,
        'xhtml_nowrap_mode'                               => null,
        // image format
        'jpg'                                             => null,
        'gif'                                             => null,
        'bmp'                                             => null,
        'wbmp'                                            => null,
        'gif_animated'                                    => null,
        'png'                                             => null,
        'greyscale'                                       => null,
        'transparent_png_index'                           => null,
        'epoc_bmp'                                        => null,
        'svgt_1_1_plus'                                   => null,
        'svgt_1_1'                                        => null,
        'transparent_png_alpha'                           => null,
        'tiff'                                            => null,
        // security
        'https_support'                                   => null,
        // storage
        'max_url_length_bookmark'                         => null,
        'max_url_length_cached_page'                      => null,
        'max_url_length_in_requests'                      => null,
        'max_url_length_homepage'                         => null,
        // ajax
        'ajax_support_getelementbyid'                     => null,
        'ajax_xhr_type'                                   => null,
        'ajax_support_event_listener'                     => null,
        'ajax_support_javascript'                         => null,
        'ajax_manipulate_dom'                             => null,
        'ajax_support_inner_html'                         => null,
        'ajax_manipulate_css'                             => null,
        'ajax_support_events'                             => null,
        'ajax_preferred_geoloc_api'                       => null,
        // wml
        'wml_make_phone_call_string'                      => null,
        'card_title_support'                              => null,
        'table_support'                                   => null,
        'elective_forms_recommended'                      => null,
        'menu_with_list_of_links_recommended'             => null,
        'break_list_of_links_with_br_element_recommended' => null,
        'icons_on_menu_items_support'                     => null,
        'opwv_wml_extensions_support'                     => null,
        'built_in_back_button_support'                    => null,
        'proportional_font'                               => null,
        'insert_br_element_after_widget_recommended'      => null,
        'wizards_recommended'                             => null,
        'wml_can_display_images_and_text_on_same_line'    => null,
        'softkey_support'                                 => null,
        'deck_prefetch_support'                           => null,
        'menu_with_select_element_recommended'            => null,
        'numbered_menus'                                  => null,
        'image_as_link_support'                           => null,
        'wrap_mode_support'                               => null,
        'access_key_support'                              => null,
        'wml_displays_image_in_center'                    => null,
        'times_square_mode_support'                       => null,
        // third_party
        'jqm_grade'                                       => null,
        'is_sencha_touch_ok'                              => null,
        // html
        'image_inlining'                                  => null,
        'canvas_support'                                  => null,
        'viewport_width'                                  => null,
        'html_preferred_dtd'                              => null,
        'viewport_supported'                              => null,
        'viewport_minimum_scale'                          => null,
        'viewport_initial_scale'                          => null,
        'mobileoptimized'                                 => null,
        'viewport_maximum_scale'                          => null,
        'viewport_userscalable'                           => null,
        'handheldfriendly'                                => null,
        // css
        'css_spriting'                                    => null,
        'css_gradient'                                    => null,
        'css_gradient_linear'                             => null,
        'css_border_image'                                => null,
        'css_rounded_corners'                             => null,
        'css_supports_width_as_percentage'                => null,
    );

    /**
     * gets the name of the platform
     *
     * @return string
     */
    public function getName()
    {
        return 'Tasman';
    }

    /**
     * gets the maker of the platform
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Apple();
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 93;
    }
}
