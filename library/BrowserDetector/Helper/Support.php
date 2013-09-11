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
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @version Stable 2.1.3 $Date: 2010/09/18 15:43:21
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
/**
 * Provides static supporting functions
 * @package   BrowserDetector
 *
 */
class Support
{
    private $_source = array();
    
    /**
     * The HTTP Headers that this application will look through to find the best
     * User Agent, if one is not specified
     *
     * @var Array
     */
    private $_userAgentHeaders = array(
        'HTTP_X_DEVICE_USER_AGENT',
        'HTTP_X_ORIGINAL_USER_AGENT',
        'HTTP_X_OPERAMINI_PHONE_UA',
        'HTTP_X_SKYFIRE_PHONE',
        'HTTP_X_BOLT_PHONE_UA',
        'HTTP_USER_AGENT'
    );
    
    // Constructor
    public function __construct($source = null)
    {
        if (is_null($source) || !is_array($source)) {
            $source = $_SERVER;
        }
        
        $this->_source = $source;
    }
    
    // Public Methods
    public function getUserAgent()
    {
        $userAgent = '';
        
        if (isset($_POST['agent'])) {
            $userAgent = $this->_cleanParam($_POST['agent']);
        } elseif (isset($_GET['agent'])) {
            $userAgent = $this->_cleanParam($_GET['agent']);
        } elseif (isset($_POST['UA'])) {
            //deprecated
            $userAgent = $this->_cleanParam($_POST['UA']);
        } elseif (isset($_GET['UA'])) {
            //deprecated
            $userAgent = $this->_cleanParam($_GET['UA']);
        } else {
            foreach ($this->_userAgentHeaders as $header) {
                if (array_key_exists($header, $this->_source) 
                    && $this->_source[$header]
                ) {
                    $userAgent = $this->_cleanParam($this->_source[$header]);
                    break;
                }
            }
        }
        
        return $userAgent;
    }
    
    public function cleanAgent($userAgent)
    {
        if (0 < stripos($userAgent, 'user-agent:')) {
            $userAgent = substr($userAgent, 0, stripos($userAgent, 'user-agent:'));
        }
        
        $userAgent = str_replace(
            array(
                'User-Agent:', 
                'User-agent:', 
                ' (KHTML, like Gecko)', 
                'Embedded Web Browser from: http://bsalsa.com/;',
                ',gzip(gfe) (via translate.google.com)'
            ), 
            '', 
            $userAgent
        );
        
        $userAgent = str_replace(
            array(' :: ', '%2C', '%20', 'rv = '), 
            array(';', '.', ' ', 'rv:'), 
            $userAgent
        );
        
        if (substr_count($userAgent, 'Mozilla/') > 1) {
            $pos = strpos($userAgent, 'Mozilla/') + 1;
            $pos = strpos($userAgent, 'Mozilla/', $pos);
            
            $userAgent = substr($userAgent, 0, $pos);
        }
        
        $replaceRules = array(
            '/\.(NET CLR |NET4\.)([a-zA-Z0-9\-\.]+)/',
            '/(media center pc|tablet pc|tob|aol|aolbuild|freenet|arcor|esobisubscriber|zango|zune|seekmotoolbar|versatel\.de isdn|ms\-rtc lm|shopperreports|hotbar|ant\.com toolbar|megaupload|zangotoolbar|dealio toolbar|spamblockerutility|searchtoolbar) ([\d\.]+)/i',
            '/(OfficeLiveConnector|OfficeLivePatch|InfoPath)\.([\d\.]+)/',
            '/SIMBAR\=\{([0-9A-Z\-]+)\}/',
            '/(slcc|btrs|bri\/|np|boie|t\-online ie|sv|iemb)(\d+)/i',
            '/ask([0-9a-zA-Z\/\-\.]+)/i',
            '/gtb([\d\.]+)/i',
            '/(anonymized by Abelssoft|Anonymisiert durch AlMiSoft Browser\-Maulkorb|Anonymisiert durch AlMiSoft Browser\-Anonymisierer) (\d+)/',
            '/Gacela\=\d-\{([0-9A-Z\-]+)\}\-\d+/',
            '/tb\-(webde|gmx)\/([\d\.]+)/',
            '/(webde|1und1|gmx|feed|imageshacktoolbar|lightning|firephp)\/([\d\.abpre]+)/i',
            '/easybits ([0-9a-z\ \.]+)/i',
            '/MSNIE(\d+)A/',
            '/(microsoft\.com|msn) optimized ie(\d+)/i',
            '/(alexa toolbar|alexatoolbar)([0-9a-z\-\\\\]+)/i',
            '/(funwebproducts|fdm|enusmscom|tmstmpext|compatible|t\-brand\-rc|cooee|t\-brand\-final|mddc|msn optimized|alexa toolbar|alexatoolbar)/i',
            '/ma(nm|md|pb|au|em|ar|ln)/i',
            '/mra ([\d\.]+) \(build \d+\)/i',
            '/#(.*)#/',
            '/\\x../'
        );
        
        foreach ($replaceRules as $rule) {
            if (preg_match($rule, $userAgent)) {
                $userAgent = preg_replace($rule, '', $userAgent);
            }
        }
        
        $userAgent = preg_replace(array('/\;\s+\;\s+/', '/\;\s+\;/', '/\;\s+\)/', '/\;+/'), ';', $userAgent);
        $userAgent = preg_replace(array('/\;\)/', '/\;\s+\)/'), ')', $userAgent);
        $userAgent = preg_replace(array('/\(\;\s+/', '/\(\;/'), '(', $userAgent);
        $userAgent = preg_replace(array('/\(\)\s*\;/', '/\;\s*\(\)/', '/\(\s*\)/'), '', $userAgent);
        
        $userAgent = preg_replace('/\s+\s/', ' ', $userAgent);
        
        return trim($userAgent);
    }
    
