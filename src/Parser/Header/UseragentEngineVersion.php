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
use UaLoader\EngineLoaderInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaNormalizer\NormalizerFactory;
use UaParser\EngineParserInterface;
use UaParser\EngineVersionInterface;
use UnexpectedValueException;

use function preg_match;

final class UseragentEngineVersion implements EngineVersionInterface
{
    private readonly NormalizerInterface $normalizer;

    /** @throws Exception */
    public function __construct(
        private readonly EngineParserInterface $engineParser,
        private readonly EngineLoaderInterface $engineLoader,
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
    public function hasEngineVersion(string $value): bool
    {
        return true;
    }

    /** @throws void */
    #[Override]
    public function getEngineVersion(string $value, string | null $code = null): string | null
    {
        $normalizedValue = $this->normalizer->normalize($value);

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
            return $engine->getVersion()->getVersion();
        } catch (UnexpectedValueException) {
            return null;
        }
    }
}
