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

namespace BrowserDetector\Parser\Header\Exception;

use UnexpectedValueException;

final class VersionContainsDerivateException extends UnexpectedValueException
{
    private string $derivate = '';

    /** @throws void */
    public function getDerivate(): string
    {
        return $this->derivate;
    }

    /** @throws void */
    public function setDerivate(string $derivate): void
    {
        $this->derivate = $derivate;
    }
}