    public function getAcceptHeader()
    {
        $accept = '*/*';
        
        if (isset($_POST['ACCEPT'])) {
            $accept = $this->_cleanParam($_POST['ACCEPT']);
        } elseif (isset($_GET['ACCEPT'])) {
            $accept = $this->_cleanParam($_GET['ACCEPT']);
        } else {
            if (array_key_exists('HTTP_ACCEPT', $this->_source) 
                && $this->_source['HTTP_ACCEPT']
            ) {
                $accept = $this->_cleanParam($this->_source['HTTP_ACCEPT']);
            }
        }
        
        return $accept;
    }
    
    public function getUAProfile()
    {
        return isset($this->_source['X-WAP-PROFILE']) 
            ? $this->_source['X-WAP-PROFILE']
            : '';
    }
    
    public static function formatBytes($bytes)
    {
        $unim = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        $c     = 0;
        
        while ($bytes >= 1024) {
            $c++;
            $bytes = $bytes / 1024;
        }
        return number_format($bytes, ($c ? 2 : 0), '.', ',') . ' ' . $unim[$c];
    }
    
    public static function formatBitrate($bytes, $seconds)
    {
        $unim = array('bps', 'Kbps', 'Mbps', 'Gbps', 'Tbps', 'Pbps');
        $bits = $bytes * 8;
        $bps  = $bits / $seconds;
        $c    = 0;
        
        while ($bps >= 1000) {
            $c++;
            $bps = $bps / 1000;
        }
        return number_format($bps, ($c ? 2 : 0), '.', ',') . ' ' . $unim[$c];
    }
    
    public static function showBool($var)
    {
        if ($var === true) {
            return 'true';
        }
        
        if ($var === false) {
            return 'false';
        }
        
        return $var;
    }
    
    public static function showLogLevel($num)
    {
        $log_arr = array(
            1 => 'LOG_CRIT',
            4 => 'LOG_ERR',
            5 => 'LOG_WARNING',
            6 => 'LOG_NOTICE'
        );
        return $log_arr[$num];
    }

    /**
     * clean Parameters taken from GET or POST Variables
     *
     * @param string $param the value to be cleaned
     *
     * @return string
     */
    private function _cleanParam($param)
    {
        return strip_tags(trim(urldecode($param)));
    }
}
