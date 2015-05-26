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

use BrowserDetector\Detector\Engine;
use BrowserDetector\Detector\Browser\General\Chrome;
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
class EngineFactory implements FactoryInterface
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $agent
     *
     * @return \BrowserDetector\Detector\MatcherInterface\EngineInterface
     */
    public static function detect($agent)
    {
        $utils = new Utils();
        $utils->setUserAgent($agent);

        if ($utils->checkIfContains(array('Edge'))) {
            $engineKey = 'Edge';
        } elseif ($utils->checkIfContains(array('U2/'))) {
            $engineKey = 'U2';
        } elseif ($utils->checkIfContains(array('U3/'))) {
            $engineKey = 'U3';
        } elseif ($utils->checkIfContains(array('T5/'))) {
            $engineKey = 'T5';
        } elseif ($utils->checkIfContains(array('AppleWebKit', 'WebKit', 'CFNetwork', 'Safari'))) {
            $chrome = new Chrome();
            $chrome->setUserAgent($agent);

            $chromeVersion = $chrome->detectVersion()->getVersion(Version::MAJORONLY);

            if ($chromeVersion >= 28) {
                $engineKey = 'Blink';
            } else {
                $engineKey = 'WebKit';
            }
        } elseif ($utils->checkIfContainsAll(array('KHTML', 'Konqueror'))) {
            $engineKey = 'KHTML';
        } elseif ($utils->checkIfContainsAll(array('MSIE', 'Mac_PowerPC'))) {
            $engineKey = 'Tasman';
        } else {

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
                $engineKey = 'Trident';
            } elseif ($utils->checkIfContains(array('Presto', 'Opera'))) {
                $engineKey = 'Presto';
            } elseif ($utils->checkIfContains(array('Gecko', 'Firefox'))) {
                $engineKey = 'Gecko';
            } elseif ($utils->checkIfContains(
                    array('NetFront/', 'NF/', 'NetFrontLifeBrowser/', 'NF3')
                ) && !$utils->checkIfContains(array('Kindle'))
            ) {
                $engineKey = 'NetFront';
            } elseif ($utils->checkIfContains('BlackBerry')) {
                $engineKey = 'BlackBerry';
            } elseif ($utils->checkIfContains(array('Teleca', 'Obigo'))) {
                $engineKey = 'Teleca';
            } else {
                $engineKey = 'UnknownEngine';
            }
        }

        $allEnginesProperties = require 'data/properties/engines.php';

        if (!isset($allEnginesProperties[$engineKey])) {
            $engineKey = 'UnknownEngine';
        }

        $engineProperties = $allEnginesProperties[$engineKey];
        $manufacturerName = '\\Detector\\Company\\' . $engineProperties['company'];
        $company          = new $manufacturerName();

        $detector = new Version();
        $detector->setUserAgent($agent);

        if (isset($engineProperties['version'])) {
            $detector->detectVersion($engineProperties['version']);
        } else {
            $detector->setVersion('0.0');
        }

        return new Engine($engineProperties['name'], $company, $detector, $engineProperties['properties']);
    }
}
