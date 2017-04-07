<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector;

use BrowserDetector\Factory\NormalizerFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetector\Loader\NotFoundException;
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

        $deviceFactory = new Factory\DeviceFactory(new DeviceLoader($this->cache));
        $normalizer    = (new NormalizerFactory())->build();
        $deviceUa      = $normalizer->normalize($request->getDeviceUserAgent());

        /** @var \UaResult\Device\DeviceInterface $device */
        /** @var \UaResult\Os\OsInterface $platform */
        try {
            list($device, $platform) = $deviceFactory->detect($deviceUa);
        } catch (NotFoundException $e) {
            $this->logger->debug($e);

            $device   = null;
            $platform = null;
        }

        $browserUa = $normalizer->normalize($request->getBrowserUserAgent());

        if (null === $platform || in_array($platform->getName(), [null, 'unknown'])) {
            $this->logger->debug('platform not detected from the device');

            $platformFactory = new PlatformFactory(new PlatformLoader($this->cache));

            try {
                $platform = $platformFactory->detect($browserUa);
            } catch (NotFoundException $e) {
                $this->logger->debug($e);
                $platform = null;
            }
        }

        $browserLoader = new Loader\BrowserLoader($this->cache);

        /** @var \UaResult\Browser\BrowserInterface $browser */
        /** @var \UaResult\Engine\EngineInterface $engine */
        list($browser, $engine) = (new Factory\BrowserFactory($browserLoader))->detect($browserUa, $platform);
        $engineLoader           = new Loader\EngineLoader($this->cache);

        if (null !== $platform && in_array($platform->getName(), ['iOS'])) {
            $this->logger->debug('engine forced to "webkit" on iOS');
            $engine = $engineLoader->load('webkit', $browserUa);
        } elseif (null === $engine || in_array($engine->getName(), [null, 'unknown'])) {
            $this->logger->debug('engine not detected from browser');
            $engine = (new Factory\EngineFactory($engineLoader))->detect($browserUa, $browserLoader);
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
     *
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
