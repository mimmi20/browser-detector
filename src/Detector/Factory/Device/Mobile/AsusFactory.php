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

use BrowserDetector\Detector\Device\Mobile\Asus;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AsusFactory implements FactoryInterface
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
        if (preg_match('/TF101G/i', $useragent)) {
            return new Asus\AsusEepPadTransformerTf101g($useragent);
        }

        if (preg_match('/(Transformer TF201|Transformer Prime TF201)/i', $useragent)) {
            return new Asus\AsusEepPadTransformerTf201($useragent);
        }

        if (preg_match('/z00ad/i', $useragent)) {
            return new Asus\AsusZ00ad($useragent);
        }

        if (preg_match('/k00c/i', $useragent)) {
            return new Asus\AsusFoneK00c($useragent);
        }

        if (preg_match('/k00f/i', $useragent)) {
            return new Asus\AsusFoneK00f($useragent);
        }

        if (preg_match('/k00z/i', $useragent)) {
            return new Asus\AsusFoneK00z($useragent);
        }

        if (preg_match('/k01e/i', $useragent)) {
            return new Asus\AsusFoneK01E($useragent);
        }

        if (preg_match('/k01a/i', $useragent)) {
            return new Asus\AsusFoneK01A($useragent);
        }

        if (preg_match('/k017/i', $useragent)) {
            return new Asus\AsusMemoPadK017($useragent);
        }

        if (preg_match('/K013/i', $useragent)) {
            return new Asus\AsusMemoPadK013($useragent);
        }

        if (preg_match('/K012/i', $useragent)) {
            return new Asus\AsusFoneK012($useragent);
        }

        if (preg_match('/(K00E|ME372CG)/i', $useragent)) {
            return new Asus\AsusFonePad7($useragent);
        }

        if (preg_match('/ME172V/i', $useragent)) {
            return new Asus\AsusMe172v($useragent);
        }

        if (preg_match('/ME173X/i', $useragent)) {
            return new Asus\AsusMe173x($useragent);
        }

        if (preg_match('/ME301T/i', $useragent)) {
            return new Asus\AsusMe301t($useragent);
        }

        if (preg_match('/ME302C/i', $useragent)) {
            return new Asus\AsusMe302c($useragent);
        }

        if (preg_match('/ME302KL/i', $useragent)) {
            return new Asus\AsusMe302kl($useragent);
        }

        if (preg_match('/ME371MG/i', $useragent)) {
            return new Asus\AsusMe371mg($useragent);
        }

        if (preg_match('/P1801\-T/i', $useragent)) {
            return new Asus\AsusP1801t($useragent);
        }

        if (preg_match('/T00J/', $useragent)) {
            return new Asus\AsusT00j($useragent);
        }

        if (preg_match('/T00N/', $useragent)) {
            return new Asus\AsusT00n($useragent);
        }

        if (preg_match('/P01Y/', $useragent)) {
            return new Asus\AsusP01y($useragent);
        }

        if (preg_match('/TF101/i', $useragent)) {
            return new Asus\AsusTf101($useragent);
        }

        if (preg_match('/TF300TL/i', $useragent)) {
            return new Asus\AsusTf300Tl($useragent);
        }

        if (preg_match('/TF300TG/i', $useragent)) {
            return new Asus\AsusTf300Tg($useragent);
        }

        if (preg_match('/TF300T/i', $useragent)) {
            return new Asus\AsusTf300T($useragent);
        }

        if (preg_match('/TF700T/i', $useragent)) {
            return new Asus\AsusTransformerPadTf700T($useragent);
        }

        if (preg_match('/Slider SL101/i', $useragent)) {
            return new Asus\Sl101($useragent);
        }

        if (preg_match('/Garmin\-Asus A50/i', $useragent)) {
            return new Asus\GarminAsusA50($useragent);
        }

        if (preg_match('/Garmin\-Asus A10/i', $useragent)) {
            return new Asus\GarminAsusA10($useragent);
        }

        if (preg_match('/Transformer Prime/i', $useragent)) {
            return new Asus\AsusTransformerPrime($useragent);
        }

        if (preg_match('/padfone t004/i', $useragent)) {
            return new Asus\AsusPadFoneT004($useragent);
        }

        if (preg_match('/padfone 2/i', $useragent)) {
            return new Asus\AsusPadFone2($useragent);
        }

        if (preg_match('/padfone/i', $useragent)) {
            return new Asus\AsusPadFone($useragent);
        }

        if (preg_match('/nexus[ _]?7/i', $useragent)) {
            return new Asus\AsusGalaxyNexus7($useragent);
        }

        if (preg_match('/asus;galaxy6/i', $useragent)) {
            return new Asus\AsusGalaxy6($useragent);
        }

        if (preg_match('/eee_701/i', $useragent)) {
            return new Asus\Eee701($useragent);
        }

        return new Asus\Asus($useragent);
    }
}
