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
use BrowserDetector\Detector\Device\Desktop\EeePc;
use BrowserDetector\Detector\Device\Desktop\Hp9000;
use BrowserDetector\Detector\Device\Desktop\LinuxDesktop;
use BrowserDetector\Detector\Device\Desktop\MacBook;
use BrowserDetector\Detector\Device\Desktop\MacBookAir;
use BrowserDetector\Detector\Device\Desktop\MacBookPro;
use BrowserDetector\Detector\Device\Desktop\Macintosh;
use BrowserDetector\Detector\Device\Desktop\MacMini;
use BrowserDetector\Detector\Device\Desktop\MacPro;
use BrowserDetector\Detector\Device\Desktop\PowerMac;
use BrowserDetector\Detector\Device\Desktop\WindowsDesktop;
use BrowserDetector\Detector\Device\GeneralDesktop;
use BrowserDetector\Helper\Linux;
use Psr\Log\LoggerInterface;
use BrowserDetector\Helper\Windows as WindowsHelper;
use BrowserDetector\Helper\Macintosh as MacintoshHelper;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DesktopFactory
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
        if ((new WindowsHelper($useragent))->isWindows()) {
            $device = new WindowsDesktop($useragent, $logger);
        } elseif ((new Linux($useragent))->isLinux()) {
            $device = new LinuxDesktop($useragent, $logger);
        } elseif (preg_match('/macbookpro/i', $useragent)) {
            $device = new MacBookPro($useragent, $logger);
        } elseif (preg_match('/macbookair/i', $useragent)) {
            $device = new MacBookAir($useragent, $logger);
        } elseif (preg_match('/macbook/i', $useragent)) {
            $device = new MacBook($useragent, $logger);
        } elseif (preg_match('/macmini/i', $useragent)) {
            $device = new MacMini($useragent, $logger);
        } elseif (preg_match('/macpro/i', $useragent)) {
            $device = new MacPro($useragent, $logger);
        } elseif (preg_match('/(powermac|power%20macintosh)/i', $useragent)) {
            $device = new PowerMac($useragent, $logger);
        } elseif ((new MacintoshHelper($useragent))->isMacintosh()) {
            $device = new Macintosh($useragent, $logger);
        } elseif (preg_match('/eeepc/i', $useragent)) {
            $device = new EeePc($useragent, $logger);
        } elseif (preg_match('/hp\-ux 9000/i', $useragent)) {
            $device = new Hp9000($useragent, $logger);
        } elseif (preg_match('/Dillo/', $useragent)) {
            $device = new LinuxDesktop($useragent, $logger);
        } else {
            $device = new GeneralDesktop($useragent, $logger);
        }

        return $device;
    }
}
