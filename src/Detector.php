<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\NotFoundException;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface as PsrCacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Seld\JsonLint\ParsingException;
use Stringy\Stringy;
use UaNormalizer\NormalizerFactory;
use UaRequest\GenericRequest;
use UaRequest\GenericRequestFactory;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;
use UnexpectedValueException;

/**
 * Browser Detection class
 */
class Detector
{
    /**
     * a cache object
     *
     * @var \BrowserDetector\Cache\Cache
     */
    private $cache;

    /**
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * sets the cache used to make the detection faster
     *
     * @param \Psr\SimpleCache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface        $logger
     */
    public function __construct(PsrCacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache  = new Cache($cache);
        $this->logger = $logger;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param array|\Psr\Http\Message\MessageInterface|string $headers
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return \UaResult\Result\ResultInterface
     *
     * @deprecated
     */
    public function getBrowser($headers): ResultInterface
    {
        $request = $this->buildRequest($headers);

        return $this->parse($request);
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return \UaResult\Result\Result
     */
    public function parseString(string $useragent)
    {
        $request = (new GenericRequestFactory())->createRequestFromString($useragent);

        return $this->parse($request);
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param array $headers
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return \UaResult\Result\Result
     */
    public function parseArray(array $headers)
    {
        $request = (new GenericRequestFactory())->createRequestFromArray($headers);

        return $this->parse($request);
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param \Psr\Http\Message\MessageInterface $message
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return \UaResult\Result\Result
     */
    public function parseMessage(MessageInterface $message)
    {
        $request = (new GenericRequestFactory())->createRequestFromPsr7Message($message);

        return $this->parse($request);
    }

    /**
     * @param \UaRequest\GenericRequest $request
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return \UaResult\Result\Result
     */
    private function parse(GenericRequest $request)
    {
        $deviceFactory = new DeviceFactory($this->cache, $this->logger);
        $normalizer    = (new NormalizerFactory())->build();
        $deviceUa      = $normalizer->normalize($request->getDeviceUserAgent());

        /* @var \UaResult\Device\DeviceInterface $device */
        /* @var \UaResult\Os\OsInterface $platform */
        try {
            [$device, $platform] = $deviceFactory->detect($deviceUa, new Stringy($deviceUa));
        } catch (NotFoundException $e) {
            $this->logger->debug($e);

            $device   = null;
            $platform = null;
        }

        $browserUa = $normalizer->normalize($request->getBrowserUserAgent());
        $s         = new Stringy($browserUa);

        if (null === $platform) {
            $this->logger->debug('platform not detected from the device');

            $platformFactory = new PlatformFactory($this->cache, $this->logger);

            try {
                $platform = $platformFactory->detect($browserUa, $s);
            } catch (NotFoundException $e) {
                $this->logger->debug($e);
                $platform = null;
            }
        }

        /* @var \UaResult\Browser\BrowserInterface $browser */
        /* @var \UaResult\Engine\EngineInterface $engine */
        [$browser, $engine] = (new BrowserFactory($this->cache, $this->logger))->detect($browserUa, $s);
        $engineLoader       = new EngineLoader($this->cache, $this->logger);

        if (null === $engine) {
            $this->logger->debug('engine not detected from browser');

            if (null !== $platform && in_array($platform->getName(), ['iOS'])) {
                $engine = $engineLoader->load('webkit', $browserUa);
            } else {
                try {
                    $engine = $engineLoader($browserUa);
                } catch (InvalidArgumentException | ParsingException $e) {
                    $this->logger->info($e);
                }
            }
        }

        return new Result(
            $request->getHeaders(),
            $device,
            $platform,
            $browser,
            $engine
        );
    }

    /**
     * @param array|\Psr\Http\Message\MessageInterface|string $request
     *
     * @throws \UnexpectedValueException
     *
     * @return \UaRequest\GenericRequest
     */
    private function buildRequest($request): GenericRequest
    {
        $requestFactory = new GenericRequestFactory();

        if ($request instanceof MessageInterface) {
            $this->logger->debug('request object created from PSR-7 http message');

            return $requestFactory->createRequestFromPsr7Message($request);
        }

        if (is_array($request)) {
            $this->logger->debug('request object created from array');

            return $requestFactory->createRequestFromArray($request);
        }

        if (is_string($request)) {
            $this->logger->debug('request object created from string');

            return $requestFactory->createRequestFromString($request);
        }

        throw new UnexpectedValueException(
            'the request parameter has to be a string, an array or an instance of \Psr\Http\Message\MessageInterface'
        );
    }
}
