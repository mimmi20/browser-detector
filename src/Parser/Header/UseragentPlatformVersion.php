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
use UaLoader\Exception\NotFoundException;
use UaLoader\PlatformLoaderInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaNormalizer\NormalizerFactory;
use UaParser\PlatformParserInterface;
use UaParser\PlatformVersionInterface;
use UnexpectedValueException;

use function preg_match;
use function str_replace;

final class UseragentPlatformVersion implements PlatformVersionInterface
{
    private readonly NormalizerInterface $normalizer;

    /** @throws Exception */
    public function __construct(
        private readonly PlatformParserInterface $platformParser,
        private readonly PlatformLoaderInterface $platformLoader,
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
    public function hasPlatformVersion(string $value): bool
    {
        return true;
    }

    /** @throws void */
    #[Override]
    public function getPlatformVersion(string $value, string | null $code = null): string | null
    {
        $normalizedValue = $this->normalizer->normalize($value);

        $matches = [];

        if (
            preg_match('/ov\((?:(wds|android) )?(?P<version>[\d_.]+)\);/i', $normalizedValue, $matches)
        ) {
            return str_replace('_', '.', $matches['version']);
        }

        if ($code === null) {
            $code = $this->platformParser->parse($normalizedValue);

            if ($code === '') {
                return null;
            }
        }

        try {
            $platform = $this->platformLoader->load($code, $normalizedValue);
        } catch (NotFoundException) {
            return null;
        }

        try {
            return $platform->getVersion()->getVersion();
        } catch (UnexpectedValueException) {
            return null;
        }
    }
}
