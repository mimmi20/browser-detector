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
    
    /**
     * a \\Zend\\Cache object
     *
     * @var \\Zend\\Cache
     */
    private $_cache = null;
    
    /**
     * @var string
     */
    private $_cachePrefix = '';
    
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
     * the file used in INI mode
     *
     * @var string
     */
    private $_localFile = null;
    
    /**
     * the config object
     *
     * @var \Wurfl\Configuration\Config
     */
    private $_config = null;
    
    /**
     * the wurfl detector class
     *
     * @var
     */
    private $_wurflManager = null;
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return \\Browscap\\Browscap
     */
    public function setCache(\Zend\Cache\Frontend\Core $cache)
    {
        $this->_cache = $cache;
        
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
        
        $this->_cachePrefix = $prefix;
        
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
     * sets the the cache prfix
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
            self::INTERFACE_WURFL
        );
        
        if (!is_int($interface) || !in_array($interface, $allowedInterfaces)) {
            throw new \UnexpectedValueException(
                'the cache prefix has to be a integer'
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
                $this->_interface = new \Browscap\Input\Browscap();
                $this->_interface->setCache($this->_cache);
                $this->_interface->setCachePrefix($this->_cachePrefix);
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
     * sets the name of the local file
     *
     * @param string $file the file name
     *
     * @return void
     */
    public function setLocaleFile($file)
    {
        $this->_localFile = $file;
    }
    
    /**
     * sets ab wurfl detection manager
     *
     * @var \Wurfl\ManagerFactory|\Wurfl\Manager
     *
     * @return \Browscap\Input\Browscap
     */
    public function setWurflManager($wurfl)
    {
        if ($wurfl instanceof \Wurfl\ManagerFactory) {
            $wurfl = $wurfl->create();
        }
        
        if (!($wurfl instanceof \Wurfl\Manager)) {
            throw new \UnexpectedValueException(
                'the $wurfl object has to be an instance of \\Wurfl\\ManagerFactory or an instance of \\Wurfl\\ManagerFactory'
            );
        }
        
        $this->_wurflManager = $wurfl;
        
        return $this;
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
        
        $cacheId = hash('sha512', $this->_cachePrefix . $this->_agent);
        $result  = null;
        
        if (!$forceDetect) {
            $result = $this->_cache->load($cacheId);
        }
        
        if ($forceDetect || !$result) {
            if (null !== $this->_localFile 
                && $this->_interface instanceof \Browscap\Input\Browscap
            ) {
                /*
                 * set the local file
                 * only needed for the ini-mode
                 */
                $this->_interface->setLocaleFile($this->_localFile);
            }
            
            if (null !== $this->_wurflManager 
                && $this->_interface instanceof \Browscap\Input\Wurfl
            ) {
                /*
                 * set the local file
                 * only needed for the ini-mode
                 */
                $this->_interface->setWurflManager($this->_wurflManager);
            }
            
            $this->_interface->setCache($this->_cache)
                ->setCachePrefix($this->_cachePrefix)
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
                && $this->_cache instanceof \Zend\Cache\Frontend\Core
            ) {
                $this->_cache->save($result, $cacheId);
            }
        }
        
        return $result;
    }
}