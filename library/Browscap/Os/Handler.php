<?php
namespace Browscap\Os;

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

use \Browscap\Helper\Utils;

/**
 * WURFL_Handlers_Handler is the base class that combines the classification of
 * the user agents and the matching process.
 *
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
abstract class Handler implements MatcherInterface
{
    /**
     * @var string the user agent to handle
     */
    protected $_useragent = '';
    
    /**
     * @var \Zend\Log\Logger
     */
    protected $_logger = null;
    
    /**
     * @var \Browscap\Helper\Utils the helper class
     */
    protected $_utils = null;
    
    /**
     * @var string the detected platform
     */
    protected $_name = 'unknown';
    
    /**
     * @var string the detected platform version
     */
    protected $_version = '';
    
    /**
     * @var string the bits of the detected platform
     */
    protected $_bits = '';
    
    /**
     * @var string the manufacturer/creator of this OS
     */
    protected $_manufacturer = 'unknown';

    /**
     * a \Zend\Cache object
     *
     * @var \Zend\Cache
     */
    protected $_cache = null;
    
    /**
     * @param WURFL_Context $wurflContext
     * @param WURFL_Request_UserAgentNormalizer_Interface $this->_useragentNormalizer
     */
    public function __construct()
    {
        $this->_utils = new Utils();
    }
    
    /**
     * sets the logger used when errors occur
     *
     * @param \Zend\Log\Logger $logger
     *
     * @return 
     */
    final public function setLogger(\Zend\Log\Logger $logger = null)
    {
        if (!($logger instanceof \Zend\Log\Logger)) {
            throw new \InvalidArgumentException(
                'the logger must be an instance of \\Zend\\Log\\Logger'
            );
        }
        
        $this->_logger = $logger;
        $this->_utils->setLogger($logger);
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return 
     */
    final public function setCache(\Zend\Cache\Frontend\Core $cache)
    {
        if (!($cache instanceof \Zend\Cache\Frontend\Core)) {
            throw new \InvalidArgumentException(
                'the cache must be an instance of \\Zend\\Cache\\Frontend\\Core'
            );
        }
        
        $this->_cache = $cache;
        
        return $this;
    }
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    final public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        $this->_utils->setUserAgent($userAgent);
        
        return $this;
    }
    
    /**
     * Returns true if this handler can handle the given useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        return false;
    }
    
    /**
     * detects the operating system name (platform) from the given user agent
     *
     * @return StdClass
     */
    final public function detect()
    {
        $this->_detectVersion();
        $this->_detectBits();
        
        return $this;
    }
    
    final public function getName()
    {
        return $this->_name;
    }
    
    final public function getVersion()
    {
        return $this->_version;
    }
    
    final public function getBits()
    {
        return $this->_bits;
    }
    
    final public function getFullName($withBits = true)
    {
        $name    = $this->getName();
        $version = $this->getVersion();
        $bits    = $this->getBits();
        
        return $name . ($name != $version && '' != $version ? ' ' . $version : '') . (($bits && $withBits) ? ' (' . $bits . ' Bit)' : '');
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $this->_useragent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $this->_version = '';
        
        return $this;
    }
    
    /**
     * detects the bit count by this browser from the given user agent
     *
     * @param string $this->_useragent
     *
     * @return string
     */
    protected function _detectBits()
    {
        if ($this->_utils->checkIfContains(array('x64', 'Win64', 'WOW64', 'x86_64', 'amd64', 'AMD64', 'ppc64', 'i686 on x86_64'))) {
            $this->_bits = '64';
            
            return $this;
        }
        
        if ($this->_utils->checkIfContains(array('Win3.1', 'Windows 3.1'))) {
            $this->_bits = '16';
            
            return $this;
        }
        
        if ($this->_utils->checkIfContains(array('Win', 'i586', 'i686', 'i386', 'i486', 'i86', 'Intel Mac OS X', 'Android'))) {
            $this->_bits = '32';
            
            return $this;
        }
        
        $this->_bits = '';
        
        return $this;
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 1;
    }
    
    /**
     * returns the manufacturer of the actual device
     *
     * @return string
     */
    final public function getManufacturer()
    {
        return $this->_manufacturer;
    }
    
    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\Browscap\Browser\Handler
     */
    public function getBrowser()
    {
        return null;
    }
}