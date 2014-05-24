<?php
namespace BrowserDetector\Detector\Browser\Desktop;

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

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\Type\Browser as BrowserType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class MicrosoftOutlook extends MicrosoftOffice
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
     * @return \BrowserDetector\Detector\Browser\Desktop\MicrosoftOutlook
     */
    public function __construct()
    {
        parent::__construct();

        $this->properties = array(
            // kind of device
            'browser_type'                 => new BrowserType\EmailClient(), // not in wurfl

            // browser
            'mobile_browser'               => 'Outlook',
            'mobile_browser_version'       => null,
            'mobile_browser_bits'          => null, // not in wurfl
            'mobile_browser_manufacturer'  => new Company\Microsoft(), // not in wurfl
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
        if (!$this->utils->checkIfContains(array('Outlook', 'microsoft Office', 'MSOffice'))) {
            return false;
        }

        $isNotReallyAnIE = array(
            // using also the Trident rendering engine
            'Maxthon',
            'Galeon',
            'Lunascape',
            'Opera',
            'PaleMoon',
            'Flock',
            'AOL',
            'TOB',
            'MyIE',
            'Excel',
            'Word',
            'PowerPoint',
            //others
            'AppleWebKit',
            'Chrome',
            'Linux',
            'IEMobile',
            'BlackBerry',
            'WebTV',
            // Outlook Express
            'Outlook-Express'
        );

        if ($this->utils->checkIfContains($isNotReallyAnIE)) {
            return false;
        }

        return true;
    }

    /**
     * detects the browser version from the given user agent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $detector = new Version();
        $detector->setUserAgent($this->useragent);
        $detector->setMode(Version::COMPLETE | Version::IGNORE_MINOR);

        $doMatch = preg_match(
            '/microsoft Office Outlook ([\d\.]+)/', $this->useragent, $matches
        );

        if ($doMatch) {
            $this->setCapability(
                'mobile_browser_version',
                $detector->setVersion($this->_mapVersion($matches[1]))
            );
            return $this;
        }

        $doMatch = preg_match(
            '/microsoft Office Outlook (\d+)/', $this->useragent, $matches
        );

        if ($doMatch) {
            $this->setCapability(
                'mobile_browser_version',
                $detector->setVersion($this->_mapVersion($matches[1]))
            );
            return $this;
        }

        $doMatch = preg_match(
            '/microsoft Outlook ([\d\.]+)/', $this->useragent, $matches
        );

        if ($doMatch) {
            $this->setCapability(
                'mobile_browser_version',
                $detector->setVersion($this->_mapVersion($matches[1]))
            );
            return $this;
        }

        $doMatch = preg_match(
            '/microsoft Outlook (\d+)/', $this->useragent, $matches
        );

        if ($doMatch) {
            $this->setCapability(
                'mobile_browser_version',
                $detector->setVersion($this->_mapVersion($matches[1]))
            );
            return $this;
        }

        parent::_detectVersion();

        return $this;
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 2839566;
    }
}