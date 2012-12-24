<?php
namespace Browscap\Os\Handlers;

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

use Browscap\Os\Handler as OsHandler;

/**
 * MSIEAgentHandler
 *
 *
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
class Ios extends OsHandler
{
    /**
     * @var string the detected platform
     */
    protected $_name = 'iOS';
    
    /**
     * @var string the manufacturer/creator of this OS
     */
    protected $_manufacturer = 'Apple';
    
    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        if ('' == $this->_useragent) {
            return false;
        }
        
        $ios = array(
            'IphoneOSX', 'iPhone OS', 'like Mac OS X', 'iPad', 'IPad', 'iPhone',
            'iPod', 'CPU OS', 'CPU iOS'
        );
        
        if (!$this->_utils->checkIfContains($ios)) {
            return false;
        }
        
        return true;
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
        $doMatch = preg_match('/IphoneOSX\/([\d\.\_]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $doMatch = preg_match('/CPU OS ([\d\.\_]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $doMatch = preg_match('/CPU iOS ([\d\.\_]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $doMatch = preg_match('/CPU iPad OS ([\d\.\_]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $doMatch = preg_match('/iPhone OS ([\d\.\_]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $doMatch = preg_match('/iPhone_OS\/([\d\.\_]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $doMatch = preg_match('/CPU like Mac OS X/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = '1.0';
            return;
        }
        
        $this->_version = '';
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 404;
    }
    
    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function getBrowser()
    {
        $browsers = array(
            'Safari',
            'OperaMini',
            'Sleipnir',
            'DarwinBrowser',
            'Facebook',
            'Isource',
            'Chrome'
        );
        
        $browserPath = realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' 
            . DIRECTORY_SEPARATOR . 'Browser' 
            . DIRECTORY_SEPARATOR . 'Handlers' . DIRECTORY_SEPARATOR . 'Mobile' 
            . DIRECTORY_SEPARATOR
        );
        $browserNs   = 'Browscap\\Browser\\Handlers\\Mobile';
        
        $chain = new \Browscap\Browser\Chain(false, $browsers, $browserPath, $browserNs);
        $chain->setDefaultHandler(new \Browscap\Browser\Handlers\Mobile\Safari());
        $chain->setUseragent($this->_useragent);
        
        return $chain->detect();
    }
}