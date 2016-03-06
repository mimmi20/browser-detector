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
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Device\UnknownDevice;
use BrowserDetector\Detector\Factory\Device\DesktopFactory;
use BrowserDetector\Detector\Factory\Device\MobileFactory;
use BrowserDetector\Detector\Factory\Device\TvFactory;
use BrowserDetector\Helper\Desktop;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Tv as TvHelper;
use Psr\Log\LoggerInterface;
use UaMatcher\Device\DeviceHasChildrenInterface;

/**
 * Device detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DeviceFactory implements FactoryInterface
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $agent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public static function detect($agent)
    {
        if ((new MobileDevice($agent))->isMobile()) {
            $device = MobileFactory::detect($agent);
        } elseif ((new TvHelper($agent))->isTvDevice()) {
            $device = TvFactory::detect($agent);
        } elseif ((new Desktop($agent))->isDesktopDevice()) {
            $device = DesktopFactory::detect($agent);
        } else {
            $device = new UnknownDevice($agent, []);
        }

        if ($device instanceof DeviceHasChildrenInterface) {
            $device = $device->detectDevice();
        }

        return $device;
    }
}
