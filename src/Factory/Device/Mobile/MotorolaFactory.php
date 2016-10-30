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

namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MotorolaFactory implements Factory\FactoryInterface
{
    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function detect($useragent)
    {
        $deviceCode = 'general motorola device';

        if (preg_match('/MotoG3/i', $useragent)) {
            $deviceCode = 'motog3';
        }

        if (preg_match('/XT1080/i', $useragent)) {
            $deviceCode = 'xt1080';
        }

        if (preg_match('/XT1068/i', $useragent)) {
            $deviceCode = 'xt1068';
        }

        if (preg_match('/XT1058/i', $useragent)) {
            $deviceCode = 'xt1058';
        }

        if (preg_match('/XT1052/i', $useragent)) {
            $deviceCode = 'xt1052';
        }

        if (preg_match('/XT1039/i', $useragent)) {
            $deviceCode = 'xt1039';
        }

        if (preg_match('/XT1033/i', $useragent)) {
            $deviceCode = 'xt1033';
        }

        if (preg_match('/XT1032/i', $useragent)) {
            $deviceCode = 'xt1032';
        }

        if (preg_match('/XT1021/i', $useragent)) {
            $deviceCode = 'xt1021';
        }

        if (preg_match('/XT926/i', $useragent)) {
            $deviceCode = 'xt926';
        }

        if (preg_match('/XT925/i', $useragent)) {
            $deviceCode = 'xt925';
        }

        if (preg_match('/DROID RAZR HD/i', $useragent)) {
            $deviceCode = 'xt923';
        }

        if (preg_match('/XT910/i', $useragent)) {
            $deviceCode = 'xt910';
        }

        if (preg_match('/XT907/i', $useragent)) {
            $deviceCode = 'xt907';
        }

        if (preg_match('/XT890/i', $useragent)) {
            $deviceCode = 'xt890';
        }

        if (preg_match('/(XT875|DROID BIONIC 4G)/i', $useragent)) {
            $deviceCode = 'xt875';
        }

        if (preg_match('/XT720/i', $useragent)) {
            $deviceCode = 'milestone xt720';
        }

        if (preg_match('/XT702/i', $useragent)) {
            $deviceCode = 'xt702';
        }

        if (preg_match('/XT615/i', $useragent)) {
            $deviceCode = 'xt615';
        }

        if (preg_match('/XT610/i', $useragent)) {
            $deviceCode = 'xt610';
        }

        if (preg_match('/XT530/i', $useragent)) {
            $deviceCode = 'xt530';
        }

        if (preg_match('/XT389/i', $useragent)) {
            $deviceCode = 'xt389';
        }

        if (preg_match('/XT320/i', $useragent)) {
            $deviceCode = 'xt320';
        }

        if (preg_match('/XT316/i', $useragent)) {
            $deviceCode = 'xt316';
        }

        if (preg_match('/XT311/i', $useragent)) {
            $deviceCode = 'xt311';
        }

        if (preg_match('/Xoom/i', $useragent)) {
            $deviceCode = 'xoom';
        }

        if (preg_match('/WX308/i', $useragent)) {
            $deviceCode = 'wx308';
        }

        if (preg_match('/T720/i', $useragent)) {
            $deviceCode = 't720';
        }

        if (preg_match('/RAZRV3x/i', $useragent)) {
            $deviceCode = 'razrv3x';
        }

        if (preg_match('/MOT\-V3i/', $useragent)) {
            $deviceCode = 'razr v3i';
        }

        if (preg_match('/nexus 6/i', $useragent)) {
            $deviceCode = 'nexus 6';
        }

        if (preg_match('/mz608/i', $useragent)) {
            $deviceCode = 'mz608';
        }

        if (preg_match('/(mz607|xoom 2 me)/i', $useragent)) {
            $deviceCode = 'mz607';
        }

        if (preg_match('/(mz616|xoom 2)/i', $useragent)) {
            $deviceCode = 'mz616';
        }

        if (preg_match('/mz615/i', $useragent)) {
            $deviceCode = 'mz615';
        }

        if (preg_match('/mz604/i', $useragent)) {
            $deviceCode = 'mz604';
        }

        if (preg_match('/mz601/i', $useragent)) {
            $deviceCode = 'mz601';
        }

        if (preg_match('/milestone x/i', $useragent)) {
            $deviceCode = 'milestone x';
        }

        if (preg_match('/milestone/i', $useragent)) {
            $deviceCode = 'milestone';
        }

        if (preg_match('/me860/i', $useragent)) {
            $deviceCode = 'me860';
        }

        if (preg_match('/me600/i', $useragent)) {
            $deviceCode = 'me600';
        }

        if (preg_match('/me525/i', $useragent)) {
            $deviceCode = 'me525';
        }

        if (preg_match('/me511/i', $useragent)) {
            $deviceCode = 'me511';
        }

        if (preg_match('/mb860/i', $useragent)) {
            $deviceCode = 'mb860';
        }

        if (preg_match('/mb632/i', $useragent)) {
            $deviceCode = 'mb632';
        }

        if (preg_match('/mb612/i', $useragent)) {
            $deviceCode = 'mb612';
        }

        if (preg_match('/mb526/i', $useragent)) {
            $deviceCode = 'mb526';
        }

        if (preg_match('/mb525/i', $useragent)) {
            $deviceCode = 'mb525';
        }

        if (preg_match('/mb511/i', $useragent)) {
            $deviceCode = 'mb511';
        }

        if (preg_match('/mb300/i', $useragent)) {
            $deviceCode = 'mb300';
        }

        if (preg_match('/mb200/i', $useragent)) {
            $deviceCode = 'mb200';
        }

        if (preg_match('/es405b/i', $useragent)) {
            $deviceCode = 'es405b';
        }

        if (preg_match('/e1000/i', $useragent)) {
            $deviceCode = 'e1000';
        }

        if (preg_match('/DROID X2/i', $useragent)) {
            $deviceCode = 'droid x2';
        }

        if (preg_match('/DROIDX/i', $useragent)) {
            $deviceCode = 'droidx';
        }

        if (preg_match('/DROID RAZR 4G/i', $useragent)) {
            $deviceCode = 'xt912b';
        }

        if (preg_match('/DROID RAZR/i', $useragent)) {
            $deviceCode = 'razr';
        }

        if (preg_match('/DROID Pro/i', $useragent)) {
            $deviceCode = 'droid pro';
        }

        if (preg_match('/droid(\-| )bionic/i', $useragent)) {
            $deviceCode = 'droid bionic';
        }

        if (preg_match('/DROID2/', $useragent)) {
            $deviceCode = 'droid2';
        }

        if (preg_match('/Droid/', $useragent)) {
            $deviceCode = 'droid';
        }

        if (preg_match('/MotoA953/', $useragent)) {
            $deviceCode = 'a953';
        }

        if (preg_match('/MotoQ9c/', $useragent)) {
            $deviceCode = 'q9c';
        }

        if (preg_match('/L7/', $useragent)) {
            $deviceCode = 'slvr l7';
        }

        return (new Factory\DeviceFactory())->get($deviceCode, $useragent);
    }
}
