<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
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
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\Version;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaDeviceType\Unknown;
use UaNormalizer\Normalizer\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaRequest\GenericRequestInterface;
use UaResult\Browser\Browser;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UaResult\Engine\Engine;
use UaResult\Os\Os;
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
     * sets the cache used to make the detection faster
     *
     * @throws void
     */
    public function __construct(
        /**
         * an logger instance
         */
        private readonly LoggerInterface $logger,
        private readonly CacheInterface $cache,
        private readonly DeviceParserInterface $deviceParser,
        private readonly PlatformParserInterface $platformParser,
        private readonly BrowserParserInterface $browserParser,
        private readonly EngineParserInterface $engineParser,
        private readonly NormalizerInterface $normalizer,
    ) {
        // nothing to do
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param array<string, string>|GenericRequestInterface|MessageInterface|string $headers
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NotNumericException
     */
    public function __invoke(array | GenericRequestInterface | MessageInterface | string $headers): ResultInterface
    {
        return $this->getBrowser($headers);
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param array<string, string>|GenericRequestInterface|MessageInterface|string $headers
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NotNumericException
     */
    public function getBrowser(array | GenericRequestInterface | MessageInterface | string $headers): ResultInterface
    {
        $request = (new RequestBuilder())->buildRequest($this->logger, $headers);

        $key = sha1(serialize($request->getFilteredHeaders()));

        if ($this->cache->hasItem($key)) {
            $item = $this->cache->getItem($key);
            assert($item instanceof ResultInterface);

            return $item;
        }

        $item = $this->parse($request);

        $this->cache->setItem($key, $item);

        return $item;
    }

    /** @throws NotNumericException */
    private function parse(GenericRequestInterface $request): Result
    {
        try {
            $deviceUa = (string) $this->normalizer->normalize($request->getDeviceUserAgent());
        } catch (Exception $e) {
            $this->logger->error($e);

            $deviceUa = '';
        }

        $deviceParser  = $this->deviceParser;
        $defaultDevice = new Device(
            null,
            null,
            new Company('unknown', null, null),
            new Company('unknown', null, null),
            new Unknown(),
            new Display(null, null, null, null),
        );

        $defaultPlatform = new Os(
            null,
            null,
            new Company('unknown', null, null),
            new Version('0'),
            null,
        );

        try {
            [$device, $platform] = $deviceParser->parse($deviceUa);
        } catch (UnexpectedValueException $e) {
            $this->logger->warning($e);

            $device   = $defaultDevice;
            $platform = $defaultPlatform;
        }

        if ($platform === null) {
            $this->logger->debug('platform not detected from the device');
            $platformParser = $this->platformParser;

            try {
                $platform = $platformParser->parse(
                    (string) $this->normalizer->normalize($request->getPlatformUserAgent()),
                );
            } catch (UnexpectedValueException $e) {
                $this->logger->warning($e);
                $platform = $defaultPlatform;
            }
        }

        $browserParser = $this->browserParser;

        $defaultBrowser = new Browser(
            null,
            new Company('unknown', null, null),
            new Version('0'),
            new \UaBrowserType\Unknown(),
            null,
            null,
        );

        $defaultEngine = new Engine(
            null,
            new Company('unknown', null, null),
            new Version('0'),
        );

        try {
            $browserUa = (string) $this->normalizer->normalize($request->getBrowserUserAgent());
        } catch (Exception $e) {
            $this->logger->error($e);

            $browserUa = '';
        }

        try {
            [$browser, $engine] = $browserParser->parse($browserUa);
        } catch (UnexpectedValueException $e) {
            $this->logger->error($e);

            $browser = $defaultBrowser;
            $engine  = $defaultEngine;
        }

        try {
            $engineUa = (string) $this->normalizer->normalize($request->getEngineUserAgent());
        } catch (Exception $e) {
            $this->logger->error($e);

            $engineUa = '';
        }

        if ($platform !== null && in_array($platform->getName(), ['iOS', 'iPhone OS'], true)) {
            try {
                $engine = $this->engineParser->load('webkit', $engineUa);
            } catch (UnexpectedValueException $e) {
                $this->logger->warning($e);

                $engine = $defaultEngine;
            }
        } elseif ($engine === null) {
            $this->logger->debug('engine not detected from browser');
            $engine = $defaultEngine;

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
            $engine,
        );
    }
}
