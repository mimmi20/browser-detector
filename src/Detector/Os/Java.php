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

use BrowserDetector\Detector\Browser\Bot\GenericJavaCrawler;
use BrowserDetector\Detector\Browser\Bot\GooglebotMobileBot;
use BrowserDetector\Detector\Browser\Mobile\Dalvik;
use BrowserDetector\Detector\Browser\Mobile\Dolfin;
use BrowserDetector\Detector\Browser\Mobile\Jasmine;
use BrowserDetector\Detector\Browser\Mobile\Motorola;
use BrowserDetector\Detector\Browser\Mobile\NetFront;
use BrowserDetector\Detector\Browser\Mobile\NokiaBrowser;
use BrowserDetector\Detector\Browser\Mobile\NokiaProxyBrowser;
use BrowserDetector\Detector\Browser\Mobile\Openwave;
use BrowserDetector\Detector\Browser\Mobile\OperaMini;
use BrowserDetector\Detector\Browser\Mobile\Phantom;
use BrowserDetector\Detector\Browser\Mobile\PlaystationBrowser;
use BrowserDetector\Detector\Browser\Mobile\Silk;
use BrowserDetector\Detector\Browser\Mobile\TelecaObigo;
use BrowserDetector\Detector\Browser\Mobile\Ucweb;
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
class Java
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
        if (!$this->utils->checkIfContains(
            array(
                'Java', 'J2ME/MIDP', 'Profile/MIDP', 'JUC', 'UCWEB', 'NetFront', 'Nokia', 'Jasmine/1.0', 'JavaPlatform',
                'WAP/OBIGO', 'Obigo/WAP'
            )
        )
        ) {
            return false;
        }

        $isNotReallyAJava = array(
            'SymbianOS',
            'SymbOS',
            'Symbian',
            'Series 60',
            'S60V3',
            'S60V5',
            'MeeGo',
            'Windows CE',
            'Windows NT',
            'MSIEMobile',
            'IEMobile',
            'Microsoft Windows'
        );

        if ($this->utils->checkIfContains($isNotReallyAJava)) {
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
        return 'Java';
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->_useragent);

        $searches = array('Java');

        return $detector->detectVersion($searches);
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Oracle();
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 147240;
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
            new Openwave(),
            new TelecaObigo(),
            new NetFront(),
            new Phantom(),
            new NokiaBrowser(),
            new Dalvik(),
            new Dolfin(),
            new OperaMini(),
            new Ucweb(),
            new NokiaProxyBrowser(),
            new Motorola(),
            new GenericJavaCrawler(),
            new PlaystationBrowser(),
            new Silk(),
            new Jasmine(),
            new GooglebotMobileBot(),
        );

        $chain = new Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }
}