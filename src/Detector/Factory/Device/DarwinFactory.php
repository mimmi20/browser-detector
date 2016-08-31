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

use BrowserDetector\Detector\Factory\FactoryInterface;
use BrowserDetector\Detector\Device\Desktop;

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
        if (false !== strpos($useragent, 'CFNetwork/807')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/802')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/798')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/796')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/760')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/758')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/720')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/718')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/714')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/711.5')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/711.4')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/711.3')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/711.2')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/711.1')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/711.0')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/709')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/708')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/705')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/699')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/696')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/673')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/672.1')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/672.0')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/647')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/609.1')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/609')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/602')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/596')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/595')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/561')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/548.1')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/548.0')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/520')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/515')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/485.13')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/485.12')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/485.10')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/485.2')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/467.12')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/459')) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/454')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/438')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/433')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/422')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/339')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/330')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/221')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/220')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/217')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/129')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/128')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/4.0')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/1.2')) {
            return new Desktop\Macintosh($useragent);
        }

        if (false !== strpos($useragent, 'CFNetwork/1.1')) {
            return new Desktop\Macintosh($useragent);
        }

        return new Desktop\Macintosh($useragent);
    }
}
