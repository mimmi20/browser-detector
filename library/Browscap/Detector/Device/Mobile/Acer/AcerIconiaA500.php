<?php
namespace Browscap\Detector\Device\Mobile\Acer;

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
final class AcerIconiaA500
    extends DeviceHandler
    implements MatcherInterface, DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $_properties = array(
        'wurflKey' => 'acer_iconia_tab_a500_ver1', // not in wurfl
        
        // kind of device
        'is_wireless_device' => true,
        'is_tablet'          => true, // wurflkey: acer_iconia_tab_a500_ver1_suban40
        // 'is_bot'             => false,
        'is_smarttv'         => false,
        'is_console'         => false,
        'ux_full_desktop'    => false,
        // 'is_transcoder'      => false,
        
        // device
        'model_name'                => 'A500',
        'model_version'             => null, // not in wurfl
        'manufacturer_name'         => 'Acer',
        'brand_name'                => 'Acer',
        'model_extra_info'          => null,
        'marketing_name'            => 'Picasso', // wurflkey: acer_iconia_tab_a500_ver1_suban40
        'has_qwerty_keyboard'       => true,
        'pointing_method'           => 'touchscreen',
        'device_bits'               => null, // not in wurfl
        'device_cpu'                => 'NVIDIA', // not in wurfl
        
        // product info
        'can_skip_aligned_link_row' => null,
        'can_assign_phone_number'   => false,
        'nokia_feature_pack'        => 0,
        'nokia_series'              => 0,
        'nokia_edition'             => 0,
        'ununiqueness_handler'      => null,
        'uaprof'                    => 'http://support.acer.com/UAprofile/Acer_A500_IML74K_Profile.xml',
        'uaprof2'                   => null,
        'uaprof3'                   => null,
        'unique'                    => true,
        
        // display
        'physical_screen_width'  => 217,
        'physical_screen_height' => 136,
        'columns'                => 80,
        'rows'                   => 25,
        'max_image_width'        => 980,
        'max_image_height'       => 472,
        'resolution_width'       => 1280,
        'resolution_height'      => 800,
        'dual_orientation'       => true,
        
        // sms
        'sms_enabled' => false,
        
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
        'nfc_support' => false,
    );
    
    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->_utils->checkIfContains(array('Iconia A500', 'A500'))) {
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
        $handler = new \Browscap\Detector\Os\Android();
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
        BrowserHandler $browser, EngineHandler $engine, OsHandler $os)
    {
        $osVersion = $os->getCapability('device_os_version')->getVersion(
            Version::MAJORONLY
        );
        
        if (3 == $osVersion) {
            // $this->setCapability('resolution_width', 640);
            $this->setCapability('resolution_height', 768);
            $this->setCapability('uaprof', 'http://support.acer.com/UAprofile/Acer_A500_Profile.xml');
        }
        
        parent::detectDependProperties($browser, $engine, $os);
        
        if (4 == $osVersion) {
            $engine->setCapability('bmp', true);
            $engine->setCapability('colors', 16777216);
        }
        
        $osVersion = $os->getCapability('device_os_version')->getVersion(
            Version::MAJORMINOR
        );
        
        if ('Android' == $browser->getCapability('mobile_browser')) {
            if (3.2 == (float) $osVersion) {
                $this->setCapability('wurflKey', 'acer_iconia_tab_a500_ver1_suban32');
            }
            
            if (4.0 == (float) $osVersion) {
                $this->setCapability('wurflKey', 'acer_iconia_tab_a500_ver1_suban40');
            }
            
            if (4.1 == (float) $osVersion) {
                $this->setCapability('wurflKey', 'acer_iconia_tab_a500_ver1_suban41');
            }
        }
        
        if ('Chrome' == $browser->getCapability('mobile_browser')) {
            if (4.0 == (float) $osVersion) {
                // $this->setCapability('wurflKey', 'acer_iconia_tab_a700_ver1_subuachrome');
            }
            
            if (4.1 == (float) $osVersion) {
                // $this->setCapability('wurflKey', 'samsung_gt_i9300_ver1_suban41_subuachrome');
            }
        }
        
        return $this;
    }
}