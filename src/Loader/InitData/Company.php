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
}
