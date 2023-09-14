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

namespace BrowserDetector\Header;

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
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Retrieve normalized header value
     *
     * @throws void
     */
    public function getNormalizedValue(): string
    {
        return $this->value;
    }

    /** @throws void */
    public function hasDeviceArchitecture(): bool
    {
        return false;
    }

    /** @throws void */
    public function getDeviceArchitecture(): string | null
    {
        return null;
    }

    /** @throws void */
    public function hasDeviceBitness(): bool
    {
        return false;
    }

    /** @throws void */
    public function getDeviceBitness(): string | null
    {
        return null;
    }

    /** @throws void */
    public function hasDeviceIsMobile(): bool
    {
        return false;
    }

    /** @throws void */
    public function getDeviceIsMobile(): bool | null
    {
        return null;
    }

    /** @throws void */
    public function hasDeviceName(): bool
    {
        return false;
    }

    /** @throws void */
    public function getDeviceName(): string | null
    {
        return null;
    }

    /** @throws void */
    public function hasDeviceCode(): bool
    {
        return false;
    }

    /** @throws void */
    public function getDeviceCode(): string | null
    {
        return null;
    }

    /** @throws void */
    public function hasClientCode(): bool
    {
        return false;
    }

    /** @throws void */
    public function getClientCode(): string | null
    {
        return null;
    }

    /** @throws void */
    public function hasClientVersion(): bool
    {
        return false;
    }

    /** @throws void */
    public function getClientVersion(): string | null
    {
        return null;
    }

    /** @throws void */
    public function hasPlatformCode(): bool
    {
        return false;
    }

    /** @throws void */
    public function getPlatformCode(): string | null
    {
        return null;
    }

    /** @throws void */
    public function hasPlatformVersion(): bool
    {
        return false;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getPlatformVersion(string | null $code = null): string | null
    {
        return null;
    }

    /** @throws void */
    public function hasEngineCode(): bool
    {
        return false;
    }

    /** @throws void */
    public function getEngineCode(): string | null
    {
        return null;
    }

    /** @throws void */
    public function hasEngineVersion(): bool
    {
        return false;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getEngineVersion(string | null $code = null): string | null
    {
        return null;
    }
}
