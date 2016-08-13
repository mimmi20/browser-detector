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

use BrowserDetector\Detector\Device\Mobile\Dell;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DellFactory implements FactoryInterface
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
        if (preg_match('/venue pro/i', $useragent)) {
            return new Dell\DellVenuePro($useragent);
        }

        if (preg_match('/venue 8 hspa\+/i', $useragent)) {
            return new Dell\DellVenue8Hspa($useragent);
        }

        if (preg_match('/venue 8 3830/i', $useragent)) {
            return new Dell\DellVenue83830($useragent);
        }

        if (preg_match('/venue 7 hspa\+/i', $useragent)) {
            return new Dell\DellVenue7Hspa($useragent);
        }

        if (preg_match('/venue 7 3730/i', $useragent)) {
            return new Dell\DellVenue73730($useragent);
        }

        if (preg_match('/venue/i', $useragent)) {
            return new Dell\DellVenue($useragent);
        }

        if (preg_match('/streak 10 pro/i', $useragent)) {
            return new Dell\DellStreak10Pro($useragent);
        }

        if (preg_match('/streak 7/i', $useragent)) {
            return new Dell\DellStreak7($useragent);
        }

        if (preg_match('/streak/i', $useragent)) {
            return new Dell\DellStreak($useragent);
        }

        return new Dell\Dell($useragent);
    }
}
