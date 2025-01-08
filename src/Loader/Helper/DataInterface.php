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

namespace BrowserDetector\Loader\Helper;

use Countable;
use RuntimeException;
use stdClass;

interface DataInterface extends Countable
{
    /** @throws RuntimeException */
    public function __invoke(): void;

    /** @throws void */
    public function getItem(string $stringKey): stdClass | null;

    /** @throws void */
    public function hasItem(string $stringKey): bool;
}
