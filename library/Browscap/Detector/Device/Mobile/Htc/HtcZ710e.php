<?php
namespace Browscap\Detector\Device\Mobile\Htc;

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

use \Browscap\Detector\DeviceHandler;
use \Browscap\Helper\Utils;
use \Browscap\Detector\MatcherInterface;
use \Browscap\Detector\MatcherInterface\DeviceInterface;
use \Browscap\Detector\BrowserHandler;
use \Browscap\Detector\EngineHandler;
use \Browscap\Detector\OsHandler;

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
final class HtcZ710e
    extends DeviceHandler
    implements MatcherInterface, DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $_properties = array(
        'wurflKey' => null, // not in wurfl
        
        // kind of device
        'is_wireless_device' => true,
        'is_tablet'          => false,
        // 'is_bot'             => false,
        'is_smarttv'         => false,
        'is_console'         => false,
        'ux_full_desktop'    => false,
        // 'is_transcoder'      => false,
        
        // device
        'model_name'                => 'Z710e',
        'model_version'             => null, // not in wurfl
        'manufacturer_name'         => 'HTC',
        'brand_name'                => 'HTC',
        'model_extra_info'          => null,
        'marketing_name'            => null,
        'has_qwerty_keyboard'       => true,
        'pointing_method'           => 'touchscreen',
        'device_bits'               => null, // not in wurfl
        'device_cpu'                => null, // not in wurfl
        
        // product info
        'can_skip_aligned_link_row' => null,
        'can_assign_phone_number'   => true,
        'nokia_feature_pack'        => 0,
        'nokia_series'              => 0,
        'nokia_edition'             => 0,
        'ununiqueness_handler'      => null,
        'uaprof'                    => null,
        'uaprof2'                   => null,
        'uaprof3'                   => null,
        'unique'                    => true,
        
        // display
        'physical_screen_width'  => 34,
        'physical_screen_height' => 50,
        'columns'                => 25,
        'rows'                   => 21,
        'max_image_width'        => 360,
        'max_image_height'       => 640,
        'resolution_width'       => 540,
        'resolution_height'      => 960,
        'dual_orientation'       => true,
        
        // security
        'phone_id_provided' => null,
        
        // storage
        'max_deck_size' => null,
        'max_length_of_username' => null,
        'max_no_of_bookmarks' => null,
        'max_length_of_password' => null,
        'max_no_of_connection_settings' => null,
        'max_object_size' => null,
        
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
        
        // flash_lite
        'full_flash_support' => null,
        'flash_lite_version' => null,
        'fl_wallpaper' => null,
        'fl_browser' => null,
        'fl_screensaver' => null,
        'fl_standalone' => null,
        'fl_sub_lcd' => null,
        
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
     * Final Interceptor: Intercept
     * Everything that has not been trapped by a previous handler
     *
     * @param string $this->_useragent
     * @return boolean always true
     */
    public function canHandle()
    {
        if (!$this->_utils->checkIfContains(array('HTC_Sensation_Z710e', 'HTC Sensation Z710e', 'Sensation_Z710e'))) {
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
        return 3;
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @param string $userAgent
     *
     * @return Stdfinal class
     */
    public function detectDevice()
    {
        return $this;
    }
    
    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectBrowser()
    {
        $browsers = array(
            new \Browscap\Detector\Browser\Mobile\Android(),
            new \Browscap\Detector\Browser\Mobile\Chrome(),
            new \Browscap\Detector\Browser\Mobile\Dalvik()
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new \Browscap\Detector\Browser\Unknown());
        
        return $chain->detect();
    }
    
    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectOs()
    {
        $os = array(
            new \Browscap\Detector\Os\Android(),
            //new \Browscap\Detector\Os\FreeBsd()
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setDefaultHandler(new \Browscap\Detector\Os\Unknown());
        $chain->setUseragent($this->_useragent);
        $chain->setHandlers($os);
        
        return $chain->detect();
    }
}