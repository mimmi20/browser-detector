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

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Os\Symbianos;
use BrowserDetector\Detector\Type\Device as DeviceType;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class Nokia700
    extends DeviceHandler
    implements DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array(
        'wurflKey'                => 'nokia_700_ver1', // not in wurfl

        // device
        'model_name'              => '700',
        'model_extra_info'        => null,
        'marketing_name'          => null,
        'has_qwerty_keyboard'     => false, // wurflkey: nokia_700_ver1_subos53
        'pointing_method'         => 'touchscreen',

        // product info
        'can_assign_phone_number' => true,
        'ununiqueness_handler'    => null,
        'uaprof'                  => 'http://nds1.nds.nokia.com/uaprof/N700r100.xml',
        'uaprof2'                 => 'http://nds1.nds.nokia.com/uaprof/N700r200.xml',
        'uaprof3'                 => null,
        'unique'                  => true,

        // display
        'physical_screen_width'   => 40,
        'physical_screen_height'  => 71,
        'columns'                 => 17,
        'rows'                    => 13,
        'max_image_width'         => 360,
        'max_image_height'        => 580,
        'resolution_width'        => 360,
        'resolution_height'       => 640,
        'dual_orientation'        => true,
        'colors'                  => 16777216,

        // sms
        'sms_enabled'             => true,

        // chips
        'nfc_support'             => true,
    );

    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains('Nokia700')) {
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
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Type\Device\TypeInterface
     */
    public function getDeviceType()
    {
        return new DeviceType\MobilePhone();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getManufacturer()
    {
        return new Company\Nokia();
    }

    /**
     * returns the type of the current device
     *
     * @return \BrowserDetector\Detector\Company\CompanyInterface
     */
    public function getBrand()
    {
        return new Company\Nokia();
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
}