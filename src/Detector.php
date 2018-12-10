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

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use BrowserDetector\Version\Version;
use ExceptionalJSON\DecodeErrorException;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaDeviceType\Unknown;
use UaNormalizer\NormalizerFactory;
use UaRequest\GenericRequest;
use UaRequest\GenericRequestFactory;
use UaResult\Browser\Browser;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UaResult\Device\Market;
use UaResult\Engine\Engine;
use UaResult\Os\Os;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;
use UnexpectedValueException;

final class Detector implements DetectorInterface
{
    /**
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Cache\CacheInterface
     */
    private $cache;

    /**
     * @var \BrowserDetector\Parser\DeviceParserInterface
     */
    private $deviceParser;

    /**
     * @var \BrowserDetector\Parser\PlatformParserInterface
     */
    private $platformParser;

    /**
     * @var \BrowserDetector\Parser\BrowserParserInterface
     */
    private $browserParser;

    /**
     * @var \BrowserDetector\Parser\EngineParserInterface
     */
    private $engineParser;

    /**
     * sets the cache used to make the detection faster
     *
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \BrowserDetector\Cache\CacheInterface           $cache
     * @param \BrowserDetector\Parser\DeviceParserInterface   $deviceParser
     * @param \BrowserDetector\Parser\PlatformParserInterface $platformParser
     * @param \BrowserDetector\Parser\BrowserParserInterface  $browserParser
     * @param \BrowserDetector\Parser\EngineParserInterface   $engineParser
     */
    public function __construct(
        LoggerInterface $logger,
        CacheInterface $cache,
        DeviceParserInterface $deviceParser,
        PlatformParserInterface $platformParser,
        BrowserParserInterface $browserParser,
        EngineParserInterface $engineParser
    ) {
        $this->logger         = $logger;
        $this->cache          = $cache;
        $this->deviceParser   = $deviceParser;
        $this->platformParser = $platformParser;
        $this->browserParser  = $browserParser;
        $this->engineParser   = $engineParser;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param array|\Psr\Http\Message\MessageInterface|string|\UaRequest\GenericRequest $headers
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return \UaResult\Result\ResultInterface
     *
     * @deprecated
     */
    public function getBrowser($headers): ResultInterface
    {
        return $this->__invoke($headers);
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param array|\Psr\Http\Message\MessageInterface|string|\UaRequest\GenericRequest $headers
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return \UaResult\Result\ResultInterface
     */
    public function __invoke($headers): ResultInterface
    {
        $request = $this->buildRequest($headers);

        $key = sha1(serialize($request->getFilteredHeaders()));

        if ($this->cache->hasItem($key)) {
            return $this->cache->getItem($key);
        }

        $item = $this->parse($request);

        $this->cache->setItem($key, $item);

        return $item;
    }

    /**
     * @param \UaRequest\GenericRequest $request
     *
     * @return \UaResult\Result\Result
     */
    private function parse(GenericRequest $request)
    {
        //$normalizer    = (new NormalizerFactory())->build();
        $deviceUa     = $request->getDeviceUserAgent(); //$normalizer->normalize($request->getDeviceUserAgent());
        $deviceParser = $this->deviceParser;

        $defaultDevice = new Device(
            null,
            null,
            new Company('Unknown', null, null),
            new Company('Unknown', null, null),
            new Unknown(),
            new Display(null, null, null, new \UaDisplaySize\Unknown(), null),
            false,
            0,
            new Market([], [], [])
        );

        $defaultPlatform = new Os(
            null,
            null,
            new Company('Unknown', null, null),
            new Version('0'),
            null
        );

        /* @var \UaResult\Device\DeviceInterface $device */
        /* @var \UaResult\Os\OsInterface $platform */
        try {
            [$device, $platform] = $deviceParser($deviceUa);
        } catch (NotFoundException | InvalidArgumentException $e) {
            $this->logger->warning($e);

            $device   = clone $defaultDevice;
            $platform = clone $defaultPlatform;
        }

        $browserUa = $request->getBrowserUserAgent(); //$normalizer->normalize($request->getBrowserUserAgent());

        if (null === $platform) {
            $this->logger->debug('platform not detected from the device');
            $platformParser = $this->platformParser;

            try {
                $platform = $platformParser($browserUa);
            } catch (NotFoundException | InvalidArgumentException $e) {
                $this->logger->warning($e);
                $platform = clone $defaultPlatform;
            }
        }

        $browserParser = $this->browserParser;

        $defaultBrowser = new Browser(
            null,
            new Company('Unknown', null, null),
            new Version('0'),
            new \UaBrowserType\Unknown(),
            0,
            null
        );

        $defaultEngine = new Engine(
            null,
            new Company('Unknown', null, null),
            new Version('0')
        );

        /* @var \UaResult\Browser\BrowserInterface $browser */
        /* @var \UaResult\Engine\EngineInterface $engine */
        try {
            [$browser, $engine] = $browserParser($browserUa);
        } catch (DecodeErrorException | InvalidArgumentException $e) {
            $this->logger->error($e);

            $browser = clone $defaultBrowser;
            $engine  = clone $defaultEngine;
        }

        if (null === $engine) {
            $this->logger->debug('engine not detected from browser');
            $engine  = clone $defaultEngine;

            if (null !== $platform && in_array($platform->getName(), ['iOS'])) {
                try {
                    $engine = $this->engineParser->load('webkit', $browserUa);
                } catch (DecodeErrorException $e) {
                    $this->logger->error($e);
                } catch (NotFoundException $e) {
                    $this->logger->warning($e);
                }
            } else {
                $engineParser = $this->engineParser;

                try {
                    $engine = $engineParser($browserUa);
                } catch (InvalidArgumentException $e) {
                    $this->logger->error($e);
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
     * @param array|\Psr\Http\Message\MessageInterface|string|\UaRequest\GenericRequest $request
     *
     * @throws \UnexpectedValueException
     *
     * @return \UaRequest\GenericRequest
     */
    private function buildRequest($request): GenericRequest
    {
        if ($request instanceof GenericRequest) {
            $this->logger->debug('request object used as is');

            return $request;
        }

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
