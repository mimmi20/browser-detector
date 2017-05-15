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
use Psr\Http\Message\MessageInterface;

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
     * @param string|array|\Wurfl\Request\GenericRequest|\Psr\Http\Message\MessageInterface $request
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

        /* @var \UaResult\Device\DeviceInterface $device */
        /* @var \UaResult\Os\OsInterface $platform */
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

        if (null === $engine || in_array($engine->getName(), [null, 'unknown'])) {
            $this->logger->debug('engine not detected from browser');
            $engine = (new Factory\EngineFactory($engineLoader))->detect($browserUa, $browserLoader, $platform);
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
     * @param string|array|\Psr\Http\Message\MessageInterface $request
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

            return $requestFactory->createRequestFromString($request);
        }

        if (is_array($request)) {
            $this->logger->debug('request object created from array');

            return $requestFactory->createRequestFromArray($request);
        }

        if ($request instanceof MessageInterface) {
            $this->logger->debug('request object created from PSR-7 http message');

            return $requestFactory->createRequestFromPsr7Message($request);
        }

        throw new UnexpectedValueException(
            'the request parameter has to be a string, an array, an instance of \Psr\Http\Message\MessageInterface '
            . 'or an instance of \Wurfl\Request\GenericRequest'
        );
    }
}
