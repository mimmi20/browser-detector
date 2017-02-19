<?php
/**
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
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
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector;

use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\Regex\NoMatchException;
use BrowserDetector\Factory\RegexFactory;
use BrowserDetector\Loader\NotFoundException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use UaResult\Os\Os;

/**
 * Browser Detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Device
{
    /**
     * a cache object
     *
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    private $cache = null;

    /**
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger = null;

    /**
     * @var \BrowserDetector\Factory\RegexFactory
     */
    private $regexFactory = null;

    /**
     * @var \BrowserDetector\Factory\DeviceFactory
     */
    private $deviceFactory = null;

    /**
     * sets the cache used to make the detection faster
     *
     * @param \Psr\Cache\CacheItemPoolInterface      $cache
     * @param \Psr\Log\LoggerInterface               $logger
     * @param \BrowserDetector\Factory\RegexFactory  $regexFactory
     * @param \BrowserDetector\Factory\DeviceFactory $deviceDactory
     */
    public function __construct(
        CacheItemPoolInterface $cache,
        LoggerInterface $logger,
        RegexFactory $regexFactory,
        DeviceFactory $deviceDactory
    ) {
        $this->cache         = $cache;
        $this->logger        = $logger;
        $this->regexFactory  = $regexFactory;
        $this->deviceFactory = $deviceDactory;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $deviceUa
     *
     * @return array
     */
    public function detect($deviceUa)
    {
        /** @var \UaResult\Device\DeviceInterface $device */
        /** @var \UaResult\Os\OsInterface $platform */
        try {
            $this->regexFactory->detect($deviceUa);

            return $this->regexFactory->getDevice();
        } catch (NotFoundException $e) {
            $this->logger->info($e);
            $device   = null;
            $platform = null;
        } catch (NoMatchException $e) {
            $device   = null;
            $platform = null;
        } catch (\InvalidArgumentException $e) {
            $this->logger->error($e);
            $device   = null;
            $platform = null;
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $device   = null;
            $platform = null;
        }

        $this->logger->debug('device not detected via regexes');

        try {
            return $this->deviceFactory->detect($deviceUa);
        } catch (NotFoundException $e) {
            $this->logger->info($e);
        }

        return [
            new \UaResult\Device\Device(null, null),
            new Os(null, null),
        ];
    }
}
