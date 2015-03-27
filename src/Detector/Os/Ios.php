<?php
/**
 * Copyright (c) 2012-2014, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Os;

use BrowserDetector\Detector\Browser\General\AppleMail;
use BrowserDetector\Detector\Browser\General\BingPreview;
use BrowserDetector\Detector\Browser\General\GoogleAdsbotMobile;
use BrowserDetector\Detector\Browser\General\Googlebot;
use BrowserDetector\Detector\Browser\General\GooglebotMobileBot;
use BrowserDetector\Detector\Browser\General\GooglePageSpeed;
use BrowserDetector\Detector\Browser\General\GooglePageSpeedInsights;
use BrowserDetector\Detector\Browser\General\GoogleSearchAppliance;
use BrowserDetector\Detector\Browser\General\MsnBotMedia;
use BrowserDetector\Detector\Browser\General\Ucweb;
use BrowserDetector\Detector\Browser\Mobile\Chrome;
use BrowserDetector\Detector\Browser\Mobile\DarwinBrowser;
use BrowserDetector\Detector\Browser\Mobile\FacebookApp;
use BrowserDetector\Detector\Browser\Mobile\GooglePlus;
use BrowserDetector\Detector\Browser\Mobile\Incredimail;
use BrowserDetector\Detector\Browser\Mobile\Isource;
use BrowserDetector\Detector\Browser\Mobile\Lunascape;
use BrowserDetector\Detector\Browser\Mobile\Mercury;
use BrowserDetector\Detector\Browser\Mobile\MqqBrowser;
use BrowserDetector\Detector\Browser\Mobile\NetNewsWire;
use BrowserDetector\Detector\Browser\Mobile\OnePassword;
use BrowserDetector\Detector\Browser\Mobile\OperaMini;
use BrowserDetector\Detector\Browser\Mobile\OperaMobile;
use BrowserDetector\Detector\Browser\Mobile\Safari;
use BrowserDetector\Detector\Browser\Mobile\Sleipnir;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface\OsInterface;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Version;

/**
 * MSIEAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Ios
    extends OsHandler
    implements OsInterface
{
    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        $ios = array(
            'IphoneOSX',
            'iPhone OS',
            'like Mac OS X',
            'iPad',
            'IPad',
            'iPhone',
            'iPod',
            'CPU OS',
            'CPU iOS',
            'IUC(U;iOS'
        );

        if (!$this->utils->checkIfContains($ios)) {
            return false;
        }

        $otherOs = array(
            'Darwin',
            'Windows Phone'
        );

        if ($this->utils->checkIfContains($otherOs)) {
            return false;
        }

        return true;
    }

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
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 66458261;
    }

    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\BrowserHandler
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
            new GoogleSearchAppliance(),
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
