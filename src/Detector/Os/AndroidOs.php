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
 * @version   SVN: $Id$
 */

use BrowserDetector\Detector\Browser\Bot\Googlebot;
use BrowserDetector\Detector\Browser\Desktop\YouWaveAndroidOnPc;
use BrowserDetector\Detector\Browser\Mobile\Android;
use BrowserDetector\Detector\Browser\Mobile\AndroidDownloadManager;
use BrowserDetector\Detector\Browser\Mobile\Chrome;
use BrowserDetector\Detector\Browser\Mobile\Dalvik;
use BrowserDetector\Detector\Browser\Mobile\Dolfin;
use BrowserDetector\Detector\Browser\Mobile\Firefox;
use BrowserDetector\Detector\Browser\Mobile\FlyFlow;
use BrowserDetector\Detector\Browser\Mobile\Maxthon;
use BrowserDetector\Detector\Browser\Mobile\MqqBrowser;
use BrowserDetector\Detector\Browser\Mobile\NetFrontLifeBrowser;
use BrowserDetector\Detector\Browser\Mobile\Opera;
use BrowserDetector\Detector\Browser\Mobile\OperaMini;
use BrowserDetector\Detector\Browser\Mobile\OperaMobile;
use BrowserDetector\Detector\Browser\Mobile\OperaTablet;
use BrowserDetector\Detector\Browser\Mobile\Silk;
use BrowserDetector\Detector\Browser\Mobile\Ucweb;
use BrowserDetector\Detector\Browser\Mobile\YaBrowser;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\BrowserHandler;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\OsInterface;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\Safari as SafariHelper;

/**
 * MSIEAgentHandler
 *
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
class AndroidOs
    extends OsHandler
    implements MatcherInterface, OsInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array();

    /**
     * Class Constructor
     *
     * @return \BrowserDetector\Detector\Os\AndroidOs
     */
    public function __construct()
    {
        parent::__construct();

        $this->properties = array(
            // os
            'device_os'              => 'Android',
            'device_os_version'      => '',
            'device_os_bits'         => '', // not in wurfl
            'device_os_manufacturer' => new Company\Google(), // not in wurfl
        );
    }

    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        $noAndroid = array(
            'SymbianOS',
            'SymbOS',
            'Symbian',
            'Series 60',
            'S60V3',
            'Bada',
            'MeeGo',
            'BlackBerry; U; ',
            'webOS',
            'hpwOS',
            'like Android',
            'BB10'
        );

        if ($this->utils->checkIfContains($noAndroid)) {
            return false;
        }
        
        $firefoxOshelper = new \BrowserDetector\Helper\FirefoxOs();
        $firefoxOshelper->setUserAgent($this->_useragent);
        
        if ($firefoxOshelper->isFirefoxOs()) {
            return false;
        }

        $safariHelper = new SafariHelper();
        $safariHelper->setUserAgent($this->_useragent);

        if ($this->utils->checkIfContains(array('Android', 'Silk', 'JUC(Linux;U;', 'JUC (Linux; U;'))
            || $safariHelper->isMobileAsSafari()
        ) {
            return true;
        }

        $doMatch = preg_match('/Linux; U; (\d+[\d\.]+)/', $this->_useragent, $matches);
        if ($doMatch && $matches[1] >= 4) {
            return true;
        }

        return false;
    }

    /**
     * detects the browser version from the given user agent
     */
    protected function _detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->_useragent);

        if ($this->utils->checkIfContains('android 2.1-update1', true)) {
            $this->setCapability(
                'device_os_version',
                $detector->setVersion('2.1.1')
            );
            return;
        }

        $searches = array(
            'Android android', 'Android AndroidHouse Team',
            'Android WildPuzzleROM v8 froyo', 'Android', 'JUC\(Linux;U;',
            'Android OS'
        );

        $this->setCapability(
            'device_os_version',
            $detector->detectVersion($searches)
        );

        if (!$this->getCapability('device_os_version')->getVersion()) {
            if ($this->utils->checkIfContains('android eclair', true)) {
                $this->setCapability(
                    'device_os_version',
                    $detector->setVersion('2.1')
                );
            }

            if ($this->utils->checkIfContains('gingerbread', true)) {
                $this->setCapability(
                    'device_os_version',
                    $detector->setVersion('2.3')
                );
            }
        }
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 44624696;
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
            new Android(),
            new Chrome(),
            new Dalvik(),
            new Silk(),
            new Dolfin(),
            new NetFrontLifeBrowser(),
            new Googlebot(),
            new Opera(),
            new OperaMini(),
            new OperaMobile(),
            new OperaTablet(),
            new Firefox(),
            new YouWaveAndroidOnPc(),
            new AndroidDownloadManager(),
            new Ucweb(),
            new YaBrowser(),
            new MqqBrowser(),
            new FlyFlow(),
            new Maxthon()
        );

        $chain = new Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\BrowserHandler $browser
     * @param \BrowserDetector\Detector\EngineHandler  $engine
     * @param \BrowserDetector\Detector\DeviceHandler  $device
     *
     * @return \BrowserDetector\Detector\Os\AndroidOs
     */
    public function detectDependProperties(
        BrowserHandler $browser, EngineHandler $engine, DeviceHandler $device
    ) {
        parent::detectDependProperties($browser, $engine, $device);

        if (!$device->getCapability('device_type')->isTablet()) {
            $engine->setCapability('xhtml_send_mms_string', 'mms:');
            $engine->setCapability('xhtml_send_sms_string', 'sms:');
        }

        $engine->setCapability('bmp', false);
        $engine->setCapability('wbmp', true);
        $engine->setCapability('gif_animated', false);
        $engine->setCapability('transparent_png_index', true);
        $engine->setCapability('transparent_png_alpha', true);
        $engine->setCapability('wml_make_phone_call_string', 'wtai://wp/mc;');
        $engine->setCapability('max_url_length_in_requests', 256);
        $engine->setCapability('ajax_preferred_geoloc_api', 'w3c_api');
        $engine->setCapability('xhtml_preferred_charset', 'iso-8859-1');
        $engine->setCapability('card_title_support', true);
        $engine->setCapability('table_support', true);
        $engine->setCapability('elective_forms_recommended', true);
        $engine->setCapability('menu_with_list_of_links_recommended', true);
        $engine->setCapability('break_list_of_links_with_br_element_recommended', true);

        if ('Android Webkit' == $browser->getCapability('mobile_browser')) {
            $engine->setCapability('is_sencha_touch_ok', false);
        }

        if ($this->utils->checkIfContains(array('(Linux; U;', 'Linux x86_64;', 'Mac OS X'))
            && !$this->utils->checkIfContains('Android')
        ) {
            $browser->setCapability('mobile_browser_modus', 'Desktop Mode');
        }

        return $this;
    }
}