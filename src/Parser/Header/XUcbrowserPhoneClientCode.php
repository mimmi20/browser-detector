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

namespace BrowserDetector\Parser\Header;

use Override;
use UaParser\ClientCodeInterface;

final class XUcbrowserPhoneClientCode implements ClientCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasClientCode(string $value): bool
    {
        return $value === 'maui browser';
    }

    /** @throws void */
    #[Override]
    public function getClientCode(string $value): string | null
    {
        return $value === 'maui browser' ? 'maui browser' : null;
    }
}
