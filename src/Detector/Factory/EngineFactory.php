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
            return new Engine\Webkit($useragent);
        }

        if ($utils->checkIfContains('Edge')) {
            return new Engine\Edge($useragent);
        }

        if ($utils->checkIfContains(' U2/')) {
            return new Engine\U2($useragent);
        }

        if ($utils->checkIfContains(' U3/')) {
            return new Engine\U3($useragent);
        }

        if ($utils->checkIfContains(' T5/')) {
            return new Engine\T5($useragent);
        }

        if (preg_match('/(msie|trident|outlook|kkman)/i', $useragent)
            && false === stripos($useragent, 'opera')
            && false === stripos($useragent, 'tasman')
        ) {
            return new Engine\Trident($useragent);
        }

        if (preg_match('/(goanna)/i', $useragent)) {
            return new Engine\Goanna($useragent);
        }

        if (preg_match('/(applewebkit|webkit|cfnetwork|safari|dalvik)/i', $useragent)) {
            $chrome  = new Chrome($useragent);
            $version = $chrome->getVersion();

            if (null !== $version) {
                $chromeVersion = $version->getVersion(Version::MAJORONLY);
            } else {
                $chromeVersion = 0;
            }

            if ($chromeVersion >= 28) {
                return new Engine\Blink($useragent);
            }

            return new Engine\Webkit($useragent);
        }

        if (preg_match('/(KHTML|Konqueror)/', $useragent)) {
            return new Engine\Khtml($useragent);
        }

        if (preg_match('/(tasman)/i', $useragent)
            || $utils->checkIfContainsAll(['MSIE', 'Mac_PowerPC'])
        ) {
            return new Engine\Tasman($useragent);
        }

        if (preg_match('/(Presto|Opera)/', $useragent)) {
            return new Engine\Presto($useragent);
        }

        if (preg_match('/(Gecko|Firefox)/', $useragent)) {
            return new Engine\Gecko($useragent);
        }

        if (preg_match('/(NetFront\/|NF\/|NetFrontLifeBrowserInterface|NF3|Nintendo 3DS)/', $useragent)
            && !$utils->checkIfContains(['Kindle'])
        ) {
            return new Engine\NetFront($useragent);
        }

        if ($utils->checkIfContains('BlackBerry')) {
            return new Engine\BlackBerry($useragent);
        }

        if (preg_match('/(Teleca|Obigo)/', $useragent)) {
            return new Engine\Teleca($useragent);
        }

        return new Engine\UnknownEngine($useragent);
    }
}
