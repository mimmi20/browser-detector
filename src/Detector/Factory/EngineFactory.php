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

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Browser\Chrome;
use BrowserDetector\Detector\Engine\BlackBerry;
use BrowserDetector\Detector\Engine\Blink;
use BrowserDetector\Detector\Engine\Edge;
use BrowserDetector\Detector\Engine\Gecko;
use BrowserDetector\Detector\Engine\Khtml;
use BrowserDetector\Detector\Engine\NetFront;
use BrowserDetector\Detector\Engine\Presto;
use BrowserDetector\Detector\Engine\T5;
use BrowserDetector\Detector\Engine\Tasman;
use BrowserDetector\Detector\Engine\Teleca;
use BrowserDetector\Detector\Engine\Trident;
use BrowserDetector\Detector\Engine\U2;
use BrowserDetector\Detector\Engine\U3;
use BrowserDetector\Detector\Engine\UnknownEngine;
use BrowserDetector\Detector\Engine\Webkit;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\Utils;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class EngineFactory
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $agent
     *
     * @return \BrowserDetector\Detector\MatcherInterface\EngineInterface
     */
    public static function detectEngine($agent)
    {
        $utils = new Utils();
        $utils->setUserAgent($agent);

        if ($utils->checkIfContains(array('Edge'))) {
            return new Edge();
        }

        if ($utils->checkIfContains(array('Presto', 'Opera'))) {
            return new Presto();
        }

        if ($utils->checkIfContainsAll(array('MSIE', 'Mac_PowerPC'))) {
            return new Tasman();
        }

        $trident = false;
        $doMatch = preg_match('/Trident\/([\d\.]+)/', $agent, $matches);

        if ($doMatch) {
            if (($matches[1] == 7 && $utils->checkIfContains('Gecko'))
                || ($matches[1] < 7 && !$utils->checkIfContains('Gecko'))
            ) {
                $trident = true;
            }
        } elseif ($utils->checkIfContains('Mozilla/')
            && $utils->checkIfContains(array('MSIE', 'Trident'))
        ) {
            $trident = true;
        }

        if ($trident) {
            return new Trident();
        }

        if ($utils->checkIfContains(array('U2/'))) {
            return new U2();
        }

        if ($utils->checkIfContains(array('U3/'))) {
            return new U3();
        }

        if ($utils->checkIfContains(array('T5/'))) {
            return new T5();
        }

        if ($utils->checkIfContains(array('AppleWebKit', 'WebKit', 'CFNetwork', 'Safari'))) {
            $chrome = new Chrome();
            $chrome->setUserAgent($agent);

            $chromeVersion = $chrome->detectVersion()->getVersion(Version::MAJORONLY);

            if ($chromeVersion >= 28) {
                return new Blink();
            }

            return new Webkit();
        }

        if ($utils->checkIfContainsAll(array('KHTML', 'Konqueror'))) {
            return new Khtml();
        }

        if ($utils->checkIfContains(array('Gecko', 'Firefox'))) {
            return new Gecko();
        }

        if ($utils->checkIfContains(array('NetFront/', 'NF/', 'NetFrontLifeBrowser/', 'NF3'))
            && !$utils->checkIfContains(array('Kindle'))
        ) {
            return new NetFront();
        }

        if ($utils->checkIfContains('BlackBerry')) {
            return new BlackBerry();
        }

        if ($utils->checkIfContains(array('Teleca', 'Obigo'))) {
            return new Teleca();
        }

        return new UnknownEngine();
    }
}
