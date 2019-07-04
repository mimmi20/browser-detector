<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
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
use Psr\Log\LoggerInterface;
use UaDeviceType\Unknown;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaRequest\GenericRequest;
use UaResult\Browser\Browser;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UaResult\Engine\Engine;
use UaResult\Os\Os;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;

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
     * @var \UaNormalizer\Normalizer\NormalizerInterface
     */
    private $normalizer;

    /**
     * sets the cache used to make the detection faster
     *
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \BrowserDetector\Cache\CacheInterface           $cache
     * @param \BrowserDetector\Parser\DeviceParserInterface   $deviceParser
     * @param \BrowserDetector\Parser\PlatformParserInterface $platformParser
     * @param \BrowserDetector\Parser\BrowserParserInterface  $browserParser
     * @param \BrowserDetector\Parser\EngineParserInterface   $engineParser
     * @param \UaNormalizer\Normalizer\NormalizerInterface    $normalizer
     */
    public function __construct(
        LoggerInterface $logger,
        CacheInterface $cache,
        DeviceParserInterface $deviceParser,
        PlatformParserInterface $platformParser,
        BrowserParserInterface $browserParser,
        EngineParserInterface $engineParser,
        NormalizerInterface $normalizer
    ) {
        $this->logger         = $logger;
        $this->cache          = $cache;
        $this->deviceParser   = $deviceParser;
        $this->platformParser = $platformParser;
        $this->browserParser  = $browserParser;
        $this->engineParser   = $engineParser;
        $this->normalizer     = $normalizer;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param array|\Psr\Http\Message\MessageInterface|string|\UaRequest\GenericRequest $headers
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \UnexpectedValueException
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
     * @throws \UnexpectedValueException
     *
     * @return \UaResult\Result\ResultInterface
     */
    public function __invoke($headers): ResultInterface
    {
        $request = (new RequestBuilder())->buildRequest($this->logger, $headers);

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
        $deviceUa     = $this->normalizer->normalize($request->getDeviceUserAgent());
        $deviceParser = $this->deviceParser;

        $defaultDevice = new Device(
            null,
            null,
            new Company('unknown', null, null),
            new Company('unknown', null, null),
            new Unknown(),
            new Display(null, new \UaDisplaySize\Unknown(), null)
        );

        $defaultPlatform = new Os(
            null,
            null,
            new Company('unknown', null, null),
            new Version('0'),
            null
        );

        /* @var \UaResult\Device\DeviceInterface $device */
        /* @var \UaResult\Os\OsInterface $platform */
        try {
            [$device, $platform] = $deviceParser->parse($deviceUa);
        } catch (NotFoundException | \UnexpectedValueException $e) {
            $this->logger->warning($e);

            $device   = clone $defaultDevice;
            $platform = clone $defaultPlatform;
        }

        if (null === $platform) {
            $this->logger->debug('platform not detected from the device');
            $platformParser = $this->platformParser;

            try {
                $platform = $platformParser->parse($this->normalizer->normalize($request->getPlatformUserAgent()));
            } catch (NotFoundException | \UnexpectedValueException $e) {
                $this->logger->warning($e);
                $platform = clone $defaultPlatform;
            }
        }

        $browserParser = $this->browserParser;

        $defaultBrowser = new Browser(
            null,
            new Company('unknown', null, null),
            new Version('0'),
            new \UaBrowserType\Unknown(),
            null,
            null
        );

        $defaultEngine = new Engine(
            null,
            new Company('unknown', null, null),
            new Version('0')
        );

        $browserUa = $this->normalizer->normalize($request->getBrowserUserAgent());

        /* @var \UaResult\Browser\BrowserInterface $browser */
        /* @var \UaResult\Engine\EngineInterface $engine */
        try {
            [$browser, $engine] = $browserParser->parse($browserUa);
        } catch (NotFoundException | \UnexpectedValueException $e) {
            $this->logger->error($e);

            $browser = clone $defaultBrowser;
            $engine  = clone $defaultEngine;
        }

        if (null !== $platform && in_array($platform->getName(), ['iOS', 'iPhone OS'], true)) {
            try {
                $engine = $this->engineParser->load('webkit', $browserUa);
            } catch (NotFoundException | \UnexpectedValueException $e) {
                $this->logger->warning($e);

                $engine = clone $defaultEngine;
            }
        } elseif (null === $engine) {
            $this->logger->debug('engine not detected from browser');
            $engine = clone $defaultEngine;

            $engineParser = $this->engineParser;

            try {
                $engine = $engineParser->parse($browserUa);
            } catch (NotFoundException | \UnexpectedValueException $e) {
                $this->logger->error($e);
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
}
