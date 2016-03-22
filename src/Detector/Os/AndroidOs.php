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

namespace BrowserDetector\Detector\Os;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Version as ResultVersion;
use Version\Version;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AndroidOs extends AbstractOs
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
        $version         = $this->detectVersion();

        $this->setData(
            [
                'name'         => 'Android',
                'version'      => ($version === null ? new Version($version) : Version::parse($version)),
                'manufacturer' => (new Company\Google())->name,
                'bits'         => null,
            ]
        );
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return string|null
     */
    private function detectVersion()
    {
        if (false !== stripos($this->useragent, 'android 2.1-update1')) {
            return '2.1.1';
        }

        $detector = new ResultVersion();
        $detector->setUserAgent($this->useragent);

        $searches = [
            'Android android',
            'Android AndroidHouse Team',
            'Android WildPuzzleROM v8 froyo',
            'Android',
            'JUC\(Linux;U;',
            'Android OS',
        ];

        $detector->detectVersion($searches);

        if ($detector->getVersion()) {
            return $detector->getVersion();
        }

        if (false !== stripos($this->useragent, 'android eclair')) {
            return '2.1';
        }

        if (false !== stripos($this->useragent, 'gingerbread')) {
            return '2.3';
        }

        return '0.0';
    }
}
