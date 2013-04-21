<?php
namespace Browscap\Helper;

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
/**
 * WURFL user agent hander utilities
 * @package   Browscap
 */
final class MobileDevice
{
    /**
     * @var string the user agent to handle
     */
    private $_useragent = '';
    
    /**
     * @var \Browscap\Helper\Utils the helper class
     */
    private $_utils = null;
    
    /**
     * @var array Collection of mobile browser keywords
     */
    private $_mobileBrowsers = array(
        'android',
        'arm; touch',
        'aspen simulator',
        'bada',
        'blackberry',
        'blazer',
        'bolt',
        'brew',
        'cldc',
        'dalvik',
        'danger hiptop',
        'eeepc',
        'embider',
        'fennec',
        'firefox or ie',
        'foma',
        'folio100',
        'gingerbread',
        'hd_mini_t',
        'hp-tablet',
        'hpwOS',
        'htc',
        'ipad',
        'iphone',
        'iphoneosx',
        'iphone os',
        'ipod',
        'iris',
        'iuc(u;ios',
        'j2me',
        'juc(linux;u;',
        'kindle',
        'lenovo',
        'like mac os x',
        'look-alike',
        'maemo',
        'meego',
        'midp',
        'netfront',
        'nintendo',
        'nitro',
        'nokia',
        'obigo',
        'openwave',
        'opera mini',
        'opera mobi',
        'palm',
        'phone',
        'playstation',
        'pocket pc',
        'pocketpc',
        'rim tablet',
        'samsung',
        'series40',
        'series 60',
        'silk',
        'symbian',
        'symbianos',
        'symbos',
        'toshiba_ac_and_az',
        'touchpad',
        'transformer tf',
        'up.browser',
        'up.link',
        'xblwp7',
        'wap2',
        'webos',
        'wetab-browser',
        'windows ce',
        'windows mobile',
        'windows phone os',
        'wireless',
        'xda_diamond_2',
        'zunewp7'
    );
    
    /**
     * Class Constructor
     *
     * @return DeviceHandler
     */
    public function __construct()
    {
        $this->_utils = new Utils();
    }
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        $this->_utils->setUserAgent($userAgent);
        
        return $this;
    }
    
    /**
     * Returns true if the give $userAgent is from a mobile device
     * @param string $userAgent
     * @return bool
     */
    public function isMobileBrowser()
    {
        if ($this->_utils->checkIfContains($this->_mobileBrowsers, true)) {
            $noBots = array(
                'xbox', 'badab', 'badap', 'simbar',
                'google wireless transcoder', 'google-tr', 'googlet', 
                'google page speed', 'google web preview'
            );
            
            if ($this->_utils->checkIfContains($noBots, true)) {
                return false;
            }
            
            return true;
        }
        
        if ($this->_utils->checkIfContains('tablet', true)
            && !$this->_utils->checkIfContains('tablet pc', true)
        ) {
            return true;
        }
        
        if ($this->_utils->checkIfContains('mobile', true)
            && !$this->_utils->checkIfContains('automobile', true)
        ) {
            return true;
        }
        
        if ($this->_utils->checkIfContains('sony', true)
            && !$this->_utils->checkIfContains('sonydtv', true)
        ) {
            return true;
        }
        
        if ($this->_utils->checkIfContains('Windows NT 6.2; ARM;')) {
            return true;
        }
        
        return false;
    }
}