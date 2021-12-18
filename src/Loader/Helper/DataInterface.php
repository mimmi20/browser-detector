<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader\Helper;

use Countable;
use RuntimeException;

interface DataInterface extends Countable
{
    /**
     * @throws RuntimeException
     */
    public function __invoke(): void;

    public function getItem(string $cacheId): mixed;

    public function hasItem(string $cacheId): bool;
}
