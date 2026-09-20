<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader\InitData;

use UaDeviceType\Type;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;

/** @phpcs:disable SlevomatCodingStandard.Classes.RequireConstructorPropertyPromotion.RequiredConstructorPropertyPromotion */
final class Device
{
    private Architecture $architecture      = Architecture::unknown;
    private int | string | null $deviceName = null;
    private string | null $marketingName    = null;
    private string | null $manufacturer     = null;
    private string | null $brand            = null;
    private Type | null $type               = null;
    private bool | null $dualOrientation    = null;
    private int | null $simCount            = null;
    private string | null $platform         = null;
    private Bits $bits                      = Bits::unknown;

    /** @var array{width: int|null, height: int|null, touch: bool|null, size: float|null} */
    private array $display = ['width' => null, 'height' => null, 'touch' => null, 'size' => null];

    /**
     * @param array{width: int|null, height: int|null, touch: bool|null, size: float|null} $display
     *
     * @throws void
     */
    public function __construct(
        Architecture $architecture,
        int | string | null $deviceName,
        string | null $marketingName,
        string | null $manufacturer,
        string | null $brand,
        Type | null $type,
        array $display,
        bool | null $dualOrientation,
        int | null $simCount,
        Bits $bits,
        string | null $platform,
    ) {
        $this->architecture    = $architecture;
        $this->deviceName      = $deviceName;
        $this->marketingName   = $marketingName;
        $this->manufacturer    = $manufacturer;
        $this->brand           = $brand;
        $this->type            = $type;
        $this->display         = $display;
        $this->dualOrientation = $dualOrientation;
        $this->simCount        = $simCount;
        $this->bits            = $bits;
        $this->platform        = $platform;
    }

    /** @throws void */
    public function getArchitecture(): Architecture
    {
        return $this->architecture;
    }

    /** @throws void */
    public function getDeviceName(): int | string | null
    {
        return $this->deviceName;
    }

    /** @throws void */
    public function getMarketingName(): string | null
    {
        return $this->marketingName;
    }

    /** @throws void */
    public function getManufacturer(): string | null
    {
        return $this->manufacturer;
    }

    /** @throws void */
    public function getBrand(): string | null
    {
        return $this->brand;
    }

    /** @throws void */
    public function getType(): Type | null
    {
        return $this->type;
    }

    /**
     * @return array{width: int|null, height: int|null, touch: bool|null, size: float|null}
     *
     * @throws void
     */
    public function getDisplay(): array
    {
        return $this->display;
    }

    /** @throws void */
    public function getDualOrientation(): bool | null
    {
        return $this->dualOrientation;
    }

    /** @throws void */
    public function getSimCount(): int | null
    {
        return $this->simCount;
    }

    /** @throws void */
    public function getBits(): Bits
    {
        return $this->bits;
    }

    /** @throws void */
    public function getPlatform(): string | null
    {
        return $this->platform;
    }
}
