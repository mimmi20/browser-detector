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

use BrowserDetector\Detector\Device\Tv\AndoerCx919;
use BrowserDetector\Detector\Device\Tv\DlinkDsm380;
use BrowserDetector\Detector\Device\Tv\GeneralTv;
use BrowserDetector\Detector\Device\Tv\GoogleTv;
use BrowserDetector\Detector\Device\Tv\Idl6651n;
use BrowserDetector\Detector\Device\Tv\LoeweSl121;
use BrowserDetector\Detector\Device\Tv\LoeweSl150;
use BrowserDetector\Detector\Device\Tv\MicrosoftXbox;
use BrowserDetector\Detector\Device\Tv\MicrosoftXboxOne;
use BrowserDetector\Detector\Device\Tv\NetrangeMmh;
use BrowserDetector\Detector\Device\Tv\PanasonicViera;
use BrowserDetector\Detector\Device\Tv\PhilipsTv;
use BrowserDetector\Detector\Device\Tv\SamsungSmartTv;
use BrowserDetector\Detector\Device\Tv\SharpAquosTv;
use BrowserDetector\Detector\Device\Tv\SonyDtv115;
use BrowserDetector\Detector\Device\Tv\SonyKdl32hx755;
use BrowserDetector\Detector\Device\Tv\SonyKdl37ex720;
use BrowserDetector\Detector\Device\Tv\SonyKdl40ex720;
use BrowserDetector\Detector\Device\Tv\SonyKdl50w815b;
use BrowserDetector\Detector\Device\Tv\SonyNszGs7Gx70;
use BrowserDetector\Detector\Device\Tv\TechniSatDigiCorderIsioS;
use BrowserDetector\Detector\Device\Tv\TechniSatDigitIsioS;
use BrowserDetector\Detector\Device\Tv\TechniSatMultyVisionIsio;
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
            return new MicrosoftXboxOne($useragent);
        }

        if (preg_match('/xbox/i', $useragent)) {
            return new MicrosoftXbox($useragent);
        }

        if (preg_match('/dlink\.dsm380/i', $useragent)) {
            return new DlinkDsm380($useragent);
        }

        if (preg_match('/NSZ\-GS7\/GX70/', $useragent)) {
            return new SonyNszGs7Gx70($useragent);
        }

        if (preg_match('/googletv/i', $useragent)) {
            return new GoogleTv($useragent);
        }

        if (preg_match('/idl\-6651n/i', $useragent)) {
            return new Idl6651n($useragent);
        }

        if (preg_match('/loewe; sl121/i', $useragent)) {
            return new LoeweSl121($useragent);
        }

        if (preg_match('/loewe; sl150/i', $useragent)) {
            return new LoeweSl150($useragent);
        }

        if (preg_match('/NETRANGEMMH/', $useragent)) {
            return new NetrangeMmh($useragent);
        }

        if (preg_match('/viera/i', $useragent)) {
            return new PanasonicViera($useragent);
        }

        if (preg_match('/\(; Philips; ; ; ; \)/', $useragent)) {
            return new PhilipsTv($useragent);
        }

        if (preg_match('/SMART\-TV/', $useragent)) {
            return new SamsungSmartTv($useragent);
        }

        if (preg_match('/KDL32HX755/', $useragent)) {
            return new SonyKdl32hx755($useragent);
        }

        if (preg_match('/KDL37EX720/', $useragent)) {
            return new SonyKdl37ex720($useragent);
        }

        if (preg_match('/KDL40EX720/', $useragent)) {
            return new SonyKdl40ex720($useragent);
        }

        if (preg_match('/KDL50W815B/', $useragent)) {
            return new SonyKdl50w815b($useragent);
        }

        if (preg_match('/SonyDTV115/', $useragent)) {
            return new SonyDtv115($useragent);
        }

        if (preg_match('/technisat digicorder isio s/i', $useragent)) {
            return new TechniSatDigiCorderIsioS($useragent);
        }

        if (preg_match('/technisat digit isio s/i', $useragent)) {
            return new TechniSatDigitIsioS($useragent);
        }

        if (preg_match('/TechniSat MultyVision ISIO/', $useragent)) {
            return new TechniSatMultyVisionIsio($useragent);
        }

        if (preg_match('/AQUOSBrowser/', $useragent)) {
            return new SharpAquosTv($useragent);
        }

        if (preg_match('/CX919/', $useragent)) {
            return new AndoerCx919($useragent);
        }

        return new GeneralTv($useragent);
    }
}
