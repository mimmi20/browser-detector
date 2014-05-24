<?php
namespace BrowserDetector\Detector\Os;

/**
 * PHP version 5.3
 *
 * LICENSE:
 *
 * Copyright (c) 2013, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * * Neither the name of the authors nor the names of its contributors may be
 *   used to endorse or promote products derived from this software without
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

use BrowserDetector\Detector\Browser\Bot\GenericJavaCrawler;
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
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\OsInterface;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Version;

/**
 * MSIEAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class Java
    extends OsHandler
    implements MatcherInterface, OsInterface
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
    public function getVersion()
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
            new Jasmine()
        );

        $chain = new Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }
}