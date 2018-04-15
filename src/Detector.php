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

use BrowserDetector\Factory\BrowserFactoryInterface;
use BrowserDetector\Factory\DeviceFactoryInterface;
use BrowserDetector\Factory\PlatformFactoryInterface;
use BrowserDetector\Loader\Loader;
use BrowserDetector\Loader\NotFoundException;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
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
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Factory\DeviceFactoryInterface
     */
    private $deviceFactory;

    /**
     * @var \BrowserDetector\Factory\PlatformFactoryInterface
     */
    private $platformFactory;

    /**
     * @var \BrowserDetector\Factory\BrowserFactoryInterface
     */
    private $browserFactory;

    /**
     * @var \BrowserDetector\Loader\Loader
     */
    private $engineLoader;

    /**
     * sets the cache used to make the detection faster
     *
     * @param \Psr\Log\LoggerInterface                          $logger
     * @param \BrowserDetector\Factory\DeviceFactoryInterface   $deviceFactory
     * @param \BrowserDetector\Factory\PlatformFactoryInterface $platformFactory
     * @param \BrowserDetector\Factory\BrowserFactoryInterface  $browserFactory
     * @param \BrowserDetector\Loader\Loader                    $engineLoader
     */
    public function __construct(
        LoggerInterface $logger,
        DeviceFactoryInterface $deviceFactory,
        PlatformFactoryInterface $platformFactory,
        BrowserFactoryInterface $browserFactory,
        Loader $engineLoader
    ) {
        $this->logger          = $logger;
        $this->deviceFactory   = $deviceFactory;
        $this->platformFactory = $platformFactory;
        $this->browserFactory  = $browserFactory;
        $this->engineLoader    = $engineLoader;
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
        $normalizer    = (new NormalizerFactory())->build();
        $deviceUa      = $normalizer->normalize($request->getDeviceUserAgent());
        $deviceFactory = $this->deviceFactory;

        /* @var \UaResult\Device\DeviceInterface $device */
        /* @var \UaResult\Os\OsInterface $platform */
        try {
            [$device, $platform] = $deviceFactory($deviceUa);
        } catch (NotFoundException $e) {
            $this->logger->debug($e);

            $device   = null;
            $platform = null;
        }

        $browserUa = $normalizer->normalize($request->getBrowserUserAgent());

        if (null === $platform) {
            $this->logger->debug('platform not detected from the device');
            $platformFactory = $this->platformFactory;

            try {
                $platform = $platformFactory($browserUa);
            } catch (NotFoundException $e) {
                $this->logger->debug($e);
                $platform = null;
            }
        }

        $browserFactory = $this->browserFactory;

        /* @var \UaResult\Browser\BrowserInterface $browser */
        /* @var \UaResult\Engine\EngineInterface $engine */
        [$browser, $engine] = $browserFactory($browserUa);

        if (null === $engine) {
            $this->logger->debug('engine not detected from browser');

            if (null !== $platform && in_array($platform->getName(), ['iOS'])) {
                $engine = $this->engineLoader->load('webkit', $browserUa);
            } else {
                $engineLoader = $this->engineLoader;

                try {
                    $engine = $engineLoader($browserUa);
                } catch (InvalidArgumentException $e) {
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
