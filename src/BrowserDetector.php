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

namespace BrowserDetector;

use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Device\UnknownDevice;
use BrowserDetector\Detector\Engine\UnknownEngine;
use BrowserDetector\Detector\Factory\BrowserFactory;
use BrowserDetector\Detector\Factory\DeviceFactory;
use BrowserDetector\Detector\Factory\EngineFactory;
use BrowserDetector\Detector\Factory\PlatformFactory;
use BrowserDetector\Detector\Factory\RegexFactory;
use BrowserDetector\Detector\Os\UnknownOs;
use BrowserDetector\Matcher\Browser\BrowserHasSpecificEngineInterface;
use BrowserDetector\Matcher\Device\DeviceHasSpecificPlatformInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use UaNormalizer\Generic\BabelFish;
use UaNormalizer\Generic\EncryptionRemover;
use UaNormalizer\Generic\IISLogging;
use UaNormalizer\Generic\KhtmlGecko;
use UaNormalizer\Generic\LocaleRemover;
use UaNormalizer\Generic\Mozilla;
use UaNormalizer\Generic\NovarraGoogleTranslator;
use UaNormalizer\Generic\SerialNumbers;
use UaNormalizer\Generic\TransferEncoding;
use UaNormalizer\Generic\YesWAP;
use UaNormalizer\UserAgentNormalizer;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;
use UnexpectedValueException;
use Wurfl\Request\GenericRequest;
use Wurfl\Request\GenericRequestFactory;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Browser Detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserDetector
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
     * sets the cache used to make the detection faster
     *
     * @param \Psr\Cache\CacheItemPoolInterface $cache
     * @param \Psr\Log\LoggerInterface          $logger (optional) Logger
     */
    public function __construct(CacheItemPoolInterface $cache, LoggerInterface $logger = null)
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
    public function getBrowser($request)
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

        $cacheId   = hash('sha512', $request->getDeviceUserAgent() . '||||' . $request->getBrowserUserAgent());
        $result    = null;
        $cacheItem = $this->cache->getItem($cacheId);

        if ($cacheItem->isHit()) {
            $result = $cacheItem->get();
        }

        if (!($result instanceof ResultInterface)) {
            $result = $this->buildResult($request);

            $cacheItem->set($result);
            $this->cache->save($cacheItem);
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
        $normalizer = new UserAgentNormalizer(
            [
                new BabelFish(),
                new IISLogging(),
                new LocaleRemover(),
                new EncryptionRemover(),
                new Mozilla(),
                new KhtmlGecko(),
                new NovarraGoogleTranslator(),
                new SerialNumbers(),
                new TransferEncoding(),
                new YesWAP(),
            ]
        );

        $deviceUa = $normalizer->normalize($request->getDeviceUserAgent());

        $rexgexFactory = new RegexFactory();
        if (null !== $rexgexFactory->detect($deviceUa)) {
            // @todo: extract device data

            $device = new UnknownDevice($deviceUa);
        } else {
            $device = DeviceFactory::detect($deviceUa);
        }

        $browserUa = $normalizer->normalize($request->getBrowserUserAgent());

        if (null !== $rexgexFactory->detect($browserUa)) {
            // @todo: extract browser/engine/os data

            $platform = new UnknownOs($browserUa);
            $browser  = new UnknownBrowser($browserUa);
            $engine   = new UnknownEngine($browserUa);
        } else {
            if ($device instanceof DeviceHasSpecificPlatformInterface) {
                $platform = $device->detectOs();
            } else {
                $platform = null;
            }

            if (null === $platform) {
                // detect the os which runs on the device
                $platform = PlatformFactory::detect($browserUa);
            }

            // detect the browser which is used
            $browser = BrowserFactory::detect($browserUa, $platform);

            // detect the engine which is used in the browser
            if ($browser instanceof BrowserHasSpecificEngineInterface) {
                $engine = $browser->getEngine();
            } else {
                $engine = null;
            }

            if (null === $engine) {
                $engine = EngineFactory::detect($browserUa, $platform);
            }
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
