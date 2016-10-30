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

namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AlcatelFactory implements Factory\FactoryInterface
{
    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function detect($useragent)
    {
        $deviceCode = 'general alcatel device';

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)8008d/i', $useragent)) {
            $deviceCode = 'ot-8008d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)8000d/i', $useragent)) {
            $deviceCode = 'ot-8000d';
        }

        if (preg_match('/7049d/i', $useragent)) {
            $deviceCode = 'ot-7049d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7047d/i', $useragent)) {
            $deviceCode = 'ot-7047d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7041x/i', $useragent)) {
            $deviceCode = 'ot-7041x';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7041d/i', $useragent)) {
            $deviceCode = 'ot-7041d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7025d/i', $useragent)) {
            $deviceCode = 'ot-7025d';
        }

        if (preg_match('/6050a/i', $useragent)) {
            $deviceCode = 'ot-6050a';
        }

        if (preg_match('/6043d/i', $useragent)) {
            $deviceCode = 'ot-6043d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6040d/i', $useragent)) {
            $deviceCode = 'ot-6040d';
        }

        if (preg_match('/6036y/i', $useragent)) {
            $deviceCode = 'ot-6036y';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6035r/i', $useragent)) {
            $deviceCode = 'ot-6035r';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6034r/i', $useragent)) {
            $deviceCode = 'ot-6034r';
        }

        if (preg_match('/4034d/i', $useragent)) {
            $deviceCode = 'ot-4034d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6033x/i', $useragent)) {
            $deviceCode = 'ot-6033x';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6032/i', $useragent)) {
            $deviceCode = 'ot-6032';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6030x/i', $useragent)) {
            $deviceCode = 'ot-6030x';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6030d/i', $useragent)) {
            $deviceCode = 'ot-6030d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6015x/i', $useragent)) {
            $deviceCode = 'ot-6015x';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6012d/i', $useragent)) {
            $deviceCode = 'ot-6012d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6010x/i', $useragent)) {
            $deviceCode = 'ot-6010x';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6010d/i', $useragent)) {
            $deviceCode = 'ot-6010d';
        }

        if (preg_match('/5042d/i', $useragent)) {
            $deviceCode = 'ot-5042d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)5036d/i', $useragent)) {
            $deviceCode = 'ot-5036d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)5035d/i', $useragent)) {
            $deviceCode = 'ot-5035d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)5020d/i', $useragent)) {
            $deviceCode = 'ot-5020d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4037t/i', $useragent)) {
            $deviceCode = 'ot-4037t';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4030x/i', $useragent)) {
            $deviceCode = 'ot-4030x';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4030d/i', $useragent)) {
            $deviceCode = 'ot-4030d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4015x/i', $useragent)) {
            $deviceCode = 'ot-4015x';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4015d/i', $useragent)) {
            $deviceCode = 'ot-4015d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4012x/i', $useragent)) {
            $deviceCode = 'ot-4012x';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4012a/i', $useragent)) {
            $deviceCode = 'ot-4012a';
        }

        if (preg_match('/3075A/', $useragent)) {
            $deviceCode = 'ot-3075a';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)997d/i', $useragent)) {
            $deviceCode = 'ot-997d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)995/i', $useragent)) {
            $deviceCode = 'ot-995';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)992d/i', $useragent)) {
            $deviceCode = 'ot-992d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991t/i', $useragent)) {
            $deviceCode = 'ot-991t';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991d/i', $useragent)) {
            $deviceCode = 'ot-991d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991/i', $useragent)) {
            $deviceCode = 'ot-991';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)990/i', $useragent)) {
            $deviceCode = 'ot-990';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)985d/i', $useragent)) {
            $deviceCode = 'ot-985d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)980/i', $useragent)) {
            $deviceCode = 'ot-980';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)918d/i', $useragent)) {
            $deviceCode = 'ot-918d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)918/i', $useragent)) {
            $deviceCode = 'ot-918';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)908/i', $useragent)) {
            $deviceCode = 'ot-908';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)903d/i', $useragent)) {
            $deviceCode = 'ot-903d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)890d/i', $useragent)) {
            $deviceCode = 'one touch 890d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)890/i', $useragent)) {
            $deviceCode = 'ot-890';
        }

        if (preg_match('/OT871A/', $useragent)) {
            $deviceCode = 'ot-871a';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)818/i', $useragent)) {
            $deviceCode = 'ot-818';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)710d/i', $useragent)) {
            $deviceCode = 'ot-710d';
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)216/i', $useragent)) {
            $deviceCode = 'ot-216';
        }

        if (preg_match('/Vodafone 975N/', $useragent)) {
            $deviceCode = '975n';
        }

        if (preg_match('/(V860|Vodafone Smart II)/', $useragent)) {
            $deviceCode = 'v860';
        }

        if (preg_match('/P321/', $useragent)) {
            $deviceCode = 'ot-p321';
        }

        if (preg_match('/P320X/', $useragent)) {
            $deviceCode = 'ot-p320x';
        }

        if (preg_match('/P310X/', $useragent)) {
            $deviceCode = 'ot-p310x';
        }

        if (preg_match('/P310A/', $useragent)) {
            $deviceCode = 'ot-p310a';
        }

        if (preg_match('/ONE TOUCH TAB 8HD/', $useragent)) {
            $deviceCode = 'ot-tab8hd';
        }

        if (preg_match('/ONE TOUCH TAB 7HD/', $useragent)) {
            $deviceCode = 'ot-tab7hd';
        }

        if (preg_match('/ALCATEL ONE TOUCH Fierce/', $useragent)) {
            $deviceCode = 'fierce';
        }

        return (new Factory\DeviceFactory())->get($deviceCode, $useragent);
    }
}
