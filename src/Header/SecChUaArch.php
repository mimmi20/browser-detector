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

namespace BrowserDetector\Header;

use function trim;

final class SecChUaArch implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function hasDeviceArchitecture(): bool
    {
        return true;
    }

    /** @throws void */
    public function getDeviceArchitecture(): string | null
    {
        $value = trim($this->value, '"');

        if ($value === '') {
            return null;
        }

        return $value;
    }
}
