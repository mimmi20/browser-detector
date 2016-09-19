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

namespace BrowserDetector\Detector\Factory\Platform;

use BrowserDetector\Detector\Factory\FactoryInterface;
use BrowserDetector\Detector\Os;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use UaHelper\Utils;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class WindowsFactory implements FactoryInterface
{
    /**
     * Gets the information about the platform by User Agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Os\OsInterface
     */
    public static function detect($useragent)
    {
        $utils = new Utils();
        $utils->setUserAgent($useragent);

        if ($utils->checkIfContains(['win9x/NT 4.90', 'Win 9x 4.90', 'Win 9x4.90'])) {
            return new Os\WindowsMe($useragent);
        }

        if ($utils->checkIfContains(['Win98'])) {
            return new Os\Windows98($useragent);
        }

        if ($utils->checkIfContains(['Win95'])) {
            return new Os\Windows95($useragent);
        }

        $doMatch = preg_match('/Windows NT ([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            switch ($matches[1]) {
                case '10.0':
                case '6.4':
                    return new Os\Windows10($useragent, $matches[1]);
                    break;
                case '6.3':
                    return new Os\Windows81($useragent);
                    break;
                case '6.2':
                    return new Os\Windows8($useragent);
                    break;
                case '6.1':
                    return new Os\Windows7($useragent);
                    break;
                case '6':
                case '6.0':
                    return new Os\WindowsVista($useragent);
                    break;
                case '5.3':
                case '5.2':
                case '5.1':
                    return new Os\WindowsXp($useragent, $matches[1]);
                    break;
                case '5.01':
                case '5.0':
                    return new Os\Windows2000($useragent, $matches[1]);
                    break;
                case '4.10':
                case '4.1':
                case '4.0':
                case '3.5':
                case '3.1':
                    return new Os\WindowsNt($useragent, $matches[1]);
                    break;
                default:
                    // nothing to do here
                    break;
            }

            return new Os\WindowsNt($useragent, '0.0');
        }

        $doMatch = preg_match('/Windows[ \-]([\d\.a-zA-Z]+)/', $useragent, $matches);

        if ($doMatch) {
            switch ($matches[1]) {
                case '10.0':
                case '10':
                case '6.4':
                    return new Os\Windows10($useragent, $matches[1]);
                    break;
                case '6.3':
                    return new Os\Windows81($useragent);
                    break;
                case '6.2':
                    return new Os\Windows8($useragent);
                    break;
                case '6.1':
                case '7':
                    return new Os\Windows7($useragent);
                    break;
                case '6.0':
                case 'Vista':
                    return new Os\WindowsVista($useragent);
                    break;
                case '2003':
                    return new Os\Windows2003($useragent);
                    break;
                case '5.3':
                case '5.2':
                case '5.1':
                    return new Os\WindowsXp($useragent, $matches[1]);
                    break;
                case 'XP':
                    return new Os\WindowsXp($useragent);
                    break;
                case 'ME':
                    return new Os\WindowsMe($useragent);
                    break;
                case '2000':
                    return new Os\Windows2000($useragent);
                    break;
                case '5.01':
                case '5.0':
                    return new Os\Windows2000($useragent, $matches[1]);
                    break;
                case '4.1':
                case '4.0':
                case '3.5':
                    return new Os\WindowsNt($useragent, $matches[1]);
                    break;
                case 'NT':
                    return new Os\WindowsNt($useragent);
                    break;
                case '3.1':
                    return new Os\Windows31($useragent);
                    break;
                case '95':
                    return new Os\Windows95($useragent);
                    break;
                case '98':
                    return new Os\Windows98($useragent);
                    break;
                default:
                    // nothing to do here
                    break;
            }

            return new Os\Windows($useragent);
        }

        return new Os\Windows($useragent);
    }
}
