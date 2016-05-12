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

namespace BrowserDetector\Detector\Browser;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Engine;
use BrowserDetector\Helper\Safari as SafariHelper;
use BrowserDetector\Matcher\Browser\BrowserHasSpecificEngineInterface;
use BrowserDetector\Version\VersionFactory;
use UaBrowserType;
use UaHelper\Utils;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AndroidWebkit extends AbstractBrowser implements BrowserHasSpecificEngineInterface
{
    /**
     * Class Constructor
     *
     * @param string $useragent the user agent to be handled
     * @param array  $data
     */
    public function __construct(
        $useragent,
        array $data
    ) {
        $this->useragent = $useragent;

        $this->setData(
            [
                'name'                        => 'Android Webkit',
                'modus'                       => null,
                'version'                     => $this->detectVersion(),
                'manufacturer'                => (new Company\Google())->name,
                'pdfSupport'                  => true,
                'rssSupport'                  => false,
                'canSkipAlignedLinkRow'       => true,
                'claimsWebSupport'            => true,
                'supportsEmptyOptionValues'   => true,
                'supportsBasicAuthentication' => true,
                'supportsPostMethod'          => true,
                'bits'                        => null,
                'type'                        => new UaBrowserType\Browser(),
            ]
        );
    }

    /**
     * detects the browser version from the given user agent
     *
     * @return \BrowserDetector\Version\Version
     */
    private function detectVersion()
    {
        $safariHelper = new SafariHelper($this->useragent);

        $doMatch = preg_match(
            '/Version\/([\d\.]+)/',
            $this->useragent,
            $matches
        );

        if ($doMatch) {
            return $safariHelper->mapSafariVersions($matches[1]);
        }

        $utils = new Utils();
        $utils->setUserAgent($this->useragent);

        if ($utils->checkIfContains('android eclair', true)) {
            return '2.1';
        }

        if ($utils->checkIfContains('gingerbread', true)) {
            return '2.3';
        }

        $doMatch = preg_match(
            '/Safari\/([\d\.]+)/',
            $this->useragent,
            $matches
        );

        if ($doMatch) {
            return $safariHelper->mapSafariVersions($matches[1]);
        }

        $doMatch = preg_match(
            '/AppleWebKit\/([\d\.]+)/',
            $this->useragent,
            $matches
        );

        if ($doMatch) {
            return $safariHelper->mapSafariVersions($matches[1]);
        }

        $doMatch = preg_match(
            '/MobileSafari\/([\d\.]+)/',
            $this->useragent,
            $matches
        );

        if ($doMatch) {
            return $safariHelper->mapSafariVersions($matches[1]);
        }

        $doMatch = preg_match(
            '/Android\/([\d\.]+)/',
            $this->useragent,
            $matches
        );

        if ($doMatch) {
            return $matches[1];
        }

        $searches = ['Version', 'Safari', 'JUC \(Linux\; U\;'];

        return VersionFactory::detectVersion($this->useragent, $searches);
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\Engine\UnknownEngine
     */
    public function getEngine()
    {
        return new Engine\Webkit($this->useragent, []);
    }
}
