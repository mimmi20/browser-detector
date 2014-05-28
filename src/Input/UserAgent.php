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
 */
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Device\GeneralBot;
use BrowserDetector\Detector\Device\GeneralDesktop;
use BrowserDetector\Detector\Device\GeneralMobile;
use BrowserDetector\Detector\Device\GeneralTv;
use BrowserDetector\Detector\Device\UnknownDevice;
use BrowserDetector\Detector\Engine\UnknownEngine;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface\BrowserInterface;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\OsInterface;
use BrowserDetector\Detector\Os\UnknownOs;
use BrowserDetector\Detector\Result;

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
     * @var \BrowserDetector\Detector\BrowserHandler
     */
    private $browser = null;

    /**
     * the detected browser engine
     *
     * @var \BrowserDetector\Detector\EngineHandler
     */
    private $engine = null;

    /**
     * the detected platform
     *
     * @var \BrowserDetector\Detector\OsHandler
     */
    private $os = null;

    /**
     * the detected device
     *
     * @var MatcherInterface\DeviceInterface
     */
    private $device = null;

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \BrowserDetector\Detector\Result
     */
    public function getBrowser()
    {
        $this->device = $this->detectDevice();
        $this->device->detectSpecialProperties();

        // detect the os which runs on the device
        $this->os = $this->device->detectOs();
        if (!($this->os instanceof OsInterface)) {
            $this->os = $this->detectOs();
        }

        // detect the browser which is used
        $this->browser = $this->os->detectBrowser();

        if (!($this->browser instanceof BrowserInterface)
            || ($this->os instanceof UnknownOs
                && is_callable(array($this->device, 'detectBrowser')))
        ) {
            $this->browser = $this->device->detectBrowser();
        }

        if (!($this->browser instanceof BrowserInterface)) {
            $this->browser = $this->detectBrowser();
        }

        // detect the engine which is used in the browser
        $this->engine = $this->browser->detectEngine();
        if (!($this->engine instanceof EngineHandler)) {
            $this->engine = $this->detectEngine();
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
     * @return string
     */
    private function detectEngine()
    {
        $handlersToUse = array();

        $chain = new Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Engine');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new UnknownEngine());

        return $chain->detect();
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \BrowserDetector\Detector\BrowserHandler
     */
    private function detectBrowser()
    {
        $handlersToUse = array();

        $chain = new Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Browser');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }

    /**
     * Gets the information about the os by User Agent
     *
     * @return string
     */
    private function detectOs()
    {
        $handlersToUse = array();

        $chain = new Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Os');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new UnknownOs());

        return $chain->detect();
    }

    /**
     * Gets the information about the device by User Agent
     *
     * @return MatcherInterface\DeviceInterface
     */
    private function detectDevice()
    {
        $handlersToUse = array(
            new GeneralBot(),
            new GeneralMobile(),
            new GeneralTv(),
            new GeneralDesktop()
        );

        $chain = new Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Device');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new UnknownDevice());

        $device = $chain->detect();
        
        if ($device instanceof DeviceHasChildrenInterface) {
            $device = $device->detectDevice();
        }
        
        return $device;
    }
}