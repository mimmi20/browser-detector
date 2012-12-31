<?php
namespace Browscap\Detector\Device\Mobile\Nokia;

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

use \Browscap\Detector\Device\Mobile\Nokia as NokiaBase;

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
class NokiaSeries60 extends NokiaBase
{
    /**
     * the detected browser properties
     *
     * @var StdClass
     */
    protected $_properties = array(
        'wurflKey' => null, // not in wurfl
        
        // kind of device
        'is_wireless_device' => true,
        'is_tablet'          => false,
        'is_bot'             => false,
        'is_smarttv'         => false,
        'is_console'         => false,
        'ux_full_desktop'    => false,
        'is_transcoder'      => false,
        
        // device
        'model_name'                => 'Series 60',
        'manufacturer_name'         => 'Nokia',
        'brand_name'                => 'unknown',
        'model_extra_info'          => null,
        'marketing_name'            => null,
        'has_qwerty_keyboard'       => null,
        'pointing_method'           => null,
        'device_claims_web_support' => null,
        'device_bits'               => null, // not in wurfl
        'device_cpu'                => null, // not in wurfl
        
        // browser
        'mobile_browser'         => null,
        'mobile_browser_version' => null,
        'mobile_browser_bits'    => null, // not in wurfl
        
        // os
        'device_os'              => null,
        'device_os_version'      => null,
        'device_os_bits'         => null, // not in wurfl
        'device_os_manufacturer' => null, // not in wurfl
        
        // engine
        'renderingengine_name'         => null, // not in wurfl
        'renderingengine_version'      => null, // not in wurfl
        'renderingengine_manufacturer' => null, // not in wurfl
        
        // others
        'is_banned' => null, // not in wurfl
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
        if (!$this->_utils->checkIfContains('Series 60', 'S60')) {
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
        return parent::getWeight() + 1;
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
}