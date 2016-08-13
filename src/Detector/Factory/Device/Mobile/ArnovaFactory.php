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

namespace BrowserDetector\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Device\Mobile\Arnova;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ArnovaFactory implements FactoryInterface
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
        if (preg_match('/101 g4/i', $useragent)) {
            return new Arnova\Arnova101G4($useragent);
        }

        if (preg_match('/AN10DG3/i', $useragent)) {
            return new Arnova\Arnova10DG3($useragent);
        }

        if (preg_match('/AN10BG3/i', $useragent)) {
            return new Arnova\Arnova10BG3($useragent);
        }

        if (preg_match('/AN9G2I/i', $useragent)) {
            return new Arnova\Arnova9G2I($useragent);
        }

        if (preg_match('/AN7FG3/i', $useragent)) {
            return new Arnova\Arnova7FG3($useragent);
        }

        if (preg_match('/AN7EG3/i', $useragent)) {
            return new Arnova\Arnova7EG3($useragent);
        }

        if (preg_match('/AN7DG3/i', $useragent)) {
            return new Arnova\Arnova7DG3($useragent);
        }

        if (preg_match('/AN7CG2/i', $useragent)) {
            return new Arnova\Arnova7CG2($useragent);
        }

        if (preg_match('/AN7BG2DT/i', $useragent)) {
            return new Arnova\Arnova7BG2DT($useragent);
        }

        if (preg_match('/ARCHM901/i', $useragent)) {
            return new Arnova\ArnovaArchm901($useragent);
        }

        return new Arnova\Arnova($useragent);
    }
}
