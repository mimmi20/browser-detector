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

namespace BrowserDetector\Version;

use UnexpectedValueException;

final class ErrorVersionCreator implements VersionFactoryInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        return new class () implements VersionInterface {
            /**
             * returns the detected version
             *
             * @throws UnexpectedValueException
             */
            public function getVersion(int $mode = VersionInterface::COMPLETE): string | null
            {
                throw new UnexpectedValueException((string) $mode);
            }

            /**
             * @return array<string, string|null>
             *
             * @throws void
             */
            public function toArray(): array
            {
                return [];
            }

            /** @throws void */
            public function getMajor(): string | null
            {
                return null;
            }

            /** @throws void */
            public function getMinor(): string | null
            {
                return null;
            }

            /** @throws void */
            public function getMicro(): string | null
            {
                return null;
            }

            /** @throws void */
            public function getPatch(): string | null
            {
                return null;
            }

            /** @throws void */
            public function getMicropatch(): string | null
            {
                return null;
            }

            /** @throws void */
            public function getBuild(): string | null
            {
                return null;
            }

            /** @throws void */
            public function getStability(): string | null
            {
                return null;
            }

            /** @throws void */
            public function isAlpha(): bool | null
            {
                return false;
            }

            /** @throws void */
            public function isBeta(): bool | null
            {
                return false;
            }
        };
    }
}
