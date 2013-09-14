<?php
namespace BrowserDetector\Input;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
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
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @version   SVN: $Id$
 */
use \BrowserDetector\Detector\MatcherInterface;
use \BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use \BrowserDetector\Detector\MatcherInterface\OsInterface;
use \BrowserDetector\Detector\MatcherInterface\BrowserInterface;
use \BrowserDetector\Detector\EngineHandler;
use \BrowserDetector\Detector\Result;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class UserAgent extends Core
{
    /**
     * the detected browser
     *
     * @var Stdclass
     */
    private $browser = null;
    
    /**
     * the detected browser engine
     *
     * @var Stdclass
     */
    private $engine = null;
    
    /**
     * the detected platform
     *
     * @var Stdclass
     */
    private $os = null;
    
    /**
     * the detected device
     *
     * @var Stdclass
     */
    private $device = null;

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \BrowserDetector\Detector\Result
     */
    public function getBrowser()
    {
        $this->device = $this->_detectDevice();
        
        // detect the os which runs on the device
        $this->os = $this->device->detectOs();
        if (!($this->os instanceof OsInterface)) {
            $this->os = $this->_detectOs();
        }
        
        // detect the browser which is used
        $this->browser = $this->os->detectBrowser();
        
        if (!($this->browser instanceof BrowserInterface)) {
            $this->browser = $this->device->detectBrowser();
        }
        
        if (!($this->browser instanceof BrowserInterface)) {
            $this->browser = $this->_detectBrowser();
        }
        
        // detect the engine which is used in the browser
        $this->engine = $this->browser->detectEngine();
        if (!($this->engine instanceof EngineHandler)) {
            $this->engine = $this->_detectEngine();
        }
        
        $this->device->detectDependProperties(
            $this->browser, $this->engine, $this->os
        );
        
        $result = new Result();
        $result->setDetectionResult(
            $this->device, $this->os, $this->browser, $this->engine
        );
        $result->setCapability('useragent', $this->_agent);
        
        return $result;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @return 
     */
    private function _detectEngine()
    {
        $handlersToUse = array();
        
        $chain = new \BrowserDetector\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Engine');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \BrowserDetector\Detector\Engine\Unknown());
        
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
        
        $chain = new \BrowserDetector\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Browser');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \BrowserDetector\Detector\Browser\Unknown());
        
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
        
        $chain = new \BrowserDetector\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Os');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \BrowserDetector\Detector\Os\Unknown());
        
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
            new \BrowserDetector\Detector\Device\GeneralBot(),
            new \BrowserDetector\Detector\Device\GeneralMobile(),
            new \BrowserDetector\Detector\Device\GeneralTv(),
            new \BrowserDetector\Detector\Device\GeneralDesktop()
        );
        
        $chain = new \BrowserDetector\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Device');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \BrowserDetector\Detector\Device\Unknown());
        
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