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

namespace BrowserDetector;

use BrowserDetector\Detector\Factory\BrowserFactory;
use BrowserDetector\Detector\Factory\DeviceFactory;
use BrowserDetector\Detector\Factory\EngineFactory;
use BrowserDetector\Detector\Factory\PlatformFactory;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use UaMatcher\Browser\BrowserCalculatesAlternativeResultInterface;
use UaMatcher\Browser\BrowserDependsOnEngineInterface;
use UaMatcher\Browser\BrowserHasRuntimeModificationsInterface;
use UaMatcher\Device\DeviceHasRuntimeModificationsInterface;
use UaMatcher\Device\DeviceHasSpecificPlatformInterface;
use UaMatcher\Engine\EngineDependsOnDeviceInterface;
use UaMatcher\Os\OsChangesBrowserInterface;
use UaMatcher\Os\OsChangesEngineInterface;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;
use UnexpectedValueException;
use Wurfl\Request\GenericRequest;
use Wurfl\Request\GenericRequestFactory;
use WurflCache\Adapter\AdapterInterface;

/**
 * Browser Detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserDetector
{
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
     * @param \Psr\Log\LoggerInterface             $logger
     */
    public function __construct(AdapterInterface $cache, LoggerInterface $logger = null)
    {
        $this->cache = $cache;

        if (null === $logger) {
            $logger = new NullLogger();
        }

        $this->logger = $logger;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string|array|\Wurfl\Request\GenericRequest $request
     *
     * @return \UaResult\Result\Result
     */
    public function getBrowser($request = null)
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

        $result = $this->cache->getItem($cacheId, $success);

        if (!$success || !($result instanceof ResultInterface)) {
            $result = $this->buildResult($request);

            $this->cache->setItem($cacheId, $result);
        }

        return $result;
    }

    /**
     * @param \Wurfl\Request\GenericRequest $request
     *
     * @return \UaResult\Result\ResultInterface
     */
    private function buildResult(GenericRequest $request)
    {
        $device = DeviceFactory::detect($request->getDeviceUserAgent());

        //if ($device instanceof DeviceHasRuntimeModificationsInterface) {
        //    $device->detectSpecialProperties();
        //}

        if ($device instanceof DeviceHasSpecificPlatformInterface) {
            $platform = $device->detectOs();
        } else {
            // detect the os which runs on the device
            $platform = PlatformFactory::detect($request->getBrowserUserAgent(), $this->logger);
        }

        // detect the browser which is used
        $browser = BrowserFactory::detect($request->getBrowserUserAgent(), $platform, $this->logger, $this->cache);

        if ($browser instanceof BrowserHasRuntimeModificationsInterface) {
            $browser->detectSpecialProperties();
        }

        if ($browser instanceof BrowserCalculatesAlternativeResultInterface) {
            $browser->calculateAlternativeRendering($device);
        }

        // detect the engine which is used in the browser
        $engine = EngineFactory::detect($request->getBrowserUserAgent(), $this->logger, $platform);

        if ($browser instanceof BrowserDependsOnEngineInterface) {
            $browser->detectDependProperties($engine);
        }

        if ($engine instanceof EngineDependsOnDeviceInterface) {
            $engine->detectDependProperties($device);
        }

        if ($platform instanceof OsChangesEngineInterface) {
            $platform->changeEngineProperties($engine, $browser, $device);
        }

        if ($platform instanceof OsChangesBrowserInterface) {
            $platform->changeBrowserProperties($browser);
        }

        return new Result(
            $request->getUserAgent(),
            $device,
            $platform,
            $browser,
            $engine
        );
    }
}
