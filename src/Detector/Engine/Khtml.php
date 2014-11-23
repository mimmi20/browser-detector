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

namespace BrowserDetector\Detector\Engine;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface\EngineInterface;
use BrowserDetector\Detector\Version;

/**
 * MSIEAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Khtml
    extends EngineHandler
    implements EngineInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        // markup
        'utf8_support'                                    => false,
        'multipart_support'                               => false,
        'supports_background_sounds'                      => false, // not in wurfl
        'supports_vb_script'                              => false, // not in wurfl
        'supports_java_applets'                           => true, // not in wurfl
        'supports_activex_controls'                       => false, // not in wurfl
        'preferred_markup'                                => 'html_web_4_0',
        'html_web_3_2'                                    => true,
        'html_web_4_0'                                    => true,
        'html_wi_oma_xhtmlmp_1_0'                         => null,
        'wml_1_1'                                         => null,
        'wml_1_2'                                         => null,
        'wml_1_3'                                         => null,
        'xhtml_support_level'                             => 4,
        'html_wi_imode_html_1'                            => null,
        'html_wi_imode_html_2'                            => null,
        'html_wi_imode_html_3'                            => null,
        'html_wi_imode_html_4'                            => null,
        'html_wi_imode_html_5'                            => null,
        'html_wi_imode_htmlx_1'                           => null,
        'html_wi_imode_htmlx_1_1'                         => null,
        'html_wi_w3_xhtmlbasic'                           => true,
        'html_wi_imode_compact_generic'                   => null,
        'voicexml'                                        => null,

        // chtml
        'chtml_table_support'                             => true,
        'imode_region'                                    => 'none',
        'chtml_can_display_images_and_text_on_same_line'  => null,
        'chtml_displays_image_in_center'                  => null,
        'chtml_make_phone_call_string'                    => 'tel:',
        'chtml_display_accesskey'                         => null,
        'emoji'                                           => null,

        // xhtml
        'xhtml_select_as_radiobutton'                     => true,
        'xhtml_avoid_accesskeys'                          => true,
        'xhtml_select_as_dropdown'                        => true,
        'xhtml_supports_iframe'                           => 'full',
        'xhtml_supports_forms_in_table'                   => true,
        'xhtmlmp_preferred_mime_type'                     => 'text/html',
        'xhtml_select_as_popup'                           => true,
        'xhtml_honors_bgcolor'                            => true,
        'xhtml_file_upload'                               => 'supported',
        'xhtml_preferred_charset'                         => 'utf8',
        'xhtml_supports_css_cell_table_coloring'          => false,
        'xhtml_autoexpand_select'                         => false,
        'accept_third_party_cookie'                       => true,
        'xhtml_make_phone_call_string'                    => 'tel:',
        'xhtml_allows_disabled_form_elements'             => false,
        'xhtml_supports_invisible_text'                   => false,
        'cookie_support'                                  => true,
        'xhtml_send_mms_string'                           => 'none',
        'xhtml_table_support'                             => true,
        'xhtml_display_accesskey'                         => false,
        'xhtml_can_embed_video'                           => 'none',
        'xhtml_supports_monospace_font'                   => false,
        'xhtml_supports_inline_input'                     => false,
        'xhtml_document_title_support'                    => true,
        'xhtml_support_wml2_namespace'                    => null,
        'xhtml_readable_background_color1'                => '#FFFFFF',
        'xhtml_format_as_attribute'                       => null,
        'xhtml_supports_table_for_layout'                 => false,
        'xhtml_readable_background_color2'                => '#FFFFFF',
        'xhtml_send_sms_string'                           => 'none',
        'xhtml_format_as_css_property'                    => null,
        'opwv_xhtml_extensions_support'                   => null,
        'xhtml_marquee_as_css_property'                   => null,
        'xhtml_nowrap_mode'                               => null,

        // image format
        'jpg'                                             => true,
        'gif'                                             => true,
        'bmp'                                             => true,
        'wbmp'                                            => false,
        'gif_animated'                                    => true,
        'png'                                             => true,
        'greyscale'                                       => false,
        'transparent_png_index'                           => false,
        'epoc_bmp'                                        => false,
        'svgt_1_1_plus'                                   => false,
        'svgt_1_1'                                        => false,
        'transparent_png_alpha'                           => false,
        'tiff'                                            => false,

        // security
        'https_support'                                   => true,

        // storage
        'max_url_length_bookmark'                         => null,
        'max_url_length_cached_page'                      => null,
        'max_url_length_in_requests'                      => 128,
        'max_url_length_homepage'                         => null,

        // ajax
        'ajax_support_getelementbyid'                     => true,
        'ajax_xhr_type'                                   => 'standard',
        'ajax_support_event_listener'                     => true,
        'ajax_support_javascript'                         => true,
        'ajax_manipulate_dom'                             => true,
        'ajax_support_inner_html'                         => true,
        'ajax_manipulate_css'                             => true,
        'ajax_support_events'                             => true,
        'ajax_preferred_geoloc_api'                       => 'none',

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
        'jqm_grade'                                       => 'A',
        'is_sencha_touch_ok'                              => true,

        // html
        'image_inlining'                                  => null,
        'canvas_support'                                  => 'none',
        'viewport_width'                                  => null,
        'html_preferred_dtd'                              => 'html4',
        'viewport_supported'                              => null,
        'viewport_minimum_scale'                          => null,
        'viewport_initial_scale'                          => null,
        'mobileoptimized'                                 => false,
        'viewport_maximum_scale'                          => null,
        'viewport_userscalable'                           => null,
        'handheldfriendly'                                => false,

        // css
        'css_spriting'                                    => false,
        'css_gradient'                                    => 'none',
        'css_gradient_linear'                             => 'none',
        'css_border_image'                                => 'none',
        'css_rounded_corners'                             => 'none',
        'css_supports_width_as_percentage'                => true,
    );

    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContainsAll(array('KHTML', 'Konqueror'))) {
            return false;
        }

        if ($this->utils->checkIfContains(array('Trident', 'Presto', 'AppleWebKit', 'WebKit', 'CFNetwork'))) {
            return false;
        }

        return true;
    }

    /**
     * gets the name of the platform
     *
     * @return string
     */
    public function getName()
    {
        return 'KHTML';
    }

    /**
     * gets the maker of the platform
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Unknown();
    }

    /**
     * detects the engine version from the given user agent
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->_useragent);

        $searches = array('KHTML');

        return $detector->detectVersion($searches);
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 36711;
    }
}
