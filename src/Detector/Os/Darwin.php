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

use BrowserDetector\Detector\Browser\Bingbot;
use BrowserDetector\Detector\Browser\CfNetwork;
use BrowserDetector\Detector\Browser\Icab;
use BrowserDetector\Detector\Browser\Maven;
use BrowserDetector\Detector\Browser\AppleMail;
use BrowserDetector\Detector\Browser\AtomicBrowser;
use BrowserDetector\Detector\Browser\OperaCoast;
use BrowserDetector\Detector\Browser\DarwinBrowser;
use BrowserDetector\Detector\Browser\Incredimail;
use BrowserDetector\Detector\Browser\Mercury;
use BrowserDetector\Detector\Browser\Omniweb;
use BrowserDetector\Detector\Browser\OnePassword;
use BrowserDetector\Detector\Browser\PerfectBrowser;
use BrowserDetector\Detector\Browser\Puffin;
use BrowserDetector\Detector\Browser\QuickLook;
use BrowserDetector\Detector\Browser\Safari;
use BrowserDetector\Detector\Browser\Sleipnir;
use BrowserDetector\Detector\Browser\SmartSync;
use BrowserDetector\Detector\Browser\Spector;
use BrowserDetector\Detector\Browser\Terra;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface\Os\OsInterface;

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
class Darwin
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
     * returns the Browser which used on the device
     *
     * @return \BrowserDetector\Detector\Browser\AbstractBrowser
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
            new OperaCoast(),
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
