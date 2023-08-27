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

use BrowserDetector\Header\HeaderInterface;
use BrowserDetector\Header\HeaderLoaderInterface;
use Psr\Http\Message\MessageInterface;

use function array_filter;
use function array_key_exists;
use function array_keys;
use function is_string;
use function serialize;
use function sha1;

final class GenericRequest implements GenericRequestInterface
{
    private const HEADERS = [
        Constants::HEADER_SEC_CH_UA_MODEL,
        Constants::HEADER_SEC_CH_UA_PLATFORM,
        Constants::HEADER_SEC_CH_UA_PLATFORM_VERSION,
        Constants::HEADER_SEC_CH_UA_FULL_VERSION_LIST,
        Constants::HEADER_SEC_CH_UA,
        Constants::HEADER_SEC_CH_UA_FULL_VERSION,
        Constants::HEADER_SEC_CH_UA_BITNESS,
        Constants::HEADER_SEC_CH_UA_ARCH,
        Constants::HEADER_SEC_CH_UA_MOBILE,
        Constants::HEADER_DEVICE_UA,
        Constants::HEADER_UCBROWSER_UA,
        Constants::HEADER_UCBROWSER_DEVICE_UA,
        Constants::HEADER_UCBROWSER_DEVICE,
        Constants::HEADER_UCBROWSER_PHONE_UA,
        Constants::HEADER_UCBROWSER_PHONE,
        Constants::HEADER_DEVICE_STOCK_UA,
        Constants::HEADER_SKYFIRE_PHONE,
        Constants::HEADER_OPERAMINI_PHONE_UA,
        Constants::HEADER_OPERAMINI_PHONE,
        Constants::HEADER_SKYFIRE_VERSION,
        Constants::HEADER_BLUECOAT_VIA,
        Constants::HEADER_BOLT_PHONE_UA,
        Constants::HEADER_MOBILE_UA,
        Constants::HEADER_REQUESTED_WITH,
        Constants::HEADER_ORIGINAL_UA,
        Constants::HEADER_UA_OS,
        Constants::HEADER_BAIDU_FLYFLOW,
        Constants::HEADER_PUFFIN_UA,
        Constants::HEADER_USERAGENT,
        Constants::HEADER_WAP_PROFILE,
        Constants::HEADER_NB_CONTENT,
    ];

    /** @var array<non-empty-string, non-empty-string> */
    private array $headers = [];

    /** @var array<non-empty-string, HeaderInterface> */
    private array $filteredHeaders = [];

    /** @throws void */
    public function __construct(MessageInterface $message, private readonly HeaderLoaderInterface $loader)
    {
        foreach (array_keys($message->getHeaders()) as $header) {
            if (!is_string($header) || $header === '') {
                continue;
            }

            $headerLine = $message->getHeaderLine($header);

            if ($headerLine === '') {
                continue;
            }

            $this->headers[$header] = $headerLine;
        }

        $this->filterHeaders();
    }

    /**
     * @return array<non-empty-string, non-empty-string>
     *
     * @throws void
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array<non-empty-string, HeaderInterface>
     *
     * @throws void
     */
    public function getFilteredHeaders(): array
    {
        return $this->filteredHeaders;
    }

    /** @throws void */
    public function getHash(): string
    {
        $data = [];

        foreach ($this->filteredHeaders as $name => $header) {
            $data[$name] = $header->getValue();
        }

        return sha1(serialize($data));
    }

    /** @throws void */
    public function getBrowserUserAgent(): string
    {
        return '';
    }

    /** @throws void */
    public function getDeviceUserAgent(): string
    {
        foreach ($this->filteredHeaders as $header) {
            if ($header->hasDeviceCode()) {
                return $header->getValue();
            }
        }

        return '';
    }

    /** @throws void */
    public function getPlatformUserAgent(): string
    {
        return '';
    }

    /** @throws void */
    public function getEngineUserAgent(): string
    {
        return '';
    }

    /** @throws void */
    private function filterHeaders(): void
    {
        $headers  = $this->headers;
        $filtered = array_filter(
            self::HEADERS,
            static fn ($value): bool => array_key_exists($value, $headers),
        );

        foreach ($filtered as $header) {
            try {
                $headerObj = $this->loader->load($header, $this->headers[$header]);
            } catch (NotFoundException) {
                continue;
            }

            $this->filteredHeaders[$header] = $headerObj;
        }
    }
}
