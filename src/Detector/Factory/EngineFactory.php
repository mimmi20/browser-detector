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
     * @param string                   $useragent
     * @param \UaResult\Os\OsInterface $os
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public static function detect($useragent, OsInterface $os = null)
    {
        $utils = new Utils();
        $utils->setUserAgent($useragent);

        if (null !== $os && in_array($os->getName(), ['iOS'])) {
            $engineName = new Engine\Webkit($useragent);
        } elseif ($utils->checkIfContains('Edge')) {
            $engineName = new Engine\Edge($useragent);
        } elseif ($utils->checkIfContains(' U2/')) {
            $engineName = new Engine\U2($useragent);
        } elseif ($utils->checkIfContains(' U3/')) {
            $engineName = new Engine\U3($useragent);
        } elseif ($utils->checkIfContains(' T5/')) {
            $engineName = new Engine\T5($useragent);
        } elseif (preg_match('/(msie|trident|outlook|kkman)/i', $useragent)
            && false === stripos($useragent, 'opera')
            && false === stripos($useragent, 'tasman')
        ) {
            $engineName = new Engine\Trident($useragent);
        } elseif (preg_match('/(goanna)/i', $useragent)) {
            $engineName = new Engine\Goanna($useragent);
        } elseif (preg_match('/(applewebkit|webkit|cfnetwork|safari|dalvik)/i', $useragent)) {
            $chrome = new Chrome($useragent);

            $chromeVersion = $chrome->getVersion()->getVersion(Version::MAJORONLY);

            if ($chromeVersion >= 28) {
                $engineName = new Engine\Blink($useragent);
            } else {
                $engineName = new Engine\Webkit($useragent);
            }
        } elseif (preg_match('/(KHTML|Konqueror)/', $useragent)) {
            $engineName = new Engine\Khtml($useragent);
        } elseif (preg_match('/(tasman)/i', $useragent)
            || $utils->checkIfContainsAll(['MSIE', 'Mac_PowerPC'])
        ) {
            $engineName = new Engine\Tasman($useragent);
        } elseif (preg_match('/(Presto|Opera)/', $useragent)) {
            $engineName = new Engine\Presto($useragent);
        } elseif (preg_match('/(Gecko|Firefox)/', $useragent)) {
            $engineName = new Engine\Gecko($useragent);
        } elseif (preg_match('/(NetFront\/|NF\/|NetFrontLifeBrowserInterface|NF3|Nintendo 3DS)/', $useragent)
            && !$utils->checkIfContains(['Kindle'])
        ) {
            $engineName = new Engine\NetFront($useragent);
        } elseif ($utils->checkIfContains('BlackBerry')) {
            $engineName = new Engine\BlackBerry($useragent);
        } elseif (preg_match('/(Teleca|Obigo)/', $useragent)) {
            $engineName = new Engine\Teleca($useragent);
        } else {
            $engineName = new Engine\UnknownEngine($useragent);
        }

        return $engineName;
    }
}
