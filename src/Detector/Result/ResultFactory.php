<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Result;

use BrowserDetector\Detector\Company;
use BrowserDetector\Matcher\Browser\BrowserHasWurflKeyInterface;
use BrowserDetector\Matcher\Device\DeviceHasWurflKeyInterface;
use Psr\Log\LoggerInterface;
use UaResult\Browser\BrowserInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Engine\EngineInterface;
use UaResult\Os\OsInterface;
use UaResult\Result\Result;
use UaResult\Result\ResultFactoryInterface;
use Wurfl\WurflConstants;

/**
 * Factory to build the detection result
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ResultFactory implements ResultFactoryInterface
{
    /**
     * builds the result object and set the values
     *
     * @param string                             $useragent
     * @param \Psr\Log\LoggerInterface           $logger
     * @param \UaResult\Device\DeviceInterface   $device
     * @param \UaResult\Os\OsInterface           $os
     * @param \UaResult\Browser\BrowserInterface $browser
     * @param \UaResult\Engine\EngineInterface   $engine
     *
     * @return \UaResult\Result\ResultInterface
     */
    public static function build(
        $useragent,
        LoggerInterface $logger = null,
        DeviceInterface $device = null,
        OsInterface $os = null,
        BrowserInterface $browser = null,
        EngineInterface $engine = null
    ) {
        if ($device->getType()->isMobile() && $device instanceof DeviceHasWurflKeyInterface) {
            $wurflKey = $device->getWurflKey($browser, $engine, $os);
        } elseif (!$device->getType()->isMobile() && $browser instanceof BrowserHasWurflKeyInterface) {
            $wurflKey = $browser->getWurflKey($os);
        } else {
            $wurflKey = WurflConstants::NO_MATCH;
        }

        $result = new Result($useragent, $device, $os, $browser, $engine, [], $wurflKey);

        return $result;
    }
}
