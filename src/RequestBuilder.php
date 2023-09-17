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

use BrowserDetector\Header\HeaderLoader;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use Laminas\Diactoros\HeaderSecurity;
use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\MessageInterface;
use UaNormalizer\NormalizerFactory;

use function array_change_key_case;
use function array_filter;
use function is_array;
use function is_string;
use function preg_replace;
use function str_starts_with;

use const ARRAY_FILTER_USE_BOTH;
use const CASE_UPPER;

final class RequestBuilder implements RequestBuilderInterface
{
    /** @throws void */
    public function __construct(
        private readonly DeviceParserInterface $deviceParser,
        private readonly PlatformParserInterface $platformParser,
        private readonly BrowserParserInterface $browserParser,
        private readonly EngineParserInterface $engineParser,
        private readonly NormalizerFactory $normalizerFactory,
    ) {
        // nothing to do
    }

    /**
     * @param array<non-empty-string, non-empty-string>|GenericRequestInterface|MessageInterface|string $request
     *
     * @throws void
     */
    public function buildRequest(
        array | GenericRequestInterface | MessageInterface | string $request,
    ): GenericRequestInterface {
        if ($request instanceof GenericRequestInterface) {
            return $request;
        }

        if ($request instanceof MessageInterface) {
            return $this->createRequestFromPsr7Message($request);
        }

        if (is_array($request)) {
            return $this->createRequestFromArray($request);
        }

        return $this->createRequestFromString($request);
    }

    /**
     * Create a Generic Request from the given $userAgent
     *
     * @throws void
     */
    private function createRequestFromString(string $userAgent): GenericRequest
    {
        return $this->createRequestFromArray([Constants::HEADER_HTTP_USERAGENT => $userAgent]);
    }

    /**
     * Creates Generic Request from the given HTTP Request (normally $_SERVER).
     *
     * @param array<string, string> $inputHeaders HTTP Request
     *
     * @throws void
     */
    private function createRequestFromArray(array $inputHeaders): GenericRequest
    {
        $filteredHeaders = array_filter(
            $inputHeaders,
            static function ($value, $key): bool {
                if (!is_string($key)) {
                    return false;
                }

                return $value !== '';
            },
            ARRAY_FILTER_USE_BOTH,
        );

        $headers = [];

        foreach (array_change_key_case($filteredHeaders, CASE_UPPER) as $upperCaseHeader => $value) {
            if (!str_starts_with($upperCaseHeader, 'HTTP_')) {
                $upperCaseHeader = 'HTTP_' . $upperCaseHeader;
            }

            if (!HeaderSecurity::isValid($value)) {
                $value = $this->filterHeader($value);
            }

            $headers[$upperCaseHeader] = $value;
        }

        $message = ServerRequestFactory::fromGlobals($headers);

        return $this->createRequestFromPsr7Message($message);
    }

    /**
     * Create a Generic Request from a given PSR-7 HTTP message
     *
     * @throws void
     */
    private function createRequestFromPsr7Message(MessageInterface $message): GenericRequest
    {
        return new GenericRequest(
            $message,
            new HeaderLoader(
                $this->deviceParser,
                $this->platformParser,
                $this->browserParser,
                $this->engineParser,
                $this->normalizerFactory,
            ),
        );
    }

    /** @throws void */
    private function filterHeader(string $header): string
    {
        return (string) preg_replace(
            ["#(((?<!\r)\n)|(\r(?!\n))|(\r\n(?![ \t])))#", '/[^\x09\x0a\x0d\x20-\x7E\x80-\xFE]/'],
            '-',
            $header,
        );
    }
}
