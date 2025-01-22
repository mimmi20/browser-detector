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

namespace BrowserDetector\Loader\InitData;

use stdClass;

use function array_change_key_case;
use function array_key_exists;
use function is_array;
use function is_bool;
use function is_float;
use function is_int;
use function is_string;

use const CASE_LOWER;

/** @phpcs:disable SlevomatCodingStandard.Classes.RequireConstructorPropertyPromotion.RequiredConstructorPropertyPromotion */
final class Device
{
    private string | null $deviceName    = null;
    private string | null $marketingName = null;
    private string | null $manufacturer  = null;
    private string | null $brand         = null;
    private string | null $type          = null;
    private bool | null $dualOrientation = null;
    private int | null $simCount         = null;
    private string | null $platform      = null;

    /** @var array{width: int|null, height: int|null, touch: bool|null, size: float|null} */
    private array $display = ['width' => null, 'height' => null, 'touch' => null, 'size' => null];

    /**
     * @param array{width: int|null, height: int|null, touch: bool|null, size: float|null} $display
     *
     * @throws void
     */
    public function __construct(
        string | null $deviceName,
        string | null $marketingName,
        string | null $manufacturer,
        string | null $brand,
        string | null $type,
        array $display,
        bool | null $dualOrientation,
        int | null $simCount,
        string | null $platform,
    ) {
        $this->deviceName      = $deviceName;
        $this->marketingName   = $marketingName;
        $this->manufacturer    = $manufacturer;
        $this->brand           = $brand;
        $this->type            = $type;
        $this->display         = $display;
        $this->dualOrientation = $dualOrientation;
        $this->simCount        = $simCount;
        $this->platform        = $platform;
    }

    /**
     * @param stdClass $data
     * @phpstan-param array{deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, type: string|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, dualOrientation: bool|null, simCount: int|null, platform: string|null} $data
     *
     * @throws void
     */
    public function __unserialize(array $data): void
    {
        $this->exchangeArray($data);
    }

    /**
     * @return array{deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, type: string|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, dualOrientation: bool|null, simCount: int|null, platform: string|null}
     *
     * @throws void
     */
    public function __serialize(): array
    {
        return $this->getArrayCopy();
    }

    /** @throws void */
    public function getDeviceName(): string | null
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
    public function getType(): string | null
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
    public function getPlatform(): string | null
    {
        return $this->platform;
    }

    /**
     * @return array{deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, type: string|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, dualOrientation: bool|null, simCount: int|null, platform: string|null}
     *
     * @throws void
     *
     * @api
     */
    public function getArrayCopy(): array
    {
        return [
            'deviceName' => $this->deviceName,
            'marketingName' => $this->marketingName,
            'manufacturer' => $this->manufacturer,
            'brand' => $this->brand,
            'type' => $this->type,
            'display' => $this->display,
            'dualOrientation' => $this->dualOrientation,
            'simCount' => $this->simCount,
            'platform' => $this->platform,
        ];
    }

    /**
     * @param stdClass $data
     * @phpstan-param array{deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, type: string|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, dualOrientation: bool|null, simCount: int|null, platform: string|null} $data
     *
     * @throws void
     *
     * @api
     */
    public function exchangeArray(array $data): void
    {
        $data = array_change_key_case($data, CASE_LOWER);

        $deviceName = null;

        if (array_key_exists('devicename', $data) && is_string($data['devicename'])) {
            $deviceName = $data['devicename'];
        }

        $marketingName = null;

        if (array_key_exists('marketingname', $data) && is_string($data['marketingname'])) {
            $marketingName = $data['marketingname'];
        }

        $manufacturer = null;

        if (array_key_exists('manufacturer', $data) && is_string($data['manufacturer'])) {
            $manufacturer = $data['manufacturer'];
        }

        $brand = null;

        if (array_key_exists('brand', $data) && is_string($data['brand'])) {
            $brand = $data['brand'];
        }

        $type = null;

        if (array_key_exists('type', $data) && is_string($data['type'])) {
            $type = $data['type'];
        }

        $dualOrientation = null;

        if (array_key_exists('dualorientation', $data) && is_bool($data['dualorientation'])) {
            $dualOrientation = $data['dualorientation'];
        }

        $simCount = null;

        if (array_key_exists('simcount', $data) && is_int($data['simcount'])) {
            $simCount = $data['simcount'];
        }

        $platform = null;

        if (array_key_exists('platform', $data) && is_string($data['platform'])) {
            $platform = $data['platform'];
        }

        $display = ['width' => null, 'height' => null, 'touch' => null, 'size' => null];

        if (array_key_exists('display', $data) && is_array($data['display'])) {
            $displayData = array_change_key_case($data['display'], CASE_LOWER);

            if (array_key_exists('width', $displayData) && is_int($displayData['width'])) {
                $display['width'] = $displayData['width'];
            }

            if (array_key_exists('height', $displayData) && is_int($displayData['height'])) {
                $display['height'] = $displayData['height'];
            }

            if (array_key_exists('touch', $displayData) && is_bool($displayData['touch'])) {
                $display['touch'] = $displayData['touch'];
            }

            if (
                array_key_exists('size', $displayData)
                && (
                    is_int($displayData['size'])
                    || is_float($displayData['size'])
                )
            ) {
                $display['size'] = (float) $displayData['size'];
            }
        }

        $this->deviceName      = $deviceName;
        $this->marketingName   = $marketingName;
        $this->manufacturer    = $manufacturer;
        $this->brand           = $brand;
        $this->type            = $type;
        $this->display         = $display;
        $this->dualOrientation = $dualOrientation;
        $this->simCount        = $simCount;
        $this->platform        = $platform;
    }
}
