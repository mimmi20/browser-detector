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
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\Result;
use BrowserDetector\Helper\InputMapper;

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
     * the UAParser class
     *
     * @var \UAParser\Parser
     */
    private $parser = null;

    /**
     * sets the UA Parser detector
     *
     * @var \UAParser\Parser $parser
     *
     * @return \BrowserDetector\Input\Uaparser
     */
    public function setParser(\UAParser\Parser $parser)
    {
        $this->parser = $parser;

        return $this;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @throws \UnexpectedValueException
     * @return \BrowserDetector\Detector\Result
     */
    public function getBrowser()
    {
        if (!($this->parser instanceof \UAParser\Parser)) {
            throw new \UnexpectedValueException(
                'the parser object has to be an instance of \\UAParser\\Parser'
            );
        }

        $parserResult = $this->initParser()->parse($this->_agent);

        $result = new Result();
        $result->setCapability('useragent', $this->_agent);

        $mapper = new InputMapper();

        $browserName    = $mapper->mapBrowserName($parserResult->ua->family);
        $browserVersion = $mapper->mapBrowserVersion($parserResult->ua->toVersionString, $browserName);

        $result->setCapability('mobile_browser', $browserName);
        $result->setCapability('mobile_browser_version', $browserVersion);

        $osName    = $mapper->mapOsName($parserResult->os->family);
        $osVersion = $mapper->mapOsVersion($parserResult->os->toVersionString, $osName);

        $result->setCapability('device_os', $osName);
        $result->setCapability('device_os_version', $osVersion);

        return $result;
    }

    /**
     * sets the main parameters to the parser
     *
     * @throws \UnexpectedValueException
     * @return \UA
     */
    private function initParser()
    {
        if (!($this->parser instanceof \UA)) {
            throw new \UnexpectedValueException(
                'the parser object has to be an instance of \\UA'
            );
        }

        return $this->parser;
    }
}
