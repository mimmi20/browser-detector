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

interface BrowserLoaderInterface extends SpecificLoaderInterface
{
    /**
     * @return array{0: array{name: string|null, version: string|null, manufacturer: string, type: string, isbot: bool}, 1: string|null}
     *
     * @throws NotFoundException
     */
    public function load(string $key, string $useragent = ''): array;
}
