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

use UnexpectedValueException;

interface BrowserLoaderInterface extends SpecificLoaderInterface
{
    /**
     * @return array{0: array{name: string|null, modus: string|null, version: string|null, manufacturer: string, bits: int|null, type: string}, 1: string|null}
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): array;
}
