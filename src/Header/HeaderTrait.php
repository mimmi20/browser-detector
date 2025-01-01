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

namespace BrowserDetector\Header;

use Override;

// @phpcs:disable SlevomatCodingStandard.Classes.RequireConstructorPropertyPromotion.RequiredConstructorPropertyPromotion
trait HeaderTrait
{
    private string $value;

    /** @throws void */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Retrieve header value
     *
     * @throws void
     */
    #[Override]
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Retrieve normalized header value
     *
     * @throws void
     */
    #[Override]
    public function getNormalizedValue(): string
    {
        return $this->value;
    }

    /** @throws void */
    #[Override]
    public function hasDeviceArchitecture(): bool
    {
        return false;
    }

    /** @throws void */
    #[Override]
    public function getDeviceArchitecture(): string | null
    {
        return null;
    }

    /** @throws void */
    #[Override]
    public function hasDeviceBitness(): bool
    {
        return false;
    }

    /** @throws void */
    #[Override]
    public function getDeviceBitness(): int | null
    {
        return null;
    }

    /** @throws void */
    #[Override]
    public function hasDeviceIsMobile(): bool
    {
        return false;
    }

    /** @throws void */
    #[Override]
    public function getDeviceIsMobile(): bool | null
    {
        return null;
    }

    /** @throws void */
    #[Override]
    public function hasDeviceCode(): bool
    {
        return false;
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(): string | null
    {
        return null;
    }

    /** @throws void */
    #[Override]
    public function hasClientCode(): bool
    {
        return false;
    }

    /** @throws void */
    #[Override]
    public function getClientCode(): string | null
    {
        return null;
    }

    /** @throws void */
    #[Override]
    public function hasClientVersion(): bool
    {
        return false;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getClientVersion(string | null $code = null): string | null
    {
        return null;
    }

    /** @throws void */
    #[Override]
    public function hasPlatformCode(): bool
    {
        return false;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformCode(string | null $derivate = null): string | null
    {
        return null;
    }

    /** @throws void */
    #[Override]
    public function hasPlatformVersion(): bool
    {
        return false;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformVersion(string | null $code = null): string | null
    {
        return null;
    }

    /** @throws void */
    #[Override]
    public function hasEngineCode(): bool
    {
        return false;
    }

    /** @throws void */
    #[Override]
    public function getEngineCode(): string | null
    {
        return null;
    }

    /** @throws void */
    #[Override]
    public function hasEngineVersion(): bool
    {
        return false;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getEngineVersion(string | null $code = null): string | null
    {
        return null;
    }
}
