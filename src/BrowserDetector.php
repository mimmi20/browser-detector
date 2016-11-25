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

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use UaNormalizer\Generic;
use UaNormalizer\UserAgentNormalizer;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;
use UnexpectedValueException;
use Wurfl\Request\GenericRequest;
use Wurfl\Request\GenericRequestFactory;

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
                'You have to call this function with the request parameter'
            );
        }

        $requestFactory = new GenericRequestFactory();

        if (is_string($request)) {
            $this->logger->debug('request object created from string');
            $request = $requestFactory->createRequestForUserAgent($request);
        } elseif (is_array($request)) {
            $this->logger->debug('request object created from array');
            $request = $requestFactory->createRequest($request);
        }

        if (!($request instanceof GenericRequest)) {
            throw new UnexpectedValueException(
                'the useragent parameter has to be a string, an array or an instance of \Wurfl\Request\GenericRequest'
            );
        }

        $cacheId   = hash('sha512', $request->getDeviceUserAgent() . '||||' . $request->getBrowserUserAgent());
        $result    = null;
        //$cacheItem = $this->cache->getItem($cacheId);

        //if ($cacheItem->isHit()) {
        //    $this->logger->debug('result found in cache');
        //    $result = $cacheItem->get();
        //}

        if (!($result instanceof ResultInterface)) {
            $this->logger->debug('need to rebuid result');
            $result = $this->buildResult($request);

            //$cacheItem->set($result);
            //$this->cache->save($cacheItem);
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
                new Generic\BabelFish(),
                new Generic\IISLogging(),
                new Generic\LocaleRemover(),
                new Generic\EncryptionRemover(),
                new Generic\Mozilla(),
                new Generic\Linux(),
                new Generic\KhtmlGecko(),
                new Generic\HexCode(),
                new Generic\WindowsNt(),
                new Generic\Tokens(),
                new Generic\NovarraGoogleTranslator(),
                new Generic\SerialNumbers(),
                new Generic\TransferEncoding(),
                new Generic\YesWAP(),
            ]
        );

        $deviceUa     = $normalizer->normalize($request->getDeviceUserAgent());
        $regexFactory = new Factory\RegexFactory($this->cache, $this->logger);

        try {
            $regexFactory->detect($deviceUa);
            $device = $regexFactory->getDevice();
        } catch (Loader\NotFoundException $e) {
            $this->logger->critical($e);
            $device = null;
        } catch (Factory\Regex\NoMatchException $e) {
            $device = null;
        } catch (\InvalidArgumentException $e) {
            $this->logger->error($e);
            $device = null;
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $device = null;
        }

        if (null === $device) {
            $this->logger->debug('device not detected via regexes');
            $device = (new Factory\DeviceFactory($this->cache, new Loader\DeviceLoader($this->cache)))->detect($deviceUa);
        }

        $browserUa = $normalizer->normalize($request->getBrowserUserAgent());
        $e         = null;

        try {
            $regexFactory->detect($browserUa);
            $platform = $regexFactory->getPlatform();
            $browser  = $regexFactory->getBrowser();
        } catch (Loader\NotFoundException $e) {
            $this->logger->critical($e);
            $platform = null;
            $browser  = null;
        } catch (Factory\Regex\NoMatchException $e) {
            $platform = null;
            $browser  = null;
        } catch (\InvalidArgumentException $e) {
            $this->logger->error($e);
            $platform = null;
            $browser  = null;
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $platform = null;
            $browser  = null;
        }

        if (null === $platform) {
            $this->logger->debug('platform not detected via regexes, try to get from device');
            $platform = $device->getPlatform();
        }

        if (null === $platform) {
            $this->logger->debug('device not detected via regexes nor from the device');
            $platform = (new Factory\PlatformFactory($this->cache, new Loader\PlatformLoader($this->cache)))->detect($browserUa);
        }

        if (null === $browser) {
            $this->logger->debug('browser not detected via regexes');
            $browser = (new Factory\BrowserFactory($this->cache, new Loader\BrowserLoader($this->cache)))->detect($browserUa, $platform);
        }

        $engineLoader = new  Loader\EngineLoader($this->cache);

        if (null !== $platform && in_array($platform->getName(), ['iOS'])) {
            $this->logger->debug('engine forced to "webkit" on iOS');
            $engine = $engineLoader->load('webkit', $browserUa);
        } else {
            if ($e === null) {
                $engine = $regexFactory->getEngine();
            } else {
                $engine = null;
            }

            if (null === $engine) {
                $this->logger->debug('engine not detected via regexes, try to get from browser');
                $engine = $browser->getEngine();
            }

            if ('unknown' === $engine) {
                $this->logger->debug('engine not detected via regexes nor from browser');
                $engine = (new Factory\EngineFactory($this->cache, $engineLoader))->detect($browserUa);
            }
        }

        return new Result(
            $request,
            $device,
            $platform,
            $browser,
            $engine
        );
    }
}
