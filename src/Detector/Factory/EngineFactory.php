<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Browser\Chrome;
use BrowserDetector\Detector\Engine;
use BrowserDetector\Version\Version;
use UaHelper\Utils;
use UaResult\Os\OsInterface;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class EngineFactory implements FactoryInterface
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string                   $agent
     * @param \UaResult\Os\OsInterface $os
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public static function detect($agent, OsInterface $os = null)
    {
        $utils = new Utils();
        $utils->setUserAgent($agent);

        if (null !== $os && in_array($os->getName(), ['iOS'])) {
            $engineName = new \BrowserDetector\Detector\Engine\Webkit($agent, []);
        } elseif ($utils->checkIfContains('Edge')) {
            $engineName = new \BrowserDetector\Detector\Engine\Edge($agent, []);
        } elseif ($utils->checkIfContains(' U2/')) {
            $engineName = new \BrowserDetector\Detector\Engine\U2($agent, []);
        } elseif ($utils->checkIfContains(' U3/')) {
            $engineName = new \BrowserDetector\Detector\Engine\U3($agent, []);
        } elseif ($utils->checkIfContains(' T5/')) {
            $engineName = new \BrowserDetector\Detector\Engine\T5($agent, []);
        } elseif (preg_match('/(msie|trident|outlook|kkman)/i', $agent)
            && false === stripos($agent, 'opera')
            && false === stripos($agent, 'tasman')
        ) {
            $engineName = new \BrowserDetector\Detector\Engine\Trident($agent, []);
        } elseif (preg_match('/(goanna)/i', $agent)) {
            $engineName = new \BrowserDetector\Detector\Engine\Goanna($agent, []);
        } elseif (preg_match('/(applewebkit|webkit|cfnetwork|safari|dalvik)/i', $agent)) {
            $chrome = new Chrome($agent, []);

            $chromeVersion = $chrome->getVersion()->getVersion(Version::MAJORONLY);

            if ($chromeVersion >= 28) {
                $engineName = new \BrowserDetector\Detector\Engine\Blink($agent, []);
            } else {
                $engineName = new \BrowserDetector\Detector\Engine\Webkit($agent, []);
            }
        } elseif (preg_match('/(KHTML|Konqueror)/', $agent)) {
            $engineName = new \BrowserDetector\Detector\Engine\Khtml($agent, []);
        } elseif (preg_match('/(tasman)/i', $agent)
            || $utils->checkIfContainsAll(['MSIE', 'Mac_PowerPC'])
        ) {
            $engineName = new \BrowserDetector\Detector\Engine\Tasman($agent, []);
        } elseif (preg_match('/(Presto|Opera)/', $agent)) {
            $engineName = new \BrowserDetector\Detector\Engine\Presto($agent, []);
        } elseif (preg_match('/(Gecko|Firefox)/', $agent)) {
            $engineName = new \BrowserDetector\Detector\Engine\Gecko($agent, []);
        } elseif (preg_match('/(NetFront\/|NF\/|NetFrontLifeBrowserInterface|NF3|Nintendo 3DS)/', $agent)
            && !$utils->checkIfContains(['Kindle'])
        ) {
            $engineName = new \BrowserDetector\Detector\Engine\NetFront($agent, []);
        } elseif ($utils->checkIfContains('BlackBerry')) {
            $engineName = new \BrowserDetector\Detector\Engine\BlackBerry($agent, []);
        } elseif (preg_match('/(Teleca|Obigo)/', $agent)) {
            $engineName = new \BrowserDetector\Detector\Engine\Teleca($agent, []);
        } else {
            $engineName = new \BrowserDetector\Detector\Engine\UnknownEngine($agent, []);
        }

        return $engineName;
    }
}
