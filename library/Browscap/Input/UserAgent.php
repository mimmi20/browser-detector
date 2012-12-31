<?php
namespace Browscap\Input;

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
class UserAgent extends Core
{
    /**
     * the detected browser
     *
     * @var StdClass
     */
    private $_browser = null;
    
    /**
     * the detected browser engine
     *
     * @var StdClass
     */
    private $_engine = null;
    
    /**
     * the detected platform
     *
     * @var StdClass
     */
    private $_os = null;
    
    /**
     * the detected device
     *
     * @var StdClass
     */
    private $_device = null;
    
    /**
     * the detection result
     *
     * @var \\Browscap\\Detector\\Result
     */
    private $_result = null;

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \Browscap\Detector\Result
     */
    final public function getBrowser()
    {
        $this->_device = $this->_detectDevice();
        
        if ($this->_device->hasOs()) {
            $this->_os = $this->_device->detectOs();
        } else {
            $this->_os = $this->_detectOs();
        }
        
        if ($this->_device->hasBrowser()) {
            $this->_browser = $this->_device->detectBrowser();
        } else {
            $this->_browser = $this->_detectBrowser();
        }
        
        if ($this->_browser->hasEngine()) {
            $this->_engine = $this->_browser->detectEngine();
        } else {
            $this->_engine = $this->_detectEngine();
        }
        
        $this->_result = new \Browscap\Detector\Result();
        $this->_result->setCapabilities($this->_device->getCapabilities());
        $this->_result->setCapabilities($this->_os->getCapabilities());
        $this->_result->setCapabilities($this->_browser->getCapabilities());
        $this->_result->setCapabilities($this->_engine->getCapabilities());
        
        return $this->_result;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @return 
     */
    private function _detectEngine()
    {
        $handlersToUse = array(
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Engine');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Engine\Unknown());
        
        return $chain->detect();
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return 
     */
    private function _detectBrowser()
    {
        $handlersToUse = array(
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Browser');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Browser\Unknown());
        
        return $chain->detect();
    }

    /**
     * Gets the information about the os by User Agent
     *
     * @return 
     */
    private function _detectOs()
    {
        $handlersToUse = array(
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Os');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Os\Unknown());
        
        return $chain->detect();
    }

    /**
     * Gets the information about the device by User Agent
     *
     * @return UserAgent
     */
    private function _detectDevice()
    {
        $handlersToUse = array(
            new \Browscap\Detector\Device\GeneralBot(),
            new \Browscap\Detector\Device\GeneralMobile(),
            new \Browscap\Detector\Device\GeneralTv(),
            new \Browscap\Detector\Device\GeneralDesktop()
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Device');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Device\Unknown());
        
        return $chain->detect();
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