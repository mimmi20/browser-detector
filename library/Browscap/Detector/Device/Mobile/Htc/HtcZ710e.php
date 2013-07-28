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
use \Browscap\Detector\Version;
use \Browscap\Detector\Company;
use \Browscap\Detector\Type\Device as DeviceType;

/**
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
    protected $properties = array();
    
    /**
     * Class Constructor
     *
     * @return DeviceHandler
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->properties = array(
            'wurflKey' => 'htc_sensation_ver1_subz710e', // not in wurfl
            
            // kind of device
            'device_type' => new DeviceType\MobilePhone(), // not in wurfl
            
            // device
            'model_name'                => 'Z710e',
            'model_version'             => null, // not in wurfl
            'manufacturer_name' => new Company\Htc(),
            'brand_name' => new Company\Htc(),
            'model_extra_info'          => null,
            'marketing_name'            => 'Sensation',
            'has_qwerty_keyboard'       => true,
            'pointing_method'           => 'touchscreen',
            'device_bits'               => null, // not in wurfl
            'device_cpu'                => null, // not in wurfl
            
            // product info
            'can_assign_phone_number'   => true,
            'ununiqueness_handler'      => null,
            'uaprof'                    => 'http://www.htcmms.com.tw/Android/Common/PG58/ua-profile.xml',
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
            'colors'                 => 65536,
            
            // sms
            'sms_enabled' => true,
            
            // chips
            'nfc_support' => true,
        );
    }
    
    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains(array('HTC_Sensation_Z710e', 'HTC Sensation Z710e', 'Sensation_Z710e'))) {
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
     * @return StdClass
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
        parent::detectDependProperties($browser, $engine, $os);
        
        $engine->setCapability('wml_1_1', true);
        $engine->setCapability('bmp', true);
        
        $osVersion = $os->getCapability('device_os_version')->getVersion(
            Version::MAJORMINOR
        );
        
        switch ($browser->getCapability('mobile_browser')) {
            case 'Android Webkit':
                switch ((float) $osVersion) {
                    case 4.0:
                        $this->setCapability('wurflKey', 'htc_sensation_ver1_subz710e_suban40');
                        break;
                    case 2.1:
                    case 2.2:
                    case 2.3:
                    case 3.1:
                    case 3.2:
                    case 4.1:
                    case 4.2:
                    default:
                        // nothing to do here
                        break;
                }
                break;
            case 'Chrome':
                $engine->setCapability('is_sencha_touch_ok', false);
                
                switch ((float) $osVersion) {
                    case 4.0:
                        $this->setCapability('wurflKey', 'htc_sensation_ver1_subz710e_b_suban40rom_subuachrome');
                        break;
                    case 2.1:
                    case 2.2:
                    case 2.3:
                    case 3.1:
                    case 3.2:
                    case 4.1:
                    case 4.2:
                    default:
                        // nothing to do here
                        break;
                }
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $this;
    }
}