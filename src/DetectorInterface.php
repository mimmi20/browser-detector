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
     * @return array{headers: array<string, string>, device: array{architecture: string, deviceName: string|null, marketingName: string|null, manufacturer: string, brand: string, type: string, ismobile: bool, istv: bool, display: array{width: int|null, height: int|null, touch: bool|null, size: float|null}, dualOrientation: bool|null, simCount: int|null, bits: int}, client: array{name: string|null, modus: string|null, version: string|null, manufacturer: string, type: string, isbot: bool, bits: int}, os: array{name: string|null, marketingName: string|null, version: string|null, manufacturer: string, bits: int}, engine: array{name: string|null, version: string|null, manufacturer: string}}
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NotNumericException
     */
    public function getBrowser(array | GenericRequestInterface | MessageInterface | string $headers): array;
}
