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

use BrowserDetector\Detector\Device\Mobile\Alcatel;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AlcatelFactory implements FactoryInterface
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
        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)8008D/i', $useragent)) {
            return new Alcatel\AlcatelOt8008D($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7047D/i', $useragent)) {
            return new Alcatel\AlcatelOt7047d($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7025D/i', $useragent)) {
            return new Alcatel\AlcatelOt7025d($useragent, []);
        }

        if (preg_match('/6036Y/i', $useragent)) {
            return new Alcatel\AlcatelOt6036Y($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6033X/i', $useragent)) {
            return new Alcatel\AlcatelOt6033X($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6030X/i', $useragent)) {
            return new Alcatel\AlcatelOt6030X($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6030D/i', $useragent)) {
            return new Alcatel\AlcatelOt6030D($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6012D/i', $useragent)) {
            return new Alcatel\AlcatelOt6012D($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6010D/i', $useragent)) {
            return new Alcatel\AlcatelOt6010D($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)5035D/i', $useragent)) {
            return new Alcatel\AlcatelOt5035D($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)5020D/i', $useragent)) {
            return new Alcatel\AlcatelOt5020D($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4037T/i', $useragent)) {
            return new Alcatel\AlcatelOt4037T($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4030X/i', $useragent)) {
            return new Alcatel\AlcatelOt4030X($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4030D/i', $useragent)) {
            return new Alcatel\AlcatelOt4030D($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4012X/i', $useragent)) {
            return new Alcatel\AlcatelOt4012X($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4012A/i', $useragent)) {
            return new Alcatel\AlcatelOt4012A($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)997d/i', $useragent)) {
            return new Alcatel\AlcatelOt997d($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)995/i', $useragent)) {
            return new Alcatel\AlcatelOt995($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)992D/i', $useragent)) {
            return new Alcatel\AlcatelOt992d($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991T/i', $useragent)) {
            return new Alcatel\AlcatelOt991t($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991D/i', $useragent)) {
            return new Alcatel\AlcatelOt991d($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991/i', $useragent)) {
            return new Alcatel\AlcatelOt991($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)990/i', $useragent)) {
            return new Alcatel\AlcatelOt990($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)980/i', $useragent)) {
            return new Alcatel\AlcatelOt980($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)918D/i', $useragent)) {
            return new Alcatel\AlcatelOt918d($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)918/i', $useragent)) {
            return new Alcatel\AlcatelOt918($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)908/i', $useragent)) {
            return new Alcatel\AlcatelOt908($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)903D/i', $useragent)) {
            return new Alcatel\AlcatelOt903d($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)890D/i', $useragent)) {
            return new Alcatel\AlcatelOt890d($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)890/i', $useragent)) {
            return new Alcatel\AlcatelOt890($useragent, []);
        }

        if (preg_match('/OT871A/', $useragent)) {
            return new Alcatel\AlcatelOt871A($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)818/i', $useragent)) {
            return new Alcatel\AlcatelOt818($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)710D/i', $useragent)) {
            return new Alcatel\AlcatelOt710D($useragent, []);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)216/i', $useragent)) {
            return new Alcatel\AlcatelOt216($useragent, []);
        }

        if (preg_match('/Vodafone 975N/', $useragent)) {
            return new Alcatel\Vodafone975n($useragent, []);
        }

        if (preg_match('/(V860|Vodafone Smart II)/', $useragent)) {
            return new Alcatel\V860($useragent, []);
        }

        if (preg_match('/P320X/', $useragent)) {
            return new Alcatel\AlcatelP320x($useragent, []);
        }

        if (preg_match('/P310X/', $useragent)) {
            return new Alcatel\AlcatelP310x($useragent, []);
        }

        if (preg_match('/ONE TOUCH TAB 7HD/', $useragent)) {
            return new Alcatel\AlcatelOtTab7hd($useragent, []);
        }

        return new Alcatel\Alcatel($useragent, []);
    }
}
