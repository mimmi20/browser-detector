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

use BrowserDetector\Detector\Factory\CompanyFactory;
use BrowserDetector\Detector\Factory\FactoryInterface;
use BrowserDetector\Detector\Version\AndroidOs;
use BrowserDetector\Detector\Version\Windows;
use BrowserDetector\Version\Version;
use UaDeviceType;
use BrowserDetector\Detector\Bits\Os as OsBits;
use UaResult\Device\Device;
use UaResult\Os\Os;

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
        $bits = (new OsBits($useragent))->getBits();

        if (preg_match('/xbox one/i', $useragent)) {
            return new Device($useragent, 'Xbox One', null, CompanyFactory::get('Microsoft')->getName(), new UaDeviceType\TvConsole(), CompanyFactory::get('Microsoft')->getName(), 'Xbox One', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Windows', Windows::detectVersion($useragent), CompanyFactory::get('Microsoft')->getName(), $bits));
        }

        if (preg_match('/xbox/i', $useragent)) {
            return new Device($useragent, 'Xbox 360', null, CompanyFactory::get('Microsoft')->getName(), new UaDeviceType\TvConsole(), CompanyFactory::get('Microsoft')->getName(), 'Xbox 360', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Windows', Windows::detectVersion($useragent), CompanyFactory::get('Microsoft')->getName(), $bits));
        }

        if (preg_match('/dlink\.dsm380/i', $useragent)) {
            return new Device($useragent, 'DSM 380', null, CompanyFactory::get('Dlink')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Dlink')->getName(), 'DSM 380', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/NSZ\-GS7\/GX70/', $useragent)) {
            return new Device($useragent, 'NSZ-GS7/GX70', null, CompanyFactory::get('Sony')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Sony')->getName(), 'NSZ-GS7/GX70', 'mouse', null, null, false, 65536, false, false, true, null);
        }

        if (preg_match('/googletv/i', $useragent)) {
            return new Device($useragent, 'Google TV', null, CompanyFactory::get('Sony')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Sony')->getName(), 'Google TV', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/idl\-6651n/i', $useragent)) {
            return new Device($useragent, 'IDL-6651N', null, CompanyFactory::get('Unknown')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Unknown')->getName(), 'IDL-6651N', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/loewe; sl121/i', $useragent)) {
            return new Device($useragent, 'SL121', null, CompanyFactory::get('Loewe')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Loewe')->getName(), 'SL121', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/loewe; sl150/i', $useragent)) {
            return new Device($useragent, 'SL150', null, CompanyFactory::get('Loewe')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Loewe')->getName(), 'SL150', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/NETRANGEMMH/', $useragent)) {
            return new Device($useragent, 'NETRANGEMMH', null, CompanyFactory::get('Netrange')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Netrange')->getName(), 'NETRANGEMMH', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/viera/i', $useragent)) {
            return new Device($useragent, 'Viera TV', null, CompanyFactory::get('Panasonic')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Panasonic')->getName(), 'Viera TV', 'mouse', null, null, false, 65536, false, false, true, null);
        }

        if (preg_match('/\(; Philips; ; ; ; \)/', $useragent)) {
            return new Device($useragent, 'general Philips TV', null, CompanyFactory::get('Philips')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Philips')->getName(), 'general Philips TV', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/SMART\-TV/', $useragent)) {
            return new Device($useragent, 'Smart TV', null, CompanyFactory::get('Samsung')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Samsung')->getName(), 'Smart TV', 'unknown', null, null, false, 65536, false, false, true, null);
        }

        if (preg_match('/KDL32HX755/', $useragent)) {
            return new Device($useragent, 'KDL32HX755', null, CompanyFactory::get('Sony')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Sony')->getName(), 'KDL32HX755', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/KDL37EX720/', $useragent)) {
            return new Device($useragent, 'KDL37EX720', null, CompanyFactory::get('Sony')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Sony')->getName(), 'KDL37EX720', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/KDL40EX720/', $useragent)) {
            return new Device($useragent, 'KDL40EX720', null, CompanyFactory::get('Sony')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Sony')->getName(), 'KDL40EX720', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/KDL50W815B/', $useragent)) {
            return new Device($useragent, 'KDL50W815B', null, CompanyFactory::get('Sony')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Sony')->getName(), 'KDL50W815B', 'mouse', null, null, false, 65536, false, false, true, null);
        }

        if (preg_match('/SonyDTV115/', $useragent)) {
            return new Device($useragent, 'DTV115', null, CompanyFactory::get('Sony')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Sony')->getName(), 'DTV115', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/technisat digicorder isio s/i', $useragent)) {
            return new Device($useragent, 'DigiCorder ISIO S', null, CompanyFactory::get('TechniSat')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('TechniSat')->getName(), 'DigiCorder ISIO S', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/technisat digit isio s/i', $useragent)) {
            return new Device($useragent, 'DIGIT ISIO S', null, CompanyFactory::get('TechniSat')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('TechniSat')->getName(), 'DIGIT ISIO S', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/TechniSat MultyVision ISIO/', $useragent)) {
            return new Device($useragent, 'MultyVision ISIO', null, CompanyFactory::get('TechniSat')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('TechniSat')->getName(), 'MultyVision ISIO', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Linux', new Version(0), CompanyFactory::get('LinuxFoundation')->getName(), $bits));
        }

        if (preg_match('/AQUOSBrowser/', $useragent)) {
            return new Device($useragent, 'Aquos TV', null, CompanyFactory::get('Sharp')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Sharp')->getName(), 'Aquos TV', 'mouse', null, null, false, 65536, false, false, true, null);
        }

        if (preg_match('/CX919/', $useragent)) {
            return new Device($useragent, 'CX919', null, CompanyFactory::get('Andoer')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Andoer')->getName(), 'CX919', 'mouse', null, null, false, 65536, false, false, true, new Os($useragent, 'Android', AndroidOs::detectVersion($useragent), CompanyFactory::get('Google')->getName(), (new OsBits($useragent))->getBits()));
        }

        return new Device($useragent, 'general TV Device', null, CompanyFactory::get('Unknown')->getName(), new UaDeviceType\Tv(), CompanyFactory::get('Unknown')->getName(), 'general TV Device', null, null, null, false, 65536, false, false, null, null);
    }
}
