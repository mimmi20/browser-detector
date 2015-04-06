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

use BrowserDetector\Detector\Browser\General\Bingbot;
use BrowserDetector\Detector\Browser\General\CfNetwork;
use BrowserDetector\Detector\Browser\General\Icab;
use BrowserDetector\Detector\Browser\General\Maven;
use BrowserDetector\Detector\Browser\Mobile\AppleMail;
use BrowserDetector\Detector\Browser\Mobile\AtomicBrowser;
use BrowserDetector\Detector\Browser\Mobile\Coast;
use BrowserDetector\Detector\Browser\Mobile\DarwinBrowser;
use BrowserDetector\Detector\Browser\Mobile\Incredimail;
use BrowserDetector\Detector\Browser\Mobile\Mercury;
use BrowserDetector\Detector\Browser\Mobile\Omniweb;
use BrowserDetector\Detector\Browser\Mobile\OnePassword;
use BrowserDetector\Detector\Browser\Mobile\PerfectBrowser;
use BrowserDetector\Detector\Browser\Mobile\Puffin;
use BrowserDetector\Detector\Browser\Mobile\QuickLook;
use BrowserDetector\Detector\Browser\Mobile\Safari;
use BrowserDetector\Detector\Browser\Mobile\Sleipnir;
use BrowserDetector\Detector\Browser\Mobile\SmartSync;
use BrowserDetector\Detector\Browser\Mobile\Spector;
use BrowserDetector\Detector\Browser\Mobile\Terra;
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
class Darwin
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
        if (!$this->utils->checkIfContains('darwin', true)) {
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
        return 'Darwin';
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

        $searches = array('Darwin');

        return $detector->detectVersion($searches);
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
        return 70150;
    }

    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\OsHandler
     */
    public function detectBrowser()
    {
        $browsers = array(
            new Safari(),
            new OnePassword(),
            new Sleipnir(),
            new DarwinBrowser(),
            new Terra(),
            new Puffin(),
            new Omniweb(),
            new AtomicBrowser(),
            new Mercury(),
            new Bingbot(),
            new Maven(),
            new PerfectBrowser(),
            new Spector(),
            new SmartSync(),
            new Incredimail(),
            new AppleMail(),
            new Coast(),
            new QuickLook(),
            new Icab(),
            new CfNetwork(),
        );

        $chain = new Chain();
        $chain->setUserAgent($this->useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }
}
