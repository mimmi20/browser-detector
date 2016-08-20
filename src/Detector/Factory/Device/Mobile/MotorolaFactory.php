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

use BrowserDetector\Detector\Device\Mobile\Motorola;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MotorolaFactory implements FactoryInterface
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
        if (preg_match('/XT1080/i', $useragent)) {
            return new Motorola\MotorolaXt1080($useragent);
        }

        if (preg_match('/XT1068/i', $useragent)) {
            return new Motorola\MotorolaXt1068($useragent);
        }

        if (preg_match('/XT1058/i', $useragent)) {
            return new Motorola\MotorolaXt1058($useragent);
        }

        if (preg_match('/XT1052/i', $useragent)) {
            return new Motorola\MotorolaXt1052($useragent);
        }

        if (preg_match('/XT1039/i', $useragent)) {
            return new Motorola\MotorolaXt1039($useragent);
        }

        if (preg_match('/XT1033/i', $useragent)) {
            return new Motorola\MotorolaXt1033($useragent);
        }

        if (preg_match('/XT1032/i', $useragent)) {
            return new Motorola\MotorolaXt1032($useragent);
        }

        if (preg_match('/XT1021/i', $useragent)) {
            return new Motorola\MotorolaXt1021($useragent);
        }

        if (preg_match('/XT926/i', $useragent)) {
            return new Motorola\MotorolaXt926($useragent);
        }

        if (preg_match('/XT925/i', $useragent)) {
            return new Motorola\MotorolaXt925($useragent);
        }

        if (preg_match('/DROID RAZR HD/i', $useragent)) {
            return new Motorola\MotorolaXt923DroidRazrHd($useragent);
        }

        if (preg_match('/XT910/i', $useragent)) {
            return new Motorola\MotorolaXt910($useragent);
        }

        if (preg_match('/XT907/i', $useragent)) {
            return new Motorola\MotorolaXt907($useragent);
        }

        if (preg_match('/XT890/i', $useragent)) {
            return new Motorola\MotorolaXt890($useragent);
        }

        if (preg_match('/(XT875|DROID BIONIC 4G)/i', $useragent)) {
            return new Motorola\MotorolaDroidBionic4G($useragent);
        }

        if (preg_match('/XT720/i', $useragent)) {
            return new Motorola\MotorolaXt720($useragent);
        }

        if (preg_match('/XT702/i', $useragent)) {
            return new Motorola\MotorolaXt702($useragent);
        }

        if (preg_match('/XT615/i', $useragent)) {
            return new Motorola\MotorolaXt615($useragent);
        }

        if (preg_match('/XT610/i', $useragent)) {
            return new Motorola\MotorolaXt610($useragent);
        }

        if (preg_match('/XT530/i', $useragent)) {
            return new Motorola\MotorolaXt530($useragent);
        }

        if (preg_match('/XT389/i', $useragent)) {
            return new Motorola\MotorolaXt389($useragent);
        }

        if (preg_match('/XT320/i', $useragent)) {
            return new Motorola\MotorolaXt320($useragent);
        }

        if (preg_match('/XT316/i', $useragent)) {
            return new Motorola\MotorolaXt316($useragent);
        }

        if (preg_match('/XT311/i', $useragent)) {
            return new Motorola\MotorolaXt311($useragent);
        }

        if (preg_match('/Xoom/i', $useragent)) {
            return new Motorola\MotorolaXoom($useragent);
        }

        if (preg_match('/WX308/i', $useragent)) {
            return new Motorola\MotorolaWx308($useragent);
        }

        if (preg_match('/T720/i', $useragent)) {
            return new Motorola\MotorolaT720($useragent);
        }

        if (preg_match('/RAZRV3x/i', $useragent)) {
            return new Motorola\MotorolaRazrV3x($useragent);
        }

        if (preg_match('/Nexus 6/i', $useragent)) {
            return new Motorola\MotorolaNexus6($useragent);
        }

        if (preg_match('/MZ608/i', $useragent)) {
            return new Motorola\MotorolaMz608($useragent);
        }

        if (preg_match('/(MZ607|XOOM 2 ME)/i', $useragent)) {
            return new Motorola\MotorolaMz607($useragent);
        }

        if (preg_match('/(MZ616|XOOM 2)/i', $useragent)) {
            return new Motorola\MotorolaMz616($useragent);
        }

        if (preg_match('/MZ615/i', $useragent)) {
            return new Motorola\MotorolaMz615($useragent);
        }

        if (preg_match('/MZ604/i', $useragent)) {
            return new Motorola\MotorolaMz604($useragent);
        }

        if (preg_match('/MZ601/i', $useragent)) {
            return new Motorola\MotorolaMz601($useragent);
        }

        if (preg_match('/Milestone X/i', $useragent)) {
            return new Motorola\MotorolaMilestoneX($useragent);
        }

        if (preg_match('/Milestone/i', $useragent)) {
            return new Motorola\MotorolaMilestone($useragent);
        }

        if (preg_match('/ME860/i', $useragent)) {
            return new Motorola\MotorolaMe860($useragent);
        }

        if (preg_match('/me600/i', $useragent)) {
            return new Motorola\MotorolaMe600($useragent);
        }

        if (preg_match('/me525/i', $useragent)) {
            return new Motorola\MotorolaMe525($useragent);
        }

        if (preg_match('/me511/i', $useragent)) {
            return new Motorola\MotorolaMe511($useragent);
        }

        if (preg_match('/MB860/i', $useragent)) {
            return new Motorola\MotorolaMb860($useragent);
        }

        if (preg_match('/MB632/i', $useragent)) {
            return new Motorola\MotorolaMb632($useragent);
        }

        if (preg_match('/MB526/i', $useragent)) {
            return new Motorola\MotorolaMb526($useragent);
        }

        if (preg_match('/MB525/i', $useragent)) {
            return new Motorola\MotorolaMb525($useragent);
        }

        if (preg_match('/MB511/i', $useragent)) {
            return new Motorola\MotorolaMb511($useragent);
        }

        if (preg_match('/mb300/i', $useragent)) {
            return new Motorola\MotorolaMb300($useragent);
        }

        if (preg_match('/mb200/i', $useragent)) {
            return new Motorola\MotorolaMb200($useragent);
        }

        if (preg_match('/ES405B/i', $useragent)) {
            return new Motorola\MotorolaES405b($useragent);
        }

        if (preg_match('/E1000/i', $useragent)) {
            return new Motorola\MotorolaE1000($useragent);
        }

        if (preg_match('/DROID X2/i', $useragent)) {
            return new Motorola\MotorolaDroidX2($useragent);
        }

        if (preg_match('/DROIDX/i', $useragent)) {
            return new Motorola\MotorolaDroidX($useragent);
        }

        if (preg_match('/DROID RAZR 4G/i', $useragent)) {
            return new Motorola\MotorolaDroidRazr4g($useragent);
        }

        if (preg_match('/DROID RAZR/i', $useragent)) {
            return new Motorola\MotorolaDroidRazr($useragent);
        }

        if (preg_match('/DROID Pro/i', $useragent)) {
            return new Motorola\MotorolaDroidPro($useragent);
        }

        if (preg_match('/droid(\-| )bionic/i', $useragent)) {
            return new Motorola\MotorolaDroidBionic($useragent);
        }

        if (preg_match('/DROID2/', $useragent)) {
            return new Motorola\MotorolaDroid2($useragent);
        }

        if (preg_match('/Droid/', $useragent)) {
            return new Motorola\MotorolaDroid($useragent);
        }

        if (preg_match('/MotoA953/', $useragent)) {
            return new Motorola\MotorolaA953($useragent);
        }

        if (preg_match('/MotoQ9c/', $useragent)) {
            return new Motorola\MotorolaQ9c($useragent);
        }

        return new Motorola\Motorola($useragent);
    }
}
