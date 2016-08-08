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

use BrowserDetector\Detector\Version\Goanna;
use BrowserDetector\Detector\Version\Trident;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use UaHelper\Utils;
use UaResult\Browser\Browser;
use UaResult\Engine\Engine;
use UaResult\Os\OsInterface;
use UaBrowserType;

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
            return new Engine($useragent, 'WebKit', VersionFactory::detectVersion($useragent, ['AppleWebKit', 'WebKit', 'CFNetwork', 'Browser\/AppleWebKit']), CompanyFactory::get('Apple')->getName());
        } elseif ($utils->checkIfContains('Edge')) {
            return new Engine($useragent, 'Edge', VersionFactory::detectVersion($useragent, ['Edge']), CompanyFactory::get('Microsoft')->getName());
        } elseif ($utils->checkIfContains(' U2/')) {
            return new Engine($useragent, 'U2', VersionFactory::detectVersion($useragent, ['U2']), CompanyFactory::get('UcWeb')->getName());
        } elseif ($utils->checkIfContains(' U3/')) {
            return new Engine($useragent, 'U3', VersionFactory::detectVersion($useragent, ['U3']), CompanyFactory::get('UcWeb')->getName());
        } elseif ($utils->checkIfContains(' T5/')) {
            return new Engine($useragent, 'T5', VersionFactory::detectVersion($useragent, ['T5']), CompanyFactory::get('Baidu')->getName());
        } elseif (preg_match('/(msie|trident|outlook|kkman)/i', $useragent)
            && false === stripos($useragent, 'opera')
            && false === stripos($useragent, 'tasman')
        ) {
            return new Engine($useragent, 'Trident', Trident::detectVersion($useragent), CompanyFactory::get('Microsoft')->getName());
        } elseif (preg_match('/(goanna)/i', $useragent)) {
            return new Engine($useragent, 'Goanna', Goanna::detectVersion($useragent), CompanyFactory::get('MoonchildProductions')->getName());
        } elseif (preg_match('/(applewebkit|webkit|cfnetwork|safari|dalvik)/i', $useragent)) {
            $chrome = new Browser($useragent, 'Chrome', VersionFactory::detectVersion($useragent, ['Chrome', 'CrMo', 'CriOS']), 'Google', 0, new UaBrowserType\Browser(), true, false, true, true, true, true, true);

            $chromeVersion = $chrome->getVersion()->getVersion(Version::MAJORONLY);

            if ($chromeVersion >= 28) {
                return new Engine($useragent, 'Blink', VersionFactory::detectVersion($useragent, ['AppleWebKit', 'WebKit', 'CFNetwork', 'Browser\/AppleWebKit']), CompanyFactory::get('Google')->getName());
            } else {
                return new Engine($useragent, 'WebKit', VersionFactory::detectVersion($useragent, ['AppleWebKit', 'WebKit', 'CFNetwork', 'Browser\/AppleWebKit']), CompanyFactory::get('Apple')->getName());
            }
        } elseif (preg_match('/(KHTML|Konqueror)/', $useragent)) {
            return new Engine($useragent, 'KHTML', VersionFactory::detectVersion($useragent, ['KHTML']), CompanyFactory::get('Unknown')->getName());
        } elseif (preg_match('/(tasman)/i', $useragent)
            || $utils->checkIfContainsAll(['MSIE', 'Mac_PowerPC'])
        ) {
            return new Engine($useragent, 'Tasman', new Version(0), CompanyFactory::get('Apple')->getName());
        } elseif (preg_match('/(Presto|Opera)/', $useragent)) {
            return new Engine($useragent, 'Presto', VersionFactory::detectVersion($useragent, ['Presto']), CompanyFactory::get('Opera')->getName());
        } elseif (preg_match('/(Gecko|Firefox)/', $useragent)) {
            return new Engine($useragent, 'Gecko', VersionFactory::detectVersion($useragent, ['rv\:']), CompanyFactory::get('MozillaFoundation')->getName());
        } elseif (preg_match('/(NetFront\/|NF\/|NetFrontLifeBrowserInterface|NF3|Nintendo 3DS)/', $useragent)
            && !$utils->checkIfContains(['Kindle'])
        ) {
            return new Engine($useragent, 'NetFront', new Version(0), CompanyFactory::get('Access')->getName());
        } elseif ($utils->checkIfContains('BlackBerry')) {
            return new Engine($useragent, 'BlackBerry', new Version(0), CompanyFactory::get('Rim')->getName());
        } elseif (preg_match('/(Teleca|Obigo)/', $useragent)) {
            return new Engine($useragent, 'Teleca', new Version(0), CompanyFactory::get('Obigo')->getName());
        }

        return new Engine($useragent, 'unknown', new Version(0), CompanyFactory::get('Unknown')->getName());
    }
}
