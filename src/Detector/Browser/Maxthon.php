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

namespace BrowserDetector\Detector\Browser;


use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\AbstractDevice;
use BrowserDetector\Detector\Engine\Blink;
use BrowserDetector\Detector\Engine\Gecko;
use BrowserDetector\Detector\Engine\Trident;
use BrowserDetector\Detector\Engine\UnknownEngine;
use BrowserDetector\Detector\Engine\Webkit;
use BrowserDetector\Detector\AbstractEngine;

use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Maxthon
    extends AbstractBrowser
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        // browser
        'wurflKey'                     => null, // not in wurfl
        'mobile_browser_modus'         => null, // not in wurfl

        // product info
        'can_skip_aligned_link_row'    => true,
        'device_claims_web_support'    => true,
        // pdf
        'pdf_support'                  => true,
        // bugs
        'empty_option_value_support'   => true,
        'basic_authentication_support' => true,
        'post_method_support'          => true,
        // rss
        'rss_support'                  => false,
    );

    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains('Mozilla/')) {
            return false;
        }

        if (!$this->utils->checkIfContains(array('maxthon', 'myie', 'mxbrowser'), true)) {
            return false;
        }

        $isNotReallyAnMaxthon = array(
            // using also the Trident rendering engine
            'Crazy Browser',
            'Galeon',
            'Lunascape',
            'Opera',
            'PaleMoon',
            'Flock',
            // other Browsers
            'MSOffice',
            'Outlook',
            'IEMobile',
            'BlackBerry',
            'WebTV',
            'ArgClrInt',
            'Firefox'
        );

        if ($this->utils->checkIfContains($isNotReallyAnMaxthon)) {
            return false;
        }

        return true;
    }

    /**
     * gets the name of the browser
     *
     * @return string
     */
    public function getName()
    {
        return 'Maxthon';
    }

    /**
     * gets the maker of the browser
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Maxthon();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Type\Device\TypeInterface
     */
    public function getBrowserType()
    {
        return new BrowserType\Browser();
    }

    /**
     * detects the browser version from the given user agent
     *
     * @return \BrowserDetector\Detector\Version
     */
    public function detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->useragent);

        if (false !== strpos($this->useragent, 'MyIE2')) {
            return $detector->setVersion('2.0');
        }

        if (false !== strpos($this->useragent, 'MyIE')) {
            return $detector->setVersion('1.0');
        }

        $detector->setDefaulVersion('2.0');

        $searches = array('Maxthon', 'MxBrowser', 'Version');

        return $detector->detectVersion($searches);
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 497330;
    }

    /**
     * returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\MatcherInterface\EngineInterface
     */
    public function detectEngine()
    {
        if (false !== strpos($this->useragent, 'Trident') || false !== strpos($this->useragent, 'MSIE')) {
            $engine = new Trident();
        } elseif (false !== strpos($this->useragent, 'WebKit')) {
            $chrome = new Chrome();
            $chrome->setUserAgent($this->useragent);

            $chromeVersion = $chrome->detectVersion()->getVersion(Version::MAJORONLY);

            if ($chromeVersion >= 28) {
                $engine = new Blink();
            } else {
                $engine = new Webkit();
            }
        } elseif (false !== strpos($this->useragent, 'Gecko')) {
            $engine = new Gecko();
        } else {
            $engine = new UnknownEngine();
        }

        $engine->setUseragent($this->useragent);

        return $engine;
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\AbstractEngine $engine
     * @param \BrowserDetector\Detector\AbstractOs     $os
     * @param \BrowserDetector\Detector\AbstractDevice $device
     *
     * @return \BrowserDetector\Detector\Browser\General\Chrome
     */
    public function detectDependProperties(
        AbstractEngine $engine,
        AbstractOs $os,
        AbstractDevice $device
    ) {
        parent::detectDependProperties($engine, $os, $device);

        $osname = $os->getName();

        if ('iOS' === $osname) {
            $engine->setCapability('xhtml_format_as_css_property', true);
            $this->setCapability('rss_support', true);
        }

        if ('Android' === $osname) {
            $engine->setCapability('html_wi_imode_compact_generic', false);
            $engine->setCapability('xhtml_avoid_accesskeys', true);
            $engine->setCapability('xhtml_supports_forms_in_table', true);
            $engine->setCapability('xhtml_file_upload', 'supported');
            $engine->setCapability('xhtml_allows_disabled_form_elements', true);
            $engine->setCapability('xhtml_readable_background_color1', '#FFFFFF');
        }

        $chrome = new Chrome();
        $chrome->setUserAgent($this->useragent);

        $chromeVersion = $chrome->detectVersion()->getVersion(Version::MAJORONLY);

        if (!$device->getDeviceType()->isMobile()) {
            $engine->setCapability('xhtml_make_phone_call_string', 'none');
        }

        if ($chromeVersion >= 21) {
            $engine->setCapability('css_gradient', 'webkit');
            $engine->setCapability('css_gradient_linear', 'none');
            $engine->setCapability('css_border_image', 'none');
            $engine->setCapability('css_rounded_corners', 'none');
        }

        if ($chromeVersion >= 26) {
            $engine->setCapability('xhtml_can_embed_video', 'play_and_stop');
            $engine->setCapability('css_gradient', 'css3');
            $engine->setCapability('svgt_1_1', true);
        }

        if ($chromeVersion >= 31) {
            $engine->setCapability('css_gradient_linear', 'css3');
            $engine->setCapability('css_border_image', 'css3');
            $engine->setCapability('css_rounded_corners', 'css3');
        }

        $this->setCapability('wurflKey', 'google_chrome_' . (int)$chromeVersion);
        $engine->setCapability('xhtml_table_support', false);

        return $this;
    }
}
