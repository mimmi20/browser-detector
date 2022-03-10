<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector;

use Psr\Http\Message\MessageInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaRequest\GenericRequest;
use UaResult\Result\ResultInterface;
use UnexpectedValueException;

interface DetectorInterface
{
    /**
     * Gets the information about the browser by User Agent
     *
     * @param array<string, string>|GenericRequest|MessageInterface|string $headers
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function __invoke($headers): ResultInterface;
}
