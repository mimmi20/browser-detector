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
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory\Platform;

use BrowserDetector\Detector\Os;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DarwinFactory implements FactoryInterface
{
    /**
     * Gets the information about the platform by User Agent
     *
     * @param string $agent
     *
     * @return \UaResult\Os\OsInterface
     */
    public static function detect($agent)
    {
        if (false !== strpos($agent, 'CFNetwork/760')) {
            return new Os\Macosx($agent, '10.11'); // OSX 10.11
        }

        if (false !== strpos($agent, 'CFNetwork/758')) {
            return new Os\Ios($agent, '9.0'); // iOS 9.0
        }

        if (false !== strpos($agent, 'CFNetwork/720')) {
            return new Os\Macosx($agent, '10.10'); // OSX 10.10
        }

        if (false !== strpos($agent, 'CFNetwork/718')) {
            return new Os\Macosx($agent, '10.10'); // OSX 10.10
        }

        if (false !== strpos($agent, 'CFNetwork/714')) {
            return new Os\Macosx($agent, '10.10'); // OSX 10.10
        }

        if (false !== strpos($agent, 'CFNetwork/711.5')) {
            return new Os\Ios($agent, '8.4'); // iOS 8.4
        }

        if (false !== strpos($agent, 'CFNetwork/711.4')) {
            return new Os\Ios($agent, '8.4'); // iOS 8.4
        }

        if (false !== strpos($agent, 'CFNetwork/711.3')) {
            return new Os\Ios($agent, '8.3'); // iOS 8.3
        }

        if (false !== strpos($agent, 'CFNetwork/711.2')) {
            return new Os\Ios($agent, '8.2'); // iOS 8.2
        }

        if (false !== strpos($agent, 'CFNetwork/711.1')) {
            return new Os\Ios($agent, '8.1'); // iOS 8.1
        }

        if (false !== strpos($agent, 'CFNetwork/711.0')) {
            return new Os\Ios($agent, '8.0'); // iOS 8.0
        }

        if (false !== strpos($agent, 'CFNetwork/709')) {
            return new Os\Macosx($agent, '10.10'); // OSX 10.10
        }

        if (false !== strpos($agent, 'CFNetwork/708')) {
            return new Os\Macosx($agent, '10.10'); // OSX 10.10
        }

        if (false !== strpos($agent, 'CFNetwork/705')) {
            return new Os\Macosx($agent, '10.10'); // OSX 10.10
        }

        if (false !== strpos($agent, 'CFNetwork/699')) {
            return new Os\Macosx($agent, '10.10'); // OSX 10.10
        }

        if (false !== strpos($agent, 'CFNetwork/696')) {
            return new Os\Macosx($agent, '10.10'); // OSX 10.10
        }

        if (false !== strpos($agent, 'CFNetwork/673')) {
            return new Os\Macosx($agent, '10.9'); // OSX 10.9
        }

        if (false !== strpos($agent, 'CFNetwork/672.1')) {
            return new Os\Ios($agent, '7.1'); // iOS 7.1
        }

        if (false !== strpos($agent, 'CFNetwork/672.0')) {
            return new Os\Ios($agent, '7.0'); // iOS 7.0
        }

        if (false !== strpos($agent, 'CFNetwork/647')) {
            return new Os\Macosx($agent, '10.9'); // OSX 10.9
        }

        if (false !== strpos($agent, 'CFNetwork/609.1')) {
            return new Os\Ios($agent, '6.1'); // iOS 6.1
        }

        if (false !== strpos($agent, 'CFNetwork/609')) {
            return new Os\Ios($agent, '6.0'); // iOS 6.0
        }

        if (false !== strpos($agent, 'CFNetwork/602')) {
            return new Os\Ios($agent, '6.0'); // iOS 6.0
        }

        if (false !== strpos($agent, 'CFNetwork/596')) {
            return new Os\Macosx($agent, '10.8'); // OSX 10.8
        }

        if (false !== strpos($agent, 'CFNetwork/595')) {
            return new Os\Macosx($agent, '10.8'); // OSX 10.8
        }

        if (false !== strpos($agent, 'CFNetwork/561')) {
            return new Os\Macosx($agent, '10.8'); // OSX 10.8
        }

        if (false !== strpos($agent, 'CFNetwork/548.1')) {
            return new Os\Ios($agent, '5.1'); // iOS 5.1
        }

        if (false !== strpos($agent, 'CFNetwork/548.0')) {
            return new Os\Ios($agent, '5.0'); // iOS 5.0
        }

        if (false !== strpos($agent, 'CFNetwork/520')) {
            return new Os\Macosx($agent, '10.7'); // OSX 10.7
        }

        if (false !== strpos($agent, 'CFNetwork/515')) {
            return new Os\Macosx($agent, '10.7'); // OSX 10.7
        }

        if (false !== strpos($agent, 'CFNetwork/485.13')) {
            return new Os\Ios($agent, '4.3'); // iOS 4.3
        }

        if (false !== strpos($agent, 'CFNetwork/485.12')) {
            return new Os\Ios($agent, '4.2'); // iOS 4.2
        }

        if (false !== strpos($agent, 'CFNetwork/485.10')) {
            return new Os\Ios($agent, '4.1'); // iOS 4.1
        }

        if (false !== strpos($agent, 'CFNetwork/485.2')) {
            return new Os\Ios($agent, '4.0'); // iOS 4.0
        }

        if (false !== strpos($agent, 'CFNetwork/467.12')) {
            return new Os\Ios($agent, '3.2'); // iOS 3.2
        }

        if (false !== strpos($agent, 'CFNetwork/459')) {
            return new Os\Ios($agent, '3.1'); // iOS 3.1
        }

        if (false !== strpos($agent, 'CFNetwork/454')) {
            return new Os\Macosx($agent, '10.6'); // OSX 10.6
        }

        if (false !== strpos($agent, 'CFNetwork/438')) {
            return new Os\Macosx($agent, '10.5'); // OSX 10.5
        }

        if (false !== strpos($agent, 'CFNetwork/433')) {
            return new Os\Macosx($agent, '10.5'); // OSX 10.5
        }

        if (false !== strpos($agent, 'CFNetwork/422')) {
            return new Os\Macosx($agent, '10.5'); // OSX 10.5
        }

        if (false !== strpos($agent, 'CFNetwork/339')) {
            return new Os\Macosx($agent, '10.5'); // OSX 10.5
        }

        if (false !== strpos($agent, 'CFNetwork/330')) {
            return new Os\Macosx($agent, '10.5'); // OSX 10.5
        }

        if (false !== strpos($agent, 'CFNetwork/221')) {
            return new Os\Macosx($agent, '10.5'); // OSX 10.5
        }

        if (false !== strpos($agent, 'CFNetwork/220')) {
            return new Os\Macosx($agent, '10.5'); // OSX 10.5
        }

        if (false !== strpos($agent, 'CFNetwork/217')) {
            return new Os\Macosx($agent, '10.5'); // OSX 10.5
        }

        if (false !== strpos($agent, 'CFNetwork/129')) {
            return new Os\Macosx($agent, '10.4'); // OSX 10.4
        }

        if (false !== strpos($agent, 'CFNetwork/128')) {
            return new Os\Macosx($agent, '10.4'); // OSX 10.4
        }

        if (false !== strpos($agent, 'CFNetwork/4.0')) {
            return new Os\Macosx($agent, '10.3'); // OSX 10.3
        }

        if (false !== strpos($agent, 'CFNetwork/1.2')) {
            return new Os\Macosx($agent, '10.3'); // OSX 10.3
        }

        if (false !== strpos($agent, 'CFNetwork/1.1')) {
            return new Os\Macosx($agent, '10.3'); // OSX 10.3
        }

        return new Os\Darwin($agent);
    }
}
