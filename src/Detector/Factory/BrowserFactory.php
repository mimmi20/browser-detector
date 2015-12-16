<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Browser\AndroidWebkit;
use BrowserDetector\Detector\Browser\Blackberry;
use BrowserDetector\Detector\Browser\Chrome;
use BrowserDetector\Detector\Browser\ContextadBot;
use BrowserDetector\Detector\Browser\Dalvik;
use BrowserDetector\Detector\Browser\Dolfin;
use BrowserDetector\Detector\Browser\Ezooms;
use BrowserDetector\Detector\Browser\Firefox;
use BrowserDetector\Detector\Browser\FlyFlow;
use BrowserDetector\Detector\Browser\GrapeFx;
use BrowserDetector\Detector\Browser\GrapeshotCrawler;
use BrowserDetector\Detector\Browser\Maxthon;
use BrowserDetector\Detector\Browser\MicrosoftInternetExplorer;
use BrowserDetector\Detector\Browser\Midori;
use BrowserDetector\Detector\Browser\Netscape;
use BrowserDetector\Detector\Browser\NikiBot;
use BrowserDetector\Detector\Browser\Opera;
use BrowserDetector\Detector\Browser\PlaystationBrowser;
use BrowserDetector\Detector\Browser\Safari;
use BrowserDetector\Detector\Browser\Sistrix;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Browser\WaterFox;
use Psr\Log\LoggerInterface;
use WurflCache\Adapter\AdapterInterface;
use UaMatcher\Os\OsInterface;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserFactory
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string                               $agent
     * @param \UaMatcher\Os\OsInterface            $platform
     * @param \Psr\Log\LoggerInterface             $logger
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @return \BrowserDetector\Detector\Browser\AbstractBrowser
     */
    public static function detect($agent, OsInterface $platform, LoggerInterface $logger, AdapterInterface $cache = null)
    {
        if (preg_match('/(opera|opr)/i', $agent)) {
            $browser = new Opera($agent, $logger);
        } elseif (preg_match('/(mxbrowser|maxthon|myie)/i', $agent)) {
            $browser = new Maxthon($agent, $logger);
        } elseif (preg_match('/Mozilla\/5\.0.*\(.*Trident\/7\.0.*rv\:11\.0.*\) like Gecko.*/', $agent)
            || preg_match('/Mozilla\/5\.0.*\(.*MSIE 10\.0.*/', $agent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (9|8|7|6)\.0.*/', $agent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (5|4)\.\d+.*/', $agent)
            || preg_match('/Mozilla\/\d\.\d+.*\(.*MSIE (3|2|1)\.\d+.*/', $agent)
        ) {
            $browser = new MicrosoftInternetExplorer($agent, $logger);
        } elseif (preg_match('/(chrome|crmo|crios)/i', $agent)) {
            $browser = new Chrome($agent, $logger);
        } elseif (preg_match('/(flyflow)/i', $agent)) {
            $browser = new FlyFlow($agent, $logger);
        } elseif (preg_match('/(dolphin|dolfin)/i', $agent)) {
            $browser = new Dolfin($agent, $logger);
        } elseif (preg_match('/(safari)/i', $agent) && 'Android' === $platform->getName()) {
            $browser = new AndroidWebkit($agent, $logger);
        } elseif (preg_match('/(safari)/i', $agent)) {
            $browser = new Safari($agent, $logger);
        } elseif (preg_match('/(waterfox)/i', $agent)) {
            $browser = new WaterFox($agent, $logger);
        } elseif (preg_match('/(firefox|minefield|shiretoko|bonecho|namoroka)/i', $agent)) {
            $browser = new Firefox($agent, $logger);
        } elseif (preg_match('/(playstation 3)/i', $agent)) {
            $browser = new PlaystationBrowser($agent, $logger);
        } elseif (preg_match('/(midori)/i', $agent)) {
            $browser = new Midori($agent, $logger);
        } elseif (preg_match('/(sistrix crawler)/i', $agent)) {
            $browser = new Sistrix($agent, $logger);
        } elseif (preg_match('/(ezooms)/i', $agent)) {
            $browser = new Ezooms($agent, $logger);
        } elseif (preg_match('/(backberry|bb10)/i', $agent)) {
            $browser = new Blackberry($agent, $logger);
        } elseif (preg_match('/(grapefx)/i', $agent)) {
            $browser = new GrapeFx($agent, $logger);
        } elseif (preg_match('/(grapeshotcrawler)/i', $agent)) {
            $browser = new GrapeshotCrawler($agent, $logger);
        } elseif (preg_match('/^Mozilla\/\d/', $agent)) {
            $browser = new Netscape($agent, $logger);
        } elseif (preg_match('/^Dalvik\/\d/', $agent)) {
            $browser = new Dalvik($agent, $logger);
        } elseif (preg_match('/niki\-bot/', $agent)) {
            $browser = new NikiBot($agent, $logger);
        } elseif (preg_match('/^ContextAd Bot\d/', $agent)) {
            $browser = new ContextadBot($agent, $logger);
        } else {
            $browser = new UnknownBrowser($agent, $logger);
        }

        $browser->setCache($cache);

        return $browser;
    }
}
