<?php
namespace BrowserDetector\Detector\Os;

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
 */

use BrowserDetector\Detector\Browser\Mobile\Android;
use BrowserDetector\Detector\Browser\Mobile\Chrome;
use BrowserDetector\Detector\Browser\Mobile\OperaMobile;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\OsInterface;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Version;

/**
 * MSIEAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class Maemo
    extends OsHandler
    implements MatcherInterface, OsInterface
{
    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains(array('maemo', 'linux armv', 'like android', 'linux/x2/r1'), true)) {
            return false;
        }

        return true;
    }

    /**
     * returns the name of the operating system/platform
     *
     * @return string
     */
    public function getName()
    {
        return 'Linux Smartphone OS (Maemo)';
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function getVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->_useragent);

        $searches = array('Maemo');

        return $detector->detectVersion($searches);
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Unknown();
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 9342;
    }

    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\BrowserHandler
     */
    public function detectBrowser()
    {
        $browsers = array(
            new Android(),
            new Chrome(),
            new OperaMobile(),
        );

        $chain = new Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }
}