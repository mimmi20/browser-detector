<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory\Device;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\GeneralMobile;
use BrowserDetector\Detector\Device\GeneralTv;
use BrowserDetector\Detector\Device\Mobile\Acer;
use BrowserDetector\Detector\Device\Mobile\Alcatel;
use BrowserDetector\Detector\Device\Mobile\Amazon;
use BrowserDetector\Detector\Device\Mobile\Amoi;
use BrowserDetector\Detector\Device\Mobile\Apple;
use BrowserDetector\Detector\Device\Mobile\Archos;
use BrowserDetector\Detector\Device\Mobile\Arnova;
use BrowserDetector\Detector\Device\Mobile\Asus;
use BrowserDetector\Detector\Device\Mobile\BarnesNoble;
use BrowserDetector\Detector\Device\Mobile\Beidou;
use BrowserDetector\Detector\Device\Mobile\BlackBerry;
use BrowserDetector\Detector\Device\Mobile\Blaupunkt;
use BrowserDetector\Detector\Device\Mobile\Htc;
use BrowserDetector\Detector\Device\Mobile\Huawei;
use BrowserDetector\Detector\Device\Mobile\Microsoft;
use BrowserDetector\Detector\Device\Mobile\Motorola;
use BrowserDetector\Detector\Device\Mobile\Nokia;
use BrowserDetector\Detector\Device\Mobile\Samsung;
use BrowserDetector\Detector\Device\Mobile\SonyEricsson;
use BrowserDetector\Detector\Device\Tv\DlinkDsm380;
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
use BrowserDetector\Detector\Device\Tv\SonyDtv115;
use BrowserDetector\Detector\Device\Tv\SonyKdl32hx755;
use BrowserDetector\Detector\Device\Tv\SonyKdl37ex720;
use BrowserDetector\Detector\Device\Tv\SonyKdl40ex720;
use BrowserDetector\Detector\Device\Tv\SonyKdl50w815b;
use BrowserDetector\Detector\Device\Tv\TechniSatDigiCorderIsioS;
use BrowserDetector\Detector\Device\Tv\TechniSatDigitIsioS;
use BrowserDetector\Detector\Device\Tv\TechniSatMultyVisionIsio;
use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Helper\MobileDevice;
use Psr\Log\LoggerInterface;
use UaMatcher\Device\DeviceHasChildrenInterface;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MobileFactory
{
    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \UaMatcher\Device\DeviceInterface
     */
    public static function detect($useragent, LoggerInterface $logger)
    {
        $helper = new MobileDevice($useragent);

        if ($helper->isSamsung()) {
            $device = new Samsung($useragent, $logger);
        } elseif ($helper->isApple()) {
            $device = new Apple($useragent, $logger);
        } elseif ($helper->isHtc()) {
            $device = new Htc($useragent, $logger);
        } elseif ($helper->isHuawei()) {
            $device = new Huawei($useragent, $logger);
        } elseif ($helper->isSony()) {
            $device = new SonyEricsson($useragent, $logger);
        } elseif ($helper->isNokia()) {
            $device = new Nokia($useragent, $logger);
        } elseif ($helper->isAmazon()) {
            $device = new Amazon($useragent, $logger);
        } elseif ($helper->isAlcatel()) {
            $device = new Alcatel($useragent, $logger);
        } elseif ($helper->isAcer()) {
            $device = new Acer($useragent, $logger);
        } elseif ($helper->isMotorola()) {
            $device = new Motorola($useragent, $logger);
        } elseif ($helper->isMicrosoft()) {
            $device = new Microsoft($useragent, $logger);
        } elseif (preg_match('/amoi/i', $useragent)) {
            $device = new Amoi($useragent, $logger);
        } elseif ($helper->isArchos()) {
            $device = new Archos($useragent, $logger);
        } elseif ($helper->isArnova()) {
            $device = new Arnova($useragent, $logger);
        } elseif ($helper->isAsus()) {
            $device = new Asus($useragent, $logger);
        } elseif (preg_match('/ BN /', $useragent)) {
            $device = new BarnesNoble($useragent, $logger);
        } elseif ($helper->isBeidou()) {
            $device = new Beidou($useragent, $logger);
        } elseif ($helper->isBlackberry()) {
            $device = new BlackBerry($useragent, $logger);
        } elseif ($helper->isBlaupunkt()) {
            $device = new Blaupunkt($useragent, $logger);
        } else {
            $device = new GeneralMobile($useragent, $logger);
        }

        if ($device instanceof DeviceHasChildrenInterface) {
            $device = $device->detectDevice();
        }

        return $device;
    }
}
