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
final class Os
{
    /**
     * @var string the user agent to handle
     */
    private $_useragent = null;
    
    /**
     * @var string the bits of the detected browser
     */
    private $_bits = null;
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        
        return $this;
    }
    
    public function getBits()
    {
        if (null === $this->_useragent) {
            throw new \UnexpectedValueException(
                'You have to set the useragent before calling this function'
            );
        }
        
        if (null === $this->_bits) {
            $this->_detectBits();
        }
        
        return $this->_bits;
    }
    
    /**
     * detects the bit count by this browser from the given user agent
     *
     * @return void
     */
    private function _detectBits()
    {
        $utils = new \Browscap\Helper\Utils();
        $utils->setUserAgent($this->_useragent);
        
        if ($utils->checkIfContains(array('x64', 'Win64', 'WOW64', 'x86_64', 'amd64', 'AMD64', 'ppc64', 'i686 on x86_64'))) {
            $this->_bits = '64';
            
            return $this;
        }
        
        if ($utils->checkIfContains(array('Win3.1', 'Windows 3.1'))) {
            $this->_bits = '16';
            
            return $this;
        }
        
        if ($utils->checkIfContains(array('Win', 'i586', 'i686', 'i386', 'i486', 'i86', 'Intel Mac OS X', 'Android', 'PPC'))) {
            $this->_bits = '32';
            
            return $this;
        }
        
        $this->_bits = '';
        
        return $this;
    }
}