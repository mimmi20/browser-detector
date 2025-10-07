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

namespace BrowserDetector\Parser\Header;

use Override;
use UaLoader\BrowserLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\BrowserParserInterface;
use UaParser\ClientVersionInterface;
use UnexpectedValueException;

use function preg_match;

final readonly class UseragentClientVersion implements ClientVersionInterface
{
    /** @throws void */
    public function __construct(
        private BrowserParserInterface $browserParser,
        private BrowserLoaderInterface $browserLoader,
        private NormalizerInterface $normalizer,
    ) {
        // nothing to do
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function hasClientVersion(string $value): bool
    {
        return true;
    }

    /** @throws void */
    #[Override]
    public function getClientVersion(string $value, string | null $code = null): string | null
    {
        try {
            $normalizedValue = $this->normalizer->normalize($value);
        } catch (Exception) {
            return null;
        }

        if ($normalizedValue === '' || $normalizedValue === null) {
            return null;
        }

        $matches = [];

        if (preg_match('/pr\([^\/]+\/(?P<version>[\d.]+)\);/', $normalizedValue, $matches)) {
            return $matches['version'];
        }

        if (
            preg_match(
                '/instagram (?P<version>[\d.]+) android \([\d.]+\/[\d.]+; \d+dpi; \d+x\d+; [a-z\/]+; [^);\/]+;/i',
                $normalizedValue,
                $matches,
            )
        ) {
            return $matches['version'];
        }

        if ($code === null) {
            try {
                $code = $this->browserParser->parse($normalizedValue);

                if ($code === '') {
                    return null;
                }
            } catch (UnexpectedValueException) {
                return null;
            }
        }

        try {
            $clientData = $this->browserLoader->load($code, $normalizedValue);
        } catch (NotFoundException) {
            return null;
        }

        try {
            $version = $clientData->getClient()->getVersion()->getVersion();
        } catch (UnexpectedValueException) {
            return null;
        }

        if ($version === '') {
            return null;
        }

        return $version;
    }
}
