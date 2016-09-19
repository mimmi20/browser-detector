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

use BrowserDetector\Detector\Device\Mobile\Prestigio;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class PrestigioFactory implements FactoryInterface
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
        if (preg_match('/PMT7077_3G/', $useragent)) {
            return new Prestigio\PrestigioPmt70773g($useragent);
        }

        if (preg_match('/PMT3287_3G/', $useragent)) {
            return new Prestigio\PrestigioPmt32873g($useragent);
        }

        if (preg_match('/PMT3277_3G/', $useragent)) {
            return new Prestigio\PrestigioPmt32773g($useragent);
        }

        if (preg_match('/PMT3037_3G/', $useragent)) {
            return new Prestigio\PrestigioPmt30373g($useragent);
        }

        if (preg_match('/PMT5587_Wi/', $useragent)) {
            return new Prestigio\PrestigioPmt5587wi($useragent);
        }

        if (preg_match('/PMT3377_Wi/', $useragent)) {
            return new Prestigio\PrestigioPmt3377wi($useragent);
        }

        if (preg_match('/PMP7480D3G_QUAD/', $useragent)) {
            return new Prestigio\PrestigioPmp7480D3gQuad($useragent);
        }

        if (preg_match('/PMP7380D3G/', $useragent)) {
            return new Prestigio\PrestigioPmp7380d3g($useragent);
        }

        if (preg_match('/PMP7280C3G_QUAD/', $useragent)) {
            return new Prestigio\PrestigioPmp7280c3gQuad($useragent);
        }

        if (preg_match('/PMP7280C3G/', $useragent)) {
            return new Prestigio\PrestigioPmp7280c3g($useragent);
        }

        if (preg_match('/PMP7170B3G/', $useragent)) {
            return new Prestigio\PrestigioPmp7170B3g($useragent);
        }

        if (preg_match('/PMP7100D3G/', $useragent)) {
            return new Prestigio\PrestigioPmp7100D3g($useragent);
        }

        if (preg_match('/PMP7079D_QUAD/', $useragent)) {
            return new Prestigio\PrestigioPmp7079dQuad($useragent);
        }

        if (preg_match('/PMP7079D3G_QUAD/', $useragent)) {
            return new Prestigio\PrestigioPmp7079d3gQuad($useragent);
        }

        if (preg_match('/PMP7070C3G/', $useragent)) {
            return new Prestigio\PrestigioPmp7070c3g($useragent);
        }

        if (preg_match('/PMP5785C_QUAD/', $useragent)) {
            return new Prestigio\PrestigioPmp5785cQuad($useragent);
        }

        if (preg_match('/PMP5785C3G_QUAD/', $useragent)) {
            return new Prestigio\PrestigioPmp5785c3gQuad($useragent);
        }

        if (preg_match('/PMP5770D/', $useragent)) {
            return new Prestigio\PrestigioPmp5770d($useragent);
        }

        if (preg_match('/PMP5670C_DUO/', $useragent)) {
            return new Prestigio\PrestigioPmp5670c($useragent);
        }

        if (preg_match('/PMP5580C/', $useragent)) {
            return new Prestigio\PrestigioPmp5580c($useragent);
        }

        if (preg_match('/PMP5570C/', $useragent)) {
            return new Prestigio\PrestigioPmp5570c($useragent);
        }

        if (preg_match('/PMP5297C_QUAD/', $useragent)) {
            return new Prestigio\PrestigioPmp5297cQuad($useragent);
        }

        if (preg_match('/PMP5197DULTRA/', $useragent)) {
            return new Prestigio\PrestigioPmp5197dUltra($useragent);
        }

        if (preg_match('/PMP5101C_QUAD/', $useragent)) {
            return new Prestigio\PrestigioPmp5101cQuad($useragent);
        }

        if (preg_match('/PMP5080CPRO/', $useragent)) {
            return new Prestigio\PrestigioPmp5080cPro($useragent);
        }

        if (preg_match('/PMP5080B/', $useragent)) {
            return new Prestigio\MultipadPmp5080b($useragent);
        }

        if (preg_match('/PMP3870C/', $useragent)) {
            return new Prestigio\PrestigioPmp3870c($useragent);
        }

        if (preg_match('/PMP3370B/', $useragent)) {
            return new Prestigio\PrestigioPmp3370b($useragent);
        }

        if (preg_match('/PMP3074BRU/', $useragent)) {
            return new Prestigio\PrestigioPmp3074bru($useragent);
        }

        if (preg_match('/PAP5000TDUO/', $useragent)) {
            return new Prestigio\PrestigioPap5000tDuo($useragent);
        }

        if (preg_match('/PAP5000DUO/', $useragent)) {
            return new Prestigio\PrestigioPap5000Duo($useragent);
        }

        if (preg_match('/PSP8500/', $useragent)) {
            return new Prestigio\PrestigioPsp8500Duo($useragent);
        }

        if (preg_match('/PSP8400/', $useragent)) {
            return new Prestigio\PrestigioPsp8400Duo($useragent);
        }

        if (preg_match('/GV7777/', $useragent)) {
            return new Prestigio\PrestigioGv7777($useragent);
        }

        return new Prestigio\Prestigio($useragent);
    }
}
