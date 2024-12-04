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

use Psr\Http\Message\MessageInterface;
use UnexpectedValueException;

interface RequestBuilderInterface
{
    /**
     * @param array<non-empty-string, non-empty-string>|GenericRequestInterface|MessageInterface|string $request
     *
     * @throws UnexpectedValueException
     */
    public function buildRequest(
        array | GenericRequestInterface | MessageInterface | string $request,
    ): GenericRequestInterface;
}
