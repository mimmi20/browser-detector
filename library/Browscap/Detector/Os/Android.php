<?php
namespace Browscap\Detector\Os;

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
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */

use \Browscap\Detector\OsHandler;
use \Browscap\Helper\Utils;
use \Browscap\Helper\Safari as SafariHelper;
use \Browscap\Detector\MatcherInterface;
use \Browscap\Detector\MatcherInterface\OsInterface;
use \Browscap\Detector\BrowserHandler;
use \Browscap\Detector\EngineHandler;
use \Browscap\Detector\DeviceHandler;
use \Browscap\Detector\Version;

/**
 * MSIEAgentHandler
 *
 *
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
class Android
    extends OsHandler
    implements MatcherInterface, OsInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $_properties = array(
        'wurflKey' => null, // not in wurfl
        
        // os
        'device_os'              => 'Android',
        'device_os_version'      => '',
        'device_os_bits'         => '', // not in wurfl
        'device_os_manufacturer' => 'Google', // not in wurfl
    );
    
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
            'like Android'
        );
        
        if ($this->_utils->checkIfContains($noAndroid)) {
            return false;
        }
        
        $safariHelper = new SafariHelper();
        $safariHelper->setUserAgent($this->_useragent);
        
        if ($this->_utils->checkIfContains(array('Android', 'Silk', 'JUC(Linux;U;', 'JUC (Linux; U;'))
            || $safariHelper->isMobileAsSafari()
        ) {
            return true;
        }
        
        return false;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $this->_useragent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $detector = new \Browscap\Detector\Version();
        $detector->setUserAgent($this->_useragent);
        
        if ($this->_utils->checkIfContains('android 2.1-update1', true)) {
            $this->setCapability(
                'device_os_version', 
                $detector->setVersion('2.1.1')
            );
            return;
        }
        
        if ($this->_utils->checkIfContains('android eclair', true)) {
            $this->setCapability(
                'device_os_version', 
                $detector->setVersion('2.1')
            );
            return;
        }
        
        $searches = array(
            'Android', 'Android WildPuzzleROM v8 froyo', 
            'Android AndroidHouse Team', 'JUC\(Linux;U;'
        );
        
        $this->setCapability(
            'device_os_version', 
            $detector->detectVersion($searches)
        );
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 648;
    }
    
    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectBrowser()
    {
        $browsers = array(
            new \Browscap\Detector\Browser\Mobile\Android(),
            new \Browscap\Detector\Browser\Mobile\Chrome(),
            new \Browscap\Detector\Browser\Mobile\Dalvik(),
            new \Browscap\Detector\Browser\Mobile\Silk(),
            new \Browscap\Detector\Browser\Mobile\DolfinJasmine(),
            new \Browscap\Detector\Browser\Mobile\NetFrontLifeBrowser(),
            new \Browscap\Detector\Browser\Bot\Googlebot(),
            new \Browscap\Detector\Browser\Mobile\OperaMini(),
            new \Browscap\Detector\Browser\Mobile\OperaMobile(),
            new \Browscap\Detector\Browser\Mobile\OperaTablet(),
            new \Browscap\Detector\Browser\Mobile\Firefox(),
            new \Browscap\Detector\Browser\Desktop\YouWaveAndroidOnPc(),
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new \Browscap\Detector\Browser\Unknown());
        
        return $chain->detect();
    }
    
    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @return DeviceHandler
     */
    public function detectDependProperties(
        BrowserHandler $browser, EngineHandler $engine, DeviceHandler $device)
    {
        parent::detectDependProperties($browser, $engine, $device);
        
        if (!$device->getCapability('is_tablet')) {
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
        $engine->setCapability('ajax_preferred_geoloc_api', 'gears');
        $engine->setCapability('xhtml_preferred_charset', 'iso-8859-1');
        $engine->setCapability('card_title_support', true);
        $engine->setCapability('table_support', true);
        $engine->setCapability('elective_forms_recommended', true);
        $engine->setCapability('menu_with_list_of_links_recommended', true);
        $engine->setCapability('break_list_of_links_with_br_element_recommended', true);
        
        if ('Android Webkit' == $browser->getCapability('mobile_browser')) {
            $engine->setCapability('is_sencha_touch_ok', false);
        }
        
        if ($this->_utils->checkIfContains(array('(Linux; U;', 'Linux x86_64;', 'Mac OS X'))
            && !$this->_utils->checkIfContains('Android')
        ) {
            $browser->setCapability('mobile_browser_modus', 'Desktop Mode');
        }
        
        return $this;
    }
}