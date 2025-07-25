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
use UaLoader\EngineLoaderInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\EngineParserInterface;
use UaParser\EngineVersionInterface;
use UnexpectedValueException;

use function preg_match;

final readonly class UseragentEngineVersion implements EngineVersionInterface
{
    /** @throws void */
    public function __construct(
        private EngineParserInterface $engineParser,
        private EngineLoaderInterface $engineLoader,
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
    public function hasEngineVersion(string $value): bool
    {
        return true;
    }

    /** @throws void */
    #[Override]
    public function getEngineVersion(string $value, string | null $code = null): string | null
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

        if (preg_match('/(?<!o)re\([^\/]+\/(?P<version>[\d.]+)/', $normalizedValue, $matches)) {
            return $matches['version'];
        }

        if ($code === null) {
            $code = $this->engineParser->parse($normalizedValue);

            if ($code === '') {
                return null;
            }
        }

        try {
            $engine = $this->engineLoader->load($code, $normalizedValue);
        } catch (UnexpectedValueException) {
            return null;
        }

        try {
            $version = $engine->getVersion()->getVersion();
        } catch (UnexpectedValueException) {
            return null;
        }

        if ($version === '') {
            return null;
        }

        return $version;
    }
}
