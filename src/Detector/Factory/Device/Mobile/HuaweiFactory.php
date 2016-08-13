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

use BrowserDetector\Detector\Device\Mobile\Huawei;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class HuaweiFactory implements FactoryInterface
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
        if (preg_match('/Y530\-U00/i', $useragent)) {
            return new Huawei\HuaweiY530u00($useragent);
        }

        if (preg_match('/Y330\-U05/i', $useragent)) {
            return new Huawei\HuaweiY330u05($useragent);
        }

        if (preg_match('/Y330\-U01/i', $useragent)) {
            return new Huawei\HuaweiY330u01($useragent);
        }

        if (preg_match('/Y300/i', $useragent)) {
            return new Huawei\HuaweiY300($useragent);
        }

        if (preg_match('/W1\-U00/i', $useragent)) {
            return new Huawei\HuaweiW1u00($useragent);
        }

        if (preg_match('/Vodafone 858/i', $useragent)) {
            return new Huawei\HuaweiVodafone858($useragent);
        }

        if (preg_match('/Vodafone 845/i', $useragent)) {
            return new Huawei\HuaweiVodafone845($useragent);
        }

        if (preg_match('/U9510/i', $useragent)) {
            return new Huawei\HuaweiU9510($useragent);
        }

        if (preg_match('/U9508/i', $useragent)) {
            return new Huawei\HuaweiU9508($useragent);
        }

        if (preg_match('/U9200/i', $useragent)) {
            return new Huawei\HuaweiU9200($useragent);
        }

        if (preg_match('/U8950N/i', $useragent)) {
            return new Huawei\HuaweiU8950n($useragent);
        }

        if (preg_match('/U8950D/i', $useragent)) {
            return new Huawei\HuaweiU8950d($useragent);
        }

        if (preg_match('/U8950/i', $useragent)) {
            return new Huawei\HuaweiU8950($useragent);
        }

        if (preg_match('/U8860/i', $useragent)) {
            return new Huawei\HuaweiU8860($useragent);
        }

        if (preg_match('/U8850/i', $useragent)) {
            return new Huawei\HuaweiU8850($useragent);
        }

        if (preg_match('/U8825/i', $useragent)) {
            return new Huawei\HuaweiU8825($useragent);
        }

        if (preg_match('/U8815/i', $useragent)) {
            return new Huawei\HuaweiU8815($useragent);
        }

        if (preg_match('/u8800/i', $useragent)) {
            return new Huawei\HuaweiU8800($useragent);
        }

        if (preg_match('/U8666E/i', $useragent)) {
            return new Huawei\HuaweiU8666e($useragent);
        }

        if (preg_match('/U8666/i', $useragent)) {
            return new Huawei\HuaweiU8666($useragent);
        }

        if (preg_match('/U8655/i', $useragent)) {
            return new Huawei\HuaweiU8655($useragent);
        }

        if (preg_match('/U8651/i', $useragent)) {
            return new Huawei\HuaweiU8651($useragent);
        }

        if (preg_match('/U8650/i', $useragent)) {
            return new Huawei\HuaweiU8650($useragent);
        }

        if (preg_match('/U8600/i', $useragent)) {
            return new Huawei\HuaweiU8600($useragent);
        }

        if (preg_match('/U8520/i', $useragent)) {
            return new Huawei\HuaweiU8520($useragent);
        }

        if (preg_match('/U8510/i', $useragent)) {
            return new Huawei\HuaweiU8510($useragent);
        }

        if (preg_match('/U8500/i', $useragent)) {
            return new Huawei\HuaweiU8500($useragent);
        }

        if (preg_match('/U8350/i', $useragent)) {
            return new Huawei\HuaweiU8350($useragent);
        }

        if (preg_match('/U8185/i', $useragent)) {
            return new Huawei\HuaweiU8185($useragent);
        }

        if (preg_match('/U8180/i', $useragent)) {
            return new Huawei\HuaweiU8180($useragent);
        }

        if (preg_match('/(U8110|TSP21)/i', $useragent)) {
            return new Huawei\HuaweiU8110($useragent);
        }

        if (preg_match('/U8100/i', $useragent)) {
            return new Huawei\HuaweiU8100($useragent);
        }

        if (preg_match('/U7510/i', $useragent)) {
            return new Huawei\HuaweiU7510($useragent);
        }

        if (preg_match('/S8600/i', $useragent)) {
            return new Huawei\HuaweiS8600($useragent);
        }

        if (preg_match('/P6\-U06/i', $useragent)) {
            return new Huawei\HuaweiP6U06($useragent);
        }

        if (preg_match('/P6 S\-U06/i', $useragent)) {
            return new Huawei\HuaweiP6SU06($useragent);
        }

        if (preg_match('/MT7\-L09/i', $useragent)) {
            return new Huawei\HuaweiMt7L09($useragent);
        }

        if (preg_match('/MT2\-L01/i', $useragent)) {
            return new Huawei\HuaweiMt2L01($useragent);
        }

        if (preg_match('/MT1\-U06/i', $useragent)) {
            return new Huawei\HuaweiMt1U06($useragent);
        }

        if (preg_match('/MediaPad T1 8\.0/i', $useragent)) {
            return new Huawei\HuaweiMediaPadT180($useragent);
        }

        if (preg_match('/MediaPad M1 8\.0/i', $useragent)) {
            return new Huawei\HuaweiMediaPadM18($useragent);
        }

        if (preg_match('/mediapad 10 link\+/i', $useragent)) {
            return new Huawei\HuaweiMediaPad10LinkPlus($useragent);
        }

        if (preg_match('/mediapad 10 link/i', $useragent)) {
            return new Huawei\HuaweiMediaPad10Link($useragent);
        }

        if (preg_match('mMediapad 7 lite/i', $useragent)) {
            return new Huawei\HuaweiMediaPad7Lite($useragent);
        }

        if (preg_match('/mediapad 7 classic/i', $useragent)) {
            return new Huawei\HuaweiMediaPad7Classic($useragent);
        }

        if (preg_match('/mediapad/i', $useragent)) {
            return new Huawei\HuaweiMediaPad($useragent);
        }

        if (preg_match('/M860/i', $useragent)) {
            return new Huawei\HuaweiM860($useragent);
        }

        if (preg_match('/M635/i', $useragent)) {
            return new Huawei\HuaweiM635($useragent);
        }

        if (preg_match('/ideos s7 slim/i', $useragent)) {
            return new Huawei\HuaweiIdeosS7Slim($useragent);
        }

        if (preg_match('/ideos s7/i', $useragent)) {
            return new Huawei\HuaweiIdeosS7($useragent);
        }

        if (preg_match('/ideos /i', $useragent)) {
            return new Huawei\HuaweiIdeos($useragent);
        }

        if (preg_match('/g510\-0100/i', $useragent)) {
            return new Huawei\HuaweiG5100100($useragent);
        }

        if (preg_match('/g7300/i', $useragent)) {
            return new Huawei\HuaweiG7300($useragent);
        }

        if (preg_match('/g6609/i', $useragent)) {
            return new Huawei\HuaweiG6609($useragent);
        }

        if (preg_match('/g6600/i', $useragent)) {
            return new Huawei\HuaweiG6600($useragent);
        }

        if (preg_match('/g700\-u10/i', $useragent)) {
            return new Huawei\HuaweiG700U10($useragent);
        }

        if (preg_match('/g527\-u081/i', $useragent)) {
            return new Huawei\HuaweiG527u081($useragent);
        }

        if (preg_match('/g525\-u00/i', $useragent)) {
            return new Huawei\HuaweiG525U00($useragent);
        }

        if (preg_match('/g510/i', $useragent)) {
            return new Huawei\HuaweiG510($useragent);
        }

        return new Huawei\Huawei($useragent);
    }
}
