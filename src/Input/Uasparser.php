<?php
/**
 * Copyright (c) 2012-2014, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Input;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Result;
use BrowserDetector\Detector\Type;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\InputMapper;
use UAS\Parser;
use UnexpectedValueException;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Uasparser extends Core
{
    /**
     * the UAParser class
     *
     * @var \UASparser
     */
    private $parser = null;

    /**
     * sets the UAS Parser detector
     *
     * @var Parser $parser
     *
     * @return Uasparser
     */
    public function setParser(Parser $parser)
    {
        $this->parser = $parser;

        return $this;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @throws UnexpectedValueException
     * @return Result
     */
    public function getBrowser()
    {
        $parserResult = $this->initParser()->Parse($this->_agent);

        $result = new Result();
        $result->setCapability('useragent', $this->_agent);

        $mapper = new InputMapper();

        $browserName    = $mapper->mapBrowserName($parserResult['ua_family']);
        $browserType    = $mapper->mapBrowserType($parserResult['typ'], $browserName);
        $browserVersion = $mapper->mapBrowserVersion($parserResult['ua_version'], $browserName);
        $browserMaker   = $mapper->mapBrowserMaker($parserResult['ua_company'], $browserName);

        $result->setCapability('browser_type', $browserType->getName());
        $result->setCapability('is_bot', $browserType->isBot());
        $result->setCapability('is_transcoder', $browserType->isTranscoder());
        $result->setCapability('is_syndication_reader', $browserType->isSyndicationReader());
        $result->setCapability('is_banned', $browserType->isBanned());
        $result->setCapability('mobile_browser', $browserName);
        $result->setCapability('mobile_browser_manufacturer', $browserMaker);
        $result->setCapability('mobile_browser_version', $browserVersion);

        $osName    = $mapper->mapOsName($parserResult['os_family']);
        $osVersion = null;
        $osMaker   = $mapper->mapOsMaker($parserResult['os_company'], $osName);

        $result->setCapability('device_os', $osName);

        $version = new Version();
        $version->setMode(
            Version::COMPLETE
            | Version::IGNORE_MINOR_IF_EMPTY
            | Version::IGNORE_MICRO_IF_EMPTY
        );

        $result->setCapability(
            'device_os_version', $version->setVersion($osVersion)
        );
        $result->setCapability('device_os_manufacturer', $osMaker);

        return $result;
    }

    /**
     * sets the main parameters to the parser
     *
     * @throws UnexpectedValueException
     * @return Parser
     */
    private function initParser()
    {
        if (!($this->parser instanceof Parser)) {
            throw new UnexpectedValueException(
                'the parser object has to be an instance of \\UAS\\Parser'
            );
        }

        return $this->parser;
    }
}
