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

namespace BrowserDetector;

use BrowserDetector\Factory\NormalizerFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetector\Loader\PlatformLoader;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use UaResult\Result\Result;
use UnexpectedValueException;
use Wurfl\Request\GenericRequest;
use Wurfl\Request\GenericRequestFactory;

/**
 * Browser Detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Detector
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
     * @var \UaNormalizer\UserAgentNormalizer
     */
    private $normalizer = null;

    /**
     * @var \BrowserDetector\Factory\RegexFactory
     */
    private $regexFactory = null;

    /**
     * @var null
     */
    private $deviceFactory = null;

    /**
     * sets the cache used to make the detection faster
     *
     * @param \Psr\Cache\CacheItemPoolInterface $cache
     * @param \Psr\Log\LoggerInterface          $logger
     */
    public function __construct(CacheItemPoolInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
    }

    /**
     * @return \UaNormalizer\UserAgentNormalizer
     */
    public function getNormalizer()
    {
        if (null === $this->normalizer) {
            $this->normalizer = (new NormalizerFactory())->build();
        }

        return $this->normalizer;
    }

    /**
     * @return \BrowserDetector\Factory\RegexFactory
     */
    public function getRegexFactory()
    {
        if (null === $this->regexFactory) {
            $this->regexFactory = new Factory\RegexFactory($this->cache, $this->logger);
        }

        return $this->regexFactory;
    }

    /**
     * @return \BrowserDetector\Factory\DeviceFactory
     */
    public function getDeviceFactory()
    {
        if (null === $this->deviceFactory) {
            $this->deviceFactory = new Factory\DeviceFactory($this->cache, new DeviceLoader($this->cache));
        }

        return $this->deviceFactory;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string|array|\Wurfl\Request\GenericRequest $request
     *
     * @return \UaResult\Result\Result
     */
    public function getBrowser($request)
    {
        if (!($request instanceof GenericRequest)) {
            $request = $this->buildRequest($request);
        }

        $regexFactory  = $this->getRegexFactory();
        $deviceFactory = $this->getDeviceFactory();
        $deviceUa      = $this->getNormalizer()->normalize($request->getDeviceUserAgent());

        /** @var \UaResult\Device\DeviceInterface $device */
        /** @var \UaResult\Os\OsInterface $platform */
        list($device, $platform) = (new Detector\Device($this->cache, $this->logger, $regexFactory, $deviceFactory))->detect($deviceUa);

        $browserUa = $this->getNormalizer()->normalize($request->getBrowserUserAgent());

        if (null === $platform || in_array($platform->getName(), [null, 'unknown'])) {
            $platformFactory = new PlatformFactory($this->cache, new PlatformLoader($this->cache));
            $platform        = (new Detector\Os($this->cache, $this->logger, $regexFactory, $platformFactory))->detect($browserUa);
        }

        /** @var \UaResult\Browser\BrowserInterface $browser */
        /** @var \UaResult\Engine\EngineInterface $engine */
        list($browser, $engine) = (new Factory\BrowserFactory($this->cache, new Loader\BrowserLoader($this->cache)))->detect($browserUa, $platform);
        $engineLoader           = new Loader\EngineLoader($this->cache);

        if (null !== $platform && in_array($platform->getName(), ['iOS'])) {
            $this->logger->debug('engine forced to "webkit" on iOS');
            $engine = $engineLoader->load('webkit', $browserUa);
        } elseif (null === $engine || in_array($engine->getName(), [null, 'unknown'])) {
            $this->logger->debug('engine not detected from browser');
            $engine = (new Factory\EngineFactory($this->cache, $engineLoader))->detect($browserUa);
        }

        return new Result(
            $request,
            $device,
            $platform,
            $browser,
            $engine
        );
    }

    /**
     * @param $request
     *
     * @throws \UnexpectedValueException
     * @return \Wurfl\Request\GenericRequest
     */
    private function buildRequest($request)
    {
        $requestFactory = new GenericRequestFactory();

        if (is_string($request)) {
            $this->logger->debug('request object created from string');

            return $requestFactory->createRequestForUserAgent($request);
        }

        if (is_array($request)) {
            $this->logger->debug('request object created from array');

            return $requestFactory->createRequest($request);
        }

        throw new UnexpectedValueException(
            'the request parameter has to be a string, an array or an instance of \Wurfl\Request\GenericRequest'
        );
    }
}
