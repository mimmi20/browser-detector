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
use BrowserDetector\Detector\Browser\AndroidWebView;
use BrowserDetector\Detector\Browser\ApusBrowser;
use BrowserDetector\Detector\Browser\BaiduBrowser;
use BrowserDetector\Detector\Browser\BaiduHdBrowser;
use BrowserDetector\Detector\Browser\BaiduMiniBrowser;
use BrowserDetector\Detector\Browser\Beamrise;
use BrowserDetector\Detector\Browser\Blackberry;
use BrowserDetector\Detector\Browser\Chedot;
use BrowserDetector\Detector\Browser\Chrome;
use BrowserDetector\Detector\Browser\Chromium;
use BrowserDetector\Detector\Browser\CmBrowser;
use BrowserDetector\Detector\Browser\CocCocBrowser;
use BrowserDetector\Detector\Browser\ComodoDragon;
use BrowserDetector\Detector\Browser\ContextadBot;
use BrowserDetector\Detector\Browser\Dalvik;
use BrowserDetector\Detector\Browser\Daumoa;
use BrowserDetector\Detector\Browser\Diglo;
use BrowserDetector\Detector\Browser\Dolfin;
use BrowserDetector\Detector\Browser\Ezooms;
use BrowserDetector\Detector\Browser\FacebookApp;
use BrowserDetector\Detector\Browser\Fennec;
use BrowserDetector\Detector\Browser\Firefox;
use BrowserDetector\Detector\Browser\Flipboard;
use BrowserDetector\Detector\Browser\FlyFlow;
use BrowserDetector\Detector\Browser\GrapeFx;
use BrowserDetector\Detector\Browser\GrapeshotCrawler;
use BrowserDetector\Detector\Browser\Gvfs;
use BrowserDetector\Detector\Browser\Icab;
use BrowserDetector\Detector\Browser\Iridium;
use BrowserDetector\Detector\Browser\KamelioApp;
use BrowserDetector\Detector\Browser\Kontact;
use BrowserDetector\Detector\Browser\Luakit;
use BrowserDetector\Detector\Browser\Maxthon;
use BrowserDetector\Detector\Browser\MaxthonNitro;
use BrowserDetector\Detector\Browser\MicrosoftInternetExplorer;
use BrowserDetector\Detector\Browser\Midori;
use BrowserDetector\Detector\Browser\MyInternetBrowser;
use BrowserDetector\Detector\Browser\NaverMatome;
use BrowserDetector\Detector\Browser\Netscape;
use BrowserDetector\Detector\Browser\NikiBot;
use BrowserDetector\Detector\Browser\Opera;
use BrowserDetector\Detector\Browser\OperaMini;
use BrowserDetector\Detector\Browser\OperaMobile;
use BrowserDetector\Detector\Browser\Palemoon;
use BrowserDetector\Detector\Browser\PhantomJs;
use BrowserDetector\Detector\Browser\PlaystationBrowser;
use BrowserDetector\Detector\Browser\Puffin;
use BrowserDetector\Detector\Browser\QupZilla;
use BrowserDetector\Detector\Browser\Qword;
use BrowserDetector\Detector\Browser\Safari;
use BrowserDetector\Detector\Browser\SamsungBrowser;
use BrowserDetector\Detector\Browser\SamsungWebView;
use BrowserDetector\Detector\Browser\SeznamBrowser;
use BrowserDetector\Detector\Browser\Silk;
use BrowserDetector\Detector\Browser\Sistrix;
use BrowserDetector\Detector\Browser\SmtBot;
use BrowserDetector\Detector\Browser\SuperBird;
use BrowserDetector\Detector\Browser\Thunderbird;
use BrowserDetector\Detector\Browser\TinyBrowser;
use BrowserDetector\Detector\Browser\UcBrowser;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Browser\WaterFox;
use BrowserDetector\Detector\Browser\WhiteHatAviator;
use BrowserDetector\Detector\Browser\YaBrowser;
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
        if ((false !== strpos($agent, 'OPR') && false !== strpos($agent, 'Android'))
            || (false !== strpos($agent, 'Opera Mobi'))
        ) {
            $browser = new OperaMobile($agent, $logger);
        } elseif (preg_match('/(opera|opr)/i', $agent)) {
            $browser = new Opera($agent, $logger);
        } elseif (false !== strpos($agent, 'UCBrowser') || false !== strpos($agent, 'UC Browser')) {
            $browser = new UcBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'iCab')) {
            $browser = new Icab($agent, $logger);
        } elseif (false !== strpos($agent, 'PhantomJS')) {
            $browser = new PhantomJs($agent, $logger);
        } elseif (false !== strpos($agent, 'YaBrowser')) {
            $browser = new YaBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Kamelio')) {
            $browser = new KamelioApp($agent, $logger);
        } elseif (false !== strpos($agent, 'FBAV')) {
            $browser = new FacebookApp($agent, $logger);
        } elseif (false !== strpos($agent, 'ACHEETAHI')) {
            $browser = new CmBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'bdbrowser_i18n')) {
            $browser = new BaiduBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'bdbrowserhd_i18n')) {
            $browser = new BaiduHdBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'bdbrowser_mini')) {
            $browser = new BaiduMiniBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Puffin')) {
            $browser = new Puffin($agent, $logger);
        } elseif (false !== strpos($agent, 'SamsungBrowser')) {
            $browser = new SamsungBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Silk')) {
            $browser = new Silk($agent, $logger);
        } elseif (false !== strpos($agent, 'coc_coc_browser')) {
            $browser = new CocCocBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'NaverMatome')) {
            $browser = new NaverMatome($agent, $logger);
        } elseif (false !== strpos($agent, 'Flipboard')) {
            $browser = new Flipboard($agent, $logger);
        } elseif (false !== strpos($agent, 'Seznam.cz')) {
            $browser = new SeznamBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Aviator')) {
            $browser = new WhiteHatAviator($agent, $logger);
        } elseif (false !== strpos($agent, 'Dragon')) {
            $browser = new ComodoDragon($agent, $logger);
        } elseif (false !== strpos($agent, 'Beamrise')) {
            $browser = new Beamrise($agent, $logger);
        } elseif (false !== strpos($agent, 'Diglo')) {
            $browser = new Diglo($agent, $logger);
        } elseif (false !== strpos($agent, 'APUSBrowser')) {
            $browser = new ApusBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Chedot')) {
            $browser = new Chedot($agent, $logger);
        } elseif (false !== strpos($agent, 'Qword')) {
            $browser = new Qword($agent, $logger);
        } elseif (false !== strpos($agent, 'Iridium')) {
            $browser = new Iridium($agent, $logger);
        } elseif (false !== strpos($agent, 'MxNitro')) {
            $browser = new MaxthonNitro($agent, $logger);
        } elseif (preg_match('/(mxbrowser|maxthon|myie)/i', $agent)) {
            $browser = new Maxthon($agent, $logger);
        } elseif (preg_match('/(superbird)/i', $agent)) {
            $browser = new SuperBird($agent, $logger);
        } elseif (false !== strpos($agent, 'TinyBrowser')) {
            $browser = new TinyBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Chrome') && false !== strpos($agent, 'Version')) {
            $browser = new AndroidWebView($agent, $logger);
        } elseif (false !== strpos($agent, 'Safari')
            && false !== strpos($agent, 'Version')
            && false !== strpos($agent, 'Tizen')
        ) {
            $browser = new SamsungWebView($agent, $logger);
        } elseif (preg_match('/Mozilla\/5\.0.*\(.*Trident\/7\.0.*rv\:11\.0.*\) like Gecko.*/', $agent)
            || preg_match('/Mozilla\/5\.0.*\(.*MSIE 10\.0.*/', $agent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (9|8|7|6)\.0.*/', $agent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (5|4)\.\d+.*/', $agent)
            || preg_match('/Mozilla\/\d\.\d+.*\(.*MSIE (3|2|1)\.\d+.*/', $agent)
        ) {
            $browser = new MicrosoftInternetExplorer($agent, $logger);
        } elseif (false !== strpos($agent, 'Chromium')) {
            $browser = new Chromium($agent, $logger);
        } elseif (preg_match('/(chrome|crmo|crios)/i', $agent)) {
            $browser = new Chrome($agent, $logger);
        } elseif (preg_match('/(Opera Mini)/', $agent)) {
            $browser = new OperaMini($agent, $logger);
        } elseif (preg_match('/(flyflow)/i', $agent)) {
            $browser = new FlyFlow($agent, $logger);
        } elseif (preg_match('/(dolphin|dolfin)/i', $agent)) {
            $browser = new Dolfin($agent, $logger);
        } elseif (preg_match('/(safari)/i', $agent) && 'Android' === $platform->getName()) {
            $browser = new AndroidWebkit($agent, $logger);
        } elseif (false !== strpos($agent, 'BlackBerry') && false !== strpos($agent, 'Version')) {
            $browser = new Blackberry($agent, $logger);
        } elseif (preg_match('/(safari)/i', $agent)) {
            $browser = new Safari($agent, $logger);
        } elseif (preg_match('/(PaleMoon)/', $agent)) {
            $browser = new Palemoon($agent, $logger);
        } elseif (preg_match('/(waterfox)/i', $agent)) {
            $browser = new WaterFox($agent, $logger);
        } elseif (preg_match('/(QupZilla)/', $agent)) {
            $browser = new QupZilla($agent, $logger);
        } elseif (preg_match('/(Thunderbird)/', $agent)) {
            $browser = new Thunderbird($agent, $logger);
        } elseif (preg_match('/(kontact)/', $agent)) {
            $browser = new Kontact($agent, $logger);
        } elseif (preg_match('/(Fennec)/', $agent)) {
            $browser = new Fennec($agent, $logger);
        } elseif (preg_match('/(myibrow)/', $agent)) {
            $browser = new MyInternetBrowser($agent, $logger);
        } elseif (preg_match('/(Daumoa)/', $agent)) {
            $browser = new Daumoa($agent, $logger);
        } elseif (preg_match('/(PaleMoon)/', $agent)) {
            $browser = new Palemoon($agent, $logger);
        } elseif (preg_match('/(firefox|minefield|shiretoko|bonecho|namoroka|fxios)/i', $agent)) {
            $browser = new Firefox($agent, $logger);
        } elseif (preg_match('/(SMTBot)/', $agent)) {
            $browser = new SmtBot($agent, $logger);
        } elseif (preg_match('/(gvfs)/', $agent)) {
            $browser = new Gvfs($agent, $logger);
        } elseif (preg_match('/(luakit)/', $agent)) {
            $browser = new Luakit($agent, $logger);
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
