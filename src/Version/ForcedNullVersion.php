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

use Override;

final class ForcedNullVersion implements VersionInterface
{
    /**
     * @return array<string, string|null>
     *
     * @throws void
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'major' => null,
            'minor' => null,
            'micro' => null,
            'patch' => null,
            'micropatch' => null,
            'stability' => null,
            'build' => null,
        ];
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
        return null;
    }

    /** @throws void */
    #[Override]
    public function isBeta(): bool | null
    {
        return null;
    }

    /**
     * returns the detected version
     *
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getVersion(int $mode = VersionInterface::COMPLETE): string | null
    {
        return null;
    }
}
