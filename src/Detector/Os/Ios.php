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

namespace BrowserDetector\Detector\Os;

use BrowserDetector\Detector\Browser\AppleMail;
use BrowserDetector\Detector\Browser\BingPreview;
use BrowserDetector\Detector\Browser\GoogleAdsbotMobile;
use BrowserDetector\Detector\Browser\Googlebot;
use BrowserDetector\Detector\Browser\GooglebotMobileBot;
use BrowserDetector\Detector\Browser\GooglePageSpeed;
use BrowserDetector\Detector\Browser\GooglePageSpeedInsights;
use BrowserDetector\Detector\Browser\GoogleApp;
use BrowserDetector\Detector\Browser\MsnBotMedia;
use BrowserDetector\Detector\Browser\Ucweb;
use BrowserDetector\Detector\Browser\Chrome;
use BrowserDetector\Detector\Browser\DarwinBrowser;
use BrowserDetector\Detector\Browser\FacebookApp;
use BrowserDetector\Detector\Browser\GooglePlus;
use BrowserDetector\Detector\Browser\Incredimail;
use BrowserDetector\Detector\Browser\Isource;
use BrowserDetector\Detector\Browser\Lunascape;
use BrowserDetector\Detector\Browser\Mercury;
use BrowserDetector\Detector\Browser\MqqBrowser;
use BrowserDetector\Detector\Browser\NetNewsWire;
use BrowserDetector\Detector\Browser\OnePassword;
use BrowserDetector\Detector\Browser\OperaMini;
use BrowserDetector\Detector\Browser\OperaMobile;
use BrowserDetector\Detector\Browser\Safari;
use BrowserDetector\Detector\Browser\Sleipnir;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface\OsInterface;

use BrowserDetector\Detector\Version;

/**
 * MSIEAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Ios
    extends AbstractOs
    implements OsInterface
{
    /**
     * returns the name of the operating system/platform
     *
     * @return string
     */
    public function getName()
    {
        return 'iOS';
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->useragent);

        $searches = array(
            'IphoneOSX',
            'CPU OS\_',
            'CPU OS',
            'CPU iOS',
            'CPU iPad OS',
            'iPhone OS',
            'iPhone_OS',
            'IUC\(U\;iOS'
        );

        $detector->detectVersion($searches);

        $doMatch = preg_match('/CPU like Mac OS X/', $this->useragent, $matches);

        if ($doMatch) {
            $detector->setVersion('1.0');
        }

        return $detector;
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Apple();
    }

    /**
     * returns the Browser which used on the device
     *
     * @return \BrowserDetector\Detector\Browser\AbstractBrowser
     */
    public function detectBrowser()
    {
        $browsers = array(
            new Safari(),
            new Chrome(),
            new OperaMobile(),
            new OperaMini(),
            new OnePassword(),
            new Sleipnir(),
            new DarwinBrowser(),
            new FacebookApp(),
            new Isource(),
            new GooglePlus(),
            new NetNewsWire(),
            new Incredimail(),
            new Lunascape(),
            new MqqBrowser(),
            new AppleMail(),
            new Googlebot(),
            new GooglebotMobileBot(),
            new GooglePageSpeed(),
            new GooglePageSpeedInsights(),
            new GoogleApp(),
            new Mercury(),
            new MsnBotMedia(),
            new GoogleAdsbotMobile(),
            new BingPreview(),
            new Ucweb(),
        );

        $chain = new Chain();
        $chain->setUserAgent($this->useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }
}
