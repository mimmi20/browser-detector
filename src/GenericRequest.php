<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector;

use BrowserDetector\Header\HeaderInterface;
use BrowserDetector\Header\HeaderLoaderInterface;
use Override;
use Psr\Http\Message\MessageInterface;

use function array_filter;
use function array_key_exists;
use function array_keys;
use function is_string;
use function mb_strtolower;
use function mb_substr;
use function serialize;
use function sha1;
use function str_starts_with;

final class GenericRequest implements GenericRequestInterface
{
    private const array HEADERS = [
        Constants::HEADER_SEC_CH_UA_MODEL,
        Constants::HEADER_SEC_CH_UA_PLATFORM,
        Constants::HEADER_SEC_CH_UA_PLATFORM_VERSION,
        Constants::HEADER_SEC_CH_UA_FULL_VERSION_LIST,
        Constants::HEADER_REQUESTED_WITH,
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
        Constants::HEADER_OPERAMINI_PHONE_UA,
        Constants::HEADER_DEVICE_STOCK_UA,
        Constants::HEADER_OPERAMINI_PHONE,
        Constants::HEADER_ORIGINAL_UA,
        Constants::HEADER_UA_OS,
        Constants::HEADER_BAIDU_FLYFLOW,
        Constants::HEADER_PUFFIN_UA,
        Constants::HEADER_USERAGENT,
    ];

    /** @var array<non-empty-string, non-empty-string> */
    private array $headers = [];

    /** @var array<non-empty-string, HeaderInterface> */
    private array $filteredHeaders = [];

    /** @throws void */
    public function __construct(MessageInterface $message, private readonly HeaderLoaderInterface $headerLoader)
    {
        foreach (array_keys($message->getHeaders()) as $header) {
            if (!is_string($header) || $header === '') {
                continue;
            }

            $headerLine = $message->getHeaderLine($header);

            if ($headerLine === '') {
                continue;
            }

            $header = mb_strtolower($header);

            if (str_starts_with($header, 'http-') || str_starts_with($header, 'http_')) {
                $header = mb_substr($header, 5);
            }

            if ($header === '') {
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
    #[Override]
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array<non-empty-string, HeaderInterface>
     *
     * @throws void
     */
    #[Override]
    public function getFilteredHeaders(): array
    {
        return $this->filteredHeaders;
    }

    /** @throws void */
    #[Override]
    public function getHash(): string
    {
        $data = [];

        foreach ($this->filteredHeaders as $name => $header) {
            $data[$name] = $header->getValue();
        }

        return sha1(serialize($data));
    }

    /** @throws void */
    private function filterHeaders(): void
    {
        $headers  = $this->headers;
        $filtered = array_filter(
            self::HEADERS,
            static fn (string $value): bool => array_key_exists(mb_strtolower($value), $headers),
        );

        foreach ($filtered as $header) {
            try {
                $headerObj = $this->headerLoader->load($header, $headers[mb_strtolower($header)]);
            } catch (NotFoundException) {
                continue;
            }

            $this->filteredHeaders[$header] = $headerObj;
        }
    }
}
