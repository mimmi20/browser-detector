<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Device\Mobile\TrekStor;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\AbstractDevice;
use BrowserDetector\Detector\Os;
use UaDeviceType;
use UaHelper\Utils;
use UaMatcher\Device\DeviceHasSpecificPlatformInterface;
use UaMatcher\MatcherCanHandleInterface;
use UaMatcher\MatcherHasWeightInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class TrekStorSt70104 extends AbstractDevice implements DeviceHasSpecificPlatformInterface, MatcherHasWeightInterface, MatcherCanHandleInterface
{
    /**
     * the class constructor
     *
     * @param string $useragent
     * @param array  $data
     */
    public function __construct(
        $useragent,
        array $data
    ) {
        $this->useragent = $useragent;

        $this->setData(
            [
                'deviceName'        => 'ST70104',
                'marketingName'     => 'SurfTab Breeze 7.0',
                'version'           => null,
                'manufacturer'      => (new Company\TrekStor())->name,
                'brand'             => (new Company\TrekStor())->brandname,
                'formFactor'        => null,
                'pointingMethod'    => 'touchscreen',
                'resolutionWidth'   => 480,
                'resolutionHeight'  => 800,
                'dualOrientation'   => false,
                'colors'            => 65536,
                'smsSupport'        => true,
                'nfcSupport'        => true,
                'hasQwertyKeyboard' => true,
                'type'              => new UaDeviceType\MobilePhone(),
            ]
        );
    }

    /**
     * checks if this device is able to handle the useragent
     *
     * @return bool returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        $trekStorPhones = ['ST70104'];

        if ($this->utils->checkIfContains($trekStorPhones)) {
            return true;
        }

        return false;
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return int
     */
    public function getWeight()
    {
        return 70634;
    }

    /**
     * returns the OS Handler
     *
     * @return \BrowserDetector\Detector\Os\AndroidOs
     */
    public function detectOs()
    {
        return new Os\AndroidOs($this->useragent, []);
    }
}
