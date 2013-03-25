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
class PalmPixi
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
        // 'is_wireless_device' => null,
        // 'is_tablet'          => null,
        'is_bot'             => false,
        // 'is_smarttv'         => null,
        // 'is_console'         => null,
        // 'ux_full_desktop'    => null,
        'is_transcoder'      => false,
        
        // device
        // 'model_name'                => null,
        // 'manufacturer_name'         => null,
        // 'brand_name'                => null,
        // 'model_extra_info'          => null,
        // 'marketing_name'            => null,
        // 'has_qwerty_keyboard'       => null,
        // 'pointing_method'           => null,
        'device_claims_web_support' => false,
        
        // browser
        'mobile_browser'              => 'PalmPixi',
        'mobile_browser_version'      => null,
        'mobile_browser_bits'         => null, // not in wurfl
        'mobile_browser_manufacturer' => 'HP', // not in wurfl
        'mobile_browser_modus'        => null, // not in wurfl
        
        // os
        // 'device_os'              => null,
        // 'device_os_version'      => null,
        // 'device_os_bits'         => null, // not in wurfl
        // 'device_os_manufacturer' => null, // not in wurfl
        
        // engine
        // 'renderingengine_name'         => null, // not in wurfl
        // 'renderingengine_version'      => null, // not in wurfl
        // 'renderingengine_manufacturer' => null, // not in wurfl
        
        // product info
        'can_skip_aligned_link_row' => true,
        'can_assign_phone_number'   => false,
        
        // markup
        'html_web_3_2' => null,
        'html_wi_oma_xhtmlmp_1_0' => null,
        'wml_1_1' => null,
        'xhtml_support_level' => null,
        'preferred_markup' => null,
        'html_web_4_0' => null,
        'html_wi_imode_htmlx_1' => null,
        'html_wi_imode_html_1' => null,
        'html_wi_imode_html_2' => null,
        'html_wi_w3_xhtmlbasic' => null,
        'html_wi_imode_compact_generic' => null,
        'html_wi_imode_html_3' => null,
        'html_wi_imode_html_4' => null,
        'wml_1_2' => null,
        'html_wi_imode_html_5' => null,
        'wml_1_3' => null,
        'voicexml' => null,
        'html_wi_imode_htmlx_1_1' => null,
        'multipart_support' => null,
        
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
        'phone_id_provided' => null,
        
        // storage
        'max_deck_size' => null,
        'max_length_of_username' => null,
        'max_url_length_bookmark' => null,
        'max_no_of_bookmarks' => null,
        'max_url_length_cached_page' => null,
        'max_length_of_password' => null,
        'max_no_of_connection_settings' => null,
        'max_url_length_in_requests' => null,
        'max_object_size' => null,
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
        
        // sms
        'sms_enabled' => null,
        'ems' => null,
        'text_imelody' => null,
        'nokiaring' => null,
        'siemens_logo_height' => null,
        'ems_variablesizedpictures' => null,
        'sckl_groupgraphic' => null,
        'siemens_ota' => null,
        'sagem_v1' => null,
        'largeoperatorlogo' => null,
        'sagem_v2' => null,
        'ems_version' => null,
        'ems_odi' => null,
        'nokiavcal' => null,
        'operatorlogo' => null,
        'siemens_logo_width' => null,
        'ems_imelody' => null,
        'sckl_vcard' => null,
        'siemens_screensaver_width' => null,
        'sckl_operatorlogo' => null,
        'panasonic' => null,
        'ems_upi' => null,
        'nokiavcard' => null,
        'callericon' => null,
        'gprtf' => null,
        'siemens_screensaver_height' => null,
        'sckl_ringtone' => null,
        'picturemessage' => null,
        'sckl_vcalendar' => null,
        
        // bearer
        'has_cellular_radio' => null,
        'sdio' => null,
        'wifi' => null,
        'max_data_rate' => null,
        'vpn' => null,
        
        // pdf
        'pdf_support' => null,
        
        // flash_lite
        'full_flash_support' => null,
        'flash_lite_version' => null,
        'fl_wallpaper' => null,
        'fl_browser' => null,
        'fl_screensaver' => null,
        'fl_standalone' => null,
        'fl_sub_lcd' => null,
        
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
        
        // wta
        'nokia_voice_call' => null,
        'wta_pdc' => null,
        'wta_voice_call' => null,
        'wta_misc' => null,
        'wta_phonebook' => null,
        
        // object download
        'video' => null,
        'picture_bmp' => null,
        'picture' => null,
        'wallpaper_df_size_limit' => null,
        'picture_preferred_width' => null,
        'wallpaper_oma_size_limit' => null,
        'picture_greyscale' => null,
        'inline_support' => null,
        'ringtone_qcelp' => null,
        'screensaver_oma_size_limit' => null,
        'screensaver_wbmp' => null,
        'picture_resize' => null,
        'picture_preferred_height' => null,
        'ringtone_rmf' => null,
        'wallpaper_wbmp' => null,
        'wallpaper_jpg' => null,
        'screensaver_bmp' => null,
        'screensaver_max_width' => null,
        'picture_inline_size_limit' => null,
        'picture_colors' => null,
        'ringtone_midi_polyphonic' => null,
        'ringtone_midi_monophonic' => null,
        'screensaver_preferred_height' => null,
        'ringtone_voices' => null,
        'ringtone_3gpp' => null,
        'oma_support' => null,
        'ringtone_inline_size_limit' => null,
        'wallpaper_preferred_width' => null,
        'wallpaper_greyscale' => null,
        'screensaver_preferred_width' => null,
        'wallpaper_preferred_height' => null,
        'picture_max_width' => null,
        'picture_jpg' => null,
        'ringtone_aac' => null,
        'ringtone_oma_size_limit' => null,
        'wallpaper_directdownload_size_limit' => null,
        'screensaver_inline_size_limit' => null,
        'ringtone_xmf' => null,
        'picture_max_height' => null,
        'screensaver_max_height' => null,
        'ringtone_mp3' => null,
        'wallpaper_png' => null,
        'screensaver_jpg' => null,
        'ringtone_directdownload_size_limit' => null,
        'wallpaper_max_width' => null,
        'wallpaper_max_height' => null,
        'screensaver' => null,
        'ringtone_wav' => null,
        'wallpaper_gif' => null,
        'screensaver_directdownload_size_limit' => null,
        'picture_df_size_limit' => null,
        'wallpaper_tiff' => null,
        'screensaver_df_size_limit' => null,
        'ringtone_awb' => null,
        'ringtone' => null,
        'wallpaper_inline_size_limit' => null,
        'picture_directdownload_size_limit' => null,
        'picture_png' => null,
        'wallpaper_bmp' => null,
        'picture_wbmp' => null,
        'ringtone_df_size_limit' => null,
        'picture_oma_size_limit' => null,
        'picture_gif' => null,
        'screensaver_png' => null,
        'wallpaper_resize' => null,
        'screensaver_greyscale' => null,
        'ringtone_mmf' => null,
        'ringtone_amr' => null,
        'wallpaper' => null,
        'ringtone_digiplug' => null,
        'ringtone_spmidi' => null,
        'ringtone_compactmidi' => null,
        'ringtone_imelody' => null,
        'screensaver_resize' => null,
        'wallpaper_colors' => null,
        'directdownload_support' => null,
        'downloadfun_support' => null,
        'screensaver_colors' => null,
        'screensaver_gif' => null,
        
        // drm
        'oma_v_1_0_combined_delivery' => null,
        'oma_v_1_0_separate_delivery' => null,
        'oma_v_1_0_forwardlock' => null,
        
        // streaming
        'streaming_vcodec_mpeg4_asp' => null,
        'streaming_video_size_limit' => null,
        'streaming_mov' => null,
        'streaming_wmv' => null,
        'streaming_acodec_aac' => null,
        'streaming_vcodec_h263_0' => null,
        'streaming_real_media' => null,
        'streaming_3g2' => null,
        'streaming_3gpp' => null,
        'streaming_acodec_amr' => null,
        'streaming_vcodec_h264_bp' => null,
        'streaming_vcodec_h263_3' => null,
        'streaming_preferred_protocol' => null,
        'streaming_vcodec_mpeg4_sp' => null,
        'streaming_flv' => null,
        'streaming_video' => null,
        'streaming_preferred_http_protocol' => null,
        'streaming_mp4' => null,
        
        // wap push
        'expiration_date' => null,
        'utf8_support' => null,
        'connectionless_cache_operation' => null,
        'connectionless_service_load' => null,
        'iso8859_support' => null,
        'connectionoriented_confirmed_service_indication' => null,
        'connectionless_service_indication' => null,
        'ascii_support' => null,
        'connectionoriented_confirmed_cache_operation' => null,
        'connectionoriented_confirmed_service_load' => null,
        'wap_push_support' => null,
        'connectionoriented_unconfirmed_cache_operation' => null,
        'connectionoriented_unconfirmed_service_load' => null,
        'connectionoriented_unconfirmed_service_indication' => null,
        
        // j2me
        'doja_1_5' => null,
        'j2me_datefield_broken' => null,
        'j2me_clear_key_code' => null,
        'j2me_right_softkey_code' => null,
        'j2me_heap_size' => null,
        'j2me_canvas_width' => null,
        'j2me_motorola_lwt' => null,
        'doja_3_5' => null,
        'j2me_wbmp' => null,
        'j2me_rmf' => null,
        'j2me_wma' => null,
        'j2me_left_softkey_code' => null,
        'j2me_jtwi' => null,
        'j2me_jpg' => null,
        'j2me_return_key_code' => null,
        'j2me_real8' => null,
        'j2me_max_record_store_size' => null,
        'j2me_realmedia' => null,
        'j2me_midp_1_0' => null,
        'j2me_bmp3' => null,
        'j2me_midi' => null,
        'j2me_btapi' => null,
        'j2me_locapi' => null,
        'j2me_siemens_extension' => null,
        'j2me_h263' => null,
        'j2me_audio_capture_enabled' => null,
        'j2me_midp_2_0' => null,
        'j2me_datefield_no_accepts_null_date' => null,
        'j2me_aac' => null,
        'j2me_capture_image_formats' => null,
        'j2me_select_key_code' => null,
        'j2me_xmf' => null,
        'j2me_photo_capture_enabled' => null,
        'j2me_realaudio' => null,
        'j2me_realvideo' => null,
        'j2me_mp3' => null,
        'j2me_png' => null,
        'j2me_au' => null,
        'j2me_screen_width' => null,
        'j2me_mp4' => null,
        'j2me_mmapi_1_0' => null,
        'j2me_http' => null,
        'j2me_imelody' => null,
        'j2me_socket' => null,
        'j2me_3dapi' => null,
        'j2me_bits_per_pixel' => null,
        'j2me_mmapi_1_1' => null,
        'j2me_udp' => null,
        'j2me_wav' => null,
        'j2me_middle_softkey_code' => null,
        'j2me_svgt' => null,
        'j2me_gif' => null,
        'j2me_siemens_color_game' => null,
        'j2me_max_jar_size' => null,
        'j2me_wmapi_1_0' => null,
        'j2me_nokia_ui' => null,
        'j2me_screen_height' => null,
        'j2me_wmapi_1_1' => null,
        'j2me_wmapi_2_0' => null,
        'doja_1_0' => null,
        'j2me_serial' => null,
        'doja_2_0' => null,
        'j2me_bmp' => null,
        'j2me_amr' => null,
        'j2me_gif89a' => null,
        'j2me_cldc_1_0' => null,
        'doja_2_1' => null,
        'doja_3_0' => null,
        'j2me_cldc_1_1' => null,
        'doja_2_2' => null,
        'doja_4_0' => null,
        'j2me_3gpp' => null,
        'j2me_video_capture_enabled' => null,
        'j2me_canvas_height' => null,
        'j2me_https' => null,
        'j2me_mpeg4' => null,
        'j2me_storage_size' => null,
        
        // mms
        'mms_3gpp' => null,
        'mms_wbxml' => null,
        'mms_symbian_install' => null,
        'mms_png' => null,
        'mms_max_size' => null,
        'mms_rmf' => null,
        'mms_nokia_operatorlogo' => null,
        'mms_max_width' => null,
        'mms_max_frame_rate' => null,
        'mms_wml' => null,
        'mms_evrc' => null,
        'mms_spmidi' => null,
        'mms_gif_static' => null,
        'mms_max_height' => null,
        'sender' => null,
        'mms_video' => null,
        'mms_vcard' => null,
        'mms_nokia_3dscreensaver' => null,
        'mms_qcelp' => null,
        'mms_midi_polyphonic' => null,
        'mms_wav' => null,
        'mms_jpeg_progressive' => null,
        'mms_jad' => null,
        'mms_nokia_ringingtone' => null,
        'built_in_recorder' => null,
        'mms_midi_monophonic' => null,
        'mms_3gpp2' => null,
        'mms_wmlc' => null,
        'mms_nokia_wallpaper' => null,
        'mms_bmp' => null,
        'mms_vcalendar' => null,
        'mms_jar' => null,
        'mms_ota_bitmap' => null,
        'mms_mp3' => null,
        'mms_mmf' => null,
        'mms_amr' => null,
        'mms_wbmp' => null,
        'built_in_camera' => null,
        'receiver' => null,
        'mms_mp4' => null,
        'mms_xmf' => null,
        'mms_jpeg_baseline' => null,
        'mms_midi_polyphonic_voices' => null,
        'mms_gif_animated' => null,
        
        // sound format
        'rmf' => null,
        'qcelp' => null,
        'awb' => null,
        'smf' => null,
        'wav' => null,
        'nokia_ringtone' => null,
        'aac' => null,
        'digiplug' => null,
        'sp_midi' => null,
        'compactmidi' => null,
        'voices' => null,
        'mp3' => null,
        'mld' => null,
        'evrc' => null,
        'amr' => null,
        'xmf' => null,
        'mmf' => null,
        'imelody' => null,
        'midi_monophonic' => null,
        'au' => null,
        'midi_polyphonic' => null,
        
        // transcoding
        'transcoder_ua_header' => null,
        
        // rss
        'rss_support' => null,
        
        // playback
        'playback_oma_size_limit' => null,
        'playback_acodec_aac' => null,
        'playback_vcodec_h263_3' => null,
        'playback_vcodec_mpeg4_asp' => null,
        'playback_mp4' => null,
        'playback_3gpp' => null,
        'playback_df_size_limit' => null,
        'playback_acodec_amr' => null,
        'playback_mov' => null,
        'playback_wmv' => null,
        'playback_acodec_qcelp' => null,
        'progressive_download' => null,
        'playback_directdownload_size_limit' => null,
        'playback_real_media' => null,
        'playback_3g2' => null,
        'playback_vcodec_mpeg4_sp' => null,
        'playback_vcodec_h263_0' => null,
        'playback_inline_size_limit' => null,
        'hinted_progressive_download' => null,
        'playback_vcodec_h264_bp' => null,
        
        // chips
        'nfc_support' => null,
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
        
        if (!$this->_utils->checkIfContains(array('PalmPixi/'))) {
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
        
        $searches = array('PalmPixi');
        
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
}