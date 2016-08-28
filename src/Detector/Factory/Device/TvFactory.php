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

namespace BrowserDetector\Detector\Factory\Device;

use BrowserDetector\Detector\Device\Tv;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class TvFactory implements FactoryInterface
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
        if (preg_match('/xbox one/i', $useragent)) {
            return new Tv\MicrosoftXboxOne($useragent);
        }

        if (preg_match('/xbox/i', $useragent)) {
            return new Tv\MicrosoftXbox($useragent);
        }

        if (preg_match('/dlink\.dsm380/i', $useragent)) {
            return new Tv\DlinkDsm380($useragent);
        }

        if (preg_match('/NSZ\-GS7\/GX70/', $useragent)) {
            return new Tv\SonyNszGs7Gx70($useragent);
        }

        if (preg_match('/googletv/i', $useragent)) {
            return new Tv\GoogleTv($useragent);
        }

        if (preg_match('/idl\-6651n/i', $useragent)) {
            return new Tv\Idl6651n($useragent);
        }

        if (preg_match('/loewe; sl32x/i', $useragent)) {
            return new Tv\LoeweSl32x($useragent);
        }

        if (preg_match('/loewe; sl121/i', $useragent)) {
            return new Tv\LoeweSl121($useragent);
        }

        if (preg_match('/loewe; sl150/i', $useragent)) {
            return new Tv\LoeweSl150($useragent);
        }

        if (preg_match('/lf1v464/i', $useragent)) {
            return new Tv\ThomsonLf1v464($useragent);
        }

        if (preg_match('/lf1v401/i', $useragent)) {
            return new Tv\ThomsonLf1v401($useragent);
        }

        if (preg_match('/lf1v394/i', $useragent)) {
            return new Tv\ThomsonLf1v394($useragent);
        }

        if (preg_match('/lf1v373/i', $useragent)) {
            return new Tv\ThomsonLf1v373($useragent);
        }

        if (preg_match('/lf1v325/i', $useragent)) {
            return new Tv\ThomsonLf1v325($useragent);
        }

        if (preg_match('/lf1v307/i', $useragent)) {
            return new Tv\ThomsonLf1v307($useragent);
        }

        if (preg_match('/NETRANGEMMH/', $useragent)) {
            return new Tv\NetrangeMmh($useragent);
        }

        if (preg_match('/viera/i', $useragent)) {
            return new Tv\PanasonicViera($useragent);
        }

        if (preg_match('/AVM\-2012/', $useragent)) {
            return new Tv\PhilipsAvm2012($useragent);
        }

        if (preg_match('/\(; Philips; ; ; ; \)/', $useragent)) {
            return new Tv\PhilipsTv($useragent);
        }

        if (preg_match('/Mxl661L32/', $useragent)) {
            return new Tv\SamsungSmartTv($useragent);
        }

        if (preg_match('/SMART\-TV/', $useragent)) {
            return new Tv\SamsungSmartTv($useragent);
        }

        if (preg_match('/KDL32HX755/', $useragent)) {
            return new Tv\SonyKdl32hx755($useragent);
        }

        if (preg_match('/KDL32W655A/', $useragent)) {
            return new Tv\SonyKdl32w655a($useragent);
        }

        if (preg_match('/KDL37EX720/', $useragent)) {
            return new Tv\SonyKdl37ex720($useragent);
        }

        if (preg_match('/KDL42W655A/', $useragent)) {
            return new Tv\SonyKdl42w655a($useragent);
        }

        if (preg_match('/KDL40EX720/', $useragent)) {
            return new Tv\SonyKdl40ex720($useragent);
        }

        if (preg_match('/KDL50W815B/', $useragent)) {
            return new Tv\SonyKdl50w815b($useragent);
        }

        if (preg_match('/SonyDTV115/', $useragent)) {
            return new Tv\SonyDtv115($useragent);
        }

        if (preg_match('/technisat digicorder isio s/i', $useragent)) {
            return new Tv\TechniSatDigiCorderIsioS($useragent);
        }

        if (preg_match('/technisat digit isio s/i', $useragent)) {
            return new Tv\TechniSatDigitIsioS($useragent);
        }

        if (preg_match('/TechniSat MultyVision ISIO/', $useragent)) {
            return new Tv\TechniSatMultyVisionIsio($useragent);
        }

        if (preg_match('/AQUOSBrowser/', $useragent)) {
            return new Tv\SharpAquosTv($useragent);
        }

        if (preg_match('/CX919/', $useragent)) {
            return new Tv\AndoerCx919($useragent);
        }

        if (preg_match('/Apple TV/', $useragent)) {
            return new Tv\AppleTv($useragent);
        }

        return new Tv\GeneralTv($useragent);
    }
}
