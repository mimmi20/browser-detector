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
class LgFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general lg device';

        if (preg_match('/x150/i', $useragent)) {
            $deviceCode = 'x150';
        }

        if (preg_match('/h850/i', $useragent)) {
            $deviceCode = 'h850';
        }

        if (preg_match('/h525n/i', $useragent)) {
            $deviceCode = 'h525n';
        }

        if (preg_match('/h345/i', $useragent)) {
            $deviceCode = 'h345';
        }

        if (preg_match('/h340n/i', $useragent)) {
            $deviceCode = 'h340n';
        }

        if (preg_match('/h320/i', $useragent)) {
            $deviceCode = 'h320';
        }

        if (preg_match('/vs980/i', $useragent)) {
            $deviceCode = 'vs980';
        }

        if (preg_match('/vs880/i', $useragent)) {
            $deviceCode = 'vs880';
        }

        if (preg_match('/vs840/i', $useragent)) {
            $deviceCode = 'vs840 4g';
        }

        if (preg_match('/vs700/i', $useragent)) {
            $deviceCode = 'vs700';
        }

        if (preg_match('/vm701/i', $useragent)) {
            $deviceCode = 'vm701';
        }

        if (preg_match('/vm670/i', $useragent)) {
            $deviceCode = 'vm670';
        }

        if (preg_match('/v935/i', $useragent)) {
            $deviceCode = 'v935';
        }

        if (preg_match('/v900/i', $useragent)) {
            $deviceCode = 'v900';
        }

        if (preg_match('/v700/i', $useragent)) {
            $deviceCode = 'v700';
        }

        if (preg_match('/v500/i', $useragent)) {
            $deviceCode = 'v500';
        }

        if (preg_match('/v490/i', $useragent)) {
            $deviceCode = 'v490';
        }

        if (preg_match('/t500/i', $useragent)) {
            $deviceCode = 't500';
        }

        if (preg_match('/t385/i', $useragent)) {
            $deviceCode = 't385';
        }

        if (preg_match('/t300/i', $useragent)) {
            $deviceCode = 't300';
        }

        if (preg_match('/su760/i', $useragent)) {
            $deviceCode = 'su760';
        }

        if (preg_match('/su660/i', $useragent)) {
            $deviceCode = 'su660';
        }

        if (preg_match('/p999/i', $useragent)) {
            $deviceCode = 'p999';
        }

        if (preg_match('/(p990|optimus 2x)/i', $useragent)) {
            $deviceCode = 'p990';
        }

        if (preg_match('/(p970|optimus\-black)/i', $useragent)) {
            $deviceCode = 'p970';
        }

        if (preg_match('/p940/i', $useragent)) {
            $deviceCode = 'p940';
        }

        if (preg_match('/p936/i', $useragent)) {
            $deviceCode = 'p936';
        }

        if (preg_match('/p925/i', $useragent)) {
            $deviceCode = 'p925';
        }

        if (preg_match('/p920/i', $useragent)) {
            $deviceCode = 'p920';
        }

        if (preg_match('/p895/i', $useragent)) {
            $deviceCode = 'p895';
        }

        if (preg_match('/p880/i', $useragent)) {
            $deviceCode = 'p880';
        }

        if (preg_match('/p875/i', $useragent)) {
            $deviceCode = 'p875';
        }

        if (preg_match('/p765/i', $useragent)) {
            $deviceCode = 'p765';
        }

        if (preg_match('/p760/i', $useragent)) {
            $deviceCode = 'p760';
        }

        if (preg_match('/p720/i', $useragent)) {
            $deviceCode = 'p720';
        }

        if (preg_match('/p713/i', $useragent)) {
            $deviceCode = 'p713';
        }

        if (preg_match('/p710/i', $useragent)) {
            $deviceCode = 'p710';
        }

        if (preg_match('/p705/i', $useragent)) {
            $deviceCode = 'p705';
        }

        if (preg_match('/p700/i', $useragent)) {
            $deviceCode = 'p700';
        }

        if (preg_match('/p698/i', $useragent)) {
            $deviceCode = 'p698';
        }

        if (preg_match('/p690/i', $useragent)) {
            $deviceCode = 'p690';
        }

        if (preg_match('/(p509|optimus\-t)/i', $useragent)) {
            $deviceCode = 'p509';
        }

        if (preg_match('/p505r/i', $useragent)) {
            $deviceCode = 'p505r';
        }

        if (preg_match('/p505/i', $useragent)) {
            $deviceCode = 'p505';
        }

        if (preg_match('/p500h/i', $useragent)) {
            $deviceCode = 'p500h';
        }

        if (preg_match('/p500/i', $useragent)) {
            $deviceCode = 'p500';
        }

        if (preg_match('/p350/i', $useragent)) {
            $deviceCode = 'p350';
        }

        if (preg_match('/nexus ?5x/i', $useragent)) {
            $deviceCode = 'nexus 5x';
        }

        if (preg_match('/nexus ?5/i', $useragent)) {
            $deviceCode = 'nexus 5';
        }

        if (preg_match('/nexus ?4/i', $useragent)) {
            $deviceCode = 'nexus 4';
        }

        if (preg_match('/ms690/i', $useragent)) {
            $deviceCode = 'ms690';
        }

        if (preg_match('/ls860/i', $useragent)) {
            $deviceCode = 'ls860';
        }

        if (preg_match('/ls740/i', $useragent)) {
            $deviceCode = 'ls740';
        }

        if (preg_match('/ls670/i', $useragent)) {
            $deviceCode = 'ls670';
        }

        if (preg_match('/ln510/i', $useragent)) {
            $deviceCode = 'ln510';
        }

        if (preg_match('/l160l/i', $useragent)) {
            $deviceCode = 'l160l';
        }

        if (preg_match('/ku800/i', $useragent)) {
            $deviceCode = 'ku800';
        }

        if (preg_match('/ks365/i', $useragent)) {
            $deviceCode = 'ks365';
        }

        if (preg_match('/ks20/i', $useragent)) {
            $deviceCode = 'ks20';
        }

        if (preg_match('/kp500/i', $useragent)) {
            $deviceCode = 'kp500';
        }

        if (preg_match('/km900/i', $useragent)) {
            $deviceCode = 'km900';
        }

        if (preg_match('/kc910/i', $useragent)) {
            $deviceCode = 'kc910';
        }

        if (preg_match('/hb620t/i', $useragent)) {
            $deviceCode = 'hb620t';
        }

        if (preg_match('/gw300/i', $useragent)) {
            $deviceCode = 'gw300';
        }

        if (preg_match('/gt550/i', $useragent)) {
            $deviceCode = 'gt550';
        }

        if (preg_match('/gt540/i', $useragent)) {
            $deviceCode = 'gt540';
        }

        if (preg_match('/gs290/i', $useragent)) {
            $deviceCode = 'gs290';
        }

        if (preg_match('/gm360/i', $useragent)) {
            $deviceCode = 'gm360';
        }

        if (preg_match('/gd880/i', $useragent)) {
            $deviceCode = 'gd880';
        }

        if (preg_match('/gd350/i', $useragent)) {
            $deviceCode = 'gd350';
        }

        if (preg_match('/ g3 /i', $useragent)) {
            $deviceCode = 'g3';
        }

        if (preg_match('/f240s/i', $useragent)) {
            $deviceCode = 'f240s';
        }

        if (preg_match('/f240k/i', $useragent)) {
            $deviceCode = 'f240k';
        }

        if (preg_match('/f220k/i', $useragent)) {
            $deviceCode = 'f220k';
        }

        if (preg_match('/f200k/i', $useragent)) {
            $deviceCode = 'f200k';
        }

        if (preg_match('/f160k/i', $useragent)) {
            $deviceCode = 'f160k';
        }

        if (preg_match('/f100s/i', $useragent)) {
            $deviceCode = 'f100s';
        }

        if (preg_match('/f100l/i', $useragent)) {
            $deviceCode = 'f100l';
        }

        if (preg_match('/eve/i', $useragent)) {
            $deviceCode = 'eve';
        }

        if (preg_match('/e989/i', $useragent)) {
            $deviceCode = 'e989';
        }

        if (preg_match('/e988/i', $useragent)) {
            $deviceCode = 'e988';
        }

        if (preg_match('/e980h/i', $useragent)) {
            $deviceCode = 'e980h';
        }

        if (preg_match('/e975/i', $useragent)) {
            $deviceCode = 'e975';
        }

        if (preg_match('/e970/i', $useragent)) {
            $deviceCode = 'e970';
        }

        if (preg_match('/e906/i', $useragent)) {
            $deviceCode = 'e906';
        }

        if (preg_match('/e900/i', $useragent)) {
            $deviceCode = 'e900';
        }

        if (preg_match('/e739/i', $useragent)) {
            $deviceCode = 'e739';
        }

        if (preg_match('/e730/i', $useragent)) {
            $deviceCode = 'e730';
        }

        if (preg_match('/e720/i', $useragent)) {
            $deviceCode = 'e720';
        }

        if (preg_match('/e615/i', $useragent)) {
            $deviceCode = 'e615';
        }

        if (preg_match('/e612/i', $useragent)) {
            $deviceCode = 'e612';
        }

        if (preg_match('/e610/i', $useragent)) {
            $deviceCode = 'e610';
        }

        if (preg_match('/e510/i', $useragent)) {
            $deviceCode = 'e510';
        }

        if (preg_match('/e460/i', $useragent)) {
            $deviceCode = 'e460';
        }

        if (preg_match('/e440/i', $useragent)) {
            $deviceCode = 'e440';
        }

        if (preg_match('/e430/i', $useragent)) {
            $deviceCode = 'e430';
        }

        if (preg_match('/e425/i', $useragent)) {
            $deviceCode = 'e425';
        }

        if (preg_match('/e400/i', $useragent)) {
            $deviceCode = 'e400';
        }

        if (preg_match('/d958/i', $useragent)) {
            $deviceCode = 'd958';
        }

        if (preg_match('/d955/i', $useragent)) {
            $deviceCode = 'd955';
        }

        if (preg_match('/d856/i', $useragent)) {
            $deviceCode = 'd856';
        }

        if (preg_match('/d855/i', $useragent)) {
            $deviceCode = 'd855';
        }

        if (preg_match('/d805/i', $useragent)) {
            $deviceCode = 'd805';
        }

        if (preg_match('/d802tr/i', $useragent)) {
            $deviceCode = 'd802tr';
        }

        if (preg_match('/d802/i', $useragent)) {
            $deviceCode = 'd802';
        }

        if (preg_match('/d724/i', $useragent)) {
            $deviceCode = 'd724';
        }

        if (preg_match('/d722/i', $useragent)) {
            $deviceCode = 'd722';
        }

        if (preg_match('/d690/i', $useragent)) {
            $deviceCode = 'd690';
        }

        if (preg_match('/d686/i', $useragent)) {
            $deviceCode = 'd686';
        }

        if (preg_match('/d682tr/i', $useragent)) {
            $deviceCode = 'd682tr';
        }

        if (preg_match('/d682/i', $useragent)) {
            $deviceCode = 'd682';
        }

        if (preg_match('/d620/i', $useragent)) {
            $deviceCode = 'd620';
        }

        if (preg_match('/d618/i', $useragent)) {
            $deviceCode = 'd618';
        }

        if (preg_match('/d605/i', $useragent)) {
            $deviceCode = 'd605';
        }

        if (preg_match('/d415/i', $useragent)) {
            $deviceCode = 'd415';
        }

        if (preg_match('/d410/i', $useragent)) {
            $deviceCode = 'd410';
        }

        if (preg_match('/d373/i', $useragent)) {
            $deviceCode = 'd373';
        }

        if (preg_match('/d325/i', $useragent)) {
            $deviceCode = 'd325';
        }

        if (preg_match('/d320/i', $useragent)) {
            $deviceCode = 'd320';
        }

        if (preg_match('/d300/i', $useragent)) {
            $deviceCode = 'd300';
        }

        if (preg_match('/d295/i', $useragent)) {
            $deviceCode = 'd295';
        }

        if (preg_match('/d290/i', $useragent)) {
            $deviceCode = 'd290';
        }

        if (preg_match('/d285/i', $useragent)) {
            $deviceCode = 'd285';
        }

        if (preg_match('/d280/i', $useragent)) {
            $deviceCode = 'd280';
        }

        if (preg_match('/d213/i', $useragent)) {
            $deviceCode = 'd213';
        }

        if (preg_match('/d160/i', $useragent)) {
            $deviceCode = 'd160';
        }

        if (preg_match('/c660/i', $useragent)) {
            $deviceCode = 'c660';
        }

        if (preg_match('/c550/i', $useragent)) {
            $deviceCode = 'c550';
        }

        if (preg_match('/c330/i', $useragent)) {
            $deviceCode = 'c330';
        }

        if (preg_match('/c199/i', $useragent)) {
            $deviceCode = 'c199';
        }

        if (preg_match('/bl40/i', $useragent)) {
            $deviceCode = 'bl40';
        }

        if (preg_match('/lg900g/i', $useragent)) {
            $deviceCode = '900g';
        }

        if (preg_match('/lg220c/i', $useragent)) {
            $deviceCode = '220c';
        }

        return (new Factory\DeviceFactory())->get($deviceCode, $useragent);
    }
}
