<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use BrowserDetector\Version\Version;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaDeviceType\Unknown;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaRequest\GenericRequest;
use UaResult\Browser\Browser;
use UaResult\Browser\BrowserInterface;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\DeviceInterface;
use UaResult\Device\Display;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;
use UnexpectedValueException;

use function assert;
use function in_array;
use function serialize;
use function sha1;

final class Detector implements DetectorInterface
{
    /**
     * an logger instance
     */
    private LoggerInterface $logger;

    private CacheInterface $cache;

    private DeviceParserInterface $deviceParser;

    private PlatformParserInterface $platformParser;

    private BrowserParserInterface $browserParser;

    private EngineParserInterface $engineParser;

    private NormalizerInterface $normalizer;

    /**
     * sets the cache used to make the detection faster
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
     * @param array<string, string>|GenericRequest|MessageInterface|string $headers
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
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
     * Gets the information about the browser by User Agent
     *
     * @deprecated
     *
     * @param array<string, string>|GenericRequest|MessageInterface|string $headers
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function getBrowser($headers): ResultInterface
    {
        return $this->__invoke($headers);
    }

    private function parse(GenericRequest $request): Result
    {
        $deviceUa     = $this->normalizer->normalize($request->getDeviceUserAgent());
        $deviceParser = $this->deviceParser;

        $defaultDevice = new Device(
            null,
            null,
            new Company('unknown', null, null),
            new Company('unknown', null, null),
            new Unknown(),
            new Display(null, null, null, null)
        );

        $defaultPlatform = new Os(
            null,
            null,
            new Company('unknown', null, null),
            new Version('0'),
            null
        );

        try {
            [$device, $platform] = $deviceParser->parse($deviceUa);
        } catch (UnexpectedValueException $e) {
            $this->logger->warning($e);

            $device   = clone $defaultDevice;
            $platform = clone $defaultPlatform;
        }

        assert($device instanceof DeviceInterface);
        assert($platform instanceof OsInterface || null === $platform);

        if (null === $platform) {
            $this->logger->debug('platform not detected from the device');
            $platformParser = $this->platformParser;

            try {
                $platform = $platformParser->parse($this->normalizer->normalize($request->getPlatformUserAgent()));
            } catch (UnexpectedValueException $e) {
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
        $engineUa  = $this->normalizer->normalize($request->getEngineUserAgent());

        try {
            [$browser, $engine] = $browserParser->parse($browserUa);
        } catch (UnexpectedValueException $e) {
            $this->logger->error($e);

            $browser = clone $defaultBrowser;
            $engine  = clone $defaultEngine;
        }

        assert($browser instanceof BrowserInterface);
        assert($engine instanceof EngineInterface || null === $engine);

        if (null !== $platform && in_array($platform->getName(), ['iOS', 'iPhone OS'], true)) {
            try {
                $engine = $this->engineParser->load('webkit', $engineUa);
            } catch (UnexpectedValueException $e) {
                $this->logger->warning($e);

                $engine = clone $defaultEngine;
            }
        } elseif (null === $engine) {
            $this->logger->debug('engine not detected from browser');
            $engine = clone $defaultEngine;

            $engineParser = $this->engineParser;

            try {
                $engine = $engineParser->parse($engineUa);
            } catch (UnexpectedValueException $e) {
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
