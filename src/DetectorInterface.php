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

namespace BrowserDetector;

use BrowserDetector\Version\Exception\NotNumericException;
use Psr\Http\Message\MessageInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UnexpectedValueException;

interface DetectorInterface
{
    /**
     * Gets the information about the browser by User Agent
     *
     * @param array<non-empty-string, non-empty-string>|GenericRequestInterface|MessageInterface|string $headers
     *
     * @return array<mixed>
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NotNumericException
     */
    public function getBrowser(array | GenericRequestInterface | MessageInterface | string $headers): array;
}
