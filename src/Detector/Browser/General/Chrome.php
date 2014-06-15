<?php
namespace BrowserDetector\Detector\Browser\General;

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

use BrowserDetector\Detector\BrowserHandler;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\Engine\Blink;
use BrowserDetector\Detector\Engine\Webkit;
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\BrowserInterface;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class Chrome
    extends BrowserHandler
    implements MatcherInterface, BrowserInterface
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
     * @return \BrowserDetector\Detector\Browser\General\Chrome
     */
    public function __construct()
    {
        parent::__construct();

        $this->properties = array(
            // kind of device
            'browser_type'                 => new BrowserType\Browser(), // not in wurfl

            // browser
            'mobile_browser'               => 'Chrome',
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
    }

    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains(array('Mozilla/', 'Chrome/', 'CrMo/'))) {
            return false;
        }

        if (!$this->utils->checkIfContains(array('Chrome', 'CrMo', 'CriOS'))) {
            return false;
        }

        $isNotReallyAnChrome = array(
            // using also the KHTML rendering engine
            'Arora',
            'Chromium',
            'Comodo Dragon',
            'Flock',
            'Galeon',
            'Google Earth',
            'Iron',
            'Lunascape',
            'Maemo',
            'Maxthon',
            'Midori',
            'OPR',
            'PaleMoon',
            'RockMelt',
            'YaBrowser',
            // Bots trying to be a Chrome
            'PagePeeker',
            // Fakes
            'Mac; Mac OS '
        );

        if ($this->utils->checkIfContains($isNotReallyAnChrome)) {
            return false;
        }

        $detector = new Version();
        $detector->setUserAgent($this->useragent);
        $detector->detectVersion(array('Chrome'));

        if (0 != $detector->getVersion(Version::MINORONLY)) {
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
        return 'unknown';
    }

    /**
     * gets the maker of the browser
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Google();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Type\Device\TypeInterface
     */
    public function getBrowserType()
    {
        return new BrowserType\Unknown();
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
        $detector->setMode(Version::COMPLETE | Version::IGNORE_MICRO);

        $searches = array('Chrome', 'CrMo', 'CriOS');

        return $detector->detectVersion($searches);
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 116398328;
    }

    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return \BrowserDetector\Detector\MatcherInterface\EngineInterface
     */
    public function detectEngine()
    {
        $version = $this->detectVersion()->getVersion(Version::MAJORONLY);

        if ($version >= 28) {
            $engine = new Blink();
        } else {
            $engine = new Webkit();
        }

        $engine->setUseragent($this->useragent);
        return $engine;
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\EngineHandler $engine
     * @param \BrowserDetector\Detector\OsHandler     $os
     * @param \BrowserDetector\Detector\DeviceHandler $device
     *
     * @return \BrowserDetector\Detector\Browser\General\Chrome
     */
    public function detectDependProperties(
        EngineHandler $engine, OsHandler $os, DeviceHandler $device
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

        return $this;
    }
}