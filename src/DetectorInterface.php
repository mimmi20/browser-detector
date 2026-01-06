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

namespace BrowserDetector;

use BrowserDetector\Version\Exception\NotNumericException;
use Psr\Http\Message\MessageInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaRequest\GenericRequestInterface;
use UnexpectedValueException;

interface DetectorInterface
{
    /**
     * Gets the information about the browser by User Agent
     *
     * @param array<non-empty-string, non-empty-string>|GenericRequestInterface|MessageInterface|string $headers
     *
     * @return array<mixed>
     * @phpstan-return array{headers: array<non-empty-string, string>, device: array{architecture: string|null, deviceName: string|null, marketingName: string|null, manufacturer: string|null, brand: string|null, dualOrientation: bool|null, simCount: int|null, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, type: string|null, ismobile: bool, istv: bool, bits: int|null}, os: array{name: string|null, marketingName: string|null, version: string|null, manufacturer: string|null}, client: array{name: string|null, version: string|null, manufacturer: string|null, type: string|null, isbot: bool}, engine: array{name: string|null, version: string|null, manufacturer: string|null}}
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NotNumericException
     */
    public function getBrowser(array | GenericRequestInterface | MessageInterface | string $headers): array;
}
