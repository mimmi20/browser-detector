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

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\OsInterface;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\Windows as WindowsHelper;

/**
 * MSIEAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class Windows
    extends OsHandler
    implements OsInterface
{
    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        $windowsHelper = new WindowsHelper();
        $windowsHelper->setUserAgent($this->_useragent);

        if ($windowsHelper->isMobileWindows()) {
            return false;
        }

        if (!$windowsHelper->isWindows()) {
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
        return 'Windows';
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
        $detector->setMode(Version::COMPLETE | Version::IGNORE_MINOR);

        if ($this->utils->checkIfContains(array('win9x/NT 4.90', 'Win 9x 4.90'))) {
            return $detector->setVersion('ME');
        }

        if ($this->utils->checkIfContains(array('Win98'))) {
            return $detector->setVersion('98');
        }

        if ($this->utils->checkIfContains(array('Win95'))) {
            return $detector->setVersion('95');
        }

        if ($this->utils->checkIfContains(array('Windows NT 6.3; ARM;'))) {
            return $detector->setVersion('RT 8.1');
        }

        if ($this->utils->checkIfContains(array('Windows NT 6.2; ARM;'))) {
            return $detector->setVersion('RT 8');
        }

        if ($this->utils->checkIfContains(array('Windows-NT'))) {
            return $detector->setVersion('NT');
        }

        $doMatch = preg_match('/Windows NT ([\d\.]+)/', $this->_useragent, $matches);

        if ($doMatch) {
            switch ($matches[1]) {
            case '6.3':
                $version = '8.1';
                break;
            case '6.2':
                $version = '8';
                break;
            case '6.1':
                $version = '7';
                break;
            case '6.0':
                $version = 'Vista';
                break;
            case '5.3':
            case '5.2':
            case '5.1':
                $version = 'XP';
                break;
            case '5.0':
            case '5.01':
                $version = '2000';
                break;
            case '4.1':
            case '4.0':
                $version = 'NT';
                break;
            default:
                $version = '';
                break;
            }

            return $detector->setVersion($version);
        }

        $doMatch = preg_match('/Windows ([\d\.a-zA-Z]+)/', $this->_useragent, $matches);

        if ($doMatch) {
            switch ($matches[1]) {
            case '6.3':
                $version = '8.1';
                break;
            case '6.2':
                $version = '8';
                break;
            case '6.1':
            case '7':
                $version = '7';
                break;
            case '6.0':
                $version = 'Vista';
                break;
            case '2003':
                $version = 'Server 2003';
                break;
            case '5.3':
            case '5.2':
            case '5.1':
            case 'XP':
                $version = 'XP';
                break;
            case 'ME':
                $version = 'ME';
                break;
            case '2000':
            case '5.0':
            case '5.01':
                $version = '2000';
                break;
            case '3.1':
                $version = '3.1';
                break;
            case '95':
                $version = '95';
                break;
            case '98':
                $version = '98';
                break;
            case '4.1':
            case '4.0':
                $version = 'NT';
                break;
            default:
                $version = '';
                break;
            }

            return $detector->setVersion($version);
        }

        return $detector->setVersion('');
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Microsoft();
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 817419325;
    }
}