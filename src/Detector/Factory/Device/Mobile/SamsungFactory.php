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

use BrowserDetector\Detector\Device\Mobile\Samsung;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class SamsungFactory implements FactoryInterface
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
        if (preg_match('/sm\-a9000/i', $useragent)) {
            return new Samsung\SamsungSmA9000($useragent);
        }

        if (preg_match('/sm\-a800f/i', $useragent)) {
            return new Samsung\SamsungSmA800f($useragent);
        }

        if (preg_match('/sm\-a800y/i', $useragent)) {
            return new Samsung\SamsungSmA800y($useragent);
        }

        if (preg_match('/sm\-a800i/i', $useragent)) {
            return new Samsung\SamsungSmA800i($useragent);
        }

        if (preg_match('/sm\-a8000/i', $useragent)) {
            return new Samsung\SamsungSmA8000($useragent);
        }

        if (preg_match('/sm\-s820l/i', $useragent)) {
            return new Samsung\SamsungSmS820l($useragent);
        }

        if (preg_match('/sm\-a710m/i', $useragent)) {
            return new Samsung\SamsungSmA710m($useragent);
        }

        if (preg_match('/sm\-a710fd/i', $useragent)) {
            return new Samsung\SamsungSmA710fd($useragent);
        }

        if (preg_match('/sm\-a710f/i', $useragent)) {
            return new Samsung\SamsungSmA710f($useragent);
        }

        if (preg_match('/sm\-a7100/i', $useragent)) {
            return new Samsung\SamsungSmA7100($useragent);
        }

        if (preg_match('/sm\-a710y/i', $useragent)) {
            return new Samsung\SamsungSmA710y($useragent);
        }

        if (preg_match('/sm\-a700fd/i', $useragent)) {
            return new Samsung\SamsungSmA700fd($useragent);
        }

        if (preg_match('/sm\-a700f/i', $useragent)) {
            return new Samsung\SamsungSmA700f($useragent);
        }

        if (preg_match('/sm\-a700s/i', $useragent)) {
            return new Samsung\SamsungSmA700s($useragent);
        }

        if (preg_match('/sm\-a700k/i', $useragent)) {
            return new Samsung\SamsungSmA700k($useragent);
        }

        if (preg_match('/sm\-a700l/i', $useragent)) {
            return new Samsung\SamsungSmA700l($useragent);
        }

        if (preg_match('/sm\-a700h/i', $useragent)) {
            return new Samsung\SamsungSmA700h($useragent);
        }

        if (preg_match('/sm\-a700yd/i', $useragent)) {
            return new Samsung\SamsungSmA700yd($useragent);
        }

        if (preg_match('/sm\-a7000/i', $useragent)) {
            return new Samsung\SamsungSmA7000($useragent);
        }

        if (preg_match('/sm\-a7009/i', $useragent)) {
            return new Samsung\SamsungSmA7009($useragent);
        }

        if (preg_match('/sm\-a510fd/i', $useragent)) {
            return new Samsung\SamsungSmA510fd($useragent);
        }

        if (preg_match('/sm\-a510f/i', $useragent)) {
            return new Samsung\SamsungSmA510f($useragent);
        }

        if (preg_match('/sm\-a510m/i', $useragent)) {
            return new Samsung\SamsungSmA510m($useragent);
        }

        if (preg_match('/sm\-a510y/i', $useragent)) {
            return new Samsung\SamsungSmA510y($useragent);
        }

        if (preg_match('/sm\-a5100/i', $useragent)) {
            return new Samsung\SamsungSmA5100($useragent);
        }

        if (preg_match('/sm\-a500fu/i', $useragent)) {
            return new Samsung\SamsungSmA500fu($useragent);
        }

        if (preg_match('/sm\-a500f/i', $useragent)) {
            return new Samsung\SamsungSmA500f($useragent);
        }

        if (preg_match('/sm\-a500h/i', $useragent)) {
            return new Samsung\SamsungSmA500h($useragent);
        }

        if (preg_match('/sm\-a500y/i', $useragent)) {
            return new Samsung\SamsungSmA500y($useragent);
        }

        if (preg_match('/sm\-a500l/i', $useragent)) {
            return new Samsung\SamsungSmA500l($useragent);
        }

        if (preg_match('/sm\-a5000/i', $useragent)) {
            return new Samsung\SamsungSmA5000($useragent);
        }

        if (preg_match('/sm\-a310f/i', $useragent)) {
            return new Samsung\SamsungSmA310f($useragent);
        }

        if (preg_match('/sm\-a300fu/i', $useragent)) {
            return new Samsung\SamsungSmA300fu($useragent);
        }

        if (preg_match('/sm\-a300f/i', $useragent)) {
            return new Samsung\SamsungSmA300f($useragent);
        }

        if (preg_match('/sm\-a300h/i', $useragent)) {
            return new Samsung\SamsungSmA300h($useragent);
        }

        if (preg_match('/sm\-j710fn/i', $useragent)) {
            return new Samsung\SamsungSmJ710fn($useragent);
        }

        if (preg_match('/sm\-j710f/i', $useragent)) {
            return new Samsung\SamsungSmJ710f($useragent);
        }

        if (preg_match('/sm\-j710m/i', $useragent)) {
            return new Samsung\SamsungSmJ710m($useragent);
        }

        if (preg_match('/sm\-j710h/i', $useragent)) {
            return new Samsung\SamsungSmJ710h($useragent);
        }

        if (preg_match('/sm\-j700f/i', $useragent)) {
            return new Samsung\SamsungSmJ700f($useragent);
        }

        if (preg_match('/sm\-j700m/i', $useragent)) {
            return new Samsung\SamsungSmJ700m($useragent);
        }

        if (preg_match('/sm\-j700h/i', $useragent)) {
            return new Samsung\SamsungSmJ700h($useragent);
        }

        if (preg_match('/sm\-j510fn/i', $useragent)) {
            return new Samsung\SamsungSmJ510fn($useragent);
        }

        if (preg_match('/sm\-j510f/i', $useragent)) {
            return new Samsung\SamsungSmJ510f($useragent);
        }

        if (preg_match('/sm\-j500fn/i', $useragent)) {
            return new Samsung\SamsungSmJ500fn($useragent);
        }

        if (preg_match('/sm\-j500f/i', $useragent)) {
            return new Samsung\SamsungSmJ500f($useragent);
        }

        if (preg_match('/sm\-j500g/i', $useragent)) {
            return new Samsung\SamsungSmJ500g($useragent);
        }

        if (preg_match('/sm\-j500m/i', $useragent)) {
            return new Samsung\SamsungSmJ500m($useragent);
        }

        if (preg_match('/sm\-j500y/i', $useragent)) {
            return new Samsung\SamsungSmJ500y($useragent);
        }

        if (preg_match('/sm\-j500h/i', $useragent)) {
            return new Samsung\SamsungSmJ500h($useragent);
        }

        if (preg_match('/sm\-j5007/i', $useragent)) {
            return new Samsung\SamsungSmJ5007($useragent);
        }

        if (preg_match('/(sm\-j500|galaxy j5)/i', $useragent)) {
            return new Samsung\SamsungSmJ500($useragent);
        }

        if (preg_match('/sm\-j320g/i', $useragent)) {
            return new Samsung\SamsungSmJ320g($useragent);
        }

        if (preg_match('/sm\-j320fn/i', $useragent)) {
            return new Samsung\SamsungSmJ320fn($useragent);
        }

        if (preg_match('/sm\-j320f/i', $useragent)) {
            return new Samsung\SamsungSmJ320f($useragent);
        }

        if (preg_match('/sm\-j3109/i', $useragent)) {
            return new Samsung\SamsungSmJ3109($useragent);
        }

        if (preg_match('/sm\-j120fn/i', $useragent)) {
            return new Samsung\SamsungSmJ120fn($useragent);
        }

        if (preg_match('/sm\-j120f/i', $useragent)) {
            return new Samsung\SamsungSmJ120f($useragent);
        }

        if (preg_match('/sm\-j120g/i', $useragent)) {
            return new Samsung\SamsungSmJ120g($useragent);
        }

        if (preg_match('/sm\-j120h/i', $useragent)) {
            return new Samsung\SamsungSmJ120h($useragent);
        }

        if (preg_match('/sm\-j120m/i', $useragent)) {
            return new Samsung\SamsungSmJ120m($useragent);
        }

        if (preg_match('/sm\-j110f/i', $useragent)) {
            return new Samsung\SamsungSmJ110f($useragent);
        }

        if (preg_match('/sm\-j110g/i', $useragent)) {
            return new Samsung\SamsungSmJ110g($useragent);
        }

        if (preg_match('/sm\-j110h/i', $useragent)) {
            return new Samsung\SamsungSmJ110h($useragent);
        }

        if (preg_match('/sm\-j110l/i', $useragent)) {
            return new Samsung\SamsungSmJ110l($useragent);
        }

        if (preg_match('/sm\-j110m/i', $useragent)) {
            return new Samsung\SamsungSmJ110m($useragent);
        }

        if (preg_match('/sm\-j111f/i', $useragent)) {
            return new Samsung\SamsungSmJ111f($useragent);
        }

        if (preg_match('/sm\-j105h/i', $useragent)) {
            return new Samsung\SamsungSmJ105h($useragent);
        }

        if (preg_match('/sm\-j100h/i', $useragent)) {
            return new Samsung\SamsungSmJ100h($useragent);
        }

        if (preg_match('/sm\-j100y/i', $useragent)) {
            return new Samsung\SamsungSmJ100y($useragent);
        }

        if (preg_match('/sm\-j100f/i', $useragent)) {
            return new Samsung\SamsungSmJ100f($useragent);
        }

        if (preg_match('/sm\-j100ml/i', $useragent)) {
            return new Samsung\SamsungSmJ100ml($useragent);
        }

        if (preg_match('/sm\-j200gu/i', $useragent)) {
            return new Samsung\SamsungSmJ200gu($useragent);
        }

        if (preg_match('/sm\-j200g/i', $useragent)) {
            return new Samsung\SamsungSmJ200g($useragent);
        }

        if (preg_match('/sm\-j200f/i', $useragent)) {
            return new Samsung\SamsungSmJ200f($useragent);
        }

        if (preg_match('/sm\-j200h/i', $useragent)) {
            return new Samsung\SamsungSmJ200h($useragent);
        }

        if (preg_match('/sm\-j200bt/i', $useragent)) {
            return new Samsung\SamsungSmJ200bt($useragent);
        }

        if (preg_match('/sm\-j200y/i', $useragent)) {
            return new Samsung\SamsungSmJ200y($useragent);
        }

        if (preg_match('/sm\-t280/i', $useragent)) {
            return new Samsung\SamsungSmT280($useragent);
        }

        if (preg_match('/sm\-t2105/i', $useragent)) {
            return new Samsung\SamsungSmT2105($useragent);
        }

        if (preg_match('/sm\-t210r/i', $useragent)) {
            return new Samsung\SamsungSmT210r($useragent);
        }

        if (preg_match('/sm\-t210l/i', $useragent)) {
            return new Samsung\SamsungSmT210l($useragent);
        }

        if (preg_match('/sm\-t210/i', $useragent)) {
            return new Samsung\SamsungSmT210($useragent);
        }

        if (preg_match('/sm\-t900/i', $useragent)) {
            return new Samsung\SamsungSmT900($useragent);
        }

        if (preg_match('/sm\-t819/i', $useragent)) {
            return new Samsung\SamsungSmT819($useragent);
        }

        if (preg_match('/sm\-t815y/i', $useragent)) {
            return new Samsung\SamsungSmT815y($useragent);
        }

        if (preg_match('/sm\-t815/i', $useragent)) {
            return new Samsung\SamsungSmT815($useragent);
        }

        if (preg_match('/sm\-t813/i', $useragent)) {
            return new Samsung\SamsungSmT813($useragent);
        }

        if (preg_match('/sm\-t810x/i', $useragent)) {
            return new Samsung\SamsungSmT810x($useragent);
        }

        if (preg_match('/sm\-t810/i', $useragent)) {
            return new Samsung\SamsungSmT810($useragent);
        }

        if (preg_match('/sm\-t805/i', $useragent)) {
            return new Samsung\SamsungSmT805($useragent);
        }

        if (preg_match('/sm\-t800/i', $useragent)) {
            return new Samsung\SamsungSmT800($useragent);
        }

        if (preg_match('/sm\-t719/i', $useragent)) {
            return new Samsung\SamsungSmT719($useragent);
        }

        if (preg_match('/sm\-t715/i', $useragent)) {
            return new Samsung\SamsungSmT715($useragent);
        }

        if (preg_match('/sm\-t713/i', $useragent)) {
            return new Samsung\SamsungSmT713($useragent);
        }

        if (preg_match('/sm\-t710/i', $useragent)) {
            return new Samsung\SamsungSmT710($useragent);
        }

        if (preg_match('/sm\-t705m/i', $useragent)) {
            return new Samsung\SamsungSmT705m($useragent);
        }

        if (preg_match('/sm\-t705/i', $useragent)) {
            return new Samsung\SamsungSmT705($useragent);
        }

        if (preg_match('/sm\-t700/i', $useragent)) {
            return new Samsung\SamsungSmT700($useragent);
        }

        if (preg_match('/sm\-t670/i', $useragent)) {
            return new Samsung\SamsungSmT670($useragent);
        }

        if (preg_match('/sm\-t585/i', $useragent)) {
            return new Samsung\SamsungSmT585($useragent);
        }

        if (preg_match('/sm\-t580/i', $useragent)) {
            return new Samsung\SamsungSmT580($useragent);
        }

        if (preg_match('/sm\-t550x/i', $useragent)) {
            return new Samsung\SamsungSmT550x($useragent);
        }

        if (preg_match('/sm\-t550/i', $useragent)) {
            return new Samsung\SamsungSmT550($useragent);
        }

        if (preg_match('/sm\-t555/i', $useragent)) {
            return new Samsung\SamsungSmT555($useragent);
        }

        if (preg_match('/sm\-t561/i', $useragent)) {
            return new Samsung\SamsungSmT561($useragent);
        }

        if (preg_match('/sm\-t560/i', $useragent)) {
            return new Samsung\SamsungSmT560($useragent);
        }

        if (preg_match('/sm\-t535/i', $useragent)) {
            return new Samsung\SamsungSmT535($useragent);
        }

        if (preg_match('/sm\-t533/i', $useragent)) {
            return new Samsung\SamsungSmT533($useragent);
        }

        if (preg_match('/(sm\-t531|sm \- t531)/i', $useragent)) {
            return new Samsung\SamsungSmT531($useragent);
        }

        if (preg_match('/sm\-t530nu/i', $useragent)) {
            return new Samsung\SamsungSmT530nu($useragent);
        }

        if (preg_match('/sm\-t530/i', $useragent)) {
            return new Samsung\SamsungSmT530($useragent);
        }

        if (preg_match('/sm\-t525/i', $useragent)) {
            return new Samsung\SamsungSmT525($useragent);
        }

        if (preg_match('/sm\-t520/i', $useragent)) {
            return new Samsung\SamsungSmT520($useragent);
        }

        if (preg_match('/sm\-t365/i', $useragent)) {
            return new Samsung\SamsungSmT365($useragent);
        }

        if (preg_match('/sm\-t355y/i', $useragent)) {
            return new Samsung\SamsungSmT355y($useragent);
        }

        if (preg_match('/sm\-t350/i', $useragent)) {
            return new Samsung\SamsungSmT350($useragent);
        }

        if (preg_match('/sm\-t335/i', $useragent)) {
            return new Samsung\SamsungSmT335($useragent);
        }

        if (preg_match('/sm\-t331/i', $useragent)) {
            return new Samsung\SamsungSmT331($useragent);
        }

        if (preg_match('/sm\-t330/i', $useragent)) {
            return new Samsung\SamsungSmT330($useragent);
        }

        if (preg_match('/sm\-t325/i', $useragent)) {
            return new Samsung\SamsungSmT325($useragent);
        }

        if (preg_match('/sm\-t320/i', $useragent)) {
            return new Samsung\SamsungSmT320($useragent);
        }

        if (preg_match('/sm\-t315/i', $useragent)) {
            return new Samsung\SamsungSmT315($useragent);
        }

        if (preg_match('/sm\-t311/i', $useragent)) {
            return new Samsung\SamsungSmT311($useragent);
        }

        if (preg_match('/sm\-t310/i', $useragent)) {
            return new Samsung\SamsungSmT310($useragent);
        }

        if (preg_match('/sm\-t235/i', $useragent)) {
            return new Samsung\SamsungSmT235($useragent);
        }

        if (preg_match('/sm\-t231/i', $useragent)) {
            return new Samsung\SamsungSmT231($useragent);
        }

        if (preg_match('/sm\-t230nu/i', $useragent)) {
            return new Samsung\SamsungSmT230nu($useragent);
        }

        if (preg_match('/sm\-t230/i', $useragent)) {
            return new Samsung\SamsungSmT230($useragent);
        }

        if (preg_match('/sm\-t211/i', $useragent)) {
            return new Samsung\SamsungSmT211($useragent);
        }

        if (preg_match('/sm\-t116/i', $useragent)) {
            return new Samsung\SamsungSmT116($useragent);
        }

        if (preg_match('/sm\-t113/i', $useragent)) {
            return new Samsung\SamsungSmT113($useragent);
        }

        if (preg_match('/sm\-t111/i', $useragent)) {
            return new Samsung\SamsungSmT111($useragent);
        }

        if (preg_match('/sm\-t110/i', $useragent)) {
            return new Samsung\SamsungSmT110($useragent);
        }

        if (preg_match('/sm\-p907a/i', $useragent)) {
            return new Samsung\SamsungSmP907a($useragent);
        }

        if (preg_match('/sm\-p905m/i', $useragent)) {
            return new Samsung\SamsungSmP905m($useragent);
        }

        if (preg_match('/sm\-p905v/i', $useragent)) {
            return new Samsung\SamsungSmP905v($useragent);
        }

        if (preg_match('/sm\-p905/i', $useragent)) {
            return new Samsung\SamsungSmP905($useragent);
        }

        if (preg_match('/sm\-p901/i', $useragent)) {
            return new Samsung\SamsungSmP901($useragent);
        }

        if (preg_match('/sm\-p900/i', $useragent)) {
            return new Samsung\SamsungSmP900($useragent);
        }

        if (preg_match('/sm\-p605/i', $useragent)) {
            return new Samsung\SamsungSmP605($useragent);
        }

        if (preg_match('/sm\-p601/i', $useragent)) {
            return new Samsung\SamsungSmP601($useragent);
        }

        if (preg_match('/sm\-p600/i', $useragent)) {
            return new Samsung\SamsungSmP600($useragent);
        }

        if (preg_match('/sm\-p550/i', $useragent)) {
            return new Samsung\SamsungSmP550($useragent);
        }

        if (preg_match('/sm\-p355/i', $useragent)) {
            return new Samsung\SamsungSmP355($useragent);
        }

        if (preg_match('/sm\-p350/i', $useragent)) {
            return new Samsung\SamsungSmP350($useragent);
        }

        if (preg_match('/sm\-n930fd/i', $useragent)) {
            return new Samsung\SamsungSmN930FD($useragent);
        }

        if (preg_match('/sm\-n930f/i', $useragent)) {
            return new Samsung\SamsungSmN930F($useragent);
        }

        if (preg_match('/sm\-n930w8/i', $useragent)) {
            return new Samsung\SamsungSmN930W8($useragent);
        }

        if (preg_match('/sm\-n9300/i', $useragent)) {
            return new Samsung\SamsungSmN9300($useragent);
        }

        if (preg_match('/sm\-n9308/i', $useragent)) {
            return new Samsung\SamsungSmN9308($useragent);
        }

        if (preg_match('/sm\-n930k/i', $useragent)) {
            return new Samsung\SamsungSmN930K($useragent);
        }

        if (preg_match('/sm\-n930l/i', $useragent)) {
            return new Samsung\SamsungSmN930L($useragent);
        }

        if (preg_match('/sm\-n930s/i', $useragent)) {
            return new Samsung\SamsungSmN930S($useragent);
        }

        if (preg_match('/sm\-n930az/i', $useragent)) {
            return new Samsung\SamsungSmN930AZ($useragent);
        }

        if (preg_match('/sm\-n930a/i', $useragent)) {
            return new Samsung\SamsungSmN930A($useragent);
        }

        if (preg_match('/sm\-n930t1/i', $useragent)) {
            return new Samsung\SamsungSmN930T1($useragent);
        }

        if (preg_match('/sm\-n930t/i', $useragent)) {
            return new Samsung\SamsungSmN930T($useragent);
        }

        if (preg_match('/sm\-n930r6/i', $useragent)) {
            return new Samsung\SamsungSmN930R6($useragent);
        }

        if (preg_match('/sm\-n930r7/i', $useragent)) {
            return new Samsung\SamsungSmN930R7($useragent);
        }

        if (preg_match('/sm\-n930r4/i', $useragent)) {
            return new Samsung\SamsungSmN930R4($useragent);
        }

        if (preg_match('/sm\-n930p/i', $useragent)) {
            return new Samsung\SamsungSmN930P($useragent);
        }

        if (preg_match('/sm\-n930v/i', $useragent)) {
            return new Samsung\SamsungSmN930V($useragent);
        }

        if (preg_match('/sm\-n930u/i', $useragent)) {
            return new Samsung\SamsungSmN930U($useragent);
        }

        if (preg_match('/sm\-n920a/i', $useragent)) {
            return new Samsung\SamsungSmN920A($useragent);
        }

        if (preg_match('/sm\-n920r/i', $useragent)) {
            return new Samsung\SamsungSmN920R($useragent);
        }

        if (preg_match('/sm\-n920s/i', $useragent)) {
            return new Samsung\SamsungSmN920S($useragent);
        }

        if (preg_match('/sm\-n920k/i', $useragent)) {
            return new Samsung\SamsungSmN920K($useragent);
        }

        if (preg_match('/sm\-n920l/i', $useragent)) {
            return new Samsung\SamsungSmN920L($useragent);
        }

        if (preg_match('/sm\-n920g/i', $useragent)) {
            return new Samsung\SamsungSmN920G($useragent);
        }

        if (preg_match('/sm\-n920c/i', $useragent)) {
            return new Samsung\SamsungSmN920C($useragent);
        }

        if (preg_match('/sm\-n920v/i', $useragent)) {
            return new Samsung\SamsungSmN920V($useragent);
        }

        if (preg_match('/sm\-n920t/i', $useragent)) {
            return new Samsung\SamsungSmN920T($useragent);
        }

        if (preg_match('/sm\-n920p/i', $useragent)) {
            return new Samsung\SamsungSmN920P($useragent);
        }

        if (preg_match('/sm\-n920a/i', $useragent)) {
            return new Samsung\SamsungSmN920A($useragent);
        }

        if (preg_match('/sm\-n920i/i', $useragent)) {
            return new Samsung\SamsungSmN920I($useragent);
        }

        if (preg_match('/sm\-n920w8/i', $useragent)) {
            return new Samsung\SamsungSmN920W8($useragent);
        }

        if (preg_match('/sm\-n9200/i', $useragent)) {
            return new Samsung\SamsungSmN9200($useragent);
        }

        if (preg_match('/sm\-n9208/i', $useragent)) {
            return new Samsung\SamsungSmN9208($useragent);
        }

        if (preg_match('/(sm\-n9009|n9009)/i', $useragent)) {
            return new Samsung\SamsungSmN9009($useragent);
        }

        if (preg_match('/sm\-n9008v/i', $useragent)) {
            return new Samsung\SamsungSmN9008V($useragent);
        }

        if (preg_match('/(sm\-n9007|N9007)/i', $useragent)) {
            return new Samsung\SamsungSmN9007($useragent);
        }

        if (preg_match('/(sm\-n9006|n9006)/i', $useragent)) {
            return new Samsung\SamsungSmN9006($useragent);
        }

        if (preg_match('/(sm\-n9005|n9005)/i', $useragent)) {
            return new Samsung\SamsungSmN9005($useragent);
        }

        if (preg_match('/(sm\-n9002|n9002)/i', $useragent)) {
            return new Samsung\SamsungSmN9002($useragent);
        }

        if (preg_match('/sm\-n8000/i', $useragent)) {
            return new Samsung\SamsungSmN8000($useragent);
        }

        if (preg_match('/sm\-n7505l/i', $useragent)) {
            return new Samsung\SamsungSmN7505L($useragent);
        }

        if (preg_match('/sm\-n7505/i', $useragent)) {
            return new Samsung\SamsungSmN7505($useragent);
        }

        if (preg_match('/sm\-n7502/i', $useragent)) {
            return new Samsung\SamsungSmN7502($useragent);
        }

        if (preg_match('/sm\-n7500q/i', $useragent)) {
            return new Samsung\SamsungSmN7500Q($useragent);
        }

        if (preg_match('/sm\-n750/i', $useragent)) {
            return new Samsung\SamsungSmN750($useragent);
        }

        if (preg_match('/sm\-n916s/i', $useragent)) {
            return new Samsung\SamsungSmN916s($useragent);
        }

        if (preg_match('/sm\-n915fy/i', $useragent)) {
            return new Samsung\SamsungSmN915fy($useragent);
        }

        if (preg_match('/sm\-n915f/i', $useragent)) {
            return new Samsung\SamsungSmN915f($useragent);
        }

        if (preg_match('/sm\-n915t/i', $useragent)) {
            return new Samsung\SamsungSmN915t($useragent);
        }

        if (preg_match('/sm\-n915g/i', $useragent)) {
            return new Samsung\SamsungSmN915g($useragent);
        }

        if (preg_match('/sm\-n915p/i', $useragent)) {
            return new Samsung\SamsungSmN915p($useragent);
        }

        if (preg_match('/sm\-n915a/i', $useragent)) {
            return new Samsung\SamsungSmN915a($useragent);
        }

        if (preg_match('/sm\-n915v/i', $useragent)) {
            return new Samsung\SamsungSmN915v($useragent);
        }

        if (preg_match('/sm\-n915d/i', $useragent)) {
            return new Samsung\SamsungSmN915d($useragent);
        }

        if (preg_match('/sm\-n915k/i', $useragent)) {
            return new Samsung\SamsungSmN915k($useragent);
        }

        if (preg_match('/sm\-n915l/i', $useragent)) {
            return new Samsung\SamsungSmN915l($useragent);
        }

        if (preg_match('/sm\-n915s/i', $useragent)) {
            return new Samsung\SamsungSmN915s($useragent);
        }

        if (preg_match('/sm\-n9150/i', $useragent)) {
            return new Samsung\SamsungSmN9150($useragent);
        }

        if (preg_match('/sm\-n910v/i', $useragent)) {
            return new Samsung\SamsungSmN910V($useragent);
        }

        if (preg_match('/sm\-n910fq/i', $useragent)) {
            return new Samsung\SamsungSmN910FQ($useragent);
        }

        if (preg_match('/sm\-n910fd/i', $useragent)) {
            return new Samsung\SamsungSmN910FD($useragent);
        }

        if (preg_match('/sm\-n910f/i', $useragent)) {
            return new Samsung\SamsungSmN910F($useragent);
        }

        if (preg_match('/sm\-n910c/i', $useragent)) {
            return new Samsung\SamsungSmN910C($useragent);
        }

        if (preg_match('/sm\-n910a/i', $useragent)) {
            return new Samsung\SamsungSmN910A($useragent);
        }

        if (preg_match('/sm\-n910h/i', $useragent)) {
            return new Samsung\SamsungSmN910H($useragent);
        }

        if (preg_match('/sm\-n910k/i', $useragent)) {
            return new Samsung\SamsungSmN910K($useragent);
        }

        if (preg_match('/sm\-n910p/i', $useragent)) {
            return new Samsung\SamsungSmN910P($useragent);
        }

        if (preg_match('/sm\-n910x/i', $useragent)) {
            return new Samsung\SamsungSmN910X($useragent);
        }

        if (preg_match('/sm\-n910s/i', $useragent)) {
            return new Samsung\SamsungSmN910S($useragent);
        }

        if (preg_match('/sm\-n910l/i', $useragent)) {
            return new Samsung\SamsungSmN910L($useragent);
        }

        if (preg_match('/sm\-n910g/i', $useragent)) {
            return new Samsung\SamsungSmN910G($useragent);
        }

        if (preg_match('/sm\-n910m/i', $useragent)) {
            return new Samsung\SamsungSmN910M($useragent);
        }

        if (preg_match('/sm\-n910t1/i', $useragent)) {
            return new Samsung\SamsungSmN910T1($useragent);
        }

        if (preg_match('/sm\-n910t3/i', $useragent)) {
            return new Samsung\SamsungSmN910T3($useragent);
        }

        if (preg_match('/sm\-n910t/i', $useragent)) {
            return new Samsung\SamsungSmN910T($useragent);
        }

        if (preg_match('/sm\-n910u/i', $useragent)) {
            return new Samsung\SamsungSmN910U($useragent);
        }

        if (preg_match('/sm\-n910r4/i', $useragent)) {
            return new Samsung\SamsungSmN910R4($useragent);
        }

        if (preg_match('/sm\-n910w8/i', $useragent)) {
            return new Samsung\SamsungSmN910W8($useragent);
        }

        if (preg_match('/sm\-n9100h/i', $useragent)) {
            return new Samsung\SamsungSmN9100H($useragent);
        }

        if (preg_match('/sm\-n9100/i', $useragent)) {
            return new Samsung\SamsungSmN9100($useragent);
        }

        if (preg_match('/sm\-n900v/i', $useragent)) {
            return new Samsung\SamsungSmN900V($useragent);
        }

        if (preg_match('/sm\-n900a/i', $useragent)) {
            return new Samsung\SamsungSmN900A($useragent);
        }

        if (preg_match('/sm\-n900s/i', $useragent)) {
            return new Samsung\SamsungSmN900S($useragent);
        }

        if (preg_match('/sm\-n900t/i', $useragent)) {
            return new Samsung\SamsungSmN900T($useragent);
        }

        if (preg_match('/sm\-n900p/i', $useragent)) {
            return new Samsung\SamsungSmN900P($useragent);
        }

        if (preg_match('/sm\-n900l/i', $useragent)) {
            return new Samsung\SamsungSmN900L($useragent);
        }

        if (preg_match('/sm\-n900k/i', $useragent)) {
            return new Samsung\SamsungSmN900K($useragent);
        }

        if (preg_match('/sm\-n9000q/i', $useragent)) {
            return new Samsung\SamsungSmN9000Q($useragent);
        }

        if (preg_match('/sm\-n900w8/i', $useragent)) {
            return new Samsung\SamsungSmN900W8($useragent);
        }

        if (preg_match('/sm\-n900/i', $useragent)) {
            return new Samsung\SamsungSmN900($useragent);
        }

        if (preg_match('/sm\-g935fd/i', $useragent)) {
            return new Samsung\SamsungSmG935FD($useragent);
        }

        if (preg_match('/sm\-g935f/i', $useragent)) {
            return new Samsung\SamsungSmG935F($useragent);
        }

        if (preg_match('/sm\-g935a/i', $useragent)) {
            return new Samsung\SamsungSmG935A($useragent);
        }

        if (preg_match('/sm\-g935p/i', $useragent)) {
            return new Samsung\SamsungSmG935P($useragent);
        }

        if (preg_match('/sm\-g935r/i', $useragent)) {
            return new Samsung\SamsungSmG935R($useragent);
        }

        if (preg_match('/sm\-g935t/i', $useragent)) {
            return new Samsung\SamsungSmG935T($useragent);
        }

        if (preg_match('/sm\-g935v/i', $useragent)) {
            return new Samsung\SamsungSmG935V($useragent);
        }

        if (preg_match('/sm\-g935w8/i', $useragent)) {
            return new Samsung\SamsungSmG935W8($useragent);
        }

        if (preg_match('/sm\-g935k/i', $useragent)) {
            return new Samsung\SamsungSmG935K($useragent);
        }

        if (preg_match('/sm\-g935l/i', $useragent)) {
            return new Samsung\SamsungSmG935L($useragent);
        }

        if (preg_match('/sm\-g935s/i', $useragent)) {
            return new Samsung\SamsungSmG935S($useragent);
        }

        if (preg_match('/sm\-g935x/i', $useragent)) {
            return new Samsung\SamsungSmG935X($useragent);
        }

        if (preg_match('/sm\-g9350/i', $useragent)) {
            return new Samsung\SamsungSmG9350($useragent);
        }

        if (preg_match('/sm\-g930fd/i', $useragent)) {
            return new Samsung\SamsungSmG930FD($useragent);
        }

        if (preg_match('/sm\-g930f/i', $useragent)) {
            return new Samsung\SamsungSmG930F($useragent);
        }

        if (preg_match('/sm\-g9308/i', $useragent)) {
            return new Samsung\SamsungSmG9308($useragent);
        }

        if (preg_match('/sm\-g930a/i', $useragent)) {
            return new Samsung\SamsungSmG930A($useragent);
        }

        if (preg_match('/sm\-g930p/i', $useragent)) {
            return new Samsung\SamsungSmG930P($useragent);
        }

        if (preg_match('/sm\-g930v/i', $useragent)) {
            return new Samsung\SamsungSmG930V($useragent);
        }

        if (preg_match('/sm\-g930r/i', $useragent)) {
            return new Samsung\SamsungSmG930R($useragent);
        }

        if (preg_match('/sm\-g930t/i', $useragent)) {
            return new Samsung\SamsungSmG930T($useragent);
        }

        if (preg_match('/sm\-g930/i', $useragent)) {
            return new Samsung\SamsungSmG930($useragent);
        }

        if (preg_match('/sm\-g9006v/i', $useragent)) {
            return new Samsung\SamsungSmG9006v($useragent);
        }

        if (preg_match('/sm\-g928f/i', $useragent)) {
            return new Samsung\SamsungSmG928F($useragent);
        }

        if (preg_match('/sm\-g928v/i', $useragent)) {
            return new Samsung\SamsungSmG928V($useragent);
        }

        if (preg_match('/sm\-g928w8/i', $useragent)) {
            return new Samsung\SamsungSmG928W8($useragent);
        }

        if (preg_match('/sm\-g928c/i', $useragent)) {
            return new Samsung\SamsungSmG928C($useragent);
        }

        if (preg_match('/sm\-g928g/i', $useragent)) {
            return new Samsung\SamsungSmG928G($useragent);
        }

        if (preg_match('/sm\-g928p/i', $useragent)) {
            return new Samsung\SamsungSmG928P($useragent);
        }

        if (preg_match('/sm\-g928i/i', $useragent)) {
            return new Samsung\SamsungSmG928I($useragent);
        }

        if (preg_match('/sm\-g9287/i', $useragent)) {
            return new Samsung\SamsungSmG9287($useragent);
        }

        if (preg_match('/sm\-g925f/i', $useragent)) {
            return new Samsung\SamsungSmG925F($useragent);
        }

        if (preg_match('/sm\-g925t/i', $useragent)) {
            return new Samsung\SamsungSmG925T($useragent);
        }

        if (preg_match('/sm\-g925r4/i', $useragent)) {
            return new Samsung\SamsungSmG925R4($useragent);
        }

        if (preg_match('/sm\-g925i/i', $useragent)) {
            return new Samsung\SamsungSmG925I($useragent);
        }

        if (preg_match('/sm\-g925p/i', $useragent)) {
            return new Samsung\SamsungSmG925P($useragent);
        }

        if (preg_match('/sm\-g925k/i', $useragent)) {
            return new Samsung\SamsungSmG925k($useragent);
        }

        if (preg_match('/sm\-g920k/i', $useragent)) {
            return new Samsung\SamsungSmG920K($useragent);
        }

        if (preg_match('/sm\-g920l/i', $useragent)) {
            return new Samsung\SamsungSmG920L($useragent);
        }

        if (preg_match('/sm\-g920p/i', $useragent)) {
            return new Samsung\SamsungSmG920P($useragent);
        }

        if (preg_match('/sm\-g920v/i', $useragent)) {
            return new Samsung\SamsungSmG920V($useragent);
        }

        if (preg_match('/sm\-g920t1/i', $useragent)) {
            return new Samsung\SamsungSmG920T1($useragent);
        }

        if (preg_match('/sm\-g920t/i', $useragent)) {
            return new Samsung\SamsungSmG920T($useragent);
        }

        if (preg_match('/sm\-g920a/i', $useragent)) {
            return new Samsung\SamsungSmG920A($useragent);
        }

        if (preg_match('/sm\-g920fd/i', $useragent)) {
            return new Samsung\SamsungSmG920Fd($useragent);
        }

        if (preg_match('/sm\-g920f/i', $useragent)) {
            return new Samsung\SamsungSmG920F($useragent);
        }

        if (preg_match('/sm\-g920i/i', $useragent)) {
            return new Samsung\SamsungSmG920I($useragent);
        }

        if (preg_match('/sm\-g920s/i', $useragent)) {
            return new Samsung\SamsungSmG920S($useragent);
        }

        if (preg_match('/sm\-g9200/i', $useragent)) {
            return new Samsung\SamsungSmG9200($useragent);
        }

        if (preg_match('/sm\-g9208/i', $useragent)) {
            return new Samsung\SamsungSmG9208($useragent);
        }

        if (preg_match('/sm\-g9209/i', $useragent)) {
            return new Samsung\SamsungSmG9209($useragent);
        }

        if (preg_match('/sm\-g920r/i', $useragent)) {
            return new Samsung\SamsungSmG920R($useragent);
        }

        if (preg_match('/sm\-g920w8/i', $useragent)) {
            return new Samsung\SamsungSmG920W8($useragent);
        }

        if (preg_match('/sm\-g903f/i', $useragent)) {
            return new Samsung\SamsungSmG903F($useragent);
        }

        if (preg_match('/sm\-g901f/i', $useragent)) {
            return new Samsung\SamsungSmG901F($useragent);
        }

        if (preg_match('/sm\-g900w8/i', $useragent)) {
            return new Samsung\SamsungSmG900w8($useragent);
        }

        if (preg_match('/sm\-g900v/i', $useragent)) {
            return new Samsung\SamsungSmG900V($useragent);
        }

        if (preg_match('/sm\-g900t/i', $useragent)) {
            return new Samsung\SamsungSmG900T($useragent);
        }

        if (preg_match('/sm\-g900i/i', $useragent)) {
            return new Samsung\SamsungSmG900i($useragent);
        }

        if (preg_match('/sm\-g900f/i', $useragent)) {
            return new Samsung\SamsungSmG900F($useragent);
        }

        if (preg_match('/sm\-g900a/i', $useragent)) {
            return new Samsung\SamsungSmG900a($useragent);
        }

        if (preg_match('/sm\-g900h/i', $useragent)) {
            return new Samsung\SamsungSmG900h($useragent);
        }

        if (preg_match('/sm\-g900/i', $useragent)) {
            return new Samsung\SamsungSmG900($useragent);
        }

        if (preg_match('/sm\-g890a/i', $useragent)) {
            return new Samsung\SamsungSmG890a($useragent);
        }

        if (preg_match('/sm\-g870f/i', $useragent)) {
            return new Samsung\SamsungSmG870F($useragent);
        }

        if (preg_match('/sm\-g870a/i', $useragent)) {
            return new Samsung\SamsungSmG870a($useragent);
        }

        if (preg_match('/sm\-g850fq/i', $useragent)) {
            return new Samsung\SamsungSmG850fq($useragent);
        }

        if (preg_match('/(sm\-g850f|galaxy alpha)/i', $useragent)) {
            return new Samsung\SamsungSmG850F($useragent);
        }

        if (preg_match('/sm\-g850a/i', $useragent)) {
            return new Samsung\SamsungSmG850a($useragent);
        }

        if (preg_match('/sm\-g850m/i', $useragent)) {
            return new Samsung\SamsungSmG850m($useragent);
        }

        if (preg_match('/sm\-g850t/i', $useragent)) {
            return new Samsung\SamsungSmG850t($useragent);
        }

        if (preg_match('/sm\-g850w/i', $useragent)) {
            return new Samsung\SamsungSmG850w($useragent);
        }

        if (preg_match('/sm\-g850y/i', $useragent)) {
            return new Samsung\SamsungSmG850y($useragent);
        }

        if (preg_match('/sm\-g800hq/i', $useragent)) {
            return new Samsung\SamsungSmG800HQ($useragent);
        }

        if (preg_match('/sm\-g800h/i', $useragent)) {
            return new Samsung\SamsungSmG800h($useragent);
        }

        if (preg_match('/sm\-g800f/i', $useragent)) {
            return new Samsung\SamsungSmG800F($useragent);
        }

        if (preg_match('/sm\-g800m/i', $useragent)) {
            return new Samsung\SamsungSmG800M($useragent);
        }

        if (preg_match('/sm\-g800a/i', $useragent)) {
            return new Samsung\SamsungSmG800A($useragent);
        }

        if (preg_match('/sm\-g800r4/i', $useragent)) {
            return new Samsung\SamsungSmG800R4($useragent);
        }

        if (preg_match('/sm\-g800y/i', $useragent)) {
            return new Samsung\SamsungSmG800Y($useragent);
        }

        if (preg_match('/sm\-g720n0/i', $useragent)) {
            return new Samsung\SamsungSmG720n0($useragent);
        }

        if (preg_match('/sm\-g720d/i', $useragent)) {
            return new Samsung\SamsungSmG720d($useragent);
        }

        if (preg_match('/sm\-g7202/i', $useragent)) {
            return new Samsung\SamsungSmG7202($useragent);
        }

        if (preg_match('/sm\-g7102t/i', $useragent)) {
            return new Samsung\SamsungSmG7102T($useragent);
        }

        if (preg_match('/sm\-g7102/i', $useragent)) {
            return new Samsung\SamsungSmG7102($useragent);
        }

        if (preg_match('/sm\-g7105l/i', $useragent)) {
            return new Samsung\SamsungSmG7105L($useragent);
        }

        if (preg_match('/sm\-g7105/i', $useragent)) {
            return new Samsung\SamsungSmG7105($useragent);
        }

        if (preg_match('/sm\-g7106/i', $useragent)) {
            return new Samsung\SamsungSmG7106($useragent);
        }

        if (preg_match('/sm\-g7108v/i', $useragent)) {
            return new Samsung\SamsungSmG7108V($useragent);
        }

        if (preg_match('/sm\-g7108/i', $useragent)) {
            return new Samsung\SamsungSmG7108($useragent);
        }

        if (preg_match('/sm\-g7109/i', $useragent)) {
            return new Samsung\SamsungSmG7109($useragent);
        }

        if (preg_match('/sm\-g710l/i', $useragent)) {
            return new Samsung\SamsungSmG710L($useragent);
        }

        if (preg_match('/sm\-g710/i', $useragent)) {
            return new Samsung\SamsungSmG710($useragent);
        }

        if (preg_match('/sm\-g531f/i', $useragent)) {
            return new Samsung\SamsungSmG531f($useragent);
        }

        if (preg_match('/sm\-g531h/i', $useragent)) {
            return new Samsung\SamsungSmG531h($useragent);
        }

        if (preg_match('/sm\-g530t/i', $useragent)) {
            return new Samsung\SamsungSmG530t($useragent);
        }

        if (preg_match('/sm\-g530h/i', $useragent)) {
            return new Samsung\SamsungSmG530h($useragent);
        }

        if (preg_match('/sm\-g530fz/i', $useragent)) {
            return new Samsung\SamsungSmG530fz($useragent);
        }

        if (preg_match('/sm\-g530f/i', $useragent)) {
            return new Samsung\SamsungSmG530f($useragent);
        }

        if (preg_match('/sm\-g530y/i', $useragent)) {
            return new Samsung\SamsungSmG530y($useragent);
        }

        if (preg_match('/sm\-g530m/i', $useragent)) {
            return new Samsung\SamsungSmG530m($useragent);
        }

        if (preg_match('/sm\-g530bt/i', $useragent)) {
            return new Samsung\SamsungSmG530bt($useragent);
        }

        if (preg_match('/sm\-g5306w/i', $useragent)) {
            return new Samsung\SamsungSmG5306w($useragent);
        }

        if (preg_match('/sm\-g5308w/i', $useragent)) {
            return new Samsung\SamsungSmG5308w($useragent);
        }

        if (preg_match('/sm\-g389f/i', $useragent)) {
            return new Samsung\SamsungSmG389F($useragent);
        }

        if (preg_match('/sm\-g3815/i', $useragent)) {
            return new Samsung\SamsungSmG3815($useragent);
        }

        if (preg_match('/sm\-g388f/i', $useragent)) {
            return new Samsung\SamsungSmG388F($useragent);
        }

        if (preg_match('/sm\-g386f/i', $useragent)) {
            return new Samsung\SamsungSmG386F($useragent);
        }

        if (preg_match('/sm\-g361f/i', $useragent)) {
            return new Samsung\SamsungSmG361F($useragent);
        }

        if (preg_match('/sm\-g361h/i', $useragent)) {
            return new Samsung\SamsungSmG361h($useragent);
        }

        if (preg_match('/sm\-g360hu/i', $useragent)) {
            return new Samsung\SamsungSmG360HU($useragent);
        }

        if (preg_match('/sm\-g360h/i', $useragent)) {
            return new Samsung\SamsungSmG360H($useragent);
        }

        if (preg_match('/sm\-g360t1/i', $useragent)) {
            return new Samsung\SamsungSmG360T1($useragent);
        }

        if (preg_match('/sm\-g360t/i', $useragent)) {
            return new Samsung\SamsungSmG360T($useragent);
        }

        if (preg_match('/sm\-g360bt/i', $useragent)) {
            return new Samsung\SamsungSmG360BT($useragent);
        }

        if (preg_match('/sm\-g360f/i', $useragent)) {
            return new Samsung\SamsungSmG360F($useragent);
        }

        if (preg_match('/sm\-g360g/i', $useragent)) {
            return new Samsung\SamsungSmG360G($useragent);
        }

        if (preg_match('/sm\-g360az/i', $useragent)) {
            return new Samsung\SamsungSmG360AZ($useragent);
        }

        if (preg_match('/sm\-g357fz/i', $useragent)) {
            return new Samsung\SamsungSmG357fz($useragent);
        }

        if (preg_match('/sm\-g355hq/i', $useragent)) {
            return new Samsung\SamsungSmG355hq($useragent);
        }

        if (preg_match('/sm\-g355hn/i', $useragent)) {
            return new Samsung\SamsungSmG355hn($useragent);
        }

        if (preg_match('/sm\-g355h/i', $useragent)) {
            return new Samsung\SamsungSmG355h($useragent);
        }

        if (preg_match('/sm\-g355m/i', $useragent)) {
            return new Samsung\SamsungSmG355m($useragent);
        }

        if (preg_match('/sm\-g3502l/i', $useragent)) {
            return new Samsung\SamsungSmG3502l($useragent);
        }

        if (preg_match('/sm\-g3502t/i', $useragent)) {
            return new Samsung\SamsungSmG3502t($useragent);
        }

        if (preg_match('/sm\-g3500/i', $useragent)) {
            return new Samsung\SamsungSmG3500($useragent);
        }

        if (preg_match('/sm\-g350e/i', $useragent)) {
            return new Samsung\SamsungSmG350e($useragent);
        }

        if (preg_match('/sm\-g350/i', $useragent)) {
            return new Samsung\SamsungSmG350($useragent);
        }

        if (preg_match('/sm\-g318h/i', $useragent)) {
            return new Samsung\SamsungSmG318h($useragent);
        }

        if (preg_match('/sm\-g313hu/i', $useragent)) {
            return new Samsung\SamsungSmG313hu($useragent);
        }

        if (preg_match('/sm\-g313hn/i', $useragent)) {
            return new Samsung\SamsungSmG313hn($useragent);
        }

        if (preg_match('/sm\-g310hn/i', $useragent)) {
            return new Samsung\SamsungSmG310hn($useragent);
        }

        if (preg_match('/sm\-g130h/i', $useragent)) {
            return new Samsung\SamsungSmG130H($useragent);
        }

        if (preg_match('/sm\-g110h/i', $useragent)) {
            return new Samsung\SamsungSmG110H($useragent);
        }

        if (preg_match('/sm\-e700f/i', $useragent)) {
            return new Samsung\SamsungSmE700f($useragent);
        }

        if (preg_match('/sm\-e700h/i', $useragent)) {
            return new Samsung\SamsungSmE700h($useragent);
        }

        if (preg_match('/sm\-e700m/i', $useragent)) {
            return new Samsung\SamsungSmE700m($useragent);
        }

        if (preg_match('/sm\-e7000/i', $useragent)) {
            return new Samsung\SamsungSmE7000($useragent);
        }

        if (preg_match('/sm\-e7009/i', $useragent)) {
            return new Samsung\SamsungSmE7009($useragent);
        }

        if (preg_match('/sm\-e500h/i', $useragent)) {
            return new Samsung\SamsungSmE500H($useragent);
        }

        if (preg_match('/sm\-c115/i', $useragent)) {
            return new Samsung\SamsungSmC115($useragent);
        }

        if (preg_match('/sm\-c111/i', $useragent)) {
            return new Samsung\SamsungSmC111($useragent);
        }

        if (preg_match('/sm\-c105/i', $useragent)) {
            return new Samsung\SamsungSmC105($useragent);
        }

        if (preg_match('/sm\-c101/i', $useragent)) {
            return new Samsung\SamsungSmC101($useragent);
        }

        if (preg_match('/sm\-z130h/i', $useragent)) {
            return new Samsung\SamsungSmZ130H($useragent);
        }

        if (preg_match('/sm\-b550h/i', $useragent)) {
            return new Samsung\SamsungSmB550h($useragent);
        }

        if (preg_match('/sgh\-t999/i', $useragent)) {
            return new Samsung\SamsungSghT999($useragent);
        }

        if (preg_match('/sgh\-t989d/i', $useragent)) {
            return new Samsung\SamsungSghT989d($useragent);
        }

        if (preg_match('/sgh\-t989/i', $useragent)) {
            return new Samsung\SamsungSghT989($useragent);
        }

        if (preg_match('/sgh\-t959v/i', $useragent)) {
            return new Samsung\SamsungSghT959v($useragent);
        }

        if (preg_match('/sgh\-t959/i', $useragent)) {
            return new Samsung\SamsungSghT959($useragent);
        }

        if (preg_match('/sgh\-t899m/i', $useragent)) {
            return new Samsung\SamsungSghT899m($useragent);
        }

        if (preg_match('/sgh\-t889/i', $useragent)) {
            return new Samsung\SamsungSghT889($useragent);
        }

        if (preg_match('/sgh\-t859/i', $useragent)) {
            return new Samsung\SamsungSghT859($useragent);
        }

        if (preg_match('/sgh\-t839/i', $useragent)) {
            return new Samsung\SamsungSghT839($useragent);
        }

        if (preg_match('/(sgh\-t769|blaze)/i', $useragent)) {
            return new Samsung\SamsungSghT769($useragent);
        }

        if (preg_match('/sgh\-t759/i', $useragent)) {
            return new Samsung\SamsungSghT759($useragent);
        }

        if (preg_match('/sgh\-t669/i', $useragent)) {
            return new Samsung\SamsungSghT669($useragent);
        }

        if (preg_match('/sgh\-t528g/i', $useragent)) {
            return new Samsung\SamsungSghT528g($useragent);
        }

        if (preg_match('/sgh\-t499/i', $useragent)) {
            return new Samsung\SamsungSghT499($useragent);
        }

        if (preg_match('/sgh\-m919/i', $useragent)) {
            return new Samsung\SamsungSghm919($useragent);
        }

        if (preg_match('/sgh\-i997r/i', $useragent)) {
            return new Samsung\SamsungSghi997r($useragent);
        }

        if (preg_match('/sgh\-i997/i', $useragent)) {
            return new Samsung\SamsungSghi997($useragent);
        }

        if (preg_match('/SGH\-I957R/i', $useragent)) {
            return new Samsung\SamsungSghi957r($useragent);
        }

        if (preg_match('/SGH\-i957/i', $useragent)) {
            return new Samsung\SamsungSghi957($useragent);
        }

        if (preg_match('/sgh\-i917/i', $useragent)) {
            return new Samsung\SamsungSghi917($useragent);
        }

        if (preg_match('/sgh-i900v/i', $useragent)) {
            return new Samsung\SamsungSghi900V($useragent);
        }

        if (preg_match('/sgh\-i900/i', $useragent)) {
            return new Samsung\SamsungSghi900($useragent);
        }

        if (preg_match('/sgh\-i897/i', $useragent)) {
            return new Samsung\SamsungSghi897($useragent);
        }

        if (preg_match('/sgh\-i857/i', $useragent)) {
            return new Samsung\SamsungSghi857($useragent);
        }

        if (preg_match('/sgh\-i780/i', $useragent)) {
            return new Samsung\SamsungSghi780($useragent);
        }

        if (preg_match('/sgh\-i777/i', $useragent)) {
            return new Samsung\SamsungSghi777($useragent);
        }

        if (preg_match('/sgh\-i747m/i', $useragent)) {
            return new Samsung\SamsungSghi747m($useragent);
        }

        if (preg_match('/sgh\-i747/i', $useragent)) {
            return new Samsung\SamsungSghi747($useragent);
        }

        if (preg_match('/sgh\-i727r/i', $useragent)) {
            return new Samsung\SamsungSghi727r($useragent);
        }

        if (preg_match('/sgh\-i727/i', $useragent)) {
            return new Samsung\SamsungSghi727($useragent);
        }

        if (preg_match('/sgh\-i717/i', $useragent)) {
            return new Samsung\SamsungSghi717($useragent);
        }

        if (preg_match('/sgh\-i577/i', $useragent)) {
            return new Samsung\SamsungSghi577($useragent);
        }

        if (preg_match('/sgh\-i547/i', $useragent)) {
            return new Samsung\SamsungSghi547($useragent);
        }

        if (preg_match('/sgh\-i497/i', $useragent)) {
            return new Samsung\SamsungSghi497($useragent);
        }

        if (preg_match('/sgh\-i467/i', $useragent)) {
            return new Samsung\SamsungSghi467($useragent);
        }

        if (preg_match('/sgh\-i337m/i', $useragent)) {
            return new Samsung\SamsungSghi337m($useragent);
        }

        if (preg_match('/sgh\-i337/i', $useragent)) {
            return new Samsung\SamsungSghi337($useragent);
        }

        if (preg_match('/sgh\-i317/i', $useragent)) {
            return new Samsung\SamsungSghi317($useragent);
        }

        if (preg_match('/sgh\-i257/i', $useragent)) {
            return new Samsung\SamsungSghi257($useragent);
        }

        if (preg_match('/sgh\-f480i/i', $useragent)) {
            return new Samsung\SamsungSghF480i($useragent);
        }

        if (preg_match('/sgh\-f480/i', $useragent)) {
            return new Samsung\SamsungSghF480($useragent);
        }

        if (preg_match('/sgh\-e250i/i', $useragent)) {
            return new Samsung\SamsungSghE250i($useragent);
        }

        if (preg_match('/sgh\-e250/i', $useragent)) {
            return new Samsung\SamsungSghE250($useragent);
        }

        if (preg_match('/(sgh\-b100|sec\-sghb100)/i', $useragent)) {
            return new Samsung\SamsungSghB100($useragent);
        }

        if (preg_match('/sec\-sghu600b/i', $useragent)) {
            return new Samsung\SamsungSghu600b($useragent);
        }

        if (preg_match('/sgh\-u800/i', $useragent)) {
            return new Samsung\SamsungSghU800($useragent);
        }

        if (preg_match('/shv\-e370k/i', $useragent)) {
            return new Samsung\SamsungShvE370k($useragent);
        }

        if (preg_match('/shv\-e250k/i', $useragent)) {
            return new Samsung\SamsungShvE250k($useragent);
        }

        if (preg_match('/shv\-e250l/i', $useragent)) {
            return new Samsung\SamsungShvE250l($useragent);
        }

        if (preg_match('/shv\-e250s/i', $useragent)) {
            return new Samsung\SamsungShvE250s($useragent);
        }

        if (preg_match('/shv\-e210l/i', $useragent)) {
            return new Samsung\SamsungShvE210l($useragent);
        }

        if (preg_match('/shv\-e210k/i', $useragent)) {
            return new Samsung\SamsungShvE210k($useragent);
        }

        if (preg_match('/shv\-e210s/i', $useragent)) {
            return new Samsung\SamsungShvE210s($useragent);
        }

        if (preg_match('/shv\-e160s/i', $useragent)) {
            return new Samsung\SamsungShvE160s($useragent);
        }

        if (preg_match('/shw\-m110s/i', $useragent)) {
            return new Samsung\SamsungShwM110s($useragent);
        }

        if (preg_match('/shw\-m180s/i', $useragent)) {
            return new Samsung\SamsungShwM180s($useragent);
        }

        if (preg_match('/shw\-m380s/i', $useragent)) {
            return new Samsung\SamsungShwM380s($useragent);
        }

        if (preg_match('/shw\-m380w/i', $useragent)) {
            return new Samsung\SamsungShwM380w($useragent);
        }

        if (preg_match('/shw\-m930bst/i', $useragent)) {
            return new Samsung\SamsungShwM930bst($useragent);
        }

        if (preg_match('/shw\-m480w/i', $useragent)) {
            return new Samsung\SamsungShwM480W($useragent);
        }

        if (preg_match('/shw\-m380k/i', $useragent)) {
            return new Samsung\ShwM380K($useragent);
        }

        if (preg_match('/scl24/i', $useragent)) {
            return new Samsung\SamsungScl24($useragent);
        }

        if (preg_match('/sch\-u820/i', $useragent)) {
            return new Samsung\SamsungSchU820($useragent);
        }

        if (preg_match('/sch\-u750/i', $useragent)) {
            return new Samsung\SamsungSchU750($useragent);
        }

        if (preg_match('/sch\-u660/i', $useragent)) {
            return new Samsung\SamsungSchU660($useragent);
        }

        if (preg_match('/sch\-u485/i', $useragent)) {
            return new Samsung\SamsungSchU485($useragent);
        }

        if (preg_match('/sch\-r970/i', $useragent)) {
            return new Samsung\SamsungSchr970($useragent);
        }

        if (preg_match('/sch\-r950/i', $useragent)) {
            return new Samsung\SamsungSchR950($useragent);
        }

        if (preg_match('/sch\-r720/i', $useragent)) {
            return new Samsung\SamsungSchr720($useragent);
        }

        if (preg_match('/sch\-r530u/i', $useragent)) {
            return new Samsung\SamsungSchR530u($useragent);
        }

        if (preg_match('/sch\-r530c/i', $useragent)) {
            return new Samsung\SamsungSchR530c($useragent);
        }

        if (preg_match('/sch\-n719/i', $useragent)) {
            return new Samsung\SamsungSchN719($useragent);
        }

        if (preg_match('/sch\-m828c/i', $useragent)) {
            return new Samsung\SamsungSchM828c($useragent);
        }

        if (preg_match('/sch\-i535/i', $useragent)) {
            return new Samsung\SamsungSchI535($useragent);
        }

        if (preg_match('/sch\-i919/i', $useragent)) {
            return new Samsung\SamsungSchI919($useragent);
        }

        if (preg_match('/sch\-i815/i', $useragent)) {
            return new Samsung\SamsungSchI8154g($useragent);
        }

        if (preg_match('/sch\-i800/i', $useragent)) {
            return new Samsung\SamsungSchI800($useragent);
        }

        if (preg_match('/sch\-i699/i', $useragent)) {
            return new Samsung\SamsungSchI699($useragent);
        }

        if (preg_match('/sch\-i605/i', $useragent)) {
            return new Samsung\SamsungSchI605($useragent);
        }

        if (preg_match('/sch\-i545/i', $useragent)) {
            return new Samsung\SamsungSchI545($useragent);
        }

        if (preg_match('/sch\-i510/i', $useragent)) {
            return new Samsung\SamsungSchI510($useragent);
        }

        if (preg_match('/sch\-i500/i', $useragent)) {
            return new Samsung\SamsungSchI500($useragent);
        }

        if (preg_match('/sch\-i435/i', $useragent)) {
            return new Samsung\SamsungSchI435($useragent);
        }

        if (preg_match('/sch\-i400/i', $useragent)) {
            return new Samsung\SamsungSchI400($useragent);
        }

        if (preg_match('/sch\-i200/i', $useragent)) {
            return new Samsung\SamsungSchI200($useragent);
        }

        if (preg_match('/SCH\-S720C/i', $useragent)) {
            return new Samsung\SamsungSchs720c($useragent);
        }

        if (preg_match('/GT\-S8600/i', $useragent)) {
            return new Samsung\SamsungGts8600($useragent);
        }

        if (preg_match('/GT\-S8530/i', $useragent)) {
            return new Samsung\SamsungGts8530($useragent);
        }

        if (preg_match('/GT\-S8500/i', $useragent)) {
            return new Samsung\SamsungGts8500($useragent);
        }

        if (preg_match('/(samsung|gt)\-s8300/i', $useragent)) {
            return new Samsung\SamsungGts8300($useragent);
        }

        if (preg_match('/(samsung|gt)\-s8003/i', $useragent)) {
            return new Samsung\SamsungGts8003($useragent);
        }

        if (preg_match('/(samsung|gt)\-s8000/i', $useragent)) {
            return new Samsung\SamsungGts8000($useragent);
        }

        if (preg_match('/(samsung|gt)\-s7710/i', $useragent)) {
            return new Samsung\SamsungGts7710($useragent);
        }

        if (preg_match('/gt\-s7582/i', $useragent)) {
            return new Samsung\SamsungGts7582($useragent);
        }

        if (preg_match('/gt\-s7580/i', $useragent)) {
            return new Samsung\SamsungGts7580($useragent);
        }

        if (preg_match('/gt\-s7562l/i', $useragent)) {
            return new Samsung\SamsungGts7562l($useragent);
        }

        if (preg_match('/gt\-s7562/i', $useragent)) {
            return new Samsung\SamsungGts7562($useragent);
        }

        if (preg_match('/gt\-s7560/i', $useragent)) {
            return new Samsung\SamsungGts7560($useragent);
        }

        if (preg_match('/gt\-s7530/i', $useragent)) {
            return new Samsung\SamsungGts7530($useragent);
        }

        if (preg_match('/gt\-s7500/i', $useragent)) {
            return new Samsung\SamsungGts7500($useragent);
        }

        if (preg_match('/gt\-s7392/i', $useragent)) {
            return new Samsung\SamsungGts7392($useragent);
        }

        if (preg_match('/gt\-s7390/i', $useragent)) {
            return new Samsung\SamsungGts7390($useragent);
        }

        if (preg_match('/gt\-s7330/i', $useragent)) {
            return new Samsung\SamsungGts7330($useragent);
        }

        if (preg_match('/gt\-s7275r/i', $useragent)) {
            return new Samsung\SamsungGts7275r($useragent);
        }

        if (preg_match('/gt\-s7275/i', $useragent)) {
            return new Samsung\SamsungGts7275($useragent);
        }

        if (preg_match('/gt\-s7272/i', $useragent)) {
            return new Samsung\SamsungGts7272($useragent);
        }

        if (preg_match('/gt\-s7270/i', $useragent)) {
            return new Samsung\SamsungGts7270($useragent);
        }

        if (preg_match('/gt\-s7262/i', $useragent)) {
            return new Samsung\SamsungGts7262($useragent);
        }

        if (preg_match('/gt\-s7250/i', $useragent)) {
            return new Samsung\SamsungGts7250($useragent);
        }

        if (preg_match('/gt\-s7233e/i', $useragent)) {
            return new Samsung\SamsungGts7233e($useragent);
        }

        if (preg_match('/gt\-s7230e/i', $useragent)) {
            return new Samsung\SamsungGts7230e($useragent);
        }

        if (preg_match('/(samsung|gt)\-s7220/i', $useragent)) {
            return new Samsung\SamsungGts7220($useragent);
        }

        if (preg_match('/gt\-s6810p/i', $useragent)) {
            return new Samsung\SamsungGts6810p($useragent);
        }

        if (preg_match('/gt\-s6810b/i', $useragent)) {
            return new Samsung\SamsungGts6810b($useragent);
        }

        if (preg_match('/gt\-s6810/i', $useragent)) {
            return new Samsung\SamsungGts6810($useragent);
        }

        if (preg_match('/gt\-s6802/i', $useragent)) {
            return new Samsung\SamsungGts6802($useragent);
        }

        if (preg_match('/gt\-s6500d/i', $useragent)) {
            return new Samsung\SamsungGts6500d($useragent);
        }

        if (preg_match('/gt\-s6500t/i', $useragent)) {
            return new Samsung\SamsungGts6500t($useragent);
        }

        if (preg_match('/gt\-s6500/i', $useragent)) {
            return new Samsung\SamsungGts6500($useragent);
        }

        if (preg_match('/gt\-s6312/i', $useragent)) {
            return new Samsung\SamsungGts6312($useragent);
        }

        if (preg_match('/gt\-s6310n/i', $useragent)) {
            return new Samsung\SamsungGts6310N($useragent);
        }

        if (preg_match('/gt\-s6310/i', $useragent)) {
            return new Samsung\SamsungGts6310($useragent);
        }

        if (preg_match('/gt\-s6102b/i', $useragent)) {
            return new Samsung\SamsungGts6102B($useragent);
        }

        if (preg_match('/gt\-s6102/i', $useragent)) {
            return new Samsung\SamsungGts6102($useragent);
        }

        if (preg_match('/gt\-s5839i/i', $useragent)) {
            return new Samsung\SamsungGts5839i($useragent);
        }

        if (preg_match('/gt\-s5830l/i', $useragent)) {
            return new Samsung\SamsungGts5830l($useragent);
        }

        if (preg_match('/gt\-s5830i/i', $useragent)) {
            return new Samsung\SamsungGts5830i($useragent);
        }

        if (preg_match('/gt\-s5830c/i', $useragent)) {
            return new Samsung\SamsungGts5830c($useragent);
        }

        if (preg_match('/gt\-s5570i/i', $useragent)) {
            return new Samsung\SamsungGts5570i($useragent);
        }

        if (preg_match('/gt\-s5570/i', $useragent)) {
            return new Samsung\SamsungGts5570($useragent);
        }

        if (preg_match('/(gt\-s5830|ace)/i', $useragent)) {
            return new Samsung\SamsungGts5830($useragent);
        }

        if (preg_match('/gt\-s5780/i', $useragent)) {
            return new Samsung\SamsungGts5780($useragent);
        }

        if (preg_match('/gt\-s5750e/i', $useragent)) {
            return new Samsung\SamsungGts5750e($useragent);
        }

        if (preg_match('/gt\-s5690/i', $useragent)) {
            return new Samsung\SamsungGts5690($useragent);
        }

        if (preg_match('/gt\-s5670/i', $useragent)) {
            return new Samsung\SamsungGts5670($useragent);
        }

        if (preg_match('/gt\-s5660/i', $useragent)) {
            return new Samsung\SamsungGts5660($useragent);
        }

        if (preg_match('/gt\-s5620/i', $useragent)) {
            return new Samsung\SamsungGts5620($useragent);
        }

        if (preg_match('/gt\-s5560i/i', $useragent)) {
            return new Samsung\SamsungGts5560i($useragent);
        }

        if (preg_match('/gt\-s5560/i', $useragent)) {
            return new Samsung\SamsungGts5560($useragent);
        }

        if (preg_match('/gt\-s5380/i', $useragent)) {
            return new Samsung\SamsungGts5380($useragent);
        }

        if (preg_match('/gt\-s5369/i', $useragent)) {
            return new Samsung\SamsungGts5369($useragent);
        }

        if (preg_match('/gt\-s5363/i', $useragent)) {
            return new Samsung\SamsungGts5363($useragent);
        }

        if (preg_match('/gt\-s5360/i', $useragent)) {
            return new Samsung\SamsungGts5360($useragent);
        }

        if (preg_match('/gt\-s5330/i', $useragent)) {
            return new Samsung\SamsungGts5330($useragent);
        }

        if (preg_match('/gt\-s5310m/i', $useragent)) {
            return new Samsung\SamsungGts5310m($useragent);
        }

        if (preg_match('/gt\-s5310/i', $useragent)) {
            return new Samsung\SamsungGts5310($useragent);
        }

        if (preg_match('/gt\-s5302/i', $useragent)) {
            return new Samsung\SamsungGts5302($useragent);
        }

        if (preg_match('/gt\-s5301l/i', $useragent)) {
            return new Samsung\SamsungGts5301l($useragent);
        }

        if (preg_match('/gt\-s5301/i', $useragent)) {
            return new Samsung\SamsungGts5301($useragent);
        }

        if (preg_match('/gt\-s5300b/i', $useragent)) {
            return new Samsung\SamsungGts5300B($useragent);
        }

        if (preg_match('/gt\-s5300/i', $useragent)) {
            return new Samsung\SamsungGts5300($useragent);
        }

        if (preg_match('/gt\-s5280/i', $useragent)) {
            return new Samsung\SamsungGts5280($useragent);
        }

        if (preg_match('/gt\-s5260/i', $useragent)) {
            return new Samsung\SamsungGts5260($useragent);
        }

        if (preg_match('/gt\-s5250/i', $useragent)) {
            return new Samsung\SamsungGts5250($useragent);
        }

        if (preg_match('/gt\-s5233s/i', $useragent)) {
            return new Samsung\SamsungGts5233S($useragent);
        }

        if (preg_match('/gt\-s5230w/i', $useragent)) {
            return new Samsung\SamsungGts5230w($useragent);
        }

        if (preg_match('/gt\-s5230/i', $useragent)) {
            return new Samsung\SamsungGts5230($useragent);
        }

        if (preg_match('/gt\-s5222/i', $useragent)) {
            return new Samsung\SamsungGts5222($useragent);
        }

        if (preg_match('/gt\-s5220/i', $useragent)) {
            return new Samsung\SamsungGts5220($useragent);
        }

        if (preg_match('/gt\-s3850/i', $useragent)) {
            return new Samsung\SamsungGts3850($useragent);
        }

        if (preg_match('/gt\-s3802/i', $useragent)) {
            return new Samsung\SamsungGts3802($useragent);
        }

        if (preg_match('/gt\-s3653/i', $useragent)) {
            return new Samsung\SamsungGts3653($useragent);
        }

        if (preg_match('/gt\-s3650/i', $useragent)) {
            return new Samsung\SamsungGts3650($useragent);
        }

        if (preg_match('/gt\-s3370/i', $useragent)) {
            return new Samsung\SamsungGts3370($useragent);
        }

        if (preg_match('/gt\-p7511/i', $useragent)) {
            return new Samsung\SamsungGtp7511($useragent);
        }

        if (preg_match('/gt\-p7510/i', $useragent)) {
            return new Samsung\SamsungGtp7510($useragent);
        }

        if (preg_match('/gt\-p7501/i', $useragent)) {
            return new Samsung\SamsungGtp7501($useragent);
        }

        if (preg_match('/gt\-p7500m/i', $useragent)) {
            return new Samsung\SamsungGtp7500M($useragent);
        }

        if (preg_match('/gt\-p7500/i', $useragent)) {
            return new Samsung\SamsungGtp7500($useragent);
        }

        if (preg_match('/gt\-p7320/i', $useragent)) {
            return new Samsung\SamsungGtp7320($useragent);
        }

        if (preg_match('/gt\-p7310/i', $useragent)) {
            return new Samsung\SamsungGtp7310($useragent);
        }

        if (preg_match('/gt\-p7300b/i', $useragent)) {
            return new Samsung\SamsungGtp7300B($useragent);
        }

        if (preg_match('/gt\-p7300/i', $useragent)) {
            return new Samsung\SamsungGtp7300($useragent);
        }

        if (preg_match('/gt\-p7100/i', $useragent)) {
            return new Samsung\SamsungGtp7100($useragent);
        }

        if (preg_match('/gt\-p6810/i', $useragent)) {
            return new Samsung\SamsungGtp6810($useragent);
        }

        if (preg_match('/gt\-p6800/i', $useragent)) {
            return new Samsung\SamsungGtp6800($useragent);
        }

        if (preg_match('/gt\-p6211/i', $useragent)) {
            return new Samsung\SamsungGtp6211($useragent);
        }

        if (preg_match('/gt\-p6210/i', $useragent)) {
            return new Samsung\SamsungGtp6210($useragent);
        }

        if (preg_match('/gt\-p6201/i', $useragent)) {
            return new Samsung\SamsungGtp6201($useragent);
        }

        if (preg_match('/gt\-p6200/i', $useragent)) {
            return new Samsung\SamsungGtp6200($useragent);
        }

        if (preg_match('/gt\-p5220/i', $useragent)) {
            return new Samsung\SamsungGtp5220($useragent);
        }

        if (preg_match('/gt\-p5210/i', $useragent)) {
            return new Samsung\SamsungGtp5210($useragent);
        }

        if (preg_match('/gt\-p5200/i', $useragent)) {
            return new Samsung\SamsungGtp5200($useragent);
        }

        if (preg_match('/gt\-p5113/i', $useragent)) {
            return new Samsung\SamsungGtp5113($useragent);
        }

        if (preg_match('/gt\-p5110/i', $useragent)) {
            return new Samsung\SamsungGtp5110($useragent);
        }

        if (preg_match('/gt\-p5100/i', $useragent)) {
            return new Samsung\SamsungGtp5100($useragent);
        }

        if (preg_match('/gt\-p3113/i', $useragent)) {
            return new Samsung\SamsungGtp3113($useragent);
        }

        if (preg_match('/(gt\-p3100|galaxy tab 2 3g)/i', $useragent)) {
            return new Samsung\SamsungGtp3100($useragent);
        }

        if (preg_match('/(gt\-p3110|galaxy tab 2)/i', $useragent)) {
            return new Samsung\SamsungGtp3110($useragent);
        }

        if (preg_match('/gt\-p1010/i', $useragent)) {
            return new Samsung\SamsungGtp1010($useragent);
        }

        if (preg_match('/gt\-p1000n/i', $useragent)) {
            return new Samsung\SamsungGtp1000N($useragent);
        }

        if (preg_match('/gt\-p1000m/i', $useragent)) {
            return new Samsung\SamsungGtp1000M($useragent);
        }

        if (preg_match('/gt\-p1000/i', $useragent)) {
            return new Samsung\SamsungGtp1000($useragent);
        }

        if (preg_match('/gt\-n9000/i', $useragent)) {
            return new Samsung\SamsungGtn9000($useragent);
        }

        if (preg_match('/gt\-n8020/i', $useragent)) {
            return new Samsung\SamsungGtn8020($useragent);
        }

        if (preg_match('/gt\-n8013/i', $useragent)) {
            return new Samsung\SamsungGtn8013($useragent);
        }

        if (preg_match('/gt\-n8010/i', $useragent)) {
            return new Samsung\SamsungGtn8010($useragent);
        }

        if (preg_match('/gt\-n8005/i', $useragent)) {
            return new Samsung\SamsungGtn8005($useragent);
        }

        if (preg_match('/(gt\-n8000d|n8000d)/i', $useragent)) {
            return new Samsung\SamsungGtn8000d($useragent);
        }

        if (preg_match('/gt\-n8000/i', $useragent)) {
            return new Samsung\SamsungGtn8000($useragent);
        }

        if (preg_match('/gt\-n7108/i', $useragent)) {
            return new Samsung\SamsungGtn7108($useragent);
        }

        if (preg_match('/gt\-n7105/i', $useragent)) {
            return new Samsung\SamsungGtn7105($useragent);
        }

        if (preg_match('/gt\-n7100/i', $useragent)) {
            return new Samsung\SamsungGtn7100($useragent);
        }

        if (preg_match('/GT\-N7000/i', $useragent)) {
            return new Samsung\SamsungGtn7000($useragent);
        }

        if (preg_match('/GT\-N5120/i', $useragent)) {
            return new Samsung\SamsungGtn5120($useragent);
        }

        if (preg_match('/GT\-N5110/i', $useragent)) {
            return new Samsung\SamsungGtn5110($useragent);
        }

        if (preg_match('/GT\-N5100/i', $useragent)) {
            return new Samsung\SamsungGtn5100($useragent);
        }

        if (preg_match('/GT\-M7600/i', $useragent)) {
            return new Samsung\SamsungGtm7600($useragent);
        }

        if (preg_match('/GT\-I9515/i', $useragent)) {
            return new Samsung\SamsungGti9515($useragent);
        }

        if (preg_match('/GT\-I9506/i', $useragent)) {
            return new Samsung\SamsungGti9506($useragent);
        }

        if (preg_match('/GT\-I9505X/i', $useragent)) {
            return new Samsung\SamsungGti9505x($useragent);
        }

        if (preg_match('/GT\-I9505G/i', $useragent)) {
            return new Samsung\SamsungGti9505g($useragent);
        }

        if (preg_match('/GT\-I9505/i', $useragent)) {
            return new Samsung\SamsungGti9505($useragent);
        }

        if (preg_match('/GT\-I9502/i', $useragent)) {
            return new Samsung\SamsungGti9502($useragent);
        }

        if (preg_match('/GT\-I9500/i', $useragent)) {
            return new Samsung\SamsungGti9500($useragent);
        }

        if (preg_match('/GT\-I9308/i', $useragent)) {
            return new Samsung\SamsungGti9308($useragent);
        }

        if (preg_match('/GT\-I9305/i', $useragent)) {
            return new Samsung\SamsungGti9305($useragent);
        }

        if (preg_match('/(gt\-i9301i|i9301i)/i', $useragent)) {
            return new Samsung\SamsungGti9301i($useragent);
        }

        if (preg_match('/(gt\-i9301q|i9301q)/i', $useragent)) {
            return new Samsung\SamsungGti9301q($useragent);
        }

        if (preg_match('/(gt\-i9301|i9301)/i', $useragent)) {
            return new Samsung\SamsungGti9301($useragent);
        }

        if (preg_match('/GT\-I9300I/i', $useragent)) {
            return new Samsung\SamsungGti9300i($useragent);
        }

        if (preg_match('/(GT\-l9300|GT\-i9300|I9300)/i', $useragent)) {
            return new Samsung\SamsungGti9300($useragent);
        }

        if (preg_match('/(GT\-I9295|I9295)/i', $useragent)) {
            return new Samsung\SamsungGti9295($useragent);
        }

        if (preg_match('/GT\-I9210/i', $useragent)) {
            return new Samsung\SamsungGti9210($useragent);
        }

        if (preg_match('/GT\-I9205/i', $useragent)) {
            return new Samsung\SamsungGti9205($useragent);
        }

        if (preg_match('/GT\-I9200/i', $useragent)) {
            return new Samsung\SamsungGti9200($useragent);
        }

        if (preg_match('/gt\-i9195i/i', $useragent)) {
            return new Samsung\SamsungGti9195i($useragent);
        }

        if (preg_match('/(gt\-i9195|i9195)/i', $useragent)) {
            return new Samsung\SamsungGti9195($useragent);
        }

        if (preg_match('/(gt\-i9192|i9192)/i', $useragent)) {
            return new Samsung\SamsungGti9192($useragent);
        }

        if (preg_match('/(gt\-i9190|i9190)/i', $useragent)) {
            return new Samsung\SamsungGti9190($useragent);
        }

        if (preg_match('/gt\-i9152/i', $useragent)) {
            return new Samsung\SamsungGti9152($useragent);
        }

        if (preg_match('/gt\-i9128v/i', $useragent)) {
            return new Samsung\SamsungGti9128v($useragent);
        }

        if (preg_match('/gt\-i9105p/i', $useragent)) {
            return new Samsung\SamsungGti9105p($useragent);
        }

        if (preg_match('/gt\-i9105/i', $useragent)) {
            return new Samsung\SamsungGti9105($useragent);
        }

        if (preg_match('/gt\-i9103/i', $useragent)) {
            return new Samsung\SamsungGti9103($useragent);
        }

        if (preg_match('/gt\-i9100t/i', $useragent)) {
            return new Samsung\SamsungGti9100t($useragent);
        }

        if (preg_match('/gt\-i9100p/i', $useragent)) {
            return new Samsung\SamsungGti9100p($useragent);
        }

        if (preg_match('/gt\-i9100g/i', $useragent)) {
            return new Samsung\SamsungGti9100g($useragent);
        }

        if (preg_match('/(gt\-i9100|i9100)/i', $useragent)) {
            return new Samsung\SamsungGti9100($useragent);
        }

        if (preg_match('/gt\-i9088/i', $useragent)) {
            return new Samsung\SamsungGti9088($useragent);
        }

        if (preg_match('/gt\-i9082l/i', $useragent)) {
            return new Samsung\SamsungGti9082L($useragent);
        }

        if (preg_match('/gt\-i9082/i', $useragent)) {
            return new Samsung\SamsungGti9082($useragent);
        }

        if (preg_match('/gt\-i9070p/i', $useragent)) {
            return new Samsung\SamsungGti9070P($useragent);
        }

        if (preg_match('/gt\-i9070/i', $useragent)) {
            return new Samsung\SamsungGti9070($useragent);
        }

        if (preg_match('/gt\-i9060l/i', $useragent)) {
            return new Samsung\SamsungGti9060l($useragent);
        }

        if (preg_match('/gt\-i9060i/i', $useragent)) {
            return new Samsung\SamsungGti9060i($useragent);
        }

        if (preg_match('/gt\-i9060/i', $useragent)) {
            return new Samsung\SamsungGti9060($useragent);
        }

        if (preg_match('/gt\-i9023/i', $useragent)) {
            return new Samsung\SamsungGti9023($useragent);
        }

        if (preg_match('/gt\-i9010p/i', $useragent)) {
            return new Samsung\SamsungGti9010P($useragent);
        }

        if (preg_match('/galaxy( |\-)s4/i', $useragent)) {
            return new Samsung\SamsungGti9500($useragent);
        }

        if (preg_match('/Galaxy( |\-)S/i', $useragent)) {
            return new Samsung\SamsungGti9010GalaxyS($useragent);
        }

        if (preg_match('/GT\-I9010/i', $useragent)) {
            return new Samsung\SamsungGti9010($useragent);
        }

        if (preg_match('/GT\-I9008L/i', $useragent)) {
            return new Samsung\SamsungGti9008l($useragent);
        }

        if (preg_match('/GT\-I9008/i', $useragent)) {
            return new Samsung\SamsungGti9008($useragent);
        }

        if (preg_match('/gt\-i9003l/i', $useragent)) {
            return new Samsung\SamsungGti9003l($useragent);
        }

        if (preg_match('/gt\-i9003/i', $useragent)) {
            return new Samsung\SamsungGti9003($useragent);
        }

        if (preg_match('/gt\-i9001/i', $useragent)) {
            return new Samsung\SamsungGti9001($useragent);
        }

        if (preg_match('/(gt\-i9000|sgh\-t959v)/i', $useragent)) {
            return new Samsung\SamsungGti9000($useragent);
        }

        if (preg_match('/(gt\-i8910|i8910)/i', $useragent)) {
            return new Samsung\SamsungGti8910($useragent);
        }

        if (preg_match('/gt\-i8750/i', $useragent)) {
            return new Samsung\SamsungGti8750($useragent);
        }

        if (preg_match('/gt\-i8730/i', $useragent)) {
            return new Samsung\SamsungGti8730($useragent);
        }

        if (preg_match('/omnia7/i', $useragent)) {
            return new Samsung\SamsungGti8700Omnia7($useragent);
        }

        if (preg_match('/gt\-i8552/i', $useragent)) {
            return new Samsung\SamsungGti8552($useragent);
        }

        if (preg_match('/gt\-i8530/i', $useragent)) {
            return new Samsung\SamsungGti8530($useragent);
        }

        if (preg_match('/gt\-i8350/i', $useragent)) {
            return new Samsung\SamsungGti8350OmniaW($useragent);
        }

        if (preg_match('/gt\-i8320/i', $useragent)) {
            return new Samsung\SamsungGti8320($useragent);
        }

        if (preg_match('/gt\-i8262/i', $useragent)) {
            return new Samsung\SamsungGti8262($useragent);
        }

        if (preg_match('/gt\-i8260/i', $useragent)) {
            return new Samsung\SamsungGti8260($useragent);
        }

        if (preg_match('/gt\-i8200n/i', $useragent)) {
            return new Samsung\SamsungGti8200n($useragent);
        }

        if (preg_match('/GT\-I8200/i', $useragent)) {
            return new Samsung\SamsungGti8200($useragent);
        }

        if (preg_match('/GT\-I8190N/i', $useragent)) {
            return new Samsung\SamsungGti8190n($useragent);
        }

        if (preg_match('/GT\-I8190/i', $useragent)) {
            return new Samsung\SamsungGti8190($useragent);
        }

        if (preg_match('/GT\-I8160P/i', $useragent)) {
            return new Samsung\SamsungGti8160p($useragent);
        }

        if (preg_match('/GT\-I8160/i', $useragent)) {
            return new Samsung\SamsungGti8160($useragent);
        }

        if (preg_match('/GT\-I8150/i', $useragent)) {
            return new Samsung\SamsungGti8150($useragent);
        }

        if (preg_match('/GT\-i8000V/i', $useragent)) {
            return new Samsung\SamsungGti8000v($useragent);
        }

        if (preg_match('/GT\-i8000/i', $useragent)) {
            return new Samsung\SamsungGti8000($useragent);
        }

        if (preg_match('/GT\-I6410/i', $useragent)) {
            return new Samsung\SamsungGti6410($useragent);
        }

        if (preg_match('/GT\-I5801/i', $useragent)) {
            return new Samsung\SamsungGti5801($useragent);
        }

        if (preg_match('/GT\-I5800/i', $useragent)) {
            return new Samsung\SamsungGti5800($useragent);
        }

        if (preg_match('/GT\-I5700/i', $useragent)) {
            return new Samsung\SamsungGti5700($useragent);
        }

        if (preg_match('/GT\-I5510/i', $useragent)) {
            return new Samsung\SamsungGti5510($useragent);
        }

        if (preg_match('/GT\-I5508/i', $useragent)) {
            return new Samsung\SamsungGti5508($useragent);
        }

        if (preg_match('/GT\-I5503/i', $useragent)) {
            return new Samsung\SamsungGti5503($useragent);
        }

        if (preg_match('/GT\-I5500/i', $useragent)) {
            return new Samsung\SamsungGti5500($useragent);
        }

        if (preg_match('/nexus s 4g/i', $useragent)) {
            return new Samsung\SamsungGalaxyNexusS4G($useragent);
        }

        if (preg_match('/nexus s/i', $useragent)) {
            return new Samsung\SamsungGalaxyNexusS($useragent);
        }

        if (preg_match('/nexus 10/i', $useragent)) {
            return new Samsung\SamsungGalaxyNexus10($useragent);
        }

        if (preg_match('/nexus player/i', $useragent)) {
            return new Samsung\SamsungGalaxyNexusPlayer($useragent);
        }

        if (preg_match('/nexus/i', $useragent)) {
            return new Samsung\SamsungGalaxyNexus($useragent);
        }

        if (preg_match('/Galaxy/i', $useragent)) {
            return new Samsung\SamsungGti7500Galaxy($useragent);
        }

        if (preg_match('/GT\-E3309T/i', $useragent)) {
            return new Samsung\SamsungGte3309t($useragent);
        }

        if (preg_match('/GT\-E2550/i', $useragent)) {
            return new Samsung\SamsungGte2550($useragent);
        }

        if (preg_match('/GT\-E2252/i', $useragent)) {
            return new Samsung\SamsungGte2252($useragent);
        }

        if (preg_match('/GT\-E2222/i', $useragent)) {
            return new Samsung\SamsungGte2222($useragent);
        }

        if (preg_match('/GT\-E2202/i', $useragent)) {
            return new Samsung\SamsungGte2202($useragent);
        }

        if (preg_match('/GT\-E1282T/i', $useragent)) {
            return new Samsung\SamsungGte1282T($useragent);
        }

        if (preg_match('/GT\-C6712/i', $useragent)) {
            return new Samsung\SamsungGtc6712($useragent);
        }

        if (preg_match('/GT\-C3780/i', $useragent)) {
            return new Samsung\SamsungGtc3780($useragent);
        }

        if (preg_match('/GT\-C3510/i', $useragent)) {
            return new Samsung\SamsungGtc3510($useragent);
        }

        if (preg_match('/GT\-C3500/i', $useragent)) {
            return new Samsung\SamsungGtc3500($useragent);
        }

        if (preg_match('/GT\-C3350/i', $useragent)) {
            return new Samsung\SamsungGtc3350($useragent);
        }

        if (preg_match('/GT\-C3322/i', $useragent)) {
            return new Samsung\SamsungGtc3322($useragent);
        }

        if (preg_match('/gt\-C3312r/i', $useragent)) {
            return new Samsung\SamsungGtc3312r($useragent);
        }

        if (preg_match('/GT\-C3310/i', $useragent)) {
            return new Samsung\SamsungGtc3310($useragent);
        }

        if (preg_match('/GT\-C3262/i', $useragent)) {
            return new Samsung\SamsungGtc3262($useragent);
        }

        if (preg_match('/GT\-B7722/i', $useragent)) {
            return new Samsung\SamsungGtb7722($useragent);
        }

        if (preg_match('/GT\-B7610/i', $useragent)) {
            return new Samsung\SamsungGtb7610($useragent);
        }

        if (preg_match('/GT\-B7510/i', $useragent)) {
            return new Samsung\SamsungGtb7510($useragent);
        }

        if (preg_match('/GT\-B7350/i', $useragent)) {
            return new Samsung\SamsungGtb7350($useragent);
        }

        if (preg_match('/gt\-b5510/i', $useragent)) {
            return new Samsung\SamsungGtb5510($useragent);
        }

        if (preg_match('/gt\-b3410/i', $useragent)) {
            return new Samsung\SamsungGtb3410($useragent);
        }

        if (preg_match('/gt\-b2710/i', $useragent)) {
            return new Samsung\SamsungGtb2710($useragent);
        }

        if (preg_match('/(gt\-b2100|b2100)/i', $useragent)) {
            return new Samsung\SamsungGtb2100($useragent);
        }

        if (preg_match('/F031/i', $useragent)) {
            return new Samsung\SamsungF031($useragent);
        }

        if (preg_match('/Continuum\-I400/i', $useragent)) {
            return new Samsung\SamsungContinuumI400($useragent);
        }

        if (preg_match('/CETUS/i', $useragent)) {
            return new Samsung\Cetus($useragent);
        }

        if (preg_match('/sc\-06d/i', $useragent)) {
            return new Samsung\SamsungSc06d($useragent);
        }

        if (preg_match('/sc\-02f/i', $useragent)) {
            return new Samsung\SamsungSc02f($useragent);
        }

        if (preg_match('/sc\-02c/i', $useragent)) {
            return new Samsung\SamsungSc02c($useragent);
        }

        if (preg_match('/sc\-02b/i', $useragent)) {
            return new Samsung\SamsungSc02b($useragent);
        }

        if (preg_match('/sc\-01f/i', $useragent)) {
            return new Samsung\SamsungSc01f($useragent);
        }

        if (preg_match('/S3500/i', $useragent)) {
            return new Samsung\SamsungS3500($useragent);
        }

        if (preg_match('/R631/i', $useragent)) {
            return new Samsung\SamsungR631($useragent);
        }

        if (preg_match('/i7110/i', $useragent)) {
            return new Samsung\SamsungI7110($useragent);
        }

        if (preg_match('/yp\-gs1/i', $useragent)) {
            return new Samsung\YPGs1($useragent);
        }

        if (preg_match('/yp\-gi1/i', $useragent)) {
            return new Samsung\YPGi1($useragent);
        }

        if (preg_match('/yp\-gb70/i', $useragent)) {
            return new Samsung\YPGB70($useragent);
        }

        if (preg_match('/yp\-g70/i', $useragent)) {
            return new Samsung\YPG70($useragent);
        }

        if (preg_match('/yp\-g1/i', $useragent)) {
            return new Samsung\YPG1($useragent);
        }

        if (preg_match('/sch\-r730/i', $useragent)) {
            return new Samsung\SamsungSshR730($useragent);
        }

        if (preg_match('/sph\-p100/i', $useragent)) {
            return new Samsung\SamsungSphp100($useragent);
        }

        if (preg_match('/sph\-m930/i', $useragent)) {
            return new Samsung\SamsungSphm930($useragent);
        }

        if (preg_match('/sph\-m840/i', $useragent)) {
            return new Samsung\SamsungSphm840($useragent);
        }

        if (preg_match('/sph\-m580/i', $useragent)) {
            return new Samsung\SphM580($useragent);
        }

        if (preg_match('/sph\-l900/i', $useragent)) {
            return new Samsung\SamsungSphl900($useragent);
        }

        if (preg_match('/sph\-l720/i', $useragent)) {
            return new Samsung\SamsungSphl720($useragent);
        }

        if (preg_match('/sph\-l710/i', $useragent)) {
            return new Samsung\SamsungSphl710($useragent);
        }

        if (preg_match('/sph\-ip830w/i', $useragent)) {
            return new Samsung\SamsungSphIp830w($useragent);
        }

        if (preg_match('/sph\-d710bst/i', $useragent)) {
            return new Samsung\SamsungSphd710bst($useragent);
        }

        if (preg_match('/sph\-d710/i', $useragent)) {
            return new Samsung\SamsungSphd710($useragent);
        }

        if (preg_match('/smart\-tv/i', $useragent)) {
            return new Samsung\SamsungSmartTv($useragent);
        }

        return new Samsung\Samsung($useragent);
    }
}
