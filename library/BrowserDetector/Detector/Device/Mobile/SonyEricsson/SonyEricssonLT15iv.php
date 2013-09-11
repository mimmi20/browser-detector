<?php
namespace BrowserDetector\Detector\Device\Mobile\SonyEricsson;

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
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */

use \BrowserDetector\Detector\DeviceHandler;
use \BrowserDetector\Helper\Utils;
use \BrowserDetector\Detector\MatcherInterface;
use \BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use \BrowserDetector\Detector\BrowserHandler;
use \BrowserDetector\Detector\EngineHandler;
use \BrowserDetector\Detector\OsHandler;
use \BrowserDetector\Detector\Version;
use \BrowserDetector\Detector\Company;
use \BrowserDetector\Detector\Type\Device as DeviceType;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
class SonyEricssonLT15iv
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
            'wurflKey' => 'sonyericsson_lt15i_ver1_subua232', // not in wurfl
            
            // kind of device
            'device_type' => new DeviceType\MobilePhone(), // not in wurfl
            
            // device
            'model_name'                => 'LT15iv',
            'model_version'             => null, // not in wurfl
            'manufacturer_name' => new Company\SonyEricsson(),
            'brand_name' => new Company\SonyEricsson(),
            'model_extra_info'          => null,
            'marketing_name'            => 'Xperia Arc SO-01C for DoCoMo',
            'has_qwerty_keyboard'       => false, // wurflkey: sonyericsson_lt15i_ver1_subua232
            'pointing_method'           => 'touchscreen',
            'device_bits'               => null, // not in wurfl
            'device_cpu'                => null, // not in wurfl
            
            // product info
            'can_assign_phone_number'   => true, // wurflkey: sonyericsson_lt15i_ver1_subua232
            'ununiqueness_handler'      => null,
            'uaprof'                    => 'http://wap.sonyericsson.com/UAprof/LT15iR402.xml',
            'uaprof2'                   => null,
            'uaprof3'                   => null,
            'unique'                    => true,
            
            // display
            'physical_screen_width'  => 34, // wurflkey: sonyericsson_lt15i_ver1_subua232
            'physical_screen_height' => 50,
            'columns'                => 44,
            'rows'                   => 32,
            'max_image_width'        => 320,
            'max_image_height'       => 400,
            'resolution_width'       => 480,
            'resolution_height'      => 854,
            'dual_orientation'       => true,
            'colors'                 => 16777216,
            
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
        if (!$this->utils->checkIfContains('SonyEricssonLT15iv')) {
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
     * @return null|\BrowserDetector\Os\Handler
     */
    public function detectBrowser()
    {
        $browsers = array(
            new \BrowserDetector\Detector\Browser\Mobile\Android(),
            new \BrowserDetector\Detector\Browser\Mobile\Chrome(),
            new \BrowserDetector\Detector\Browser\Mobile\Dalvik()
        );
        
        $chain = new \BrowserDetector\Detector\Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new \BrowserDetector\Detector\Browser\Unknown());
        
        return $chain->detect();
    }
    
    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\BrowserDetector\Os\Handler
     */
    public function detectOs()
    {
        $handler = new \BrowserDetector\Detector\Os\Android();
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
        
        $engine->setCapability('bmp', true);
        $engine->setCapability('xhtml_can_embed_video', 'none');
        
        return $this;
    }
}