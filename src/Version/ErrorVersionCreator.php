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

namespace BrowserDetector\Version;

use JsonException;
use Override;
use UnexpectedValueException;

use function json_encode;

use const JSON_THROW_ON_ERROR;

final class ErrorVersionCreator implements VersionBuilderInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @param array<int, bool|string|null> $searches
     *
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function detectVersion(string $useragent, array $searches = []): VersionInterface
    {
        return new readonly class ($searches) implements VersionInterface {
            /**
             * @param array<int, bool|string|null> $searches
             *
             * @throws void
             */
            public function __construct(private array $searches)
            {
                // nothing to do
            }

            /**
             * returns the detected version
             *
             * @throws UnexpectedValueException
             * @throws JsonException
             */
            #[Override]
            public function getVersion(int $mode = VersionInterface::COMPLETE): string | null
            {
                throw new UnexpectedValueException(
                    $mode . '::' . json_encode($this->searches, JSON_THROW_ON_ERROR),
                );
            }

            /**
             * @return array<string, string|null>
             *
             * @throws void
             */
            #[Override]
            public function toArray(): array
            {
                return [];
            }

            /** @throws void */
            #[Override]
            public function getMajor(): string | null
            {
                return null;
            }

            /** @throws void */
            #[Override]
            public function getMinor(): string | null
            {
                return null;
            }

            /** @throws void */
            #[Override]
            public function getMicro(): string | null
            {
                return null;
            }

            /** @throws void */
            #[Override]
            public function getPatch(): string | null
            {
                return null;
            }

            /** @throws void */
            #[Override]
            public function getMicropatch(): string | null
            {
                return null;
            }

            /** @throws void */
            #[Override]
            public function getBuild(): string | null
            {
                return null;
            }

            /** @throws void */
            #[Override]
            public function getStability(): string | null
            {
                return null;
            }

            /** @throws void */
            #[Override]
            public function isAlpha(): bool | null
            {
                return false;
            }

            /** @throws void */
            #[Override]
            public function isBeta(): bool | null
            {
                return false;
            }
        };
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function setRegex(string $regex): void
    {
        // do nothing here
    }

    /**
     * sets the detected version
     *
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function set(string $version): VersionInterface
    {
        return new NullVersion();
    }

    /**
     * @param array<string, string|null> $data
     *
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public static function fromArray(array $data): VersionInterface
    {
        return new NullVersion();
    }
}
