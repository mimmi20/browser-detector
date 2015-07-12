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

namespace BrowserDetector;

use BrowserDetector\Detector\Factory\BrowserFactory;
use BrowserDetector\Detector\Factory\DeviceFactory;
use BrowserDetector\Detector\Factory\EngineFactory;
use BrowserDetector\Detector\Factory\PlatformFactory;
use BrowserDetector\Detector\MatcherInterface\Device\DeviceHasRuntimeModificationsInterface;
use BrowserDetector\Detector\MatcherInterface\Device\DeviceHasVersionInterface;
use BrowserDetector\Detector\MatcherInterface\Os\OsChangesBrowserInterface;
use BrowserDetector\Detector\MatcherInterface\Os\OsChangesEngineInterface;
use BrowserDetector\Detector\Result;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use UnexpectedValueException;
use Wurfl\Request\GenericRequest;
use Wurfl\Request\GenericRequestFactory;
use WurflCache\Adapter\AdapterInterface;

/**
 * Browser Detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserDetector
{
    const INTERFACE_INTERNAL     = 1;
    const INTERFACE_BROWSCAP_INI = 2;
    const INTERFACE_WURFL_FILE   = 3;
    const INTERFACE_WURFL_CLOUD  = 4;
    const INTERFACE_UAPARSER     = 5;
    const INTERFACE_UASPARSER    = 6;
    const INTERFACE_BROWSCAP_CROSSJOIN = 7;

    /**
     * a \WurflCache\Adapter\AdapterInterface object
     *
     * @var \WurflCache\Adapter\AdapterInterface
     */
    private $cache = null;

    /**
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger = null;

    /**
     * sets the cache used to make the detection faster
     *
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @return \BrowserDetector\BrowserDetector
     */
    public function setCache(AdapterInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * returns the actual Cache Adapter
     *
     * @return \WurflCache\Adapter\AdapterInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * sets the logger
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \BrowserDetector\BrowserDetector
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * returns the logger
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        if (null === $this->logger) {
            $this->logger = new NullLogger();
        }

        return $this->logger;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string|array|\Wurfl\Request\GenericRequest $request
     * @param boolean                                    $forceDetect if TRUE a possible cache hit is ignored
     *
     * @return \BrowserDetector\Detector\Result
     */
    public function getBrowser($request = null, $forceDetect = false)
    {
        if (null === $request) {
            throw new UnexpectedValueException(
                'You have to call this function with the useragent parameter'
            );
        }

        $requestFactory = new GenericRequestFactory();

        if (is_string($request)) {
            $request = $requestFactory->createRequestForUserAgent($request);
        } elseif (is_array($request)) {
            $request = $requestFactory->createRequest($request);
        }

        if (!($request instanceof GenericRequest)) {
            throw new UnexpectedValueException(
                'the useragent parameter has to be a string, an array or an instance of \Wurfl\Request\GenericRequest'
            );
        }

        $cacheId = hash('sha512', $request->getDeviceUserAgent() . '||||' . $request->getBrowserUserAgent());
        $result  = null;
        $success = false;

        if (!$forceDetect && null !== $this->getCache()) {
            $result = $this->getCache()->getItem($cacheId, $success);
        }

        if ($forceDetect || null === $this->getCache() || !$success || !($result instanceof Detector\Result)) {
            $device = DeviceFactory::detect($request->getDeviceUserAgent());

            if (null !== $this->getLogger()) {
                $device->setLogger($this->getLogger());
            }

            if ($device instanceof DeviceHasVersionInterface) {
                $device->detectDeviceVersion();
            }

            if ($device instanceof DeviceHasRuntimeModificationsInterface) {
                $device->detectSpecialProperties();
            }

            // detect the os which runs on the device
            $platform = PlatformFactory::detect($request->getBrowserUserAgent());

            // detect the browser which is used
            $browser = BrowserFactory::detect($request->getBrowserUserAgent(), $this->getCache());

            // detect the engine which is used in the browser
            $engine = EngineFactory::detect($request->getBrowserUserAgent(), $platform);

            if ($platform instanceof OsChangesEngineInterface) {
                $platform->changeEngineProperties($engine, $browser, $device);
            }

            if ($platform instanceof OsChangesBrowserInterface) {
                $platform->changeBrowserProperties($browser);
            }

            // @todo: set engine related properties to the browser, define an interface for that
            // @todo: set browser related properties to the device, define an interface for that

            $result = new Result();

            if (null !== $this->getLogger()) {
                $result->setLogger($this->getLogger());
            }

            $result->setCapability('useragent', $request->getUserAgent());

            $result->setDetectionResult(
                $device,
                $platform,
                $browser,
                $engine
            );

            if (!$forceDetect && null !== $this->getCache()) {
                $this->getCache()->setItem($cacheId, $result);
            }
        }

        return $result;
    }
}

