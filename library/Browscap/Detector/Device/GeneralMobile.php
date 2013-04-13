<?php
namespace Browscap\Detector\Device;

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
use \Browscap\Helper\MobileDevice;
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
final class GeneralMobile
    extends DeviceHandler
    implements MatcherInterface, DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $_properties = array(
        'wurflKey' => 'generic_mobile', // not in wurfl
        
        // kind of device
        'is_wireless_device' => true,
        'is_tablet'          => false,
        'is_bot'             => false,
        'is_smarttv'         => false,
        'is_console'         => false,
        'ux_full_desktop'    => false,
        'is_transcoder'      => false,
        
        // device
        'model_name'                => 'general Mobile Device',
        'model_version'             => null, // not in wurfl
        'manufacturer_name'         => 'unknown',
        'brand_name'                => 'unknown',
        'model_extra_info'          => null,
        'marketing_name'            => null,
        'has_qwerty_keyboard'       => null,
        'pointing_method'           => null,
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
        'physical_screen_width'  => 40,
        'physical_screen_height' => 60,
        'columns'                => 15,
        'rows'                   => 12,
        'max_image_width'        => 240,
        'max_image_height'       => 320,
        'resolution_width'       => 240,
        'resolution_height'      => 320,
        'dual_orientation'       => true,
        
        // security
        'phone_id_provided' => false,
        
        // storage
        'max_deck_size' => 1000000,
        'max_length_of_username' => 0,
        'max_no_of_bookmarks' => 0,
        'max_length_of_password' => 0,
        'max_no_of_connection_settings' => 0,
        'max_object_size' => 0,
        
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
        $mobileDeviceHelper = new MobileDevice();
        $mobileDeviceHelper->setUserAgent($this->_useragent);
        
        if ($mobileDeviceHelper->isMobileBrowser()) {
            return true;
        }
        
        return false;
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
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setNamespace(__NAMESPACE__ . '\\Mobile');
        $chain->setDirectory(
            __DIR__ . DIRECTORY_SEPARATOR . 'Mobile' . DIRECTORY_SEPARATOR
        );
        $chain->setDefaultHandler($this);
        
        return $chain->detect();
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
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectBrowser()
    {
        $browserPath = realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..' 
            . DIRECTORY_SEPARATOR . 'Browser'
            . DIRECTORY_SEPARATOR . 'Mobile'
            . DIRECTORY_SEPARATOR
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setNamespace('\\Browscap\\Detector\\Browser\\Mobile');
        $chain->setDirectory($browserPath);
        $chain->setDefaultHandler(new \Browscap\Detector\Browser\Unknown());
        
        return $chain->detect();
    }
    
    /**
     * detects properties who are depending on the device version or the user 
     * agent
     *
     * @return DeviceHandler
     */
    protected function _parseProperties()
    {
        if ($this->_utils->checkIfContains(array('Android; Tablet'))) {
            $this->setCapability('is_tablet', true);
            
            $this->setCapability('physical_screen_width', 112);
            $this->setCapability('physical_screen_height', 187);
            $this->setCapability('columns', 40);
            $this->setCapability('rows', 40);
            $this->setCapability('max_image_width', 320);
            $this->setCapability('max_image_height', 400);
            $this->setCapability('resolution_width', 480);
            $this->setCapability('resolution_height', 800);
            $this->setCapability('dual_orientation', true);
            $this->setCapability('can_assign_phone_number', false);
            
            $this->setCapability('wurflKey', null);
            
            return $this;
        }
        
        if ($this->_utils->checkIfContains(array('Opera Tablet'))) {
            $this->setCapability('is_tablet', true);
            
            $this->setCapability('physical_screen_width', 100);
            $this->setCapability('physical_screen_height', 200);
            $this->setCapability('columns', 60);
            $this->setCapability('rows', 40);
            $this->setCapability('max_image_width', 480);
            $this->setCapability('max_image_height', 640);
            $this->setCapability('resolution_width', 480);
            $this->setCapability('resolution_height', 640);
            $this->setCapability('dual_orientation', true);
            $this->setCapability('can_assign_phone_number', true);
            
            $this->setCapability('wurflKey', null);
            
            return $this;
        }
        
        if ($this->_utils->checkIfContains(array('XBLWP7', 'ZuneWP7'))) {
            $this->setCapability('is_tablet', false);
            
            $this->setCapability('physical_screen_width', 50);
            $this->setCapability('physical_screen_height', 84);
            $this->setCapability('columns', 12);
            $this->setCapability('rows', 20);
            $this->setCapability('max_image_width', 320);
            $this->setCapability('max_image_height', 480);
            $this->setCapability('resolution_width', 480);
            $this->setCapability('resolution_height', 800);
            $this->setCapability('dual_orientation', true);
            $this->setCapability('can_assign_phone_number', true);
            $this->setCapability('has_qwerty_keyboard', true);
            $this->setCapability('pointing_method', 'touchscreen');
            $this->setCapability('sms_enabled', true);
            $this->setCapability('nfc_support', true);
            
            $this->setCapability('wurflKey', 'generic_ms_phone_os7_5_desktopmode');
            
            return $this;
        }
        
        if ($this->_utils->checkIfContains(array('Opera Mobi'))) {
            $this->setCapability('is_tablet', false);
            
            $this->setCapability('physical_screen_width', 34);
            $this->setCapability('physical_screen_height', 50);
            $this->setCapability('columns', 60);
            $this->setCapability('rows', 40);
            $this->setCapability('max_image_width', 320);
            $this->setCapability('max_image_height', 400);
            $this->setCapability('resolution_width', 320);
            $this->setCapability('resolution_height', 480);
            $this->setCapability('dual_orientation', true);
            $this->setCapability('can_assign_phone_number', true);
            
            $this->setCapability('wurflKey', null);
            
            return $this;
        }
        
        return $this;
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
        parent::detectDependProperties($browser, $engine, $os);
        
        $engine->setCapability('bmp', false);
        $engine->setCapability('wbmp', false);
        $engine->setCapability('tiff', false);
        
        if ('Firefox' == $browser->getCapability('mobile_browser')
            && 'Android' == $os->getCapability('device_os')
        ) {
            $os->getCapability('device_os_version')->setVersion('2.0');
            
            if ($this->getCapability('is_tablet')) {
                $this->setCapability('wurflKey', 'generic_android_ver2_0_fennec_tablet');
            } else {
                $this->setCapability('wurflKey', 'generic_android_ver2_0_fennec');
                
                $engine->setCapability('wbmp', true);
            }
        }
        
        return $this;
    }
}