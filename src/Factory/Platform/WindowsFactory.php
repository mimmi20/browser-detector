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

namespace BrowserDetector\Factory\Platform;

use BrowserDetector\Factory;
use BrowserDetector\Factory\PlatformFactory;
use UaHelper\Utils;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class WindowsFactory implements Factory\FactoryInterface
{
    /**
     * Gets the information about the platform by User Agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect($useragent)
    {
        $utils = new Utils();
        $utils->setUserAgent($useragent);
        $platformFactory = new PlatformFactory();

        if ($utils->checkIfContains(['win9x/NT 4.90', 'Win 9x 4.90', 'Win 9x4.90'])) {
            return $platformFactory->get('windows me', $useragent);
        }

        if ($utils->checkIfContains(['Win98'])) {
            return $platformFactory->get('windows 98', $useragent);
        }

        if ($utils->checkIfContains(['Win95'])) {
            return $platformFactory->get('windows 95', $useragent);
        }

        $doMatch = preg_match('/Windows NT ([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            switch ($matches[1]) {
                case '10.0':
                    return $platformFactory->get('windows nt 10', $useragent);
                    break;
                case '6.4':
                    return $platformFactory->get('windows nt 6.4', $useragent);
                    break;
                case '6.3':
                    return $platformFactory->get('windows nt 6.3', $useragent);
                    break;
                case '6.2':
                    return $platformFactory->get('windows nt 6.2', $useragent);
                    break;
                case '6.1':
                    return $platformFactory->get('windows nt 6.1', $useragent);
                    break;
                case '6':
                case '6.0':
                    return $platformFactory->get('windows nt 6.0', $useragent);
                    break;
                case '5.3':
                    return $platformFactory->get('windows nt 5.3', $useragent);
                    break;
                case '5.2':
                    return $platformFactory->get('windows nt 5.2', $useragent);
                    break;
                case '5.1':
                    return $platformFactory->get('windows nt 5.1', $useragent);
                    break;
                case '5.01':
                    return $platformFactory->get('windows nt 5.01', $useragent);
                    break;
                case '5.0':
                    return $platformFactory->get('windows nt 5.0', $useragent);
                    break;
                case '4.10':
                    return $platformFactory->get('windows nt 4.10', $useragent);
                    break;
                case '4.1':
                    return $platformFactory->get('windows nt 4.1', $useragent);
                    break;
                case '4.0':
                    return $platformFactory->get('windows nt 4.0', $useragent);
                    break;
                case '3.5':
                    return $platformFactory->get('windows nt 3.5', $useragent);
                    break;
                case '3.1':
                    return $platformFactory->get('windows nt 3.1', $useragent);
                    break;
                default:
                    // nothing to do here
                    break;
            }

            return $platformFactory->get('windows nt', $useragent, '0.0');
        }

        $doMatch = preg_match('/Windows[ \-]([\d\.a-zA-Z]+)/', $useragent, $matches);

        if ($doMatch) {
            switch ($matches[1]) {
                case '10.0':
                case '10':
                    return $platformFactory->get('windows nt 10', $useragent);
                    break;
                case '6.4':
                    return $platformFactory->get('windows nt 6.4', $useragent);
                    break;
                case '6.3':
                    return $platformFactory->get('windows nt 6.3', $useragent);
                    break;
                case '6.2':
                    return $platformFactory->get('windows nt 6.2', $useragent);
                    break;
                case '6.1':
                case '7':
                    return $platformFactory->get('windows nt 6.1', $useragent);
                    break;
                case '6.0':
                case 'Vista':
                    return $platformFactory->get('windows nt 6.0', $useragent);
                    break;
                case '2003':
                    return $platformFactory->get('windows 2003', $useragent);
                    break;
                case '5.3':
                    return $platformFactory->get('windows nt 5.3', $useragent);
                    break;
                case '5.2':
                    return $platformFactory->get('windows nt 5.2', $useragent);
                    break;
                case '5.1':
                case 'XP':
                    return $platformFactory->get('windows nt 5.1', $useragent);
                    break;
                case 'ME':
                    return $platformFactory->get('windows me', $useragent);
                    break;
                case '2000':
                    return $platformFactory->get('windows nt 5.0', $useragent);
                    break;
                case '5.01':
                    return $platformFactory->get('windows nt 5.01', $useragent);
                    break;
                case '5.0':
                    return $platformFactory->get('windows nt 5.0', $useragent);
                    break;
                case '4.1':
                    return $platformFactory->get('windows nt 4.1', $useragent);
                    break;
                case '4.0':
                    return $platformFactory->get('windows nt 4.0', $useragent);
                    break;
                case '3.5':
                    return $platformFactory->get('windows nt 3.5', $useragent);
                    break;
                case 'NT':
                    return $platformFactory->get('windows nt', $useragent);
                    break;
                case '3.1':
                    return $platformFactory->get('windows 3.1', $useragent);
                    break;
                case '95':
                    return $platformFactory->get('windows 95', $useragent);
                    break;
                case '98':
                    return $platformFactory->get('windows 98', $useragent);
                    break;
                default:
                    // nothing to do here
                    break;
            }
        }

        return $platformFactory->get('windows', $useragent);
    }
}
