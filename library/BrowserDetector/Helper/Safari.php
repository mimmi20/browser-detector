<?php
namespace BrowserDetector\Helper;

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
/**
 * a helper for detecting safari and some of his derefered browsers
 * @package   BrowserDetector
 */
class Safari
{
    /**
     * @var string the user agent to handle
     */
    private $_useragent = '';
    
    /**
     * @var \BrowserDetector\Helper\Utils the helper class
     */
    private $utils = null;
    
    /**
     * Class Constructor
     *
     * @return DeviceHandler
     */
    public function __construct()
    {
        $this->utils = new Utils();
    }
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        $this->utils->setUserAgent($userAgent);
        
        return $this;
    }
    
    public function isSafari()
    {
        if (!$this->utils->checkIfContains('Mozilla/')
            && !$this->utils->checkIfContains('Safari')
            && !$this->utils->checkIfContains('MobileSafari')
        ) {
            return false;
        }
        
        if (!$this->utils->checkIfContains(array('Safari', 'AppleWebKit', 'CFNetwork'))) {
            return false;
        }
        
        $isNotReallyAnSafari = array(
            // using also the KHTML rendering engine
            '1Password',
            'AdobeAIR',
            'Arora',
            'BlackBerry',
            'BrowserNG',
            'Chrome',
            'Chromium',
            'Dolfin',
            'Dreamweaver',
            'Epiphany',
            'FBAN/',
            'FBAV/',
            'FBForIPhone',
            'Flock',
            'Galeon',
            'Google Earth',
            'iCab',
            'Iron',
            'konqueror',
            'Lunascape',
            'Maemo',
            'Maxthon',
            'Midori',
            'MQQBrowser',
            'NokiaBrowser',
            'OmniWeb',
            'PaleMoon',
            'PhantomJS',
            'Qt',
            'QuickLook',
            'QupZilla',
            'rekonq',
            'Rockmelt',
            'Silk',
            'Shiira',
            'WebBrowser',
            'WebClip',
            'WeTab',
            'wOSBrowser',
            //mobile Version
            //'Mobile',
            'Tablet',
            'Android',
            // Fakes
            'Mac; Mac OS '
        );
        
        if ($this->utils->checkIfContains($isNotReallyAnSafari)) {
            return false;
        }
        
        return true;
    }
    
    public function isMobileAsSafari()
    {
        if (!$this->isSafari()) {
            return false;
        }
        
        $mobileDeviceHelper = new MobileDevice();
        $mobileDeviceHelper->setUserAgent($this->_useragent);
        
        if (!$mobileDeviceHelper->isMobileBrowser()) {
            return false;
        }
        
        if ($this->utils->checkIfContains(array('PLAYSTATION', 'Browser/AppleWebKit', 'CFNetwork', 'BlackBerry; U; BlackBerry'))) {
            return false;
        }
        
        return true;
    }
    
    /**
     * maps different Safari Versions to a normalized format
     *
     * @return string
     */
    public function mapSafariVersions($detectedVersion)
    {
        if ($detectedVersion >= 9500) {
            $detectedVersion = '7.0';
        } elseif ($detectedVersion >= 8500) {
            $detectedVersion = '6.0';
        } elseif ($detectedVersion >= 7500) {
            $detectedVersion = '5.1';
        } elseif ($detectedVersion >= 6500) {
            $detectedVersion = '5.0';
        } elseif ($detectedVersion >= 950) {
            $detectedVersion = '7.0';
        } elseif ($detectedVersion >= 850) {
            $detectedVersion = '6.0';
        } elseif ($detectedVersion >= 750) {
            $detectedVersion = '5.1';
        } elseif ($detectedVersion >= 650) {
            $detectedVersion = '5.0';
        } elseif ($detectedVersion >= 500) {
            $detectedVersion = '4.0';
        }
        
        $regularVersions = array(
            '3.0', '3.1', '3.2', '4.0', '4.1', '5.0', '5.1', '5.2', '6.0',
            '6.1', '7.0', '7.1'
        );
        
        if (in_array(substr($detectedVersion, 0, 3), $regularVersions)) {
            return $detectedVersion;
        }
        
        return '';
    }
}