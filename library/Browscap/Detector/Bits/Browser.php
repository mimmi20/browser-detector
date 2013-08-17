<?php
namespace Browscap\Detector\Bits;

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
 * WURFL_Handlers_Handler is the base class that combines the classification of
 * the user agents and the matching process.
 *
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
final class Browser
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = null;
    
    /**
     * @var string the bits of the detected browser
     */
    private $bits = null;
    
    /**
     * @var \Browscap\Helper\Utils
     */
    private $utils = null;
    
    /**
     * class constructor
     */
    public function __construct()
    {
        $this->utils = new \Browscap\Helper\Utils();
    }
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    public function setUserAgent($userAgent)
    {
        $this->useragent = $userAgent;
        $this->utils->setUserAgent($this->useragent);
        
        return $this;
    }
    
    public function getBits()
    {
        if (null === $this->useragent) {
            throw new \UnexpectedValueException(
                'You have to set the useragent before calling this function'
            );
        }
        
        $this->_detectBits();
        
        return $this->bits;
    }
    
    /**
     * detects the bit count by this browser from the given user agent
     *
     * @return void
     */
    private function _detectBits()
    {
        // 32 bits on 64 bit system
        if ($this->utils->checkIfContains(array('i686 on x86_64'))) {
            $this->bits = '32';
            
            return $this;
        }
        
        // 64 bits
        if ($this->utils->checkIfContains(array('x64', 'Win64', 'x86_64', 'amd64', 'AMD64', 'ppc64'))) {
            $this->bits = '64';
            
            return $this;
        }
        
        // old deprecated 16 bit windows systems
        if ($this->utils->checkIfContains(array('Win3.1', 'Windows 3.1'))) {
            $this->bits = '16';
            
            return $this;
        }
        
        // general windows or a 32 bit browser on a 64 bit system (WOW64)
        if ($this->utils->checkIfContains(array('Win', 'WOW64', 'i586', 'i686', 'i386', 'i486', 'i86', 'Intel Mac OS X', 'Android', 'PPC'))) {
            $this->bits = '32';
            
            return $this;
        }
        
        // old deprecated 8 bit systems
        if ($this->utils->checkIfContains(array('CP/M', '8-bit'))) {
            $this->bits = '8';
            
            return $this;
        }
        
        $this->bits = '';
        
        return $this;
    }
}