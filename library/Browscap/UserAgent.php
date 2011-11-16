<?php
declare(ENCODING = 'utf-8');
namespace Browscap;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * PHP version 5
 *
 * LICENSE: This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301 USA
 *
 * @category  CreditCalc
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright 2006-2008 Jonathan Stoppani
 * @version   SVN: $Id$
 */

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  CreditCalc
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright 2007-2010 Unister GmbH
 */
class UserAgent
{
    /**
     * the user agent sent from the browser
     *
     * @var string
     */
    private $_agent = '';
    
    /**
     * the detected browser
     *
     * @var StdClass
     */
    private $_browser = null;

    /**
     * a \Zend\Cache object
     *
     * @var \Zend\Cache
     */
    private $_cache = null;
    
    /*
     * @var \Zend\Log\Logger
     */
    private $_logger = null;
    
    /**
     * @var \Zend\Config\Config
     */
    private $_config = null;

    /**
     * Constructor class, checks for the existence of (and loads) the cache and
     * if needed updated the definitions
     *
     * @param string                          $agent
     * @param array|\Zend\Config\Config       $config
     * @param \Zend\Log\Logger                $logger
     * @param array|\Zend\Cache\Frontend\Core $cache
     *
     * @throws Exceptions\AgentNotStringException
     */
    public function __construct($agent = null, $config = null, $logger = null, $cache = null)
    {
        if (null === $agent) {
            $support = new Support();
            $agent   = $support->getUserAgent();
        }
        if (!is_string($agent)) {
            throw new Exceptions\AgentNotStringException(
                'the user agent must be a string'
            );
        }
        
        $this->_agent = $agent;
        
        if ($config instanceof \Zend\Config\Config) {
            $config = $config->toArray();
        }
        
        if (null !== $config && !is_array($config)) {
            throw new Exceptions\WrongConfigObjectException(
                'the config must be an array or an instance of \\Zend\\Config\\Config'
            );
        }
        
        $this->_config = $config;
        
        $this->_cache = null;
        if ($cache instanceof \Zend\Cache\Frontend\Core) {
            $this->_cache = $cache;
        } elseif (!empty($config['cache']) && is_array($config['cache'])) {
            $cacheConfig = $config['cache'];
            
            $this->_cache = \Zend\Cache\Cache::factory(
                $cacheConfig['frontend'],
                $cacheConfig['backend'],
                $cacheConfig['front'],
                $cacheConfig['back']
            );
        }
        
        if (null === $this->_cache && null !== $cache) {
            throw new Exceptions\WrongCacheObjectException(
                'the cache must be an instance of \\Zend\\Cache\\Frontend\\Core'
            );
        }

        if ($logger instanceof \Zend\Log\Logger) {
            $this->_logger = $logger;
        } elseif (null !== $logger) {
            throw new Exceptions\WrongCacheObjectException(
                'the logger must be an instance of \\Zend\\Log\\Logger'
            );
        }
        
        $this->_browser = $this->_detect();
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $sUserAgent     the user agent string
     * @param boolean $bReturnAsArray whether return an array or an object
     *
     * @return stdClas|array the object containing the browsers details.
     *                       Array if $bReturnAsArray is set to true.
     */
    private function _detect($sUserAgent = null, $bReturnAsArray = false)
    {
        // define the User Agent object and set the default values
        $object = new \StdClass();
        $object->Browser  = 'Default Browser';
        $object->Version  = 0;
        $object->MajorVer = 0;
        $object->MinorVer = 0;
        $object->Platform = 'unknown';
        $object->Alpha = false;
        $object->Beta = false;
        $object->Win16    = 0;
        $object->Win32    = 0;
        $object->Win64    = 0;
        $object->Frames = false;
        $object->IFrames = false;
        $object->Tables = false;
        $object->Cookies = false;
        $object->BackgroundSounds = false;
        $object->JavaScript = false;
        $object->VBScript = false;
        $object->JavaApplets = false;
        $object->ActiveXControls = false;
        $object->isBanned = false;
        $object->isMobileDevice = false;
        $object->isSyndicationReader = false;
        $object->Crawler = false;
        $object->CssVersion = 0;
        $object->AolVersion = 0;
        $object->wurflKey = 'generic';
        $object->renderEngine = 'unknown';
        
        // detect the rendering engine
        $engineChain = new Engine\Chain();
        $engine      = $engineChain->detect($sUserAgent);
        
        // detect the browser
        $browserChain = new Browser\Chain();
        $browser      = $browserChain->detect($sUserAgent);
        
        // detect the operating system
        $osChain = new Os\Chain();
        $os      = $osChain->detect($sUserAgent);
        
        // detect the device
        $deviceChain = new Device\Chain();
        $device      = $deviceChain->detect($sUserAgent);
        
        // take over the detected values to User Agent object
        $object->Browser  = $browser->browser;
        $object->Version  = $browser->version;
        $object->MajorVer = (int) $browser->version;
        $versions         = explode('.', $browser->version, 2);
        $object->MinorVer = $versions[1];
        
        if (64 == $browser->bits) {
            $object->Win64 = 1;
        } elseif (32 == $browser->bits) {
            $object->Win32 = 1;
        } elseif (16 == $browser->bits) {
            $object->Win16 = 1;
        }
        
        return ($bReturnAsArray ? (array) $object : $object);
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $sUserAgent     the user agent string
     * @param boolean $bReturnAsArray whether return an array or an object
     *
     * @return stdClas|array the object containing the browsers details.
     *                       Array if $bReturnAsArray is set to true.
     */
    public function getBrowser($sUserAgent = null, $bReturnAsArray = false)
    {
        return $this->_detect($sUserAgent, $bReturnAsArray);
    }
    
    /**
     * returns the stored user agent
     *
     * @return string
     */
    public function getAgent()
    {
        return $this->_agent;
    }
    
    /**
     * returns the stored user agent
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getAgent();
    }
}