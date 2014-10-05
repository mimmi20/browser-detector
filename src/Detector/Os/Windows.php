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

namespace BrowserDetector\Detector\Os;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface\MatcherInterface;
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
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
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
    public function detectVersion()
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
            case '6.4':
                $version = '10';
                break;
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
            case '6.4':
                $version = '10';
                break;
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