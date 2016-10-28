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
use BrowserDetector\Detector\Factory\DeviceFactory;
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
            $deviceCode = 'sm-a9000';
        }

        if (preg_match('/sm\-a800f/i', $useragent)) {
            $deviceCode = 'sm-a800f';
        }

        if (preg_match('/sm\-a800y/i', $useragent)) {
            $deviceCode = 'sm-a800y';
        }

        if (preg_match('/sm\-a800i/i', $useragent)) {
            $deviceCode = 'sm-a800i';
        }

        if (preg_match('/sm\-a8000/i', $useragent)) {
            $deviceCode = 'sm-a8000';
        }

        if (preg_match('/sm\-s820l/i', $useragent)) {
            $deviceCode = 'sm-s820l';
        }

        if (preg_match('/sm\-a710m/i', $useragent)) {
            $deviceCode = 'sm-a710m';
        }

        if (preg_match('/sm\-a710fd/i', $useragent)) {
            $deviceCode = 'sm-a710fd';
        }

        if (preg_match('/sm\-a710f/i', $useragent)) {
            $deviceCode = 'sm-a710f';
        }

        if (preg_match('/sm\-a7100/i', $useragent)) {
            $deviceCode = 'sm-a7100';
        }

        if (preg_match('/sm\-a710y/i', $useragent)) {
            $deviceCode = 'sm-a710y';
        }

        if (preg_match('/sm\-a700fd/i', $useragent)) {
            $deviceCode = 'sm-a700fd';
        }

        if (preg_match('/sm\-a700f/i', $useragent)) {
            $deviceCode = 'sm-a700f';
        }

        if (preg_match('/sm\-a700s/i', $useragent)) {
            $deviceCode = 'sm-a700s';
        }

        if (preg_match('/sm\-a700k/i', $useragent)) {
            $deviceCode = 'sm-a700k';
        }

        if (preg_match('/sm\-a700l/i', $useragent)) {
            $deviceCode = 'sm-a700l';
        }

        if (preg_match('/sm\-a700h/i', $useragent)) {
            $deviceCode = 'sm-a700h';
        }

        if (preg_match('/sm\-a700yd/i', $useragent)) {
            $deviceCode = 'sm-a700yd';
        }

        if (preg_match('/sm\-a7000/i', $useragent)) {
            $deviceCode = 'sm-a7000';
        }

        if (preg_match('/sm\-a7009/i', $useragent)) {
            $deviceCode = 'sm-a7009';
        }

        if (preg_match('/sm\-a510fd/i', $useragent)) {
            $deviceCode = 'sm-a510fd';
        }

        if (preg_match('/sm\-a510f/i', $useragent)) {
            $deviceCode = 'sm-a510f';
        }

        if (preg_match('/sm\-a510m/i', $useragent)) {
            $deviceCode = 'sm-a510m';
        }

        if (preg_match('/sm\-a510y/i', $useragent)) {
            $deviceCode = 'sm-a510y';
        }

        if (preg_match('/sm\-a5100/i', $useragent)) {
            $deviceCode = 'sm-a5100';
        }

        if (preg_match('/sm\-a510s/i', $useragent)) {
            $deviceCode = 'sm-a510s';
        }

        if (preg_match('/sm\-a500fu/i', $useragent)) {
            $deviceCode = 'sm-a500fu';
        }

        if (preg_match('/sm\-a500f/i', $useragent)) {
            $deviceCode = 'sm-a500f';
        }

        if (preg_match('/sm\-a500h/i', $useragent)) {
            $deviceCode = 'sm-a500h';
        }

        if (preg_match('/sm\-a500y/i', $useragent)) {
            $deviceCode = 'sm-a500y';
        }

        if (preg_match('/sm\-a500l/i', $useragent)) {
            $deviceCode = 'sm-a500l';
        }

        if (preg_match('/sm\-a5000/i', $useragent)) {
            $deviceCode = 'sm-a5000';
        }

        if (preg_match('/sm\-a310f/i', $useragent)) {
            $deviceCode = 'sm-a310f';
        }

        if (preg_match('/sm\-a300fu/i', $useragent)) {
            $deviceCode = 'sm-a300fu';
        }

        if (preg_match('/sm\-a300f/i', $useragent)) {
            $deviceCode = 'sm-a300f';
        }

        if (preg_match('/sm\-a300h/i', $useragent)) {
            $deviceCode = 'sm-a300h';
        }

        if (preg_match('/sm\-j710fn/i', $useragent)) {
            $deviceCode = 'sm-j710fn';
        }

        if (preg_match('/sm\-j710f/i', $useragent)) {
            $deviceCode = 'sm-j710f';
        }

        if (preg_match('/sm\-j710m/i', $useragent)) {
            $deviceCode = 'sm-j710m';
        }

        if (preg_match('/sm\-j710h/i', $useragent)) {
            $deviceCode = 'sm-j710h';
        }

        if (preg_match('/sm\-j700f/i', $useragent)) {
            $deviceCode = 'sm-j700f';
        }

        if (preg_match('/sm\-j700m/i', $useragent)) {
            $deviceCode = 'sm-j700m';
        }

        if (preg_match('/sm\-j700h/i', $useragent)) {
            $deviceCode = 'sm-j700h';
        }

        if (preg_match('/sm\-j510fn/i', $useragent)) {
            $deviceCode = 'sm-j510fn';
        }

        if (preg_match('/sm\-j510f/i', $useragent)) {
            $deviceCode = 'sm-j510f';
        }

        if (preg_match('/sm\-j500fn/i', $useragent)) {
            $deviceCode = 'sm-j500fn';
        }

        if (preg_match('/sm\-j500f/i', $useragent)) {
            $deviceCode = 'sm-j500f';
        }

        if (preg_match('/sm\-j500g/i', $useragent)) {
            $deviceCode = 'sm-j500g';
        }

        if (preg_match('/sm\-j500m/i', $useragent)) {
            $deviceCode = 'sm-j500m';
        }

        if (preg_match('/sm\-j500y/i', $useragent)) {
            $deviceCode = 'sm-j500y';
        }

        if (preg_match('/sm\-j500h/i', $useragent)) {
            $deviceCode = 'sm-j500h';
        }

        if (preg_match('/sm\-j5007/i', $useragent)) {
            $deviceCode = 'sm-j5007';
        }

        if (preg_match('/(sm\-j500|galaxy j5)/i', $useragent)) {
            $deviceCode = 'sm-j500';
        }

        if (preg_match('/sm\-j320g/i', $useragent)) {
            $deviceCode = 'sm-j320g';
        }

        if (preg_match('/sm\-j320fn/i', $useragent)) {
            $deviceCode = 'sm-j320fn';
        }

        if (preg_match('/sm\-j320f/i', $useragent)) {
            $deviceCode = 'sm-j320f';
        }

        if (preg_match('/sm\-j3109/i', $useragent)) {
            $deviceCode = 'sm-j3109';
        }

        if (preg_match('/sm\-j120fn/i', $useragent)) {
            $deviceCode = 'sm-j120fn';
        }

        if (preg_match('/sm\-j120f/i', $useragent)) {
            $deviceCode = 'sm-j120f';
        }

        if (preg_match('/sm\-j120g/i', $useragent)) {
            $deviceCode = 'sm-j120g';
        }

        if (preg_match('/sm\-j120h/i', $useragent)) {
            $deviceCode = 'sm-j120h';
        }

        if (preg_match('/sm\-j120m/i', $useragent)) {
            $deviceCode = 'sm-j120m';
        }

        if (preg_match('/sm\-j110f/i', $useragent)) {
            $deviceCode = 'sm-j110f';
        }

        if (preg_match('/sm\-j110g/i', $useragent)) {
            $deviceCode = 'sm-j110g';
        }

        if (preg_match('/sm\-j110h/i', $useragent)) {
            $deviceCode = 'sm-j110h';
        }

        if (preg_match('/sm\-j110l/i', $useragent)) {
            $deviceCode = 'sm-j110l';
        }

        if (preg_match('/sm\-j110m/i', $useragent)) {
            $deviceCode = 'sm-j110m';
        }

        if (preg_match('/sm\-j111f/i', $useragent)) {
            $deviceCode = 'sm-j111f';
        }

        if (preg_match('/sm\-j105h/i', $useragent)) {
            $deviceCode = 'sm-j105h';
        }

        if (preg_match('/sm\-j100h/i', $useragent)) {
            $deviceCode = 'sm-j100h';
        }

        if (preg_match('/sm\-j100y/i', $useragent)) {
            $deviceCode = 'sm-j100y';
        }

        if (preg_match('/sm\-j100f/i', $useragent)) {
            $deviceCode = 'sm-j100f';
        }

        if (preg_match('/sm\-j100ml/i', $useragent)) {
            $deviceCode = 'sm-j100ml';
        }

        if (preg_match('/sm\-j200gu/i', $useragent)) {
            $deviceCode = 'sm-j200gu';
        }

        if (preg_match('/sm\-j200g/i', $useragent)) {
            $deviceCode = 'sm-j200g';
        }

        if (preg_match('/sm\-j200f/i', $useragent)) {
            $deviceCode = 'sm-j200f';
        }

        if (preg_match('/sm\-j200h/i', $useragent)) {
            $deviceCode = 'sm-j200h';
        }

        if (preg_match('/sm\-j200bt/i', $useragent)) {
            $deviceCode = 'sm-j200bt';
        }

        if (preg_match('/sm\-j200y/i', $useragent)) {
            $deviceCode = 'sm-j200y';
        }

        if (preg_match('/sm\-t280/i', $useragent)) {
            $deviceCode = 'sm-t280';
        }

        if (preg_match('/sm\-t2105/i', $useragent)) {
            $deviceCode = 'sm-t2105';
        }

        if (preg_match('/sm\-t210r/i', $useragent)) {
            $deviceCode = 'sm-t210r';
        }

        if (preg_match('/sm\-t210l/i', $useragent)) {
            $deviceCode = 'sm-t210l';
        }

        if (preg_match('/sm\-t210/i', $useragent)) {
            $deviceCode = 'sm-t210';
        }

        if (preg_match('/sm\-t900/i', $useragent)) {
            $deviceCode = 'sm-t900';
        }

        if (preg_match('/sm\-t819/i', $useragent)) {
            $deviceCode = 'sm-t819';
        }

        if (preg_match('/sm\-t815y/i', $useragent)) {
            $deviceCode = 'sm-t815y';
        }

        if (preg_match('/sm\-t815/i', $useragent)) {
            $deviceCode = 'sm-t815';
        }

        if (preg_match('/sm\-t813/i', $useragent)) {
            $deviceCode = 'sm-t813';
        }

        if (preg_match('/sm\-t810x/i', $useragent)) {
            $deviceCode = 'sm-t810x';
        }

        if (preg_match('/sm\-t810/i', $useragent)) {
            $deviceCode = 'sm-t810';
        }

        if (preg_match('/sm\-t805/i', $useragent)) {
            $deviceCode = 'sm-t805';
        }

        if (preg_match('/sm\-t800/i', $useragent)) {
            $deviceCode = 'sm-t800';
        }

        if (preg_match('/sm\-t719/i', $useragent)) {
            $deviceCode = 'sm-t719';
        }

        if (preg_match('/sm\-t715/i', $useragent)) {
            $deviceCode = 'sm-t715';
        }

        if (preg_match('/sm\-t713/i', $useragent)) {
            $deviceCode = 'sm-t713';
        }

        if (preg_match('/sm\-t710/i', $useragent)) {
            $deviceCode = 'sm-t710';
        }

        if (preg_match('/sm\-t705m/i', $useragent)) {
            $deviceCode = 'sm-t705m';
        }

        if (preg_match('/sm\-t705/i', $useragent)) {
            $deviceCode = 'sm-t705';
        }

        if (preg_match('/sm\-t700/i', $useragent)) {
            $deviceCode = 'sm-t700';
        }

        if (preg_match('/sm\-t670/i', $useragent)) {
            $deviceCode = 'sm-t670';
        }

        if (preg_match('/sm\-t585/i', $useragent)) {
            $deviceCode = 'sm-t585';
        }

        if (preg_match('/sm\-t580/i', $useragent)) {
            $deviceCode = 'sm-t580';
        }

        if (preg_match('/sm\-t550x/i', $useragent)) {
            $deviceCode = 'sm-t550x';
        }

        if (preg_match('/sm\-t550/i', $useragent)) {
            $deviceCode = 'sm-t550';
        }

        if (preg_match('/sm\-t555/i', $useragent)) {
            $deviceCode = 'sm-t555';
        }

        if (preg_match('/sm\-t561/i', $useragent)) {
            $deviceCode = 'sm-t561';
        }

        if (preg_match('/sm\-t560/i', $useragent)) {
            $deviceCode = 'sm-t560';
        }

        if (preg_match('/sm\-t535/i', $useragent)) {
            $deviceCode = 'sm-t535';
        }

        if (preg_match('/sm\-t533/i', $useragent)) {
            $deviceCode = 'sm-t533';
        }

        if (preg_match('/(sm\-t531|sm \- t531)/i', $useragent)) {
            $deviceCode = 'sm-t531';
        }

        if (preg_match('/sm\-t530nu/i', $useragent)) {
            $deviceCode = 'sm-t530nu';
        }

        if (preg_match('/sm\-t530/i', $useragent)) {
            $deviceCode = 'sm-t530';
        }

        if (preg_match('/sm\-t525/i', $useragent)) {
            $deviceCode = 'sm-t525';
        }

        if (preg_match('/sm\-t520/i', $useragent)) {
            $deviceCode = 'sm-t520';
        }

        if (preg_match('/sm\-t365/i', $useragent)) {
            $deviceCode = 'sm-t365';
        }

        if (preg_match('/sm\-t355y/i', $useragent)) {
            $deviceCode = 'sm-t355y';
        }

        if (preg_match('/sm\-t350/i', $useragent)) {
            $deviceCode = 'sm-t350';
        }

        if (preg_match('/sm\-t335/i', $useragent)) {
            $deviceCode = 'sm-t335';
        }

        if (preg_match('/sm\-t331/i', $useragent)) {
            $deviceCode = 'sm-t331';
        }

        if (preg_match('/sm\-t330/i', $useragent)) {
            $deviceCode = 'sm-t330';
        }

        if (preg_match('/sm\-t325/i', $useragent)) {
            $deviceCode = 'sm-t325';
        }

        if (preg_match('/sm\-t320/i', $useragent)) {
            $deviceCode = 'sm-t320';
        }

        if (preg_match('/sm\-t315/i', $useragent)) {
            $deviceCode = 'sm-t315';
        }

        if (preg_match('/sm\-t311/i', $useragent)) {
            $deviceCode = 'sm-t311';
        }

        if (preg_match('/sm\-t310/i', $useragent)) {
            $deviceCode = 'sm-t310';
        }

        if (preg_match('/sm\-t235/i', $useragent)) {
            $deviceCode = 'sm-t235';
        }

        if (preg_match('/sm\-t231/i', $useragent)) {
            $deviceCode = 'sm-t231';
        }

        if (preg_match('/sm\-t230nu/i', $useragent)) {
            $deviceCode = 'sm-t230nu';
        }

        if (preg_match('/sm\-t230/i', $useragent)) {
            $deviceCode = 'sm-t230';
        }

        if (preg_match('/sm\-t211/i', $useragent)) {
            $deviceCode = 'sm-t211';
        }

        if (preg_match('/sm\-t116/i', $useragent)) {
            $deviceCode = 'sm-t116';
        }

        if (preg_match('/sm\-t113/i', $useragent)) {
            $deviceCode = 'sm-t113';
        }

        if (preg_match('/sm\-t111/i', $useragent)) {
            $deviceCode = 'sm-t111';
        }

        if (preg_match('/sm\-t110/i', $useragent)) {
            $deviceCode = 'sm-t110';
        }

        if (preg_match('/sm\-p907a/i', $useragent)) {
            $deviceCode = 'sm-p907a';
        }

        if (preg_match('/sm\-p905m/i', $useragent)) {
            $deviceCode = 'sm-p905m';
        }

        if (preg_match('/sm\-p905v/i', $useragent)) {
            $deviceCode = 'sm-p905v';
        }

        if (preg_match('/sm\-p905/i', $useragent)) {
            $deviceCode = 'sm-p905';
        }

        if (preg_match('/sm\-p901/i', $useragent)) {
            $deviceCode = 'sm-p901';
        }

        if (preg_match('/sm\-p900/i', $useragent)) {
            $deviceCode = 'sm-p900';
        }

        if (preg_match('/sm\-p605/i', $useragent)) {
            $deviceCode = 'sm-p605';
        }

        if (preg_match('/sm\-p601/i', $useragent)) {
            $deviceCode = 'sm-p601';
        }

        if (preg_match('/sm\-p600/i', $useragent)) {
            $deviceCode = 'sm-p600';
        }

        if (preg_match('/sm\-p550/i', $useragent)) {
            $deviceCode = 'sm-p550';
        }

        if (preg_match('/sm\-p355/i', $useragent)) {
            $deviceCode = 'sm-p355';
        }

        if (preg_match('/sm\-p350/i', $useragent)) {
            $deviceCode = 'sm-p350';
        }

        if (preg_match('/sm\-n930fd/i', $useragent)) {
            $deviceCode = 'sm-n930fd';
        }

        if (preg_match('/sm\-n930f/i', $useragent)) {
            $deviceCode = 'sm-n930f';
        }

        if (preg_match('/sm\-n930w8/i', $useragent)) {
            $deviceCode = 'sm-n930w8';
        }

        if (preg_match('/sm\-n9300/i', $useragent)) {
            $deviceCode = 'sm-n9300';
        }

        if (preg_match('/sm\-n9308/i', $useragent)) {
            $deviceCode = 'sm-n9308';
        }

        if (preg_match('/sm\-n930k/i', $useragent)) {
            $deviceCode = 'sm-n930k';
        }

        if (preg_match('/sm\-n930l/i', $useragent)) {
            $deviceCode = 'sm-n930l';
        }

        if (preg_match('/sm\-n930s/i', $useragent)) {
            $deviceCode = 'sm-n930s';
        }

        if (preg_match('/sm\-n930az/i', $useragent)) {
            $deviceCode = 'sm-n930az';
        }

        if (preg_match('/sm\-n930a/i', $useragent)) {
            $deviceCode = 'sm-n930a';
        }

        if (preg_match('/sm\-n930t1/i', $useragent)) {
            $deviceCode = 'sm-n930t1';
        }

        if (preg_match('/sm\-n930t/i', $useragent)) {
            $deviceCode = 'sm-n930t';
        }

        if (preg_match('/sm\-n930r6/i', $useragent)) {
            $deviceCode = 'sm-n930r6';
        }

        if (preg_match('/sm\-n930r7/i', $useragent)) {
            $deviceCode = 'sm-n930r7';
        }

        if (preg_match('/sm\-n930r4/i', $useragent)) {
            $deviceCode = 'sm-n930r4';
        }

        if (preg_match('/sm\-n930p/i', $useragent)) {
            $deviceCode = 'sm-n930p';
        }

        if (preg_match('/sm\-n930v/i', $useragent)) {
            $deviceCode = 'sm-n930v';
        }

        if (preg_match('/sm\-n930u/i', $useragent)) {
            $deviceCode = 'sm-n930u';
        }

        if (preg_match('/sm\-n920a/i', $useragent)) {
            $deviceCode = 'sm-n920a';
        }

        if (preg_match('/sm\-n920r/i', $useragent)) {
            $deviceCode = 'sm-n920r';
        }

        if (preg_match('/sm\-n920s/i', $useragent)) {
            $deviceCode = 'sm-n920s';
        }

        if (preg_match('/sm\-n920k/i', $useragent)) {
            $deviceCode = 'sm-n920k';
        }

        if (preg_match('/sm\-n920l/i', $useragent)) {
            $deviceCode = 'sm-n920l';
        }

        if (preg_match('/sm\-n920g/i', $useragent)) {
            $deviceCode = 'sm-n920g';
        }

        if (preg_match('/sm\-n920c/i', $useragent)) {
            $deviceCode = 'sm-n920c';
        }

        if (preg_match('/sm\-n920v/i', $useragent)) {
            $deviceCode = 'sm-n920v';
        }

        if (preg_match('/sm\-n920t/i', $useragent)) {
            $deviceCode = 'sm-n920t';
        }

        if (preg_match('/sm\-n920p/i', $useragent)) {
            $deviceCode = 'sm-n920p';
        }

        if (preg_match('/sm\-n920a/i', $useragent)) {
            $deviceCode = 'sm-n920a';
        }

        if (preg_match('/sm\-n920i/i', $useragent)) {
            $deviceCode = 'sm-n920i';
        }

        if (preg_match('/sm\-n920w8/i', $useragent)) {
            $deviceCode = 'sm-n920w8';
        }

        if (preg_match('/sm\-n9200/i', $useragent)) {
            $deviceCode = 'sm-n9200';
        }

        if (preg_match('/sm\-n9208/i', $useragent)) {
            $deviceCode = 'sm-n9208';
        }

        if (preg_match('/(sm\-n9009|n9009)/i', $useragent)) {
            $deviceCode = 'sm-n9009';
        }

        if (preg_match('/sm\-n9008v/i', $useragent)) {
            $deviceCode = 'sm-n9008v';
        }

        if (preg_match('/(sm\-n9007|N9007)/i', $useragent)) {
            $deviceCode = 'sm-n9007';
        }

        if (preg_match('/(sm\-n9006|n9006)/i', $useragent)) {
            $deviceCode = 'sm-n9006';
        }

        if (preg_match('/(sm\-n9005|n9005)/i', $useragent)) {
            $deviceCode = 'sm-n9005';
        }

        if (preg_match('/(sm\-n9002|n9002)/i', $useragent)) {
            $deviceCode = 'sm-n9002';
        }

        if (preg_match('/sm\-n8000/i', $useragent)) {
            $deviceCode = 'sm-n8000';
        }

        if (preg_match('/sm\-n7505l/i', $useragent)) {
            $deviceCode = 'sm-n7505l';
        }

        if (preg_match('/sm\-n7505/i', $useragent)) {
            $deviceCode = 'sm-n7505';
        }

        if (preg_match('/sm\-n7502/i', $useragent)) {
            $deviceCode = 'sm-n7502';
        }

        if (preg_match('/sm\-n7500q/i', $useragent)) {
            $deviceCode = 'sm-n7500q';
        }

        if (preg_match('/sm\-n750/i', $useragent)) {
            $deviceCode = 'sm-n750';
        }

        if (preg_match('/sm\-n916s/i', $useragent)) {
            $deviceCode = 'sm-n916s';
        }

        if (preg_match('/sm\-n915fy/i', $useragent)) {
            $deviceCode = 'sm-n915fy';
        }

        if (preg_match('/sm\-n915f/i', $useragent)) {
            $deviceCode = 'sm-n915f';
        }

        if (preg_match('/sm\-n915t/i', $useragent)) {
            $deviceCode = 'sm-n915t';
        }

        if (preg_match('/sm\-n915g/i', $useragent)) {
            $deviceCode = 'sm-n915g';
        }

        if (preg_match('/sm\-n915p/i', $useragent)) {
            $deviceCode = 'sm-n915p';
        }

        if (preg_match('/sm\-n915a/i', $useragent)) {
            $deviceCode = 'sm-n915a';
        }

        if (preg_match('/sm\-n915v/i', $useragent)) {
            $deviceCode = 'sm-n915v';
        }

        if (preg_match('/sm\-n915d/i', $useragent)) {
            $deviceCode = 'sm-n915d';
        }

        if (preg_match('/sm\-n915k/i', $useragent)) {
            $deviceCode = 'sm-n915k';
        }

        if (preg_match('/sm\-n915l/i', $useragent)) {
            $deviceCode = 'sm-n915l';
        }

        if (preg_match('/sm\-n915s/i', $useragent)) {
            $deviceCode = 'sm-n915s';
        }

        if (preg_match('/sm\-n9150/i', $useragent)) {
            $deviceCode = 'sm-n9150';
        }

        if (preg_match('/sm\-n910v/i', $useragent)) {
            $deviceCode = 'sm-n910v';
        }

        if (preg_match('/sm\-n910fq/i', $useragent)) {
            $deviceCode = 'sm-n910fq';
        }

        if (preg_match('/sm\-n910fd/i', $useragent)) {
            $deviceCode = 'sm-n910fd';
        }

        if (preg_match('/sm\-n910f/i', $useragent)) {
            $deviceCode = 'sm-n910f';
        }

        if (preg_match('/sm\-n910c/i', $useragent)) {
            $deviceCode = 'sm-n910c';
        }

        if (preg_match('/sm\-n910a/i', $useragent)) {
            $deviceCode = 'sm-n910a';
        }

        if (preg_match('/sm\-n910h/i', $useragent)) {
            $deviceCode = 'sm-n910h';
        }

        if (preg_match('/sm\-n910k/i', $useragent)) {
            $deviceCode = 'sm-n910k';
        }

        if (preg_match('/sm\-n910p/i', $useragent)) {
            $deviceCode = 'sm-n910p';
        }

        if (preg_match('/sm\-n910x/i', $useragent)) {
            $deviceCode = 'sm-n910x';
        }

        if (preg_match('/sm\-n910s/i', $useragent)) {
            $deviceCode = 'sm-n910s';
        }

        if (preg_match('/sm\-n910l/i', $useragent)) {
            $deviceCode = 'sm-n910l';
        }

        if (preg_match('/sm\-n910g/i', $useragent)) {
            $deviceCode = 'sm-n910g';
        }

        if (preg_match('/sm\-n910m/i', $useragent)) {
            $deviceCode = 'sm-n910m';
        }

        if (preg_match('/sm\-n910t1/i', $useragent)) {
            $deviceCode = 'sm-n910t1';
        }

        if (preg_match('/sm\-n910t3/i', $useragent)) {
            $deviceCode = 'sm-n910t3';
        }

        if (preg_match('/sm\-n910t/i', $useragent)) {
            $deviceCode = 'sm-n910t';
        }

        if (preg_match('/sm\-n910u/i', $useragent)) {
            $deviceCode = 'sm-n910u';
        }

        if (preg_match('/sm\-n910r4/i', $useragent)) {
            $deviceCode = 'sm-n910r4';
        }

        if (preg_match('/sm\-n910w8/i', $useragent)) {
            $deviceCode = 'sm-n910w8';
        }

        if (preg_match('/sm\-n9100h/i', $useragent)) {
            $deviceCode = 'sm-n9100h';
        }

        if (preg_match('/sm\-n9100/i', $useragent)) {
            $deviceCode = 'sm-n9100';
        }

        if (preg_match('/sm\-n900v/i', $useragent)) {
            $deviceCode = 'sm-n900v';
        }

        if (preg_match('/sm\-n900a/i', $useragent)) {
            $deviceCode = 'sm-n900a';
        }

        if (preg_match('/sm\-n900s/i', $useragent)) {
            $deviceCode = 'sm-n900s';
        }

        if (preg_match('/sm\-n900t/i', $useragent)) {
            $deviceCode = 'sm-n900t';
        }

        if (preg_match('/sm\-n900p/i', $useragent)) {
            $deviceCode = 'sm-n900p';
        }

        if (preg_match('/sm\-n900l/i', $useragent)) {
            $deviceCode = 'sm-n900l';
        }

        if (preg_match('/sm\-n900k/i', $useragent)) {
            $deviceCode = 'sm-n900k';
        }

        if (preg_match('/sm\-n9000q/i', $useragent)) {
            $deviceCode = 'sm-n9000q';
        }

        if (preg_match('/sm\-n900w8/i', $useragent)) {
            $deviceCode = 'sm-n900w8';
        }

        if (preg_match('/sm\-n900/i', $useragent)) {
            $deviceCode = 'sm-n900';
        }

        if (preg_match('/sm\-g935fd/i', $useragent)) {
            $deviceCode = 'sm-g935fd';
        }

        if (preg_match('/sm\-g935f/i', $useragent)) {
            $deviceCode = 'sm-g935f';
        }

        if (preg_match('/sm\-g935a/i', $useragent)) {
            $deviceCode = 'sm-g935a';
        }

        if (preg_match('/sm\-g935p/i', $useragent)) {
            $deviceCode = 'sm-g935p';
        }

        if (preg_match('/sm\-g935r/i', $useragent)) {
            $deviceCode = 'sm-g935r';
        }

        if (preg_match('/sm\-g935t/i', $useragent)) {
            $deviceCode = 'sm-g935t';
        }

        if (preg_match('/sm\-g935v/i', $useragent)) {
            $deviceCode = 'sm-g935v';
        }

        if (preg_match('/sm\-g935w8/i', $useragent)) {
            $deviceCode = 'sm-g935w8';
        }

        if (preg_match('/sm\-g935k/i', $useragent)) {
            $deviceCode = 'sm-g935k';
        }

        if (preg_match('/sm\-g935l/i', $useragent)) {
            $deviceCode = 'sm-g935l';
        }

        if (preg_match('/sm\-g935s/i', $useragent)) {
            $deviceCode = 'sm-g935s';
        }

        if (preg_match('/sm\-g935x/i', $useragent)) {
            $deviceCode = 'sm-g935x';
        }

        if (preg_match('/sm\-g9350/i', $useragent)) {
            $deviceCode = 'sm-g9350';
        }

        if (preg_match('/sm\-g930fd/i', $useragent)) {
            $deviceCode = 'sm-g930fd';
        }

        if (preg_match('/sm\-g930f/i', $useragent)) {
            $deviceCode = 'sm-g930f';
        }

        if (preg_match('/sm\-g9308/i', $useragent)) {
            $deviceCode = 'sm-g9308';
        }

        if (preg_match('/sm\-g930a/i', $useragent)) {
            $deviceCode = 'sm-g930a';
        }

        if (preg_match('/sm\-g930p/i', $useragent)) {
            $deviceCode = 'sm-g930p';
        }

        if (preg_match('/sm\-g930v/i', $useragent)) {
            $deviceCode = 'sm-g930v';
        }

        if (preg_match('/sm\-g930r/i', $useragent)) {
            $deviceCode = 'sm-g930r';
        }

        if (preg_match('/sm\-g930t/i', $useragent)) {
            $deviceCode = 'sm-g930t';
        }

        if (preg_match('/sm\-g930/i', $useragent)) {
            $deviceCode = 'sm-g930';
        }

        if (preg_match('/sm\-g9006v/i', $useragent)) {
            $deviceCode = 'sm-g9006v';
        }

        if (preg_match('/sm\-g928f/i', $useragent)) {
            $deviceCode = 'sm-g928f';
        }

        if (preg_match('/sm\-g928v/i', $useragent)) {
            $deviceCode = 'sm-g928v';
        }

        if (preg_match('/sm\-g928w8/i', $useragent)) {
            $deviceCode = 'sm-g928w8';
        }

        if (preg_match('/sm\-g928c/i', $useragent)) {
            $deviceCode = 'sm-g928c';
        }

        if (preg_match('/sm\-g928g/i', $useragent)) {
            $deviceCode = 'sm-g928g';
        }

        if (preg_match('/sm\-g928p/i', $useragent)) {
            $deviceCode = 'sm-g928p';
        }

        if (preg_match('/sm\-g928i/i', $useragent)) {
            $deviceCode = 'sm-g928i';
        }

        if (preg_match('/sm\-g9287/i', $useragent)) {
            $deviceCode = 'sm-g9287';
        }

        if (preg_match('/sm\-g925f/i', $useragent)) {
            $deviceCode = 'sm-g925f';
        }

        if (preg_match('/sm\-g925t/i', $useragent)) {
            $deviceCode = 'sm-g925t';
        }

        if (preg_match('/sm\-g925r4/i', $useragent)) {
            $deviceCode = 'sm-g925r4';
        }

        if (preg_match('/sm\-g925i/i', $useragent)) {
            $deviceCode = 'sm-g925i';
        }

        if (preg_match('/sm\-g925p/i', $useragent)) {
            $deviceCode = 'sm-g925p';
        }

        if (preg_match('/sm\-g925k/i', $useragent)) {
            $deviceCode = 'sm-g925k';
        }

        if (preg_match('/sm\-g920k/i', $useragent)) {
            $deviceCode = 'sm-g920k';
        }

        if (preg_match('/sm\-g920l/i', $useragent)) {
            $deviceCode = 'sm-g920l';
        }

        if (preg_match('/sm\-g920p/i', $useragent)) {
            $deviceCode = 'sm-g920p';
        }

        if (preg_match('/sm\-g920v/i', $useragent)) {
            $deviceCode = 'sm-g920v';
        }

        if (preg_match('/sm\-g920t1/i', $useragent)) {
            $deviceCode = 'sm-g920t1';
        }

        if (preg_match('/sm\-g920t/i', $useragent)) {
            $deviceCode = 'sm-g920t';
        }

        if (preg_match('/sm\-g920a/i', $useragent)) {
            $deviceCode = 'sm-g920a';
        }

        if (preg_match('/sm\-g920fd/i', $useragent)) {
            $deviceCode = 'sm-g920fd';
        }

        if (preg_match('/sm\-g920f/i', $useragent)) {
            $deviceCode = 'sm-g920f';
        }

        if (preg_match('/sm\-g920i/i', $useragent)) {
            $deviceCode = 'sm-g920i';
        }

        if (preg_match('/sm\-g920s/i', $useragent)) {
            $deviceCode = 'sm-g920s';
        }

        if (preg_match('/sm\-g9200/i', $useragent)) {
            $deviceCode = 'sm-g9200';
        }

        if (preg_match('/sm\-g9208/i', $useragent)) {
            $deviceCode = 'sm-g9208';
        }

        if (preg_match('/sm\-g9209/i', $useragent)) {
            $deviceCode = 'sm-g9209';
        }

        if (preg_match('/sm\-g920r/i', $useragent)) {
            $deviceCode = 'sm-g920r';
        }

        if (preg_match('/sm\-g920w8/i', $useragent)) {
            $deviceCode = 'sm-g920w8';
        }

        if (preg_match('/sm\-g903f/i', $useragent)) {
            $deviceCode = 'sm-g903f';
        }

        if (preg_match('/sm\-g901f/i', $useragent)) {
            $deviceCode = 'sm-g901f';
        }

        if (preg_match('/sm\-g900w8/i', $useragent)) {
            $deviceCode = 'sm-g900w8';
        }

        if (preg_match('/sm\-g900v/i', $useragent)) {
            $deviceCode = 'sm-g900v';
        }

        if (preg_match('/sm\-g900t/i', $useragent)) {
            $deviceCode = 'sm-g900t';
        }

        if (preg_match('/sm\-g900i/i', $useragent)) {
            $deviceCode = 'sm-g900i';
        }

        if (preg_match('/sm\-g900f/i', $useragent)) {
            $deviceCode = 'sm-g900f';
        }

        if (preg_match('/sm\-g900a/i', $useragent)) {
            $deviceCode = 'sm-g900a';
        }

        if (preg_match('/sm\-g900h/i', $useragent)) {
            $deviceCode = 'sm-g900h';
        }

        if (preg_match('/sm\-g900/i', $useragent)) {
            $deviceCode = 'sm-g900';
        }

        if (preg_match('/sm\-g890a/i', $useragent)) {
            $deviceCode = 'sm-g890a';
        }

        if (preg_match('/sm\-g870f/i', $useragent)) {
            $deviceCode = 'sm-g870f';
        }

        if (preg_match('/sm\-g870a/i', $useragent)) {
            $deviceCode = 'sm-g870a';
        }

        if (preg_match('/sm\-g850fq/i', $useragent)) {
            $deviceCode = 'sm-g850fq';
        }

        if (preg_match('/(sm\-g850f|galaxy alpha)/i', $useragent)) {
            $deviceCode = 'sm-g850f';
        }

        if (preg_match('/sm\-g850a/i', $useragent)) {
            $deviceCode = 'sm-g850a';
        }

        if (preg_match('/sm\-g850m/i', $useragent)) {
            $deviceCode = 'sm-g850m';
        }

        if (preg_match('/sm\-g850t/i', $useragent)) {
            $deviceCode = 'sm-g850t';
        }

        if (preg_match('/sm\-g850w/i', $useragent)) {
            $deviceCode = 'sm-g850w';
        }

        if (preg_match('/sm\-g850y/i', $useragent)) {
            $deviceCode = 'sm-g850y';
        }

        if (preg_match('/sm\-g800hq/i', $useragent)) {
            $deviceCode = 'sm-g800hq';
        }

        if (preg_match('/sm\-g800h/i', $useragent)) {
            $deviceCode = 'sm-g800h';
        }

        if (preg_match('/sm\-g800f/i', $useragent)) {
            $deviceCode = 'sm-g800f';
        }

        if (preg_match('/sm\-g800m/i', $useragent)) {
            $deviceCode = 'sm-g800m';
        }

        if (preg_match('/sm\-g800a/i', $useragent)) {
            $deviceCode = 'sm-g800a';
        }

        if (preg_match('/sm\-g800r4/i', $useragent)) {
            $deviceCode = 'sm-g800r4';
        }

        if (preg_match('/sm\-g800y/i', $useragent)) {
            $deviceCode = 'sm-g800y';
        }

        if (preg_match('/sm\-g720n0/i', $useragent)) {
            $deviceCode = 'sm-g720n0';
        }

        if (preg_match('/sm\-g720d/i', $useragent)) {
            $deviceCode = 'sm-g720d';
        }

        if (preg_match('/sm\-g7202/i', $useragent)) {
            $deviceCode = 'sm-g7202';
        }

        if (preg_match('/sm\-g7102t/i', $useragent)) {
            $deviceCode = 'sm-g7102t';
        }

        if (preg_match('/sm\-g7102/i', $useragent)) {
            $deviceCode = 'sm-g7102';
        }

        if (preg_match('/sm\-g7105l/i', $useragent)) {
            $deviceCode = 'sm-g7105l';
        }

        if (preg_match('/sm\-g7105/i', $useragent)) {
            $deviceCode = 'sm-g7105';
        }

        if (preg_match('/sm\-g7106/i', $useragent)) {
            $deviceCode = 'sm-g7106';
        }

        if (preg_match('/sm\-g7108v/i', $useragent)) {
            $deviceCode = 'sm-g7108v';
        }

        if (preg_match('/sm\-g7108/i', $useragent)) {
            $deviceCode = 'sm-g7108';
        }

        if (preg_match('/sm\-g7109/i', $useragent)) {
            $deviceCode = 'sm-g7109';
        }

        if (preg_match('/sm\-g710l/i', $useragent)) {
            $deviceCode = 'sm-g710l';
        }

        if (preg_match('/sm\-g710/i', $useragent)) {
            $deviceCode = 'sm-g710';
        }

        if (preg_match('/sm\-g531f/i', $useragent)) {
            $deviceCode = 'sm-g531f';
        }

        if (preg_match('/sm\-g531h/i', $useragent)) {
            $deviceCode = 'sm-g531h';
        }

        if (preg_match('/sm\-g530t/i', $useragent)) {
            $deviceCode = 'sm-g530t';
        }

        if (preg_match('/sm\-g530h/i', $useragent)) {
            $deviceCode = 'sm-g530h';
        }

        if (preg_match('/sm\-g530fz/i', $useragent)) {
            $deviceCode = 'sm-g530fz';
        }

        if (preg_match('/sm\-g530f/i', $useragent)) {
            $deviceCode = 'sm-g530f';
        }

        if (preg_match('/sm\-g530y/i', $useragent)) {
            $deviceCode = 'sm-g530y';
        }

        if (preg_match('/sm\-g530m/i', $useragent)) {
            $deviceCode = 'sm-g530m';
        }

        if (preg_match('/sm\-g530bt/i', $useragent)) {
            $deviceCode = 'sm-g530bt';
        }

        if (preg_match('/sm\-g5306w/i', $useragent)) {
            $deviceCode = 'sm-g5306w';
        }

        if (preg_match('/sm\-g5308w/i', $useragent)) {
            $deviceCode = 'sm-g5308w';
        }

        if (preg_match('/sm\-g389f/i', $useragent)) {
            $deviceCode = 'sm-g389f';
        }

        if (preg_match('/sm\-g3815/i', $useragent)) {
            $deviceCode = 'sm-g3815';
        }

        if (preg_match('/sm\-g388f/i', $useragent)) {
            $deviceCode = 'sm-g388f';
        }

        if (preg_match('/sm\-g386f/i', $useragent)) {
            $deviceCode = 'sm-g386f';
        }

        if (preg_match('/sm\-g361f/i', $useragent)) {
            $deviceCode = 'sm-g361f';
        }

        if (preg_match('/sm\-g361h/i', $useragent)) {
            $deviceCode = 'sm-g361h';
        }

        if (preg_match('/sm\-g360hu/i', $useragent)) {
            $deviceCode = 'sm-g360hu';
        }

        if (preg_match('/sm\-g360h/i', $useragent)) {
            $deviceCode = 'sm-g360h';
        }

        if (preg_match('/sm\-g360t1/i', $useragent)) {
            $deviceCode = 'sm-g360t1';
        }

        if (preg_match('/sm\-g360t/i', $useragent)) {
            $deviceCode = 'sm-g360t';
        }

        if (preg_match('/sm\-g360bt/i', $useragent)) {
            $deviceCode = 'sm-g360bt';
        }

        if (preg_match('/sm\-g360f/i', $useragent)) {
            $deviceCode = 'sm-g360f';
        }

        if (preg_match('/sm\-g360g/i', $useragent)) {
            $deviceCode = 'sm-g360g';
        }

        if (preg_match('/sm\-g360az/i', $useragent)) {
            $deviceCode = 'sm-g360az';
        }

        if (preg_match('/sm\-g357fz/i', $useragent)) {
            $deviceCode = 'sm-g357fz';
        }

        if (preg_match('/sm\-g355hq/i', $useragent)) {
            $deviceCode = 'sm-g355hq';
        }

        if (preg_match('/sm\-g355hn/i', $useragent)) {
            $deviceCode = 'sm-g355hn';
        }

        if (preg_match('/sm\-g355h/i', $useragent)) {
            $deviceCode = 'sm-g355h';
        }

        if (preg_match('/sm\-g355m/i', $useragent)) {
            $deviceCode = 'sm-g355m';
        }

        if (preg_match('/sm\-g3502l/i', $useragent)) {
            $deviceCode = 'sm-g3502l';
        }

        if (preg_match('/sm\-g3502t/i', $useragent)) {
            $deviceCode = 'sm-g3502t';
        }

        if (preg_match('/sm\-g3500/i', $useragent)) {
            $deviceCode = 'sm-g3500';
        }

        if (preg_match('/sm\-g350e/i', $useragent)) {
            $deviceCode = 'sm-g350e';
        }

        if (preg_match('/sm\-g350/i', $useragent)) {
            $deviceCode = 'sm-g350';
        }

        if (preg_match('/sm\-g318h/i', $useragent)) {
            $deviceCode = 'sm-g318h';
        }

        if (preg_match('/sm\-g313hu/i', $useragent)) {
            $deviceCode = 'sm-g313hu';
        }

        if (preg_match('/sm\-g313hn/i', $useragent)) {
            $deviceCode = 'sm-g313hn';
        }

        if (preg_match('/sm\-g310hn/i', $useragent)) {
            $deviceCode = 'sm-g310hn';
        }

        if (preg_match('/sm\-g130h/i', $useragent)) {
            $deviceCode = 'sm-g130h';
        }

        if (preg_match('/sm\-g110h/i', $useragent)) {
            $deviceCode = 'sm-g110h';
        }

        if (preg_match('/sm\-e700f/i', $useragent)) {
            $deviceCode = 'sm-e700f';
        }

        if (preg_match('/sm\-e700h/i', $useragent)) {
            $deviceCode = 'sm-e700h';
        }

        if (preg_match('/sm\-e700m/i', $useragent)) {
            $deviceCode = 'sm-e700m';
        }

        if (preg_match('/sm\-e7000/i', $useragent)) {
            $deviceCode = 'sm-e7000';
        }

        if (preg_match('/sm\-e7009/i', $useragent)) {
            $deviceCode = 'sm-e7009';
        }

        if (preg_match('/sm\-e500h/i', $useragent)) {
            $deviceCode = 'sm-e500h';
        }

        if (preg_match('/sm\-c115/i', $useragent)) {
            $deviceCode = 'sm-c115';
        }

        if (preg_match('/sm\-c111/i', $useragent)) {
            $deviceCode = 'sm-c111';
        }

        if (preg_match('/sm\-c105/i', $useragent)) {
            $deviceCode = 'sm-c105';
        }

        if (preg_match('/sm\-c101/i', $useragent)) {
            $deviceCode = 'sm-c101';
        }

        if (preg_match('/sm\-z130h/i', $useragent)) {
            $deviceCode = 'sm-z130h';
        }

        if (preg_match('/sm\-b550h/i', $useragent)) {
            $deviceCode = 'sm-b550h';
        }

        if (preg_match('/sgh\-t999/i', $useragent)) {
            $deviceCode = 'sgh-t999';
        }

        if (preg_match('/sgh\-t989d/i', $useragent)) {
            $deviceCode = 'sgh-t989d';
        }

        if (preg_match('/sgh\-t989/i', $useragent)) {
            $deviceCode = 'sgh-t989';
        }

        if (preg_match('/sgh\-t959v/i', $useragent)) {
            $deviceCode = 'sgh-t959v';
        }

        if (preg_match('/sgh\-t959/i', $useragent)) {
            $deviceCode = 'sgh-t959';
        }

        if (preg_match('/sgh\-t899m/i', $useragent)) {
            $deviceCode = 'sgh-t899m';
        }

        if (preg_match('/sgh\-t889/i', $useragent)) {
            $deviceCode = 'sgh-t889';
        }

        if (preg_match('/sgh\-t859/i', $useragent)) {
            $deviceCode = 'sgh-t859';
        }

        if (preg_match('/sgh\-t839/i', $useragent)) {
            $deviceCode = 'sgh-t839';
        }

        if (preg_match('/(sgh\-t769|blaze)/i', $useragent)) {
            $deviceCode = 'sgh-t769';
        }

        if (preg_match('/sgh\-t759/i', $useragent)) {
            $deviceCode = 'sgh-t759';
        }

        if (preg_match('/sgh\-t669/i', $useragent)) {
            $deviceCode = 'sgh-t669';
        }

        if (preg_match('/sgh\-t528g/i', $useragent)) {
            $deviceCode = 'sgh-t528g';
        }

        if (preg_match('/sgh\-t499/i', $useragent)) {
            $deviceCode = 'sgh-t499';
        }

        if (preg_match('/sgh\-m919/i', $useragent)) {
            $deviceCode = 'sgh-m919';
        }

        if (preg_match('/sgh\-i997r/i', $useragent)) {
            $deviceCode = 'sgh-i997r';
        }

        if (preg_match('/sgh\-i997/i', $useragent)) {
            $deviceCode = 'sgh-i997';
        }

        if (preg_match('/SGH\-I957R/i', $useragent)) {
            $deviceCode = 'sgh-i957r';
        }

        if (preg_match('/SGH\-i957/i', $useragent)) {
            $deviceCode = 'sgh-i957';
        }

        if (preg_match('/sgh\-i917/i', $useragent)) {
            $deviceCode = 'sgh-i917';
        }

        if (preg_match('/sgh-i900v/i', $useragent)) {
            $deviceCode = 'sgh-i900v';
        }

        if (preg_match('/sgh\-i900/i', $useragent)) {
            $deviceCode = 'sgh-i900';
        }

        if (preg_match('/sgh\-i897/i', $useragent)) {
            $deviceCode = 'sgh-i897';
        }

        if (preg_match('/sgh\-i857/i', $useragent)) {
            $deviceCode = 'sgh-i857';
        }

        if (preg_match('/sgh\-i780/i', $useragent)) {
            $deviceCode = 'sgh-i780';
        }

        if (preg_match('/sgh\-i777/i', $useragent)) {
            $deviceCode = 'sgh-i777';
        }

        if (preg_match('/sgh\-i747m/i', $useragent)) {
            $deviceCode = 'sgh-i747m';
        }

        if (preg_match('/sgh\-i747/i', $useragent)) {
            $deviceCode = 'sgh-i747';
        }

        if (preg_match('/sgh\-i727r/i', $useragent)) {
            $deviceCode = 'sgh-i727r';
        }

        if (preg_match('/sgh\-i727/i', $useragent)) {
            $deviceCode = 'sgh-i727';
        }

        if (preg_match('/sgh\-i717/i', $useragent)) {
            $deviceCode = 'sgh-i717';
        }

        if (preg_match('/sgh\-i577/i', $useragent)) {
            $deviceCode = 'sgh-i577';
        }

        if (preg_match('/sgh\-i547/i', $useragent)) {
            $deviceCode = 'sgh-i547';
        }

        if (preg_match('/sgh\-i497/i', $useragent)) {
            $deviceCode = 'sgh-i497';
        }

        if (preg_match('/sgh\-i467/i', $useragent)) {
            $deviceCode = 'sgh-i467';
        }

        if (preg_match('/sgh\-i337m/i', $useragent)) {
            $deviceCode = 'sgh-i337m';
        }

        if (preg_match('/sgh\-i337/i', $useragent)) {
            $deviceCode = 'sgh-i337';
        }

        if (preg_match('/sgh\-i317/i', $useragent)) {
            $deviceCode = 'sgh-i317';
        }

        if (preg_match('/sgh\-i257/i', $useragent)) {
            $deviceCode = 'sgh-i257';
        }

        if (preg_match('/sgh\-f480i/i', $useragent)) {
            $deviceCode = 'sgh-f480i';
        }

        if (preg_match('/sgh\-f480/i', $useragent)) {
            $deviceCode = 'sgh-f480';
        }

        if (preg_match('/sgh\-e250i/i', $useragent)) {
            $deviceCode = 'sgh-e250i';
        }

        if (preg_match('/sgh\-e250/i', $useragent)) {
            $deviceCode = 'sgh-e250';
        }

        if (preg_match('/(sgh\-b100|sec\-sghb100)/i', $useragent)) {
            $deviceCode = 'sgh-b100';
        }

        if (preg_match('/sec\-sghu600b/i', $useragent)) {
            $deviceCode = 'sgh-u600b';
        }

        if (preg_match('/sgh\-u800/i', $useragent)) {
            $deviceCode = 'sgh-u800';
        }

        if (preg_match('/shv\-e370k/i', $useragent)) {
            $deviceCode = 'shv-e370k';
        }

        if (preg_match('/shv\-e250k/i', $useragent)) {
            $deviceCode = 'shv-e250k';
        }

        if (preg_match('/shv\-e250l/i', $useragent)) {
            $deviceCode = 'shv-e250l';
        }

        if (preg_match('/shv\-e250s/i', $useragent)) {
            $deviceCode = 'shv-e250s';
        }

        if (preg_match('/shv\-e210l/i', $useragent)) {
            $deviceCode = 'shv-e210l';
        }

        if (preg_match('/shv\-e210k/i', $useragent)) {
            $deviceCode = 'shv-e210k';
        }

        if (preg_match('/shv\-e210s/i', $useragent)) {
            $deviceCode = 'shv-e210s';
        }

        if (preg_match('/shv\-e160s/i', $useragent)) {
            $deviceCode = 'shv-e160s';
        }

        if (preg_match('/shw\-m110s/i', $useragent)) {
            $deviceCode = 'shw-m110s';
        }

        if (preg_match('/shw\-m180s/i', $useragent)) {
            $deviceCode = 'shw-m180s';
        }

        if (preg_match('/shw\-m380s/i', $useragent)) {
            $deviceCode = 'shw-m380s';
        }

        if (preg_match('/shw\-m380w/i', $useragent)) {
            $deviceCode = 'shw-m380w';
        }

        if (preg_match('/shw\-m930bst/i', $useragent)) {
            $deviceCode = 'shw-m930bst';
        }

        if (preg_match('/shw\-m480w/i', $useragent)) {
            $deviceCode = 'shw-m480w';
        }

        if (preg_match('/shw\-m380k/i', $useragent)) {
            $deviceCode = 'shw-m380k';
        }

        if (preg_match('/scl24/i', $useragent)) {
            $deviceCode = 'scl24';
        }

        if (preg_match('/sch\-u820/i', $useragent)) {
            $deviceCode = 'sch-u820';
        }

        if (preg_match('/sch\-u750/i', $useragent)) {
            $deviceCode = 'sch-u750';
        }

        if (preg_match('/sch\-u660/i', $useragent)) {
            $deviceCode = 'sch-u660';
        }

        if (preg_match('/sch\-u485/i', $useragent)) {
            $deviceCode = 'sch-u485';
        }

        if (preg_match('/sch\-r970/i', $useragent)) {
            $deviceCode = 'sch-r970';
        }

        if (preg_match('/sch\-r950/i', $useragent)) {
            $deviceCode = 'sch-r950';
        }

        if (preg_match('/sch\-r720/i', $useragent)) {
            $deviceCode = 'sch-r720';
        }

        if (preg_match('/sch\-r530u/i', $useragent)) {
            $deviceCode = 'sch-r530u';
        }

        if (preg_match('/sch\-r530c/i', $useragent)) {
            $deviceCode = 'sch-r530c';
        }

        if (preg_match('/sch\-n719/i', $useragent)) {
            $deviceCode = 'sch-n719';
        }

        if (preg_match('/sch\-m828c/i', $useragent)) {
            $deviceCode = 'sch-m828c';
        }

        if (preg_match('/sch\-i535/i', $useragent)) {
            $deviceCode = 'sch-i535';
        }

        if (preg_match('/sch\-i919/i', $useragent)) {
            $deviceCode = 'sch-i919';
        }

        if (preg_match('/sch\-i815/i', $useragent)) {
            $deviceCode = 'sch-i815';
        }

        if (preg_match('/sch\-i800/i', $useragent)) {
            $deviceCode = 'sch-i800';
        }

        if (preg_match('/sch\-i699/i', $useragent)) {
            $deviceCode = 'sch-i699';
        }

        if (preg_match('/sch\-i605/i', $useragent)) {
            $deviceCode = 'sch-i605';
        }

        if (preg_match('/sch\-i545/i', $useragent)) {
            $deviceCode = 'sch-i545';
        }

        if (preg_match('/sch\-i510/i', $useragent)) {
            $deviceCode = 'sch-i510';
        }

        if (preg_match('/sch\-i500/i', $useragent)) {
            $deviceCode = 'sch-i500';
        }

        if (preg_match('/sch\-i435/i', $useragent)) {
            $deviceCode = 'sch-i435';
        }

        if (preg_match('/sch\-i400/i', $useragent)) {
            $deviceCode = 'sch-i400';
        }

        if (preg_match('/sch\-i200/i', $useragent)) {
            $deviceCode = 'sch-i200';
        }

        if (preg_match('/SCH\-S720C/i', $useragent)) {
            $deviceCode = 'sch-s720c';
        }

        if (preg_match('/GT\-S8600/i', $useragent)) {
            $deviceCode = 'gt-s8600';
        }

        if (preg_match('/GT\-S8530/i', $useragent)) {
            $deviceCode = 'gt-s8530';
        }

        if (preg_match('/GT\-S8500/i', $useragent)) {
            $deviceCode = 'gt-s8500';
        }

        if (preg_match('/(samsung|gt)\-s8300/i', $useragent)) {
            $deviceCode = 'gt-s8300';
        }

        if (preg_match('/(samsung|gt)\-s8003/i', $useragent)) {
            $deviceCode = 'gt-s8003';
        }

        if (preg_match('/(samsung|gt)\-s8000/i', $useragent)) {
            $deviceCode = 'gt-s8000';
        }

        if (preg_match('/(samsung|gt)\-s7710/i', $useragent)) {
            $deviceCode = 'gt-s7710';
        }

        if (preg_match('/gt\-s7582/i', $useragent)) {
            $deviceCode = 'gt-s7582';
        }

        if (preg_match('/gt\-s7580/i', $useragent)) {
            $deviceCode = 'gt-s7580';
        }

        if (preg_match('/gt\-s7562l/i', $useragent)) {
            $deviceCode = 'gt-s7562l';
        }

        if (preg_match('/gt\-s7562/i', $useragent)) {
            $deviceCode = 'gt-s7562';
        }

        if (preg_match('/gt\-s7560/i', $useragent)) {
            $deviceCode = 'gt-s7560';
        }

        if (preg_match('/gt\-s7530/i', $useragent)) {
            $deviceCode = 'gt-s7530';
        }

        if (preg_match('/gt\-s7500/i', $useragent)) {
            $deviceCode = 'gt-s7500';
        }

        if (preg_match('/gt\-s7392/i', $useragent)) {
            $deviceCode = 'gt-s7392';
        }

        if (preg_match('/gt\-s7390/i', $useragent)) {
            $deviceCode = 'gt-s7390';
        }

        if (preg_match('/gt\-s7330/i', $useragent)) {
            $deviceCode = 'gt-s7330';
        }

        if (preg_match('/gt\-s7275r/i', $useragent)) {
            $deviceCode = 'gt-s7275r';
        }

        if (preg_match('/gt\-s7275/i', $useragent)) {
            $deviceCode = 'gt-s7275';
        }

        if (preg_match('/gt\-s7272/i', $useragent)) {
            $deviceCode = 'gt-s7272';
        }

        if (preg_match('/gt\-s7270/i', $useragent)) {
            $deviceCode = 'gt-s7270';
        }

        if (preg_match('/gt\-s7262/i', $useragent)) {
            $deviceCode = 'gt-s7262';
        }

        if (preg_match('/gt\-s7250/i', $useragent)) {
            $deviceCode = 'gt-s7250';
        }

        if (preg_match('/gt\-s7233e/i', $useragent)) {
            $deviceCode = 'gt-s7233e';
        }

        if (preg_match('/gt\-s7230e/i', $useragent)) {
            $deviceCode = 'gt-s7230e';
        }

        if (preg_match('/(samsung|gt)\-s7220/i', $useragent)) {
            $deviceCode = 'gt-s7220';
        }

        if (preg_match('/gt\-s6810p/i', $useragent)) {
            $deviceCode = 'gt-s6810p';
        }

        if (preg_match('/gt\-s6810b/i', $useragent)) {
            $deviceCode = 'gt-s6810b';
        }

        if (preg_match('/gt\-s6810/i', $useragent)) {
            $deviceCode = 'gt-s6810';
        }

        if (preg_match('/gt\-s6802/i', $useragent)) {
            $deviceCode = 'gt-s6802';
        }

        if (preg_match('/gt\-s6500d/i', $useragent)) {
            $deviceCode = 'gt-s6500d';
        }

        if (preg_match('/gt\-s6500t/i', $useragent)) {
            $deviceCode = 'gt-s6500t';
        }

        if (preg_match('/gt\-s6500/i', $useragent)) {
            $deviceCode = 'gt-s6500';
        }

        if (preg_match('/gt\-s6312/i', $useragent)) {
            $deviceCode = 'gt-s6312';
        }

        if (preg_match('/gt\-s6310n/i', $useragent)) {
            $deviceCode = 'gt-s6310n';
        }

        if (preg_match('/gt\-s6310/i', $useragent)) {
            $deviceCode = 'gt-s6310';
        }

        if (preg_match('/gt\-s6102b/i', $useragent)) {
            $deviceCode = 'gt-s6102b';
        }

        if (preg_match('/gt\-s6102/i', $useragent)) {
            $deviceCode = 'gt-s6102';
        }

        if (preg_match('/gt\-s5839i/i', $useragent)) {
            $deviceCode = 'gt-s5839i';
        }

        if (preg_match('/gt\-s5830l/i', $useragent)) {
            $deviceCode = 'gt-s5830l';
        }

        if (preg_match('/gt\-s5830i/i', $useragent)) {
            $deviceCode = 'gt-s5830i';
        }

        if (preg_match('/gt\-s5830c/i', $useragent)) {
            $deviceCode = 'gt-s5830c';
        }

        if (preg_match('/gt\-s5570i/i', $useragent)) {
            $deviceCode = 'gt-s5570i';
        }

        if (preg_match('/gt\-s5570/i', $useragent)) {
            $deviceCode = 'gt-s5570';
        }

        if (preg_match('/(gt\-s5830|ace)/i', $useragent)) {
            $deviceCode = 'gt-s5830';
        }

        if (preg_match('/gt\-s5780/i', $useragent)) {
            $deviceCode = 'gt-s5780';
        }

        if (preg_match('/gt\-s5750e/i', $useragent)) {
            $deviceCode = 'gt-s5750e orange';
        }

        if (preg_match('/gt\-s5690/i', $useragent)) {
            $deviceCode = 'gt-s5690';
        }

        if (preg_match('/gt\-s5670/i', $useragent)) {
            $deviceCode = 'gt-s5670';
        }

        if (preg_match('/gt\-s5660/i', $useragent)) {
            $deviceCode = 'gt-s5660';
        }

        if (preg_match('/gt\-s5620/i', $useragent)) {
            $deviceCode = 'gt-s5620';
        }

        if (preg_match('/gt\-s5560i/i', $useragent)) {
            $deviceCode = 'gt-s5560i';
        }

        if (preg_match('/gt\-s5560/i', $useragent)) {
            $deviceCode = 'gt-s5560';
        }

        if (preg_match('/gt\-s5380/i', $useragent)) {
            $deviceCode = 'gt-s5380';
        }

        if (preg_match('/gt\-s5369/i', $useragent)) {
            $deviceCode = 'gt-s5369';
        }

        if (preg_match('/gt\-s5363/i', $useragent)) {
            $deviceCode = 'gt-s5363';
        }

        if (preg_match('/gt\-s5360/i', $useragent)) {
            $deviceCode = 'gt-s5360';
        }

        if (preg_match('/gt\-s5330/i', $useragent)) {
            $deviceCode = 'gt-s5330';
        }

        if (preg_match('/gt\-s5310m/i', $useragent)) {
            $deviceCode = 'gt-s5310m';
        }

        if (preg_match('/gt\-s5310/i', $useragent)) {
            $deviceCode = 'gt-s5310';
        }

        if (preg_match('/gt\-s5302/i', $useragent)) {
            $deviceCode = 'gt-s5302';
        }

        if (preg_match('/gt\-s5301l/i', $useragent)) {
            $deviceCode = 'gt-s5301l';
        }

        if (preg_match('/gt\-s5301/i', $useragent)) {
            $deviceCode = 'gt-s5301';
        }

        if (preg_match('/gt\-s5300b/i', $useragent)) {
            $deviceCode = 'gt-s5300b';
        }

        if (preg_match('/gt\-s5300/i', $useragent)) {
            $deviceCode = 'gt-s5300';
        }

        if (preg_match('/gt\-s5280/i', $useragent)) {
            $deviceCode = 'gt-s5280';
        }

        if (preg_match('/gt\-s5260/i', $useragent)) {
            $deviceCode = 'gt-s5260';
        }

        if (preg_match('/gt\-s5250/i', $useragent)) {
            $deviceCode = 'gt-s5250';
        }

        if (preg_match('/gt\-s5233s/i', $useragent)) {
            $deviceCode = 'gt-s5233s';
        }

        if (preg_match('/gt\-s5230w/i', $useragent)) {
            $deviceCode = 'gt s5230w';
        }

        if (preg_match('/gt\-s5230/i', $useragent)) {
            $deviceCode = 'gt-s5230';
        }

        if (preg_match('/gt\-s5222/i', $useragent)) {
            $deviceCode = 'gt-s5222';
        }

        if (preg_match('/gt\-s5220/i', $useragent)) {
            $deviceCode = 'gt-s5220';
        }

        if (preg_match('/gt\-s3850/i', $useragent)) {
            $deviceCode = 'gt-s3850';
        }

        if (preg_match('/gt\-s3802/i', $useragent)) {
            $deviceCode = 'gt-s3802';
        }

        if (preg_match('/gt\-s3653/i', $useragent)) {
            $deviceCode = 'gt-s3653';
        }

        if (preg_match('/gt\-s3650/i', $useragent)) {
            $deviceCode = 'gt-s3650';
        }

        if (preg_match('/gt\-s3370/i', $useragent)) {
            $deviceCode = 'gt-s3370';
        }

        if (preg_match('/gt\-p7511/i', $useragent)) {
            $deviceCode = 'gt-p7511';
        }

        if (preg_match('/gt\-p7510/i', $useragent)) {
            $deviceCode = 'gt-p7510';
        }

        if (preg_match('/gt\-p7501/i', $useragent)) {
            $deviceCode = 'gt-p7501';
        }

        if (preg_match('/gt\-p7500m/i', $useragent)) {
            $deviceCode = 'gt-p7500m';
        }

        if (preg_match('/gt\-p7500/i', $useragent)) {
            $deviceCode = 'gt-p7500';
        }

        if (preg_match('/gt\-p7320/i', $useragent)) {
            $deviceCode = 'gt-p7320';
        }

        if (preg_match('/gt\-p7310/i', $useragent)) {
            $deviceCode = 'gt-p7310';
        }

        if (preg_match('/gt\-p7300b/i', $useragent)) {
            $deviceCode = 'gt-p7300b';
        }

        if (preg_match('/gt\-p7300/i', $useragent)) {
            $deviceCode = 'gt-p7300';
        }

        if (preg_match('/gt\-p7100/i', $useragent)) {
            $deviceCode = 'gt-p7100';
        }

        if (preg_match('/gt\-p6810/i', $useragent)) {
            $deviceCode = 'gt-p6810';
        }

        if (preg_match('/gt\-p6800/i', $useragent)) {
            $deviceCode = 'gt-p6800';
        }

        if (preg_match('/gt\-p6211/i', $useragent)) {
            $deviceCode = 'gt-p6211';
        }

        if (preg_match('/gt\-p6210/i', $useragent)) {
            $deviceCode = 'gt-p6210';
        }

        if (preg_match('/gt\-p6201/i', $useragent)) {
            $deviceCode = 'gt-p6201';
        }

        if (preg_match('/gt\-p6200/i', $useragent)) {
            $deviceCode = 'gt-p6200';
        }

        if (preg_match('/gt\-p5220/i', $useragent)) {
            $deviceCode = 'gt-p5220';
        }

        if (preg_match('/gt\-p5210/i', $useragent)) {
            $deviceCode = 'gt-p5210';
        }

        if (preg_match('/gt\-p5200/i', $useragent)) {
            $deviceCode = 'gt-p5200';
        }

        if (preg_match('/gt\-p5113/i', $useragent)) {
            $deviceCode = 'gt-p5113';
        }

        if (preg_match('/gt\-p5110/i', $useragent)) {
            $deviceCode = 'gt-p5110';
        }

        if (preg_match('/gt\-p5100/i', $useragent)) {
            $deviceCode = 'gt-p5100';
        }

        if (preg_match('/gt\-p3113/i', $useragent)) {
            $deviceCode = 'gt-p3113';
        }

        if (preg_match('/(gt\-p3100|galaxy tab 2 3g)/i', $useragent)) {
            $deviceCode = 'gt-p3100';
        }

        if (preg_match('/(gt\-p3110|galaxy tab 2)/i', $useragent)) {
            $deviceCode = 'gt-p3110';
        }

        if (preg_match('/gt\-p1010/i', $useragent)) {
            $deviceCode = 'gt-p1010';
        }

        if (preg_match('/gt\-p1000n/i', $useragent)) {
            $deviceCode = 'gt-p1000n';
        }

        if (preg_match('/gt\-p1000m/i', $useragent)) {
            $deviceCode = 'gt-p1000m';
        }

        if (preg_match('/gt\-p1000/i', $useragent)) {
            $deviceCode = 'gt-p1000';
        }

        if (preg_match('/gt\-n9000/i', $useragent)) {
            $deviceCode = 'gt-n9000';
        }

        if (preg_match('/gt\-n8020/i', $useragent)) {
            $deviceCode = 'gt-n8020';
        }

        if (preg_match('/gt\-n8013/i', $useragent)) {
            $deviceCode = 'gt-n8013';
        }

        if (preg_match('/gt\-n8010/i', $useragent)) {
            $deviceCode = 'gt-n8010';
        }

        if (preg_match('/gt\-n8005/i', $useragent)) {
            $deviceCode = 'gt-n8005';
        }

        if (preg_match('/(gt\-n8000d|n8000d)/i', $useragent)) {
            $deviceCode = 'gt-n8000d';
        }

        if (preg_match('/gt\-n8000/i', $useragent)) {
            $deviceCode = 'gt-n8000';
        }

        if (preg_match('/gt\-n7108/i', $useragent)) {
            $deviceCode = 'gt-n7108';
        }

        if (preg_match('/gt\-n7105/i', $useragent)) {
            $deviceCode = 'gt-n7105';
        }

        if (preg_match('/gt\-n7100/i', $useragent)) {
            $deviceCode = 'gt-n7100';
        }

        if (preg_match('/GT\-N7000/i', $useragent)) {
            $deviceCode = 'gt-n7000';
        }

        if (preg_match('/GT\-N5120/i', $useragent)) {
            $deviceCode = 'gt-n5120';
        }

        if (preg_match('/GT\-N5110/i', $useragent)) {
            $deviceCode = 'gt-n5110';
        }

        if (preg_match('/GT\-N5100/i', $useragent)) {
            $deviceCode = 'gt-n5100';
        }

        if (preg_match('/GT\-M7600/i', $useragent)) {
            $deviceCode = 'gt-m7600';
        }

        if (preg_match('/GT\-I9515/i', $useragent)) {
            $deviceCode = 'gt-i9515';
        }

        if (preg_match('/GT\-I9506/i', $useragent)) {
            $deviceCode = 'gt-i9506';
        }

        if (preg_match('/GT\-I9505X/i', $useragent)) {
            $deviceCode = 'gt-i9505x';
        }

        if (preg_match('/GT\-I9505G/i', $useragent)) {
            $deviceCode = 'gt-i9505g';
        }

        if (preg_match('/GT\-I9505/i', $useragent)) {
            $deviceCode = 'gt-i9505';
        }

        if (preg_match('/GT\-I9502/i', $useragent)) {
            $deviceCode = 'gt-i9502';
        }

        if (preg_match('/GT\-I9500/i', $useragent)) {
            $deviceCode = 'gt-i9500';
        }

        if (preg_match('/GT\-I9308/i', $useragent)) {
            $deviceCode = 'gt-i9308';
        }

        if (preg_match('/GT\-I9305/i', $useragent)) {
            $deviceCode = 'gt-i9305';
        }

        if (preg_match('/(gt\-i9301i|i9301i)/i', $useragent)) {
            $deviceCode = 'gt-i9301i';
        }

        if (preg_match('/(gt\-i9301q|i9301q)/i', $useragent)) {
            $deviceCode = 'gt-i9301q';
        }

        if (preg_match('/(gt\-i9301|i9301)/i', $useragent)) {
            $deviceCode = 'gt-i9301';
        }

        if (preg_match('/GT\-I9300I/i', $useragent)) {
            $deviceCode = 'gt-i9300i';
        }

        if (preg_match('/(GT\-l9300|GT\-i9300|I9300)/i', $useragent)) {
            $deviceCode = 'gt-i9300';
        }

        if (preg_match('/(GT\-I9295|I9295)/i', $useragent)) {
            $deviceCode = 'gt-i9295';
        }

        if (preg_match('/GT\-I9210/i', $useragent)) {
            $deviceCode = 'gt-i9210';
        }

        if (preg_match('/GT\-I9205/i', $useragent)) {
            $deviceCode = 'gt-i9205';
        }

        if (preg_match('/GT\-I9200/i', $useragent)) {
            $deviceCode = 'gt-i9200';
        }

        if (preg_match('/gt\-i9195i/i', $useragent)) {
            $deviceCode = 'gt-i9195i';
        }

        if (preg_match('/(gt\-i9195|i9195)/i', $useragent)) {
            $deviceCode = 'gt-i9195';
        }

        if (preg_match('/(gt\-i9192|i9192)/i', $useragent)) {
            $deviceCode = 'gt-i9192';
        }

        if (preg_match('/(gt\-i9190|i9190)/i', $useragent)) {
            $deviceCode = 'gt-i9190';
        }

        if (preg_match('/gt\-i9152/i', $useragent)) {
            $deviceCode = 'gt-i9152';
        }

        if (preg_match('/gt\-i9128v/i', $useragent)) {
            $deviceCode = 'gt-i9128v';
        }

        if (preg_match('/gt\-i9105p/i', $useragent)) {
            $deviceCode = 'gt-i9105p';
        }

        if (preg_match('/gt\-i9105/i', $useragent)) {
            $deviceCode = 'gt-i9105';
        }

        if (preg_match('/gt\-i9103/i', $useragent)) {
            $deviceCode = 'gt-i9103';
        }

        if (preg_match('/gt\-i9100t/i', $useragent)) {
            $deviceCode = 'gt-i9100t';
        }

        if (preg_match('/gt\-i9100p/i', $useragent)) {
            $deviceCode = 'gt-i9100p';
        }

        if (preg_match('/gt\-i9100g/i', $useragent)) {
            $deviceCode = 'gt-i9100g';
        }

        if (preg_match('/(gt\-i9100|i9100)/i', $useragent)) {
            $deviceCode = 'gt-i9100';
        }

        if (preg_match('/gt\-i9088/i', $useragent)) {
            $deviceCode = 'gt-i9088';
        }

        if (preg_match('/gt\-i9082l/i', $useragent)) {
            $deviceCode = 'gt-i9082l';
        }

        if (preg_match('/gt\-i9082/i', $useragent)) {
            $deviceCode = 'gt-i9082';
        }

        if (preg_match('/gt\-i9070p/i', $useragent)) {
            $deviceCode = 'gt-i9070p';
        }

        if (preg_match('/gt\-i9070/i', $useragent)) {
            $deviceCode = 'gt-i9070';
        }

        if (preg_match('/gt\-i9060l/i', $useragent)) {
            $deviceCode = 'gt-i9060l';
        }

        if (preg_match('/gt\-i9060i/i', $useragent)) {
            $deviceCode = 'gt-i9060i';
        }

        if (preg_match('/gt\-i9060/i', $useragent)) {
            $deviceCode = 'gt-i9060';
        }

        if (preg_match('/gt\-i9023/i', $useragent)) {
            $deviceCode = 'gt-i9023';
        }

        if (preg_match('/gt\-i9010p/i', $useragent)) {
            $deviceCode = 'gt-i9010p';
        }

        if (preg_match('/galaxy( |\-)s4/i', $useragent)) {
            $deviceCode = 'gt-i9500';
        }

        if (preg_match('/Galaxy( |\-)S/i', $useragent)) {
            $deviceCode = 'samsung gt-i9010';
        }

        if (preg_match('/GT\-I9010/i', $useragent)) {
            $deviceCode = 'samsung gt-i9010';
        }

        if (preg_match('/GT\-I9008L/i', $useragent)) {
            $deviceCode = 'gt-i9008l';
        }

        if (preg_match('/GT\-I9008/i', $useragent)) {
            $deviceCode = 'gt-i9008';
        }

        if (preg_match('/gt\-i9003l/i', $useragent)) {
            $deviceCode = 'gt-i9003l';
        }

        if (preg_match('/gt\-i9003/i', $useragent)) {
            $deviceCode = 'gt-i9003';
        }

        if (preg_match('/gt\-i9001/i', $useragent)) {
            $deviceCode = 'gt-i9001';
        }

        if (preg_match('/(gt\-i9000|sgh\-t959v)/i', $useragent)) {
            $deviceCode = 'gt-i9000';
        }

        if (preg_match('/(gt\-i8910|i8910)/i', $useragent)) {
            $deviceCode = 'gt-i8910';
        }

        if (preg_match('/gt\-i8750/i', $useragent)) {
            $deviceCode = 'gt-i8750';
        }

        if (preg_match('/gt\-i8730/i', $useragent)) {
            $deviceCode = 'gt-i8730';
        }

        if (preg_match('/omnia7/i', $useragent)) {
            $deviceCode = 'gt-i8700';
        }

        if (preg_match('/gt\-i8552/i', $useragent)) {
            $deviceCode = 'gt-i8552';
        }

        if (preg_match('/gt\-i8530/i', $useragent)) {
            $deviceCode = 'gt-i8530';
        }

        if (preg_match('/gt\-i8350/i', $useragent)) {
            $deviceCode = 'gt-i8350';
        }

        if (preg_match('/gt\-i8320/i', $useragent)) {
            $deviceCode = 'gt-i8320';
        }

        if (preg_match('/gt\-i8262/i', $useragent)) {
            $deviceCode = 'gt-i8262';
        }

        if (preg_match('/gt\-i8260/i', $useragent)) {
            $deviceCode = 'gt-i8260';
        }

        if (preg_match('/gt\-i8200n/i', $useragent)) {
            $deviceCode = 'gt-i8200n';
        }

        if (preg_match('/GT\-I8200/i', $useragent)) {
            $deviceCode = 'gt-i8200';
        }

        if (preg_match('/GT\-I8190N/i', $useragent)) {
            $deviceCode = 'gt-i8190n';
        }

        if (preg_match('/GT\-I8190/i', $useragent)) {
            $deviceCode = 'gt-i8190';
        }

        if (preg_match('/GT\-I8160P/i', $useragent)) {
            $deviceCode = 'gt-i8160p';
        }

        if (preg_match('/GT\-I8160/i', $useragent)) {
            $deviceCode = 'gt-i8160';
        }

        if (preg_match('/GT\-I8150/i', $useragent)) {
            $deviceCode = 'gt-i8150';
        }

        if (preg_match('/GT\-i8000V/i', $useragent)) {
            $deviceCode = 'gt-i8000v';
        }

        if (preg_match('/GT\-i8000/i', $useragent)) {
            $deviceCode = 'gt-i8000';
        }

        if (preg_match('/GT\-I6410/i', $useragent)) {
            $deviceCode = 'gt-i6410';
        }

        if (preg_match('/GT\-I5801/i', $useragent)) {
            $deviceCode = 'gt-i5801';
        }

        if (preg_match('/GT\-I5800/i', $useragent)) {
            $deviceCode = 'gt-i5800';
        }

        if (preg_match('/GT\-I5700/i', $useragent)) {
            $deviceCode = 'gt-i5700';
        }

        if (preg_match('/GT\-I5510/i', $useragent)) {
            $deviceCode = 'gt-i5510';
        }

        if (preg_match('/GT\-I5508/i', $useragent)) {
            $deviceCode = 'gt-i5508';
        }

        if (preg_match('/GT\-I5503/i', $useragent)) {
            $deviceCode = 'gt-i5503';
        }

        if (preg_match('/GT\-I5500/i', $useragent)) {
            $deviceCode = 'gt-i5500';
        }

        if (preg_match('/nexus s 4g/i', $useragent)) {
            $deviceCode = 'nexus s 4g';
        }

        if (preg_match('/nexus s/i', $useragent)) {
            $deviceCode = 'nexus s';
        }

        if (preg_match('/nexus 10/i', $useragent)) {
            $deviceCode = 'nexus 10';
        }

        if (preg_match('/nexus player/i', $useragent)) {
            $deviceCode = 'nexus player';
        }

        if (preg_match('/nexus/i', $useragent)) {
            $deviceCode = 'galaxy nexus';
        }

        if (preg_match('/Galaxy/i', $useragent)) {
            $deviceCode = 'gt-i7500';
        }

        if (preg_match('/GT\-E3309T/i', $useragent)) {
            $deviceCode = 'gt-e3309t';
        }

        if (preg_match('/GT\-E2550/i', $useragent)) {
            $deviceCode = 'gt-e2550';
        }

        if (preg_match('/GT\-E2252/i', $useragent)) {
            $deviceCode = 'gt-e2252';
        }

        if (preg_match('/GT\-E2222/i', $useragent)) {
            $deviceCode = 'gt-e2222';
        }

        if (preg_match('/GT\-E2202/i', $useragent)) {
            $deviceCode = 'gt-e2202';
        }

        if (preg_match('/GT\-E1282T/i', $useragent)) {
            $deviceCode = 'gt-e1282t';
        }

        if (preg_match('/GT\-C6712/i', $useragent)) {
            $deviceCode = 'gt-c6712';
        }

        if (preg_match('/GT\-C3780/i', $useragent)) {
            $deviceCode = 'gt-c3780';
        }

        if (preg_match('/GT\-C3510/i', $useragent)) {
            $deviceCode = 'gt-c3510';
        }

        if (preg_match('/GT\-C3500/i', $useragent)) {
            $deviceCode = 'gt-c3500';
        }

        if (preg_match('/GT\-C3350/i', $useragent)) {
            $deviceCode = 'gt-c3350';
        }

        if (preg_match('/GT\-C3322/i', $useragent)) {
            $deviceCode = 'gt-c3322';
        }

        if (preg_match('/gt\-C3312r/i', $useragent)) {
            $deviceCode = 'gt-c3312r';
        }

        if (preg_match('/GT\-C3310/i', $useragent)) {
            $deviceCode = 'gt-c3310';
        }

        if (preg_match('/GT\-C3262/i', $useragent)) {
            $deviceCode = 'gt-c3262';
        }

        if (preg_match('/GT\-B7722/i', $useragent)) {
            $deviceCode = 'gt-b7722';
        }

        if (preg_match('/GT\-B7610/i', $useragent)) {
            $deviceCode = 'gt-b7610';
        }

        if (preg_match('/GT\-B7510/i', $useragent)) {
            $deviceCode = 'gt-b7510';
        }

        if (preg_match('/GT\-B7350/i', $useragent)) {
            $deviceCode = 'gt-b7350';
        }

        if (preg_match('/gt\-b5510/i', $useragent)) {
            $deviceCode = 'gt-b5510';
        }

        if (preg_match('/gt\-b3410/i', $useragent)) {
            $deviceCode = 'gt-b3410';
        }

        if (preg_match('/gt\-b2710/i', $useragent)) {
            $deviceCode = 'gt-b2710';
        }

        if (preg_match('/(gt\-b2100|b2100)/i', $useragent)) {
            $deviceCode = 'gt-b2100';
        }

        if (preg_match('/F031/i', $useragent)) {
            $deviceCode = 'f031';
        }

        if (preg_match('/Continuum\-I400/i', $useragent)) {
            $deviceCode = 'continuum i400';
        }

        if (preg_match('/CETUS/i', $useragent)) {
            $deviceCode = 'cetus';
        }

        if (preg_match('/sc\-06d/i', $useragent)) {
            $deviceCode = 'sc-06d';
        }

        if (preg_match('/sc\-02f/i', $useragent)) {
            $deviceCode = 'sc-02f';
        }

        if (preg_match('/sc\-02c/i', $useragent)) {
            $deviceCode = 'sc-02c';
        }

        if (preg_match('/sc\-02b/i', $useragent)) {
            $deviceCode = 'sc-02b';
        }

        if (preg_match('/sc\-01f/i', $useragent)) {
            $deviceCode = 'sc-01f';
        }

        if (preg_match('/S3500/i', $useragent)) {
            $deviceCode = 's3500';
        }

        if (preg_match('/R631/i', $useragent)) {
            $deviceCode = 'r631';
        }

        if (preg_match('/i7110/i', $useragent)) {
            $deviceCode = 'i7110';
        }

        if (preg_match('/yp\-gs1/i', $useragent)) {
            $deviceCode = 'yp-gs1';
        }

        if (preg_match('/yp\-gi1/i', $useragent)) {
            $deviceCode = 'yp-gi1';
        }

        if (preg_match('/yp\-gb70/i', $useragent)) {
            $deviceCode = 'yp-gb70';
        }

        if (preg_match('/yp\-g70/i', $useragent)) {
            $deviceCode = 'yp-g70';
        }

        if (preg_match('/yp\-g1/i', $useragent)) {
            $deviceCode = 'yp-g1';
        }

        if (preg_match('/sch\-r730/i', $useragent)) {
            $deviceCode = 'sch-r730';
        }

        if (preg_match('/sph\-p100/i', $useragent)) {
            $deviceCode = 'sph-p100';
        }

        if (preg_match('/sph\-m930/i', $useragent)) {
            $deviceCode = 'sph-m930';
        }

        if (preg_match('/sph\-m840/i', $useragent)) {
            $deviceCode = 'sph-m840';
        }

        if (preg_match('/sph\-m580/i', $useragent)) {
            $deviceCode = 'sph-m580';
        }

        if (preg_match('/sph\-l900/i', $useragent)) {
            $deviceCode = 'sph-l900';
        }

        if (preg_match('/sph\-l720/i', $useragent)) {
            $deviceCode = 'sph-l720';
        }

        if (preg_match('/sph\-l710/i', $useragent)) {
            $deviceCode = 'sph-l710';
        }

        if (preg_match('/sph\-ip830w/i', $useragent)) {
            $deviceCode = 'sph-ip830w';
        }

        if (preg_match('/sph\-d710bst/i', $useragent)) {
            $deviceCode = 'sph-d710bst';
        }

        if (preg_match('/sph\-d710/i', $useragent)) {
            $deviceCode = 'sph-d710';
        }

        if (preg_match('/smart\-tv/i', $useragent)) {
            $deviceCode = 'samsung smart tv';
        }

        $deviceCode = 'general samsung device';

        return DeviceFactory::get($deviceCode, $useragent);
    }
}
