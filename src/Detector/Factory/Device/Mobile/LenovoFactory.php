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

use BrowserDetector\Detector\Device\Mobile\Lenovo;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class LenovoFactory implements FactoryInterface
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
        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000\-H/i', $useragent)) {
            return new Lenovo\LenovoS6000hIdeaTab($useragent, []);
        }

        if (preg_match('/S6000\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000fIdeaTab($useragent, []);
        }

        if (preg_match('/S5000\-H/i', $useragent)) {
            return new Lenovo\LenovoS5000h($useragent, []);
        }

        if (preg_match('/S5000\-F/i', $useragent)) {
            return new Lenovo\LenovoS5000f($useragent, []);
        }

        if (preg_match('/(IdeaTabS2110AF|IdeaTabS2110AH)/i', $useragent)) {
            return new Lenovo\LenovoS2110afIdeaTab($useragent, []);
        }

        if (preg_match('/S920\_ROW/i', $useragent)) {
            return new Lenovo\LenovoS920($useragent, []);
        }

        if (preg_match('/S880i/i', $useragent)) {
            return new Lenovo\LenovoS880i($useragent, []);
        }

        if (preg_match('/S820\_ROW/i', $useragent)) {
            return new Lenovo\LenovoS820row($useragent, []);
        }

        if (preg_match('/S660/i', $useragent)) {
            return new Lenovo\LenovoS660($useragent, []);
        }

        if (preg_match('/P780/i', $useragent)) {
            return new Lenovo\LenovoP780($useragent, []);
        }

        if (preg_match('/K910L/i', $useragent)) {
            return new Lenovo\LenovoK910l($useragent, []);
        }

        if (preg_match('/ K1/i', $useragent)) {
            return new Lenovo\LenovoIdeaPadK1($useragent, []);
        }

        if (preg_match('/IdeaPadA10/i', $useragent)) {
            return new Lenovo\LenovoIdeaPadA10($useragent, []);
        }

        if (preg_match('/A1\_07/i', $useragent)) {
            return new Lenovo\LenovoIdeaPadA1($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        if (preg_match('/S6000L\-F/i', $useragent)) {
            return new Lenovo\LenovoS6000lfIdeaTab($useragent, []);
        }

        return new Lenovo($useragent, []);
    }
}
