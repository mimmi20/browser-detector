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

use Psr\Log\LoggerInterface;
use UaMatcher\Browser\BrowserInterface;
use UaMatcher\Device\DeviceInterface;
use UaMatcher\Engine\EngineInterface;
use UaMatcher\Os\OsInterface;
use Wurfl\WurflConstants;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @property-read $id
 * @property-read $userAgent
 */
interface ResultInterface extends \UaMatcher\Result\ResultInterface
{
    /**
     * the class constructor
     *
     * @param string                              $userAgent
     * @param \Psr\Log\LoggerInterface            $logger
     * @param string|null                         $wurflKey
     * @param \UaMatcher\Device\DeviceInterface   $device
     * @param \UaMatcher\Os\OsInterface           $os
     * @param \UaMatcher\Browser\BrowserInterface $browser
     * @param \UaMatcher\Engine\EngineInterface   $engine
     */
    public function __construct(
        $userAgent,
        LoggerInterface $logger,
        $wurflKey = WurflConstants::NO_MATCH,
        DeviceInterface $device = null,
        OsInterface $os = null,
        BrowserInterface $browser = null,
        EngineInterface $engine = null
    );

    /**
     * returns a second device for rendering properties
     *
     * @return \BrowserDetector\Detector\Result\ResultInterface
     */
    public function getRenderAs();

    /**
     * sets a second device for rendering properties
     *
     * @var \BrowserDetector\Detector\Result\ResultInterface
     *
     * @return DeviceInterface
     */
    public function setRenderAs(ResultInterface $result);
}
