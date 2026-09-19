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
}
