<?php

/**
 * This file is part of the mimmi20/ua-generic-request package.
 *
 * Copyright (c) 2015-2025, Thomas Mueller <mimmi20@live.de>
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
use UaNormalizer\NormalizerFactory;
use UaParser\BrowserParserInterface;
use UaParser\ClientVersionInterface;
use UnexpectedValueException;

use function preg_match;

final class UseragentClientVersion implements ClientVersionInterface
{
    private readonly NormalizerInterface $normalizer;

    /** @throws Exception */
    public function __construct(
        private readonly BrowserParserInterface $browserParser,
        private readonly BrowserLoaderInterface $browserLoader,
        NormalizerFactory $normalizerFactory,
    ) {
        $this->normalizer = $normalizerFactory->build();
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
        $normalizedValue = $this->normalizer->normalize($value);

        $matches = [];

        if (preg_match('/pr\([^\/]+\/(?P<version>[\d.]+)\);/', $normalizedValue, $matches)) {
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
            return $clientData->getClient()->getVersion()->getVersion();
        } catch (UnexpectedValueException) {
            return null;
        }
    }
}
