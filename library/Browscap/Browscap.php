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
 * @version   SVN: $Id: UserAgent.php 375 2012-12-21 16:58:41Z tmu $
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
            self::INTERFACE_BROWSCAP_INI
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
            default:
                throw new \UnexpectedValueException(
                    'an unsupported interface was set'
                );
                break;
        }
        
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
        
        $support      = new \Browscap\Helper\Support();
        $cleanedAgent = $support->cleanAgent($this->_agent);
        $cacheHelper  = new \Browscap\Helper\Cache();
        
        $result = null;
        
        if (!$forceDetect) {
            $result = $cacheHelper->getBrowserFromCache(
                $this->_cache, $cleanedAgent, $this->_cachePrefix
            );
        }
        
        if ($forceDetect || !$result) {
            $this->_interface->setCache($this->_cache)
                ->setCachePrefix($this->_cachePrefix)
                ->setAgent($this->_agent)
            ;
            
            $result = $this->_interface->getBrowser();
            
            if (!$forceDetect 
                && $this->_cache instanceof \Zend\Cache\Frontend\Core
            ) {
                $cacheId = $cacheHelper->getCacheIdFromAgent(
                    $cleanedAgent, $this->_cachePrefix
                );
                
                $this->_cache->save($result, $cacheId);
            }
        }
        
        return $result;
    }
}