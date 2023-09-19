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

interface HeaderInterface
{
    /**
     * Retrieve header value
     *
     * @throws void
     */
    public function getValue(): string;

    /**
     * Retrieve normalized header value
     *
     * @throws void
     */
    public function getNormalizedValue(): string;

    /** @throws void */
    public function hasDeviceArchitecture(): bool;

    /** @throws void */
    public function getDeviceArchitecture(): string | null;

    /** @throws void */
    public function hasDeviceBitness(): bool;

    /** @throws void */
    public function getDeviceBitness(): int | null;

    /** @throws void */
    public function hasDeviceIsMobile(): bool;

    /** @throws void */
    public function getDeviceIsMobile(): bool | null;

    /** @throws void */
    public function hasDeviceCode(): bool;

    /** @throws void */
    public function getDeviceCode(): string | null;

    /** @throws void */
    public function hasClientCode(): bool;

    /** @throws void */
    public function getClientCode(): string | null;

    /** @throws void */
    public function hasClientVersion(): bool;

    /** @throws void */
    public function getClientVersion(string | null $code = null): string | null;

    /** @throws void */
    public function hasPlatformCode(): bool;

    /** @throws void */
    public function getPlatformCode(): string | null;

    /** @throws void */
    public function hasPlatformVersion(): bool;

    /** @throws void */
    public function getPlatformVersion(string | null $code = null): string | null;

    /** @throws void */
    public function hasEngineCode(): bool;

    /** @throws void */
    public function getEngineCode(): string | null;

    /** @throws void */
    public function hasEngineVersion(): bool;

    /** @throws void */
    public function getEngineVersion(string | null $code = null): string | null;
}
