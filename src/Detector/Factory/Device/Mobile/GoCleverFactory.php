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

namespace BrowserDetector\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Device\Mobile\GoClever;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class GoCleverFactory implements FactoryInterface
{
    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public static function detect($useragent)
    {
        if (preg_match('/TQ700/', $useragent)) {
            return new GoClever\GoCleverTq700($useragent);
        }

        if (preg_match('/TERRA\_101/', $useragent)) {
            return new GoClever\GoCleverTerra101($useragent);
        }

        if (preg_match('/INSIGNIA\_785\_PRO/', $useragent)) {
            return new GoClever\GoCleverInsignia785Pro($useragent);
        }

        if (preg_match('/ARIES\_785/', $useragent)) {
            return new GoClever\GoCleverAries785($useragent);
        }

        if (preg_match('/ARIES\_101/', $useragent)) {
            return new GoClever\GoCleverAries101($useragent);
        }

        if (preg_match('/ORION7o/', $useragent)) {
            return new GoClever\GoCleverOrion7o($useragent);
        }

        if (preg_match('/QUANTUM 4/', $useragent)) {
            return new GoClever\GoCleverQuantum4($useragent);
        }

        if (preg_match('/TAB A93\.2/', $useragent)) {
            return new GoClever\GoCleverTabA932($useragent);
        }

        return new GoClever\GoClever($useragent);
    }
}
