<?php
namespace BrowserDetector\Detector\Device\Mobile\Nokia;

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
use BrowserDetector\Detector\EngineHandler;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Os\Symbianos;
use BrowserDetector\Detector\OsHandler;
use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Detector\Version;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class NokiaC700
    extends DeviceHandler
    implements MatcherInterface, DeviceInterface
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
     * @return \BrowserDetector\Detector\Device\Mobile\Nokia\NokiaC700
     */
    public function __construct()
    {
        parent::__construct();

        $this->properties = array(
            'wurflKey'                => 'nokia_c7_00_ver1_subuaseries53', // not in wurfl

            // kind of device
            'device_type'             => new DeviceType\MobilePhone(), // not in wurfl

            // device
            'model_name'              => 'C7-00',
            'model_version'           => null, // not in wurfl
            'manufacturer_name'       => new Company\Nokia(),
            'brand_name'              => new Company\Nokia(),
            'model_extra_info'        => null,
            'marketing_name'          => 'Astound',
            'has_qwerty_keyboard'     => true,
            'pointing_method'         => 'touchscreen',
            'device_bits'             => null, // not in wurfl
            'device_cpu'              => null, // not in wurfl

            // product info
            'can_assign_phone_number' => true,
            'ununiqueness_handler'    => null,
            'uaprof'                  => 'http://nds1.nds.nokia.com/uaprof/NC7-00r100.xml',
            'uaprof2'                 => 'http://nds1.nds.nokia.com/uaprof/NC7-00r100-VF3G.xml',
            'uaprof3'                 => 'http://nds1.nds.nokia.com/uaprof/NC7-00r310.xml',
            'unique'                  => true,

            // display
            'physical_screen_width'   => 44,
            'physical_screen_height'  => 78,
            'columns'                 => 17,
            'rows'                    => 13,
            'max_image_width'         => 360,
            'max_image_height'        => 620,
            'resolution_width'        => 360,
            'resolution_height'       => 640,
            'dual_orientation'        => true,
            'colors'                  => 16777216, // wurflkey: nokia_c7_00_ver1_subbrowserng73

            // sms
            'sms_enabled'             => true,

            // chips
            'nfc_support'             => true,
        );
    }

    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains('NokiaC7-00')) {
            return false;
        }

        return true;
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 3;
    }

    /**
     * detects the device name from the given user agent
     *
     * @return \BrowserDetector\Detector\Device\Mobile\Nokia\NokiaC700
     */
    public function detectDevice()
    {
        return $this;
    }

    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return \BrowserDetector\Detector\Os\Symbianos
     */
    public function detectOs()
    {
        $handler = new Symbianos();
        $handler->setUseragent($this->_useragent);

        return $handler;
    }

    /**
     * detects properties who are depending on the browser, the rendering engine
     * or the operating system
     *
     * @param \BrowserDetector\Detector\BrowserHandler $browser
     * @param \BrowserDetector\Detector\EngineHandler  $engine
     * @param \BrowserDetector\Detector\OsHandler      $os
     *
     * @return \BrowserDetector\Detector\Device\Mobile\Nokia\NokiaC700
     */
    public function detectDependProperties(
        BrowserHandler $browser, EngineHandler $engine, OsHandler $os
    ) {
        parent::detectDependProperties($browser, $engine, $os);

        $browserVersion = $browser->getCapability('mobile_browser_version')->getVersion(
            Version::MAJORMINOR
        );

        if (!$this->utils->checkIfContains(array('Series60/5.3'))) {
            $this->setCapability('wurflKey', 'nokia_c7_00_ver1_subuaseries53');
            // $this->setCapability('colors', 16777216);
        } elseif (7.3 == (float)$browserVersion) {
            $this->setCapability('wurflKey', 'nokia_c7_00_ver1_subbrowserng73');
            $this->setCapability('colors', 16777216);
        }

        return $this;
    }
}