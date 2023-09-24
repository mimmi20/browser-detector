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

namespace BrowserDetector\Loader;

interface PlatformLoaderInterface
{
    /**
     * @return array{name: string|null, marketingName: string|null, version: string|null, manufacturer: string}
     *
     * @throws NotFoundException
     */
    public function load(string $key, string $useragent = ''): array;
}
