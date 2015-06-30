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
use BrowserDetector\Detector\Engine;
use BrowserDetector\Detector\Platform;
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
     * @param string                             $agent
     * @param \BrowserDetector\Detector\Platform $os
     *
     * @return \BrowserDetector\Detector\Engine
     */
    public static function detect($agent, Platform $os = null)
    {
        $utils = new Utils();
        $utils->setUserAgent($agent);

        if (null !== $os && in_array($os->getName(), array('iOS'))) {
            $engineKey = 'WebKit';
        } elseif ($utils->checkIfContains('Edge')) {
            $engineKey = 'Edge';
        } elseif ($utils->checkIfContains('U2/') && !$utils->checkIfContains('AskTbATU2')) {
            $engineKey = 'U2';
        } elseif ($utils->checkIfContains('U3/')) {
            $engineKey = 'U3';
        } elseif ($utils->checkIfContains('T5/')) {
            $engineKey = 'T5';
        } elseif (preg_match('/(msie|trident|outlook|kkman)/i', $agent)
            && false === stripos($agent, 'opera')
            && false === stripos($agent, 'tasman')
        ) {
            $engineKey = 'Trident';
        } elseif (preg_match('/(applewebkit|webkit|cfnetwork|safari|dalvik)/i', $agent)) {
            $chrome = new Chrome();
            $chrome->setUserAgent($agent);

            $chromeVersion = $chrome->detectVersion()->getVersion(Version::MAJORONLY);

            if ($chromeVersion >= 28) {
                $engineKey = 'Blink';
            } else {
                $engineKey = 'WebKit';
            }
        } elseif (preg_match('/(KHTML|Konqueror)/', $agent)) {
            $engineKey = 'KHTML';
        } elseif (preg_match('/(tasman)/i', $agent)
            || $utils->checkIfContainsAll(array('MSIE', 'Mac_PowerPC'))
        ) {
            $engineKey = 'Tasman';
        } elseif (preg_match('/(Presto|Opera)/', $agent)) {
            $engineKey = 'Presto';
        } elseif (preg_match('/(Gecko|Firefox)/', $agent)) {
            $engineKey = 'Gecko';
        } elseif (preg_match('/(NetFront\/|NF\/|NetFrontLifeBrowser|NF3|Nintendo 3DS)/', $agent)
            && !$utils->checkIfContains(array('Kindle'))
        ) {
            $engineKey = 'NetFront';
        } elseif ($utils->checkIfContains('BlackBerry')) {
            $engineKey = 'BlackBerry';
        } elseif (preg_match('/(Teleca|Obigo)/', $agent)) {
            $engineKey = 'Teleca';
        } else {
            $engineKey = 'UnknownEngine';
        }

        $allEnginesProperties = require __DIR__ . '/../../../data/properties/engines.php';

        if (!isset($allEnginesProperties[$engineKey])) {
            $engineKey = 'UnknownEngine';
        }

        $engineProperties = $allEnginesProperties[$engineKey];
        $manufacturerName = '\\BrowserDetector\\Detector\\Company\\' . $engineProperties['company'];
        $company          = new $manufacturerName();

        $detector = new Version();
        $detector->setUserAgent($agent);

        if (isset($engineProperties['version'])) {
            $detector->detectVersion($engineProperties['version']);
        } else {
            $detector->setVersion('0.0');
        }

        return new Engine(
            $engineProperties['name'],
            $company,
            $detector,
            $engineProperties['transcoder'],
            $engineProperties['properties']
        );
    }
}
