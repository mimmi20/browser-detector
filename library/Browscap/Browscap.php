<?php
namespace Browscap;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
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
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright 2006-2008 Jonathan Stoppani
 * @version   SVN: $Id$
 */

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class Browscap
{
    const INTERFACE_INTERNAL     = 1;
    const INTERFACE_BROWSCAP_INI = 2;
    const INTERFACE_WURFL        = 3;
    const INTERFACE_WURFL_CLOUD  = 4;
    const INTERFACE_UAPARSER     = 5;
    const INTERFACE_UASPARSER    = 6;
    
    /**
     * a \\Zend\\Cache object
     *
     * @var \\Zend\\Cache
     */
    private $cache = null;
    
    /**
     * @var string
     */
    private $cachePrefix = '';
    
    /**
     * the user agent sent from the browser
     *
     * @var string
     */
    private $_agent = null;
    
    /**
     * the interface for the detection
     *
     * @var \\Browscap\\Input\\Core
     */
    private $_interface = null;
    
    /**
     * the detection result
     *
     * @var \\Browscap\\Detector\\Result
     */
    private $_result = null;
    
    /**
     * the config object
     *
     * @var mixed
     */
    private $_config = null;
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return \\Browscap\\Browscap
     */
    public function setCache(\Zend\Cache\Frontend\Core $cache)
    {
        $this->cache = $cache;
        
        return $this;
    }

    /**
     * sets the the cache prfix
     *
     * @param string $prefix the new prefix
     *
     * @return \\Browscap\\Browscap
     */
    public function setCachePrefix($prefix)
    {
        if (!is_string($prefix)) {
            throw new \UnexpectedValueException(
                'the cache prefix has to be a string'
            );
        }
        
        $this->cachePrefix = $prefix;
        
        return $this;
    }

    /**
     * sets the the cache prfix
     *
     * @param \Wurfl\Configuration\Config $config the new config
     *
     * @return \\Browscap\\Browscap
     */
    public function setConfig(\Wurfl\Configuration\Config $config)
    {
        $this->_config = $config;
        
        return $this;
    }
    
    /**
     * returns the stored user agent
     *
     * @return UserAgent
     */
    public function setAgent($userAgent)
    {
        $this->_agent = $userAgent;
        
        return $this;
    }

    /**
     * sets the the detection interface
     *
     * @param integer $interface the new Interface to use
     *
     * @return \\Browscap\\Browscap
     */
    public function setInterface($interface)
    {
        $allowedInterfaces = array(
            self::INTERFACE_INTERNAL,
            self::INTERFACE_BROWSCAP_INI,
            self::INTERFACE_WURFL,
            self::INTERFACE_WURFL_CLOUD,
            self::INTERFACE_UAPARSER,
            self::INTERFACE_UASPARSER
        );
        
        if (!is_int($interface) || !in_array($interface, $allowedInterfaces)) {
            throw new \UnexpectedValueException(
                'the interface is unknown'
            );
        }
        
        switch ($interface) {
            case self::INTERFACE_BROWSCAP_INI:
                $this->_interface = new \Browscap\Input\Browscap();
                break;
            case self::INTERFACE_INTERNAL:
                $this->_interface = new \Browscap\Input\UserAgent();
                break;
            case self::INTERFACE_WURFL:
                $this->_interface = new \Browscap\Input\Wurfl();
                break;
            case self::INTERFACE_WURFL_CLOUD:
                $this->_interface = new \Browscap\Input\WurflCloud();
                break;
            case self::INTERFACE_UAPARSER:
                $this->_interface = new \Browscap\Input\Uaparser();
                break;
            case self::INTERFACE_UASPARSER:
                $this->_interface = new \Browscap\Input\Uasparser();
                break;
            default:
                throw new \UnexpectedValueException(
                    'an unsupported interface was set'
                );
                break;
        }
        
        return $this;
    }

    /**
     * returns the actual interface
     *
     * @return \\Browscap\\Input\\Core
     */
    public function getInterface()
    {
        return $this->_interface;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $userAgent the user agent string
     *
     * @return 
     */
    public function getBrowser($forceDetect = false)
    {
        if (null === $this->_interface) {
            throw new \UnexpectedValueException(
                'You have to define the Interface before calling this function'
            );
        }
        
        if (null === $this->_agent) {
            throw new \UnexpectedValueException(
                'You have to set the useragent before calling this function'
            );
        }
        
        $cacheId = hash('sha512', $this->cachePrefix . $this->_agent);
        $result  = null;
        
        if (!$forceDetect) {
            $result = $this->cache->load($cacheId);
        }
        
        if ($forceDetect || !$result) {
            $this->_interface->setCache($this->cache)
                ->setCachePrefix($this->cachePrefix)
                ->setAgent($this->_agent)
            ;
            
            $result = $this->_interface->getBrowser();
            
            if (!($result instanceof Detector\Result)) {
                throw new Input\Exception(
                    'the getBrowser Function has to return an instance of \\Browscap\\Detector\\Result', 
                    Input\Exception::NO_RESULT_CLASS_RETURNED
                );
            }
            
            if (!$forceDetect 
                && $this->cache instanceof \Zend\Cache\Frontend\Core
            ) {
                $this->cache->save($result, $cacheId);
            }
        }
        
        return $result;
    }
}