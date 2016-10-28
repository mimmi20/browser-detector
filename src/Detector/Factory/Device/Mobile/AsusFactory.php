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

use BrowserDetector\Detector\Device\Mobile\Asus;
use BrowserDetector\Detector\Factory\DeviceFactory;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AsusFactory implements FactoryInterface
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
        $deviceCode = 'general asus device';

        if (preg_match('/TF101G/i', $useragent)) {
            $deviceCode = 'eee pad transformer tf101g';
        }

        if (preg_match('/(Transformer TF201|Transformer Prime TF201)/i', $useragent)) {
            $deviceCode = 'asus eee pad tf201';
        }

        if (preg_match('/z00ad/i', $useragent)) {
            $deviceCode = 'z00ad';
        }

        if (preg_match('/k00c/i', $useragent)) {
            $deviceCode = 'k00c';
        }

        if (preg_match('/k00f/i', $useragent)) {
            $deviceCode = 'k00f';
        }

        if (preg_match('/k00z/i', $useragent)) {
            $deviceCode = 'k00z';
        }

        if (preg_match('/k01e/i', $useragent)) {
            $deviceCode = 'k01e';
        }

        if (preg_match('/k01a/i', $useragent)) {
            $deviceCode = 'k01a';
        }

        if (preg_match('/k017/i', $useragent)) {
            $deviceCode = 'k017';
        }

        if (preg_match('/K013/i', $useragent)) {
            $deviceCode = 'k013';
        }

        if (preg_match('/K012/i', $useragent)) {
            $deviceCode = 'k012';
        }

        if (preg_match('/(K00E|ME372CG)/i', $useragent)) {
            $deviceCode = 'k00e';
        }

        if (preg_match('/ME172V/i', $useragent)) {
            $deviceCode = 'me172v';
        }

        if (preg_match('/ME173X/i', $useragent)) {
            $deviceCode = 'me173x';
        }

        if (preg_match('/ME301T/i', $useragent)) {
            $deviceCode = 'me301t';
        }

        if (preg_match('/ME302C/i', $useragent)) {
            $deviceCode = 'me302c';
        }

        if (preg_match('/ME302KL/i', $useragent)) {
            $deviceCode = 'me302kl';
        }

        if (preg_match('/ME371MG/i', $useragent)) {
            $deviceCode = 'me371mg';
        }

        if (preg_match('/P1801\-T/i', $useragent)) {
            $deviceCode = 'p1801-t';
        }

        if (preg_match('/T00J/', $useragent)) {
            $deviceCode = 't00j';
        }

        if (preg_match('/T00N/', $useragent)) {
            $deviceCode = 't00n';
        }

        if (preg_match('/P01Y/', $useragent)) {
            $deviceCode = 'p01y';
        }

        if (preg_match('/TF101/i', $useragent)) {
            $deviceCode = 'tf101';
        }

        if (preg_match('/TF300TL/i', $useragent)) {
            $deviceCode = 'tf300tl';
        }

        if (preg_match('/TF300TG/i', $useragent)) {
            $deviceCode = 'tf300tg';
        }

        if (preg_match('/TF300T/i', $useragent)) {
            $deviceCode = 'tf300t';
        }

        if (preg_match('/TF700T/i', $useragent)) {
            $deviceCode = 'tf700t';
        }

        if (preg_match('/Slider SL101/i', $useragent)) {
            $deviceCode = 'sl101';
        }

        if (preg_match('/Garmin\-Asus A50/i', $useragent)) {
            $deviceCode = 'a50';
        }

        if (preg_match('/Garmin\-Asus A10/i', $useragent)) {
            $deviceCode = 'asus a10';
        }

        if (preg_match('/Transformer Prime/i', $useragent)) {
            $deviceCode = 'asus eee pad tf201';
        }

        if (preg_match('/padfone t004/i', $useragent)) {
            $deviceCode = 'padfone t004';
        }

        if (preg_match('/padfone 2/i', $useragent)) {
            $deviceCode = 'a68';
        }

        if (preg_match('/padfone/i', $useragent)) {
            $deviceCode = 'padfone';
        }

        if (preg_match('/nexus[ _]?7/i', $useragent)) {
            $deviceCode = 'nexus 7';
        }

        if (preg_match('/asus;galaxy6/i', $useragent)) {
            $deviceCode = 'galaxy6';
        }

        if (preg_match('/eee_701/i', $useragent)) {
            $deviceCode = 'eee 701';
        }

        return DeviceFactory::get($deviceCode, $useragent);
    }
}
