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

namespace BrowserDetector\Parser\Device;

use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\DeviceParserInterface;
use UnexpectedValueException;

interface DesktopParserInterface extends DeviceParserInterface
{
    /**
     * Gets the information about the browser by User Agent
     *
     * @throws void
     */
    public function parse(string $useragent): string;

    /**
     * @return array<int, (array<mixed>|string|null)>
     * @phpstan-return array{0:array{deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, dualOrientation: bool|null, simCount: int|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, type: string}, 1:string|null}
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $company, string $key): array;
}
