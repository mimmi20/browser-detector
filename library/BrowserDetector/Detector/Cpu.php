<?php
namespace BrowserDetector\Detector;

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
 * Class to detect the generic cpu of an Browser
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
class Cpu
{
    /**
     * @var string the user agent to handle
     */
    private $_useragent = null;
    
    /**
     * @var string the bits of the detected browser
     */
    private $_cpu = null;
    
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
    
    public function getCpu()
    {
        if (null === $this->_useragent) {
            throw new \UnexpectedValueException(
                'You have to set the useragent before calling this function'
            );
        }
        
        if (null === $this->_cpu) {
            $this->_detectCpu();
        }
        
        return $this->_cpu;
    }
    
    /**
     * detects the bit count by this browser from the given user agent
     *
     * @return void
     */
    private function _detectCpu()
    {
        $utils = new \BrowserDetector\Helper\Utils();
        $utils->setUserAgent($this->_useragent);
        
        // Intel 64 bits
        if ($utils->checkIfContains(array('x64', 'x86_64'))) {
            $this->_cpu = 'Intel X64';
            
            return $this;
        }
        
        // AMD 64 Bits
        if ($utils->checkIfContains(array('amd64', 'AMD64'))) {
            $this->_cpu = 'AMD X64';
            
            return $this;
        }
        
        // PPC 64 Bits
        if ($utils->checkIfContains(array('ppc64'), true)) {
            $this->_cpu = 'PPC X64';
            
            return $this;
        }
        
        // Intel X86
        if ($utils->checkIfContains(array('i586', 'i686', 'i386', 'i486', 'i86'))) {
            $this->_cpu = 'Intel X86';
            
            return $this;
        }
        
        // PPC 64 Bits
        if ($utils->checkIfContains(array('ppc'), true)) {
            $this->_cpu = 'PPC';
            
            return $this;
        }
        
        // ARM
        if ($utils->checkIfContains(array('arm'), true)) {
            $this->_cpu = 'ARM';
            
            return $this;
        }
        
        $this->_cpu = '';
        
        return $this;
    }
}