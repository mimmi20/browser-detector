<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Header;

use Override;

final class SecChUaMobile implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    #[Override]
    public function hasDeviceIsMobile(): bool
    {
        return true;
    }

    /** @throws void */
    #[Override]
    public function getDeviceIsMobile(): bool
    {
        return $this->value === '1' || $this->value === '?1' || $this->value === '"?1"';
    }
}
