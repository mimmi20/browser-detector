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
use \BrowserDetector\Detector\Version;
use \BrowserDetector\Detector\Company;
use \BrowserDetector\Helper\InputMapper;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class Uaparser extends Core
{
    /**
     * the detected browser
     *
     * @var Stdclass
     */
    private $_browser = null;
    
    /**
     * the detected browser engine
     *
     * @var Stdclass
     */
    private $_engine = null;
    
    /**
     * the detected platform
     *
     * @var Stdclass
     */
    private $_os = null;
    
    /**
     * the detected device
     *
     * @var Stdclass
     */
    private $_device = null;
    
    /**
     * the UAParser class
     *
     * @var \UAParser
     */
    private $_uaParser = null;
    
    /**
     * sets the UA Parser detector
     *
     * @var \UA $parser
     *
     * @return \BrowserDetector\Input\Uaparser
     */
    public function setParser(\UA $parser)
    {
        $this->_uaParser = $parser;
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Storage\Adapter\AbstractAdapter $cache
     *
     * @return \BrowserDetector\Input\Uaparser
     */
    public function setCache(\Zend\Cache\Storage\Adapter\AbstractAdapter $cache)
    {
        $this->cache = $cache;
        
        return $this;
    }

    /**
     * sets the the cache prfix
     *
     * @param string $prefix the new prefix
     *
     * @return \BrowserDetector\Input\Uaparser
     */
    public function setCachePrefix($prefix)
    {
        if (!is_string($prefix)) {
            throw new \UnexpectedValueException(
                'the cache prefix has to be a string'
            );
        }
        
        $this->cachePrefix = $prefix;
        
        return $this;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \BrowserDetector\Detector\Result
     */
    public function getBrowser()
    {
        if (!($this->_uaParser instanceof \UA)) {
            throw new \UnexpectedValueException(
                'the parser object has to be an instance of \\UA'
            );
        }
        
        $parserResult = $this->_uaParser->parse($this->_agent);
        
        $result = new Result();
        $result->setCapability('useragent', $this->_agent);
        
        $mapper = new InputMapper();
        
        $browserName    = $mapper->mapBrowserName($parserResult->ua->family);
        $browserVersion = $mapper->mapBrowserVersion($parserResult->ua->toVersionString, $browserName);
        
        $result->setCapability('mobile_browser', $browserName);
        // $result->setCapability('mobile_browser_version', $browserVersion);
        
        $osName    = $mapper->mapOsName($parserResult->os->family);
        $osVersion = $mapper->mapOsVersion($parserResult->os->toVersionString, $osName);
        
        $result->setCapability('device_os', $osName);
        $result->setCapability('device_os_version', $osVersion);
        
        return $result;
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
