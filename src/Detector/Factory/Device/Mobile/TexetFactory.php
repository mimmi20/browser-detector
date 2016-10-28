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

use BrowserDetector\Detector\Device\Mobile\Texet;
use BrowserDetector\Detector\Factory\DeviceFactory;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class TexetFactory implements FactoryInterface
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
        if (preg_match('/x\-pad ix 7 3g/i', $useragent)) {
            $deviceCode = 'tm-7068';
        }

        if (preg_match('/x\-pad lite 7\.1/i', $useragent)) {
            $deviceCode = 'tm-7066';
        }

        if (preg_match('/x\-pad style 7\.1 3g/i', $useragent)) {
            $deviceCode = 'tm-7058';
        }

        if (preg_match('/x\-navi/i', $useragent)) {
            $deviceCode = 'tm-4672';
        }

        if (preg_match('/tm\-3204r/i', $useragent)) {
            $deviceCode = 'tm-3204r';
        }

        if (preg_match('/tm\-7055hd/i', $useragent)) {
            $deviceCode = 'tm-7055hd';
        }

        if (preg_match('/tm\-7058hd/i', $useragent)) {
            $deviceCode = 'tm-7058hd';
        }

        if (preg_match('/tm\-7058/i', $useragent)) {
            $deviceCode = 'tm-7058';
        }

        if (preg_match('/tm\-5204/i', $useragent)) {
            $deviceCode = 'tm-5204';
        }

        $deviceCode = 'general texet device';

        return DeviceFactory::get($deviceCode, $useragent);
    }
}
