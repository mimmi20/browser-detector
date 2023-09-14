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
use BrowserDetector\Header\HeaderInterface;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use BrowserDetector\Version\NotNumericException;
use BrowserDetector\Version\VersionFactory;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaNormalizer\NormalizerFactory;
use UnexpectedValueException;

use function array_filter;
use function array_key_exists;
use function assert;
use function explode;
use function in_array;
use function is_array;
use function mb_strtolower;
use function reset;

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
        private readonly NormalizerFactory $normalizerFactory,
    ) {
        // nothing to do
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param array<non-empty-string, non-empty-string>|GenericRequestInterface|MessageInterface|string $headers
     *
     * @return array<mixed>
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NotNumericException
     */
    public function getBrowser(array | GenericRequestInterface | MessageInterface | string $headers): array
    {
        $requestBuilder = new RequestBuilder(
            $this->deviceParser,
            $this->platformParser,
            $this->browserParser,
            $this->engineParser,
            $this->normalizerFactory,
        );

        $request = $requestBuilder->buildRequest($headers);
        $cacheId = $request->getHash();

        if ($this->cache->hasItem($cacheId)) {
            $item = $this->cache->getItem($cacheId);
            assert(is_array($item));

            return $item;
        }

        $item = $this->parse($request);

        $this->cache->setItem($cacheId, $item);

        return $item;
    }

    /**
     * @return array<mixed>
     *
     * @throws NotNumericException
     * @throws UnexpectedValueException
     */
    private function parse(GenericRequestInterface $request): array
    {
        $result = [
            'headers' => $request->getHeaders(),
            'device' => [
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => null,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
                'bits' => null,
            ],
            'client' => [
                'name' => null,
                'modus' => null,
                'version' => null,
                'manufacturer' => null,
                'bits' => null,
                'type' => null,
                'isbot' => null,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
            ],
        ];

        /* detect device */
        $headersWithDeviceCode = array_filter(
            $request->getFilteredHeaders(),
            static fn (HeaderInterface $header): bool => $header->hasDeviceCode(),
        );

        $deviceHeader     = reset($headersWithDeviceCode);
        $platformCodename = null;
        $deviceCodename   = null;

        if ($deviceHeader instanceof HeaderInterface) {
            $deviceCodename = $deviceHeader->getDeviceCode();
        }

        if ($deviceCodename !== null) {
            $parts = explode('=', $deviceCodename, 2);

            [$device, $platformCodename] = $this->deviceParser->load($parts[0], $parts[1]);

            $result['device'] = $device;
        }

        $platformHeader = null;

        /* detect platform */
        if ($platformCodename === null) {
            $headersWithPlatformName = array_filter(
                $request->getFilteredHeaders(),
                static fn (HeaderInterface $header): bool => $header->hasPlatformCode(),
            );

            $platformHeader = reset($headersWithPlatformName);

            if (
                !$platformHeader instanceof HeaderInterface
                && $deviceHeader instanceof HeaderInterface
            ) {
                $platformHeader = clone $deviceHeader;
            }

            if ($platformHeader instanceof HeaderInterface) {
                $platformCodename = $platformHeader->getPlatformCode();
            }
        }

        if ($platformCodename !== null && $platformHeader instanceof HeaderInterface) {
            $result['os'] = $this->platformParser->load($platformCodename, $platformHeader->getValue());

            if (
                array_key_exists('name', $result['os'])
                && $result['os']['name'] !== null
                && (
                    !array_key_exists('version', $result['os'])
                    || $result['os']['version'] === null
                )
            ) {
                $headersWithPlatformVersion = array_filter(
                    $request->getFilteredHeaders(),
                    static fn (HeaderInterface $header): bool => $header->hasPlatformVersion(),
                );

                $platformVersionHeader = reset($headersWithPlatformVersion);
                assert($platformVersionHeader instanceof HeaderInterface);

                $platformVersion = $platformVersionHeader->getPlatformVersion($platformCodename);

                if ($platformVersion !== null) {
                    $versionFactory = new VersionFactory();

                    $result['os']['version'] = $versionFactory->set($platformVersion)->getVersion();
                }
            }
        }

        /* detect client */
        $headersWithBrowserCode = array_filter(
            $request->getFilteredHeaders(),
            static fn (HeaderInterface $header): bool => $header->hasClientCode(),
        );

        $browserHeader = reset($headersWithBrowserCode);
        assert($browserHeader instanceof HeaderInterface);

        $browserCodename = $browserHeader->getClientCode();
        $engineCodename  = null;

        if ($browserCodename !== null) {
            [$browser, $engineCodename] = $this->browserParser->load(
                $browserCodename,
                $browserHeader->getValue(),
            );

            $result['client'] = $browser;
        }

        if (in_array(mb_strtolower($result['os']['name'] ?? ''), ['ios'], true)) {
            $engineCodename = 'webkit';
        }

        if ($browserHeader->hasClientVersion()) {
            $browserVersion = $browserHeader->getClientVersion();
        } else {
            $headersWithBrowserVersion = array_filter(
                $request->getFilteredHeaders(),
                static fn (HeaderInterface $header): bool => $header->hasClientVersion(),
            );

            $browserVersionHeader = reset($headersWithBrowserVersion);
            assert($browserVersionHeader instanceof HeaderInterface);

            $browserVersion = $browserVersionHeader->getClientVersion();
        }

        if ($browserVersion !== null) {
            $result['client']['version'] = (new VersionFactory())->set($browserVersion)->getVersion();
        }

        $engineHeader = clone $browserHeader;

        /* detect engine */
        if ($engineCodename === null) {
            $headersWithEngineName = array_filter(
                $request->getFilteredHeaders(),
                static fn (HeaderInterface $header): bool => $header->hasEngineCode(),
            );

            $engineHeader = reset($headersWithEngineName);
            assert($engineHeader instanceof HeaderInterface);

            $engineCodename = $engineHeader->getEngineCode();
        }

        if ($engineCodename !== null) {
            $result['engine'] = $this->engineParser->load($engineCodename, $engineHeader->getValue());

            if (
                array_key_exists('name', $result['engine'])
                && $result['engine']['name'] !== null
                && (
                    !array_key_exists('version', $result['engine'])
                    || $result['engine']['version'] === null
                )
            ) {
                $headersWithEngineVersion = array_filter(
                    $request->getFilteredHeaders(),
                    static fn (HeaderInterface $header): bool => $header->hasEngineVersion(),
                );

                $engineVersionHeader = reset($headersWithEngineVersion);
                assert($engineVersionHeader instanceof HeaderInterface);

                $engineVersion = $engineVersionHeader->getEngineVersion($engineCodename);

                if ($engineVersion !== null) {
                    $versionFactory = new VersionFactory();

                    $result['engine']['version'] = $versionFactory->set($engineVersion)->getVersion();
                }
            }
        }

        return $result;
    }
}
