<?php
namespace Browscap;

/**
 * Tera_WURFL - PHP MySQL driven WURFL
 * 
 * Tera-WURFL was written by Steve Kamerman, and is based on the
 * Java WURFL Evolution package by Luca Passani and WURFL PHP Tools by Andrea Trassati.
 * This version uses a MySQL database to store the entire WURFL file, multiple patch
 * files, and a persistent caching mechanism to provide extreme performance increases.
 * 
 * @package TeraWurfl
 * @author Steve Kamerman <stevekamerman AT gmail.com>
 * @version Stable 2.1.3 $Date: 2010/09/18 15:43:21
 * @license http://www.mozilla.org/MPL/ MPL Vesion 1.1
 */
/**
 * Provides static supporting functions for Tera-WURFL
 * @package TeraWurfl
 *
 */
class Support
{
    private $_source = array();
    
    /**
     * The HTTP Headers that Tera-WURFL will look through to find the best User Agent, if one is not specified
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
