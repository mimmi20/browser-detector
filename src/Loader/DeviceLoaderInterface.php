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

use Override;

interface DeviceLoaderInterface extends SpecificLoaderInterface
{
    /**
     * @return array<int, (array<mixed>|string|null)>
     * @phpstan-return array{0: array{deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, dualOrientation: bool|null, simCount: int|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, type: string, ismobile: bool, istv: bool}, 1: string|null}
     *
     * @throws NotFoundException
     */
    #[Override]
    public function load(string $key): array;
}
