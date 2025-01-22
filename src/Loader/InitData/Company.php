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
use function is_string;

use const CASE_LOWER;

/** @phpcs:disable SlevomatCodingStandard.Classes.RequireConstructorPropertyPromotion.RequiredConstructorPropertyPromotion */
final class Company
{
    private string | null $name      = null;
    private string | null $brandname = null;

    /** @throws void */
    public function __construct(string | null $name, string | null $brandname)
    {
        $this->name      = $name;
        $this->brandname = $brandname;
    }

    /**
     * @param stdClass $data
     * @phpstan-param array{name: string|null, brandname: string|null} $data
     *
     * @throws void
     */
    public function __unserialize(array $data): void
    {
        $this->exchangeArray($data);
    }

    /**
     * @return array{name: string|null, brandname: string|null}
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
    public function getBrandname(): string | null
    {
        return $this->brandname;
    }

    /**
     * @return array{name: string|null, brandname: string|null}
     *
     * @throws void
     *
     * @api
     */
    public function getArrayCopy(): array
    {
        return [
            'name' => $this->name,
            'brandname' => $this->brandname,
        ];
    }

    /**
     * @param array{name: string|null, brandname: string|null} $data
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

        $brandname = null;

        if (array_key_exists('brandname', $data) && is_string($data['brandname'])) {
            $brandname = $data['brandname'];
        }

        $this->name      = $name;
        $this->brandname = $brandname;
    }
}
