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

use stdClass;

use function array_change_key_case;
use function array_key_exists;
use function is_array;
use function is_string;

use const CASE_LOWER;

/** @phpcs:disable SlevomatCodingStandard.Classes.RequireConstructorPropertyPromotion.RequiredConstructorPropertyPromotion */
final class Client
{
    private string | null $name               = null;
    private string | null $manufacturer       = null;
    private string | stdClass | null $version = null;
    private string | null $type               = null;
    private string | null $engine             = null;

    /** @throws void */
    public function __construct(
        string | null $name,
        string | null $manufacturer,
        string | stdClass | null $version,
        string | null $type,
        string | null $engine,
    ) {
        $this->name         = $name;
        $this->manufacturer = $manufacturer;
        $this->version      = $version;
        $this->type         = $type;
        $this->engine       = $engine;
    }

    /**
     * @param array<string, array<mixed|string>|stdClass|string|null> $data
     * @phpstan-param array{name: string|null, manufacturer: string|null, version: string|array<string|mixed>|stdClass|null, type: string|null, engine: string|null} $data
     *
     * @throws void
     */
    public function __unserialize(array $data): void
    {
        $this->exchangeArray($data);
    }

    /**
     * @return array{name: string|null, manufacturer: string|null, version: stdClass|string|null, type: string|null, engine: string|null}
     *
     * @throws void
     */
    public function __serialize(): array
    {
        return $this->getArrayCopy();
    }

    /** @throws void */
    public function getName(): string | null
    {
        return $this->name;
    }

    /** @throws void */
    public function getManufacturer(): string | null
    {
        return $this->manufacturer;
    }

    /** @throws void */
    public function getVersion(): string | stdClass | null
    {
        return $this->version;
    }

    /** @throws void */
    public function getType(): string | null
    {
        return $this->type;
    }

    /** @throws void */
    public function getEngine(): string | null
    {
        return $this->engine;
    }

    /**
     * @return array{name: string|null, manufacturer: string|null, version: stdClass|string|null, type: string|null, engine: string|null}
     *
     * @throws void
     *
     * @api
     */
    public function getArrayCopy(): array
    {
        return [
            'name' => $this->name,
            'manufacturer' => $this->manufacturer,
            'version' => $this->version,
            'type' => $this->type,
            'engine' => $this->engine,
        ];
    }

    /**
     * @param array<string, array<mixed|string>|stdClass|string|null> $data
     * @phpstan-param array{name: string|null, manufacturer: string|null, version: string|array<string|mixed>|stdClass|null, type: string|null, engine: string|null} $data
     *
     * @throws void
     *
     * @api
     */
    public function exchangeArray(array $data): void
    {
        $data = array_change_key_case($data, CASE_LOWER);

        $name = null;

        if (array_key_exists('name', $data) && is_string($data['name'])) {
            $name = $data['name'];
        }

        $manufacturer = null;

        if (array_key_exists('manufacturer', $data) && is_string($data['manufacturer'])) {
            $manufacturer = $data['manufacturer'];
        }

        $type = null;

        if (array_key_exists('type', $data) && is_string($data['type'])) {
            $type = $data['type'];
        }

        $engine = null;

        if (array_key_exists('engine', $data) && is_string($data['engine'])) {
            $engine = $data['engine'];
        }

        $version = null;

        if (array_key_exists('version', $data)) {
            if (is_string($data['version']) || $data['version'] instanceof stdClass) {
                $version = $data['version'];
            } elseif (is_array($data['version'])) {
                $version = (object) $data['version'];
            }
        }

        $this->name         = $name;
        $this->manufacturer = $manufacturer;
        $this->version      = $version;
        $this->type         = $type;
        $this->engine       = $engine;
    }
}
