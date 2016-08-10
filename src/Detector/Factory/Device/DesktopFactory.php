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

use BrowserDetector\Detector\Device\Desktop\EeePc;
use BrowserDetector\Detector\Device\Desktop\GeneralDesktop;
use BrowserDetector\Detector\Device\Desktop\Hp9000;
use BrowserDetector\Detector\Device\Desktop\Imac;
use BrowserDetector\Detector\Device\Desktop\LinuxDesktop;
use BrowserDetector\Detector\Device\Desktop\MacBook;
use BrowserDetector\Detector\Device\Desktop\MacBookAir;
use BrowserDetector\Detector\Device\Desktop\MacBookPro;
use BrowserDetector\Detector\Device\Desktop\Macintosh;
use BrowserDetector\Detector\Device\Desktop\MacMini;
use BrowserDetector\Detector\Device\Desktop\MacPro;
use BrowserDetector\Detector\Device\Desktop\PowerMac;
use BrowserDetector\Detector\Device\Desktop\WindowsDesktop;
use BrowserDetector\Detector\Factory\FactoryInterface;
use BrowserDetector\Helper\Linux as LinuxHelper;
use BrowserDetector\Helper\Macintosh as MacintoshHelper;
use BrowserDetector\Helper\Windows as WindowsHelper;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DesktopFactory implements FactoryInterface
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
        if ((new WindowsHelper($useragent))->isWindows()) {
            return new \UaResult\Device\Device($useragent, 'Windows Desktop', null, CompanyFactory::get('Unknown')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Unknown')->getName(), 'Windows Desktop', 'mouse', 800, 600, false, 65536, false, false, true, new \UaResult\Os\Os($this->useragent, 'Windows', Windows::detectVersion($this->useragent), CompanyFactory::get('Microsoft')->getName(), $bits));
        }

        if ((new LinuxHelper($useragent))->isLinux()) {
            return new \UaResult\Device\Device($useragent, 'Linux Desktop', null, CompanyFactory::get('Unknown')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Unknown')->getName(), 'Linux Desktop', 'mouse', 800, 600, false, 65536, false, false, true, null);
        }

        if (preg_match('/iMac/', $useragent)) {
            return new \UaResult\Device\Device($useragent, 'iMac', null, CompanyFactory::get('Apple')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Apple')->getName(), 'iMac', 'mouse', null, null, false, 65536, false, false, true, null);
        }

        if (preg_match('/macbookpro/i', $useragent)) {
            return new \UaResult\Device\Device($useragent, 'MacBook Pro', null, CompanyFactory::get('Apple')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Apple')->getName(), 'MacBook Pro', 'mouse', null, null, false, 65536, false, false, true, null);
        }

        if (preg_match('/macbookair/i', $useragent)) {
            return new \UaResult\Device\Device($useragent, 'MacBook Air', null, CompanyFactory::get('Apple')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Apple')->getName(), 'MacBook Air', 'mouse', null, null, false, 65536, false, false, true, null);
        }

        if (preg_match('/macbook/i', $useragent)) {
            return new \UaResult\Device\Device($useragent, 'MacBook', null, CompanyFactory::get('Apple')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Apple')->getName(), 'MacBook', 'mouse', null, null, false, 65536, false, false, true, null);
        }

        if (preg_match('/macmini/i', $useragent)) {
            return new \UaResult\Device\Device($useragent, 'Mac Mini', null, CompanyFactory::get('Apple')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Apple')->getName(), 'Mac Mini', 'mouse', null, null, null, null, false, false, true, null);
        }

        if (preg_match('/macpro/i', $useragent)) {
            return new \UaResult\Device\Device($useragent, 'MacPro', null, CompanyFactory::get('Apple')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Apple')->getName(), 'MacPro', 'mouse', null, null, false, 65536, false, false, true, null);
        }

        if (preg_match('/(powermac|power%20macintosh)/i', $useragent)) {
            return new \UaResult\Device\Device($useragent, 'PowerMac', null, CompanyFactory::get('Apple')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Apple')->getName(), 'PowerMac', 'mouse', null, null, false, 65536, false, false, true, null);
        }

        if ((new MacintoshHelper($useragent))->isMacintosh()) {
            return new \UaResult\Device\Device($useragent, 'Macintosh', null, CompanyFactory::get('Apple')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Apple')->getName(), 'Macintosh', 'mouse', 800, 600, false, 65536, false, false, true, null);
        }

        if (preg_match('/eeepc/i', $useragent)) {
            return new \UaResult\Device\Device($useragent, 'eee pc', null, CompanyFactory::get('Asus')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Asus')->getName(), 'eee pc', 'mouse', 1024, 600, false, null, false, false, true, null);
        }

        if (preg_match('/hp\-ux 9000/i', $useragent)) {
            return new \UaResult\Device\Device($useragent, '9000', null, CompanyFactory::get('Hp')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Hp')->getName(), '9000', 'mouse', null, null, null, null, false, false, true, null);
        }

        if (preg_match('/Dillo/', $useragent)) {
            return new \UaResult\Device\Device($useragent, 'Linux Desktop', null, CompanyFactory::get('Unknown')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Unknown')->getName(), 'Linux Desktop', 'mouse', 800, 600, false, 65536, false, false, true, null);
        }

        return new \UaResult\Device\Device($useragent, 'general Desktop', null, CompanyFactory::get('Unknown')->getName(), new UaDeviceType\Desktop(), CompanyFactory::get('Unknown')->getName(), 'general Desktop', 'mouse', null, null, false, 65536, false, false, null, null);
    }
}
