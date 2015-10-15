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

use BrowserDetector\Detector\Company;
use UaResult\Version;
use UaMatcher\Browser\BrowserInterface;
use UaMatcher\Device\DeviceInterface;
use UaMatcher\Engine\EngineInterface;
use UaMatcher\Os\OsChangesBrowserInterface;
use UaMatcher\Os\OsChangesEngineInterface;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class AndroidOs extends AbstractOs implements OsChangesEngineInterface, OsChangesBrowserInterface
{
    /**
     * returns the name of the operating system/platform
     *
     * @return string
     */
    public function getName()
    {
        return 'Android';
    }

    /**
     * returns the version of the operating system/platform
     *
     * @return \UaResult\Version
     */
    public function detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->useragent);

        if ($this->utils->checkIfContains('android 2.1-update1', true)) {
            return $detector->setVersion('2.1.1');
        }

        $searches = array(
            'Android android',
            'Android AndroidHouse Team',
            'Android WildPuzzleROM v8 froyo',
            'Android',
            'JUC\(Linux;U;',
            'Android OS'
        );

        $detector->detectVersion($searches);

        if (!$detector->getVersion()) {
            if ($this->utils->checkIfContains('android eclair', true)) {
                $detector->setVersion('2.1');
            }

            if ($this->utils->checkIfContains('gingerbread', true)) {
                $detector->setVersion('2.3');
            }
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
        return new Company\Google();
    }

    /**
     * changes properties of the browser depending on properties of the Os
     *
     * @param \UaMatcher\Browser\BrowserInterface $browser
     *
     * @return \BrowserDetector\Detector\Os\AndroidOs
     */
    public function changeBrowserProperties(BrowserInterface $browser)
    {
        if ($this->utils->checkIfContains(
            array('(Linux; U;', 'Linux x86_64;', 'Mac OS X')
        ) && !$this->utils->checkIfContains('Android')
        ) {
            $browser->setCapability('mobile_browser_modus', 'Desktop Mode');
        }

        return $this;
    }

    /**
     * changes properties of the engine depending on browser properties and depending on properties of the Os
     *
     * @param \UaMatcher\Engine\EngineInterface   $engine
     * @param \UaMatcher\Browser\BrowserInterface $browser
     * @param \UaMatcher\Device\DeviceInterface   $device
     *
     * @return \BrowserDetector\Detector\Os\AndroidOs
     */
    public function changeEngineProperties(EngineInterface $engine, BrowserInterface $browser, DeviceInterface $device)
    {
        if (!$device->getDeviceType()->isTablet()) {
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

        if ('Android Webkit' == $browser->getName()) {
            $engine->setCapability('is_sencha_touch_ok', false);
        }

        return $this;
    }
}
