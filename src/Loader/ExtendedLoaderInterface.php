<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader;

/**
 * Browser detection class
 */
interface ExtendedLoaderInterface
{
    /** @throws NotFoundException */
    public function load(string $browserKey, string $useragent = ''): mixed;

    /** @throws void */
    public function has(string $key): bool;
}
