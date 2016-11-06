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
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class SamsungFactory implements Factory\FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function detect($useragent)
    {
        $deviceCode = 'general samsung device';

        if (preg_match('/sm\-a9000/i', $useragent)) {
            $deviceCode = 'sm-a9000';
        } elseif (preg_match('/sm\-a800f/i', $useragent)) {
            $deviceCode = 'sm-a800f';
        } elseif (preg_match('/sm\-a800y/i', $useragent)) {
            $deviceCode = 'sm-a800y';
        } elseif (preg_match('/sm\-a800i/i', $useragent)) {
            $deviceCode = 'sm-a800i';
        } elseif (preg_match('/sm\-a8000/i', $useragent)) {
            $deviceCode = 'sm-a8000';
        } elseif (preg_match('/sm\-s820l/i', $useragent)) {
            $deviceCode = 'sm-s820l';
        } elseif (preg_match('/sm\-a710m/i', $useragent)) {
            $deviceCode = 'sm-a710m';
        } elseif (preg_match('/sm\-a710fd/i', $useragent)) {
            $deviceCode = 'sm-a710fd';
        } elseif (preg_match('/sm\-a710f/i', $useragent)) {
            $deviceCode = 'sm-a710f';
        } elseif (preg_match('/sm\-a7100/i', $useragent)) {
            $deviceCode = 'sm-a7100';
        } elseif (preg_match('/sm\-a710y/i', $useragent)) {
            $deviceCode = 'sm-a710y';
        } elseif (preg_match('/sm\-a700fd/i', $useragent)) {
            $deviceCode = 'sm-a700fd';
        } elseif (preg_match('/sm\-a700f/i', $useragent)) {
            $deviceCode = 'sm-a700f';
        } elseif (preg_match('/sm\-a700s/i', $useragent)) {
            $deviceCode = 'sm-a700s';
        } elseif (preg_match('/sm\-a700k/i', $useragent)) {
            $deviceCode = 'sm-a700k';
        } elseif (preg_match('/sm\-a700l/i', $useragent)) {
            $deviceCode = 'sm-a700l';
        } elseif (preg_match('/sm\-a700h/i', $useragent)) {
            $deviceCode = 'sm-a700h';
        } elseif (preg_match('/sm\-a700yd/i', $useragent)) {
            $deviceCode = 'sm-a700yd';
        } elseif (preg_match('/sm\-a7000/i', $useragent)) {
            $deviceCode = 'sm-a7000';
        } elseif (preg_match('/sm\-a7009/i', $useragent)) {
            $deviceCode = 'sm-a7009';
        } elseif (preg_match('/sm\-a510fd/i', $useragent)) {
            $deviceCode = 'sm-a510fd';
        } elseif (preg_match('/sm\-a510f/i', $useragent)) {
            $deviceCode = 'sm-a510f';
        } elseif (preg_match('/sm\-a510m/i', $useragent)) {
            $deviceCode = 'sm-a510m';
        } elseif (preg_match('/sm\-a510y/i', $useragent)) {
            $deviceCode = 'sm-a510y';
        } elseif (preg_match('/sm\-a5100/i', $useragent)) {
            $deviceCode = 'sm-a5100';
        } elseif (preg_match('/sm\-a510s/i', $useragent)) {
            $deviceCode = 'sm-a510s';
        } elseif (preg_match('/sm\-a500fu/i', $useragent)) {
            $deviceCode = 'sm-a500fu';
        } elseif (preg_match('/sm\-a500f/i', $useragent)) {
            $deviceCode = 'sm-a500f';
        } elseif (preg_match('/sm\-a500h/i', $useragent)) {
            $deviceCode = 'sm-a500h';
        } elseif (preg_match('/sm\-a500y/i', $useragent)) {
            $deviceCode = 'sm-a500y';
        } elseif (preg_match('/sm\-a500l/i', $useragent)) {
            $deviceCode = 'sm-a500l';
        } elseif (preg_match('/sm\-a5000/i', $useragent)) {
            $deviceCode = 'sm-a5000';
        } elseif (preg_match('/sm\-a310f/i', $useragent)) {
            $deviceCode = 'sm-a310f';
        } elseif (preg_match('/sm\-a300fu/i', $useragent)) {
            $deviceCode = 'sm-a300fu';
        } elseif (preg_match('/sm\-a300f/i', $useragent)) {
            $deviceCode = 'sm-a300f';
        } elseif (preg_match('/sm\-a300h/i', $useragent)) {
            $deviceCode = 'sm-a300h';
        } elseif (preg_match('/sm\-j710fn/i', $useragent)) {
            $deviceCode = 'sm-j710fn';
        } elseif (preg_match('/sm\-j710f/i', $useragent)) {
            $deviceCode = 'sm-j710f';
        } elseif (preg_match('/sm\-j710m/i', $useragent)) {
            $deviceCode = 'sm-j710m';
        } elseif (preg_match('/sm\-j710h/i', $useragent)) {
            $deviceCode = 'sm-j710h';
        } elseif (preg_match('/sm\-j700f/i', $useragent)) {
            $deviceCode = 'sm-j700f';
        } elseif (preg_match('/sm\-j700m/i', $useragent)) {
            $deviceCode = 'sm-j700m';
        } elseif (preg_match('/sm\-j700h/i', $useragent)) {
            $deviceCode = 'sm-j700h';
        } elseif (preg_match('/sm\-j510fn/i', $useragent)) {
            $deviceCode = 'sm-j510fn';
        } elseif (preg_match('/sm\-j510f/i', $useragent)) {
            $deviceCode = 'sm-j510f';
        } elseif (preg_match('/sm\-j500fn/i', $useragent)) {
            $deviceCode = 'sm-j500fn';
        } elseif (preg_match('/sm\-j500f/i', $useragent)) {
            $deviceCode = 'sm-j500f';
        } elseif (preg_match('/sm\-j500g/i', $useragent)) {
            $deviceCode = 'sm-j500g';
        } elseif (preg_match('/sm\-j500m/i', $useragent)) {
            $deviceCode = 'sm-j500m';
        } elseif (preg_match('/sm\-j500y/i', $useragent)) {
            $deviceCode = 'sm-j500y';
        } elseif (preg_match('/sm\-j500h/i', $useragent)) {
            $deviceCode = 'sm-j500h';
        } elseif (preg_match('/sm\-j5007/i', $useragent)) {
            $deviceCode = 'sm-j5007';
        } elseif (preg_match('/(sm\-j500|galaxy j5)/i', $useragent)) {
            $deviceCode = 'sm-j500';
        } elseif (preg_match('/sm\-j320g/i', $useragent)) {
            $deviceCode = 'sm-j320g';
        } elseif (preg_match('/sm\-j320fn/i', $useragent)) {
            $deviceCode = 'sm-j320fn';
        } elseif (preg_match('/sm\-j320f/i', $useragent)) {
            $deviceCode = 'sm-j320f';
        } elseif (preg_match('/sm\-j3109/i', $useragent)) {
            $deviceCode = 'sm-j3109';
        } elseif (preg_match('/sm\-j120fn/i', $useragent)) {
            $deviceCode = 'sm-j120fn';
        } elseif (preg_match('/sm\-j120f/i', $useragent)) {
            $deviceCode = 'sm-j120f';
        } elseif (preg_match('/sm\-j120g/i', $useragent)) {
            $deviceCode = 'sm-j120g';
        } elseif (preg_match('/sm\-j120h/i', $useragent)) {
            $deviceCode = 'sm-j120h';
        } elseif (preg_match('/sm\-j120m/i', $useragent)) {
            $deviceCode = 'sm-j120m';
        } elseif (preg_match('/sm\-j110f/i', $useragent)) {
            $deviceCode = 'sm-j110f';
        } elseif (preg_match('/sm\-j110g/i', $useragent)) {
            $deviceCode = 'sm-j110g';
        } elseif (preg_match('/sm\-j110h/i', $useragent)) {
            $deviceCode = 'sm-j110h';
        } elseif (preg_match('/sm\-j110l/i', $useragent)) {
            $deviceCode = 'sm-j110l';
        } elseif (preg_match('/sm\-j110m/i', $useragent)) {
            $deviceCode = 'sm-j110m';
        } elseif (preg_match('/sm\-j111f/i', $useragent)) {
            $deviceCode = 'sm-j111f';
        } elseif (preg_match('/sm\-j105h/i', $useragent)) {
            $deviceCode = 'sm-j105h';
        } elseif (preg_match('/sm\-j100h/i', $useragent)) {
            $deviceCode = 'sm-j100h';
        } elseif (preg_match('/sm\-j100y/i', $useragent)) {
            $deviceCode = 'sm-j100y';
        } elseif (preg_match('/sm\-j100f/i', $useragent)) {
            $deviceCode = 'sm-j100f';
        } elseif (preg_match('/sm\-j100ml/i', $useragent)) {
            $deviceCode = 'sm-j100ml';
        } elseif (preg_match('/sm\-j200gu/i', $useragent)) {
            $deviceCode = 'sm-j200gu';
        } elseif (preg_match('/sm\-j200g/i', $useragent)) {
            $deviceCode = 'sm-j200g';
        } elseif (preg_match('/sm\-j200f/i', $useragent)) {
            $deviceCode = 'sm-j200f';
        } elseif (preg_match('/sm\-j200h/i', $useragent)) {
            $deviceCode = 'sm-j200h';
        } elseif (preg_match('/sm\-j200bt/i', $useragent)) {
            $deviceCode = 'sm-j200bt';
        } elseif (preg_match('/sm\-j200y/i', $useragent)) {
            $deviceCode = 'sm-j200y';
        } elseif (preg_match('/sm\-t280/i', $useragent)) {
            $deviceCode = 'sm-t280';
        } elseif (preg_match('/sm\-t2105/i', $useragent)) {
            $deviceCode = 'sm-t2105';
        } elseif (preg_match('/sm\-t210r/i', $useragent)) {
            $deviceCode = 'sm-t210r';
        } elseif (preg_match('/sm\-t210l/i', $useragent)) {
            $deviceCode = 'sm-t210l';
        } elseif (preg_match('/sm\-t210/i', $useragent)) {
            $deviceCode = 'sm-t210';
        } elseif (preg_match('/sm\-t900/i', $useragent)) {
            $deviceCode = 'sm-t900';
        } elseif (preg_match('/sm\-t819/i', $useragent)) {
            $deviceCode = 'sm-t819';
        } elseif (preg_match('/sm\-t815y/i', $useragent)) {
            $deviceCode = 'sm-t815y';
        } elseif (preg_match('/sm\-t815/i', $useragent)) {
            $deviceCode = 'sm-t815';
        } elseif (preg_match('/sm\-t813/i', $useragent)) {
            $deviceCode = 'sm-t813';
        } elseif (preg_match('/sm\-t810x/i', $useragent)) {
            $deviceCode = 'sm-t810x';
        } elseif (preg_match('/sm\-t810/i', $useragent)) {
            $deviceCode = 'sm-t810';
        } elseif (preg_match('/sm\-t805/i', $useragent)) {
            $deviceCode = 'sm-t805';
        } elseif (preg_match('/sm\-t800/i', $useragent)) {
            $deviceCode = 'sm-t800';
        } elseif (preg_match('/sm\-t719/i', $useragent)) {
            $deviceCode = 'sm-t719';
        } elseif (preg_match('/sm\-t715/i', $useragent)) {
            $deviceCode = 'sm-t715';
        } elseif (preg_match('/sm\-t713/i', $useragent)) {
            $deviceCode = 'sm-t713';
        } elseif (preg_match('/sm\-t710/i', $useragent)) {
            $deviceCode = 'sm-t710';
        } elseif (preg_match('/sm\-t705m/i', $useragent)) {
            $deviceCode = 'sm-t705m';
        } elseif (preg_match('/sm\-t705/i', $useragent)) {
            $deviceCode = 'sm-t705';
        } elseif (preg_match('/sm\-t700/i', $useragent)) {
            $deviceCode = 'sm-t700';
        } elseif (preg_match('/sm\-t670/i', $useragent)) {
            $deviceCode = 'sm-t670';
        } elseif (preg_match('/sm\-t585/i', $useragent)) {
            $deviceCode = 'sm-t585';
        } elseif (preg_match('/sm\-t580/i', $useragent)) {
            $deviceCode = 'sm-t580';
        } elseif (preg_match('/sm\-t550x/i', $useragent)) {
            $deviceCode = 'sm-t550x';
        } elseif (preg_match('/sm\-t550/i', $useragent)) {
            $deviceCode = 'sm-t550';
        } elseif (preg_match('/sm\-t555/i', $useragent)) {
            $deviceCode = 'sm-t555';
        } elseif (preg_match('/sm\-t561/i', $useragent)) {
            $deviceCode = 'sm-t561';
        } elseif (preg_match('/sm\-t560/i', $useragent)) {
            $deviceCode = 'sm-t560';
        } elseif (preg_match('/sm\-t535/i', $useragent)) {
            $deviceCode = 'sm-t535';
        } elseif (preg_match('/sm\-t533/i', $useragent)) {
            $deviceCode = 'sm-t533';
        } elseif (preg_match('/(sm\-t531|sm \- t531)/i', $useragent)) {
            $deviceCode = 'sm-t531';
        } elseif (preg_match('/sm\-t530nu/i', $useragent)) {
            $deviceCode = 'sm-t530nu';
        } elseif (preg_match('/sm\-t530/i', $useragent)) {
            $deviceCode = 'sm-t530';
        } elseif (preg_match('/sm\-t525/i', $useragent)) {
            $deviceCode = 'sm-t525';
        } elseif (preg_match('/sm\-t520/i', $useragent)) {
            $deviceCode = 'sm-t520';
        } elseif (preg_match('/sm\-t365/i', $useragent)) {
            $deviceCode = 'sm-t365';
        } elseif (preg_match('/sm\-t355y/i', $useragent)) {
            $deviceCode = 'sm-t355y';
        } elseif (preg_match('/sm\-t350/i', $useragent)) {
            $deviceCode = 'sm-t350';
        } elseif (preg_match('/sm\-t335/i', $useragent)) {
            $deviceCode = 'sm-t335';
        } elseif (preg_match('/sm\-t331/i', $useragent)) {
            $deviceCode = 'sm-t331';
        } elseif (preg_match('/sm\-t330/i', $useragent)) {
            $deviceCode = 'sm-t330';
        } elseif (preg_match('/sm\-t325/i', $useragent)) {
            $deviceCode = 'sm-t325';
        } elseif (preg_match('/sm\-t320/i', $useragent)) {
            $deviceCode = 'sm-t320';
        } elseif (preg_match('/sm\-t315/i', $useragent)) {
            $deviceCode = 'sm-t315';
        } elseif (preg_match('/sm\-t311/i', $useragent)) {
            $deviceCode = 'sm-t311';
        } elseif (preg_match('/sm\-t310/i', $useragent)) {
            $deviceCode = 'sm-t310';
        } elseif (preg_match('/sm\-t235/i', $useragent)) {
            $deviceCode = 'sm-t235';
        } elseif (preg_match('/sm\-t231/i', $useragent)) {
            $deviceCode = 'sm-t231';
        } elseif (preg_match('/sm\-t230nu/i', $useragent)) {
            $deviceCode = 'sm-t230nu';
        } elseif (preg_match('/sm\-t230/i', $useragent)) {
            $deviceCode = 'sm-t230';
        } elseif (preg_match('/sm\-t211/i', $useragent)) {
            $deviceCode = 'sm-t211';
        } elseif (preg_match('/sm\-t116/i', $useragent)) {
            $deviceCode = 'sm-t116';
        } elseif (preg_match('/sm\-t113/i', $useragent)) {
            $deviceCode = 'sm-t113';
        } elseif (preg_match('/sm\-t111/i', $useragent)) {
            $deviceCode = 'sm-t111';
        } elseif (preg_match('/sm\-t110/i', $useragent)) {
            $deviceCode = 'sm-t110';
        } elseif (preg_match('/sm\-p907a/i', $useragent)) {
            $deviceCode = 'sm-p907a';
        } elseif (preg_match('/sm\-p905m/i', $useragent)) {
            $deviceCode = 'sm-p905m';
        } elseif (preg_match('/sm\-p905v/i', $useragent)) {
            $deviceCode = 'sm-p905v';
        } elseif (preg_match('/sm\-p905/i', $useragent)) {
            $deviceCode = 'sm-p905';
        } elseif (preg_match('/sm\-p901/i', $useragent)) {
            $deviceCode = 'sm-p901';
        } elseif (preg_match('/sm\-p900/i', $useragent)) {
            $deviceCode = 'sm-p900';
        } elseif (preg_match('/sm\-p605/i', $useragent)) {
            $deviceCode = 'sm-p605';
        } elseif (preg_match('/sm\-p601/i', $useragent)) {
            $deviceCode = 'sm-p601';
        } elseif (preg_match('/sm\-p600/i', $useragent)) {
            $deviceCode = 'sm-p600';
        } elseif (preg_match('/sm\-p550/i', $useragent)) {
            $deviceCode = 'sm-p550';
        } elseif (preg_match('/sm\-p355/i', $useragent)) {
            $deviceCode = 'sm-p355';
        } elseif (preg_match('/sm\-p350/i', $useragent)) {
            $deviceCode = 'sm-p350';
        } elseif (preg_match('/sm\-n930fd/i', $useragent)) {
            $deviceCode = 'sm-n930fd';
        } elseif (preg_match('/sm\-n930f/i', $useragent)) {
            $deviceCode = 'sm-n930f';
        } elseif (preg_match('/sm\-n930w8/i', $useragent)) {
            $deviceCode = 'sm-n930w8';
        } elseif (preg_match('/sm\-n9300/i', $useragent)) {
            $deviceCode = 'sm-n9300';
        } elseif (preg_match('/sm\-n9308/i', $useragent)) {
            $deviceCode = 'sm-n9308';
        } elseif (preg_match('/sm\-n930k/i', $useragent)) {
            $deviceCode = 'sm-n930k';
        } elseif (preg_match('/sm\-n930l/i', $useragent)) {
            $deviceCode = 'sm-n930l';
        } elseif (preg_match('/sm\-n930s/i', $useragent)) {
            $deviceCode = 'sm-n930s';
        } elseif (preg_match('/sm\-n930az/i', $useragent)) {
            $deviceCode = 'sm-n930az';
        } elseif (preg_match('/sm\-n930a/i', $useragent)) {
            $deviceCode = 'sm-n930a';
        } elseif (preg_match('/sm\-n930t1/i', $useragent)) {
            $deviceCode = 'sm-n930t1';
        } elseif (preg_match('/sm\-n930t/i', $useragent)) {
            $deviceCode = 'sm-n930t';
        } elseif (preg_match('/sm\-n930r6/i', $useragent)) {
            $deviceCode = 'sm-n930r6';
        } elseif (preg_match('/sm\-n930r7/i', $useragent)) {
            $deviceCode = 'sm-n930r7';
        } elseif (preg_match('/sm\-n930r4/i', $useragent)) {
            $deviceCode = 'sm-n930r4';
        } elseif (preg_match('/sm\-n930p/i', $useragent)) {
            $deviceCode = 'sm-n930p';
        } elseif (preg_match('/sm\-n930v/i', $useragent)) {
            $deviceCode = 'sm-n930v';
        } elseif (preg_match('/sm\-n930u/i', $useragent)) {
            $deviceCode = 'sm-n930u';
        } elseif (preg_match('/sm\-n920a/i', $useragent)) {
            $deviceCode = 'sm-n920a';
        } elseif (preg_match('/sm\-n920r/i', $useragent)) {
            $deviceCode = 'sm-n920r';
        } elseif (preg_match('/sm\-n920s/i', $useragent)) {
            $deviceCode = 'sm-n920s';
        } elseif (preg_match('/sm\-n920k/i', $useragent)) {
            $deviceCode = 'sm-n920k';
        } elseif (preg_match('/sm\-n920l/i', $useragent)) {
            $deviceCode = 'sm-n920l';
        } elseif (preg_match('/sm\-n920g/i', $useragent)) {
            $deviceCode = 'sm-n920g';
        } elseif (preg_match('/sm\-n920c/i', $useragent)) {
            $deviceCode = 'sm-n920c';
        } elseif (preg_match('/sm\-n920v/i', $useragent)) {
            $deviceCode = 'sm-n920v';
        } elseif (preg_match('/sm\-n920t/i', $useragent)) {
            $deviceCode = 'sm-n920t';
        } elseif (preg_match('/sm\-n920p/i', $useragent)) {
            $deviceCode = 'sm-n920p';
        } elseif (preg_match('/sm\-n920a/i', $useragent)) {
            $deviceCode = 'sm-n920a';
        } elseif (preg_match('/sm\-n920i/i', $useragent)) {
            $deviceCode = 'sm-n920i';
        } elseif (preg_match('/sm\-n920w8/i', $useragent)) {
            $deviceCode = 'sm-n920w8';
        } elseif (preg_match('/sm\-n9200/i', $useragent)) {
            $deviceCode = 'sm-n9200';
        } elseif (preg_match('/sm\-n9208/i', $useragent)) {
            $deviceCode = 'sm-n9208';
        } elseif (preg_match('/(sm\-n9009|n9009)/i', $useragent)) {
            $deviceCode = 'sm-n9009';
        } elseif (preg_match('/sm\-n9008v/i', $useragent)) {
            $deviceCode = 'sm-n9008v';
        } elseif (preg_match('/(sm\-n9007|N9007)/i', $useragent)) {
            $deviceCode = 'sm-n9007';
        } elseif (preg_match('/(sm\-n9006|n9006)/i', $useragent)) {
            $deviceCode = 'sm-n9006';
        } elseif (preg_match('/(sm\-n9005|n9005)/i', $useragent)) {
            $deviceCode = 'sm-n9005';
        } elseif (preg_match('/(sm\-n9002|n9002)/i', $useragent)) {
            $deviceCode = 'sm-n9002';
        } elseif (preg_match('/sm\-n8000/i', $useragent)) {
            $deviceCode = 'sm-n8000';
        } elseif (preg_match('/sm\-n7505l/i', $useragent)) {
            $deviceCode = 'sm-n7505l';
        } elseif (preg_match('/sm\-n7505/i', $useragent)) {
            $deviceCode = 'sm-n7505';
        } elseif (preg_match('/sm\-n7502/i', $useragent)) {
            $deviceCode = 'sm-n7502';
        } elseif (preg_match('/sm\-n7500q/i', $useragent)) {
            $deviceCode = 'sm-n7500q';
        } elseif (preg_match('/sm\-n750/i', $useragent)) {
            $deviceCode = 'sm-n750';
        } elseif (preg_match('/sm\-n916s/i', $useragent)) {
            $deviceCode = 'sm-n916s';
        } elseif (preg_match('/sm\-n915fy/i', $useragent)) {
            $deviceCode = 'sm-n915fy';
        } elseif (preg_match('/sm\-n915f/i', $useragent)) {
            $deviceCode = 'sm-n915f';
        } elseif (preg_match('/sm\-n915t/i', $useragent)) {
            $deviceCode = 'sm-n915t';
        } elseif (preg_match('/sm\-n915g/i', $useragent)) {
            $deviceCode = 'sm-n915g';
        } elseif (preg_match('/sm\-n915p/i', $useragent)) {
            $deviceCode = 'sm-n915p';
        } elseif (preg_match('/sm\-n915a/i', $useragent)) {
            $deviceCode = 'sm-n915a';
        } elseif (preg_match('/sm\-n915v/i', $useragent)) {
            $deviceCode = 'sm-n915v';
        } elseif (preg_match('/sm\-n915d/i', $useragent)) {
            $deviceCode = 'sm-n915d';
        } elseif (preg_match('/sm\-n915k/i', $useragent)) {
            $deviceCode = 'sm-n915k';
        } elseif (preg_match('/sm\-n915l/i', $useragent)) {
            $deviceCode = 'sm-n915l';
        } elseif (preg_match('/sm\-n915s/i', $useragent)) {
            $deviceCode = 'sm-n915s';
        } elseif (preg_match('/sm\-n9150/i', $useragent)) {
            $deviceCode = 'sm-n9150';
        } elseif (preg_match('/sm\-n910v/i', $useragent)) {
            $deviceCode = 'sm-n910v';
        } elseif (preg_match('/sm\-n910fq/i', $useragent)) {
            $deviceCode = 'sm-n910fq';
        } elseif (preg_match('/sm\-n910fd/i', $useragent)) {
            $deviceCode = 'sm-n910fd';
        } elseif (preg_match('/sm\-n910f/i', $useragent)) {
            $deviceCode = 'sm-n910f';
        } elseif (preg_match('/sm\-n910c/i', $useragent)) {
            $deviceCode = 'sm-n910c';
        } elseif (preg_match('/sm\-n910a/i', $useragent)) {
            $deviceCode = 'sm-n910a';
        } elseif (preg_match('/sm\-n910h/i', $useragent)) {
            $deviceCode = 'sm-n910h';
        } elseif (preg_match('/sm\-n910k/i', $useragent)) {
            $deviceCode = 'sm-n910k';
        } elseif (preg_match('/sm\-n910p/i', $useragent)) {
            $deviceCode = 'sm-n910p';
        } elseif (preg_match('/sm\-n910x/i', $useragent)) {
            $deviceCode = 'sm-n910x';
        } elseif (preg_match('/sm\-n910s/i', $useragent)) {
            $deviceCode = 'sm-n910s';
        } elseif (preg_match('/sm\-n910l/i', $useragent)) {
            $deviceCode = 'sm-n910l';
        } elseif (preg_match('/sm\-n910g/i', $useragent)) {
            $deviceCode = 'sm-n910g';
        } elseif (preg_match('/sm\-n910m/i', $useragent)) {
            $deviceCode = 'sm-n910m';
        } elseif (preg_match('/sm\-n910t1/i', $useragent)) {
            $deviceCode = 'sm-n910t1';
        } elseif (preg_match('/sm\-n910t3/i', $useragent)) {
            $deviceCode = 'sm-n910t3';
        } elseif (preg_match('/sm\-n910t/i', $useragent)) {
            $deviceCode = 'sm-n910t';
        } elseif (preg_match('/sm\-n910u/i', $useragent)) {
            $deviceCode = 'sm-n910u';
        } elseif (preg_match('/sm\-n910r4/i', $useragent)) {
            $deviceCode = 'sm-n910r4';
        } elseif (preg_match('/sm\-n910w8/i', $useragent)) {
            $deviceCode = 'sm-n910w8';
        } elseif (preg_match('/sm\-n9100h/i', $useragent)) {
            $deviceCode = 'sm-n9100h';
        } elseif (preg_match('/sm\-n9100/i', $useragent)) {
            $deviceCode = 'sm-n9100';
        } elseif (preg_match('/sm\-n900v/i', $useragent)) {
            $deviceCode = 'sm-n900v';
        } elseif (preg_match('/sm\-n900a/i', $useragent)) {
            $deviceCode = 'sm-n900a';
        } elseif (preg_match('/sm\-n900s/i', $useragent)) {
            $deviceCode = 'sm-n900s';
        } elseif (preg_match('/sm\-n900t/i', $useragent)) {
            $deviceCode = 'sm-n900t';
        } elseif (preg_match('/sm\-n900p/i', $useragent)) {
            $deviceCode = 'sm-n900p';
        } elseif (preg_match('/sm\-n900l/i', $useragent)) {
            $deviceCode = 'sm-n900l';
        } elseif (preg_match('/sm\-n900k/i', $useragent)) {
            $deviceCode = 'sm-n900k';
        } elseif (preg_match('/sm\-n9000q/i', $useragent)) {
            $deviceCode = 'sm-n9000q';
        } elseif (preg_match('/sm\-n900w8/i', $useragent)) {
            $deviceCode = 'sm-n900w8';
        } elseif (preg_match('/sm\-n900/i', $useragent)) {
            $deviceCode = 'sm-n900';
        } elseif (preg_match('/sm\-g935fd/i', $useragent)) {
            $deviceCode = 'sm-g935fd';
        } elseif (preg_match('/sm\-g935f/i', $useragent)) {
            $deviceCode = 'sm-g935f';
        } elseif (preg_match('/sm\-g935a/i', $useragent)) {
            $deviceCode = 'sm-g935a';
        } elseif (preg_match('/sm\-g935p/i', $useragent)) {
            $deviceCode = 'sm-g935p';
        } elseif (preg_match('/sm\-g935r/i', $useragent)) {
            $deviceCode = 'sm-g935r';
        } elseif (preg_match('/sm\-g935t/i', $useragent)) {
            $deviceCode = 'sm-g935t';
        } elseif (preg_match('/sm\-g935v/i', $useragent)) {
            $deviceCode = 'sm-g935v';
        } elseif (preg_match('/sm\-g935w8/i', $useragent)) {
            $deviceCode = 'sm-g935w8';
        } elseif (preg_match('/sm\-g935k/i', $useragent)) {
            $deviceCode = 'sm-g935k';
        } elseif (preg_match('/sm\-g935l/i', $useragent)) {
            $deviceCode = 'sm-g935l';
        } elseif (preg_match('/sm\-g935s/i', $useragent)) {
            $deviceCode = 'sm-g935s';
        } elseif (preg_match('/sm\-g935x/i', $useragent)) {
            $deviceCode = 'sm-g935x';
        } elseif (preg_match('/sm\-g9350/i', $useragent)) {
            $deviceCode = 'sm-g9350';
        } elseif (preg_match('/sm\-g930fd/i', $useragent)) {
            $deviceCode = 'sm-g930fd';
        } elseif (preg_match('/sm\-g930f/i', $useragent)) {
            $deviceCode = 'sm-g930f';
        } elseif (preg_match('/sm\-g9308/i', $useragent)) {
            $deviceCode = 'sm-g9308';
        } elseif (preg_match('/sm\-g930a/i', $useragent)) {
            $deviceCode = 'sm-g930a';
        } elseif (preg_match('/sm\-g930p/i', $useragent)) {
            $deviceCode = 'sm-g930p';
        } elseif (preg_match('/sm\-g930v/i', $useragent)) {
            $deviceCode = 'sm-g930v';
        } elseif (preg_match('/sm\-g930r/i', $useragent)) {
            $deviceCode = 'sm-g930r';
        } elseif (preg_match('/sm\-g930t/i', $useragent)) {
            $deviceCode = 'sm-g930t';
        } elseif (preg_match('/sm\-g930/i', $useragent)) {
            $deviceCode = 'sm-g930';
        } elseif (preg_match('/sm\-g9006v/i', $useragent)) {
            $deviceCode = 'sm-g9006v';
        } elseif (preg_match('/sm\-g928f/i', $useragent)) {
            $deviceCode = 'sm-g928f';
        } elseif (preg_match('/sm\-g928v/i', $useragent)) {
            $deviceCode = 'sm-g928v';
        } elseif (preg_match('/sm\-g928w8/i', $useragent)) {
            $deviceCode = 'sm-g928w8';
        } elseif (preg_match('/sm\-g928c/i', $useragent)) {
            $deviceCode = 'sm-g928c';
        } elseif (preg_match('/sm\-g928g/i', $useragent)) {
            $deviceCode = 'sm-g928g';
        } elseif (preg_match('/sm\-g928p/i', $useragent)) {
            $deviceCode = 'sm-g928p';
        } elseif (preg_match('/sm\-g928i/i', $useragent)) {
            $deviceCode = 'sm-g928i';
        } elseif (preg_match('/sm\-g9287/i', $useragent)) {
            $deviceCode = 'sm-g9287';
        } elseif (preg_match('/sm\-g925f/i', $useragent)) {
            $deviceCode = 'sm-g925f';
        } elseif (preg_match('/sm\-g925t/i', $useragent)) {
            $deviceCode = 'sm-g925t';
        } elseif (preg_match('/sm\-g925r4/i', $useragent)) {
            $deviceCode = 'sm-g925r4';
        } elseif (preg_match('/sm\-g925i/i', $useragent)) {
            $deviceCode = 'sm-g925i';
        } elseif (preg_match('/sm\-g925p/i', $useragent)) {
            $deviceCode = 'sm-g925p';
        } elseif (preg_match('/sm\-g925k/i', $useragent)) {
            $deviceCode = 'sm-g925k';
        } elseif (preg_match('/sm\-g920k/i', $useragent)) {
            $deviceCode = 'sm-g920k';
        } elseif (preg_match('/sm\-g920l/i', $useragent)) {
            $deviceCode = 'sm-g920l';
        } elseif (preg_match('/sm\-g920p/i', $useragent)) {
            $deviceCode = 'sm-g920p';
        } elseif (preg_match('/sm\-g920v/i', $useragent)) {
            $deviceCode = 'sm-g920v';
        } elseif (preg_match('/sm\-g920t1/i', $useragent)) {
            $deviceCode = 'sm-g920t1';
        } elseif (preg_match('/sm\-g920t/i', $useragent)) {
            $deviceCode = 'sm-g920t';
        } elseif (preg_match('/sm\-g920a/i', $useragent)) {
            $deviceCode = 'sm-g920a';
        } elseif (preg_match('/sm\-g920fd/i', $useragent)) {
            $deviceCode = 'sm-g920fd';
        } elseif (preg_match('/sm\-g920f/i', $useragent)) {
            $deviceCode = 'sm-g920f';
        } elseif (preg_match('/sm\-g920i/i', $useragent)) {
            $deviceCode = 'sm-g920i';
        } elseif (preg_match('/sm\-g920s/i', $useragent)) {
            $deviceCode = 'sm-g920s';
        } elseif (preg_match('/sm\-g9200/i', $useragent)) {
            $deviceCode = 'sm-g9200';
        } elseif (preg_match('/sm\-g9208/i', $useragent)) {
            $deviceCode = 'sm-g9208';
        } elseif (preg_match('/sm\-g9209/i', $useragent)) {
            $deviceCode = 'sm-g9209';
        } elseif (preg_match('/sm\-g920r/i', $useragent)) {
            $deviceCode = 'sm-g920r';
        } elseif (preg_match('/sm\-g920w8/i', $useragent)) {
            $deviceCode = 'sm-g920w8';
        } elseif (preg_match('/sm\-g903f/i', $useragent)) {
            $deviceCode = 'sm-g903f';
        } elseif (preg_match('/sm\-g901f/i', $useragent)) {
            $deviceCode = 'sm-g901f';
        } elseif (preg_match('/sm\-g900w8/i', $useragent)) {
            $deviceCode = 'sm-g900w8';
        } elseif (preg_match('/sm\-g900v/i', $useragent)) {
            $deviceCode = 'sm-g900v';
        } elseif (preg_match('/sm\-g900t/i', $useragent)) {
            $deviceCode = 'sm-g900t';
        } elseif (preg_match('/sm\-g900i/i', $useragent)) {
            $deviceCode = 'sm-g900i';
        } elseif (preg_match('/sm\-g900f/i', $useragent)) {
            $deviceCode = 'sm-g900f';
        } elseif (preg_match('/sm\-g900a/i', $useragent)) {
            $deviceCode = 'sm-g900a';
        } elseif (preg_match('/sm\-g900h/i', $useragent)) {
            $deviceCode = 'sm-g900h';
        } elseif (preg_match('/sm\-g900/i', $useragent)) {
            $deviceCode = 'sm-g900';
        } elseif (preg_match('/sm\-g890a/i', $useragent)) {
            $deviceCode = 'sm-g890a';
        } elseif (preg_match('/sm\-g870f/i', $useragent)) {
            $deviceCode = 'sm-g870f';
        } elseif (preg_match('/sm\-g870a/i', $useragent)) {
            $deviceCode = 'sm-g870a';
        } elseif (preg_match('/sm\-g850fq/i', $useragent)) {
            $deviceCode = 'sm-g850fq';
        } elseif (preg_match('/(sm\-g850f|galaxy alpha)/i', $useragent)) {
            $deviceCode = 'sm-g850f';
        } elseif (preg_match('/sm\-g850a/i', $useragent)) {
            $deviceCode = 'sm-g850a';
        } elseif (preg_match('/sm\-g850m/i', $useragent)) {
            $deviceCode = 'sm-g850m';
        } elseif (preg_match('/sm\-g850t/i', $useragent)) {
            $deviceCode = 'sm-g850t';
        } elseif (preg_match('/sm\-g850w/i', $useragent)) {
            $deviceCode = 'sm-g850w';
        } elseif (preg_match('/sm\-g850y/i', $useragent)) {
            $deviceCode = 'sm-g850y';
        } elseif (preg_match('/sm\-g800hq/i', $useragent)) {
            $deviceCode = 'sm-g800hq';
        } elseif (preg_match('/sm\-g800h/i', $useragent)) {
            $deviceCode = 'sm-g800h';
        } elseif (preg_match('/sm\-g800f/i', $useragent)) {
            $deviceCode = 'sm-g800f';
        } elseif (preg_match('/sm\-g800m/i', $useragent)) {
            $deviceCode = 'sm-g800m';
        } elseif (preg_match('/sm\-g800a/i', $useragent)) {
            $deviceCode = 'sm-g800a';
        } elseif (preg_match('/sm\-g800r4/i', $useragent)) {
            $deviceCode = 'sm-g800r4';
        } elseif (preg_match('/sm\-g800y/i', $useragent)) {
            $deviceCode = 'sm-g800y';
        } elseif (preg_match('/sm\-g720n0/i', $useragent)) {
            $deviceCode = 'sm-g720n0';
        } elseif (preg_match('/sm\-g720d/i', $useragent)) {
            $deviceCode = 'sm-g720d';
        } elseif (preg_match('/sm\-g7202/i', $useragent)) {
            $deviceCode = 'sm-g7202';
        } elseif (preg_match('/sm\-g7102t/i', $useragent)) {
            $deviceCode = 'sm-g7102t';
        } elseif (preg_match('/sm\-g7102/i', $useragent)) {
            $deviceCode = 'sm-g7102';
        } elseif (preg_match('/sm\-g7105l/i', $useragent)) {
            $deviceCode = 'sm-g7105l';
        } elseif (preg_match('/sm\-g7105/i', $useragent)) {
            $deviceCode = 'sm-g7105';
        } elseif (preg_match('/sm\-g7106/i', $useragent)) {
            $deviceCode = 'sm-g7106';
        } elseif (preg_match('/sm\-g7108v/i', $useragent)) {
            $deviceCode = 'sm-g7108v';
        } elseif (preg_match('/sm\-g7108/i', $useragent)) {
            $deviceCode = 'sm-g7108';
        } elseif (preg_match('/sm\-g7109/i', $useragent)) {
            $deviceCode = 'sm-g7109';
        } elseif (preg_match('/sm\-g710l/i', $useragent)) {
            $deviceCode = 'sm-g710l';
        } elseif (preg_match('/sm\-g710/i', $useragent)) {
            $deviceCode = 'sm-g710';
        } elseif (preg_match('/sm\-g531f/i', $useragent)) {
            $deviceCode = 'sm-g531f';
        } elseif (preg_match('/sm\-g531h/i', $useragent)) {
            $deviceCode = 'sm-g531h';
        } elseif (preg_match('/sm\-g530t/i', $useragent)) {
            $deviceCode = 'sm-g530t';
        } elseif (preg_match('/sm\-g530h/i', $useragent)) {
            $deviceCode = 'sm-g530h';
        } elseif (preg_match('/sm\-g530fz/i', $useragent)) {
            $deviceCode = 'sm-g530fz';
        } elseif (preg_match('/sm\-g530f/i', $useragent)) {
            $deviceCode = 'sm-g530f';
        } elseif (preg_match('/sm\-g530y/i', $useragent)) {
            $deviceCode = 'sm-g530y';
        } elseif (preg_match('/sm\-g530m/i', $useragent)) {
            $deviceCode = 'sm-g530m';
        } elseif (preg_match('/sm\-g530bt/i', $useragent)) {
            $deviceCode = 'sm-g530bt';
        } elseif (preg_match('/sm\-g5306w/i', $useragent)) {
            $deviceCode = 'sm-g5306w';
        } elseif (preg_match('/sm\-g5308w/i', $useragent)) {
            $deviceCode = 'sm-g5308w';
        } elseif (preg_match('/sm\-g389f/i', $useragent)) {
            $deviceCode = 'sm-g389f';
        } elseif (preg_match('/sm\-g3815/i', $useragent)) {
            $deviceCode = 'sm-g3815';
        } elseif (preg_match('/sm\-g388f/i', $useragent)) {
            $deviceCode = 'sm-g388f';
        } elseif (preg_match('/sm\-g386f/i', $useragent)) {
            $deviceCode = 'sm-g386f';
        } elseif (preg_match('/sm\-g361f/i', $useragent)) {
            $deviceCode = 'sm-g361f';
        } elseif (preg_match('/sm\-g361h/i', $useragent)) {
            $deviceCode = 'sm-g361h';
        } elseif (preg_match('/sm\-g360hu/i', $useragent)) {
            $deviceCode = 'sm-g360hu';
        } elseif (preg_match('/sm\-g360h/i', $useragent)) {
            $deviceCode = 'sm-g360h';
        } elseif (preg_match('/sm\-g360t1/i', $useragent)) {
            $deviceCode = 'sm-g360t1';
        } elseif (preg_match('/sm\-g360t/i', $useragent)) {
            $deviceCode = 'sm-g360t';
        } elseif (preg_match('/sm\-g360bt/i', $useragent)) {
            $deviceCode = 'sm-g360bt';
        } elseif (preg_match('/sm\-g360f/i', $useragent)) {
            $deviceCode = 'sm-g360f';
        } elseif (preg_match('/sm\-g360g/i', $useragent)) {
            $deviceCode = 'sm-g360g';
        } elseif (preg_match('/sm\-g360az/i', $useragent)) {
            $deviceCode = 'sm-g360az';
        } elseif (preg_match('/sm\-g357fz/i', $useragent)) {
            $deviceCode = 'sm-g357fz';
        } elseif (preg_match('/sm\-g355hq/i', $useragent)) {
            $deviceCode = 'sm-g355hq';
        } elseif (preg_match('/sm\-g355hn/i', $useragent)) {
            $deviceCode = 'sm-g355hn';
        } elseif (preg_match('/sm\-g355h/i', $useragent)) {
            $deviceCode = 'sm-g355h';
        } elseif (preg_match('/sm\-g355m/i', $useragent)) {
            $deviceCode = 'sm-g355m';
        } elseif (preg_match('/sm\-g3502l/i', $useragent)) {
            $deviceCode = 'sm-g3502l';
        } elseif (preg_match('/sm\-g3502t/i', $useragent)) {
            $deviceCode = 'sm-g3502t';
        } elseif (preg_match('/sm\-g3500/i', $useragent)) {
            $deviceCode = 'sm-g3500';
        } elseif (preg_match('/sm\-g350e/i', $useragent)) {
            $deviceCode = 'sm-g350e';
        } elseif (preg_match('/sm\-g350/i', $useragent)) {
            $deviceCode = 'sm-g350';
        } elseif (preg_match('/sm\-g318h/i', $useragent)) {
            $deviceCode = 'sm-g318h';
        } elseif (preg_match('/sm\-g313hu/i', $useragent)) {
            $deviceCode = 'sm-g313hu';
        } elseif (preg_match('/sm\-g313hn/i', $useragent)) {
            $deviceCode = 'sm-g313hn';
        } elseif (preg_match('/sm\-g310hn/i', $useragent)) {
            $deviceCode = 'sm-g310hn';
        } elseif (preg_match('/sm\-g130h/i', $useragent)) {
            $deviceCode = 'sm-g130h';
        } elseif (preg_match('/sm\-g110h/i', $useragent)) {
            $deviceCode = 'sm-g110h';
        } elseif (preg_match('/sm\-e700f/i', $useragent)) {
            $deviceCode = 'sm-e700f';
        } elseif (preg_match('/sm\-e700h/i', $useragent)) {
            $deviceCode = 'sm-e700h';
        } elseif (preg_match('/sm\-e700m/i', $useragent)) {
            $deviceCode = 'sm-e700m';
        } elseif (preg_match('/sm\-e7000/i', $useragent)) {
            $deviceCode = 'sm-e7000';
        } elseif (preg_match('/sm\-e7009/i', $useragent)) {
            $deviceCode = 'sm-e7009';
        } elseif (preg_match('/sm\-e500h/i', $useragent)) {
            $deviceCode = 'sm-e500h';
        } elseif (preg_match('/sm\-c115/i', $useragent)) {
            $deviceCode = 'sm-c115';
        } elseif (preg_match('/sm\-c111/i', $useragent)) {
            $deviceCode = 'sm-c111';
        } elseif (preg_match('/sm\-c105/i', $useragent)) {
            $deviceCode = 'sm-c105';
        } elseif (preg_match('/sm\-c101/i', $useragent)) {
            $deviceCode = 'sm-c101';
        } elseif (preg_match('/sm\-z130h/i', $useragent)) {
            $deviceCode = 'sm-z130h';
        } elseif (preg_match('/sm\-b550h/i', $useragent)) {
            $deviceCode = 'sm-b550h';
        } elseif (preg_match('/sgh\-t999/i', $useragent)) {
            $deviceCode = 'sgh-t999';
        } elseif (preg_match('/sgh\-t989d/i', $useragent)) {
            $deviceCode = 'sgh-t989d';
        } elseif (preg_match('/sgh\-t989/i', $useragent)) {
            $deviceCode = 'sgh-t989';
        } elseif (preg_match('/sgh\-t959v/i', $useragent)) {
            $deviceCode = 'sgh-t959v';
        } elseif (preg_match('/sgh\-t959/i', $useragent)) {
            $deviceCode = 'sgh-t959';
        } elseif (preg_match('/sgh\-t899m/i', $useragent)) {
            $deviceCode = 'sgh-t899m';
        } elseif (preg_match('/sgh\-t889/i', $useragent)) {
            $deviceCode = 'sgh-t889';
        } elseif (preg_match('/sgh\-t859/i', $useragent)) {
            $deviceCode = 'sgh-t859';
        } elseif (preg_match('/sgh\-t839/i', $useragent)) {
            $deviceCode = 'sgh-t839';
        } elseif (preg_match('/(sgh\-t769|blaze)/i', $useragent)) {
            $deviceCode = 'sgh-t769';
        } elseif (preg_match('/sgh\-t759/i', $useragent)) {
            $deviceCode = 'sgh-t759';
        } elseif (preg_match('/sgh\-t669/i', $useragent)) {
            $deviceCode = 'sgh-t669';
        } elseif (preg_match('/sgh\-t528g/i', $useragent)) {
            $deviceCode = 'sgh-t528g';
        } elseif (preg_match('/sgh\-t499/i', $useragent)) {
            $deviceCode = 'sgh-t499';
        } elseif (preg_match('/sgh\-m919/i', $useragent)) {
            $deviceCode = 'sgh-m919';
        } elseif (preg_match('/sgh\-i997r/i', $useragent)) {
            $deviceCode = 'sgh-i997r';
        } elseif (preg_match('/sgh\-i997/i', $useragent)) {
            $deviceCode = 'sgh-i997';
        } elseif (preg_match('/SGH\-I957R/i', $useragent)) {
            $deviceCode = 'sgh-i957r';
        } elseif (preg_match('/SGH\-i957/i', $useragent)) {
            $deviceCode = 'sgh-i957';
        } elseif (preg_match('/sgh\-i917/i', $useragent)) {
            $deviceCode = 'sgh-i917';
        } elseif (preg_match('/sgh-i900v/i', $useragent)) {
            $deviceCode = 'sgh-i900v';
        } elseif (preg_match('/sgh\-i900/i', $useragent)) {
            $deviceCode = 'sgh-i900';
        } elseif (preg_match('/sgh\-i897/i', $useragent)) {
            $deviceCode = 'sgh-i897';
        } elseif (preg_match('/sgh\-i857/i', $useragent)) {
            $deviceCode = 'sgh-i857';
        } elseif (preg_match('/sgh\-i780/i', $useragent)) {
            $deviceCode = 'sgh-i780';
        } elseif (preg_match('/sgh\-i777/i', $useragent)) {
            $deviceCode = 'sgh-i777';
        } elseif (preg_match('/sgh\-i747m/i', $useragent)) {
            $deviceCode = 'sgh-i747m';
        } elseif (preg_match('/sgh\-i747/i', $useragent)) {
            $deviceCode = 'sgh-i747';
        } elseif (preg_match('/sgh\-i727r/i', $useragent)) {
            $deviceCode = 'sgh-i727r';
        } elseif (preg_match('/sgh\-i727/i', $useragent)) {
            $deviceCode = 'sgh-i727';
        } elseif (preg_match('/sgh\-i717/i', $useragent)) {
            $deviceCode = 'sgh-i717';
        } elseif (preg_match('/sgh\-i577/i', $useragent)) {
            $deviceCode = 'sgh-i577';
        } elseif (preg_match('/sgh\-i547/i', $useragent)) {
            $deviceCode = 'sgh-i547';
        } elseif (preg_match('/sgh\-i497/i', $useragent)) {
            $deviceCode = 'sgh-i497';
        } elseif (preg_match('/sgh\-i467/i', $useragent)) {
            $deviceCode = 'sgh-i467';
        } elseif (preg_match('/sgh\-i337m/i', $useragent)) {
            $deviceCode = 'sgh-i337m';
        } elseif (preg_match('/sgh\-i337/i', $useragent)) {
            $deviceCode = 'sgh-i337';
        } elseif (preg_match('/sgh\-i317/i', $useragent)) {
            $deviceCode = 'sgh-i317';
        } elseif (preg_match('/sgh\-i257/i', $useragent)) {
            $deviceCode = 'sgh-i257';
        } elseif (preg_match('/sgh\-f480i/i', $useragent)) {
            $deviceCode = 'sgh-f480i';
        } elseif (preg_match('/sgh\-f480/i', $useragent)) {
            $deviceCode = 'sgh-f480';
        } elseif (preg_match('/sgh\-e250i/i', $useragent)) {
            $deviceCode = 'sgh-e250i';
        } elseif (preg_match('/sgh\-e250/i', $useragent)) {
            $deviceCode = 'sgh-e250';
        } elseif (preg_match('/(sgh\-b100|sec\-sghb100)/i', $useragent)) {
            $deviceCode = 'sgh-b100';
        } elseif (preg_match('/sec\-sghu600b/i', $useragent)) {
            $deviceCode = 'sgh-u600b';
        } elseif (preg_match('/sgh\-u800/i', $useragent)) {
            $deviceCode = 'sgh-u800';
        } elseif (preg_match('/shv\-e370k/i', $useragent)) {
            $deviceCode = 'shv-e370k';
        } elseif (preg_match('/shv\-e250k/i', $useragent)) {
            $deviceCode = 'shv-e250k';
        } elseif (preg_match('/shv\-e250l/i', $useragent)) {
            $deviceCode = 'shv-e250l';
        } elseif (preg_match('/shv\-e250s/i', $useragent)) {
            $deviceCode = 'shv-e250s';
        } elseif (preg_match('/shv\-e210l/i', $useragent)) {
            $deviceCode = 'shv-e210l';
        } elseif (preg_match('/shv\-e210k/i', $useragent)) {
            $deviceCode = 'shv-e210k';
        } elseif (preg_match('/shv\-e210s/i', $useragent)) {
            $deviceCode = 'shv-e210s';
        } elseif (preg_match('/shv\-e160s/i', $useragent)) {
            $deviceCode = 'shv-e160s';
        } elseif (preg_match('/shw\-m110s/i', $useragent)) {
            $deviceCode = 'shw-m110s';
        } elseif (preg_match('/shw\-m180s/i', $useragent)) {
            $deviceCode = 'shw-m180s';
        } elseif (preg_match('/shw\-m380s/i', $useragent)) {
            $deviceCode = 'shw-m380s';
        } elseif (preg_match('/shw\-m380w/i', $useragent)) {
            $deviceCode = 'shw-m380w';
        } elseif (preg_match('/shw\-m930bst/i', $useragent)) {
            $deviceCode = 'shw-m930bst';
        } elseif (preg_match('/shw\-m480w/i', $useragent)) {
            $deviceCode = 'shw-m480w';
        } elseif (preg_match('/shw\-m380k/i', $useragent)) {
            $deviceCode = 'shw-m380k';
        } elseif (preg_match('/scl24/i', $useragent)) {
            $deviceCode = 'scl24';
        } elseif (preg_match('/sch\-u820/i', $useragent)) {
            $deviceCode = 'sch-u820';
        } elseif (preg_match('/sch\-u750/i', $useragent)) {
            $deviceCode = 'sch-u750';
        } elseif (preg_match('/sch\-u660/i', $useragent)) {
            $deviceCode = 'sch-u660';
        } elseif (preg_match('/sch\-u485/i', $useragent)) {
            $deviceCode = 'sch-u485';
        } elseif (preg_match('/sch\-r970/i', $useragent)) {
            $deviceCode = 'sch-r970';
        } elseif (preg_match('/sch\-r950/i', $useragent)) {
            $deviceCode = 'sch-r950';
        } elseif (preg_match('/sch\-r720/i', $useragent)) {
            $deviceCode = 'sch-r720';
        } elseif (preg_match('/sch\-r530u/i', $useragent)) {
            $deviceCode = 'sch-r530u';
        } elseif (preg_match('/sch\-r530c/i', $useragent)) {
            $deviceCode = 'sch-r530c';
        } elseif (preg_match('/sch\-n719/i', $useragent)) {
            $deviceCode = 'sch-n719';
        } elseif (preg_match('/sch\-m828c/i', $useragent)) {
            $deviceCode = 'sch-m828c';
        } elseif (preg_match('/sch\-i535/i', $useragent)) {
            $deviceCode = 'sch-i535';
        } elseif (preg_match('/sch\-i919/i', $useragent)) {
            $deviceCode = 'sch-i919';
        } elseif (preg_match('/sch\-i815/i', $useragent)) {
            $deviceCode = 'sch-i815';
        } elseif (preg_match('/sch\-i800/i', $useragent)) {
            $deviceCode = 'sch-i800';
        } elseif (preg_match('/sch\-i699/i', $useragent)) {
            $deviceCode = 'sch-i699';
        } elseif (preg_match('/sch\-i605/i', $useragent)) {
            $deviceCode = 'sch-i605';
        } elseif (preg_match('/sch\-i545/i', $useragent)) {
            $deviceCode = 'sch-i545';
        } elseif (preg_match('/sch\-i510/i', $useragent)) {
            $deviceCode = 'sch-i510';
        } elseif (preg_match('/sch\-i500/i', $useragent)) {
            $deviceCode = 'sch-i500';
        } elseif (preg_match('/sch\-i435/i', $useragent)) {
            $deviceCode = 'sch-i435';
        } elseif (preg_match('/sch\-i400/i', $useragent)) {
            $deviceCode = 'sch-i400';
        } elseif (preg_match('/sch\-i200/i', $useragent)) {
            $deviceCode = 'sch-i200';
        } elseif (preg_match('/SCH\-S720C/i', $useragent)) {
            $deviceCode = 'sch-s720c';
        } elseif (preg_match('/GT\-S8600/i', $useragent)) {
            $deviceCode = 'gt-s8600';
        } elseif (preg_match('/GT\-S8530/i', $useragent)) {
            $deviceCode = 'gt-s8530';
        } elseif (preg_match('/GT\-S8500/i', $useragent)) {
            $deviceCode = 'gt-s8500';
        } elseif (preg_match('/(samsung|gt)\-s8300/i', $useragent)) {
            $deviceCode = 'gt-s8300';
        } elseif (preg_match('/(samsung|gt)\-s8003/i', $useragent)) {
            $deviceCode = 'gt-s8003';
        } elseif (preg_match('/(samsung|gt)\-s8000/i', $useragent)) {
            $deviceCode = 'gt-s8000';
        } elseif (preg_match('/(samsung|gt)\-s7710/i', $useragent)) {
            $deviceCode = 'gt-s7710';
        } elseif (preg_match('/gt\-s7582/i', $useragent)) {
            $deviceCode = 'gt-s7582';
        } elseif (preg_match('/gt\-s7580/i', $useragent)) {
            $deviceCode = 'gt-s7580';
        } elseif (preg_match('/gt\-s7562l/i', $useragent)) {
            $deviceCode = 'gt-s7562l';
        } elseif (preg_match('/gt\-s7562/i', $useragent)) {
            $deviceCode = 'gt-s7562';
        } elseif (preg_match('/gt\-s7560/i', $useragent)) {
            $deviceCode = 'gt-s7560';
        } elseif (preg_match('/gt\-s7530/i', $useragent)) {
            $deviceCode = 'gt-s7530';
        } elseif (preg_match('/gt\-s7500/i', $useragent)) {
            $deviceCode = 'gt-s7500';
        } elseif (preg_match('/gt\-s7392/i', $useragent)) {
            $deviceCode = 'gt-s7392';
        } elseif (preg_match('/gt\-s7390/i', $useragent)) {
            $deviceCode = 'gt-s7390';
        } elseif (preg_match('/gt\-s7330/i', $useragent)) {
            $deviceCode = 'gt-s7330';
        } elseif (preg_match('/gt\-s7275r/i', $useragent)) {
            $deviceCode = 'gt-s7275r';
        } elseif (preg_match('/gt\-s7275/i', $useragent)) {
            $deviceCode = 'gt-s7275';
        } elseif (preg_match('/gt\-s7272/i', $useragent)) {
            $deviceCode = 'gt-s7272';
        } elseif (preg_match('/gt\-s7270/i', $useragent)) {
            $deviceCode = 'gt-s7270';
        } elseif (preg_match('/gt\-s7262/i', $useragent)) {
            $deviceCode = 'gt-s7262';
        } elseif (preg_match('/gt\-s7250/i', $useragent)) {
            $deviceCode = 'gt-s7250';
        } elseif (preg_match('/gt\-s7233e/i', $useragent)) {
            $deviceCode = 'gt-s7233e';
        } elseif (preg_match('/gt\-s7230e/i', $useragent)) {
            $deviceCode = 'gt-s7230e';
        } elseif (preg_match('/(samsung|gt)\-s7220/i', $useragent)) {
            $deviceCode = 'gt-s7220';
        } elseif (preg_match('/gt\-s6810p/i', $useragent)) {
            $deviceCode = 'gt-s6810p';
        } elseif (preg_match('/gt\-s6810b/i', $useragent)) {
            $deviceCode = 'gt-s6810b';
        } elseif (preg_match('/gt\-s6810/i', $useragent)) {
            $deviceCode = 'gt-s6810';
        } elseif (preg_match('/gt\-s6802/i', $useragent)) {
            $deviceCode = 'gt-s6802';
        } elseif (preg_match('/gt\-s6500d/i', $useragent)) {
            $deviceCode = 'gt-s6500d';
        } elseif (preg_match('/gt\-s6500t/i', $useragent)) {
            $deviceCode = 'gt-s6500t';
        } elseif (preg_match('/gt\-s6500/i', $useragent)) {
            $deviceCode = 'gt-s6500';
        } elseif (preg_match('/gt\-s6312/i', $useragent)) {
            $deviceCode = 'gt-s6312';
        } elseif (preg_match('/gt\-s6310n/i', $useragent)) {
            $deviceCode = 'gt-s6310n';
        } elseif (preg_match('/gt\-s6310/i', $useragent)) {
            $deviceCode = 'gt-s6310';
        } elseif (preg_match('/gt\-s6102b/i', $useragent)) {
            $deviceCode = 'gt-s6102b';
        } elseif (preg_match('/gt\-s6102/i', $useragent)) {
            $deviceCode = 'gt-s6102';
        } elseif (preg_match('/gt\-s5839i/i', $useragent)) {
            $deviceCode = 'gt-s5839i';
        } elseif (preg_match('/gt\-s5830l/i', $useragent)) {
            $deviceCode = 'gt-s5830l';
        } elseif (preg_match('/gt\-s5830i/i', $useragent)) {
            $deviceCode = 'gt-s5830i';
        } elseif (preg_match('/gt\-s5830c/i', $useragent)) {
            $deviceCode = 'gt-s5830c';
        } elseif (preg_match('/gt\-s5570i/i', $useragent)) {
            $deviceCode = 'gt-s5570i';
        } elseif (preg_match('/gt\-s5570/i', $useragent)) {
            $deviceCode = 'gt-s5570';
        } elseif (preg_match('/(gt\-s5830|ace)/i', $useragent)) {
            $deviceCode = 'gt-s5830';
        } elseif (preg_match('/gt\-s5780/i', $useragent)) {
            $deviceCode = 'gt-s5780';
        } elseif (preg_match('/gt\-s5750e/i', $useragent)) {
            $deviceCode = 'gt-s5750e orange';
        } elseif (preg_match('/gt\-s5690/i', $useragent)) {
            $deviceCode = 'gt-s5690';
        } elseif (preg_match('/gt\-s5670/i', $useragent)) {
            $deviceCode = 'gt-s5670';
        } elseif (preg_match('/gt\-s5660/i', $useragent)) {
            $deviceCode = 'gt-s5660';
        } elseif (preg_match('/gt\-s5620/i', $useragent)) {
            $deviceCode = 'gt-s5620';
        } elseif (preg_match('/gt\-s5560i/i', $useragent)) {
            $deviceCode = 'gt-s5560i';
        } elseif (preg_match('/gt\-s5560/i', $useragent)) {
            $deviceCode = 'gt-s5560';
        } elseif (preg_match('/gt\-s5380/i', $useragent)) {
            $deviceCode = 'gt-s5380';
        } elseif (preg_match('/gt\-s5369/i', $useragent)) {
            $deviceCode = 'gt-s5369';
        } elseif (preg_match('/gt\-s5363/i', $useragent)) {
            $deviceCode = 'gt-s5363';
        } elseif (preg_match('/gt\-s5360/i', $useragent)) {
            $deviceCode = 'gt-s5360';
        } elseif (preg_match('/gt\-s5330/i', $useragent)) {
            $deviceCode = 'gt-s5330';
        } elseif (preg_match('/gt\-s5310m/i', $useragent)) {
            $deviceCode = 'gt-s5310m';
        } elseif (preg_match('/gt\-s5310/i', $useragent)) {
            $deviceCode = 'gt-s5310';
        } elseif (preg_match('/gt\-s5302/i', $useragent)) {
            $deviceCode = 'gt-s5302';
        } elseif (preg_match('/gt\-s5301l/i', $useragent)) {
            $deviceCode = 'gt-s5301l';
        } elseif (preg_match('/gt\-s5301/i', $useragent)) {
            $deviceCode = 'gt-s5301';
        } elseif (preg_match('/gt\-s5300b/i', $useragent)) {
            $deviceCode = 'gt-s5300b';
        } elseif (preg_match('/gt\-s5300/i', $useragent)) {
            $deviceCode = 'gt-s5300';
        } elseif (preg_match('/gt\-s5280/i', $useragent)) {
            $deviceCode = 'gt-s5280';
        } elseif (preg_match('/gt\-s5260/i', $useragent)) {
            $deviceCode = 'gt-s5260';
        } elseif (preg_match('/gt\-s5250/i', $useragent)) {
            $deviceCode = 'gt-s5250';
        } elseif (preg_match('/gt\-s5233s/i', $useragent)) {
            $deviceCode = 'gt-s5233s';
        } elseif (preg_match('/gt\-s5230w/i', $useragent)) {
            $deviceCode = 'gt s5230w';
        } elseif (preg_match('/gt\-s5230/i', $useragent)) {
            $deviceCode = 'gt-s5230';
        } elseif (preg_match('/gt\-s5222/i', $useragent)) {
            $deviceCode = 'gt-s5222';
        } elseif (preg_match('/gt\-s5220/i', $useragent)) {
            $deviceCode = 'gt-s5220';
        } elseif (preg_match('/gt\-s3850/i', $useragent)) {
            $deviceCode = 'gt-s3850';
        } elseif (preg_match('/gt\-s3802/i', $useragent)) {
            $deviceCode = 'gt-s3802';
        } elseif (preg_match('/gt\-s3653/i', $useragent)) {
            $deviceCode = 'gt-s3653';
        } elseif (preg_match('/gt\-s3650/i', $useragent)) {
            $deviceCode = 'gt-s3650';
        } elseif (preg_match('/gt\-s3370/i', $useragent)) {
            $deviceCode = 'gt-s3370';
        } elseif (preg_match('/gt\-p7511/i', $useragent)) {
            $deviceCode = 'gt-p7511';
        } elseif (preg_match('/gt\-p7510/i', $useragent)) {
            $deviceCode = 'gt-p7510';
        } elseif (preg_match('/gt\-p7501/i', $useragent)) {
            $deviceCode = 'gt-p7501';
        } elseif (preg_match('/gt\-p7500m/i', $useragent)) {
            $deviceCode = 'gt-p7500m';
        } elseif (preg_match('/gt\-p7500/i', $useragent)) {
            $deviceCode = 'gt-p7500';
        } elseif (preg_match('/gt\-p7320/i', $useragent)) {
            $deviceCode = 'gt-p7320';
        } elseif (preg_match('/gt\-p7310/i', $useragent)) {
            $deviceCode = 'gt-p7310';
        } elseif (preg_match('/gt\-p7300b/i', $useragent)) {
            $deviceCode = 'gt-p7300b';
        } elseif (preg_match('/gt\-p7300/i', $useragent)) {
            $deviceCode = 'gt-p7300';
        } elseif (preg_match('/gt\-p7100/i', $useragent)) {
            $deviceCode = 'gt-p7100';
        } elseif (preg_match('/gt\-p6810/i', $useragent)) {
            $deviceCode = 'gt-p6810';
        } elseif (preg_match('/gt\-p6800/i', $useragent)) {
            $deviceCode = 'gt-p6800';
        } elseif (preg_match('/gt\-p6211/i', $useragent)) {
            $deviceCode = 'gt-p6211';
        } elseif (preg_match('/gt\-p6210/i', $useragent)) {
            $deviceCode = 'gt-p6210';
        } elseif (preg_match('/gt\-p6201/i', $useragent)) {
            $deviceCode = 'gt-p6201';
        } elseif (preg_match('/gt\-p6200/i', $useragent)) {
            $deviceCode = 'gt-p6200';
        } elseif (preg_match('/gt\-p5220/i', $useragent)) {
            $deviceCode = 'gt-p5220';
        } elseif (preg_match('/gt\-p5210/i', $useragent)) {
            $deviceCode = 'gt-p5210';
        } elseif (preg_match('/gt\-p5200/i', $useragent)) {
            $deviceCode = 'gt-p5200';
        } elseif (preg_match('/gt\-p5113/i', $useragent)) {
            $deviceCode = 'gt-p5113';
        } elseif (preg_match('/gt\-p5110/i', $useragent)) {
            $deviceCode = 'gt-p5110';
        } elseif (preg_match('/gt\-p5100/i', $useragent)) {
            $deviceCode = 'gt-p5100';
        } elseif (preg_match('/gt\-p3113/i', $useragent)) {
            $deviceCode = 'gt-p3113';
        } elseif (preg_match('/(gt\-p3100|galaxy tab 2 3g)/i', $useragent)) {
            $deviceCode = 'gt-p3100';
        } elseif (preg_match('/(gt\-p3110|galaxy tab 2)/i', $useragent)) {
            $deviceCode = 'gt-p3110';
        } elseif (preg_match('/gt\-p1010/i', $useragent)) {
            $deviceCode = 'gt-p1010';
        } elseif (preg_match('/gt\-p1000n/i', $useragent)) {
            $deviceCode = 'gt-p1000n';
        } elseif (preg_match('/gt\-p1000m/i', $useragent)) {
            $deviceCode = 'gt-p1000m';
        } elseif (preg_match('/gt\-p1000/i', $useragent)) {
            $deviceCode = 'gt-p1000';
        } elseif (preg_match('/gt\-n9000/i', $useragent)) {
            $deviceCode = 'gt-n9000';
        } elseif (preg_match('/gt\-n8020/i', $useragent)) {
            $deviceCode = 'gt-n8020';
        } elseif (preg_match('/gt\-n8013/i', $useragent)) {
            $deviceCode = 'gt-n8013';
        } elseif (preg_match('/gt\-n8010/i', $useragent)) {
            $deviceCode = 'gt-n8010';
        } elseif (preg_match('/gt\-n8005/i', $useragent)) {
            $deviceCode = 'gt-n8005';
        } elseif (preg_match('/(gt\-n8000d|n8000d)/i', $useragent)) {
            $deviceCode = 'gt-n8000d';
        } elseif (preg_match('/gt\-n8000/i', $useragent)) {
            $deviceCode = 'gt-n8000';
        } elseif (preg_match('/gt\-n7108/i', $useragent)) {
            $deviceCode = 'gt-n7108';
        } elseif (preg_match('/gt\-n7105/i', $useragent)) {
            $deviceCode = 'gt-n7105';
        } elseif (preg_match('/gt\-n7100/i', $useragent)) {
            $deviceCode = 'gt-n7100';
        } elseif (preg_match('/GT\-N7000/i', $useragent)) {
            $deviceCode = 'gt-n7000';
        } elseif (preg_match('/GT\-N5120/i', $useragent)) {
            $deviceCode = 'gt-n5120';
        } elseif (preg_match('/GT\-N5110/i', $useragent)) {
            $deviceCode = 'gt-n5110';
        } elseif (preg_match('/GT\-N5100/i', $useragent)) {
            $deviceCode = 'gt-n5100';
        } elseif (preg_match('/GT\-M7600/i', $useragent)) {
            $deviceCode = 'gt-m7600';
        } elseif (preg_match('/GT\-I9515/i', $useragent)) {
            $deviceCode = 'gt-i9515';
        } elseif (preg_match('/GT\-I9506/i', $useragent)) {
            $deviceCode = 'gt-i9506';
        } elseif (preg_match('/GT\-I9505X/i', $useragent)) {
            $deviceCode = 'gt-i9505x';
        } elseif (preg_match('/GT\-I9505G/i', $useragent)) {
            $deviceCode = 'gt-i9505g';
        } elseif (preg_match('/GT\-I9505/i', $useragent)) {
            $deviceCode = 'gt-i9505';
        } elseif (preg_match('/GT\-I9502/i', $useragent)) {
            $deviceCode = 'gt-i9502';
        } elseif (preg_match('/GT\-I9500/i', $useragent)) {
            $deviceCode = 'gt-i9500';
        } elseif (preg_match('/GT\-I9308/i', $useragent)) {
            $deviceCode = 'gt-i9308';
        } elseif (preg_match('/GT\-I9305/i', $useragent)) {
            $deviceCode = 'gt-i9305';
        } elseif (preg_match('/(gt\-i9301i|i9301i)/i', $useragent)) {
            $deviceCode = 'gt-i9301i';
        } elseif (preg_match('/(gt\-i9301q|i9301q)/i', $useragent)) {
            $deviceCode = 'gt-i9301q';
        } elseif (preg_match('/(gt\-i9301|i9301)/i', $useragent)) {
            $deviceCode = 'gt-i9301';
        } elseif (preg_match('/GT\-I9300I/i', $useragent)) {
            $deviceCode = 'gt-i9300i';
        } elseif (preg_match('/(GT\-l9300|GT\-i9300|I9300)/i', $useragent)) {
            $deviceCode = 'gt-i9300';
        } elseif (preg_match('/(GT\-I9295|I9295)/i', $useragent)) {
            $deviceCode = 'gt-i9295';
        } elseif (preg_match('/GT\-I9210/i', $useragent)) {
            $deviceCode = 'gt-i9210';
        } elseif (preg_match('/GT\-I9205/i', $useragent)) {
            $deviceCode = 'gt-i9205';
        } elseif (preg_match('/GT\-I9200/i', $useragent)) {
            $deviceCode = 'gt-i9200';
        } elseif (preg_match('/gt\-i9195i/i', $useragent)) {
            $deviceCode = 'gt-i9195i';
        } elseif (preg_match('/(gt\-i9195|i9195)/i', $useragent)) {
            $deviceCode = 'gt-i9195';
        } elseif (preg_match('/(gt\-i9192|i9192)/i', $useragent)) {
            $deviceCode = 'gt-i9192';
        } elseif (preg_match('/(gt\-i9190|i9190)/i', $useragent)) {
            $deviceCode = 'gt-i9190';
        } elseif (preg_match('/gt\-i9152/i', $useragent)) {
            $deviceCode = 'gt-i9152';
        } elseif (preg_match('/gt\-i9128v/i', $useragent)) {
            $deviceCode = 'gt-i9128v';
        } elseif (preg_match('/gt\-i9105p/i', $useragent)) {
            $deviceCode = 'gt-i9105p';
        } elseif (preg_match('/gt\-i9105/i', $useragent)) {
            $deviceCode = 'gt-i9105';
        } elseif (preg_match('/gt\-i9103/i', $useragent)) {
            $deviceCode = 'gt-i9103';
        } elseif (preg_match('/gt\-i9100t/i', $useragent)) {
            $deviceCode = 'gt-i9100t';
        } elseif (preg_match('/gt\-i9100p/i', $useragent)) {
            $deviceCode = 'gt-i9100p';
        } elseif (preg_match('/gt\-i9100g/i', $useragent)) {
            $deviceCode = 'gt-i9100g';
        } elseif (preg_match('/(gt\-i9100|i9100)/i', $useragent)) {
            $deviceCode = 'gt-i9100';
        } elseif (preg_match('/gt\-i9088/i', $useragent)) {
            $deviceCode = 'gt-i9088';
        } elseif (preg_match('/gt\-i9082l/i', $useragent)) {
            $deviceCode = 'gt-i9082l';
        } elseif (preg_match('/gt\-i9082/i', $useragent)) {
            $deviceCode = 'gt-i9082';
        } elseif (preg_match('/gt\-i9070p/i', $useragent)) {
            $deviceCode = 'gt-i9070p';
        } elseif (preg_match('/gt\-i9070/i', $useragent)) {
            $deviceCode = 'gt-i9070';
        } elseif (preg_match('/gt\-i9060l/i', $useragent)) {
            $deviceCode = 'gt-i9060l';
        } elseif (preg_match('/gt\-i9060i/i', $useragent)) {
            $deviceCode = 'gt-i9060i';
        } elseif (preg_match('/gt\-i9060/i', $useragent)) {
            $deviceCode = 'gt-i9060';
        } elseif (preg_match('/gt\-i9023/i', $useragent)) {
            $deviceCode = 'gt-i9023';
        } elseif (preg_match('/gt\-i9010p/i', $useragent)) {
            $deviceCode = 'gt-i9010p';
        } elseif (preg_match('/galaxy( |\-)s4/i', $useragent)) {
            $deviceCode = 'gt-i9500';
        } elseif (preg_match('/Galaxy( |\-)S/i', $useragent)) {
            $deviceCode = 'samsung gt-i9010';
        } elseif (preg_match('/GT\-I9010/i', $useragent)) {
            $deviceCode = 'samsung gt-i9010';
        } elseif (preg_match('/GT\-I9008L/i', $useragent)) {
            $deviceCode = 'gt-i9008l';
        } elseif (preg_match('/GT\-I9008/i', $useragent)) {
            $deviceCode = 'gt-i9008';
        } elseif (preg_match('/gt\-i9003l/i', $useragent)) {
            $deviceCode = 'gt-i9003l';
        } elseif (preg_match('/gt\-i9003/i', $useragent)) {
            $deviceCode = 'gt-i9003';
        } elseif (preg_match('/gt\-i9001/i', $useragent)) {
            $deviceCode = 'gt-i9001';
        } elseif (preg_match('/(gt\-i9000|sgh\-t959v)/i', $useragent)) {
            $deviceCode = 'gt-i9000';
        } elseif (preg_match('/(gt\-i8910|i8910)/i', $useragent)) {
            $deviceCode = 'gt-i8910';
        } elseif (preg_match('/gt\-i8750/i', $useragent)) {
            $deviceCode = 'gt-i8750';
        } elseif (preg_match('/gt\-i8730/i', $useragent)) {
            $deviceCode = 'gt-i8730';
        } elseif (preg_match('/omnia7/i', $useragent)) {
            $deviceCode = 'gt-i8700';
        } elseif (preg_match('/gt\-i8552/i', $useragent)) {
            $deviceCode = 'gt-i8552';
        } elseif (preg_match('/gt\-i8530/i', $useragent)) {
            $deviceCode = 'gt-i8530';
        } elseif (preg_match('/gt\-i8350/i', $useragent)) {
            $deviceCode = 'gt-i8350';
        } elseif (preg_match('/gt\-i8320/i', $useragent)) {
            $deviceCode = 'gt-i8320';
        } elseif (preg_match('/gt\-i8262/i', $useragent)) {
            $deviceCode = 'gt-i8262';
        } elseif (preg_match('/gt\-i8260/i', $useragent)) {
            $deviceCode = 'gt-i8260';
        } elseif (preg_match('/gt\-i8200n/i', $useragent)) {
            $deviceCode = 'gt-i8200n';
        } elseif (preg_match('/GT\-I8200/i', $useragent)) {
            $deviceCode = 'gt-i8200';
        } elseif (preg_match('/GT\-I8190N/i', $useragent)) {
            $deviceCode = 'gt-i8190n';
        } elseif (preg_match('/GT\-I8190/i', $useragent)) {
            $deviceCode = 'gt-i8190';
        } elseif (preg_match('/GT\-I8160P/i', $useragent)) {
            $deviceCode = 'gt-i8160p';
        } elseif (preg_match('/GT\-I8160/i', $useragent)) {
            $deviceCode = 'gt-i8160';
        } elseif (preg_match('/GT\-I8150/i', $useragent)) {
            $deviceCode = 'gt-i8150';
        } elseif (preg_match('/GT\-i8000V/i', $useragent)) {
            $deviceCode = 'gt-i8000v';
        } elseif (preg_match('/GT\-i8000/i', $useragent)) {
            $deviceCode = 'gt-i8000';
        } elseif (preg_match('/GT\-I6410/i', $useragent)) {
            $deviceCode = 'gt-i6410';
        } elseif (preg_match('/GT\-I5801/i', $useragent)) {
            $deviceCode = 'gt-i5801';
        } elseif (preg_match('/GT\-I5800/i', $useragent)) {
            $deviceCode = 'gt-i5800';
        } elseif (preg_match('/GT\-I5700/i', $useragent)) {
            $deviceCode = 'gt-i5700';
        } elseif (preg_match('/GT\-I5510/i', $useragent)) {
            $deviceCode = 'gt-i5510';
        } elseif (preg_match('/GT\-I5508/i', $useragent)) {
            $deviceCode = 'gt-i5508';
        } elseif (preg_match('/GT\-I5503/i', $useragent)) {
            $deviceCode = 'gt-i5503';
        } elseif (preg_match('/GT\-I5500/i', $useragent)) {
            $deviceCode = 'gt-i5500';
        } elseif (preg_match('/nexus s 4g/i', $useragent)) {
            $deviceCode = 'nexus s 4g';
        } elseif (preg_match('/nexus s/i', $useragent)) {
            $deviceCode = 'nexus s';
        } elseif (preg_match('/nexus 10/i', $useragent)) {
            $deviceCode = 'nexus 10';
        } elseif (preg_match('/nexus player/i', $useragent)) {
            $deviceCode = 'nexus player';
        } elseif (preg_match('/nexus/i', $useragent)) {
            $deviceCode = 'galaxy nexus';
        } elseif (preg_match('/Galaxy/i', $useragent)) {
            $deviceCode = 'gt-i7500';
        } elseif (preg_match('/GT\-E3309T/i', $useragent)) {
            $deviceCode = 'gt-e3309t';
        } elseif (preg_match('/GT\-E2550/i', $useragent)) {
            $deviceCode = 'gt-e2550';
        } elseif (preg_match('/GT\-E2252/i', $useragent)) {
            $deviceCode = 'gt-e2252';
        } elseif (preg_match('/GT\-E2222/i', $useragent)) {
            $deviceCode = 'gt-e2222';
        } elseif (preg_match('/GT\-E2202/i', $useragent)) {
            $deviceCode = 'gt-e2202';
        } elseif (preg_match('/GT\-E1282T/i', $useragent)) {
            $deviceCode = 'gt-e1282t';
        } elseif (preg_match('/GT\-C6712/i', $useragent)) {
            $deviceCode = 'gt-c6712';
        } elseif (preg_match('/GT\-C3780/i', $useragent)) {
            $deviceCode = 'gt-c3780';
        } elseif (preg_match('/GT\-C3510/i', $useragent)) {
            $deviceCode = 'gt-c3510';
        } elseif (preg_match('/GT\-C3500/i', $useragent)) {
            $deviceCode = 'gt-c3500';
        } elseif (preg_match('/GT\-C3350/i', $useragent)) {
            $deviceCode = 'gt-c3350';
        } elseif (preg_match('/GT\-C3322/i', $useragent)) {
            $deviceCode = 'gt-c3322';
        } elseif (preg_match('/gt\-C3312r/i', $useragent)) {
            $deviceCode = 'gt-c3312r';
        } elseif (preg_match('/GT\-C3310/i', $useragent)) {
            $deviceCode = 'gt-c3310';
        } elseif (preg_match('/GT\-C3262/i', $useragent)) {
            $deviceCode = 'gt-c3262';
        } elseif (preg_match('/GT\-B7722/i', $useragent)) {
            $deviceCode = 'gt-b7722';
        } elseif (preg_match('/GT\-B7610/i', $useragent)) {
            $deviceCode = 'gt-b7610';
        } elseif (preg_match('/GT\-B7510/i', $useragent)) {
            $deviceCode = 'gt-b7510';
        } elseif (preg_match('/GT\-B7350/i', $useragent)) {
            $deviceCode = 'gt-b7350';
        } elseif (preg_match('/gt\-b5510/i', $useragent)) {
            $deviceCode = 'gt-b5510';
        } elseif (preg_match('/gt\-b3410/i', $useragent)) {
            $deviceCode = 'gt-b3410';
        } elseif (preg_match('/gt\-b2710/i', $useragent)) {
            $deviceCode = 'gt-b2710';
        } elseif (preg_match('/(gt\-b2100|b2100)/i', $useragent)) {
            $deviceCode = 'gt-b2100';
        } elseif (preg_match('/F031/i', $useragent)) {
            $deviceCode = 'f031';
        } elseif (preg_match('/Continuum\-I400/i', $useragent)) {
            $deviceCode = 'continuum i400';
        } elseif (preg_match('/CETUS/i', $useragent)) {
            $deviceCode = 'cetus';
        } elseif (preg_match('/sc\-06d/i', $useragent)) {
            $deviceCode = 'sc-06d';
        } elseif (preg_match('/sc\-02f/i', $useragent)) {
            $deviceCode = 'sc-02f';
        } elseif (preg_match('/sc\-02c/i', $useragent)) {
            $deviceCode = 'sc-02c';
        } elseif (preg_match('/sc\-02b/i', $useragent)) {
            $deviceCode = 'sc-02b';
        } elseif (preg_match('/sc\-01f/i', $useragent)) {
            $deviceCode = 'sc-01f';
        } elseif (preg_match('/S3500/i', $useragent)) {
            $deviceCode = 's3500';
        } elseif (preg_match('/R631/i', $useragent)) {
            $deviceCode = 'r631';
        } elseif (preg_match('/i7110/i', $useragent)) {
            $deviceCode = 'i7110';
        } elseif (preg_match('/yp\-gs1/i', $useragent)) {
            $deviceCode = 'yp-gs1';
        } elseif (preg_match('/yp\-gi1/i', $useragent)) {
            $deviceCode = 'yp-gi1';
        } elseif (preg_match('/yp\-gb70/i', $useragent)) {
            $deviceCode = 'yp-gb70';
        } elseif (preg_match('/yp\-g70/i', $useragent)) {
            $deviceCode = 'yp-g70';
        } elseif (preg_match('/yp\-g1/i', $useragent)) {
            $deviceCode = 'yp-g1';
        } elseif (preg_match('/sch\-r730/i', $useragent)) {
            $deviceCode = 'sch-r730';
        } elseif (preg_match('/sph\-p100/i', $useragent)) {
            $deviceCode = 'sph-p100';
        } elseif (preg_match('/sph\-m930/i', $useragent)) {
            $deviceCode = 'sph-m930';
        } elseif (preg_match('/sph\-m840/i', $useragent)) {
            $deviceCode = 'sph-m840';
        } elseif (preg_match('/sph\-m580/i', $useragent)) {
            $deviceCode = 'sph-m580';
        } elseif (preg_match('/sph\-l900/i', $useragent)) {
            $deviceCode = 'sph-l900';
        } elseif (preg_match('/sph\-l720/i', $useragent)) {
            $deviceCode = 'sph-l720';
        } elseif (preg_match('/sph\-l710/i', $useragent)) {
            $deviceCode = 'sph-l710';
        } elseif (preg_match('/sph\-ip830w/i', $useragent)) {
            $deviceCode = 'sph-ip830w';
        } elseif (preg_match('/sph\-d710bst/i', $useragent)) {
            $deviceCode = 'sph-d710bst';
        } elseif (preg_match('/sph\-d710/i', $useragent)) {
            $deviceCode = 'sph-d710';
        } elseif (preg_match('/smart\-tv/i', $useragent)) {
            $deviceCode = 'samsung smart tv';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
