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
use UaLoader\Exception\NotFoundException;
use UaLoader\PlatformLoaderInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\PlatformParserInterface;
use UaParser\PlatformVersionInterface;
use UnexpectedValueException;

use function preg_match;
use function str_replace;

final readonly class UseragentPlatformVersion implements PlatformVersionInterface
{
    /** @throws void */
    public function __construct(
        private PlatformParserInterface $platformParser,
        private PlatformLoaderInterface $platformLoader,
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
    public function hasPlatformVersion(string $value): bool
    {
        return true;
    }

    /** @throws void */
    #[Override]
    public function getPlatformVersion(string $value, string | null $code = null): string | null
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
            $version = $platform->getVersion()->getVersion();
        } catch (UnexpectedValueException) {
            return null;
        }

        if ($version === '') {
            return null;
        }

        return $version;
    }
}
