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

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DarwinFactory implements FactoryInterface
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
        if (false !== strpos($useragent, 'CFNetwork/760')) {
            return new Os\Macosx($useragent, '10.11');
        }

        if (false !== strpos($useragent, 'CFNetwork/758')) {
            return new Os\Ios($useragent, '9.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/720')) {
            return new Os\Macosx($useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/718')) {
            return new Os\Macosx($useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/714')) {
            return new Os\Macosx($useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.5')) {
            return new Os\Ios($useragent, '8.4');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.4')) {
            return new Os\Ios($useragent, '8.4');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.3')) {
            return new Os\Ios($useragent, '8.3');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.2')) {
            return new Os\Ios($useragent, '8.2');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.1')) {
            return new Os\Ios($useragent, '8.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/711.0')) {
            return new Os\Ios($useragent, '8.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/709')) {
            return new Os\Macosx($useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/708')) {
            return new Os\Macosx($useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/705')) {
            return new Os\Macosx($useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/699')) {
            return new Os\Macosx($useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/696')) {
            return new Os\Macosx($useragent, '10.10');
        }

        if (false !== strpos($useragent, 'CFNetwork/673')) {
            return new Os\Macosx($useragent, '10.9');
        }

        if (false !== strpos($useragent, 'CFNetwork/672.1')) {
            return new Os\Ios($useragent, '7.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/672.0')) {
            return new Os\Ios($useragent, '7.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/647')) {
            return new Os\Macosx($useragent, '10.9');        }

        if (false !== strpos($useragent, 'CFNetwork/609.1')) {
            return new Os\Ios($useragent, '6.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/609')) {
            return new Os\Ios($useragent, '6.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/602')) {
            return new Os\Ios($useragent, '6.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/596')) {
            return new Os\Macosx($useragent, '10.8');
        }

        if (false !== strpos($useragent, 'CFNetwork/595')) {
            return new Os\Macosx($useragent, '10.8');
        }

        if (false !== strpos($useragent, 'CFNetwork/561')) {
            return new Os\Macosx($useragent, '10.8');
        }

        if (false !== strpos($useragent, 'CFNetwork/548.1')) {
            return new Os\Ios($useragent, '5.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/548.0')) {
            return new Os\Ios($useragent, '5.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/520')) {
            return new Os\Macosx($useragent, '10.7');
        }

        if (false !== strpos($useragent, 'CFNetwork/515')) {
            return new Os\Macosx($useragent, '10.7');
        }

        if (false !== strpos($useragent, 'CFNetwork/485.13')) {
            return new Os\Ios($useragent, '4.3');
        }

        if (false !== strpos($useragent, 'CFNetwork/485.12')) {
            return new Os\Ios($useragent, '4.2');
        }

        if (false !== strpos($useragent, 'CFNetwork/485.10')) {
            return new Os\Ios($useragent, '4.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/485.2')) {
            return new Os\Ios($useragent, '4.0');
        }

        if (false !== strpos($useragent, 'CFNetwork/467.12')) {
            return new Os\Ios($useragent, '3.2');
        }

        if (false !== strpos($useragent, 'CFNetwork/459')) {
            return new Os\Ios($useragent, '3.1');
        }

        if (false !== strpos($useragent, 'CFNetwork/454')) {
            return new Os\Macosx($useragent, '10.6');
        }

        if (false !== strpos($useragent, 'CFNetwork/438')) {
            return new Os\Macosx($useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/433')) {
            return new Os\Macosx($useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/422')) {
            return new Os\Macosx($useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/339')) {
            return new Os\Macosx($useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/330')) {
            return new Os\Macosx($useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/221')) {
            return new Os\Macosx($useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/220')) {
            return new Os\Macosx($useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/217')) {
            return new Os\Macosx($useragent, '10.5');
        }

        if (false !== strpos($useragent, 'CFNetwork/129')) {
            return new Os\Macosx($useragent, '10.4');
        }

        if (false !== strpos($useragent, 'CFNetwork/128')) {
            return new Os\Macosx($useragent, '10.4');
        }

        if (false !== strpos($useragent, 'CFNetwork/4.0')) {
            return new Os\Macosx($useragent, '10.3');
        }

        if (false !== strpos($useragent, 'CFNetwork/1.2')) {
            return new Os\Macosx($useragent, '10.3');
        }

        if (false !== strpos($useragent, 'CFNetwork/1.1')) {
            return new Os\Macosx($useragent, '10.3');
        }

        return new Os\Darwin($useragent);
    }
}
